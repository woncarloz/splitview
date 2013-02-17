<?php

// By woncarloz2@yahoo.com
// ver021613
// File Description: PHP script that shows sites side by side if you pass a $left and $right var in a frameset.
// This work is licensed under the Creative Commons Attribution-ShareAlike 3.0 Unported License. To view a copy of this license, visit http://creativecommons.org/licenses/by-sa/3.0/.


$left = $_GET["left"];
$right = $_GET["right"];
$replace = $_GET["replace"];

if (empty($left)) {
	$left = "http://web.archive.org/web/19970404064352/http://www.apple.com/";
}

if (empty($right)) {
	$right = "http://www.apple.com/";
}

if ($_GET["submit-diff"] == "View Diff! ")  {
	header( 'Location: view_diff2.php?site1='.$left.'&site2='.$right ) ;
}



if (!empty($replace))  {
	$right_array = explode (".com", $left);
	$right = "http://".$replace.$right_array [1];
}


if (!empty($_GET["header_frame"]))  {
	if ($_GET["edit"] == "on") {
		$edit = "<a href=index.php?left=".$left."&right=".$right."&edit=true target=_top>Edit</a>
		 | <a href=index.php?left=".$left."&right=".$right."&edit=true&tinyurl=create target=_top>TinyURL</a>
		 &nbsp; &nbsp; &nbsp; &nbsp;  ";
	} elseif ($_GET["edit"] == "off") {
		$edit = "<a href=index.php?left=".$left."&right=".$right." target=_top>[Leave Batch View]</a>
		 &nbsp; &nbsp; &nbsp; &nbsp;  ";
	}
	echo "<small><strong>".$edit."<big><a href=".$_GET["header_frame"]." target=_top>".$_GET["header_frame"]."</a></big></strong></small>";
	exit;
}




if ((empty($_GET["tinyurl"])) && ((!empty($_GET["left"])) || (!empty($_GET["right"]))) && (empty($_GET["edit"])) ) {  
	
	if ($_GET["show_edit"] == "off") {
		$edit = "off";
	} else {
		$edit = "on";
	}
	
	echo "<html>\n<head>\n<title>Split Viewer</title>\n</head>\n";	
	echo "<frameset cols='50,50' frameborder='yes' border='20' framespacing='0'>\n";
	echo "<frameset rows='29,*' frameborder='yes' border='1' framespacing='0'>\n";

	echo "<frame src='index.php?header_frame=".$left."&edit=".$edit."&left=".$left."&right=".$right."' scrolling='no' id='leftFrame' name='leftFrame' title='leftFrame' />\n";
	echo "<frame src='".$left."' scrolling='yes' id='rightFrame' name='rightFrame' title='rightFrame' /></frameset>\n";

	echo "<frameset rows='25,*' frameborder='no' border='1' framespacing='0'>\n";

	echo "<frame src='index.php?header_frame=".$right."' scrolling='no' id='leftFrame' name='leftFrame' title='leftFrame' />\n";
	echo "<frame src='".$right."' scrolling='yes' id='rightFrame' name='rightFrame' title='rightFrame' />\n";

	echo "</frameset></frameset></frameset>\n<noframes><body></body></noframes>\n</html>";


} else {

	// Show form
	echo '<!DOCTYPE html><head><title></title>';
	echo '<link rel="stylesheet" type="text/css" href="splitview.css"></head><body class="benefits top"><section class="signup_strip home"><div class="signup">';
	echo "<center><form class='signup_form'><h2>Split Frame Viewer</h2>";
	echo "<h3>Allows you to view two Web sites side by side.</h3>";

	echo '<table border=0><tr><td align=center>';
	echo 'Left Frame<br><input size="128" type="text" name="left" title="Left side URL" value="'.$left.'" />';


	echo '</label></td><td align=center>';
	echo 'Right Frame<br><input type="text" name="right" title="Right side URL" value="'.$right.'" />';

	echo "</td></tr></table>";

	if (!empty($_GET["tinyurl"]))  {
		//$tinry_url_source = str_replace("&tinyurl=create", "", $_SERVER['HTTP_REFERER']);
		$tinry_url_source = "http://".$_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"]."?left=".$left."&right=".$right;
		$tinry_url = get_tiny_url($tinry_url_source);
		//echo "tinry_url_source = ".$tinry_url_source."<br>"; // DEBUG
		echo "<a href=".$tinry_url.">".$tinry_url."</a>";
	}

	echo '<p><input type="submit" name="submit-split" value="View Split!"/> ';
	echo '<input type="submit" name="submit-diff" value="View Diff! "/><p>';
	echo '<br><a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/deed.en_US"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-sa/3.0/80x15.png" /></a><br /><small><span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/InteractiveResource" property="dct:title" rel="dct:type">Split Viewer</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="http://woncarloz2.net16.net/splitview/" property="cc:attributionName" rel="cc:attributionURL">woncarloz</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/deed.en_US">Creative Commons Attribution-ShareAlike 3.0 Unported License</a>.<br />Based on a work at <a xmlns:dct="http://purl.org/dc/terms/" href="https://github.com/woncarloz/splitview.git" rel="dct:source">https://github.com/woncarloz/splitview.git</a>.</small>';
	echo "</form></section></center></div>";
	echo '<p><center>Example Split Result<br><img alt="Example Split Result" src="https://www.evernote.com/shard/s22/sh/b55f41bc-12a8-40ef-b05b-c48ff5768143/a4f881b14ef934be9d04c68f3fd6f131/res/637b7822-9859-4f04-ba5a-fd9ec6cd7a4a/skitch.png" />';
	echo "</center></body></html>";

	

}


// Tinyurl API
/////////////////////////////////////////

function get_tiny_url($url)  {  
  $ch = curl_init();  
  $timeout = 5;  
  curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
  $data = curl_exec($ch);  
  curl_close($ch);  
  return $data;  
}



?>
