<?php 
	
	require_once'header.php';
	
	/*Hash
	*/
	/*$str="Hello, this is a new website. Welcome";
	$str2="Hello, this is a new website. Welcome";
	echo "String: ".$str."<br>";
	echo "String2: ".$str2."<br>";
	echo "Base64encode str: ".base64_encode($str)."<br>";
	echo "Base64encode str2: ".base64_encode($str2)."<br>";
	echo "SHA256 str: ".hash('sha256',$str)."<br>";
	echo "SHA256 str2: ".hash('sha256',$str2)."<br>";
	echo "SHA256+base64_encode: ".base64_encode(hash('sha512',$str))."<br>";
	$sha256bas64=(string)base64_encode(hash('sha512',$str));
	echo "Basewanted: ".convBase($sha256bas64,"0123456789abcdefghijklmnoprstuvzxyw=".strtoupper("abcdefghijklmnoprstuvzxyw"),"0123456789abcdefghijklmnoprstuvzxyw+_%~-<>/&();.,[]{}\|*!@#$^".strtoupper("abcdefghijklmnoprstuvzxyw"))."<br>"."<br>";
	echo "Hashstring: ".substr(hash('whirlpool',hash('sha512',$sha256bas64)),0,200)."<br>";
	echo "SHA512: ".hash('sha512',$str)."<br>";
	echo "Whirlpool str: ".hash('whirlpool',$str)."<br>";
	echo "SHA512+Whirlpool str: ".hash('whirlpool',hash('sha512',$str))."<br>";
	echo "SHA512+Whirlpool str2: ".hash('whirlpool',hash('sha512',$str2))."<br>";
	echo"<br>";*/
	
	echo "<br><span class='main'>Welcome to ".$appname;
	
	if ($loggedin) echo "#$userstr, you are logged in.";
	else echo ', please sign up and/or log in to join in.';
	
?> 

</span><br><br>
</body>
</html>
