<?php
	header("Content-type: text/css");
	
?>
*{
	font-family:verdana;sans-serif;
	font-size:14pt;
}
body
{
	width:70%;
	margin:20px auto;
	background:#ffffff;
	border: 1px solid #888;
}
html
{background:#ffffff;}
hr{
	width:70%;
}
img
{
	border: 1px solid black;
	margin-right:15px;
	-moz-box-shadow:2px 2px #888;
	-webkit-box-shadow:2px 2px #888;
	box-shadow::2px 2px #888;
}
li a, .button{
text-decoration:none;}

li a:hover, .button:hover{
	color:green;
}

.appname{
	text-align:center;
	background:#eb8;
	color:#40d;
	font-family:helvetica;
	font-size:20pt;
	padding:4px;
}
.fieldname{
	float:left;
	width:120px;
}
.main{
	margin-left:40px;
}
.info{
	background:lightgreen;
	color:blue;
	border: 1px solid green;
	padding: 5px 10px;
	margin-left:40px;
}
.menu li, .button{
	display:inline;
	padding: 4px 6px;
	border: 1px solid #777;
	background:#ddd;
	color:#d04;
	margin-right:8px;
	border-radius:5px;
	-moz-box-shadow:2px 2px #888;
	-webkit-box-shadow:2px 2px #888;
	box-shadow:2px 2px #888;
}
.subhead{
	font-weight:bold;
}
.taken, .error{
	color:red;
}
.available{
	color:green;
}

.whisper{
	font-style:intalic;
	color:#006600;
}
#logo{
	font-family:Georgia;
	font-weight:bold;
	font-style:italic;
	font-size:97px;
}
ul.meaning{
	list-style-type:square;
}
ul.example{
	list-style-type:circle;
}