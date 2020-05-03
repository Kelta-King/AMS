<?php

	// to add a student just remember that password's limit is 4 characters and same for userID

	if(isset($_SESSION['login_user']))
	{
		
?>
 
<div class="w3-row">
<div class="w3-col l3 w3-padding w3-light-gray">
<ul class="w3-ul w3-light-gray">
<div class="w3-margin">Admin can do</div>
<li class="w3-round w3-white w3-margin">See Users</li>
<a href="#AddUser" style="text-decoration:none;"><li class="w3-round w3-white w3-margin">Add/remove</li></a>
</ul>
</div>

<div class="w3-col l9 w3-padding w3-white">
<h1 class="w3-margin-bottom w3-margin-top"><b>Hello <?php echo $result['Name']?>!</b></h1>


<ul class="w3-ul w3-border">
<div class="w3-center w3-xlarge">
All Users list
</div>
<center><div id="loader" class="loader w3-margin-top" style="display:none;"></div><center>
<li class="w3-round w3-margin w3-row w3-blue"><span class="w3-col l3">RollNo</span><span class="w3-col l3">Name</span><span class="w3-col l3">AccountType</span><span class="w3-col l3">Operation</span></li>

<?php
$query3 = "SELECT u_id, RollNo, Name, account_type FROM `users` WHERE u_id > 1";
//displaying all users to admin, admin can remive them...
if($data = $conn->query($query3)){
	
	while($rslt = $data->fetch_assoc()){
		
?>

<li class="w3-round w3-white w3-margin w3-row"><span class="w3-col l3"><?php echo $rslt['RollNo'] ?></span><span class="w3-col l3"><?php echo $rslt['Name'] ?></span><span class="w3-col l3"><?php echo $rslt['account_type'] ?></span><span class="w3-col l3"><button class="kel-hover w3-hover-red w3-button w3-blue" onclick="remove(<?php echo $rslt['u_id'] ?>)">Remove</button></span></li>

<?php		

	}
	
}
//failiure of query
else{
	echo "Somehting went wrong";
}


?>


</ul>
<!-- add section -->

<div class="w3-border w3-margin-bottom w3-margin-top" id="AddUser">

<form class="w3-container w3-margin-right w3-margin-bottom" name="add">
  <h1>Fill this form to add a user</h1>
	<center><div id="loader2" class="loader w3-margin-top" style="display:none;"></div><center>

	<div class="w3-row-padding w3-padding-16">
		<div class="w3-half">
			<input class="w3-input w3-border" type="text" name="fname" placeholder="FirstName" required>
		</div>
		<div class="w3-half">
			<input class="w3-input w3-border" type="text" name="lname" placeholder="LastName" required>
		</div>	
	</div>
	<div class="w3-section w3-margin">
		<input class="w3-input w3-border" placeholder="RollNo" name="RollNo" required>
	</div>
  <select class="w3-select w3-border w3-margin" id="select" name="acc_type" required>
    <option value="" disabled selected>AccountType</option>
    <option value="student">Student</option>
    <option value="teacher">Teacher</option>
  </select>

  <p><button class="kel-hover w3-button w3-hover-blue w3-blue w3-margin-left" type="button" onclick="adduser()">Add user</button></p>
</form>

</div>

<div class="w3-border w3-margin-bottom" id="AddSubject">

<form class="w3-container w3-margin-right w3-margin-bottom" name="addSub">
  <h1>Fill this form to add a Subject</h1>
	<center><div id="loader3" class="loader w3-margin-top" style="display:none;"></div><center>

	
	<div class="w3-section w3-margin">
		<input class="w3-input w3-border" placeholder="Subject" name="subject" required>
	</div>
  
  <p><button class="kel-hover w3-button w3-hover-blue w3-blue w3-margin-left" type="button" onclick="addsubject()">Add Subject</button></p>
</form>

</div>

<ul class="w3-ul w3-border">
<div class="w3-center w3-xlarge">
All Subjects list
</div>
<center><div id="loader4" class="loader w3-margin-top" style="display:none;"></div><center>
<li class="w3-round w3-margin w3-row w3-blue"><span class="w3-col l3">Sub_id</span><span class="w3-col l6">Name</span></li>

<?php
$query4 = "SELECT * FROM `subjects`";
//displaying all users to admin, admin can remive them...
if($data = $conn->query($query4)){
	
	while($rslt = $data->fetch_assoc()){
		
?>

<li class="w3-round w3-white w3-margin w3-row"><span class="w3-col l3"><?php echo $rslt['s_id'] ?></span><span class="w3-col l3"><?php echo $rslt['s_name'] ?></span><button class="kel-hover w3-hover-red w3-button w3-blue" onclick="removeSub(<?php echo $rslt['s_id'] ?>)">Remove</button></span></li>

<?php		

	}
	
}
//failiure of query
else{
	echo "Somehting went wrong";
}


?>


</ul>

<form class="w3-container w3-row w3-margin-right w3-margin-bottom" name="addRelation">
  <h1>Fill this form to add a Subject To a teacher</h1>
	<center><div id="loader5" class="loader w3-margin-top" style="display:none;"></div><center>

	<select class="w3-select w3-col l6 w3-border w3-margin" id="selectTeacher" name="acc_type" required>
		<option value="" disabled selected>Teacher Name</option>
<?php
	$query = "SELECT u_id, Name FROM `users` WHERE account_type = 'teacher'";
	
	if($data = $conn->query($query)){
		if($data->num_rows > 0){
			
			while($result = $data->fetch_assoc()){
?>
	<option value="<?php echo $result['u_id'] ?>"><?php echo $result['Name'] ?></option>
<?php
				
			}
			
		}
		else{
			echo "no teachers";
		}
?>
		
<?php
	}
	else{
		echo "something went wrong";
	}
?>
	</select>
	
	<select class="w3-select w3-col l5 w3-border w3-margin" id="selectSub" name="acc_type" required>
		<option value="" disabled selected>Subject</option>
<?php
	$query = "SELECT * FROM `subjects`";
	
	if($data = $conn->query($query)){
		if($data->num_rows > 0){
			
			while($result = $data->fetch_assoc()){
?>
	<option value="<?php echo $result['s_id'] ?>"><?php echo $result['s_name'] ?></option>
<?php
				
			}
			
		}
		else{
			echo "no subjects";
		}
?>
		
<?php
	}
	else{
		echo "something went wrong";
	}
?>
	</select>
	
  
  <p><button class="kel-hover w3-button w3-hover-blue w3-blue w3-margin-left" type="button" onclick="addrelation()">Add Relation</button></p>
</form>

</div>

	
</div>
<script src="./JS/adminSection.js">

</script>
<?php 
	}
	else{
		echo "<div class='loader'></div>";
					echo "You are not authorized to access this page";
					
					header('refresh:1; url=http://localhost:8080/KeltaAttendance/logout.php');
					
	}
?>