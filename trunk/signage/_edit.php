<?
	include_once($BF.'components/edit_functions.php');
	// Set the basic values to be used.
	//   $table = the table that you will be connecting to to check / make the changes
	//   $mysqlStr = this is the "mysql string" that you are going to be using to update with.  This needs to be set to "" (empty string)
	//   $sudit = this is the "audit string" that you are going to be using to update with.  This needs to be set to "" (empty string)
	$table = 'Signage';
	$mysqlStr = '';
	$audit = '';

	// "List" is a way for php to split up an array that is coming back.  
	// "set_strs" is a function (bottom of the _lib) that is set up to look at the old information in the DB, and compare it with
	//    the new information in the form fields.  If the information is DIFFERENT, only then add it to the mysql string to update.
	//    This will ensure that only information that NEEDS to be updated, is updated.  This means smaller and faster DB calls.
	//    ...  This also will ONLY add changes to the audit table if the values are different.
	list($mysqlStr,$audit) = set_strs($mysqlStr,'txtOriginal',$info['txtOriginal'],$audit,$table,$info['ID']);
	
	// if nothing has changed, don't do anything.  Otherwise update / audit.
	if($mysqlStr != '') { 
		$_SESSION['infoMessages'][] = "All changes Saved.";
		list($str,$aud) = update_record($mysqlStr, $audit, $table, $info['ID']);
		db_query("UPDATE ".$table." SET dtMarcomAdded=now() WHERE ID=".$info['ID'],"Update DT");
		if($info['dtMarcomAdded'] == '') { // Initial Submission
			
			$stationinfo = db_query("SELECT chrStation FROM Stations WHERE id='".$info['idStation']."'","Get Station Name",1);
			
			
			$info['chrEmail'] = $_SESSION['chrEmail'];
			$info['chrSubject'] = "Signage Submission.";
			$info['txtMsg'] = "
<p>Dear ".$_SESSION['chrFirst']." ".$_SESSION['chrLast'].",</p>
 
<p>Thank you for submitting your content for the ".$stationinfo['chrStation']." demo. Below is the content you have submitted:</p>
 
<p>".$_POST['txtOriginal']."</p>
 
<p>If you need to make any changes to your content, please log back in to the staffing tool, <a href='http://ciscostaffing.techitweb.com'>http://ciscostaffing.techitweb.com/</a>, and follow these steps:</p>
 
<p><strong>Step 1</strong>: Click on the Signage Submission section in the right hand bar under My Information. You will see the list of your respective demos.<br />
<strong>Step 2</strong>: Click on the demo you would like to update<br />
<strong>Step 3</strong>: Type in your content in the signage field. Click on Save and you will return to the Marcom Signage section.</p>
 
<p>Once the content has been approved by Corporate Identity & Branding, you will be alerted via email. For any questions, please contact <a href='mailto:ciscolive09-booth-support@external.cisco.com'>ciscolive09-booth-support@external.cisco.com</a>.</p>
 
<p>Thank you,<br />
The Cisco Live Main Booth Support Team</p>";
			// send E-mail
			include($BF .'includes/_emailer.php');
			
		
		}
		
	 } else {
	 	$_SESSION['infoMessages'][] = "No Changes have been made";
	 }
	
	header("Location: index.php");
	die();	
?>