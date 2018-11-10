<?php
	require_once 'header.php';
	
	if (!$loggedin) die();
	echo"<center><input type='text' style = 'font-size:10px' size='20'value='$userstr' id='myInput'>
<button style = 'font-size:10px' onclick='copyy()'>Copy my code</button></center>";

	echo"(coming soon)";
	echo "Search your friend here";
	if (isset($_GET['view'])) 
		$view = sanitizeString($_GET['view']);
	else $view = $user;
	
	if ($view==$user)
	{
		$name1 = $name2 = "Your";
		$name3="You are";
	}
	else 
	{
		$name1 = "<a href='members.php?view=$view'>$view</a>'s";
		$name2 = "$view's";
		$name3 = "$view is";
	}
	
	echo "<div class='main'>";
	
	$followers = array();
	$following = array();
	
	$result = queryMysql("SELECT *FROM friends WHERE user='$view'");
	$num = $result->num_rows;
	
	for($j=0;$j<$num;++$j)
	{
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$following[$j]=$row['user'];
	}
	
	$mutual = array_intersect($followers,$following);
	$followers = array_diff($followers,$mutual);
	$following = array_diff($following,$mutual);
	$friends = false;
	
	if (sizeof($mutual))
	{
		echo "<span class='subhead'>$name2 mutual friends</span><ul>";
		foreach ($mutual as $friend)
		{
			echo "<li><a href='members.php?view=$friend'>$friend</a>";
		}
		echo "</ul>";
		$friends = true;
	}
	if (sizeof($followers))
	{
		echo "<span class='subhead'>$name2 followers</span><ul>";
		foreach ($mutual as $friend)
		{
			echo "<li><a href='members.php?view=$friend'>$friend</a>";
		}
		echo "</ul>";
		$friends = true;
	}
	if (sizeof($following))
	{
		echo "<span class='subhead'>$name2 following</span><ul>";
		foreach ($mutual as $friend)
		{
			echo "<li><a href='members.php?view=$friend'>$friend</a>";
		}
		echo "</ul>";
		$friends = true;
	}
	
	if (!$friends) echo "<br>You don't have any friends yet.<br><br>";
	echo"<a class='button' href='messages.php?view=$view'>";
	echo "View $name2 messages</a>";
?>

<script>
function copyy() {
  var copyText = document.getElementById("myInput");
  copyText.select();
  document.execCommand("Copy");
}
</script>

</div><br>
</body>
</html>