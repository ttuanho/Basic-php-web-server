<?php
	require_once'header.php';
	
	if (!$loggedin) {die();}
	
	echo "<div class='main'><h3>Your profile</h3>";
	
	$result = queryMysql("SELECT *FROM profiles WHERE user='$user'");
	
	if (isset($_POST['text']))
	{
		$text = sanitizeString($_POST['text']);
		$text =  preg_replace('/\s+/',' ',$text);
		if ($result->num_rows)
			queryMysql("UPDATE profiles SET text='$text' WHERE user='$user'");
		else queryMysql("INSERT INTO profiles VALUES('$user','$text')");
	}
	else 
	{
		if ($result->num_rows)
		{
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$text = stripcslashes($row['text']);
		}
		else $text="";
	}
	
	$text = stripcslashes(preg_replace('/\s+/',' ',$text));
		
	if (isset($_FILES['image']['name']))
	{
		$saveto = '$user.jpg';
		move_uploaded_file($_FILES['image']['name'],$saveto);
		$typeok = TRUE;
		
		switch($_FILES['image']['type'])
		{
			case "image/gif": $src = imagecreatefromgif($saveto);break;
			case "image/jpeg": $src = imagecreatefromjpeg($saveto);break;
			case "image/pjpeg": $src = imagecreatefromjpeg($saveto);break;
			default: $typeok = FALSE; break;
		}
		
		if ($typeok)
		{
			list($w,$h) = getimagesize($saveto);
			
			$max = 100;
			$tw = $w;
			$th = $h;
			
			if ($w>$h&&$max<$w)
			{
				$th = $max / $w * $h;
				$tw = $max;
			}
			elseif ($h>$w&&$max<$h)
			{
				$tw = $max / $h *$w;
				$th = $max;
			}
			elseif ($max<$w)
			{
				$tw = $th = $max;
			}
			$tmp = imagecreatetruecolor($tw,$th);
			imagecopyresampled($tmp,$src,0,0,0,0,$tw,$th,$w,$h);
			imageconvolution($tmp,array(array(-1,-1,-1),array(-1,16,-1),array(-1,-1,-1)),8,0);
			imagejpeg($tmp,$saveto);
			imagedestroy($tmp);
			imagedestroy($src);
		}
	}
	showProfile($user);
	echo"<small>[<a href='profile.php?edit'>Edit</a>]</small>";
	
		if (isset($_GET['edit'])) echo "
		<form method='post' action='profile.php' enctype='multipart/form-data'>
		<h3>Enter or edit your details and/or upload an image</h3>
		<textarea name='text' cols='50' rows='3'>$text</textarea>
		";
if (isset($_GET['edit']))echo"
<br>
Image: 
<input type='file' name='image' size='14'>
<input type='submit' value='Save Profile'>
</form> ";

//Show the learner's progress

?></div> <br>
</body>
</html>