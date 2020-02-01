<?php
	include('_controller.php');

	function sitm() {
		global $BF,$info;
?>
		<div style='margin:50px;'>
<?
			$_SESSION['checkin_name'] = $info['chrFirst'].' '.$info['chrLast'];
			$timezone = db_query("SELECT tz.intOffset, E.bDaylightSavings
									FROM Events AS E 
									JOIN TimeZone AS tz ON E.idTimeZone=tz.ID
									WHERE E.ID='".$_SESSION['idEvent']."'","Get TimeZone Info",1);
			
			$tzoff = ($timezone['bDaylightSavings']?$timezone['intOffset']+1:$timezone['intOffset']);
			
			$before = explode(':::',date('Y-m-d:::H:i:00', strtotime('Now +'.$tzoff.' hours + 30 minutes')));
			$after = explode(':::',date('Y-m-d:::H:i:00', strtotime('Now +'.$tzoff.' hours - 60 minutes')));

			$shifts = db_query("SELECT S.ID, L.chrLocation, St.chrStation, St.chrNumber, Sh.dDate, DATE_FORMAT(Sh.tBegin,'%l:%i %p') AS tBegin, DATE_FORMAT(Sh.tEnd,'%l:%i %p') AS tEnd
								FROM Schedule AS S
								JOIN Locations AS L ON S.idLocation=L.ID
								JOIN Shifts AS Sh ON S.idShift=Sh.ID 
								JOIN Stations AS St ON S.idStation=St.ID
								WHERE S.idEvent='".$_SESSION['idEvent']."' AND S.idPerson='".$info['ID']."' 
									AND (Sh.dDate = '".$before[0]."' OR Sh.dDate = '".$after[0]."')
									AND Sh.tBegin BETWEEN CAST('".$after[1]."' AS time) AND CAST('".$before[1]."' AS time)
									AND dtCheckin IS NULL
								ORDER BY Sh.tBegin
								
								","Getting Shifts");
?>
			<div style='padding-bottom:10px; font-weight:bold;'>Click on the shift to check-in <?=$info['chrFirst'].' '.$info['chrLast']?>. If no results are shown, then either the staffer is already checked in or they have no shift beginning in 30 minutes or 1 hour ago.</div>
<?
			$tableHeaders = array(
				'tBegin' 		=> array('displayName'=>'Begin Time','default'=>'asc'),
				'tEnd' 			=> array('displayName'=>'End Time'),
				'chrLocation' 	=> array('displayName'=>'Location'),
				'chrStation' 	=> array('displayName'=>'Station'),
				'chrNumber' 	=> array('displayName'=>'Number'),
			);
			
			sortList('Schedule',				# Table Name
				$tableHeaders,				# Table Name
				$shifts,					# Query results
				'_checkin.php?ID=',	# The linkto page when you click on the row
				'width: 100%;', 			# Additional header CSS here
				''
			);
?>
			<div style='padding-top:10px;'><input type='button' value='New Search' onclick='reset_search();' /></div>
		</div>
<?		
	}
?>