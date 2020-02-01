<?php
	$BF = '../';
	$now = date('m-d-Y');
	ob_clean(); 	
	$event = decode(str_replace(' ','_',$_SESSION['chrEvent']));
	$now = date('m-d-Y');
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=".$event."-Matrix-".$now.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	$q = "SELECT ID, chrLocation
			FROM Locations 
			WHERE !bDeleted AND Locations.idEvent='". $_SESSION['idEvent'] ."' AND bStaffingEnabled AND ID = '".$_REQUEST['ID']."'
			ORDER BY chrLocation ASC";

	$location_results = db_query($q,"Getting Locations");
	$locations = array();
	while($row = mysqli_fetch_assoc($location_results)) {
		$locations[$row['ID']] = $row['chrLocation'];	
	}
	$q = "SELECT ID, idLocation, DATE_FORMAT(dDate,'%a. %b. %e, %Y') as dDate, DATE_FORMAT(tBegin, '%l:%i %p') as tBegin, DATE_FORMAT(tEnd, '%l:%i %p') as tEnd, dDate as dOrder, tBegin as tStartTime
		FROM Shifts
		WHERE !Shifts.bDeleted
		ORDER BY dOrder, tStartTime";
	$shift_result = db_query($q, 'get Shifts');
	
	$shifts = array();
	while ($row = mysqli_fetch_assoc($shift_result)) {
		$shifts[$row['idLocation']][$row['ID']] = $row['dDate'].' - '.$row['tBegin'].' to '.$row['tEnd'];
	}

	$q = "SELECT CONCAT(chrNumber,' - ',chrStation) as chrDisplay,chrFirst,chrLast,idPerson,dDate,tBegin,Shifts.idLocation,Stations.ID as idStation,Shifts.ID as idShift, Schedule.dtCheckin
		FROM Stations
		LEFT JOIN Shifts USING (idLocation) 
		LEFT JOIN Schedule ON Schedule.idStation=Stations.ID && Schedule.idShift=Shifts.ID 
		LEFT JOIN People ON Schedule.idPerson=People.ID
		WHERE !Stations.bDeleted
		ORDER BY chrNumber, chrStation, idStation, Shifts.dDate, Shifts.tBegin
	";
	$data_result = db_query($q,'getting data');
	
	$stationresults = array();
	while($row = mysqli_fetch_assoc($data_result)) {

		$stationresults[$row['idLocation']][$row['idStation']]['chrDisplay'] = $row['chrDisplay'];	
		if($row['idPerson'] == '') { 
			$stationresults[$row['idLocation']][$row['idStation']][$row['idShift']] = '<Empty>';
		} else if($row['idPerson'] == '0') {
			$stationresults[$row['idLocation']][$row['idStation']][$row['idShift']] = '-Not Required-';
		} else {
			$stationresults[$row['idLocation']][$row['idStation']][$row['idShift']] = $row['chrFirst'] . ' ' . $row['chrLast'].($row['dtCheckin'] != ''?'<br /><em>Checked In at: '.date('n-d-Y g:i a',strtotime($row['dtCheckin'])).'</em>':'');
		}
	}
?>
	<table border="1">
<?
	foreach($locations AS $idLocation => $chrLocation) {

		$worksheet =& $workbook->addWorksheet(decode($chrLocation));
		$worksheet->hideGridLines();
		$column_num = 0;
		$row_num = 0;
		if(isset($shifts[$idLocation])) {
			$worksheet->setColumn($column_num, $column_num, 40);
			$worksheet->write($row_num, $column_num, ' ', $format_column_header2);
			$column_num++;
		
			foreach($shifts[$idLocation] AS $shift) {
				$worksheet->setColumn($column_num, $column_num, 50);
				$worksheet->write($row_num, $column_num, $shift, $format_column_header2);
				$column_num++;
			}
			if(isset($stationresults[$idLocation])) {
				foreach($stationresults[$idLocation] AS $k => $v) {
					$column_num = 0;
					$row_num++;
					$worksheet->write($row_num, $column_num, decode($stationresults[$idLocation][$k]['chrDisplay']), $format_column_header);
					$column_num++;
					foreach($shifts[$idLocation] AS $s => $val) {
						$worksheet->write($row_num, $column_num, decode($stationresults[$idLocation][$k][$s]), $format_data);
						$column_num++;
					}
				}
			} else {
				$column_num = 0;
				$row_num++;
				$worksheet->write($row_num, $column_num, 'No Stations found for this location', $format_column_header3);
			}
		} else {
			$column_num = 0;
			$row_num++;
			$worksheet->setColumn($column_num, $column_num, 40);
			$worksheet->write($row_num, $column_num, 'No Shifts found for this location', $format_column_header3);
		}
	}


		<tr>
			<td style="font-weight:bold;">Room Name</td>
			<td style="font-weight:bold;">Room Number</td>	
			<td style="font-weight:bold;">Building Name</td>
			<td style="font-weight:bold;">Move In</td>
			<td style="font-weight:bold;">Move Out</td>
		</tr>
<?
	$count=0;
	while($row = mysqli_fetch_assoc($results)) {
?>
		<tr>
			<td><?=decode($row['room_name'])?></td>
			<td><?=decode($row['room_number'])?></td>
			<td><?=decode($row['building_name'])?></td>
			<td><?=decode(pretty_datetime($row['move_in']))?></td>
			<td><?=decode(pretty_datetime($row['move_out']))?></td>
		</tr>
<?
	}
?>
	</table>
<?
	exit;
	die();
?>
