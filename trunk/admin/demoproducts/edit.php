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
										
						<?=form_text(array('caption'=>'Demo/Product Name','required'=>'true','name'=>'chrProduct','size'=>'30','maxlength'=>'255','value'=>encode($info['chrProduct'])))?>
						
					</td>
					<td class="tcgutter"></td>
					<td class="tcright">

						&nbsp;
	
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