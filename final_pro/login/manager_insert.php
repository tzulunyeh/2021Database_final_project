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
        
        // // Change address format
        // $formattedAddrFrom    = str_replace(' ', '+', $addressFrom);
        // // $formattedAddrTo     = str_replace(' ', '+', $addressTo);
        
        // // Geocoding API request with start address
        // $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$apiKey);
        // $outputFrom = json_decode($geocodeFrom);
        // if(!empty($outputFrom->error_message)){
        //     return $outputFrom->error_message;
        // }
        
        // // // Geocoding API request with end address
        // // $geocodeTo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false&key='.$apiKey);
        // // $outputTo = json_decode($geocodeTo);
        // // if(!empty($outputTo->error_message)){
        // //     return $outputTo->error_message;
        // // }
        
        // // Get latitude and longitude from the geodata
        // $latitudeFrom    = $outputFrom->results[0]->geometry->location->lat;
        // $longitudeFrom    = $outputFrom->results[0]->geometry->location->lng;
        // $latitudeTo        = $outputTo->results[0]->geometry->location->lat;
        // $longitudeTo    = $outputTo->results[0]->geometry->location->lng;


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

    $managerid = $_POST['managerid'];
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

    $sql = "SELECT * FROM `house` ORDER BY `house.id` DESC LIMIT 0 , 1";
    $result = mysqli_query($conn, $sql);
    $houseid = mysqli_fetch_row($result);
    $houseid[0] = substr($houseid[0],1);
    $houseid[0]=intval($houseid[0])+1;
    $houseid[0]='H'.strval($houseid[0]);
    
    $sql ="SELECT `area.id` FROM `area` WHERE `縣市` ='$address_city' AND `區` ='$address_area' AND `里` ='$address_vill'";
    mysqli_query($conn, 'SET NAMES utf8');
    $result = mysqli_query($conn, $sql);


    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $areaid=$row["area.id"];
        
        $sql = "SELECT * FROM `house` WHERE `name` ='$name' AND `area.id`='$areaid' AND `price` ='$price' AND `address` ='$address_road' AND `坪` ='$pin' AND `房` ='$room' AND `廳` ='$living' AND `衛` ='$bath' AND `屋齡` ='$age' AND `樓層` ='$floor' AND `總樓數` ='$sum_floor' AND `停車位` ='$parking' AND `建案` ='$case' AND `link` ='$link'";
        mysqli_query($conn, 'SET NAMES utf8');
        $result = mysqli_query($conn, $sql);
        
        if ($result->num_rows <= 0) {
            $addressFrom=urlencode($address_city.$address_area.$address_vill.$address_road);
            $ginwai=getLatandLong($addressFrom);

            $sql = "INSERT INTO `house`(`house.id`, `name`, `price`, `area.id`, `address`, `坪`, `房`, `廳`, `衛`, `屋齡`, `樓層`, `總樓數`, `停車位`, `建案`, `link`,`經`,`緯`) 
                    VALUES ('$houseid[0]','$name','$price','$areaid','$address_road','$pin','$room','$living','$bath','$age','$floor','$sum_floor','$parking','$case','$link','$ginwai[1]','$ginwai[0]')";
            mysqli_query($conn, 'SET NAMES utf8');
            mysqli_query($conn, $sql);

            $sql = "INSERT INTO `manager_to_house`(`manager.id`, `house.id`) VALUES ('$managerid','$houseid[0]')";  
            mysqli_query($conn, 'SET NAMES utf8');
            mysqli_query($conn, $sql);
            
            if($managerid!='M1'){
                $sql = "INSERT INTO `manager_to_house`(`manager.id`, `house.id`) VALUES ('M1','$houseid[0]')";  
                mysqli_query($conn, 'SET NAMES utf8');
                mysqli_query($conn, $sql);  
            }

            $sql ="SELECT `shop.id`, `經`, `緯` FROM `shop`";
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
                $sql="INSERT INTO `shop_distance`(`house.id`, `shop.id`, `shop_distance`) VALUES ('$houseid[0]','$shopid','$distance')";
                mysqli_query($conn, 'SET NAMES utf8');
                mysqli_query($conn, $sql);
            }

            $sql ="SELECT `club.id`, `經`, `緯` FROM `club`";
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
                $sql="INSERT INTO `club_distance`(`house.id`, `club.id`, `club_distance`) VALUES ('$houseid[0]','$clubid','$distance')";
                
                mysqli_query($conn, 'SET NAMES utf8');
                mysqli_query($conn, $sql);
            }

            $sql ="SELECT `medical.id`, `經`, `緯` FROM `medical`";
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
                $sql="INSERT INTO `medical_distance`(`house.id`, `medical.id`, `medical_distance`) VALUES ('$houseid[0]','$medicalid','$distance')";
                
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
                $sql="INSERT INTO `exercise_distance`(`house.id`, `exercise.id`, `exercise_distance`) VALUES ('$houseid[0]','$exerciseid','$distance')";
                mysqli_query($conn, 'SET NAMES utf8');
                mysqli_query($conn, $sql);
            }
            echo "Accept";
        }
        else{
            echo "資料重複";
        }
    }
    else{
        echo "資料錯誤";
    }
    
?>

