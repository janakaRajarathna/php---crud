<?php
 $server="localhost";
 $username="root";
 $password="";
 $database="sch";

 $con = mysqli_connect($server,$username, $password, $database);
 
 //Error Handling
 if(!$con){
    die("Database Connection Fail".mysqli_connect_error());
 }

?>