<?
	include_once($BF.'components/add_functions.php');
	$table = 'Locations'; # added so not to forget to change the insert AND audit

	$q = "INSERT INTO ". $table ." SET 
		chrKEY = '". makekey() ."',
		bStaffingEnabled = '". $_POST['bStaffingEnabled'] ."',
		chrLocation = '". encode($_POST['chrLocation']) ."',
		idEvent = '". $_SESSION['idEvent'] ."'
	";
	
	# if there database insertion is successful	
	if(db_query($q,"Insert into ". $table)) {

		// This is the code for inserting the Audit Page
		// Type 1 means ADD NEW RECORD, change the TABLE NAME also
		global $mysqli_connection;  // This is needed for mysqli to be able to get the "last insert id"
		$newID = mysqli_insert_id($mysqli_connection);
	
		$q = "INSERT INTO Audit SET 
			idType=1, 
			idRecord='". $newID ."',
			txtNewValue='". encode($_POST['chrLocation']) ."',
			dtDateTime=now(),
			chrTableName='". $table ."',
			idPerson='". $_SESSION['idPerson'] ."'
		";
		db_query($q,"Insert audit");
		//End the code for History Insert 
	
		$_SESSION['infoMessages'][] = "New Location: " . encode($_POST['chrEvent']) . " has been added";
		header("Location: ". $_POST['moveTo']);
		die();
	} else {
		# if the database insertion failed, send them to the error page with a useful message
		errorPage('An error has occurred while trying to add this Location.');
	}
?>