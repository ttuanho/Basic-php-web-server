<!DOCTYPE html>
<html>
	<head>
	 <title>Setting up database</title>
	</head>
	
	
<body>
	<h3> Setting up... </h3>
	<?php
	   require_once'functions.php';
	   
	   createTable('members','user varchar(500), pass varchar(500), index (user(6))');
	   createTable('messages',
	               'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				   auth VARCHAR(500),
				   recip VARCHAR(200),
				   pm CHAR(1),
				   time INT UNSIGNED,
				   message VARCHAR(4096),
				   INDEX(auth(6)),
				   INDEX(recip(6))');
	   createTable('friends',
					'user VARCHAR(500), 
					friend VARCHAR(500),
					INDEX(user(6)),
					INDEX(user(6))');
		createTable('profiles',
					'user VARCHAR(500),
					text VARCHAR(4096),
					INDEX(user(6))');
	?>
	<br>..done
	
</body>
</html>