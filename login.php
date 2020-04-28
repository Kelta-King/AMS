<?php

	session_start();
	function test_input($data) 
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	if(isset($_SESSION['login_user']) && isset($_SESSION['login_process'])){
		
		$user = test_input($_SESSION['login_user']);
		
		//distinguish the session string in two parts of RollNo and account type
		$user = explode("&",$user);
		$RollNo = $user[0];
		$usertype = $user[1];
		$uid = (int)"";
		$query1 = "SELECT u_id FROM `users` WHERE RollNo = $RollNo";

		// please note %d in the format string, using %s would be meaningless
		$query1 = sprintf("SELECT u_id FROM `users` WHERE RollNo = %d", $RollNo);

		require_once('database/dbconnect.php');
		
		//echo $query1;
		if($data = $conn->query($query1)){
			while($result = $data->fetch_assoc()){
				$uid = $result['u_id'];
			}
			
			//in url uid and account type will go
			//in session userrid and accounttype will go
			$AMNqrutid = base64_encode($uid); // uid
			$MNPrtypre = base64_encode($usertype); //accounttype
			//making a unique url and not understandable url
			header("Location:home?AMNqrutid=$AMNqrutid&MNPrtypre=$MNPrtypre");
			//unset the login process session
			unset($_SESSION['login_process']);
		}
		else{
			echo 'Something went wrong';
			//directly logout and try again, we cannot let them be on this page
			header('Location:http://keltaking.co/KeltaAttendance/logout');
		}
		
		$conn->close();
		
	}

?>
