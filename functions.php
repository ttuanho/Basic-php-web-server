<?php
	
$dbhost='127.0.0.1';
$dbname='phpmyadmin';
$dbuser='root';
$dbpass='';
$appname='vocab';
$connection = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
if ($connection->connect_error) die($connection->connect_error);

function createTable($name,$query)
{
	queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
	echo "Table '$name' created or already exists. <br>";
}

function queryMysql($query)
{
	global $connection;
	$result = $connection->query($query);
	if (!$result) die ($connection->error);
	return $result;
}

function destroySession()
{
	$_SESSION = array();
	if (session_id()!=""||isset($_COOKIE[session_name()]))
		setcookie(session_name(),'',time()-2592000,'/');
	
	session_destroy();
}

function sanitizeString($var)
{
	global $connection;
	$var = strip_tags($var);
	$var = htmlentities($var);
	$var = stripcslashes($var);
	return $connection->real_escape_string($var);
}

function showProfile($user)
{
	if (file_exists("$user.jpg"))
		echo "<img src='$user.jpg' style='float:left'>";
	
	$result =  queryMysql("SELECT *FROM profiles WHERE user='$user'");
	
	if ($result->num_rows)
	{
		$row = $result->fetch_array(MYSQLI_ASSOC);
		echo stripcslashes($row['text'])."<br style='clear:left'><br>";
	}
}
?>
<head>
  <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
	<script src="js/jquery.easy-autocomplete.min.js"></script> 
	
	<link rel="stylesheet" type="text/css" href="vocab_css.css">
	
	
</head>

<?php

//-----------------------Fundament setting---------------------------------------------
//function get_post($conn, $var)  {    return $conn->real_escape_string($_POST[$var]);  } 
  
//require_once'login.php'; //--->currently for admin only--> check before running
//require_once'cpu.php';
$conn = $connection;
if ($conn->connect_error) die($conn->connect_error);
function get_post($conn, $var)  {    return $conn->real_escape_string($_POST[$var]);  }

function RandomString($minimum,$character_limit)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_'; // character "=" for order
    $randstring = "";//$characters[rand(0, strlen($characters))];
	$character_num=rand($minimum,$character_limit);
    for ($i = 0; $i <=$character_num; $i++) {
        $randstring .= $characters[rand(0, strlen($characters)-1)];
    }
    return $randstring;
}

//Form handling validation
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  return $data;
}
//Form handling validation
function encode_input($data) {
  $data = trim($data);
  $data = base64_encode($data);
  $data = stripslashes($data);
  return $data;
}
//Form handling validation
/*function encode_input($data) {
  $data = stripslashes($data);
  $dta = base64_decode($data);
  return $dta;
}*/

//SEARCH MANY WORDS BY GETTING INFO FROM OXFORD DICTIONARY
function lookup_word_oxfordDict(string $wordstolookup)
{
	
}

