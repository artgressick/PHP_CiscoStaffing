<?
	include('_controller.php');
	
	function sitm() { 
		global $BF,$results;
	
	$tableHeaders = array(
		'chrProduct' 	=> array('displayName'=>'Demo/Product Name','default'=>'desc'),
		'opt_del' 			=> 'chrProduct'
	);
	
	sortList('Signage_Product',		# Table Name
		$tableHeaders,			# Table Name
		$results,				# Query results
		'edit.php?key=',		# The linkto page when you click on the row
		'width: 100%;border:none;', 			# Additional header CSS here
		''
	);


?>

<?	} ?>