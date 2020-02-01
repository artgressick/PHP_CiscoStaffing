<?php
	include('_controller.php');

	function sitm() {
		global $BF;
?>
		<div style='margin:50px;'>
<?
		if(!isset($_POST['last_name'])) {
?>			
			<div style='text-align:center;'>
			<form action="" method="post" id="idForm" onsubmit="return error_check()"> 
				Staffer Last Name: <input type='text' name='last_name' id='last_name' size='40' onchange='submit_form();'/>
				<div style="padding-top:10px;"><input type="submit" name="search" value="Search" /></div>
			</form>
			</div>
<?
		} else {
			$people = db_query("SELECT ID, chrFirst, chrLast, chrKEY FROM People WHERE !bDeleted AND idPersonStatus='3' AND chrLast like '%".strtolower(encode($_POST['last_name']))."%' ORDER BY chrLast","Getting matching staffers");
?>
			<div style='padding-bottom:10px; font-weight:bold;'>Click on staffers name to view their shifts for checkin.</div>
<?
			$tableHeaders = array(
				'chrLast' 	=> array('displayName'=>'Last Name','default'=>'asc'),
				'chrFirst' 		=> array('displayName'=>'First Name')
			);
			
			sortList('People',		# Table Name
				$tableHeaders,			# Table Name
				$people,				# Query results
				'checkinperson.php?key=',		# The linkto page when you click on the row
				'width: 100%;', 			# Additional header CSS here
				''
			);
?>
			<div style='padding-top:10px;'><input type='button' value='Back' onclick='reset_search();' /></div>
<?			
		}
?>		
		</div>
<?		
	}
?>