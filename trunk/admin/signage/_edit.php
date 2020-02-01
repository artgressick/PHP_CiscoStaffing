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
	list($mysqlStr,$audit) = set_strs($mysqlStr,'idZone',$info['idZone'],$audit,$table,$info['ID']);
	list($mysqlStr,$audit) = set_strs($mysqlStr,'idProduct',$info['idProduct'],$audit,$table,$info['ID']);
	list($mysqlStr,$audit) = set_strs($mysqlStr,'idStation',$info['idStation'],$audit,$table,$info['ID']);
	list($mysqlStr,$audit) = set_strs($mysqlStr,'idMarcomLead',$info['idMarcomLead'],$audit,$table,$info['ID']);
	list($mysqlStr,$audit) = set_strs($mysqlStr,'txtOriginal',$info['txtOriginal'],$audit,$table,$info['ID']);
	list($mysqlStr,$audit) = set_strs($mysqlStr,'bApproved',$info['bApproved'],$audit,$table,$info['ID']);
	list($mysqlStr,$audit) = set_strs($mysqlStr,'txtUpdated',$info['txtUpdated'],$audit,$table,$info['ID']);
	
	// if nothing has changed, don't do anything.  Otherwise update / audit.
	if($mysqlStr != '') { 
		$_SESSION['infoMessages'][] = "All changes Saved.";
		list($str,$aud) = update_record($mysqlStr, $audit, $table, $info['ID']);
		db_query("UPDATE ".$table." SET dtAdminUpdated=now() WHERE ID=".$info['ID'],"Update DT");
		
		if($_POST['bApproved']) {

			$stationinfo = db_query("SELECT chrStation FROM Stations WHERE id='".$info['idStation']."'","Get Station Name",1);
			$personinfo = db_query("SELECT * FROM People WHERE ID='".$_POST['idMarcomLead']."'","Get person Info",1);
			
			$info['chrEmail'] = $personinfo['chrEmail'];
			$info['chrSubject'] = "Signage Approved.";
			$info['txtMsg'] = "
<p>Dear ".$personinfo['chrFirst']." ".$personinfo['chrLast'].",</p>
 
<p>The content you submitted for the ".$stationinfo['chrStation']." demo has been approved by corporate editing. Below is the content that was submitted and approved:</p>
 
<p>".$_POST['txtOriginal']."</p>
 
<p>Your content will be placed into the graphic and will be sent to you to review and approve within the next couple of weeks.</p>
 
<p>Please feel free to contact Cisco Staffing at <a href='mailto:ciscolive09-booth-support@external.cisco.com'>ciscolive09-booth-support@external.cisco.com</a> for any questions regarding your signage submission.</p>
 
<p>Thank you,<br />
The Cisco Live Main Booth Support Team</p>";
			// send E-mail
			include($BF .'includes/_emailer.php');
		} else {

			$stationinfo = db_query("SELECT chrStation FROM Stations WHERE id='".$info['idStation']."'","Get Station Name",1);
			$personinfo = db_query("SELECT * FROM People WHERE ID='".$_POST['idMarcomLead']."'","Get person Info",1);
			
			$info['chrEmail'] = $personinfo['chrEmail'];
			$info['chrSubject'] = "Signage Not Approved.";
			$info['txtMsg'] = "
<p>Dear ".$personinfo['chrFirst']." ".$personinfo['chrLast'].",</p>
 
<p>The content you submitted for the ".$stationinfo['chrStation'].") demo was not approved by corporate editing. Below is the original submission:</p>
 
<p>".$_POST['txtOriginal']."</p>

<p>The edited version is:</p>

<p>".$_POST['txtUpdated']."</p>

<p>If you approve of this change, please log back into the staffing tool and follow these steps:</p>

<p><strong>Step 1</strong>: Click on the Signage Submission section in the right hand bar under My Information.<br />
<strong>Step 2</strong>: Click on the demo that shows Not Approved under the Approval column<br />
<strong>Step 3</strong>: Review the Admin Edited Version of the content<br />
<strong>Step 4</strong>: If you DO approve, simply copy and paste the Admin Edited Version content into the Signage Field and click Save. If you DO NOT approve, type in the alternate content and click on Save. You will be notified if the alternate content has been approved or not.</p>
 
<p>Please feel free to contact us if you have any questions about your submission <a href='mailto:ciscolive09-booth-support@external.cisco.com'>ciscolive09-booth-support@external.cisco.com</a>.</p>
 
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