<?php 
	require_once'header.php';
	
	echo "<div class='main'><h3>Please enter your details to log in</h3>";
	$error = $user = $pass="";
	
	if (isset($_POST['user']))
	{
		$init_input = sanitizeString($_POST['user']);
		$user = hash("sha256",hash("whirlpool",$_POST['user']."a+&%$^ERGj"));
		$pass = hash("sha256",hash("whirlpool",$_POST['pass']."r2y87r*^%.")).hash("whirlpool",$_POST['user']."ashfiwue$3!@RGj");
		
		if ($user==""||$pass=="")
			$error = "Not all fields were entered";
		else
		{
			$result = queryMysql("SELECT USERNAME, USER_PASSWORD,ID FROM users
				WHERE USERNAME = '$user' AND USER_PASSWORD='$pass'");
			$row = $result->fetch_array(MYSQLI_ASSOC);
			if ($result->num_rows == 0)
			{
				$error = "<span class='error'>Username/Password invalid</span><br><br>";
			}
			else 
			{
				
				$_SESSION['USERNAME'] = $user;
				$_SESSION['USER_PASSWORD'] = $pass;
				//$user_id = $row['ID']; 
				/*
				$user_password="H5ga46ifT6b9WnOBr37";
        $user_id="xY1lMkT98InS4C7DFHAKuhguire78u387yhfdi".$user_password;*/
				die("You are logged in. Please <a href='vocab.php'>".
				"click here</a> to continue.<br><br>");
			}
		}
	}
	echo "
	<br>
	<form method='post' action='login.php'>$error
	<span class='fieldname'>Username:</span><input type='text' maxlength='50' name= 'user' placeholder='abcd' class='form-signup1'><br>
	<span class='fieldname'>Password:</span><input type='password' maxlength='50' name='pass' placeholder='*********' class='form-signup1'>
	";
?>
<br>
<span class='fieldname'>&nbsp;</span>
<input type='submit' value='Login'>
</form> <br></div>
</body>
</html>