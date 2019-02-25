<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
include("connect.php");
//include("geocode.php");
session_start(); 


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$userid =  $_SESSION['UID'];
	$note = mysqli_real_escape_string($con, $_POST['Note']);
	$permission = mysqli_real_escape_string($con, $_POST['Permission']);
    $tag = mysqli_real_escape_string($con, $_POST['Tags']);
	$start_date = $_POST["Date1"];
	$end_date = $_POST["Date2"];
	$start_time = $_POST["Time1"];
	$end_time = $_POST["Time2"];
	$recur = mysqli_real_escape_string($con, $_POST['Repeat']);
	$day = mysqli_real_escape_string($con, $_POST['Days']);
	$user_state = mysqli_real_escape_string($con, $_POST['UserState']);
	$allow_comments = mysqli_real_escape_string($con, $_POST['comm_perm']);
	//Using prepared statement to guard against sql injection
	$sql5 = $con->prepare('INSERT INTO user_state(UID,UserState) Values (?,?)');
	$sql5->bind_param('ss',$userid,$user_state);
	$sql5->execute();
	$sql2 = $con->prepare('INSERT INTO tag(TagName)  Values (?)');
	$sql2->bind_param('s',$tag);
	$sql2->execute();
	//$con->query($sql2);
	$lastid_tag = mysqli_insert_id($con);
	//Using prepared statement to guard against sql injection
	$sql3 = $con->prepare('INSERT INTO Schedule(Start_Date,End_Date,Start_Time,End_Time,Recurring,Day_of_week) Values (?,?,?,?,?,?)');
	$sql3->bind_param('ssssss',$start_date,$end_date,$start_time,$end_time,$recur,$day);
	$sql3->execute();
	$last_id = mysqli_insert_id($con);
	//$sql4 = "Select SchID from Schedule where Schedule.Start_date='$start_date' and SCHEDULE.End_Date='$end_date' and schedule.Start_Time='$start_time' and schedule.End_Time='$end_time' and schedule.Recurring='$recur' and schedule.Day_of_week='$day'";
	//$result = mysqli_query($con,$sql4) or die("Bad Query");
	 /*echo "<table align='center' border='1'>";
	echo "<tr><th>SchID</th></tr>";
	while($row = mysqli_fetch_assoc($result))
	{
		echo "<tr>";
		echo "<td>" . $row['SchID'] . "</td>";
		
		
		
		
		echo "</tr>";
	}
	echo "</table>";*/
	//$row= mysqli_fetch_row($result);
	//$string = implode('',$row);
	$sql1 = "INSERT INTO Note(NoteID,SchID,NoteContent,UID,locid,Shared_With,TimeStamp,Are_comments_allowed)  Values  (default,'$last_id','$note','$userid',6,'$permission',now(),'$allow_comments')";
	$con->query($sql1);
	//$sql7 = "Select NoteID from Note where Note.SchID ='$last_id' and Note.NoteContent= '$note' and Note.UID= '$userid' and Note.Shared_With='$permission' and Note.Are_comments_allowed='$allow_comments'";
	$lastid = mysqli_insert_id($con);
	//$result1 = mysqli_query($con,$sql7) or die("Bad Query");
	//$row1= mysqli_fetch_row($result1);
	//$sql8= "Select tagID from Tag where Tag.tagname='$tag'";
	//$result2 = mysqli_query($con,$sql8) or die("Bad Query");
	//$row2= mysqli_fetch_row($result2);
	//Using prepared statement to guard against sql injection
	$sql6 = $con->prepare('INSERT INTO note_tag (NoteID,TagID) Values (?,?)');
	$sql6->bind_param('ss',$lastid,$lastid_tag);
	$sql6->execute();
	//$sql3 = "INSERT INTO user_state(UID,UserState) values ("$_SESSION['UID']",)"
	//mysql_query($sql4);
	//mysql_query($con, $sql2);
	/*if ($con->query($sql2) === true && $con->query($sql3) === true && $con->query($sql1) === true )
	{
		echo "Note Posted";
		//$_SESSION['message'] = "Note posted";
	}	
	else{
		$_SESSION['message'] = "Note could not be posted";
	}*/
}
else{
	echo "Fill the details";
}
?>
<style>
* {box-sizing: border-box;}

