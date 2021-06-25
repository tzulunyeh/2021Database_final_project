<?php 

    include '../config.php';

    $house = $_POST['search_house'];
    $house = substr($house,1,4);

    $sql = "SELECT * FROM `house` NATURAL JOIN `area` WHERE `house.id` = '$house'";
	mysqli_query($conn, 'SET NAMES utf8');
	$stmt = $conn->prepare($sql);
	$result = $stmt->execute();
	$result = $stmt->get_result();
	$discussion = [];
	while ($row = $result->fetch_assoc()) {
		
        array_push($discussion, [
            'houseid' => $row['house.id'],
            'name' => $row['name'],
            'price' => $row['price'],
            'area.id' => $row['area.id'],
            '郵遞區號' => $row['郵遞區號'],
            '縣市' => $row['縣市'],
            '區' => $row['區'],
            '里' => $row['里'],
            'address' => $row['address'],
            '坪' => $row['坪'],
            '房' => $row['房'],
            '廳' => $row['廳'],
            '衛' => $row['衛'],
            '屋齡' => $row['屋齡'],
            '樓層' => $row['樓層'],
            '總樓數' => $row['總樓數'],
            '停車位' => $row['停車位'],
            '建案'=> $row['建案'],
            'link' => $row['link'],
        ]);
	
	}

	// $json = [
	// 	// 'ok' => true, 
	// 	'' => $discussion
	// ];
	$response = json_encode($discussion,JSON_UNESCAPED_UNICODE);
	echo $response;


?>