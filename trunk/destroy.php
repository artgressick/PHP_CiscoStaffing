<?php
	//session_name(str_replace(' ','_',$PROJECT_NAME));
	session_start();
	
	$_SESSION['chrEmail'] = '';
	$_SESSION['idPerson'] = '';
	$_SESSION['chrFirst'] = '';
	$_SESSION['chrLast'] = '';
	$_SESSION['bAdmin'] = '';
	$_SESSION['idLevel'] = '';
	$_SESSION['dtLogin'] = '';
	$_SESSION['idEvent'] = '';
	$_SESSION['chrEvent'] = '';
?>
<meta http-equiv="refresh" content="0;url=http://ciscostaffing.techitweb.com/logout.php?id=<?=$_REQUEST['reason']?>">