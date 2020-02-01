<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?
/*
 if(isset($_SESSION['idPerson']) && is_numeric($_SESSION['idPerson'])) { // This is added to auto logout person if they stay on the same page for over 20 minutes == 1200 seconds
?>	<meta http-equiv="refresh" content="1200;URL=<?=$BF?>destroy.php?reason=2" />
<?	} 
*/
//Getting Browser Information
require_once($BF.'components/browser.php');
$br = new Browser;
//echo "<pre>";
//print_r($br);
//echo "</pre>";
?>
	<title><?=(isset($title) ? $title.' - ' : '')?><?=$PROJECT_NAME?></title>
	<link href="<?=$BF?>includes/global.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" src="<?=$BF?>includes/nav.js"></script>
	<script type='text/javascript'>var BF = '<?=$BF?>';</script>

<?		# If the "Stuff in the Header" function exists, then call it
		if(function_exists('sith')) { sith(); } 
?>
</head>
<body <?=(isset($bodyParams) ? 'onload="'. $bodyParams .'"' : '')?>>
<?// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // This is to display the SESSION variables, unrem to use?>
<table width="908" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="3"><a href="<?=$BF?>index.php" title="Link to the Main Page"><img src="<?=$BF?>images/banners_cisco_live_09.gif" width="908" height="150" /></a></td>
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
						<a href="<?=$BF?>destroy.php?reason=1">Logout</a>
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
						<table cellspacing="0" cellpadding="0" border="0" style="">
							<tr>
								<td style='width:4px; padding:0px; margin:0px;' align="left" background="<?=$BF?>images/wire-header-bg.gif"><img src="<?=$BF?>images/wire-header-left.gif"></td>
								<td background="<?=$BF?>images/wire-header-bg.gif" style='padding:0px; margin:0px; font-weight:bold; color:#282828;font-size:12px; width:100%;'>
									<table cellpadding='0' cellspacing='0' border='0' style='width:100%;'>
										<tr>
											<td style='text-align:left;padding-left:5px;vertical-align:middle;'><?=$page_title?></td>
<?
											if(isset($filters)) {
?>
											<td style='text-align:right;padding-right:5px;vertical-align:middle;font-weight:normal;font-size:10px;'>
												<form action="" method="get" id="idFilterForm" style="padding:0; margin:0;">
													<?=$filters?>
													<?=form_button(array('type'=>'submit','name'=>'filter','value'=>'Filter'))?>																	</form>
											</td>
<?									
											}
?>
										</tr>
									</table>
								</td>
								<td style='width:4px; padding:0px; margin:0px;' align="right" background="<?=$BF?>images/wire-header-bg.gif"><img src="<?=$BF?>images/wire-header-right.gif"></td>
							</tr>
<?
						if(isset($directions)) {
?>
							<tr>
								<td colspan='3' class='directions'><?=$directions?></td>	
							</tr>
<?
						}
?>
							<tr>
			              		<td style="border:solid 1px #c0c1c2;" colspan='3'>
			              			<?=messages()?>
<!-- Begin code -->
<?
	# This is where we will put in the code for the page.
	(!isset($sitm) || $sitm == '' ? sitm() : $sitm());
?>
<!-- End code -->
			             		</td>
			          		</tr>
			       		</table>
   					</td>
   					<td width='150' style='vertical-align:top; padding:10px;padding-left:5px;'>
