<?php
session_start();

//by coming to this page user's login process will get started and so session will get start
if(!isset($_SERVER['HTTPS'] ) )
{
    header("Location:https://keltaking.co/KeltaAttendance");   
}
$_SESSION['login_process'] = "start"; 
?>

<!DOCTYPE html>
<html>
	<head>
		<title>LogIn | KeltaAttendancePortal</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='https://fonts.googleapis.com/css?family=Aleo' rel='stylesheet'>
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://keltaking.co/KeltaAttendance/kel-CSS/kel.css">
		<style>
			.loader {
			  border: 5px solid #f3f3f3;
			  border-radius: 50%;
			  border-top: 5px solid #3498db;
			  width: 30px;
			  height: 30px;
			  -webkit-animation: spin 1s linear infinite; 
			  animation: spin 1s linear infinite;
			}

			@-webkit-keyframes spin {
			  0% { -webkit-transform: rotate(0deg); }
			  100% { -webkit-transform: rotate(360deg); }
			}

			@keyframes spin {
			  0% { transform: rotate(0deg); }
			  100% { transform: rotate(360deg); }
			}
		</style>
	</head>
	<body class="w3-teal">
	<div class="w3-center">
	<h1>KELTA ATTENDANCE PORTAL</h1>
	</div>
		
	<div class="w3-content w3-padding" style="max-width:400px">
	<div class="w3-card w3-hover-shadow " style="margin-top:50px;">
	<div class="w3-light-gray w3-container w3-center w3-animate-fade" style="z-index:2;">
		<div class="w3-padding-16">
			
		<div class="w3-xlarge w3-bold w3-margin-top">LogIn form</div>
		<form class="w3-container w3-center w3-margin" id="login">
		<div class="w3-margin-bottom w3-text-red" >
		<center><div class="loader" id="loader" style="display:none;"></div></center>
		<div id="error"></div>
		</div>
			<img src="https://www.w3schools.com/w3images/avatar3.png" class="w3-circle" alt="User" style="width:50%">
			
			<div class="w3-section">
				<input type="text" class=" w3-padding w3-round-xxlarge w3-border w3-hover-border-black" name="RollNo" placeholder="UserID" style="margin:0;" required><br>
			</div>
			<div class="w3-section">
				<input type="password" class="w3-padding w3-round-xxlarge w3-border w3-hover-border-black" name="password" placeholder="Password" style="margin:0;" required>
			</div>
			<div class="kel-hover-2" onclick="alert('Talk to the admin...')"><u>forgot password?</u></div>
			<div class="w3-section">
				<button type="button" class="kel-button w3-black w3-round w3-padding w3-border-black w3-black" onclick="login()">LogIn</button>
			</div>
			
		</form>
		</div>
	</div>
	</div>
	</div>
	<script src="JS/index.js">
	</script>
	</body>
	
