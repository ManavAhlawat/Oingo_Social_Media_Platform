<!doctype html>
<html>
<head>
<body style="background-color:white">
<?php
include('connect.php');
session_start();
$_SESSION['message']='session started';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	//to make sure two passwords are equal to each other
	if ($_POST['Password'] == $_POST['ConfirmPassword']) {
		$username = mysqli_real_escape_string($con, $_POST['UserName']);
		$email = mysqli_real_escape_string($con, $_POST['Email']);
		//$password = md5($_POST['Password']);//md5 hash password security
		$password = mysqli_real_escape_string($con, $_POST['Password']);
		$_SESSION['UserName'] = $username;
		
		$sql = "insert into user(UserName,Email,Password) VALUES ('$username','$email','$password')";
	
		if ($con->query($sql) == true) {
			$_SESSION['message'] = 'Sign Up successful! Added user to the database!';
			header("location: login.php");
		}
		else {
			$_SESSION['message'] = "User could not be added to the database!";
		}
	}
	else {
		$_SESSION['message'] = "Two passwords did not match";
	}
}
else {
	$_SESSION['message'] = "Fill in the details below to sign up to Oingo!";
}
?>

<div class="body-content" align="center" style="background-color:lightblue" style="display:block" style="width:10px">
	<div class="module">
		<h1>Create an account</h1>
		<form class="form" action="OingoSignUp.php" method="post" enctype="multipart/form-data" autocomplete="off">
			<div class="alert alert-error"><?= $_SESSION['message'] ?></div><br><br>
			<input type="text" placeholder="User Name" name="UserName" required /><br><br>
			<input type="email" placeholder="Email" name="Email" required /><br><br>
			<input type="password" placeholder="Password" name="Password" autocomplete="new-password" required /><br><br>
			<input type="password" placeholder="Confirm Password" name="ConfirmPassword" autocomplete="new-password" required /><br><br>
			<input type="submit" value="Sign Up" name="SignUp" style="background-color:pink"/><br><br>
			Already a member? <a href = "login.php">Log in</a> here
		</form>
	</div>
</div>	

</body>
</head>
</html>
