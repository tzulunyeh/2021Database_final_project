<?php 

    include '../config.php';

    error_reporting(0);

    $Email=$_POST['Email'];
    $Password=md5($_POST['Password']);
    

    $sql = "SELECT * FROM manager WHERE `email` ='$Email' AND `password` ='$Password'";


        $result = mysqli_query($conn, $sql);
        $stmt = $conn->prepare($sql);
        if ($result->num_rows > 0) {
            $discussion = [];
            $result = $stmt->execute();
            $result = $stmt->get_result();
            // if(!$row = $result->fetch_assoc()){
            //     array_push($discussion,[
            //         'managerid' => '',
            //         'username' => '',
            //     ]);
            // }
            while ($row = $result->fetch_assoc()) {
                array_push($discussion,[
                    'managerid' => $row['manager.id'],
                    'username' => $row['username']
                ]);
            }

            $response = json_encode($discussion,JSON_UNESCAPED_UNICODE);
            echo $response;
        }
        else
        echo "No account";

?>
