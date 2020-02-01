<?php
	include('_controller.php');

	function sitm() {
		global $BF;
?>
		<div align="center">
		<a href="<?=$BF?>videos/instructions.flv"  
			 style="display:block;width:500px;height:376px;"  
			 id="player"></a> 
		</div>
		
		<!-- Player Updates -->
		<script>
		
			$f("player", "<?=$BF?>includes/flowplayer-3.0.7.swf",  {
			
				// use the first frame of the video as a "splash image"
				clip: {
					autoPlay: true,
					autoBuffering: true,
					scaling: 'fit'
				},
				
				// controlbar settings
				plugins:  {
					controls: {
					
						// setup a background image
						//background: 'url(images/videooverlay-big.jpg) repeat',
						
						/* you may want to remove the gradient */
						// backgroundGradient: 'none',
						
						// these buttons are visible
						all:false,
						scrubber:true,
						play:true,
						mute:true,
						volume: true,
						time: true,
						
						// custom colors
						//bufferColor: '#333333',
						//progressColor: '#cc0000',
						//buttonColor: '#cc0000',
						//buttonOverColor: '#ff0000',
						
						// custom height
						//height: 30,
						
						// setup auto hide
						autoHide: 'always'
						
						// a little more styling
						//width: '98%',
						//bottom: 5,
						//left: '50%',
						//borderRadius: 15
					}
				}
			});
		</script>
<?	} ?>