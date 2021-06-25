<?php
	set_time_limit(0);
	include 'config.php';
	 error_reporting(0);

	$Vill = $_POST['Vill'];
	$Club = $_POST['Club'];
	$Exc = $_POST['Exc'];
	$Med = $_POST['Med'];
	$Shop = $_POST['Shop'];
	$Price = $_POST['Price'];
	$Ping = $_POST['Ping'];
	$Year = $_POST['Year'];

	// $Vill='麗林里';
	// $Club = 10;
	// $Exc = 10;
	// $Med = 10;
	// $Shop = 10;
	// $Price = 5000;
	// $Ping = 200;
	// $Year = 200;

	// 讀取資料
	$array = [];

	$sqlShop="SELECT `house.id`,MIN(`shop_distance`) AS minDistance FROM `shop_distance` GROUP BY `house.id`";
	$sqlEx="SELECT `house.id`,MIN(`exercise_distance`) AS minDistance FROM `exercise_distance` GROUP BY `house.id`";
	$sqlMed="SELECT `house.id`,MIN(`medical_distance`) AS minDistance FROM `medical_distance` GROUP BY `house.id`";
	$sqlClub="SELECT `house.id`,MIN(`club_distance`) AS minDistance FROM `club_distance` GROUP BY `house.id`";

	$Shopresult = mysqli_query($conn, $sqlShop);
	while($shop_distance = mysqli_fetch_assoc($Shopresult)){
		$array[$shop_distance['house.id']]=0;
		if($shop_distance['minDistance'] < $Shop){
			$array[$shop_distance['house.id']]++;
		}
	}

	$sqlEx="SELECT `house.id`,MIN(`exercise_distance`) AS minDistance FROM `exercise_distance` GROUP BY `house.id`";
	$Exresult = mysqli_query($conn, $sqlEx);
	while($ex_distance = mysqli_fetch_assoc($Exresult)){
		if($ex_distance['minDistance']<$Exc){
			$array[$ex_distance['house.id']]++;
		}
	}

	$sqlMed="SELECT `house.id`,MIN(`medical_distance`) AS minDistance FROM `medical_distance` GROUP BY `house.id`";
	$Medresult = mysqli_query($conn, $sqlMed);
	while($med_distance = mysqli_fetch_assoc($Medresult)){
		if($med_distance['minDistance']<$Med){
			$array[$med_distance['house.id']]++;
		}
	}

	$sqlClub="SELECT `house.id`,MIN(`club_distance`) AS minDistance FROM `club_distance` GROUP BY `house.id`";
	$Clubresult = mysqli_query($conn, $sqlClub);
	while($club_distance = mysqli_fetch_assoc($Clubresult)){
		if($club_distance['minDistance']<$Club){
			$array[$club_distance['house.id']]++;
		}
	}

	$sql = "SELECT * FROM house NATURAL JOIN area WHERE `price`< '$Price' AND  `坪`<'$Ping' AND `屋齡`<'$Year'";

	$sqlVill="SELECT * FROM `area` WHERE `里` = '$Vill'";
	$Villresult = mysqli_query($conn, $sqlVill);
	while($result = mysqli_fetch_assoc($Villresult)){
		$areaid =$result['area.id'];
		$sql=$sql." AND `area.id`= '$areaid'";
	}

	mysqli_query($conn, 'SET NAMES utf8');
	$stmt = $conn->prepare($sql);
	$result = $stmt->execute();
	$result = $stmt->get_result();
	$discussion = [];
	while ($row = $result->fetch_assoc()) {
	if($array[$row['house.id']]==4){
	// echo $array[$row['house.id']],'<br>' ;
	// echo $row['縣市'].$row['區'].$row['里'].$row['address'];
	array_push($discussion, [
	'houseid' => $row['house.id'],
	'name' => $row['name'],
	'price' => $row['price'],
	// 'area.id' => $row['area.id'],
	'address' => $row['縣市'].$row['區'].$row['里'].$row['address'],
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
	'經'=>floatval($row['經']),
    '緯'=>floatval($row['緯']),
	]);
	}
	}

	// $json = [
	//  // 'ok' => true, 
	//  '' => $discussion
	// ];
	$response = json_encode($discussion,JSON_UNESCAPED_UNICODE);
	echo $response;
?>