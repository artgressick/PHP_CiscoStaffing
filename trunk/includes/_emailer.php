<?php
$email_sent = false;

	//create an email and send it to them proper
	$to  = $info['chrEmail']." <".$info['chrEmail'].">, "; // note the comma
	//$to .= 'wez@example.com'; //only if we need more people
	
	// subject
	$subject = $info['chrSubject'];
	
	// message

	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Additional headers
	//$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
	$headers .= 'From: '.$PROJECT_NAME." <".$PROJECT_EMAIL.">" . "\r\n";
	//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
	//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
	$headers .= 'Reply-To: '.$PROJECT_NAME." <".$PROJECT_EMAIL.">" . "\r\n";
	$headers .= 'Return-Path: '.$PROJECT_NAME." <".$PROJECT_EMAIL.">" . "\r\n";
	
	// Mail it
	if(mail($to, decode($subject), decode($info['txtMsg']), $headers, '-f'.$PROJECT_EMAIL)) { $email_sent = true; }

/*	$info['chrFromEmail'] = $PROJECT_NAME." <".$PROJECT_EMAIL.">";

	// This is added so that the Pear module can differentiate between HTML emails and plain text emails.
	//dtn: This is added so that the Pear module can differentiate between HTML emails and plain text emails.
	$er = error_reporting(0); 		//dtn: This is added in so that we don't get spammed with PEAR::isError() messages in our tail -f ..
	include_once('Mail.php');
	include_once('Mail/mime.php');

	$crlf = "\n";
//	mb_language('en');
//	mb_internal_encoding('UTF-8');
	
	$mime = new Mail_mime($crlf);	

	$subject = decode($info['chrSubject']);
//	$subject = mb_convert_encoding($subject, 'UTF-8',"AUTO");
//	$subject = mb_encode_mimeheader($subject);

	$hdrs = array('From'    => $info['chrFromEmail'],
				  'Subject' => $subject
			  );
	
	$mime->_build_params['text_encoding'] ='quoted-printable';
	$mime->_build_params['text_charset'] = "UTF-8";
	$mime->_build_params['html_charset'] = "UTF-8";

	$Message = decode($info['txtMsg']);
		
	$mime->setHTMLBody($Message);
	if(isset($info['Attachment'])) { $mime->addAttachment($info['Attachment']); }
		
	$body = $mime->get();
	$hdrs = $mime->headers($hdrs);
//	$body = mb_convert_encoding($body, "UTF-8", "UTF-8"); 
	
	$mail =& Mail::factory('mail');
	if($mail->send($info['chrEmail'], $hdrs, $body)) { $email_sent = true; }
*/
?>