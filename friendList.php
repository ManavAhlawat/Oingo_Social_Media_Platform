<?php
include('connect.php');
session_start();

//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$userid =  $_SESSION['UID'];
	$sql = "Select username from user where uid in (select friend_id from friend_list where uid='$userid' and Action='Accepted' union select uid from friend_list where Friend_Id='$userid' and Action='Accepted')";
	$result = mysqli_query($con,$sql) or die("Bad Query");
	//$row = mysqli_fetch_assoc($result);
	echo "<br>";
	echo "<table align='center' border='1'>";
	echo "<tr><th>Friends</th></tr>";
	while($row = mysqli_fetch_assoc($result))
	{
		echo "<tr>";
		echo "<td>" . $row['username'] . "</td>";
		echo "</tr>";
	}
	echo "</table>";
//}
//else {
//	echo "No friends";
//}
?>