//SEARCH MANY WORDS BY GETTING INFO FROM CAMBRIDGE DICTIONARY
function web_content(string $wordstolookup)
{
	set_time_limit(0);

$text_file_name="CAMBRIDGE html file looking up ".$wordstolookup.".txt";
$link="https://dictionary.cambridge.org/dictionary/english/".$wordstolookup;
$content = file_get_contents($link);
file_put_contents($text_file_name, $content);
$myfile=fopen($text_file_name,"r");
$stringg =  fread($myfile,filesize($text_file_name));
return $stringg;
}
function data_lookup_word_cambridgeDict(string $wordstolookup)
{
	set_time_limit(0);

$text_file_name="CAMBRIDGE html file looking up ".$wordstolookup.".txt";
$link="https://dictionary.cambridge.org/dictionary/english/".$wordstolookup;
$content = file_get_contents($link);
file_put_contents($text_file_name, $content);
$myfile=fopen($text_file_name,"r");
$stringg =  fread($myfile,filesize($text_file_name));

//$stringg=delete_substr_in_range2words($stringg,"<script","</script>");
//$stringg=delete_substr_in_range2words($stringg,"<link","/>");

//Eliminate "script" part
/*while (strpos($stringg,"<script")==true)
{
	$a=(int) strpos($stringg,"<script");
	$b=(int)strpos($stringg,"</script>",$a+strlen("<script"));
	for($j=$a;$j<=$b+strlen("</script>");$j++){
		$stringg[$j]="*";
	}
}*/
//$stringg=delete_substr_in_range2words($stringg,"<script","</script>");
//Eliminate "link" part
/*while (strpos($stringg,"<link")==true)
{
	$a=(int) strpos($stringg,"<link");
	$b=(int)strpos($stringg,"/>",$a+strlen("<link"));
	for($j=$a;$j<=$b+strlen("/>");$j++){
		$stringg[$j]="*";
	}
}*/
//$stringg=delete_substr_in_range2words($stringg,"<link","/>");

//Write
$myfile=fopen($text_file_name,"w");
fwrite($myfile,$stringg);
//Read
$myfile=fopen($text_file_name,"r");
$stringg =  fread($myfile,filesize($text_file_name));

//Eliminate "<a class="circle bg" part
//$stringg=delete_substr_in_range2words($stringg,"<a",">");

//$stringg=delete_substr_in_range2words($stringg,"<div",">");
//$stringg=delete_substr_in_range2words($stringg,"<span",">");


//Minimize range
/*$pos1=(int) strpos($stringg,"<div class=\"sense-block\"")-1;
for ($k=1;$k<=$pos1;$k++)
{
	substr($stringg[$k],1);
}*/

//Write
$myfile=fopen($text_file_name,"w");
fwrite($myfile,$stringg);
//Read
$myfile=fopen($text_file_name,"r");
$stringg =  fread($myfile,filesize($text_file_name));

$stringg=change_main_string_fetch_data_obligatorily_in_the_middle_of_2_signs($stringg,'>[<span','>','<',30);///After manipulating Type, delete the unecessary part
$stringg=change_main_string_fetch_data_obligatorily_in_the_middle_of_2_signs($stringg,'<span class="pos" title=','>','<',30);///After manipulating Wordform, delete the unecessary part

//Minimize range
$pos2=(int) strpos($stringg,"Translations of ")-1;
/*for ($f=$pos2;$f<=strlen($stringg);$f++)
{
	substr($stringg[$f],1);
}*/

//Signs of new definitions: "<p class="def-head semi-flush">" OR ">[<span" OR "<span class='pos' "

$myfile=fopen($text_file_name,"w");
fwrite($myfile,$stringg);
return $stringg;

fclose($myfile);



}
function wordform_lookup_word_cambridgeDict(string $wordstolookup)
{
	return fetch_data_obligatorily_in_the_middle_of_2_signs($wordstolookup,'<span class="pos" title=','>','<',30);
}

function type_lookup_word_cambridgeDict(string $wordstolookup)
{
	$a= fetch_data_obligatorily_in_the_middle_of_2_signs($wordstolookup,'>[<span','>','<',30);
	if (strlen($a)>4){
	$a="";}
	return $a;
}

function meaning_lookup_word_cambridgeDict(string $wordstolookup)
{
	$a=fetch_data_obligatorily_in_the_middle_of_2_signs($stringg,'<b class="def"','>','<',2);
	
}

function use_lookup_word_cambridgeDict(string $wordstolookup)
{
	return fetch_data_obligatorily_in_the_middle_of_2_signs($stringg,'class="usage"','>','<',2);
}

function convert_html_to_text($posNfistsign,$endsign,$stringg)
{
	$posbegin=(int)$posNfistsign;
	$pos2=strpos($stringg,$endsign,$posbegin+3);
	$posend=$pos2+strlen($endsign);
	$length=$posend-$posbegin+5;
	$chuoi=substr($stringg,$posbegin,$length);
	$outcome=strip_tags($chuoi);
	return $outcome;
}

//****************--------------------------------------------------
function posN($stringg,$settingstring,$N)
{
	$pos[0]=0;
	$length=strlen($settingstring)-2;
	for($i=1;$i<=$N;$i++){
		$pos[$i]=strpos($stringg,$settingstring,$pos[$i-1]+$length);
	}
	return $pos[$N];
}

//Fetch ALL data which is obligatorily in the middle of '>' and '<' AFTER the initial sign / marking /settting string  given
function fetch_data_in_html_string($stringg,$firstsign,$lastsign)
{
	$pos_firstsign=(int)strpos($stringg,$firstsign);
	$pos_lastsign=(int)strpos($stringg,$lastsign);
	$outcome=" ";
	$dk=false;
	for ($i=$pos_firstsign;$i<=$pos_lastsign;$i++){
		if ($dk==true){
			$outcome=$outcome.substr($stringg,$i,1);
		}
		if ($stringg[$i]==">"){
			$dk=true;
		}
		if ($stringg[$i]=="<"){
			$dk=false;
		}
	}
	return $outcome;
}

//Fetch data which is obligatorily in the middle of '>' and '<' AFTER the initial sign / marking /settting string  given, skipping $n first empty characters
function fetch_data_obligatorily_in_the_middle_of_2_signs($stringg,$settingstring,$firstsign,$secondsign,$n)
{
	$pos1=strpos($stringg,$settingstring);
	$pos2=strpos($stringg,$firstsign,$pos1+$n);
	$pos3=strpos($stringg,$secondsign,$pos2);
	//echo "Position of ".$settingstring." is ".$pos1."<br>";
	//echo "Position of ".$firstsign." is ".$pos2."<br>";
	//echo "Position of ".$secondsign." is ".$pos3."<br>";
	$outcome=substr($stringg,$pos2+1,$pos3-$pos2-1);
	//echo $outcome."<br>";
	$stringg=substr_replace($stringg,'',$pos1,$pos3+2);
	//echo $stringg;
	return $outcome;
}

