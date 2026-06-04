<?php
    include('db.php');

    if(isset($_POST['submit'])){
        // echo '<pre>';print_r($_POST);echo '</pre>';exit;
        $emp_nm =  $_POST['emp_nm'];
        $degn = $_POST['dsign'];
        $age = $_POST['age'];
        $qualif = $_POST['quali'];
        $pre_cmpy = $_POST['pre_cmpny'];
        $user_nm = $_POST['user'];
        $pass = $_POST['pass'];
        $conf_pass = $_POST['cpass'];

        // Login Time
        $li_hr = $_POST['li_hr'];
        $li_mn = $_POST['li_mn'];
        $li_ap = $_POST['li_ap'];

        // Logout Time
        $lo_hr = $_POST['lo_hr'];
        $lo_mn = $_POST['lo_mn'];
        $lo_ap = $_POST['lo_ap'];

        // Final formatted times
        $lg_in  = $li_hr . ":" . $li_mn . " " . $li_ap;
        $lg_out = $lo_hr . ":" . $lo_mn . " " . $lo_ap;

        // $target_dir = "uploads/";
        $filename = $_FILES["formFile"]["name"]; 
        $target_file = "uploads/" . basename($filename);

        $file_tmp = $_FILES['formFile']['tmp_name'];

        move_uploaded_file($file_tmp, $target_file);
        $sql =  "INSERT INTO emp_register(`ename`,`designation`,`age`,`qualifcation`,`prev_compny`,`login_time`,`logout_time`,`username`,`password`,`confirm_pass`,`attachment`)VALUES('$emp_nm','$degn','$age','$qualif','$pre_cmpy','$lg_in','$lg_out','$user_nm','$pass','$conf_pass','$filename') ";
        $sql_qry = mysqli_query($con,$sql);


        if($sql_qry){
           echo "<script> alert('data insert succesfully');window.location.href='show_rec.php';</script>";
        }else{
            echo '<script> alert("unsuccesssfully insert the record");</script>';
        }

    }
?>

<?php
    if(isset($_GET['id'])){
        $main_id = $_GET['id'];
        $data = mysqli_query($con,"SELECT * FROM emp_register WHERE id = '$main_id'");
        $fetch = mysqli_fetch_object($data);

        // ---------------- LOGIN TIME ----------------
        $login_time = $fetch->login_time;   // example: 06:30 AM
        $login_parts = explode(" ", $login_time);   // ["06:30", "AM"]
        $login_hm = explode(":", $login_parts[0]);  // ["06", "30"]

        $li_hour   = $login_hm[0];
        $li_minute = $login_hm[1];
        $li_ampm   = $login_parts[1];

        // ---------------- LOGOUT TIME ----------------
        $logout_time = $fetch->logout_time;   // example: 09:15 PM
        $logout_parts = explode(" ", $logout_time);   // ["09:15", "PM"]
        $logout_hm = explode(":", $logout_parts[0]);  // ["09", "15"]

        $lo_hour   = $logout_hm[0];
        $lo_minute = $logout_hm[1];
        $lo_ampm   = $logout_parts[1];
    }
