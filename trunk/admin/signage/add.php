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

						<? $zones = db_query("SELECT Z.ID, chrZone AS chrRecord
				  FROM Zones AS Z
				  JOIN Locations AS L ON Z.idLocation=L.ID
				  WHERE !Z.bDeleted AND !L.bDeleted AND L.idEvent='".$_SESSION['idEvent']."'
				  ORDER BY chrRecord","Getting Areas"); ?>
						<?=form_select($zones,array('caption'=>'Zone','required'=>'true','name'=>'idZone','style'=>'width:150px;'))?>

						<? $product = db_query("SELECT ID, chrProduct as chrRecord FROM Signage_Product ORDER BY chrRecord","Getting Products"); ?>
						<?=form_select($product,array('caption'=>'Demo/Product','name'=>'idProduct','style'=>'width:150px;'))?>

										
					</td>
					<td class="tcgutter"></td>
					<td class="tcright">

						<? $station = db_query("SELECT ID, CONCAT(chrNumber,' (',chrStation,')') as chrRecord FROM Stations WHERE !bDeleted AND idEvent='".$_SESSION['idEvent']."' ORDER BY chrRecord","Getting Stations"); ?>
						<?=form_select($station,array('caption'=>'Station','required'=>'true','name'=>'idStation','style'=>'width:150px;'))?>

						<? $marcom = db_query("SELECT ID, CONCAT(chrFirst,' ',chrLast) as chrRecord FROM People WHERE bMarcom AND !bDeleted ORDER BY chrRecord","Getting Marcom"); ?>
						<?=form_select($marcom,array('caption'=>'Marcom Lead','required'=>'true','name'=>'idMarcomLead','style'=>'width:150px;'))?>

					</td>
				</tr>
<?
/*
				<tr>
					<td class="tcleft" colspan="3">
						<?=form_textarea(array('caption'=>'Original Submittion','name'=>'txtOriginal','cols'=>'43','rows'=>'10','style'=>'width:100%;'))?>
					</td>
				</tr>
				<tr>
					<td class="tcleft" colspan="3">
						<?=form_checkbox(array('type'=>'radio','caption'=>'Approval?','title'=>'Not Approved','name'=>'bApproved','id'=>'bApproved0','value'=>'0','checked'=>'true'))?>&nbsp;&nbsp;&nbsp;
						<?=form_checkbox(array('type'=>'radio','title'=>'Approved','name'=>'bApproved','id'=>'bApproved1','value'=>'1'))?>

					</td>
				</tr>
				<tr>
					<td class="tcleft" colspan="3">
						<?=form_textarea(array('caption'=>'Edited Version','name'=>'txtUpdated','cols'=>'43','rows'=>'10','style'=>'width:100%;'))?>
					</td>
				</tr>
*/
?>
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