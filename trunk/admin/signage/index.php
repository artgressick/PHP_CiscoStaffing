<?
	include('_controller.php');
	
	function sitm() { 
		global $BF,$results;
	
	$tableHeaders = array(
		'chrZone' 		=> array('displayName'=>'Zone','default'=>'desc'),
		'chrStation' 	=> array('displayName'=>'Station'),
		'chrProduct' 	=> array('displayName'=>'Demo/Product'),
		'chrPerson' 	=> array('displayName'=>'Marcom Lead'),
		'chrApproved'	=> array('displayName'=>'Approval'),
		'dSubmitted' 	=> array('displayName'=>'Submitted/Updated On'),
		'opt_del' 	=> 'chrZone,chrPerson'
	);
	
	sortList('Signage',		# Table Name
		$tableHeaders,			# Table Name
		$results,				# Query results
		'edit.php?key=',		# The linkto page when you click on the row
		'width: 100%;border:none;', 			# Additional header CSS here
		''
	);


?>

<?	} ?>