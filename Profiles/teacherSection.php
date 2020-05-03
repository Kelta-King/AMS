<?php

	if(isset($_SESSION['login_user'])){
?>

<div class="w3-row">

<div class="w3-col l3">
<ul class="w3-ul w3-light-gray">
<div class="w3-margin">You can see</div>
<a href="#" style="text-decoration:none;"><li class="w3-round w3-white w3-margin">Assigned subjects</li></a>
<a href="#attendanceStu" style="text-decoration:none;"><li class="w3-round w3-white w3-margin">Attendence</li></a>
</ul>
</div>
<div class="w3-col l9 w3-padding w3-white">

<h1 class="w3-margin-bottom w3-margin-top"><b>Hello Professor <?php echo $result['Name']?>!</b></h1>

<div class="w3-container w3-border">
<form id="addAttendence" style="margin-right:30px" method="post" action="./action/addAttendence.php">
<div class="w3-center w3-xlarge">Add attendence</div>
<?php
	$t_id = $rslt['u_id'];
	//this query will find the current teacher's enrolled subjects
	$query = "SELECT subjects.s_id, s_name FROM ((sub_teacher INNER JOIN users ON sub_teacher.t_id = users.u_id) INNER JOIN subjects ON sub_teacher.s_id = subjects.s_id ) WHERE users.u_id = $t_id";
	
?>
<select class="w3-select w3-border w3-margin" id="select" name="sub" required>
<option value="">Choose Subject</option>
<?php
$subjects = array();
$i=0;
if($data = $conn->query($query)){
	while($rslt = $data->fetch_assoc()){
		$s_name = $rslt['s_name'];
		$s_id = $rslt['s_id'];
		$subjects[$s_id] = $s_name;
		$i++;
?>
    <option value="<?php echo $rslt['s_id'] ?>"><?php echo $rslt['s_name'] ?></option>
<?php
	}
}
?>
    
</select>
<div class="w3-section w3-margin-left">
<label>Date of Attendence</label>
<input type="date" class="w3-padding-small w3-input w3-border" value="<?php echo date("Y-m-d") ?>" id="date" name="date" required>
</div>

<ul class="w3-ul w3-padding-32 w3-margin-left">

<li class="w3-row w3-blue w3-round">
<span class="w3-col l4">RollNo</span>
<span class="w3-col l6">Name of student</span>
<span class="w3-col l2">Present/Absent</span>
</li>
<?php
$query = "SELECT u_id, Name, RollNo FROM `users` WHERE account_type = 'student'";

if($data = $conn->query($query)){
	
	while($result = $data->fetch_assoc()){
		
?>
<li class="w3-row">
<span class="w3-col l4"><?php echo $result['RollNo'] ?></span>
<span class="w3-col l6"><?php echo $result['Name'] ?></span>
<span class="w3-col l2"><select name="<?php echo $result['u_id'] ?>" required><option disabled >x</option><option value="0" selected>0</option><option value="1">1</option></select></span>
</li>
<?php
	}
}
else{
	echo "something went wrong";
}
?>
</ul>
<div class="w3-section">
<input class="w3-margin-left w3-button kel-hover w3-blue w3-hover-green" type="submit" value="Add Attendence" onclick="addAtten()">
</div>
</form>
</div>
<div class="w3-padding-16" id="attendanceStu"></div>
<div class="w3-container w3-border" >
<div class="w3-center w3-xxlarge">Attendence of students</div>
<select class="w3-select w3-border" style="margin-bottom:20px;margin-top:20px;">
<option class="w3-bar-item w3-button" disabled selected>Select Subject</option>
<?php
foreach($subjects as $sub){
?>
  <option class="w3-bar-item w3-button " onclick="openCity('<?php echo $sub ?>')"><?php echo $sub ?></option>
<?php
}
?>
</select>
<?php
	$students = array();
	$i=0;
	if($data = $conn->query($query)){
		
		while($rslt = $data->fetch_assoc()){
			$students[$i] = $rslt['Name'];
			$i++;
		}
		
	}
	else{
		echo "something went wrong";
	}
	
	$dates = array();
	$i=0;
	$query1 = "SELECT DISTINCT a_date FROM attendance ORDER BY a_date;";
	if($data = $conn->query($query1)){
		while($rslt = $data->fetch_assoc()){
			$dates[$i] = $rslt['a_date'];
			$i++;
		}
	}
	else{
		echo "no access";
	}
	
	$i=0;
	$stu_ids = array();
	$query1 = "SELECT u_id FROM users WHERE account_type = 'student'";
	if($data = $conn->query($query1)){
		while($rslt = $data->fetch_assoc()){
			$stu_ids[$i] = $rslt['u_id'];
			$i++;
		}
	}
	else{
		echo "no access";
	}	
	
	foreach($subjects as $sub_id => $sub){
		
?>
<div>
<div class="subject w3-padding-16 w3-animate-opacity" id="<?php echo $sub;  ?>" style="display:none;">
<div class="w3-xlarge "><?php echo $sub;  ?><span onclick="this.parentElement.parentElement.style.display='none'" class="w3-button w3-xlarge w3-right">&times;</span>
</div>
<div style="overflow-x:auto;" class="w3-margin-top">
<table class="w3-table-all" id="<?php echo $sub ?>" >

<tr class="w3-blue">
<th>Students</th>
<?php
foreach($dates as $date){
?>
	<th><?php echo $date ?></th>
<?php
}
?>
</tr>
<?php 
$j=0;
foreach($students as $student){
?>
<tr>
<td><?php echo $student ?></td>
<?php
	foreach($dates as $date){
		$query = "SELECT PorA FROM attendance WHERE a_date = '$date' and sub_id = $sub_id and stu_id= $stu_ids[$j]";
		if($d = $conn->query($query)){
?>
<td>
<?php
			if($d->num_rows == 0){
				echo "x";
			}
			else{
				while($rslt = $d->fetch_assoc()){
					echo $rslt['PorA'];
				}
			}
			
		}
		else{
			echo "no access";
		}
?>
</td>
<?php
		
	}
	$j++;
	
?>
</tr>
<?php
}
?>
</table>
</div>
<button class="w3-button kel-hover w3-blue w3-margin" onclick = "convertSheet('<?php echo $sub ?>', 'xlsx')">Convert</button>

</div>
</div>
<?php
	    
	}
?>

</div>

<div class="w3-padding-32"></div>
</div>

</div>
<script type="text/javascript" src="https://oss.sheetjs.com/sheetjs/xlsx.full.min.js"></script>
<script src="./JS/teacherSection.js"></script>
<?php
	}
	else{
		echo "Something went wrong";
	}
?>