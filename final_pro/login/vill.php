<?php
    include '../config.php';
    error_reporting(0);
    $area = $_POST['area'];
    $city = $_POST['city'];
    $sql="SELECT `里` FROM `area` WHERE `區`='$area' AND `縣市`='$city' GROUP BY `里` ORDER BY `area.id` ASC";
    mysqli_query($conn, 'SET NAMES utf8');
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();
    $result = $stmt->get_result();
    $discussion = [];
    while ($row = $result->fetch_assoc()) {
        array_push($discussion, [
            '里' => $row['里'],
        ]);
    }
    $response = json_encode($discussion,JSON_UNESCAPED_UNICODE);
    echo $response;
?>