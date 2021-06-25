<?php 

    include '../config.php';
    error_reporting(0);
    set_time_limit(0);
    
    function getLatandLong($addressFrom){
        // Google API key
        $apiKey = 'AIzaSyA0Ow288BsU4CDD7Y12DplzTqTr7mj_Tts';
        
        // Change address format
        $formattedAddrFrom    = str_replace(' ', '+', $addressFrom);
        // $formattedAddrTo     = str_replace(' ', '+', $addressTo);
        
        // Geocoding API request with start address
        $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$apiKey);
        $outputFrom = json_decode($geocodeFrom);
        if(!empty($outputFrom->error_message)){
            return $outputFrom->error_message;
        }
        $latitudeFrom    = $outputFrom->results[0]->geometry->location->lat;
        $longitudeFrom    = $outputFrom->results[0]->geometry->location->lng;

        return array($latitudeFrom,$longitudeFrom);
    }


    function getDistance($latitudeFrom, $longitudeFrom,$latitudeTo,$longitudeTo, $unit = ''){
        // Google API key
        $apiKey = 'AIzaSyA0Ow288BsU4CDD7Y12DplzTqTr7mj_Tts';

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

    $houseid =$_POST ['$$houseid'];
    $name =$_POST ['$$name'];
    $price =$_POST ['$$price'];
    $address_city =$_POST ['$$address_city'];
    $address_area =$_POST ['$$address_area'];
    $address_vill =$_POST ['$$address_vill'];
    $address_road =$_POST ['$$address_road'];
    $pin =$_POST ['$$pin'];
    $room =$_POST ['$$room'];
    $living =$_POST ['$$living'];
    $bath =$_POST ['$$bath'];
    $age =$_POST ['$$age'];
    $floor =$_POST ['$$floor'];
    $sum_floor =$_POST ['$$sum_floor'];
    $parking =$_POST ['$$parking'];
    $case =$_POST ['$$case'];
    $link =$_POST ['$$link'];
    $address=$address_city.$address_area.$address_vill.$address_road;

    $sql = "SELECT * FROM `area` WHERE `縣市`='$address_city' AND `區`='$address_area' AND `里`='$address_vill';";
    mysqli_query($conn, 'SET NAMES utf8');
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $areaid=$row["area.id"];
        $addressFrom=urlencode($address_city.$address_area.$address_vill.$address_road);
        $ginwai=getLatandLong($addressFrom);
        $sql = "UPDATE `house` SET `name`='$name', `area.id`='$areaid',`price`='$price',`address`='$address_road',`坪`='$pin',`房`='$room',`廳`='$living',`衛`='$bath',`屋齡`='$age',`樓層`='$floor',`總樓數`='$sum_floor',`停車位`='$parking',`建案`='$case',`link`='$link',`經`='$ginwai[1]',`緯`='$ginwai[0]' WHERE `house.id`='$houseid'";
        mysqli_query($conn, 'SET NAMES utf8');
        mysqli_query($conn, $sql);
        $addressFrom=urlencode($address_city.$address_area.$address_vill.$address_road);
        $ginwai=getLatandLong($addressFrom);

        $sql ="SELECT * FROM `shop`";
        mysqli_query($conn, 'SET NAMES utf8');
        mysqli_query($conn, $sql);
        $stmt = $conn->prepare($sql);
        $result_shop = $stmt->execute();
        $result_shop = $stmt->get_result();
        while ($row_shop = $result_shop->fetch_assoc()) {
            $shopid =$row_shop['shop.id'];
            $ginshop=$row_shop['經'];
            $waishop=$row_shop['緯'];
            $distance = getDistance($ginwai[1],$ginwai[0],$ginshop,$waishop, "K");
            $sql="UPDATE `shop_distance` SET `house.id`='$houseid',`shop.id`='$shopid',`shop_distance`='$distance' WHERE `house.id` ='$houseid' AND `shop.id`='$shopid'";
            mysqli_query($conn, 'SET NAMES utf8');
            mysqli_query($conn, $sql);
        }

        $sql ="SELECT * FROM `club`";
        mysqli_query($conn, 'SET NAMES utf8');
        mysqli_query($conn, $sql);
        $stmt = $conn->prepare($sql);
        $result_club = $stmt->execute();
        $result_club = $stmt->get_result();
        while ($row_club = $result_club->fetch_assoc()) {
            $clubid =$row_club['club.id'];
            $ginclub=$row_club['經'];
            $waiclub=$row_club['緯'];
            $distance = getDistance($ginwai[1],$ginwai[0],$ginclub,$waiclub, "K");
            $sql="UPDATE `club_distance` SET `house.id`='$houseid',`club.id`='$clubid',`club_distance`='$distance' WHERE `house.id` ='$houseid' AND `club.id`='$clubid'";
            mysqli_query($conn, 'SET NAMES utf8');
            mysqli_query($conn, $sql);
        }

        $sql ="SELECT * FROM `medical`";
        mysqli_query($conn, 'SET NAMES utf8');
        mysqli_query($conn, $sql);
        $stmt = $conn->prepare($sql);
        $result_medical = $stmt->execute();
        $result_medical = $stmt->get_result();
        while ($row_medical = $result_medical->fetch_assoc()) {
            $medicalid =$row_medical['medical.id'];
            $ginmed=$row_medical['經'];
            $waimed=$row_medical['緯'];
            $distance = getDistance($ginwai[1],$ginwai[0],$ginmed,$waimed, "K");
            $sql="UPDATE `medical_distance` SET `house.id`='$houseid',`medical.id`='$medicalid',`medical_distance`='$distance' WHERE `house.id` ='$houseid' AND `medical.id`='$medicalid'";
            mysqli_query($conn, 'SET NAMES utf8');
            mysqli_query($conn, $sql);
        }

        $sql ="SELECT * FROM `exercise`";
        mysqli_query($conn, 'SET NAMES utf8');
        mysqli_query($conn, $sql);
        $stmt = $conn->prepare($sql);
        $result_exercise = $stmt->execute();
        $result_exercise = $stmt->get_result();
        while ($row_exercise = $result_exercise->fetch_assoc()) {
            $exerciseid =$row_exercise['exercise.id'];
            $ginex=$row_exercise['經'];
            $waiex=$row_exercise['緯'];
            $distance = getDistance($ginwai[1],$ginwai[0],$ginex,$waiex, "K");
            $sql="UPDATE `exercise_distance` SET `house.id`='$houseid',`exercise.id`='$exerciseid',`exercise_distance`='$distance' WHERE `house.id` ='$houseid' AND `exercise.id`='$exerciseid'";
            mysqli_query($conn, 'SET NAMES utf8');
            mysqli_query($conn, $sql);
        }

        echo "Accept";
    }
    else{
        echo "資料錯誤";
    }
?>