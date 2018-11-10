<?php
	require_once 'header.php';
	
	
	if (!$loggedin) die();

	echo "<div class='main'><h3>Your volcabulary</h3><small>[<a href='vocab.php?edit'>Edit</a>]</small>
	<small>[<a href='vocab.php?add'>Add words</a>]</small><small>[<a href='vocab.php'>View list</a>]</small><small>[<a href='vocab.php?folder'>Folder</a>]</small><br><br>";
	
	
	if (isset($_GET['edit']))
	{
		$edit = ($_GET['edit']);
		//
		
		
	}
	if (isset($_GET['delete']))
		{
		$erase = ($_GET['delete']);
		queryMysql("DELETE FROM vocab_user WHERE USER_WORD_ID='$erase'");
		//echo $erase;
		}
	if (isset($_POST['save']))
	{
		
	}
	if (isset($_GET['add']))
	{
	echo "
<!--<input  class='word_lookup' type='text' name='word_lookup'    placeholder='Look up English word or insert link'>-->
<div id='input-word'  >
<pre>
<input type='text' style='font-weight:bold; font-size:14px; text-transform:uppercase;' placeholder='ALIMENT' size='22' name='word'> <input type='text' name='pronunciation' style='font-size:10pt' size='19' placeholder='ˈælɪmənt'><select style=' font-size:15pt;' name='form' ><!--class='custom-select mb-2 mr-sm-2 mb-sm-0' id='inlineFormCustomSelect'-->
    <option  name='form' style='font-weight:bold;'>Wordform</option>
    <option selected name='form'  style='font-style:italic;' value='noun'>Noun</option>
	<option  name='form'  style='font-style:italic;' value='ajective'>Ajective</option>
    <option  name='form'  style='font-style:italic;' value='verb'>Verb</option>
    <option  name='form'  style='font-style:italic;' value='adverb'>Adverb</option>
	<option  name='form'  style='font-style:italic;'value='preposition'>Preposition</option>
	<option  name='form'  style='font-style:italic;' value='idiom'>Idiom</option>
	<option  name='form' style='font-style:normal; font-weight:bold;' value=''>Multiform</option>
	<option  name='form'  style='font-style:italic;' value='verb noun'>Verb;noun</option></select><!--<input id='inputwordform' type='text' name='form' style='font-style:italic; font-size:14pt;' size='14' placeholder='form'>--> <input type='text' style='font-style:italic;font-size:14px;' name='type' size='16' placeholder='uncountable'>  <input type='text' style='font-style:italic; font-size:14px; text-decoration:underline;' name='use' placeholder='Use: old-fashioned' size='21'>

 <textarea type='text' name='meaning' rows='6' cols='47' placeholder='Meaning: food'></textarea><textarea type='text' name='example' rows='6' cols='37' placeholder='Example:We spend more on almost any article of bodily aliment than on our mental one.'></textarea>
<center><input class='adding' name='add' type='submit' style='left:inherent;' value='ADD'></center></div>
</pre></form>";
	}
