<?php

    include '../config.php';
    set_time_limit(0);
    
    $ginwai=[];

    function getDistance($addressFrom){
        // Google API key
        $apiKey = 'AIzaSyA0Ow288BsU4CDD7Y12DplzTqTr7mj_Tts';
        
        // Change address format
        $formattedAddrFrom    = str_replace(' ', '+', $addressFrom);
        
        
        // Geocoding API request with start address
        $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$apiKey);
        $outputFrom = json_decode($geocodeFrom);
        if(!empty($outputFrom->error_message)){
            return $outputFrom->error_message;
        }
        
        // Get latitude and longitude from the geodata
        $latitudeFrom    = $outputFrom->results[0]->geometry->location->lat;
        $longitudeFrom    = $outputFrom->results[0]->geometry->location->lng;

        return array($latitudeFrom,$longitudeFrom);

    }

    $sql = "SELECT * FROM house NATURAL JOIN area";
    mysqli_query($conn, 'SET NAMES utf8');
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();
    $result = $stmt->get_result();
    $discussion = [];
    while ($row = $result->fetch_assoc()) {
        $addressFrom=urlencode($row['縣市'].$row['區'].$row['里'].$row['address']);
        $ginwai=getDistance($addressFrom);
        $houseid = $row['house.id'];
        $name = $row['name'];
        $price = $row['price'];
        $areaid = $row['area.id'];
        $address = $row['address'];
        $pin = $row['坪'];
        $room = $row['房'];
        $living = $row['廳'];
        $bath = $row['衛'];
        $age = $row['屋齡'];
        $floor = $row['樓層'];
        $sum_floor = $row['總樓數'];
        $parking = $row['停車位'];
        $case = $row['建案'];
        $link = $row['link'];

        $sql="INSERT INTO `house_copy`(`house.id`, `name`, `price`, `area.id`, `address`, `坪`, `房`, `廳`, `衛`, `屋齡`, `樓層`, `總樓數`, `停車位`, `建案`, `link`, `經`, `緯`) VALUES ('$houseid','$name','$price','$areaid','$address','$pin','$room','$living','$bath','$age','$floor','$sum_floor','$parking','$case','$link','$ginwai[1]','$ginwai[0]')";
        mysqli_query($conn, 'SET NAMES utf8');
        mysqli_query($conn, $sql);

        echo $sql,'<br>';
        echo "Accept",'<br>';
    }

?>