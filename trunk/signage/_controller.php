<?
	# This is the BASE FOLDER pointing back to the root directory
	$BF = '../';
	
	preg_match('/(\w)+\.php$/',$_SERVER['SCRIPT_NAME'],$file_name);
    $post_file = '_'.$file_name[0];

	switch($file_name[0]) {
		#################################################
		##	Index Page
		#################################################
		case 'index.php':
			$title = "Marcom Signage";	# Page Title
			$directions = 'Select a Signage from the list to add/update.';
			# Adding in the lib file
			include($BF .'_lib.php');
			# Auth Check, enable this if the page requires you to be logged in
			auth_check('litm','1,2,3,4');
			include_once($BF.'components/formfields.php');


			$results = db_query("SELECT s.*, z.chrZone, CONCAT(st.chrNumber,' (',st.chrStation,')') as chrStation, sp.chrProduct,  IF(s.bApproved,'Approved','Not Approved') AS chrApproved, DATE_FORMAT(s.dtMarcomAdded,'%m/%d/%Y') AS dSubmitted
				  FROM Signage AS s 
				  JOIN Zones AS z ON s.idZone=z.ID
				  JOIN Stations AS st ON s.idStation = st.ID
				  LEFT JOIN Signage_Product AS sp ON s.idProduct=sp.ID AND !sp.bDeleted
		 		  WHERE !s.bDeleted AND !z.bDeleted AND !st.bDeleted AND s.idMarcomLead='". $_SESSION['idPerson'] ."'
				  ORDER BY s.dtMarcomAdded, s.dtAdded
			","getting info"); // Get Info
			
			if(mysqli_num_rows($results) == 1) {
				$info = mysqli_fetch_assoc($results);
				header("Location: edit.php?key=".$info['chrKEY']);
				die();
			}
		
			# Stuff In The Header
			function sith() { 
				global $BF;
				?><script type='text/javascript' src='<?=$BF?>includes/overlays.js'></script><?
				include($BF .'components/list/sortlistjs.php');
			}

			# Stuff On The Bottom
			function sotb() { 
				global $BF;
				$tableName = "Signage";
				include($BF ."includes/overlay.php");
			}

			# The template to use (should be the last thing before the break)
			$page_title = 'Marcom Signage';
			include($BF ."models/template.php");		
			
			break;

		#################################################
		##	Edit Page
		#################################################
		case 'edit.php':
			$title = "Add/Modify Signage";	# Page Title
			# Adding in the lib file
			include($BF .'_lib.php');
			# Auth Check, enable this if the page requires you to be logged in
			auth_check('litm','1,2,3,4');
			include($BF.'components/formfields.php');
			
			# Check for KEY, if not Error, Get $info, Error if no results
			if(!isset($_REQUEST['key']) || $_REQUEST['key'] == "") { errorPage('Invalid Signage Section'); } // Check Required Field for Query

			$info = db_query("SELECT * 
								FROM Signage 
								WHERE chrKEY='". $_REQUEST['key'] ."'
			","getting info",1); // Get Info
				
			if($info['ID'] == "") { errorPage('Invalid Signage Section'); } // Did we get a result?
			
			$eventinfo = db_query("SELECT * FROM Events WHERE ID='".$_SESSION['idEvent']."'","Get Event Info",1);
			
			if(isset($_POST['txtOriginal'])) { include($post_file); }

			# Stuff In The Header
			function sith() { 
				global $BF;
			
?>	<script type='text/javascript'>var page = 'edit';</script>
	<script type='text/javascript' src='error_check.js'></script>
<?

			}

			# The template to use (should be the last thing before the break)
			$page_title = 'Add/Modify Signage';
			$directions = 'Add/Update Signage below and click "Save"';
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