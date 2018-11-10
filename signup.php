<?php
	
	require_once'header.php';
	
	echo '
	<script>
	function checkUser(user)
	{
	   if (user.value=="")
	   {
			0("info".innerHTML=""
			return
	   }
	   params = "users"+user.value
	   request = new ajaxRequest()
	   request.open("POST". "checkuser.php",true)
	   request.setRequestHeader("Content-type",
	   "application/x-www-form-urlencodeed")
	   request.setRequestHeader("Content-length",params.length)
	   request.setRequestHeader("Connection","close")
	   
	   request.onreadystatechange = function()
	   {
			if (this.readyState==4)
				if (this.status==200)
					if (this.responseText!=null)
						0("info")innerHTML= this.responseText
	   }
	   request.send(params)
	}
	
	function ajaxRequest()
	{
		try { var request = new XHLHttpRequest()}
		
		catch(e1){
		try{request = new ActiveXObject("Msxml2.XMLHTTP")}
		catch(e2){
		try {try request = new ActiveXObject("Microsoft.XMLHTTP")}
		catch(e3){
		request = false
		}}}
		return request
	}
</script>
<div class="main" ><h3>Please enter your details to sign up</h3>
	';
	
	$error = $user = $pass ="";
	if (isset($_SESSION['user'])) destroySession();
	
	if (isset($_POST['user']))
	{
		$init_input = sanitizeString($_POST['user']);
		$user = hash("sha256",hash("whirlpool",$_POST['user']."a+&%$^ERGj"));
		$pass = hash("sha256",hash("whirlpool",$_POST['pass']."r2y87r*^%.")).hash("whirlpool",$_POST['user']."ashfiwue$3!@RGj");
		
		$firstname = sanitizeString($_POST['firstname']);
		$lastname = sanitizeString($_POST['lastname']);
		$city = sanitizeString($_POST['city']);
		$email = sanitizeString($_POST['email']);
		
		if ($user==""||$pass=="")
			$error="Not all required fields were entered<br><br>";
		else 
		{
			$result = queryMysql("SELECT *FROM users WHERE USERNAME = '$user'");
			
			if ($result->num_rows)
				$error="<script>alert('Your chosen username already exists');</script><br><br>";
			else 
			{
				$idcreated = RandomString(255,256);
				$timenow=time();
				queryMysql("INSERT INTO users VALUES('','$user','$pass','$firstname','$lastname','$email','$idcreated','','$city','$timenow','1','$init_input')");
				die("<h4>Account created<h4>Please log in<br><br>");
			}
		}
	}
	/*echo "
	<form method='post' action='signup.php'>$error
	<span class='fieldname'>Username: </span>
	<input type='text' maxlength='30' name = 'user' placeholder='abcd' value='' onBlur='checkUser(this)'>
	<span id='info'></span><br>
	<span class='fieldname'>Password: </span>
	<input type='text' maxlength='30' name='pass' placeholder='dcba' value=''><br>
	";*/
	//New form------------------------------------------
	echo "<br><br><form id='identicalForm' action='signup.php' method='post'>
  <div class='form-row'>
    <div class='form-group'>
      <!--<label>Firstname(optional)</label><label>Lastname(optional)</label>--><br>
      <input type='text' name='firstname' class='form-signup1' placeholder='Firstname(optional)'>   
      <input type='text' name='lastname' class='form-signup1' placeholder='Lastname(optional)'>
    </div>
  </div>
  <div class='form-group'>
    <label>Username to register</label><br>
    <input type='text' name='user' class='form-signup' id='signup' placeholder='Your unique username' onBlur='checkUser(this)' required>
  </div>
  <div>
    <label>Password</label><br>
    <input type='text' name='pass' class='form-signup' id='signup' required placeholder='*****'>
  </div>
  <!--<div class='form-group'>
    <label>Retype your Password</label><br>
    <input type='password' name='pass' class='form-signup' id='signup' placeholder='Password'>
  </div>-->
  <div class='form-group'>
    <label for='inputAddress2'>Email</label><br>
    <input type='text' name='email' class='form-signup' id='signup' placeholder='Email'>
  </div>
  <div class='form-row'>
    <div class='form-group col-md-6'>
      <label for='inputCity'>City</label><br>
      <input type='text' name='city' class='form-signup' id='signup' placeholder='City'>
    </div> 
	";
?>
</div>
  <button type='submit' name='action' value='signupnow' class='btn btn-primary'>Sign up</button>
</form>

<!--<span class='fieldname'>&nbsp;</span>
<input type='submit' value='Sign up'>-->
</form></div><br>
</body>
</html>