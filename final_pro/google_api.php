<?php

    include 'config.php';
    set_time_limit(0);
        /**
     * @function getDistance()
     * Calculates the distance between two address
     * 
     * @params
     * $addressFrom - Starting point
     * $addressTo - End point
     * $unit - Unit type
     * 
     * @author CodexWorld
     * @url https://www.codexworld.com
     *
     */
    function getDistance($addressFrom, $addressTo, $unit = ''){
        // Google API key
        $apiKey = 'AIzaSyA0Ow288BsU4CDD7Y12DplzTqTr7mj_Tts';
        
        // Change address format
        $formattedAddrFrom    = str_replace(' ', '+', $addressFrom);
        $formattedAddrTo     = str_replace(' ', '+', $addressTo);
        
        // Geocoding API request with start address
        $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$apiKey);
        $outputFrom = json_decode($geocodeFrom);
        if(!empty($outputFrom->error_message)){
            return $outputFrom->error_message;
        }
        
        // Geocoding API request with end address
        $geocodeTo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false&key='.$apiKey);
        $outputTo = json_decode($geocodeTo);
        if(!empty($outputTo->error_message)){
            return $outputTo->error_message;
        }
        
        // Get latitude and longitude from the geodata
        $latitudeFrom    = $outputFrom->results[0]->geometry->location->lat;
        $longitudeFrom    = $outputFrom->results[0]->geometry->location->lng;
        $latitudeTo        = $outputTo->results[0]->geometry->location->lat;
        $longitudeTo    = $outputTo->results[0]->geometry->location->lng;


        // Calculate distance between latitude and longitude
        $theta    = $longitudeFrom - $longitudeTo;
        $dist    = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
        $dist    = acos($dist);
        $dist    = rad2deg($dist);
        $miles    = $dist * 60 * 1.1515;
        
        // Convert unit and return distance
        $unit = strtoupper($unit);
        if($unit == "K"){
            return round($miles * 1.609344, 2);
        }elseif($unit == "M"){
            return round($miles * 1609.344, 2);
        }else{
            return round($miles, 2);
        }
    }

    $sql="SELECT * FROM `house`";
    mysqli_query($conn, 'SET NAMES utf8');
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        
        $areaid=$row['area.id'];
        $sql="SELECT * FROM `area` WHERE `area.id`= '$areaid'";
        mysqli_query($conn, 'SET NAMES utf8');
        $stmt = $conn->prepare($sql);
        $result1 = $stmt->execute();
        $result1 = $stmt->get_result();
        $row2 = $result1->fetch_assoc();


        $sql="SELECT * FROM `exercise`";
        mysqli_query($conn, 'SET NAMES utf8');
        $stmt = $conn->prepare($sql);
        $result1 = $stmt->execute();
        $result1 = $stmt->get_result();
        while ($row1 = $result1->fetch_assoc()) {
            $addressFrom = urlencode($row2['縣市'].$row2['區'].$row2['里'].$row['address']);
            $addressTo = urlencode($row1['address']);
            $houseid=$row['house.id'];
            $shopid=$row1['exercise.id'];
            echo $houseid,'<br>';
            echo $shopid,'<br>';
            echo $addressFrom,'<br>';
            echo $addressTo,'<br>';

            $distance = getDistance($addressFrom, $addressTo, "K");

            $sql="INSERT INTO `exercise_distance`(`house.id`, `exercise.id`, `exercise_distance`) VALUES ('$houseid','$shopid','$distance')";
            mysqli_query($conn, 'SET NAMES utf8');
            mysqli_query($conn, $sql);
        }
    }

    // Get distance in km
    // $distance = getDistance($addressFrom, $addressTo, "K");
    //     echo $distance;

    // $sqlhouse="SELECT `house.id`,`address`,`縣市`,`區`,`里` from `house` natural join `area`" ;
	// $resulthouse = mysqli_query($conn, $sqlhouse);
	// while($house_array=mysqli_fetch_assoc($resulthouse)){
	// 	$houseAddress=$house_array['縣市'].$house_array['區'].$house_array['里'].$house_array['address'];
	// 	$addressFrom=urlencode($houseAddress);
	// 	$houseid=$house_array['house.id'];
	// 	echo $houseid,'<br>';
	// 	echo $addressFrom,'<br>';
	// 	$sqlEx="SELECT `address`, `exercise.id` from `exercise_place`";
	// 	$resultEx = mysqli_query($conn, $sqlEx);
	// 	while($exAddress = mysqli_fetch_assoc($resultEx)){
	// 		$exerciseid=$exAddress['exercise.id'];
	// 		$addressTo   = urlencode($exAddress['address']);

	// 		$distance = getDistance($addressFrom, $addressTo, "K");
	// 		$sqlInsert = "INSERT INTO `exercise_distance`(`house.id`,`exercise.id`,`exercise_distance`) VALUES($houseid,$exerciseid,$distance)";
	// 	}
	// }

	// Get distance in km
	// $distance = getDistance($addressFrom, $addressTo, "K");
	// echo $distance;
     
?>