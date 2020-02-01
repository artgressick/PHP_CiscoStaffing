<?
	# This is the BASE FOLDER pointing back to the root directory
	$BF = '';
	
	preg_match('/(\w)+\.php$/',$_SERVER['SCRIPT_NAME'],$file_name);
    $post_file = '_'.$file_name[0];

	switch($file_name[0]) {
		#################################################
		##	Index Page
		#################################################
		case 'index.php':
			//$title = "Welcome to Cisco Staffing";	# Page Title
			# Adding in the lib file
			include($BF .'_lib.php');
			auth_check('litm','1,2,3,4');
			include_once($BF.'components/formfields.php');
			
			# Stuff In The Header
			function sith() { 
				global $BF;
				include($BF .'components/list/sortlistjs.php');
			}

			# The template to use (should be the last thing before the break)
			$page_title = 'Welcome to '.$PROJECT_NAME;
			include($BF ."models/template.php");		
			
			break;
		#################################################
		##	Make iCal Page
		#################################################
		case 'makeical.php':
//			$NON_HTML_PAGE=1;

			include($BF .'_lib.php');
			include($BF.'components/add_functions.php');
			# Stuff In The Header
			function sith() { 
				global $BF;
			}
			$key = makekey();
			$query = "SELECT SCH.ID, E.chrEvent, L.chrLocation, S.dDate, S.tBegin, S.tEnd, ST.chrStation, ST.chrNumber
						FROM Schedule AS SCH
						JOIN Stations AS ST ON SCH.idStation=ST.ID
						JOIN Shifts AS S ON SCH.idShift=S.ID
						JOIN Locations AS L ON ST.idLocation=L.ID AND S.idLocation=L.ID
						JOIN Events AS E ON L.idEvent=E.ID
						WHERE SCH.idPerson=".$_SESSION['idPerson']."
						ORDER BY dBegin, tBegin, tEnd";
			
			$q = "INSERT INTO CalendarQueries SET 
				chrKEY='". $key ."',
				dtCreated=now(),
				idPerson='". $_SESSION['idPerson'] ."',
				chrCalendarQuery='". encode($query) ."'
			";	
			if(db_query($q,"Inserting Query into Database")) {
				require_once($BF.'components/browser.php');
				$br = new Browser;
				if($br->Platform == 'Windows') {
					header("Location: ".$PROJECT_ADDRESS."outlookcal.php?k=". $key);
				} else {
					$ICAL_ADDRESS = str_replace('http://','webcal://',$PROJECT_ADDRESS);
					header("Location: ".$ICAL_ADDRESS."ical.php?k=". $key);
				}
			}	
			# The template to use (should be the last thing before the break)
			$page_title = 'iCal Subscribe';
			include($BF ."models/template.php");		
			
			break;
		#################################################
		##	Log Out Page
		#################################################
		case 'logout.php':
			$page_title = "Logged Off";	# Page Title
			# Adding in the lib file
			include($BF .'_lib.php');
			# Stuff In The Header
			function sith() { 
				global $BF;
			}

			# The template to use (should be the last thing before the break)
			include($BF ."models/nonav.php");		
			
			break;
		#################################################
		##	Error Page
		#################################################
		case 'error.php':
			$page_title = "Error Page";	# Page Title
			# Adding in the lib file
			include($BF .'_lib.php');
			include_once($BF.'components/formfields.php');

			# Stuff In The Header
			function sith() { 
				global $BF;
			}

			# The template to use (should be the last thing before the break)
			include($BF ."models/nonav.php");		
			
			break;
		#################################################
		##	Error Page
		#################################################
		case 'locked.php':
			$page_title = "Account Locked";	# Page Title
			# Adding in the lib file
			include($BF .'_lib.php');
			include_once($BF.'components/formfields.php');

			# Stuff In The Header
			function sith() { 
				global $BF;
			}

			# The template to use (should be the last thing before the break)
			include($BF ."models/nonav.php");		
			
			break;

		#################################################
		##	Instructional Video
		#################################################
		case 'instructions.php':
			//$title = "Welcome to Cisco Staffing";	# Page Title
			# Adding in the lib file
			include($BF .'_lib.php');
			auth_check('litm','1,2,3,4');
			include_once($BF.'components/formfields.php');
			
			# Stuff In The Header
			function sith() { 
				global $BF;
?>
		<script type="text/javascript" src="<?=$BF?>includes/flowplayer-3.0.6.min.js"></script>
<?
			}

			# The template to use (should be the last thing before the break)
			$page_title = 'Welcome to '.$PROJECT_NAME;
			include($BF ."models/template.php");		
			
			break;
		#################################################
		##	Old Checkin Page
		#################################################
/*		case 'checkin.php':
			//$title = "Welcome to Cisco Staffing";	# Page Title
			# Adding in the lib file
			include($BF .'_lib.php');
			auth_check('litm','1');
			include_once($BF.'components/formfields.php');
			
			# Stuff In The Header
			function sith() { 
				global $BF;
?>
				<script type="text/javascript" src="<?=$BF?>includes/forms.js"></script>
				<script type='text/javascript' src='<?=$BF?>includes/overlays.js'></script>
				<script type="text/javascript">

					var totalErrors = 0;

					function submitbadge() {
						if(totalErrors != 0) { reset_errors(); }  
						
						totalErrors = 0;

						if(errEmpty('badgenum', "You must enter a Badge Number.")) { totalErrors++; }
						
						if(totalErrors == 0) {
							reset_errors();
							var badgeid_tmp = document.getElementById('badgenum').value;
							
							var badgeid = badgeid_tmp.split('*');
							
							checkbadge("<?=$BF?>",badgeid[1]);
							
							
						}
						
						
					}
					
					function ifEnter(field,event) {
						var theCode = (event.keyCode ? event.keyCode : (event.which ? event.which : event.charCode));
						if (theCode == 13) {
							submitbadge();
							return false;
						} else {
							return true;
						}
					}
				</script>
<?				
			}

			# The template to use (should be the last thing before the break)
			$page_title = 'Event Checkin ';
			$bodyParams = "document.getElementById('badgenum').focus();";
			include($BF ."models/nonav.php");
			
			break;
*/		#################################################
		##	Staffing Checkin
		#################################################
		case 'staffingcheckin.php':
			//$title = "Welcome to Cisco Staffing";	# Page Title
			# Adding in the lib file
			include($BF .'_lib.php');
			auth_check('litm','1');
			include_once($BF.'components/formfields.php');
			
			# Stuff In The Header
			function sith() { 
				global $BF;
				include($BF .'components/list/sortlistjs.php');
?>
				<script type="text/javascript" src="<?=$BF?>includes/forms.js"></script>
				<script type='text/javascript' src='<?=$BF?>includes/overlays.js'></script>
				<script type="text/javascript">
					function submit_form() {
						document.getElementById('idForm').submit();
					}
				
					function reset_search() {
						window.location.href='staffingcheckin.php';
					}
				</script>
<?
				
			}

			# The template to use (should be the last thing before the break)
			$page_title = 'Event Checkin ';
			$bodyParams = "document.getElementById('last_name').focus();";
			include($BF ."models/nonav.php");
			
			break;
		#################################################
		##	Staffing Checkin Page 2
		#################################################
		case 'checkinperson.php':
			//$title = "Welcome to Cisco Staffing";	# Page Title
			# Adding in the lib file
			include($BF .'_lib.php');
			auth_check('litm','1');
			include_once($BF.'components/formfields.php');

			# Check for KEY, if not Error, Get $info, Error if no results
			if(!isset($_REQUEST['key']) || $_REQUEST['key'] == "") { errorPage('Invalid Staffer'); } // Check Required Field for Query

			$info = db_query("SELECT * 
								FROM People 
								WHERE chrKEY='". $_REQUEST['key'] ."'
			","getting info",1); // Get Info
				
			if($info['ID'] == "") { errorPage('Invalid Staffer'); } // Did we get a result?


			
			# Stuff In The Header
			function sith() { 
				global $BF;
				include($BF .'components/list/sortlistjs.php');
?>
				<script type="text/javascript" src="<?=$BF?>includes/forms.js"></script>
				<script type='text/javascript' src='<?=$BF?>includes/overlays.js'></script>
				<script type="text/javascript">
					function reset_search() {
						window.location.href='staffingcheckin.php';
					}
				</script>
<?
				
			}

			# The template to use (should be the last thing before the break)
			$page_title = 'Event Checkin ';
			$bodyParams = "document.getElementById('last_name').focus();";
			include($BF ."models/nonav.php");
			
			break;
		#################################################
		##	Staffing Checkin Page 3
		#################################################
		case '_checkin.php':
			//$title = "Welcome to Cisco Staffing";	# Page Title
			# Adding in the lib file
			include($BF .'_lib.php');
			auth_check('litm','1');

			# Check for KEY, if not Error, Get $info, Error if no results
			if(!isset($_REQUEST['ID']) || !is_numeric($_REQUEST['ID'])) { errorPage('Invalid Shift'); } // Check Required Field for Query

			if(db_query("UPDATE Schedule SET dtCheckin=now() WHERE ID='".$_REQUEST['ID']."'","Checkin Staffer")) {
				$_SESSION['infoMessages'][] = $_SESSION['checkin_name']." is Checked In Successfully.";
				header("Location: staffingcheckin.php");
				die();	
			}
			
			# Stuff In The Header
			function sith() { 
				global $BF;
			}

			# The template to use (should be the last thing before the break)
			
			break;


		#################################################
		##	Else show Error Page
		#################################################
		default:
			include($BF .'_lib.php');
			errorPage('Page Incomplete.  Please notify an Administrator that you have received this error.');
	}

?>