if (isset($_POST['word'])&& isset($_POST['meaning'])&&(isset($_POST['add']))){
	//echo $_POST['add'];
	$word   = get_post($conn,'word');
	$meaning   = get_post($conn, 'meaning');
	//echo $word."---";
	//echo "good";
	
	if (($word!="")&&($meaning!="")){
	if (isset($_POST['form'])) {$form   = get_post($conn, 'form');} else $form="";
    if (isset($_POST['pronunciation'])) {$pronunciation   = get_post($conn, 'pronunciation');} 
	else $pronunciation="";
	$form   = get_post($conn,'form');
	if (isset($_POST['type'])) {$type   = get_post($conn, 'type');} 
	else $type="";
	if (isset($_POST['use'])) {$use   = get_post($conn, 'use');} 
	else $use="";
	
	
	if (isset($_POST['example'])) {$example   = get_post($conn, 'example');} 
	else $example="";
	//echo $word."jhgjh ".$pronunciation." ".$form."<br>";
	
	//Evaluate the Reliable POINT  ---> see cpu.php
	$reliablePoint=calculate_Reliable_Point($word,$pronunciation,$form,$type,$use,"",$meaning,$example);
	
	//echo $reliablePoint;
	
	//Creating word_id by randonizing numbers ---> see cpu.php
	$word_id=RandomString(35,40);
	//..........
	
	$activePoint=strlen($word.$pronunciation.$form.$type.$use.$example.$meaning)/10;
	
	$nowtime=time();
	
	//---------Insert into vocabulary TABLE----------------------------------
	$query= "INSERT INTO vocabulary (WORDS,pronunciation,WORDFORMS,TYPES,USES,MEANING,AddedBy,dateCreated,ReliablePoint,example,WORD_ID) VALUES". "('$word', '$pronunciation', '$form', '$type', '$use', '$meaning', '$usernamereg', '$nowtime', '$reliablePoint' , '$example', '$word_id')";  
	//To check result
	//echo "Word: ".$word." ";
	//echo "form: ".$form." ";
	$result   = $conn->query($query);    
if (!$result){ echo "INSERT failed: $query<br>" .      $conn->error . "<br><br>";}
	//else echo "The word has been added to vocabulary list<br>";
	
	
	//------Insert into individual's vocab TABLE------------------------------
	$query="INSERT INTO vocab_user
	(USER_ID,USER_WORD_ID,POINT,added_date,REGULARITY_INDEX,ActivePoint)
	VALUES"."('$user_id','$word_id','50.00','$nowtime','0','$activePoint')";
	$result = $conn->query($query);
	if (!$result){ echo "INSERT failed: $query<br>" .      $conn->error . "<br><br>";}
	//else echo "The word has been added to individual table<br>";
	//$action="vocab_list";
	}
	}
	
	
	$result2 = queryMysql("SELECT *FROM vocab_user WHERE USER_ID='$user_id' ORDER BY added_date ");
	$num = $result2->num_rows;
	
	for ($j=0;$j<$num;++$j)
	{
		$row = $result2->fetch_array(MYSQLI_ASSOC);
		$words[$j]=$row['USER_WORD_ID'];
		//echo $words[$j]."<br>";
		//echo $j."<br>";
	}
	$j-=1;
	
	for ($j=$j;$j>=0;--$j)
	{	

		if (isset($_GET['difficulty']))
		$result3 = queryMysql("SELECT *FROM vocabulary WHERE WORD_ID = '$words[$j]' ORDER BY ReliablePoint");
		else $result3 = queryMysql("SELECT *FROM vocabulary WHERE WORD_ID = '$words[$j]' ");
		$row  = $result3->fetch_array(MYSQLI_ASSOC);
		$idword[$j] = $row['ID'];
		$word[$j] = $row['WORDS'];
		if ($row['pronunciation']!="") $pronunciation[$j] = $row['pronunciation'];
		else $pronunciation[$j]=null;
		$wordforms[$j] = $row['WORDFORMS'];
		if ($row['TYPES']!="")$types[$j] = $row['TYPES'];
		else $types[$j]="";
		if ($row['USES']!="") $uses[$j] = $row['USES'];
		else $uses[$j]="";
		$meanings[$j] = $row['MEANING'];
		//$adder[$j] = $row['AddedBY'];
		//$time[$j]= $row['dateCreated'];
		$reliablepoint[$j] = $row['ReliablePoint'];
		$examples[$j] = $row['example'];
		// echo $j.$words[$j];
		if (isset($_GET['edit']))
		{
			echo "<form action='vocab.php' method='post'>";
		}
		if (!isset($_GET['edit']))
			echo "<b><strong>".strtoupper($word[$j])."</b></strong> ";
		else echo "<input type='text' style='font-weight:bold; font-size:14px; text-transform:uppercase;' value='$word[$j]' size='16' name='word'>";
		
		if (!isset($_GET['edit']))
		{if ($pronunciation[$j]!='') echo "<span class='pronun' style='font-family:DictBats;'> /".$pronunciation[$j]."/</span> ";}
		else echo "<input type='text' name='pronunciation' style='font-size:10pt' size='14' value='$pronunciation[$j]' placeholder='Pronunciation'>";
		
		if (!isset($_GET['edit'])) echo "<i>(".$wordforms[$j].")</i>";
		elseif (isset($_GET['edit'])) echo "<input style=' font-size:12pt;' name='form' size='8' value='$wordforms[$j]'>";
		
		if (!isset($_GET['edit'])&&($types[$j]!="")) echo "<i>[".$types[$j]."]</i> ";
		elseif (isset($_GET['edit'])) echo " <input type='text' style='font-style:italic;font-size:14px;' name='type' size='10' value='$types[$j]'>";
		if (!isset($_GET['edit'])&&($uses[$j]!="")) echo "<i>".$uses[$j]."</i> ";
		if (isset($_GET['edit'])) echo "<br>";
		if (!isset($_GET['edit']))
		{
		if (strpos($meanings[$j],";"))
		{
			echo ": ";
			echo "<br><ul class='meaning'>";
			$meaning = explode(";",$meanings[$j]);
			for ($i=0;$i<sizeof($meaning);++$i)
			{
				echo "<li>".$meaning[$i]."</li>";
			}
			echo "</ul>";
		}
		else echo ": ".$meanings[$j]."<br>";
		}
		else echo "<textarea type='text' name='meaning' rows='5' cols='34'>$meanings[$j]</textarea>";
		
		if (!isset($_GET['edit']))
		{
		if (substr_count($examples[$j],".")+substr_count($examples[$j],"?")>1)
		{
			echo "<ul class='example'>";
			//$example = explode(";",examples[$j]);
			$example = explode(".",$examples[$j]);
			for ($i=0;$i<sizeof($example);++$i)
			{
				if ($example[$i]!="")echo "<li>".$example[$i].".</li>";
			}
			echo "</ul>";
		}
		elseif($examples[$j]!="") echo "<ul class='example'>"."<li>".$examples[$j]."</li></ul>";
		//echo "<small>[<a href='vocab.php?edit=".$words[$j]."'>Edit</a>]</small>";
		}
		else echo  "<textarea type='text' name='example' rows='5' cols='28' >$examples[$j]</textarea>";
		
		if (isset($_GET['edit'])) echo "<br><small>[<a href='vocab.php?delete=".$words[$j]."'>Delete</a>]</small>";
		if (isset($_GET['edit'])){echo "<input type='submit' name='save' value='save'><br>";}
		if (isset($_GET['edit'])) echo"</form>";
		if (!isset($_GET['edit'])) echo"<hr>";
		else echo"<br><br>";
	}
	
	if (!$num) echo "You haven't added any words yet.";
?>
</div>
</body>
</html>