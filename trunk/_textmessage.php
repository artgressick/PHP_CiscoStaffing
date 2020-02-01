#!/usr/bin/php
<?
	set_include_path('.:/home/techit/php_includes:/usr/share/php');
	$auth_not_required = 1;
	$no_session = true;
	require('_lib.php');

	$q = "SELECT SC.ID, S.dDate, S.tBegin, S.tEnd, E.chrEvent, ST.chrStation, P.chrMobilePhone, MC.chrMethod, E.chrTextMessage
		FROM Shifts AS S
		JOIN Locations AS L ON S.idLocation=L.ID
		JOIN Events AS E ON L.idEvent=E.ID
		JOIN TimeZone AS TZ ON E.idTimeZone=TZ.ID
		JOIN Schedule AS SC ON SC.idShift=S.ID AND SC.idLocation=L.ID AND SC.idEvent=E.ID
		JOIN Stations AS ST ON SC.idStation=ST.ID
		JOIN People AS P ON SC.idPerson=P.ID
		JOIN MobileCarriers AS MC ON P.idMobileCarrier=MC.ID
		WHERE !S.bDeleted AND !L.bDeleted AND !SC.bReminderSent AND !E.bDeleted AND !P.bDeleted AND !ST.bDeleted AND !MC.bDeleted AND E.dEnd >= now() AND E.bTextMessage AND CONCAT(S.dDate,' ',S.tBegin) BETWEEN ADDTIME(now(),CONCAT(if(E.bDaylightSavings,TZ.intOffset + 2,TZ.intOffset + 1),':0:0.0')) AND ADDTIME(now(),CONCAT(if(E.bDaylightSavings,TZ.intOffset + 3,TZ.intOffset + 2),':00:00.0'))
	";
	
	$results = db_query($q,"Getting Alerts");

	$cnt = 0;
	while($row = mysqli_fetch_assoc($results)) {
		$message = $row['chrTextMessage'];
		$message = str_replace("[STATION]", $row['chrStation'], $message);
		$message = str_replace("[DATE]", date('n/j/Y',strtotime($row['dDate'])), $message);
		$message = str_replace("[START_TIME]", date('g:ia',strtotime($row['tBegin'])), $message);
		$message = str_replace("[END_TIME]", date('g:ia',strtotime($row['tEnd'])), $message);
		$message = str_replace("[EVENT]", $row['chrEvent'], $message);

		$phone = preg_replace('/(\||\'|\"|\.|\@\,| |\-|\(|\)|\+|\-|[a-zA-Z])+/','',$row['chrMobilePhone']);
		if(strlen($phone) == 11 && $phone[0] == "1") { $phone = substr($phone, 1); }
		if(strlen($phone) == 10 && $phone != '5555555555') {

			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: ciscolive09-booth-support@external.cisco.com' . "\r\n";
			$headers .= 'Reply-To: ciscolive09-booth-support@external.cisco.com' . "\r\n";

			if(mail($phone . $row['chrMethod'], '', decode($message), $headers, '-f ciscolive09-booth-support@external.cisco.com')) { 
				$cnt++;
				db_query("UPDATE Schedule SET bReminderSent=1 WHERE ID='".$row['ID']."'","Update bReminderSent");
			}
		
		}
	}
	
	if($cnt > 0) { mail('programmers@techitsolutions.com','Cisco Staffing - Mobile phone blast', $cnt. ' Emails Sent.','From: staffing@cisco.com'); }
?>