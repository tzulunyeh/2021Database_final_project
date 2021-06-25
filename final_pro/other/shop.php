<?php

    include '../config.php';
    error_reporting(0);
    
    $houseid = $_POST['houseid'];

    $sql = "SELECT * FROM `shop_distance` NATURAL JOIN `shop` WHERE `house.id`='$houseid' AND `shop_distance`< '2'";
    mysqli_query($conn, 'SET NAMES utf8');
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();
    $result = $stmt->get_result();
    $discussion = [];
    while ($row = $result->fetch_assoc()) {
        array_push($discussion, [
            'shopid' => $row['shop.id'],
            // 'areaid' => $row['area.id'],
            'address' => $row['address'],
            'name' => $row['name'],
            'shopnum' => $row['shop.num'],
            'tel' => $row['tel'],
            'time' => $row['time'],
            '經'=>floatval($row['經']),
            '緯'=>floatval($row['緯']),
        ]);
    }

    // $json = [
    // 	// 'ok' => true, 
    // 	'' => $discussion
    // ];
    $response = json_encode($discussion,JSON_UNESCAPED_UNICODE);
    echo $response;

?>