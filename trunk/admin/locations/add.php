<?
	include('_controller.php');
	
	function sitm() { 
		global $BF;
?>
	<div class='innerbody'>
		<form action="" method="post" id="idForm" onsubmit="return error_check()">
			<table width="100%" class="twoCol" id="twoCol" cellpadding="0" cellspacing="0">
				<tr>
					<td class="tcleft">
										
						<?=form_text(array('caption'=>'Location Name','required'=>'true','name'=>'chrLocation','size'=>'30','maxlength'=>'100'))?>
						
					</td>
					<td class="tcgutter"></td>
					<td class="tcright">
	
						<?=form_checkbox(array('type'=>'radio','caption'=>'Enable Staffing?','title'=>'No','name'=>'bStaffingEnabled','value'=>'0','required'=>'true'))?>&nbsp;&nbsp;&nbsp;
						<?=form_checkbox(array('type'=>'radio','title'=>'Yes','name'=>'bStaffingEnabled','value'=>'1'))?>
	
					</td>
				</tr>
			</table>
			<div class='FormButtons'>
				<?=form_button(array('type'=>'submit','value'=>'Add Another','extra'=>'onclick="document.getElementById(\'moveTo\').value=\'add.php\';"'))?> &nbsp;&nbsp; <?=form_button(array('type'=>'submit','value'=>'Add and Continue','extra'=>'onclick="document.getElementById(\'moveTo\').value=\'index.php\';"'))?>
				<?=form_text(array('type'=>'hidden','nocaption'=>'true','name'=>'moveTo'))?>
			</div>
		</form>
	</div>
<?
	}
?>