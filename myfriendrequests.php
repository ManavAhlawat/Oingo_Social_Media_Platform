<html>
<?php
include('connect.php');
//include('friend_suggest.php');
session_start();


//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$userid =  $_SESSION['UID'];
	//$friend_id = $_GET['UID'];
	$sql1 = "select * from user join friend_list on user.uid=friend_list.UID where Friend_Id='$userid' and Action!='Accepted'";
	$result1 = mysqli_query($con,$sql1) or die("Bad Query");
	//$row1 = mysqli_fetch_assoc($result1);
	$count = mysqli_num_rows($result1);
if($count>0){
	echo "Click the User's name to add as friend<br>";
}
else{
	echo "You have no friend request currently!";
}
	while($row1 = mysqli_fetch_assoc($result1)){
	//echo "You have friend requests to answer to!\n\r";
	echo "<a href ='accept.php?UID=". $row1['UID'] ."'>" . $row1['UserName'] ."<br>";
//}
}
//else {
	//echo "No friend requests!";
	//}
//}
//else {
//	echo "No friends";
//}
//echo "<td><a href = 'friend_request.php?UID=". $row['UID'] ."'>" . $row['UserName'] . "</td>";
/*" <input type=\"submit\" value=\"Add friend\" action=\"accept.php\0">*/
?>
</html>
