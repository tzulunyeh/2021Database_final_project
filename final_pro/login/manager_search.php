<?php 

    include '../config.php';
	error_reporting(0);
	$managerid = $_POST['managerid'];

    $sql = "SELECT * FROM `manager_to_house` NATURAL JOIN `house` WHERE `manager.id` = '$managerid'";
	mysqli_query($conn, 'SET NAMES utf8');
	$stmt = $conn->prepare($sql);
	$result = $stmt->execute();
	$result = $stmt->get_result();
	$discussion = [];

	while ($row = $result->fetch_assoc()) {
		array_push($discussion, [
			'houseid'=>$row['house.id'],
			'name' => $row['name'],
		]);
	}	
	// if(!($row = $result->fetch_assoc())){
	// 	array_push($discussion,[
	// 		'managerid' => '',
	// 		'username' => '',
	// 	]);
	// }

	// $json = [
	// 	// 'ok' => true, 
	// 	'' => $discussion
	// ];
	$response = json_encode($discussion,JSON_UNESCAPED_UNICODE);
	echo $response;


?>