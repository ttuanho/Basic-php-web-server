<?php
	
	session_start();
	echo  "<!DOCTYPE html>\n<html><head>";
	
	require_once'functions.php';
	//require_once'login.php';
	
	$userstr='Guest';
	
	if (isset($_SESSION['USERNAME']))
	{
		$user = $_SESSION['USERNAME'];//-->**********LATER
		//Remember comment/delete 2 lines below before running publicily
		//pass for admin account: #abc
		/*$user_id="xY1lMkT98InS4C7DFHAKuhguire78u387yhfdiH5ga46ifT6b9WnOBr37";*/
		$result = queryMysql("SELECT *FROM users WHERE USERNAME='$user'");
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$user_id = $row['ID'];
		//echo $user_id;
		$usernamereg = $row['usernamereg'];
		$loggedin = TRUE;
		$userstr =substr($user,0,12);
	}
	else $loggedin = false;
	
	echo "<title>$appname</title><link rel='stylesheet'".
	"href='style.css' type='text/css'>".
	"</head><body><!--<center><canvas id='logo' width='624' height='96' >$appname </canvas></center>-->".
	"<div class='appname' > $appname(#$userstr)</div>".
	'<script scr="javascript.js"></script>
	<!-- Bootstrap CSS -->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">-->
	
	<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
   rel = "stylesheet">
    <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>';
	
	
	echo "<br> <ul class='menu'>"."<li><a href='about.php'>About</a></li>";
	if ($loggedin)
		     echo "<li><a href='members.php?view=$user'>Home</a></li>".
			 "<li><a href='vocab.php'>MyWords</a></li>".
			 "<li><a href='practice.php'>Practice</a></li>".
			 "<li><a href='profile.php'>Profile</a></li>".
			 "<li><a href='friends.php'>Friends</a></li>".
			 "<li><a href='setting.php'>Setting</a></li>".
			 "<li><a href='logout.php'>Log out</a></li></ul><br>";
	else echo (	"<li><a href='index.php'>Home</a></li>".
				"<li><a href='signup.php'>Sign up</a></li>".
				"<li><a href='login.php'>Log in</a></li></ul><br>");
				//"<span class='info'>&#8658; You must be logged in to view this page.</span><br><br>");

	
?>