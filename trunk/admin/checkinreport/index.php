<?
	include('_controller.php');
	
	function sitm() { 
		global $BF,$results;
	
		$tableHeaders = array(
			'chrName' 			=> array('displayName' => 'Staffer Name','default' => 'asc'),
			'datetime'			=> array('displayName' => 'Check-in Date/Time')
		);
		
		sortList('Checkin',		# Table Name
			$tableHeaders,			# Table Name
			$results,				# Query results
			'',		# The linkto page when you click on the row
			'width: 100%;border:none;', 			# Additional header CSS here
			''
		);
	}
?>