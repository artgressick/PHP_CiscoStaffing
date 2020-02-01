<?
	$BF = '';
	session_start();

	$_SESSION['chrEmail'] = '';
	$_SESSION['idPerson'] = '';
	$_SESSION['chrFirst'] = '';
	$_SESSION['chrLast'] = '';
	$_SESSION['bAdmin'] = '';
	$_SESSION['idLevel'] = '';
	$_SESSION['dtLogin'] = '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Cisco Staffing</title>
	<link href="<?=$BF?>includes/global.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" src="<?=$BF?>includes/nav.js"></script>
	<script type='text/javascript'>var BF = '<?=$BF?>';</script>
</head>
<body>
<table width="908" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="3"><a href="<?=$BF?>index.php" title="Link to the Main Page"><img src="<?=$BF?>images/general-logo.gif" width="309" height="150" /><img src="<?=$BF?>images/general-main1.jpg" width="599" height="150" /></a></td>
	</tr>
	<tr>
		<td width="4" background="<?=$BF?>images/shadow-left.gif"><img src="<?=$BF?>images/shadow-left.gif" width="4" height="5" /></td>
<!-- This is the middle of the smooth bar-->
		<td width="900" style='background: url(<?=$BF?>images/smoothbar.gif) #fff repeat-x;'>
<? if(isset($_SESSION['idPerson']) && is_numeric($_SESSION['idPerson'])) { ?>

			<table width="900" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><img src="<?=$BF?>images/smoothbar_arrow.gif" /></td>
					<td style="text-align:left; width:100%; padding-left:5px;"><span class="loginbar" style="">Welcome <a href="<?=$BF?>myprofile/index.php" style='color:blue;font-weight:bold;'><?=$_SESSION['chrFirst']?> <?=$_SESSION['chrLast']?></a> <?=(isset($_SESSION['chrEvent']) ? ' to <span style="color:blue;font-weight:bold;">'.$_SESSION['chrEvent'].'</span>' : '')?></span>
					</td>
					<td align="right" nowrap="nowrap" style='padding-right:10px;'>
						<a href="<?=$BF?>signout.php">Logout</a>
            		</td>
        		</tr>
			</table>
<?	} ?>
		  </td>
		<td width="4" background="<?=$BF?>images/shadow-right.gif"><img src="<?=$BF?>images/shadow-right.gif" width="4" height="5" /></td>
	</tr>
	<tr>
		<td width="4" background="<?=$BF?>images/shadow-left.gif"><img src="<?=$BF?>images/shadow-left.gif" width="4" height="5" /></td>
		<td style='background:white;'>
			<table width='100%' cellpadding='0' cellspacing='0' border='0' style='padding:0;margin:0;'>
				<tr>
					<td style='vertical-align:top; padding:10px; padding-right:5px;'>
						<table cellspacing="0" cellpadding="0" border="0" width="100%;">
							<tr>
								<td style='padding:0px;'></td>
							</tr>
							<tr>
			              		<td style="padding:10px;">
<?

		if(!isset($_REQUEST['id']) || !is_numeric($_REQUEST['id'])) { $_REQUEST['id'] = 4; } 
?>
	<div class='header2'>Logged Off</div>
	<p>You are now logged off. &nbsp;Possible reasons this has occurred may be:</p>
	<p>
		<ul style="line-height:18px;">
			<li<?=($_REQUEST['id']==1?' style="font-weight:bold;"':'')?>>You clicked on the log-off link.</li>
			<li<?=($_REQUEST['id']==0?' style="font-weight:bold;"':'')?>>The link between our web-server and your browser has been broken.</li>
			<li<?=($_REQUEST['id']==2?' style="font-weight:bold;"':'')?>>You have stayed on the same page for longer than 20 minutes.</li>
			<li<?=($_REQUEST['id']==3?' style="font-weight:bold;"':'')?>>You have been logged in for more then 12 Hours, and should take a break.</li>
		</ul>
	</p>
	<p style='text-align:center;'><a href="<?=$BF?>index.php">Please click here to log in again.</a></p>
			             		</td>
			          		</tr>
			       		</table>
   					</td>
   				</tr>
   			</table>
   		</td>
	  	<td width="4" background="<?=$BF?>images/shadow-right.gif"><img src="<?=$BF?>images/shadow-right.gif" width="4" height="5" /></td>
    </tr>
	<tr>
      	<td colspan="3">
		  	<table width="908" border="0" cellspacing="0" cellpadding="0">
			  	<tr>
					<td rowspan="2" align="left" valign="bottom" background="<?=$BF?>images/shadowblue-left.gif"><img src="<?=$BF?>images/blue-bottomleft.gif" width="15" height="18" /></td>
					<td width="100%" height="45" bgcolor="#C2CED8">
						<div class="Copyright">
							<div class="Copyright">&copy; <?=date('Y')?>, Cisco, Inc. Internal Use Only</div>
							<div class="Copyright">Cisco Staffing Version 1.0a built by techIT Solutions</div>
						</div>
					</td>
					<td rowspan="2" align="right" valign="bottom" background="<?=$BF?>images/shadowblue-right.gif"><img src="<?=$BF?>images/blue-bottomright.gif" width="15" height="18" /></td>
			  	</tr>
			  	<tr>
					<td background="<?=$BF?>images/shadow-bottom.gif"><img src="<?=$BF?>images/shadow-bottom.gif" width="4" height="9" /></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>