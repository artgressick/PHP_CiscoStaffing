<?php
	include('_controller.php');

	function sitm() {
		global $BF;
?>
		<div style='margin:50px; text-align:center;'>
			Badge Number: <textarea style="height:50px; width:500px;" name="badgenum" id="badgenum" onkeypress="ifEnter(this,event);""></textarea>
			<div style="padding-top:10px;"><input type="button" name="submit" value="Submit" onclick="submitbadge();" /></div>
		</div>
<?		
	}
?>