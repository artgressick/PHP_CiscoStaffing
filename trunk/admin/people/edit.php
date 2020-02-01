<?
	include('_controller.php');
	
	function sitm() { 
		global $BF,$info;
?>
	<div class='innerbody'>
		<form action="" method="post" id="idForm" onsubmit="return error_check()">
			<table width="100%" class="twoCol" id="twoCol" cellpadding="0" cellspacing="0">
				<tr>
					<td class="tcleft">
				
						<div class="colHeader">Personal Information</div>

						<?=form_text(array('caption'=>'First Name','required'=>'true','name'=>'chrFirst','size'=>'30','maxlength'=>'100','value'=>$info['chrFirst']))?>
						<?=form_text(array('caption'=>'Last Name','required'=>'true','name'=>'chrLast','size'=>'30','maxlength'=>'100','value'=>$info['chrLast']))?>
						<?=form_text(array('caption'=>'Email Address','required'=>'true','name'=>'chrEmail','size'=>'30','maxlength'=>'150','value'=>$info['chrEmail']))?>
						<?=form_text(array('caption'=>'Job Title','name'=>'chrJobTitle','size'=>'30','maxlength'=>'200','value'=>$info['chrJobTitle']))?>
						<?=form_text(array('caption'=>'Office Phone','name'=>'chrOfficePhone','size'=>'30','maxlength'=>'30','value'=>$info['chrOfficePhone']))?>
						<?=form_text(array('caption'=>'Mobile Phone','required'=>'true','name'=>'chrMobilePhone','size'=>'30','maxlength'=>'30','value'=>$info['chrMobilePhone']))?>
<?						
						$q = "SELECT ID, chrMobileCarrier AS chrRecord FROM MobileCarriers WHERE !bDeleted ORDER BY chrMobileCarrier";
						$mobilecarriers = db_query($q,"getting mobile carriers");
?>
						<?=form_select($mobilecarriers,array('caption'=>'Mobile Carrier','required'=>'Required) (For SMS Alerts','name'=>'idMobileCarrier','value'=>$info['idMobileCarrier']))?>
<?					
						$q = "SELECT ID, chrLocale AS chrRecord FROM Locales WHERE !bDeleted ORDER BY intOrder, chrLocale";
						$states = db_query($q,"getting states");
?>
						<?=form_select($states,array('caption'=>'State / Province','required'=>'US / Canada','name'=>'idLocale','value'=>$info['idLocale']))?>
<?					
						$q = "SELECT ID, chrCountry AS chrRecord FROM Countries WHERE !bDeleted ORDER BY intOrder, chrCountry";
						$countries = db_query($q,"getting countries");
?>
						<?=form_select($countries,array('caption'=>'Country','required'=>'true','name'=>'idCountry','value'=>$info['idCountry']))?>
						
						<?=form_text(array('caption'=>'Badge Number','name'=>'BadgeNum','size'=>'30','maxlength'=>'30','value'=>$info['BadgeNum']))?>
					</td>
					<td class="tcgutter"></td>
					<td class="tcright">
	
						<div class="colHeader">Password</div>
						
						<?=form_text(array('caption'=>'Password','type'=>'password','required'=>'Only Required if Changing','name'=>'chrPassword','size'=>'30','maxlength'=>'100','value'=>'','title'=>'Enter New Password'))?>
						<?=form_text(array('caption'=>'Confirm Password','type'=>'password','required'=>'Only Required if Changing','name'=>'chrPassword2','size'=>'30','maxlength'=>'100','value'=>''))?>

						<div class="colHeader">Account Options</div>

						<?=form_checkbox(array('type'=>'radio','caption'=>'Marcom Manager?','title'=>'No','name'=>'bMarcom','id'=>'bMarcom0','value'=>'0','checked'=>(!$info['bMarcom']?'true':'false')))?>&nbsp;&nbsp;&nbsp;
						<?=form_checkbox(array('type'=>'radio','title'=>'Yes','name'=>'bMarcom','id'=>'bMarcom1','value'=>'1','checked'=>($info['bMarcom']?'true':'false')))?>

<?					
						$q = "SELECT ID, chrPersonStatus AS chrRecord FROM PersonStatus WHERE !bDeleted AND ID IN (3,5) ORDER BY ID";
						$employeetypes = db_query($q,"getting employee types");
?>
						<?=form_select($employeetypes,array('caption'=>'Account Status','required'=>'true','name'=>'idPersonStatus','value'=>$info['idPersonStatus']))?>
						<?=form_checkbox(array('type'=>'radio','caption'=>'Account Locked','title'=>'No','name'=>'bLocked','id'=>'bLocked0','value'=>'0','required'=>'This is marked Yes with 5 consecutive bad login attempts','checked'=>(!$info['bLocked']?'true':'false')))?>&nbsp;&nbsp;&nbsp;
						<?=form_checkbox(array('type'=>'radio','title'=>'Yes','name'=>'bLocked','id'=>'bLocked1','value'=>'1','checked'=>($info['bLocked']?'true':'false')))?>
	
					<?=form_checkbox(array('type'=>'radio','caption'=>'Super Administrator?','title'=>'No','name'=>'bAdmin','id'=>'bAdmin0','value'=>'0','checked'=>(!$info['bAdmin']?'true':'false')))?>&nbsp;&nbsp;&nbsp;
						<?=form_checkbox(array('type'=>'radio','title'=>'Yes','name'=>'bAdmin','id'=>'bAdmin1','value'=>'1','checked'=>($info['bAdmin']?'true':'false')))?>
						<div class="colHeader">Account Statistics</div>
						
						<?=form_text(array('caption'=>'Last Login','value'=>($info['dtLastLogin'] != "" && $info['dtLastLogin'] != "0000-00-00 00:00:00" ? date('l, F j, Y - g:i a', strtotime($info['dtLastLogin'])) : "Never Logged In"),'display'=>'true'))?>
						
					</td>
				</tr>
			</table>
			<div class='FormButtons'>
				<?=form_button(array('type'=>'submit','value'=>'Update Information'))?>
				<?=form_text(array('type'=>'hidden','nocaption'=>'true','name'=>'key','value'=>$_REQUEST['key']))?>
			</div>
		</form>
	</div>

<?
	}
?>