<?php
	set_time_limit(0);
	include 'config.php';
	
	require __DIR__ . '/vendor/autoload.php';

	// 建立 Google Client
	$client = new \Google_Client();
	$client->setApplicationName('Google Sheets and PHP');
	// 設定權限
	$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
	$client->setAccessType('offline');
	// 引入金鑰
	$client->setAuthConfig(__DIR__ . '/final-project-db-315613-97a4a17a48d5.json');
	
	// 建立 Google Sheets Service
	$service = new \Google_Service_Sheets($client);
	
	// Google Sheet ID
	$spreadsheetId = '13QG17ryuYUsvOChllgleqByXJrYtY_dhajP0IgFm7bc';
	
	// $requests = [
	// 	new Google_Service_Sheets_Request([
	// 		'deleteDimension'=> [
	// 			'range' => [
	// 				'sheetId'   => 919643660, 
    //                 'dimension' => 'ROWS',
    //                 'startIndex'=> 2699, 
    //                 'endIndex'  => 2702,
	// 			]
	// 		]
	// 	])
	// ];
	
	// $batchUpdateRequest = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
	// 	'requests'=> $requests
	// ]);

	// $response = $service->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);
	







	// // 取得 Sheet 範圍

	// $getRange = "'club'!A2:E10";
	
	// // 讀取資料
	// $response = $service->spreadsheets_values->get($spreadsheetId, $getRange);
	// $valuesRange = $response->getValues();

	// $mask = "%4s\n";
	// foreach($valuesRange as $row ){
	// 	if(floatval($row[4])<2){

	// 		$sql = "SELECT * FROM `house` WHERE `house.id` = '$row[0]'";
	// 		$result = mysqli_query($conn, $sql);
	// 		$output = mysqli_fetch_assoc($result);

	// 		// echo sprintf($mask,$row[0],$row[1]);
	// 		// echo $row[0];
	// 		echo $row[0] ,'<br>';
	// 		echo $output['name'];
	// 		echo '<br>';  
	// 	}
		
	// }
	
		$sql = "SELECT * FROM `house` ORDER BY `house.id` DESC LIMIT 0 , 1";
		$result = mysqli_query($conn, $sql);
		$houseid = mysqli_fetch_row($result);
		$houseid[0] = substr($houseid[0],1);
		$houseid[0]=intval($houseid[0]); //-1
		$count_house=intval($houseid[0])*19+2;
		$houseid[0]=intval($houseid[0])+1;
		$houseid[0]='H'.strval($houseid[0]);

			$sql = "SELECT * FROM `club`";
			$result = mysqli_query($conn, $sql);

		while($clubid = mysqli_fetch_assoc($result)){

			echo $clubid['club.id'] ,'<br>';

			// 取得 Sheet 範圍
			
			$A='A'.$count_house;
			$D='D'.$count_house;
			echo $A,'<br>';
			$getRange = "'club'!$count_house:$count_house";

			echo $clubid['club.id'] ,'<br>';

			// 值
			$values = [[$houseid[0], $clubid['club.id'],'大雅國小',$clubid['address']]];
			echo $clubid['club.id'] ,'<br>';
			// Update Sheet
			$body = new \Google_Service_Sheets_ValueRange([
				'values' => $values
			]);
		
			$params = [
				'valueInputOption' => 'RAW'
			];
		
			$insert = [
				"insertDataOption" => "INSERT_ROWS"
			];
		
			$updateSheet = $service->spreadsheets_values->update($spreadsheetId, $getRange, $body, $params,$insert);
			$count_house = $count_house+1;
		}
			

	// $sql = "SELECT * FROM manager WHERE account='$account' AND password='$password'";
	// $result = mysqli_query($conn, $sql);
	// if ($result->num_rows > 0) {
		// $row = mysqli_fetch_assoc($result);
		// $_SESSION['account'] = $row['account'];
	// 	header("Location: welcome.php");
	// } else {
	// 	echo "<script>alert('Woops! account or Password is Wrong.')</script>";
	// }



?>