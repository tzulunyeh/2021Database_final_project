<?php

    include '../config.php';
    error_reporting(0);
    
    $houseid = $_POST['houseid'];

    $sql = "SELECT * FROM `club_distance` NATURAL JOIN `club` WHERE `house.id`='$houseid' AND `club_distance`< '2'";
    mysqli_query($conn, 'SET NAMES utf8');
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();
    $result = $stmt->get_result();
    $discussion = [];
    while ($row = $result->fetch_assoc()) {
        $club=$row['club.id'];
        $sqlclub = "SELECT * FROM `club_activity` WHERE `club.id`= '$club'";
        $stmtclub = $conn->prepare($sqlclub);
        $resultclub = $stmtclub->execute();
        $resultclub = $stmtclub->get_result();
        $activity=NULL;
        while($rowclub=$resultclub->fetch_assoc()){
            $activity=$activity.$rowclub['activity'].'、';
        }

        array_push($discussion, [
            'clubid' => $row['club.id'],
            // 'areaid' => $row['area.id'],
            'name' => $row['name'],
            'address' => $row['address'],
            'tel' => $row['tel'],
            '活動'=> rtrim($activity,'、'),
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