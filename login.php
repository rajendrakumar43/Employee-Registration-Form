<?php
    session_start();
    include('db.php');
    date_default_timezone_set("Asia/Kolkata") ;
    if(isset($_POST['login'])){

    $username = $_POST['user'];
    $password = $_POST['pass'];

    $query = "SELECT * FROM emp_register WHERE username='$username' AND `password`='$password'";
    $result = mysqli_query($con,$query);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_object($result);

        $ctime = strtotime(date("H:i"));
        $lg_in = strtotime($row->login_time);
        $lg_out = strtotime($row->logout_time);
        
        if($ctime >= $lg_in && $ctime <= $lg_out){
            $_SESSION['user'] = $username;
            echo "<script>alert('log in succesfully');window.location.href='dashboard.php';</script>";exit;
        }else{
            echo "<script>alert('Login allowed only between {$row->login_time} and {$row->logout_time}');window.location.href='login.php';</script>";exit;
        } 
    }else{
        echo "<script>alert('Invalid Username or Password');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>login Form</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    </head>

    <body>
        <h4 class="text-center text-danger">login page</h4>
        <div class="container">
            <div class="d-flex justify-content-center align-items-center  ">
                <div style="height: 400px;">
                    <form action="" method="POST"  class="p-3 border rounded bg-light">
                        
                        <div class="mb-1">
                            <label for="user" class="form-label">User Name :</label>
                            <input type="text" class="form-control" id="user" name="user" >
                        </div>
                        <div class="mb-1">
                            <label for="pass" class="form-label">Password :</label>
                            <input type="password" class="form-control" id="pass" name="pass" >
                        </div>
                        <input type="submit" name="login" value="Login" >
                        <a href="register.php">Registration</a>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
