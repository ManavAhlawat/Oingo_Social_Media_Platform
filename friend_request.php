<?php
include('connect.php');
//include('friend_suggest.php');
session_start();


//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$userid =  $_SESSION['UID'];
	$friend_id = $_GET['UID'];
	$sql1 = "SELECT UID FROM USER";
	$result1 = mysqli_query($con,$sql1) or die("Bad Query");
	$row1 = mysqli_fetch_assoc($result1);
	$sql = "Insert into friend_list(UID,Friend_Id,Action) Values ('$userid','$friend_id','Request_Sent')";
	//$result = mysqli_query($con,$sql) or die("Bad Query");
if($con->query($sql)){
	echo "Request sent";
}
else {
	echo "Request not sent";
	}
//}
//else {
//	echo "No friends";
//}
?>