<?
					 if(access_check('1,2,3,4')) {
?>
						<table cellspacing="0" cellpadding="0" border="0" width="100%" class="navigation">
							<tr>
								<td align="left" background="<?=$BF?>images/wire-header-bg.gif" style="padding:0px; margin:0px;"><img src="<?=$BF?>images/wire-header-left.gif"></td>
								<td class="heading" width="100%" background="<?=$BF?>images/wire-header-bg.gif" style="padding:0px; margin:0px;">My Information</td>
								<td align="right" background="<?=$BF?>images/wire-header-bg.gif" style="padding:0px; margin:0px;"><img src="<?=$BF?>images/wire-header-right.gif"></td>
							</tr>
							<tr>
			              		<td class="navbox" style="padding:0;" colspan='3'>
									<ul style="<?=($br->Name == 'MSIE'?'margin:10px 0 10px 20px;':'margin-left: -20px;')?>">
										<li><a href="<?=$BF?>">Home</a></li>
										<li><a href="<?=$BF?>myprofile/">My Profile</a></li>
										<? if(access_check('1,2,3,4') && isset($_SESSION['idEvent']) && is_numeric($_SESSION['idEvent'])) { 
											$tmp = db_query("SELECT idEvent FROM Schedule_Requested WHERE idEvent='".$_SESSION['idEvent']."' AND idPerson='".$_SESSION['idPerson']."'","See if person has requested a Schedule",1); ?>
										<li><a href="<?=$BF?>myschedule/step1.php"><?=($tmp['idEvent'] == ''?'Sign-up to Work':'Edit Work Request')?></a></li>
										<li><a href="<?=$BF?>instructions.php">Instructional Video</a></li>
										<? } ?>
										
<? 
								if($_SESSION['bMarcom'] && isset($_SESSION['idEvent']) && is_numeric($_SESSION['idEvent'])) {
									$check = db_query("SELECT count(ID) as intCount FROM Signage WHERE !bDeleted AND idMarcomLead='".$_SESSION['idPerson']."'","Do we have any Signage",1);
									if($check['intCount'] > 0) {
?>
										<li><a href="<?=$BF?>signage/">Signage Submission</a></li>
<?
									}
								}
?>
									</ul>

								</td>
							</tr>
						</table>
<?
					}
					if(access_check('1,2,3') || $_SESSION['bAdmin']==1) { 
?>
						<table cellspacing="0" cellpadding="0" border="0" width="100%" class="navigation" style='margin-top:5px;'>
							<tr>
								<td align="left" background="<?=$BF?>images/wire-header-bg.gif"><img src="<?=$BF?>images/wire-header-left.gif"></td>
								<td class="heading" width="100%" background="<?=$BF?>images/wire-header-bg.gif">Administration</td>
								<td align="right" background="<?=$BF?>images/wire-header-bg.gif"><img src="<?=$BF?>images/wire-header-right.gif"></td>
							</tr>
							<tr>
			              		<td class="navbox" colspan='3'>
									<ul style="<?=($br->Name == 'MSIE'?'margin:10px 0 10px 20px;':'margin-left: -20px;')?>">
									<? if(isset($_SESSION['idEvent']) && is_numeric($_SESSION['idEvent'])) { ?>
										<li><a href="<?=$BF?>assignment/">Staffer Assignment</a></li>
									<? } else { ?>
										<li><a href="<?=$BF?>">Sign into Event</a></li>
									<? } ?>
									<? if(access_check('1,2')) { ?>
										<li><a href="<?=$BF?>emailers/">Mass E-mailer</a></li>
										<li><a href="<?=$BF?>admin/eventsettings/">Event Settings</a></li>
										<li><a href="<?=$BF?>admin/locations/">Locations</a></li>
										<li><a href="<?=$BF?>admin/shifts/">Shifts</a></li>
										<li><a href="<?=$BF?>admin/stations/">Stations/Positions</a></li>
										<li><a href="<?=$BF?>admin/zones/">Zones</a></li>
										<li><a href="<?=$BF?>admin/people/">All Staffers</a></li>
										<li><a href="<?=$BF?>admin/landingpage/">Landing Page</a></li>
									<? } ?>
									<? if(access_check('1') || $_SESSION['bAdmin']==1) { ?>
										<li><a href="<?=$BF?>admin/registrations/">New Registrations</a></li>
										<li><a href="<?=$BF?>admin/events/">Events</a></li>
										<li><a href="<?=$BF?>admin/eventexpertise/">Event Expertise</a></li>
										<li><a href="<?=$BF?>admin/expertise/">Expertise</a></li>
										<li><a href="<?=$BF?>admin/signage/">Signage Management</a></li>
										<li><a href="<?=$BF?>admin/demoproducts/">Signage Demo/Products</a></li>
									<? if(isset($_SESSION['idEvent']) && is_numeric($_SESSION['idEvent'])) { ?>
										<li><a href="<?=$BF?>staffingcheckin.php">Staffer Check-in</a></li>
<?
/*
										<li><a href="<?=$BF?>checkin.php">Staffer Check-in</a></li>
										<li><a href="<?=$BF?>admin/checkinreport/">Check-in Report</a></li>

*/
?>
									<? } ?>
									<? } ?>
									
									</ul>
								</td>
							</tr>
						</table>
<?
					}
					if(access_check('1,2,3') && isset($_SESSION['idEvent']) && is_numeric($_SESSION['idEvent'])) {
?>
						<table cellspacing="0" cellpadding="0" border="0" width="100%" class="navigation" style='margin-top:5px;'>
							<tr>
								<td align="left" background="<?=$BF?>images/wire-header-bg.gif"><img src="<?=$BF?>images/wire-header-left.gif"></td>
								<td class="heading" width="100%" background="<?=$BF?>images/wire-header-bg.gif">Reports</td>
								<td align="right" background="<?=$BF?>images/wire-header-bg.gif"><img src="<?=$BF?>images/wire-header-right.gif"></td>
							</tr>
							<tr>
			              		<td class="navbox" colspan='3'>
									<ul style="<?=($br->Name == 'MSIE'?'margin:10px 0 10px 20px;':'margin-left: -20px;')?>">
										<li><a href="<?=$BF?>reports/staffingmatrix/" target='_blank'>Staffing Matrix</a></li>
									</ul>
								</td>
							</tr>
						</table>
<?
					}						
?>
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
					<td width="50%" height="45" bgcolor="#C2CED8">
						<div class="Copyright">
							<div class="Copyright">&copy; <?=date('Y')?>, Cisco, Inc. Internal Use Only</div>
							<div class="Copyright">Cisco Staffing Version 1.0a built by techIT Solutions</div>
						</div>
					</td>
					<td width="50%" height="45" bgcolor="#C2CED8">
						<div class="Copyright" style="text-align:right;">
							<div class="Copyright">For Support or Questions Send E-mail to:</div>
							<div class="Copyright"><a href="mailto:ciscolive09-booth-support@external.cisco.com">ciscolive09-booth-support@external.cisco.com</a></div>
						</div>
					</td>
					<td rowspan="2" align="right" valign="bottom" background="<?=$BF?>images/shadowblue-right.gif"><img src="<?=$BF?>images/blue-bottomright.gif" width="15" height="18" /></td>
			  	</tr>
			  	<tr>
					<td colspan="2" background="<?=$BF?>images/shadow-bottom.gif"><img src="<?=$BF?>images/shadow-bottom.gif" width="4" height="9" /></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<?
	# Any aditional things can go down here including javascript or hidden variables
	# "Stuff on the Bottom"
	if(function_exists('sotb')) { sotb(); } 
?>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-6291470-6");
pageTracker._trackPageview();
} catch(err) {}</script>
</body>
</html>