//*****ONCE Fetch data which is obligatorily in the middle of '>' and '<' AFTER SETTING RANGE & the initial sign / marking /settting string  given, skipping $n first empty characters
function fetch_data_obligatorily_in_the_middle_of_2_signs_setting_range($stringg,$setting_range,$settingstring,$firstsign,$secondsign,$n)
{
	$pos1=strpos($stringg,$settingstring,$setting_range);
	$pos2=strpos($stringg,$firstsign,$pos1+$n);
	$pos3=strpos($stringg,$secondsign,$pos2);
	//echo "Position of ".$settingstring." is ".$pos1."<br>";
	//echo "Position of ".$firstsign." is ".$pos2."<br>";
	//echo "Position of ".$secondsign." is ".$pos3."<br>";
	$outcome=substr($stringg,$pos2+1,$pos3-$pos2-1);
	//echo $outcome."<br>";
	$stringg=substr_replace($stringg,'',$pos1,$pos3+2);
	//echo $stringg;
	return $outcome;
}
//*****Fetch data which is obligatorily in the middle of '>' and '<' AFTER SETTING RANGE & the initial sign / marking /settting string  given, skipping $n first empty characters UNTIL $ENDINGSTRING
function fetch_data_obligatorily_in_the_middle_of_2_comparative_signs_setting_range($stringg,$setting_range,$settingstring,$endingstring,$n)
{
	$pos_start=strpos($stringg,$settingstring,$setting_range+1);
	$pos_end=strpos($stringg,$endingstring,$pos_start+5);
	
	//***********************************************8
	
	//$pos2=strpos($stringg,$firstsign,$pos1+$n);
	//$pos3=strpos($stringg,$secondsign,$pos2);
	//echo "Position of ".$settingstring." is ".$pos1."<br>";
	//echo "Position of ".$firstsign." is ".$pos2."<br>";
	//echo "Position of ".$secondsign." is ".$pos3."<br>";
	$outcome=substr($stringg,$pos2+1,$pos3-$pos2-1);
	//echo $outcome."<br>";
	$stringg=substr_replace($stringg,'',$pos1,$pos3+2);
	//echo $stringg;
	return $outcome;
}

function pos1_fetch_data_obligatorily_in_the_middle_of_2_signs($stringg,$settingstring)
{
	$pos1=strpos($stringg,$settingstring);
	return $pos1;
}
function pos2_fetch_data_obligatorily_in_the_middle_of_2_signs($stringg,$settingstring,$firstsign,$secondsign,$n)
{
	$pos1=strpos($stringg,$settingstring);
	$pos2=strpos($stringg,$firstsign,$pos1+$n);
	return $pos2;
}
function pos3_fetch_data_obligatorily_in_the_middle_of_2_signs($stringg,$settingstring,$firstsign,$secondsign,$n)
{
	$pos1=strpos($stringg,$settingstring);
	$pos2=strpos($stringg,$firstsign,$pos1+$n);
	$pos3=strpos($stringg,$secondsign,$pos2);
	return $pos3;
}
function change_main_string_fetch_data_obligatorily_in_the_middle_of_2_signs($stringg,$settingstring,$firstsign,$secondsign,$n)
{
	$pos1=strpos($stringg,$settingstring);
	$pos2=strpos($stringg,$firstsign,$pos1+$n);
	$pos3=strpos($stringg,$secondsign,$pos2);
	return substr_replace($stringg,'',$pos1,$pos3-$pos1);
}
//------------------------------------------------------------------------------------------------------------

//Delete Substring in a range of 2 wordstolookup
function delete_substr_in_range2words(string $initialstring,string $firstword, string $secondword)
{
	/*$laterstring=" ";
	while (strpos($initialstring,$firstword)==true) 
	{
	$position1=(int)strpos($initialstring,$firstword);// echo $position1."<br>";
	$position2=(int)strpos($initialstring,$secondword); //echo $position2."<br>";
	for ($i=$position1;$i<=$position2+strlen($secondword);$i++){
		$initialstring[$i]=" ";
	}
	$laterstring=$initialstring;
	}
	return $laterstring;*/
		
	while (strpos($initialstring,$firstword)==true)
{
	$a=(int) strpos($initialstring,$firstword);
	$b=(int)strpos($initialstring,$secondword,$a+strlen($firstword));
	for($j=$a;$j<=$b+strlen($secondword);$j++){
		substr($initialstring[$j],1);
	}
}
	return $initialstring;
}