body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background-color: #e9e9e9;
}

.topnav a {
  float: left;
  display: block;
  color: black;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #2196F3;
  color: white;
}

.topnav .search-container {
  float: right;
}

.topnav input[type=text] {
  padding: 6px;
  margin-top: 8px;
  font-size: 17px;
  border: none;
}

.topnav .search-container button {
  float: right;
  padding: 6px 10px;
  margin-top: 8px;
  margin-right: 16px;
  background: #ddd;
  font-size: 17px;
  border: none;
  cursor: pointer;
}

.topnav .search-container button:hover {
  background: #ccc;
}

@media screen and (max-width: 600px) {
  .topnav .search-container {
    float: none;
  }
  .topnav a, .topnav input[type=text], .topnav .search-container button {
    float: none;
    display: block;
    text-align: left;
    width: 100%;
    margin: 0;
    padding: 14px;
  }
  .topnav input[type=text] {
    border: 1px solid #ccc;  
  }
}
</style>
</head>
<body>

<div class="topnav">
  <a class="active" href="#home">Home</a>
  <a href="friendList.php">My Friends</a>
  <a href="filter.php">Search Notes</a>
  <a href="PreviousNotes.php">My Previous Notes</a>
  <a href="Friend_suggest.php">Friend Suggestions</a>
  <a href="myfriendrequests.php">Friend Requests</a>
  <div class="search-container">
    <form action="/action_page.php">
      <input type="text" placeholder="Search.." name="search">
      <button type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>
</div>
<div align="right"> <a align = " left" href = "logout.php">Sign Out</a>
</div>
<div style="padding-left:16px">
  <h2>Welcome <span class="user"><?= $_SESSION['username'] ?> </span></h2>
</div>
<form class="form" action="welcome.php" method="post" enctype="multipart/form-data" autocomplete="off" align="middle">
      <h1> Post a note here</h1>
	  <br><input align="middle" type = "text" placeholder="Write a note.." name="Note">
	  <br><br><br>Tags<select name="Tags" multiple>
  <option value="#fun">#Fun</option>
  <option value="#food">#Food</option>
  <option value="#me">#Me</option>
  <option value="#tourism">#Tourism</option>
</select>
	
How do you feel?<input align="middle" type = "text" placeholder="Hungry?" name="UserState">
	  <br><br>
	  Schedule:
	  Start Date<input type="date" name="Date1" value="<?php echo date('Y-m-d'); ?>"></input>
	  End Date<input type="date" name="Date2" value="<?php echo date('Y-m-d'); ?>"></input>
	  Start Time<input type="time" name="Time1" value="08:56"></input>
	  End Time<input type="time" name="Time2" value="18:30"></input>
	  <br><br>Repeat:<select name=Repeat>
  <option value="Weekly">Weekly</option>
  <option value="Daily">Daily</option>
  <option value="Monthly">Monthly</option>
  <option value="Biweekly">Biweekly</option>
</select>

Days<select name=Days>
  <option value="Monday">Monday</option>
  <option value="Tuseday">Tuesday</option>
  <option value="Wednesday">Wednesday</option>
  <option value="Thursday">Thursday</option>
</select>
Share with:<select name=Permission>
<option value="Friends">Friends</option>
<option value="Public">Public</option>
</select>
Allow comments?<select name=comm_perm>
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
      <br><br><input type="submit" value="Post" name="note"><br>

    </form>

	<p>Click the button to get your coordinates.</p>

<button onclick="getLocation()">Try It</button>

<p id="demo"></p>

<script>
var x = document.getElementById("demo");

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    x.innerHTML = "Latitude: " + position.coords.latitude + 
    "<br>Longitude: " + position.coords.longitude;
}
</script>
</body>
</html>
