<?php
	require_once'header.php';
	
	if (!$loggedin) die();
	
	if (isset($_POST['action']))
	{
		
	}
?>
<h3>Dictionary Preference</h3>
<form action='setting.php'  method='post'><pre>
<label class='radio-inline'><input type='radio' name='dictionary_name' value='Long_dict'>Longman dictionary</label> 
<label  class='radio-inline'><input type='radio' name='dictionary_name' value='Oxford_dict'>Oxford dictionary</label>   
<label class='radio-inline'><input type='radio' name='dictionary_name' value='Cam_dict'>Cambridge dictionary</label>         
<label class='radio-inline'><input type='radio' name='dictionary_name' value='Urban_dict'>Urban dictionary</label>

<input type='submit' name='action' value='Save'>
</pre>
</div>
<hr>