//Prevent Sql injection
function SQL_prevent($stringg)
{
     $status=true;
     $invalidword[1]="admin";
	 $invalidword[2]="DROP";
	 $invalidword[3]="users";
	 $invalidword[4]="vocabulary";
	 $invalidword[5]="loginrecord";
	 $invalidword[6]="(";
	 $invalidword[7]=")";
	 $invalidword[8]="'";
	 $invalidword[9]="=";
	 $invalidword[10]="+";
	 $invalidword[11]="/";
	 $invalidword[12]="Drop";
	 $invalidword[12]="vocab_users";
	 $invalidword[13]="<";
	 $invalidword[14]=">";
	 for ($i=1;$i<=14; $i++){
		 if (strpos($stringg,$invalidword[$i])==true){
			 $status=false;
		 }
	 }
	 return $status;
	 
}

//GET CLIENT IP ADDRESS
function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

//get client IP
function getIP(){
if (isset($_SERVER['HTTP_CLIENT_IP']) && array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
    $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
    $ips = array_map('trim', $ips);
    $ip = $ips[0];
} else {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

$ip = filter_var($ip, FILTER_VALIDATE_IP);
$ip = ($ip === false) ? '0.0.0.0' : $ip;
return $ip;	
}

function radomnize_creating_id($minimum,$character_limit){
	$character_num=rand($minimum,$character_limit);
	/*
	for ($t=0,$t<=9,++$t){
	$a[$t]=(string)$t;
	}
	$z=11;
	for ($y='a'
	for ($i=1;$i<=$character_num;++$i){
		$code=$code.$a[rand(0,36)];
	}
	return $code;*/
}

function calculate_AP_Point(){
	
}
//HASH function
function hashstring($var,$strlength)
{
	$a = substr(hash('whirlpool',hash('sha512',$var)),0,$strlength);
	return $a;
}

function convBase($numberInput, $fromBaseInput, $toBaseInput)
{
    if ($fromBaseInput==$toBaseInput) return $numberInput;
    $fromBase = str_split($fromBaseInput,1);
    $toBase = str_split($toBaseInput,1);
    $number = str_split($numberInput,1);
    $fromLen=strlen($fromBaseInput);
    $toLen=strlen($toBaseInput);
    $numberLen=strlen($numberInput);
    $retval='';
    if ($toBaseInput == '0123456789')
    {
        $retval=0;
        for ($i = 1;$i <= $numberLen; $i++)
            $retval = bcadd($retval, bcmul(array_search($number[$i-1], $fromBase),bcpow($fromLen,$numberLen-$i)));
        return $retval;
    }
    if ($fromBaseInput != '0123456789')
        $base10=convBase($numberInput, $fromBaseInput, '0123456789');
    else
        $base10 = $numberInput;
    if ($base10<strlen($toBaseInput))
        return $toBase[$base10];
    while($base10 != '0')
    {
        $retval = $toBase[bcmod($base10,$toLen)].$retval;
        $base10 = bcdiv($base10,$toLen,0);
    }
    return $retval;
}

function calculate_Reliable_Point($word,$spelling,$form,$type,$use,$completSynonyms,$meaning,$example){
	$point['word']=pow(4.2,strlen($word)/4);
	if ($spelling!=""){$point['spelling']=11;} 
	else $point['spelling']=0;
	$point['form']=3;
	if ($type!=""){$point['type']=12;}
	else $point['type']=0;
	if ($use!=""){$point['use']=12*pow(1.5,strlen($use)/20);}
	else $point['use']=0;
	
	if (strpos($meaning,';')==true){
		$point['meaning']=16*pow(1.3,strlen($meaning)/20);
		//$point['meaning']=27*$point['meaning'];
		}
	else {$point['meaning']=16*pow(1.2,strlen($meaning)/20);}
	if ($example!=""){
		if (strpos($example,'.')||(strpos($example,'?'))){
		$point['example']=17*pow(1.25,strlen($example)/20);
		}
		else {$point['example']=17*pow(1.15,strlen($example)/20);}
		}
	else $point['example']=0;
	//$completSynonyms ---> affect other word point
	$finalpoint=($point['word']+$point['spelling']+$point['form']+$point['type']+$point['use']+$point['meaning']+$point['example'])/(95*pow(1.21,strlen($word)/4))*1000;
	
	return $finalpoint;
	
}

//Redirect a page
/*function Redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}*/
function str_replace_first($from, $to, $subject)
{
    $from = '/'.preg_quote($from, '/').'/';

    return preg_replace($from, $to, $subject, 1);
}





/*$user_password="H5ga46ifT6b9WnOBr37";
$user_id="xY1lMkT98InS4C7DFHAKuhguire78u387yhfdi".$user_password;*/
?>