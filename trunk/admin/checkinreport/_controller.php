<?
	# This is the BASE FOLDER pointing back to the root directory
	$BF = '../../';

	preg_match('/(\w)+\.php$/',$_SERVER['SCRIPT_NAME'],$file_name);
    $post_file = '_'.$file_name[0];

	switch($file_name[0]) {
		#################################################
		##	Index Page
		#################################################
		case 'index.php':
			# Variables for the page
			$title = "Check-in Report Stations";	# Page Title

			# Adding in the lib file
			include($BF .'_lib.php');
			# Auth Check, enable this if the page requires you to be logged in
			auth_check('litm','1');
			include($BF.'components/formfields.php');
			
			$q = "SELECT c.ID, CONCAT(p.chrFirst,' ',p.chrLast) AS chrName, ADDTIME(c.dtCheckin,CONCAT(if(e.bDaylightSavings,tz.intOffset + 1,tz.intOffset),':0:0.0')) AS datetime
				FROM Checkin AS c
				JOIN People as p ON c.idPerson=p.ID 
				JOIN Events as e ON c.idEvent=e.ID 
				JOIN TimeZone AS tz ON e.idTimeZone=tz.ID
				WHERE c.idEvent='".$_SESSION['idEvent']."'
			";
				
			$results = db_query($q,"getting checkins");
			
			# Stuff In The Header
			function sith() { 
				global $BF;
				include($BF .'components/list/sortlistjs.php');
			}

			# Stuff On The Bottom
			function sotb() { 
				global $BF;
			}

			# The template to use (should be the last thing before the break)
			$page_title = 'Check-in Report <span class="resultsShown">(<span id="resultCount">'.mysqli_num_rows($results).'</span> results)</span>';
			$directions = '';
			
			include($BF ."models/template.php");		

			break;
			
		#################################################
		##	Else show Error Page
		#################################################
		default:
			include($BF .'_lib.php');
			errorPage('Page Incomplete.  Please notify an Administrator that you have received this error.');
	}

?>