?>
<?php
    if(isset($_POST['update'])){
        $main_id = $_GET['id'];
        $emp_nm =  $_POST['emp_nm'];
        $degn = $_POST['dsign'];
        $age = $_POST['age'];
        $qualif = $_POST['quali'];
        $pre_cmpy = $_POST['pre_cmpny'];
        // $lg_in = $_POST['lit'];
        // $lg_out = $_POST['lot'];
        $user_nm = $_POST['user'];
        $pass = $_POST['pass'];

        // Login Time
        $li_hr = $_POST['li_hr'];
        $li_mn = $_POST['li_mn'];
        $li_ap = $_POST['li_ap'];

        // Logout Time
        $lo_hr = $_POST['lo_hr'];
        $lo_mn = $_POST['lo_mn'];
        $lo_ap = $_POST['lo_ap'];

        // Final formatted times
        $lg_in  = $li_hr . ":" . $li_mn . " " . $li_ap;
        $lg_out = $lo_hr . ":" . $lo_mn . " " . $lo_ap;

        $filename = $_FILES['formFile']['name'];
        $tempname = $_FILES['formFile']['tmp_name'];
        $old_file = $fetch->attachment;

        if($tempname != ""){
            move_uploaded_file($tempname, "uploads/".$filename); 
        } else {
            $filename = $old_file;
        }
        $update_qry = mysqli_query($con, "UPDATE emp_register SET ename='$emp_nm',designation='$degn',age='$age',
        qualifcation='$qualif',prev_compny='$pre_cmpy',login_time='$lg_in', logout_time='$lg_out',attachment='$filename' WHERE id='$main_id'");
        if($update_qry){
           echo "<script> alert('data update succesfully');window.location.href='show_rec.php';</script>";
        }else{
            echo '<script> alert("unsuccesssfully update the record");</script>';
        }

    }
?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Employee Registration Form</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    </head>

    <body>
        <div class="row">
            <div class="col-lg-12">
                <a href="show_rec.php" class="btn btn-success" style="margin-left: 10rem; margin-top:1rem;" >show</a>
                <h4 class="text-center text-danger">Employee Registration Form</h4>
            </div>
        </div>
        <div class="container">
            <div class="col-lg-12 col-md-12 col-sm-12">
                    <form action="" method="POST" enctype="multipart/form-data" class="p-3 border rounded bg-light" id="myform">
                        <?php 
                            if(isset($_GET['id'])){
                                ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="emp_nm" class="form-label">Employee Name :</label>
                                            <input type="text" class="form-control" id="emp_nm" name="emp_nm" value="<?php echo $fetch->ename;?>">
                                            <span id="error_emp" style="color:red;"></span>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="dsign" class="form-label">Designation :</label>
                                            <select class="form-select select2" id="dsign" name="dsign">
                                                <option value=""> --Select Designation-- </option>
                                                <option value="designer" <?= ($fetch->designation == "designer") ? 'selected' : '' ?>>designer</option>
                                                <option value="developer" <?= ($fetch->designation == "developer") ? 'selected' : '' ?>>developer</option>
                                                <option value="manager" <?= ($fetch->designation == "manager") ? 'selected' : '' ?>>manager</option>
                                            </select>
                                            <span id="error_dg" style="color:red;"></span>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="age">Age :</label>
                                            <input type="number" class="form-control" id="age" name="age" value="<?php echo $fetch->age;?>">
                                            <span id="error_age" style="color:red;"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label" for="quali">Qualification :</label>
                                            <input type="text" class="form-control" id="quali" name="quali" value="<?php echo $fetch->qualifcation;?>">
                                            <span id="error_qua" style="color:red;"></span>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="pre_cmpny">Previous Company Name :</label>
                                            <input type="text" class="form-control" id="pre_cmpny" name="pre_cmpny" value="<?php echo $fetch->prev_compny;?>">
                                            <span id="error_pc" style="color:red;"></span>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="lgt">Login Time :</label>
                                            <div class="d-flex align-items-center gap-1">
                                                <select id="hour" class="form-select w-auto" name="li_hr">
                                                    <option value="">HH</option>
                                                    <?php
                                                        for($i=1;$i<=12;$i++){
                                                            $val = str_pad($i,2,"0",STR_PAD_LEFT);
                                                            $selected = ($val == $li_hour) ? "selected" : "";
                                                            echo "<option value='$val' $selected>$val</option>";
                                                        }
                                                    ?>
                                                </select><span>:</span>
                                                <select id="minute" class="form-select w-auto" name="li_mn">
                                                    <option value="">MM</option> 
                                                    <?php
                                                        for($i=0;$i<=59;$i++){
                                                        $val = str_pad($i,2,"0",STR_PAD_LEFT);
                                                        $selected = ($val == $li_minute) ? "selected" : "";
                                                        echo "<option value='$val' $selected>$val</option>";
                                                        }
                                                    ?>
                                                </select><span>:</span>
                                                <select id="ampm" class="form-select" name="li_ap" style="width: 8rem;">
                                                    <option value="">AM/PM</option>
                                                    <option value="AM" <?php if($li_ampm=="AM") echo "selected"; ?>>AM</option>
                                                    <option value="PM" <?php if($li_ampm=="PM") echo "selected"; ?>>PM</option>
                                                </select>
                                            </div>
                                            <span id="error_lt" style="color:red;"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="lot">Logout Time :</label>
                                            <div class="d-flex align-items-center gap-1">
                                                <select id="hour" class="w-auto form-select" name="lo_hr">
                                                    <option value="">HH</option>
                                                    <?php
                                                        for($i=1;$i<=12;$i++){
                                                            $val = str_pad($i,2,"0",STR_PAD_LEFT);
                                                            $selected = ($val == $lo_hour) ? "selected" : "";
                                                            echo "<option value='$val' $selected>$val</option>";
                                                        }
                                                    ?>
                                                </select><span>:</span>
                                                <select id="minute" class="w-auto form-select" name="lo_mn">
                                                    <option value="">MM</option> 
                                                    <?php
                                                        for($i=0;$i<=59;$i++){
                                                        $val = str_pad($i,2,"0",STR_PAD_LEFT);
                                                        $selected = ($val == $lo_minute) ? "selected" : "";
                                                        echo "<option value='$val' $selected>$val</option>";
                                                        }
                                                    ?>
                                                </select><span>:</span>
                                                <select id="ampm" class="form-select" name="lo_ap" style="width: 8rem;">
                                                    <option value="">AM/PM</option>
                                                    <option value="AM" <?php if($lo_ampm=="AM") echo "selected"; ?>>AM</option>
                                                    <option value="PM" <?php if($lo_ampm=="PM") echo "selected"; ?>>PM</option>
                                                </select>
                                            </div>
                                            <span id="error_ot" style="color:red;"></span>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="formFile" class="form-label">file upload :</label>
                                            <input class="form-control" type="file" id="formFile" name="formFile">
                                            <img width="100px" height="100px" src="uploads/<?php echo $fetch->attachment; ?>">
                                            <span id="error_ig" style="color:red;"></span>
                                        </div>
                                        <!-- <div class="col-md-4">
                                            <label for="user" class="form-label">User Name :</label>
                                            <input type="text" class="form-control" id="user" name="user">
                                            <span id="error_us" style="color:red;"></span>
                                        </div> -->
                                    </div>
                                    <!-- <div class="row">
                                        <div class="col-md-4">
                                            <label for="pass" class="form-label">Password :</label>
                                            <input type="password" class="form-control" id="pass" name="pass">
                                            <span id="error_ps" style="color:red;"></span>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="pass" class="form-label"> Confirm Password :</label>
                                            <input type="password" class="form-control" id="cpass" name="cpass">
                                            <span id="error_cps" style="color:red;"></span>
                                        </div>
                                    </div> -->
                                <?php 
                            }else{ ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="emp_nm" class="form-label">Employee Name :</label>
                                            <input type="text" class="form-control" id="emp_nm" name="emp_nm" >
                                            <span id="error_emp" style="color:red;"></span>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="dsign" class="form-label">Designation :</label>
                                            <select class="form-select select2" id="dsign" name="dsign">
                                                <option value=""> --Select Designation-- </option>
                                                <option value="designer" >designer</option>
                                                <option value="developer" >developer</option>
                                                <option value="manager" >manager</option>
                                            </select>
                                            <span id="error_dg" style="color:red;"></span>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="age">Age :</label>
                                            <input type="number" class="form-control" id="age" name="age" >
                                            <span id="error_age" style="color:red;"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label" for="quali">Qualification :</label>
                                            <input type="text" class="form-control" id="quali" name="quali" >
                                            <span id="error_qua" style="color:red;"></span>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="pre_cmpny">Previous Company Name :</label>
                                            <input type="text" class="form-control" id="pre_cmpny" name="pre_cmpny" >
                                            <span id="error_pc" style="color:red;"></span>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="lgt">Login Time :</label>
                                            <div class="d-flex align-items-center gap-1">
                                                <select id="hour" class="form-select w-auto" name="li_hr">
                                                    <option value="">HH</option>
                                                    <?php
                                                        for($i=1;$i<=12;$i++){
                                                            $val = str_pad($i,2,"0",STR_PAD_LEFT);
                                                            echo "<option value='$val'>$val</option>";
                                                        }
                                                    ?>
                                                </select><span>:</span>
                                                <select id="minute" class="form-select w-auto" name="li_mn">
                                                    <option value="">MM</option> 
                                                    <?php
                                                        for($i=0;$i<=59;$i++){
                                                        $val = str_pad($i,2,"0",STR_PAD_LEFT);
                                                        echo "<option value='$val'>$val</option>";
                                                        }
                                                    ?>
                                                </select><span>:</span>
                                                <select id="ampm" class="form-select" name="li_ap" style="width: 8rem;">
                                                    <option value="">AM/PM</option>
                                                    <option value="AM">AM</option>
                                                    <option value="PM">PM</option>
                                                </select>
                                            </div>
                                            <span id="error_lt" style="color:red;"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="lot">Logout Time :</label>
                                            <div class="d-flex align-items-center gap-1">
                                                <select id="hour" class="w-auto form-select" name="lo_hr">
                                                    <option value="">HH</option>
                                                    <?php
                                                        for($i=1;$i<=12;$i++){
                                                            $val = str_pad($i,2,"0",STR_PAD_LEFT);
                                                            echo "<option value='$val'>$val</option>";
                                                        }
                                                    ?>
                                                </select><span>:</span>
                                                <select id="minute" class="w-auto form-select" name="lo_mn">
                                                    <option value="">MM</option> 
                                                    <?php
                                                        for($i=0;$i<=59;$i++){
                                                        $val = str_pad($i,2,"0",STR_PAD_LEFT);
                                                        echo "<option value='$val'>$val</option>";
                                                        }
                                                    ?>
                                                </select><span>:</span>
                                                <select id="ampm" class="form-select" name="lo_ap" style="width: 8rem;">
                                                    <option value="">AM/PM</option>
                                                    <option value="AM">AM</option>
                                                    <option value="PM">PM</option>
                                                </select>
                                            </div>
                                            <span id="error_ot" style="color:red;"></span>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="formFile" class="form-label">file upload :</label>
                                            <input class="form-control" type="file" id="formFile" name="formFile">
                                            <span id="error_ig" style="color:red;"></span>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="user" class="form-label">User Name :</label>
                                            <input type="text" class="form-control" id="user" name="user">
                                            <span id="error_us" style="color:red;"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="pass" class="form-label">Password :</label>
                                            <input type="password" class="form-control" id="pass" name="pass">
                                            <span id="error_ps" style="color:red;"></span>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="pass" class="form-label"> Confirm Password :</label>
                                            <input type="password" class="form-control" id="cpass" name="cpass">
                                            <span id="error_cps" style="color:red;"></span>
                                        </div>
                                    </div>
                            <?php }
                        ?>
                        <div class="col-lg-12 mt-2 d-flex justify-content-end">
                            <input type="submit" name="<?php if(isset($_GET['id'])){echo "update" ;}else{echo "submit";}?>" id="submit" class="btn btn-primary" value="<?php if(isset($_GET['id'])){echo "Update" ;}else{echo "Submit" ;}?>">
                        </div>
                    </form>
            </div>
        </div>
    </body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $("#myform").submit(function(e){
            var emp = $("#emp_nm").val().trim();
            var desig = $("#dsign").val();
            var age = $("#age").val().trim();
            var qua = $("#quali").val().trim();
            var pc = $("#pre_cmpny").val().trim();
            var qua = $("#quali").val().trim();

            var li_hr = $("select[name='li_hr']").val();
            var li_mn = $("select[name='li_mn']").val();
            var li_ap = $("select[name='li_ap']").val();

            var lo_hr = $("select[name='lo_hr']").val();
            var lo_mn = $("select[name='lo_mn']").val();
            var lo_ap = $("select[name='lo_ap']").val();

            var file  = $("#formFile").val();
            var user  = $("#user").val().trim();
            var pass  = $("#pass").val().trim();
            var cpass  = $("#cpass").val().trim();

            if(emp ==''){
               $('#error_emp').text("Enter Employee Name").show().delay(2000).fadeOut();
               e.preventDefault();
               return false;
            }
            if(desig == ''){
                $('#error_dg').text("Select Designanation").show().delay(2000).fadeOut();
                e.preventDefault();
                return false;
            }
            if(age ==''|| isNaN(age) || age <= 0){
                $('#error_age').text("Enter age").show().delay(2000).fadeOut();
                e.preventDefault();
                return false;
            }
            if(qua ==''){
               $('#error_qua').text("Enter Qualification").show().delay(2000).fadeOut();
                e.preventDefault();
                return false;
            }
            if(pc ==''){
               $('#error_pc').text("Enter preCompany").show().delay(2000).fadeOut();
                e.preventDefault();
                return false;
            }
            if(li_hr == '' || li_mn == '' || li_ap == ''){
                $('#error_lt').text("Select complete Login Time").show().delay(2000).fadeOut();
                e.preventDefault();
                return false;
            }
            if(lo_hr == '' || lo_mn == '' || lo_ap == ''){
                $('#error_ot').text("Select complete Logout Time").show().delay(2000).fadeOut();
                e.preventDefault();
                return false;
            }
            if(file == ''){
                $('#error_ig').text("Please upload file").show().delay(2000).fadeOut();
                e.preventDefault();
                return false;
            }
            if(user == ''){
                $('#error_us').text("Enter Username").show().delay(2000).fadeOut();
                e.preventDefault();
                return false;
            }
            if(pass == ''){
                $('#error_ps').text("Enter Password").show().delay(2000).fadeOut();
                e.preventDefault();
                return false;
            }
            if(cpass == ''){
                $('#error_cps').text("Enter Confirm Password").show().delay(2000).fadeOut();
                e.preventDefault();
                return false;
            }
            if(pass !== cpass){
                $('#error_cps').text("Password do not match").show().delay(2000).fadeOut();
                e.preventDefault();
                return false;
            }
        });
    });
</script>









