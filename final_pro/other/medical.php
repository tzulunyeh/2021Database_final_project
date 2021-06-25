<?php
    
    include '../config.php';
    error_reporting(0);
    
    $houseid = $_POST['houseid'];

    $sql = "SELECT * FROM `medical_distance` NATURAL JOIN `medical` WHERE `house.id`='$houseid' AND `medical_distance`< '2'";
    mysqli_query($conn, 'SET NAMES utf8');
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();
    $result = $stmt->get_result();
    $discussion = [];
    while ($row = $result->fetch_assoc()) {
        array_push($discussion, [
            'medicalid' => $row['medical.id'],
            // 'areaid' => $row['area.id'],
            'address' => $row['address'],
            'name' => $row['name'],
            'tel' => $row['tel'],
            'type' => $row['type'],
	        'level' => $row['level'],
            '經'=>floatval($row['經']),
            '緯'=>floatval($row['緯']),
        ]);
    }

    // $json = [
    //  // 'ok' => true, 
    //  '' => $discussion
    // ];
    $response = json_encode($discussion,JSON_UNESCAPED_UNICODE);
    echo $response;

?>