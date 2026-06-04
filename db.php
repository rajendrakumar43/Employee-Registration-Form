<?php
    $con = new mysqli("localhost","root","","erp");
    if($con->connect_error){
        die("Connection Failed:".$con->connect_error);
    }else{
        // echo "Success!!";
    }
?>