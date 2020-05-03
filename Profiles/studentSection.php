<?php

	if(isset($_SESSION['login_user'])){
?>

<div class="w3-row">

<div class="w3-col l3">
<ul class="w3-ul w3-light-gray">
<div class="w3-margin">You can do</div>
<a href="" style="text-decoration:none;"><li class="w3-round w3-white w3-margin">Check Attendence</li></a>
</ul>
</div>
<div class="w3-col l9 w3-padding w3-white">

<h1 class="w3-margin-bottom w3-margin-top"><b>Hello Student <?php echo $result['Name']?>!</b></h1>

<div class="w3-container w3-border">
<div class="w3-xlarge w3-center">View your attendence</div>
<?php 

$dates = array();
$i=0;
$avgs = array();
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

$subjects = array();
$query1 = "SELECT DISTINCT * FROM `subjects`";
if($data = $conn->query($query1)){
	while($rslt = $data->fetch_assoc()){
		$subjects[$rslt['s_id']] = $rslt['s_name'];
		$i++;
	}
}
else{
	echo "no access";
}
?>










<table class="w3-table-all">
<tr>
<th>Subjects</th>
<?php

foreach($dates as $date){
	echo "<th>$date</th>";
}
?>
</tr>
<tr>
<?php
$stu_id = $result['u_id'];
foreach($subjects as $sub_id => $sub){
	echo "<td><b>$sub</b></td>";
	$avg = 0;
	$total = 0;
	$count = 0;
?>

<?php

foreach($dates as $date){
	$query = "SELECT PorA FROM attendance WHERE a_date = '$date' and sub_id = $sub_id and stu_id= $stu_id";
	
	if($data = $conn->query($query)){
		if($data->num_rows == 0){
			echo "<td>x</td>";
			
		}
		while($rslt= $data->fetch_assoc()){
			echo "<td>".$rslt['PorA']."</td>";

			$total++; // for PorA is 0 as well as 1 for x it won't be here
			$count+=(int)$rslt['PorA'];
			//echo "<script>alert(". $rslt['PorA'] == '1' .")</script>";
			
		}
		
	}
	else{
		echo "x";
	}
	
}
?>
</tr>
<?php
if($total == 0){
		$avg = 0;
	}
	else{
		$avg = ($count/$total)*100;
	}
	echo "<tr><td>Total classes: $total and total attended: $count, so attendence in $sub: ".$avg."%</td></tr>";
}
?>
</table>
<?php
?>
<div></div>
</div>

</div>
</div>


<?php
	}
	else{
		echo "Something went wrong";
	}
?>