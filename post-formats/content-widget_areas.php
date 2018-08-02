<?php
/**
 * The template used for displaying a widget area.
 *
 * @package WordPress
 * @subpackage Braftonium
 * @since braftonium 1.5
 */
if(!session_id()) session_start();
$sectionrow = $_SESSION['sectionrow'];
if (get_sub_field('title')):
	$titletext = ($sectionrow==0)?'<h1>'.get_sub_field('title').'</h1>':'<h2>'.get_sub_field('title').'</h2>';
endif;
$widgetareas = get_sub_field('widget_area');

$style = get_sub_field('style');
$classes = array('widgetarea');
if ($style['add_class']){
	$classes[] = $style['add_class'];
}
if (!$style['background_image'] && !$style['background_color'] ) {
	$classes[] = "gradient";
}
if ( $style['other'] ) {
	if (in_array('full', $style['other'])){
		$classes[] = "full";
	}
	if (in_array('compact', $style['other'])){
		$classes[] = "compact";
	}
	if (in_array('thin', $style['other'])){
		$classes[] = "thin";
	}
	if (in_array('center', $style['other'])){
		$classes[] = "center";
	}
}?>

<section id="post-<?php the_ID(); echo '-'.$sectionrow; ?>" class="<?php echo implode(' ',$classes); ?>" style="<?php
if ( $style['background_image'] ) { echo 'background-image: url(' . $style['background_image'] . ');'; }
if ( $style['background_color'] ) { echo 'background-color: ' . $style['background_color'] . ';'; }
if ( $style['color'] ) { echo 'color: ' . $style['color'] . ';'; } ?>" >
	<?php if ( $style['video_url'] ) {
		if (strpos($video, 'youtube.com') == true || strpos($video, '.webm') == false && strpos($video, '.mp4') == false) {
			$videoid = preg_replace('/https:\/\/www.youtube.com\/watch\?v=/', '', $video);
		?>

			<div id="video"></div>
		
			<script async src="https://www.youtube.com/iframe_api"></script>
			<script>
			 function onYouTubeIframeAPIReady() {
			  var player;
			  player = new YT.Player('video', {
				videoId: '<?php echo $videoid; ?>', // YouTube Video ID
				width: 1000,			   // Player width (in px)
				height: 750,			  // Player height (in px)
				playerVars: {
				  autoplay: 1,		// Auto-play the video on load
				  controls: 1,		// Show pause/play buttons in player
				  showinfo: 0,		// Hide the video title
				  modestbranding: 1,  // Hide the Youtube Logo
				  loop: 1,			// Run the video in a loop
				  fs: 1,			  // Hide the full screen button
				  rel: 0,
				  playsinline: 1,
				  cc_load_policy: 1, // Hide closed captions
				  iv_load_policy: 3,  // Hide the Video Annotations
				  autohide: 0		 // Hide video controls when playing
				},
				events: {
				  onReady: function(e) {
					e.target.mute();
				  }
				}
			  });
			 }
			</script>
		<?php } else {
			$vidstring = chop($video, '.webm');
			$vidstring = chop($vidstring, '.mp4'); ?>
			<button id="vidpause"><i class="fa fa-pause" aria-hidden="true"></i></button>
			<video playsinline autoplay muted loop id="video">
				<source src="<?php echo $vidstring; ?>.webm" type="video/webm">
				<source src="<?php echo $vidstring; ?>.mp4" type="video/mp4">
			</video>
		<?php }
	} ?><div class="wrap">

		<?php if ($titletext): echo $titletext; endif; ?>
		<?php if ($widgetareas):
			$count = count($widgetareas);
			echo '<div class="container count'.$count.'">';
			foreach($widgetareas as $widgetarea):
				dynamic_sidebar( $widgetarea );
			endforeach;
			echo '</div>';
		endif; ?>
		
	</div>
</section><!-- section -->

<?php if ( $style['other'] && in_array('shadow', $style['other']) ) { echo '<div class="shadow"></div>'; } ?>
<?php if ( $style['video_url'] ) { ?>
	<script>
	var vid = document.getElementById("bgvid"),
	pauseButton = document.getElementById("vidpause");
	function vidFade() {
		vid.classList.add("stopfade");
	}
	vid.addEventListener('ended', function() {
		// only functional if "loop" is removed 
		 vid.pause();
		// to capture IE10
		vidFade();
	});
	pauseButton.addEventListener("click", function() {
		vid.classList.toggle("stopfade");
		if (vid.paused) {
	vid.play();
			pauseButton.innerHTML = '<i class="fa fa-pause" aria-hidden="true"></i>';
		} else {
			vid.pause();
			pauseButton.innerHTML = '<i class="fa fa-play" aria-hidden="true"></i>';
		}
	})
	</script>
<?php } ?>