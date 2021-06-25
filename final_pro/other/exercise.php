<?php
    
    include '../config.php';
    error_reporting(0);
    
    $houseid = $_POST['houseid'];
     
    $sql = "SELECT * FROM `exercise_distance` NATURAL JOIN `exercise` WHERE `house.id`='$houseid' AND `exercise_distance`< '2'";
    mysqli_query($conn, 'SET NAMES utf8');
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();
    $result = $stmt->get_result();
    $discussion = [];
    while ($row = $result->fetch_assoc()) {
        $ex=$row['exercise.id'];
        $sqlFa = "SELECT * FROM `exercise_facility` WHERE `exercise.id`= '$ex'";
        $stmtFa = $conn->prepare($sqlFa);
        $resultFa = $stmtFa->execute();
        $resultFa = $stmtFa->get_result();
        $facility=NULL;
        while($rowFa=$resultFa->fetch_assoc()){
            $facility=$facility.$rowFa['facility'].'、';
        }
        array_push($discussion, [
            'exerciseid' => $row['exercise.id'],
            'name' => $row['name'],
            // 'areaid' => $row['area.id'],
            'address' => $row['address'],
            'tel' => $row['tel'],
            '設施'=> rtrim($facility,'、'),
            '經'=>floatval($row['經']),
            '緯'=>floatval($row['緯']),
        ]);
    }

    // $json = [
    // 	// 'ok' => "TRUE", 
    // 	'' => $discussion
    // ];
    $response = json_encode($discussion,JSON_UNESCAPED_UNICODE);
    echo $response;

?>