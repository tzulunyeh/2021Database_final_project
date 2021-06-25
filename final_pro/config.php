<?php 

$server = "localhost";
$user = "root";
$pass = "Ryan510169";
$database = "final_project";


$conn = mysqli_connect($server, $user, $pass, $database);

mysqli_query($conn,"set names 'utf8'");

if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}



?>