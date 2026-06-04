<?php
include('db.php');
$id = $_GET['id'];
$test = "SELECT * FROM emp_register WHERE id = '$id'";
$result = mysqli_query($con, $test);
$fetch = mysqli_fetch_object($result);
$emp_nm = $fetch->ename;
$desgn = $fetch->designation;
$age = $fetch->age;
$qal = $fetch->qualifcation;
$pre_com = $fetch->prev_compny;
$lit = date(' h:i:s A ', strtotime($fetch->login_time));
$lot = date(' h:i:s A ', strtotime($fetch->logout_time));
$user_nm = $fetch->username;
$pass = $fetch->password;
$attch = $fetch->attachment;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <div class="row">
        <div class="col-lg-12">
            <a href="show_rec.php" class="btn btn-warning" style="margin-left: 10rem; margin-top:1rem;" >Back</a>
            <h4 class="text-center text-danger">View Employee Details</h4>
        </div>
    </div>
    <div class="container" style="border: 1px solid green;">
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label><strong>Employee Name:</strong></label>
                    <?php echo $emp_nm; ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label><strong>Designation :</strong></label>
                    <?php echo $desgn; ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label><strong>Age :</strong></label>
                    <?php echo $age; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label><strong>qualification :</strong></label>
                    <?php echo $qal; ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label><strong>Previous Company Name :</strong></label>
                    <?php echo $pre_com; ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label><strong>Login Time :</strong></label>
                    <?php echo $lit; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label><strong>Logout Time :</strong></label>
                    <?php echo $lot; ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label><strong>file upload :</strong></label>
                    <img src="uploads/<?php echo $attch ;?>" height="50px" width="100px">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label><strong>User Name :</strong></label>
                    <?php echo $user_nm; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label><strong>Password :</strong></label>
                    <?php echo $pass; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>