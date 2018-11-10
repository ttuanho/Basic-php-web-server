<?php
require_once'header.php';

destroySession();
if (isset($_SESSION['USERNAME']))
{
	destroySession();
	echo "<div class='main'> You have been logged out. Please ".
	"<a href='index.php'>click here</a> to refresh the screen.";
}
else echo "<div class='main'><br>".
"You 've logged out. Click any button to refresh the page.";
?>
<br><br></div>
</body>
</html>