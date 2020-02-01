<?
	# This is the BASE FOLDER pointing back to the root directory
	$BF = '../../';

	preg_match('/(\w)+\.php$/',$_SERVER['SCRIPT_NAME'],$file_name);
    $post_file = '_'.$file_name[0];
    $auth_options = 'eventnotneeded';

	switch($file_name[0]) {
		#################################################
		##	Index Page
		#################################################
		case 'index.php':
			# Variables for the page
			if(isset($_REQUEST['excel'])) { $NON_HTML_PAGE=1; }
			$title = "Manage Signage";						# Page Title
			# Adding in the lib file
			include($BF .'_lib.php');
			# Auth Check, enable this if the page requires you to be logged in
			auth_check('litm','1');
			include($BF.'components/formfields.php');
	

			$q = "SELECT s.*, z.chrZone, CONCAT(st.chrNumber,' (',st.chrStation,')') as chrStation, sp.chrProduct, CONCAT(p.chrFirst,' ',p.chrLast) as chrPerson, IF(s.bApproved,'Approved','Not Approved') AS chrApproved, DATE_FORMAT(s.dtMarcomAdded,'%m/%d/%Y %l:%i %p') AS dSubmitted, s.txtOriginal, s.txtUpdated
				  FROM Signage AS s 
				  JOIN Zones AS z ON s.idZone=z.ID
				  JOIN Stations AS st ON s.idStation = st.ID
				  LEFT JOIN Signage_Product AS sp ON s.idProduct=sp.ID AND !sp.bDeleted
				  JOIN People AS p ON s.idMarcomLead=p.ID
		 		  WHERE !s.bDeleted AND !z.bDeleted AND !st.bDeleted AND !p.bDeleted
				  ORDER BY s.dtMarcomAdded, s.dtAdded";
				
			$results = db_query($q,"getting Signage");
			
			if(isset($_REQUEST['excel'])) { include($post_file); }
			
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
			$page_title = linkto(array('address'=>'add.php','img'=>'plus_add.png','style'=>'float:left;')).'&nbsp;&nbsp;Signage <span class="resultsShown">(<span id="resultCount">'.mysqli_num_rows($results).'</span> results)</span>&nbsp;&nbsp;<input type="button" name="excel" value="Export to Excel" onclick="window.location=\'index.php?excel=true\';" />';
			$directions = 'Choose a Signage from the list below. Click on the column header to sort the list by that column.';
			include($BF ."models/template.php");		

			break;
		

 		#################################################
		##	Add Page
		#################################################
		case 'add.php':
			$title = "Add Signage Section";	# Page Title
			# Adding in the lib file
			include($BF .'_lib.php');
			# Auth Check, enable this if the page requires you to be logged in
			auth_check('litm','1');
			include($BF.'components/formfields.php');

			if(isset($_POST['idMarcomLead'])) { include($post_file); }

			# Stuff In The Header
			function sith() { 
				global $BF;
?>	<script type='text/javascript'>var page = 'add';</script>
	<script type='text/javascript' src='error_check.js'></script>
<?
			}

			# The template to use (should be the last thing before the break)
			$page_title = 'Add New Signage Section';
			$directions = 'Setup a new Signage Section for Submittion';
			include($BF ."models/template.php");	
			
			break;


		#################################################
		##	Edit Page
		#################################################
		case 'edit.php':
			$title = "View/Modify Signage Section";	# Page Title
			# Adding in the lib file
			include($BF .'_lib.php');
			# Auth Check, enable this if the page requires you to be logged in
			auth_check('litm','1');
			include($BF.'components/formfields.php');
			
			# Check for KEY, if not Error, Get $info, Error if no results
			if(!isset($_REQUEST['key']) || $_REQUEST['key'] == "") { errorPage('Invalid Signage Section'); } // Check Required Field for Query

			$info = db_query("SELECT * 
								FROM Signage 
								WHERE chrKEY='". $_REQUEST['key'] ."'
			","getting info",1); // Get Info
				
			if($info['ID'] == "") { errorPage('Invalid Signage Section'); } // Did we get a result?
			
			if(isset($_POST['idMarcomLead'])) { include($post_file); }

			# Stuff In The Header
			function sith() { 
				global $BF;
			
?>	<script type='text/javascript'>var page = 'edit';</script>
	<script type='text/javascript' src='error_check.js'></script>
<?

			}

			# The template to use (should be the last thing before the break)
			$page_title = 'Edit Signage Section';
			$directions = 'Please update the information below and press the "Update Information" when you are done making changes.';
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