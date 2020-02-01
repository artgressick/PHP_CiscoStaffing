<?php
	$BF = '../';
	$now = date('m-d-Y');
	ob_clean(); 	
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=Signage_".$now.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
?>
	<table border="1">
		<tr>
			<td style="font-weight:bold;">Zone</td>
			<td style="font-weight:bold;">Station</td>	
			<td style="font-weight:bold;">Demo/Product</td>
			<td style="font-weight:bold;">Marcom Lead</td>
			<td style="font-weight:bold;">Approval</td>
			<td style="font-weight:bold;">Submitted/Updated On</td>
			<td style="font-weight:bold;">Original</td>
			<td style="font-weight:bold;">Admin Version</td>
		</tr>
<?
	$count=0;
	while($row = mysqli_fetch_assoc($results)) {
?>
		<tr>
			<td><?=decode($row['chrZone'])?></td>
			<td><?=decode($row['chrStation'])?></td>
			<td><?=decode($row['chrProduct'])?></td>
			<td><?=decode($row['chrPerson'])?></td>
			<td><?=decode($row['chrApproved'])?></td>
			<td><?=decode($row['dSubmitted'])?></td>
			<td><?=decode($row['txtOriginal'])?></td>
			<td><?=decode($row['txtUpdated'])?></td>
		</tr>
<?
	}
?>
	</table>
<?
	exit;
	die();
?>