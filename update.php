<?php
include('db.php');
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
        qualifcation='$qualif',prev_compny='$pre_cmpy',login_time='$lg_in', logout_time='$lg_out',attachment='$filename',username='$user_nm',password='$pass' WHERE id='$main_id'");
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
        <a href="show_rec.php" class="btn btn-success">show</a>
        <h4 class="text-center text-danger">Employee Registration Form</h4>
        <div class="container">
            <div class="d-flex justify-content-center align-items-center  ">
                <div style="height: 400px;">
                    <form action="" method="POST" enctype="multipart/form-data" class="p-3 border rounded bg-light">
                        <div class="mb-1">
                            <label for="emp_nm" class="form-label">Employee Name :</label>
                            <input type="text" class="form-control" id="emp_nm" name="emp_nm" value="<?php echo $fetch->ename;?>">
                        </div>
                        <div class="mb-1">
                            <label for="dsign" class="form-label">Designation :</label>
                            <select class="form-select select2" id="dsign" name="dsign">
                                <option> --Select Designation-- </option>
                                <option value="designer" <?= ($fetch->designation == "designer") ? 'selected' : '' ?>>designer</option>
                                <option value="developer" <?= ($fetch->designation == "developer") ? 'selected' : '' ?>>developer</option>
                                <option value="manager" <?= ($fetch->designation == "manager") ? 'selected' : '' ?>>manager</option>
                            </select>
                        </div>
                        <div class="mb-1 ">
                            <label class="form-label" for="age">Age :</label>
                            <input type="number" class="form-control" id="age" name="age" value="<?php echo $fetch->age;?>">
                        </div>
                        <div class="mb-1 ">
                            <label class="form-label" for="quali">Qualification :</label>
                            <input type="text" class="form-control" id="quali" name="quali" value="<?php echo $fetch->qualifcation;?>">
                        </div>
                        <div class="mb-1 ">
                            <label class="form-label" for="pre_cmpny">Previous Company Name :</label>
                            <input type="text" class="form-control" id="pre_cmpny" name="pre_cmpny" value="<?php echo $fetch->prev_compny;?>">
                        </div>
                        <div class="mb-1 ">
                            <label for="lgt">Login Time :</label>
                            <!-- <input type="time" name="lit" id="lit" class="form-control" onchange="onTimeChange()"> -->
                            <div class="col-12 w-100 d-flex">
                                <select id="hour" class="w-25 form-select" name="li_hr">
                                    <option value="">HH</option>
                                    <?php
                                        for ($i = 1; $i <= 12; $i++) {
                                            $val = str_pad($i, 2, "0", STR_PAD_LEFT);
                                            $selected = ($val == $li_hour) ? "selected" : "";
                                            echo "<option value='$val' $selected>$val</option>";
                                        }
                                    ?>
                                </select><span>:</span>
                                <select id="minute" class="w-25 form-select" name="li_mn">
                                    <option value="">MM</option> 
                                    <?php
                                        for ($i = 0; $i < 60; $i++) {
                                            $val = str_pad($i, 2, "0", STR_PAD_LEFT);
                                            $selected = ($val == $li_minute) ? "selected" : "";
                                            echo "<option value='$val' $selected>$val</option>";
                                        }
                                    ?>
                                </select><span>:</span>
                                <select id="ampm" class="w-25 form-select" name="li_ap">
                                    <option value="">AM/PM</option>
                                    <option value="AM"  <?php if($li_ampm=="AM") echo "selected"; ?>>AM</option>
                                    <option value="PM" <?php if($li_ampm=="PM") echo "selected"; ?>>PM</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-1">
                            <label for="lot">Logout Time :</label>
                            <!-- <input type="time" name="lot" id="lot" class="form-control" onchange="TimeChange()"> -->
                            <div class="col-12 w-100 d-flex">
                                <select id="hour" class="w-25 form-select" name="lo_hr">
                                    <option value="">HH</option>
                                    <?php
                                        for ($i = 1; $i <= 12; $i++) {
                                            $val = str_pad($i, 2, "0", STR_PAD_LEFT);
                                            $selected = ($val == $lo_hour) ? "selected" : "";
                                            echo "<option value='$val' $selected>$val</option>";
                                        }
                                    ?>
                                </select><span>:</span>
                                <select id="minute" class="w-25 form-select" name="lo_mn">
                                    <option value="">MM</option> 
                                    <?php
                                        for ($i = 0; $i < 60; $i++) {
                                            $val = str_pad($i, 2, "0", STR_PAD_LEFT);
                                            $selected = ($val == $lo_minute) ? "selected" : "";
                                            echo "<option value='$val' $selected>$val</option>";
                                        }
                                    ?>
                                </select><span>:</span>
                                <select id="ampm" class="w-25 form-select" name="lo_ap">
                                    <option value="">AM/PM</option>
                                    <option value="AM" <?php if($lo_ampm=="AM") echo "selected"; ?>>AM</option>
                                    <option value="PM" <?php if($lo_ampm=="PM") echo "selected"; ?>>PM</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-1">
                            <label for="formFile" class="form-label">file upload :</label>
                            <input class="form-control" type="file" id="formFile" name="formFile" >
                        </div>
                        <img width="100px" height="100px" src="uploads/<?php echo $fetch->attachment; ?>">
                        
                        <div class="mb-1">
                            <label for="user" class="form-label">User Name :</label>
                            <input type="text" class="form-control" id="user" name="user"value="<?php echo $fetch->username;?>">
                        </div>
                        <div class="mb-1">
                            <label for="pass" class="form-label">Password :</label>
                            <input type="password" class="form-control" id="pass" name="pass"value="<?php echo $fetch->password;?>">
                        </div>
                        <input type="submit" name="update" class="btn btn-primary" value="Update">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
