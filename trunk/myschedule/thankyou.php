<?
	include('_controller.php');
		
	function sitm() { 
		global $BF;
?>
	<div class='header2'>My Schedule - Thank You</div>
	<?=messages()?>
	<p>The submission is current, and any additional updates will be done in real-time. You will receive an e-mail at <strong><?=$_SESSION['chrEmail']?></strong> confirming your staffing options you selected.  If you cannot perform the responsibilities of staffing the booth please remove yourself as a staffer.</p>
	<p><?=form_button(array('type'=>'button','name'=>'Home','value'=>'Home','extra'=>'onclick="javascript:location.href=\''.$BF.'index.php\'";'))?></p>
<?	} ?>