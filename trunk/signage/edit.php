<?
	include('_controller.php');
	
	function sitm() { 
		global $BF,$info,$eventinfo;
		$style = "";
		if($eventinfo['bSignageLock'] || $info['bApproved']) {
			$style = "disabled='disabled'";
		}
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
				  		<?=form_select($zones,array('caption'=>'Zone','value'=>$info['idZone'],'display'=>'true'))?>
<? if($info['idProduct'] != '0') { ?>
						<? $product = db_query("SELECT ID, chrProduct as chrRecord FROM Signage_Product ORDER BY chrRecord","Getting Products"); ?>
						<?=form_select($product,array('caption'=>'Demo/Product','value'=>$info['idProduct'],'display'=>'true'))?>
<? } ?>
					</td>
					<td class="tcgutter"></td>
					<td class="tcright">

						<? $station = db_query("SELECT ID, CONCAT(chrNumber,' (',chrStation,')') as chrRecord FROM Stations WHERE !bDeleted AND idEvent='".$_SESSION['idEvent']."' ORDER BY chrRecord","Getting Stations"); ?>
						<?=form_select($station,array('caption'=>'Station','value'=>$info['idStation'],'display'=>'true'))?>

						<?=form_text(array('caption'=>'Approved?','display'=>'true','value'=>(!$info['bApproved']?'No':'Yes')))?>

					</td>
				</tr>
				<tr>
					<td class="tcleft" colspan="3">
											<?=form_textarea(array('caption'=>'Signage','required'=>'true','name'=>'txtOriginal','cols'=>'43','rows'=>'15','style'=>'width:100%;','value'=>$info['txtOriginal'],'extra'=>$style))?>
					</td>
				</tr>
<?
		if($info['txtUpdated'] != "") {
?>				
				<tr>
					<td class="tcleft" colspan="3">
						<?=form_textarea(array('caption'=>'Admin Edited Version','name'=>'txtUpdated','cols'=>'43','rows'=>'15','style'=>'width:100%;','value'=>$info['txtUpdated'],'extra'=>'disabled="disabled"'))?>
					</td>
				</tr>
<?
		}
?>				
			</table>
<?
		if(!$eventinfo['bSignageLock'] && !$info['bApproved']) {
?>
			<div class='FormButtons'>
				<?=form_button(array('type'=>'submit','value'=>'Save'))?>
				<?=form_text(array('type'=>'hidden','nocaption'=>'true','name'=>'key','value'=>$_REQUEST['key']))?>
			</div>
<?
		}
?>
		</form>
	</div>
<?
	}
?>