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
	
						<?=form_text(array('caption'=>'First Name','value'=>encode($info['chrFirst']),'display'=>'true'))?>
						<?=form_text(array('caption'=>'Last Name','value'=>encode($info['chrLast']),'display'=>'true'))?>
						<?=form_text(array('caption'=>'Email Address','value'=>encode($info['chrEmail']),'display'=>'true'))?>
						<?=form_text(array('caption'=>'Job Title','value'=>encode($info['chrJobTitle']),'display'=>'true'))?>
						<?=form_text(array('caption'=>'Office Phone','value'=>encode($info['chrOfficePhone']),'display'=>'true'))?>
						<?=form_text(array('caption'=>'Mobile Phone','value'=>encode($info['chrMobilePhone']),'display'=>'true'))?>
<?						
							$q = "SELECT ID, chrMobileCarrier AS chrRecord FROM MobileCarriers WHERE !bDeleted ORDER BY chrMobileCarrier";
							$mobilecarriers = db_query($q,"getting mobile carriers");
?>
						<?=form_select($mobilecarriers,array('caption'=>'Mobile Carrier','value'=>$info['idMobileCarrier'],'display'=>'true'))?>
<?					
							$q = "SELECT ID, chrLocale AS chrRecord FROM Locales WHERE !bDeleted ORDER BY intOrder, chrLocale";
							$states = db_query($q,"getting states");
?>
						<?=form_select($states,array('caption'=>'State / Province','value'=>$info['idLocale'],'display'=>'true'))?>
<?					
							$q = "SELECT ID, chrCountry AS chrRecord FROM Countries WHERE !bDeleted ORDER BY intOrder, chrCountry";
							$countries = db_query($q,"getting countries");
?>
						<?=form_select($countries,array('caption'=>'Country','value'=>$info['idCountry'],'display'=>'true'))?>
	
					</td>
					<td class="tcgutter"></td>
					<td class="tcright">
	
						<div class="colHeader">Account Options</div>
<?					
						$q = "SELECT ID, chrPersonStatus AS chrRecord FROM PersonStatus WHERE !bDeleted AND ID IN (3,4,5) ORDER BY ID";
						$status = db_query($q,"getting status");
?>
						<?=form_select($status,array('caption'=>'Account Status','required'=>'true','name'=>'idPersonStatus','value'=>$info['idPersonStatus']))?>
					
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