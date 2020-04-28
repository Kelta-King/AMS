<?php
    session_start();


	include("Commen/header.php");
	// in home.php everything will work according to account type and uid 
	//of user, not userid of user. We will fetch that as well using uid
	//this is for security purpose

	function test_input($data) 
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	if(isset($_SESSION['login_user']))
	{
		
		$user = test_input($_SESSION['login_user']);
		
		//distinguish the session string in two parts of RollNo and account type
		$user = explode("&",$user);
		$RollNo = $user[0]; //RollNo from session
		$usertype = $user[1];
		
		$urluid = $_REQUEST['AMNqrutid']; 
		//uid of url both url and session id will not be same like roll no and db entry number
		$urlusertype = $_REQUEST['MNPrtypre'];
		
		$urluid = base64_decode($urluid);
		$urlusertype = base64_decode($urlusertype);
		
		$query1 = "SELECT * FROM `users` WHERE u_id = $urluid";
		$query1 = sprintf("SELECT * FROM `users` WHERE u_id = %d", $urluid);

		require_once('database/dbconnect.php');
		
		if($data = $conn->query($query1)){
			
			while($rslt = $data->fetch_assoc()){
				if($rslt['RollNo'] != $RollNo || $usertype != $urlusertype){
					echo "<div class='loader'></div>";
					echo "You are not authorized to access this page";
					echo "";
?>
	<script>alert('You are not authorized to access this page')</script>	
<?php
					$_SESSION['login_process'] = "start"; 
					header('refresh:1; url=https://keltaking.co/KeltaAttendance/login');
					
				}
				//if both are same then only user can access this page esle user will redirect to login.php and then again to home.php
				else{
					
					if($data = $conn->query($query1)){
			
						while($result = $data->fetch_assoc()){
					
?>

<?php
//-----------Admin Section section-----------//	
	if($result['account_type'] == "admin"){
	//html code for amdmin account

	require("Profiles/adminSection.php");






//-----------Teacher section-----------//	
	}
	else if($result['account_type'] == "teacher"){
	//html code for teacher account
	require("Profiles/teacherSection.php");

?>








<?php
//-----------Student section-----------//	
	}
	else if($result['account_type'] == "student"){
	//html code for student account
	require("Profiles/studentSection.php");

?>

	

<?php
		
	}

?>
	


<?php					
					
					
						}
					}
			
				}
			
			}	
		}
		else{
			echo "no";
		}
		
		$conn->close();
	}
	else{
		echo "Login first...";
		header("url=http://keltaking.co/KeltaAttendance/logout");
	}
	
	require("Commen/footer.php");
	
?>
</body>
</html>
