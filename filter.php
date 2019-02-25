<!doctype html>
<html>
<head>
<body>
<h1>Apply filter to search for notes</h1>
<form class="form" action="filter.php" method="post" enctype="multipart/form-data" autocomplete="off" align="middle">
	  <br><br><br>Tags<select name="Tags" multiple>
  <option value="#fun">#Fun</option>
  <option value="#food">#Food</option>
  <option value="#me">#Me</option>
  <option value="#tourism">#Tourism</option>
</select>
How do you feel?<input align="middle" type = "text" placeholder="Hungry?" name="UserState">
	  <br><br>
	  Schedule:
	  Select Date<input type="date" name="Date1" value="<?php echo date('Y-m-d'); ?>"></input>
	  Select Time<input type="time" name="Time1" value="08:56"></input>

Find notes from:<select name=Permission>
<option value="Friends">Friends</option>
<option value="Public">Public</option>
</select>
Find notes in what radius?<input type="number" name="quantity" min="1" max="5">kms</input>
      <br><br><input type="submit" value="Search" name="note"><br>

    </form>



<?php
include('connect.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$userid =  $_SESSION['UID'];
	$tag = mysqli_real_escape_string($con, $_POST['Tags']);
	$sql8= "Select tagID from Tag where Tag.tagname='$tag'";
	$result2 = mysqli_query($con,$sql8) or die("Bad Query");
	$row2= mysqli_fetch_row($result2);
	$user_state = mysqli_real_escape_string($con, $_POST['UserState']);
	$permission = mysqli_real_escape_string($con, $_POST['Permission']);
	$select_date = $_POST["Date1"];
	$select_time = $_POST["Time1"];
	$radius = $_POST["quantity"];
	$sql ="INSERT INTO filter (filter_id,uid,tagid,userstate,user_type,date,time,current_latitude,current_longitude,radius_of_interest) values (default,'$userid',".$row2[0].",'$user_state','$permission','$select_date','$select_time',0.70947638,-1.29067093,5)";
	$con->query($sql);
	$sql2 ="SELECT note.notecontent from note join note_tag join user_state on note.NoteID=note_tag.NoteID and note.UID=user_state.UID where note_tag.tagid=".$row2[0]." and user_state.UserState='$user_state' and note.Shared_With='$permission'";
    $result = mysqli_query($con,$sql2) or die("Bad Query");
	//$row = mysqli_fetch_assoc($result);
	echo "<br>";
	echo "<table align='center' border='1'>";
	echo "<tr><th>Note</th></tr>";
	while($row = mysqli_fetch_assoc($result))
	{
		echo "<tr>";
		echo "<td>" . $row['notecontent'] . "</td>";
		echo "</tr>";
	}
	echo "</table>";
}
else {
	echo "not yet applied filter";
}
?>
</body>
</head>
</html>
