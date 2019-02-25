<?php
include('connect.php');
//include('friend_suggest.php');
session_start();


//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$userid =  $_SESSION['UID'];
	$friend_id = $_GET['UID'];
	
	//echo $userid. ":" . $friend_id;
	$sql1 = "Update friend_list set Action='Accepted' where Friend_Id=$userid and UID=$friend_id";
	//$result1 = mysqli_query($con,$sql1) or die("Bad Query");
	//$row1 = mysqli_fetch_assoc($result1);
	//$sql = "Insert into friend_list(UID,Friend_Id,Action) Values ('$userid','$friend_id','Request_Sent')";
	//$result = mysqli_query($con,$sql) or die("Bad Query");
if($con->query($sql1) === True){
	echo "Added as friend";
}
else {
	echo "Could not add friend";
	}
//}
//else {
//	echo "No friends";
//}
?>
