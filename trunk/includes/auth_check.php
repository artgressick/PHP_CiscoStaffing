<?
	$_SESSION['errorMessages'] = array();
	if (isset($_POST['auth_form_name'])) {  // check to see if this is a submission of the login form
		$auth_form_name = strtolower($_REQUEST['auth_form_name']);

		$q = "SELECT *
			FROM People 
			WHERE !bDeleted AND idPersonStatus NOT IN (4,5) AND chrEmail='" . $auth_form_name . "'
		";
		$result = db_query($q, "auth_check: verifying Email.");
		
		if (mysqli_num_rows($result)) {
			$pass = sha1($_POST['auth_form_password']);
			$row = mysqli_fetch_assoc($result);
			
			if($pass == $row['chrPassword'] && $row['bLocked'] != 1) {
				
				# This gets the browser statistics for easy searching
				$browser = get_browser(null, true);
				$q = "INSERT INTO VisitorStatistics SET
					dtCreated=now(),
					dbBrowserVersion='". $browser['version'] ."',
					chrBrowser='". $browser['browser'] ."',
					chrBrowserParent='". $browser['parent'] ."',
					chrPlatform='". $browser['platform'] ."',
					chrBrowserNamePattern='". $browser['browser_name_pattern'] ."',
					chrUserAgent='". $_SERVER['HTTP_USER_AGENT'] ."'
				";
				db_query($q,"insert visitor information");

				# Set the session variables that will be used in the rest of the site
				$_SESSION['chrEmail'] = $row["chrEmail"];
				$_SESSION['idPerson'] = $row["ID"];
				$_SESSION['chrFirst'] = $row["chrFirst"];
				$_SESSION['chrLast'] = $row["chrLast"];
				$intAttempts = $row["intAttempts"];
				$_SESSION['bAdmin'] = $row['bAdmin'];
				$_SESSION['bMarcom'] = $row['bMarcom'];
				$_SESSION['idLevel'] = 4;
				$_SESSION['dtLogin'] = date('m/d/Y H:m:s');

				# This resets their login attempts after the total amount of failed attempts was logged
				db_query("UPDATE People SET intAttempts=0 WHERE ID=". $row['ID'],'increment logins');
				db_query("INSERT INTO LoginAttempts SET idPerson='". $row['ID'] ."', dtCreated=now(), idLoginAttemptType=1",'success login record');
				if(isset($intAttempts) && $intAttempts > 0) {
					$_SESSION['infoMessages'][] = "NOTICE! There has been ".$intAttempts." failed login attempts on this account since your last login!";
				}
				# This sends the user to whatever page they were originally trying to get to before being stopped to login
				header('Location: ' . $_SERVER['REQUEST_URI']);
				die();
			} else {
				if(!$row['bLocked']) {
					if($row['intAttempts'] == 4) {
						# If the account failed to log in 5 times, lock their account and send them to the "Blocked" page.
						db_query("UPDATE People SET intAttempts=intAttempts+1,bLocked=1 WHERE ID=". $row['ID'],'increment logins');
						db_query("INSERT INTO LoginAttempts SET idPerson='". $row['ID'] ."', dtCreated=now(), idLoginAttemptType=3",'insert login attempt record');
						header('Location: '. $BF .'locked.php');
						die();
					} else {
						# If the aacount failed to log in, but is under 5 attempts, show them the generic message and log the attempt
						$_SESSION['errorMessages'][] = "Authentication failed<!--(1)-->.";
						db_query("INSERT INTO LoginAttempts SET idPerson='". $row['ID'] ."', dtCreated=now(), idLoginAttemptType=2",'insert login attempt record');
						db_query("UPDATE People SET intAttempts=intAttempts+1 WHERE ID=". $row['ID'],'increment logins');
					}
				} else {
					# If the account is locked, send them to the "Blocked" page.
					header('Location: '. $BF .'locked.php');
					die();
				}
			}
		} else {
			# Nothing came back for this email address in the DB.  Generic message ensues.
			echo(mysql_error());
			$_SESSION['errorMessages'][] = "Authentication failed<!--(2)-->.";
		}
	
	}

	# if they need to be log in for the current page and currently are not yet logged in, send them to the login page.
	include_once($BF.'components/formfields.php');
	include($BF . "login.php");
	include($BF ."models/nonav.php");		
	die();
?>
