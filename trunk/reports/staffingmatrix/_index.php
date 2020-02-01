<?php
	$now = date('m-d-Y');
	ob_clean(); 	
	header("Content-type: application/octet-stream");
	$event = decode(str_replace(' ','_',$_SESSION['chrEvent']));
	$now = date('m-d-Y');
	
	$q = "SELECT ID, chrLocation
			FROM Locations 
			WHERE !bDeleted AND Locations.idEvent='". $_SESSION['idEvent'] ."' AND bStaffingEnabled AND ID = '".$_REQUEST['idLocation']."'
			ORDER BY chrLocation ASC";

	$location = db_query($q,"Getting Locations",1);	
	
	$location['chrLocation'] = decode(str_replace(' ','_',$location['chrLocation']));
	 	
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=".$event."-".$location['chrLocation']."-Matrix-".$now.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	// get list of AS_Shifts for this location
	$query = "SELECT ID, idLocation, DATE_FORMAT(dDate,'%W<br />%M %d, %Y') as dDate, DATE_FORMAT(tBegin, '%l:%i %p') as tBegin, DATE_FORMAT(tEnd, '%l:%i %p') as tEnd, dDate as dOrder, tBegin as tStartTime
		FROM Shifts
		WHERE !Shifts.bDeleted AND Shifts.idLocation = '" . $_REQUEST['idLocation'] . "'
		ORDER BY dOrder, tStartTime";
	$shift_result = db_query($query, 'get Shifts');
	
	$total_shifts = mysqli_num_rows($shift_result);
	
	$shifts = array();
	while ($row = mysqli_fetch_assoc($shift_result)) {
		$shifts[$row['ID']] = '<center>'.$row['dDate'].'<br />'.$row['tBegin'].' to '.$row['tEnd'].'</center>';
	}
	$cell_width = floor(100 / ($total_shifts + 1));

	$q = "SELECT CONCAT(chrNumber,' - ',chrStation) as chrDisplay,chrFirst,chrLast, chrMobilePhone,idPerson,dDate,tBegin,Shifts.idLocation,Stations.ID as idStation,Shifts.ID as idShift, Schedule.dtCheckin
		FROM Stations
		LEFT JOIN Shifts USING (idLocation) 
		LEFT JOIN Schedule ON Schedule.idStation=Stations.ID && Schedule.idShift=Shifts.ID 
		LEFT JOIN People ON Schedule.idPerson=People.ID
		WHERE !Stations.bDeleted AND Stations.idLocation='" . $_REQUEST['idLocation'] . "'
		ORDER BY chrNumber, chrStation, idStation, Shifts.dDate, Shifts.tBegin
	";
	$data_result = db_query($q,'getting data');
	
	$stationresults = array();
	$check = '';
	while($row = mysqli_fetch_assoc($data_result)) {
		if($check != $row['idStation']) {
			$check = $row['idStation'];
			$stationresults[$row['idStation']]['chrDisplay'] = $row['chrDisplay'];	
		}
		
		if($row['idPerson'] == '') { 
			$stationresults[$row['idStation']][$row['idShift']] = '&lt;Empty&gt;';
		} else if($row['idPerson'] == '0') {
			$stationresults[$row['idStation']][$row['idShift']] = '-Not&nbsp;Required-';
		} else {
			$stationresults[$row['idStation']][$row['idShift']] = $row['chrFirst'] . ' ' . $row['chrLast']. ' ('.$row['chrMobilePhone'].')'.($row['dtCheckin'] != ''?'<br /><em>Checked In at: '.date('n-d-Y g:i a',strtotime($row['dtCheckin'])).'</em>':'');
		}
	}

?>
	<table border="1">
		<tr>
			<td></td>
<?
		foreach($shifts AS $id => $display) { 
?>
			<td style="font-weight:bold;"><?=$display?></td>
<?
		} 
		foreach($stationresults AS $idStation => $value) {
?>
		</tr>
		<tr>	
			<td style="font-weight:bold;"><?=$value['chrDisplay']?></td>
<?						
			foreach($shifts AS $k => $v) {
?>					
			<td><?=$stationresults[$idStation][$k]?></td>
<?
			}
		}
?>
		</tr>
	</table>
<?
	exit;
	die();
?>
