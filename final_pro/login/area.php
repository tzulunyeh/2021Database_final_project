<?php
    include '../config.php';
    error_reporting(0);
    $city = $_POST['city'];
    $sql="SELECT `區` FROM `area` WHERE `縣市`='$city' GROUP BY `區`";
    mysqli_query($conn, 'SET NAMES utf8');
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();
    $result = $stmt->get_result();
    $discussion = [];
    while ($row = $result->fetch_assoc()) {
        array_push($discussion, [
            '區' => $row['區'],
        ]);
    }
    $response = json_encode($discussion,JSON_UNESCAPED_UNICODE);
    echo $response;
?>