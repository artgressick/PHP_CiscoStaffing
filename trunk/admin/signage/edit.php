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

						<? $zones = db_query("SELECT Z.ID, chrZone AS chrRecord
				  FROM Zones AS Z
				  JOIN Locations AS L ON Z.idLocation=L.ID
				  WHERE !Z.bDeleted AND !L.bDeleted AND L.idEvent='".$_SESSION['idEvent']."'
				  ORDER BY chrRecord","Getting Areas"); ?>
						<?=form_select($zones,array('caption'=>'Zone','required'=>'true','name'=>'idZone','style'=>'width:150px;','value'=>$info['idZone']))?>
						<? $product = db_query("SELECT ID, chrProduct as chrRecord FROM Signage_Product ORDER BY chrRecord","Getting Products"); ?>
						<?=form_select($product,array('caption'=>'Demo/Product','name'=>'idProduct','style'=>'width:150px;','value'=>$info['idProduct']))?>
					</td>
					<td class="tcgutter"></td>
					<td class="tcright">

						<? $station = db_query("SELECT ID, CONCAT(chrNumber,' (',chrStation,')') as chrRecord FROM Stations WHERE !bDeleted AND idEvent='".$_SESSION['idEvent']."' ORDER BY chrRecord","Getting Stations"); ?>
						<?=form_select($station,array('caption'=>'Station','required'=>'true','name'=>'idStation','style'=>'width:150px;','value'=>$info['idStation']))?>

						<? $marcom = db_query("SELECT ID, CONCAT(chrFirst,' ',chrLast) as chrRecord FROM People WHERE bMarcom AND !bDeleted ORDER BY chrRecord","Getting Marcom"); ?>
						<?=form_select($marcom,array('caption'=>'Marcom Lead','required'=>'true','name'=>'idMarcomLead','style'=>'width:150px;','value'=>$info['idMarcomLead']))?>

					</td>
				</tr>
				<tr>
					<td class="tcleft" colspan="3">
						<?=form_textarea(array('caption'=>'Original Submission','name'=>'txtOriginal','cols'=>'43','rows'=>'15','style'=>'width:100%;','value'=>$info['txtOriginal']))?>
					</td>
				</tr>
				<tr>
					<td class="tcleft" colspan="3">
						<?=form_checkbox(array('type'=>'radio','caption'=>'Approval?','title'=>'Not Approved','name'=>'bApproved','id'=>'bApproved0','value'=>'0','checked'=>(!$info['bApproved']?'true':'false')))?>&nbsp;&nbsp;&nbsp;
						<?=form_checkbox(array('type'=>'radio','title'=>'Approved','name'=>'bApproved','id'=>'bApproved1','value'=>'1','checked'=>($info['bApproved']?'true':'false')))?>

					</td>
				</tr>
				<tr>
					<td class="tcleft" colspan="3">
						<?=form_textarea(array('caption'=>'Edited Version','name'=>'txtUpdated','cols'=>'43','rows'=>'15','style'=>'width:100%;','value'=>$info['txtUpdated']))?>
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