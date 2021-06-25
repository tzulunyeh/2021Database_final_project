<?php 

    include '../config.php';

    $house = $_POST['$$houseid'];

    $sql = "DELETE FROM `house` WHERE `house.id`='$house'";
    echo $sql;
    mysqli_query($conn, 'SET NAMES utf8');
    $result = mysqli_query($conn, $sql);
	echo 'Accept';

?>