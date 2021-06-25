<?php
    include '../config.php';
    error_reporting(0);
    $sql="SELECT `縣市` FROM `area` GROUP BY `縣市`";
    mysqli_query($conn, 'SET NAMES utf8');
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();
    $result = $stmt->get_result();
    $discussion = [];
    while ($row = $result->fetch_assoc()) {
        array_push($discussion, [
            '縣市' => $row['縣市'],
        ]);
    }
    $response = json_encode($discussion,JSON_UNESCAPED_UNICODE);
    echo $response;
?>