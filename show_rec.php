<?php

include('db.php');


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM `emp_register`WHERE `id`='$id'";
    $tbl_id = mysqli_query($con, $sql);
    if ($tbl_id) {
        echo "<script> alert('Record delete succesfully');window.location.href='show_rec.php';</script>";
    } else {
        echo '<script> alert("unsuccesssfully delete the record");</script>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Record Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-center">

            <div>
                <a href="register.php" class="btn btn-success btn-sm mb-2 ">Back</a>
                <table class="table table-bordered table-striped text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>Id</th>
                            <th>Employee Name</th>
                            <th>Designation</th>
                            <th>Age</th>
                            <th>Qualification</th>
                            <th>Previous Company Name</th>
                            <th>Login Time</th>
                            <th>Logout Time</th>
                            <th>file upload</th>
                            <th>User Name</th>
                            <th>Password</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM emp_register";
                        $result = mysqli_query($con, $sql);
                        $i = 1;
                        while ($row = mysqli_fetch_object($result)) {
                            $main_id = $row->id;
                            $emp_nm = $row->ename;
                            $desgn = $row->designation;
                            $age = $row->age;
                            $qal = $row->qualifcation;
                            $pre_com = $row->prev_compny;
                            $lit = date(' h:i:s A ', strtotime($row->login_time));
                            $lot = date(' h:i:s A ', strtotime($row->logout_time));
                            $user_nm = $row->username;
                            $pass = $row->password;
                            $attch = $row->attachment;

                        ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $emp_nm; ?></td>
                                <td><?php echo $desgn; ?></td>
                                <td><?php echo $age; ?></td>
                                <td><?php echo $qal; ?></td>
                                <td><?php echo $pre_com; ?></td>
                                <td><?php echo $lit; ?></td>
                                <td><?php echo $lot; ?></td>
                                <!-- <td><a href="uploads/<?php echo $attch; ?>" target="_blank">View Attachment</a></td> -->
                                <td><img src="uploads/<?php echo $attch ;?>" height="100px" width="100px"></td>
                                <td><?php echo $user_nm; ?></td>
                                <td><?php echo $pass; ?></td>
                                <td>
                                    <a href="view.php?id=<?php echo $main_id; ?>" class="btn btn-primary btn-sm m">View</a>
                                    <a href="register.php?id=<?php echo $main_id; ?>" class="btn btn-warning btn-sm">Update</a>
                                    <a href="show_rec.php?id=<?php echo $main_id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you want to delete the record');">Delete</a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <a href="login.php" class="btn btn-danger">login</a>
            </div>

        </div>
    </div>
</body>

</html>