<?php
include('connect.php');
session_start();

//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$userid =  $_SESSION['UID'];
	$sql = "SELECT * FROM USER where UID!='$userid'";
	$result = mysqli_query($con,$sql) or die("Bad Query");
	//$row = mysqli_fetch_assoc($result);
	echo "<br>";
	echo "<table align='center' border='1'>";
	echo "<tr><th>Friend Suggestions</th></tr>";
	while($row = mysqli_fetch_assoc($result))
	{
		echo "<tr>";
		echo "<td><a href = 'friend_request.php?UID=". $row['UID'] ."'>" . $row['UserName'] . "</td>";
		echo "</tr>";
		
	}
	echo "</table>";
//}
//else {
//	echo "No friends";
//}
?>
