<?php 

	include '../config.php';

	error_reporting(0);

	$UserName=$_POST['UserName'];
	$Email=$_POST['Email'];
	
	$Password=md5($_POST['Password']);
	$SecondConfirm=md5($_POST['SecondConfirm']);
	$Password1 = md5("");
	$SecondConfirm1 = md5("");

	if($UserName=='' || $Email=='' || $Password==$Password1 || $SecondConfirm==$SecondConfirm1){
		echo "<script>alert('YOU CAN REGISTER NOW!')</script>";
	}
	else{
		if ($Password == $SecondConfirm){
			$sql = "SELECT * FROM manager WHERE username='$UserName'";
			$result = mysqli_query($conn, $sql);
			if (!$result->num_rows > 0) {

				$sql = "SELECT * FROM `manager` ORDER BY `manager.id` DESC LIMIT 0 , 1";
				$result = mysqli_query($conn, $sql);
				$managerid = mysqli_fetch_row($result);
				$managerid[0] = substr($managerid[0],1);
				$managerid[0]=intval($managerid[0])+1;
				$managerid[0]='M'.strval($managerid[0]);
				

				$sql = "INSERT INTO manager (`manager.id`,`email`, `username`, `password`)
						VALUES ('$managerid[0]','$Email', '$UserName', '$Password')";
				
				$result = mysqli_query($conn, $sql);
				if ($result) {
					echo "<script>alert('Wow! User Registration Completed.')</script>";
				} else {
					echo "<script>alert('Woops! Something Went Wrong.')</script>";
				}
			} else {
				echo "<script>alert('Woops! account Already Exists.')</script>";
			}
		}
	
	
		
	}

?>