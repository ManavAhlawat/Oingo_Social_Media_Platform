<html>
   
<head>
<?php
include("connect.php");
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST")//to check if username and password are sent from the form
{
	$username = mysqli_real_escape_string($con,$_POST['UserName']);
	$password = mysqli_real_escape_string($con,$_POST['Password']);
	
	$sql = "Select * from user where UserName= '$username' and Password= '$password'";
	$result = mysqli_query($con,$sql) or die("Bad Query");
	$row= mysqli_fetch_array($result,MYSQLI_ASSOC);
	//$active = $row['active'];
	
	$count = mysqli_num_rows($result);
	
	if($count == 1 and $row['UserName'] == $username and $row['Password'] == $password)
	{
		//session_register("Username");
		//$_SESSION['login_user'] = $username;
		$_SESSION['message'] = "Successfully logged in $username";
		$_SESSION['username'] = "$username";
		$_SESSION['UID'] = $row['UID'];
		header ("location: welcome.php");
		//echo "Login Success";
	}
	else
	{
		echo "Invalid username or password";
	}
}
else{
	echo "Please fill in the credentials!";
}
?>

      <title>Login Page</title>
      
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         .box {
            border:#666666 solid 1px;
         }
      </style>
      
   </head>
   
   <body bgcolor = "#FFFFFF">
	
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
				
            <div style = "margin:30px">
               
               <form action = "login.php" method = "post">
                  <label>UserName  :</label><input type = "text" name = "UserName" class = "box"/><br /><br />
                  <label>Password  :</label><input type = "password" name = "Password" class = "box" /><br/><br />
                  <input type="submit" value="Log In" name="LogIn" style="background-color:pink"/><br><br>
               </form>
               
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"></div>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>