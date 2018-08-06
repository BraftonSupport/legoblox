<?php
function braftonium_language_setup(){

	load_theme_textdomain( 'braftonium', get_template_directory() . '/library/translation' );
  
	$locale = get_locale();
	$locale_file = get_template_directory() . "/library/translation/$locale.php";
  
	if ( is_readable( $locale_file ) ) {
		require_once( $locale_file );
	}
	// var_dump($locale_file);
  }
  add_action('after_setup_theme', 'braftonium_language_setup');

// LOAD BRAFTONIUM THEME CORE (if you remove this, the theme will break)


/*********************
LAUNCH BRAFTONIUM
Let's get everything up and running.
*********************/
function braftonium_start() {
	require_once( 'library/braftonium.php' );
	include_once get_template_directory().'/library/custom-fields/fields.php';
	
  //Allow editor style.
  add_editor_style( get_template_directory_uri() . '/library/css/editor-style.css' );

  add_action( 'admin_enqueue_scripts', 'load_admin_style' );
  function load_admin_style() {
	wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/library/css/admin.css', false, '1.0.0' );
  }

  wp_enqueue_script( 'functions', get_template_directory_uri() . '/library/js/functions.js', array(), '1.0.0', true );
  wp_enqueue_script( 'slick', get_template_directory_uri() . '/library/js/slick/slick.min.js', array(), '1.0.0', true );
  wp_enqueue_style( 'slick', get_template_directory_uri() . '/library/js/slick/slick.css', false, '1.0.0' );
  wp_enqueue_style( 'slick-themes', get_template_directory_uri() . '/library/js/slick/slick-theme.css', false, '1.0.0' );

  if ( get_field('sticky_nav', 'option')&&get_field('sticky_nav', 'option')[0]=='on' ){
	wp_enqueue_script( 'sticky', get_template_directory_uri() . '/library/js/sticky.js', array(), '1.0.0', true );
  }

  // launching operation cleanup
  add_action( 'init', 'braftonium_head_cleanup' );
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'braftonium_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'braftonium_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'braftonium_remove_recent_comments_style', 1 );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'braftonium_scripts_and_styles', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  braftonium_support();

  // cleaning up random code around images
  add_filter( 'the_content', 'filter_ptags_on_images' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'excerpt_more' );

} /* end braftonium */

// let's get this party started
add_action( 'after_setup_theme', 'braftonium_start' );



/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
	$content_width = 680;
}

/************* THEME CUSTOMIZE *********************/

/* 
  A good tutorial for creating your own Sections, Controls and Settings:
  http://code.tutsplus.com/series/a-guide-to-the-wordpress-theme-customizer--wp-33722
  
  Good articles on modifying the default options:
  http://natko.com/changing-default-wordpress-theme-customization-api-sections/
  http://code.tutsplus.com/tutorials/digging-into-the-theme-customizer-components--wp-27162
  
  To do:
  - Create a js for the postmessage transport method
  - Create some sanitize functions to sanitize inputs
  - Create some boilerplate Sections, Controls and Settings
*/

function braftonium_customizer($wp_customize) {
  // $wp_customize calls go here.
  //
  // Uncomment the below lines to remove the default customize sections 

  // $wp_customize->remove_section('title_tagline');
  // $wp_customize->remove_section('colors');
  $wp_customize->remove_section('background_image');
  // $wp_customize->remove_section('static_front_page');
  // $wp_customize->remove_section('nav');

  // Uncomment the below lines to remove the default controls
  // $wp_customize->remove_control('blogdescription');
  
  // Uncomment the following to change the default section titles
  $wp_customize->get_section('colors')->title = __( 'Theme Colors', 'braftonium' );
//   $wp_customize->get_section('background_image')->title = __( 'Images' );
}

add_action( 'customize_register', 'braftonium_customizer' );


/*
This is a modification of a function found in the
twentythirteen theme where we can declare some
external fonts. If you're using Google Fonts, you
can replace these fonts, change it in your scss files
and be up and running in seconds.
*/
function braftonium_fonts() {
  wp_enqueue_style('googleFonts', '//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');
}

add_action('wp_enqueue_scripts', 'braftonium_fonts');

/* I CALL UPON THE POWERS OF AN SVG SPRITESHEET except linking an svg file doesn't work in IE so I gots to do this */
require_once(ABSPATH . 'wp-admin/includes/file.php');


function get_svg_path($svgid) {
	WP_Filesystem();
	global $wp_filesystem;
	$file_data = get_template_directory_uri().'/library/theme-options/svg-icons.svg';
	$content = $wp_filesystem->get_contents($file_data);
	$first_step = explode( '<symbol id="'.$svgid , $content );
	$second_step = explode("</path>" , $first_step[1] );
	return '<svg class="'.$svgid.$second_step[0].'</svg>';
}

/**
 * What it says on the tin.
 */
if (!function_exists( 'social_sharing_buttons' ) ) :
	$ssbutton = get_field('social_share_buttons', 'option');
	if (in_array("on", $ssbutton) ) {
		function social_sharing_buttons() {
			$social_media = get_field('social_media', 'option');
			$ss_location = get_field('ss_button_location', 'option');

			// Get current page URL 
			$ssbURL = get_permalink();

			// Get current page title
			$ssbTitle = str_replace( ' ', '%20', get_the_title());
				
			// Get Post Thumbnail for pinterest
			$ssbThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );

			// Construct sharing URL without using any script
			$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$ssbURL;
			$twitterURL = 'https://twitter.com/intent/tweet?text='.$ssbTitle.'&amp;url='.$ssbURL;
			$googleURL = 'https://plus.google.com/share?url='.$ssbURL;
			$pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$ssbURL.'&amp;media='.$ssbThumbnail[0].'&amp;description='.$ssbTitle;
			$linkedURL = 'https://linkedin.com/shareArticle?mini=true&url='.$ssbURL.'&title='.$ssbTitle;

			// Add sharing button at the end of page/page content
			$variable = '<span class="ssb-social"><span class="ssb-text">Social Share: </span>';

			if (is_array($social_media) && in_array("facebook", $social_media)) { $variable .= '<a class="ssb-facebook" href="'.$facebookURL.'" target="_blank">'.get_svg_path('icon-facebook').'</a>'; }
			if ( in_array('twitter', $social_media) ) { $variable .= '<a class="ssb-twitter" href="'. $twitterURL .'" target="_blank">'.get_svg_path('icon-twitter').'</a>'; }
			if ( in_array('google', $social_media) ) { $variable .= '<a class="ssb-googleplus" href="'.$googleURL.'" target="_blank">'.get_svg_path('icon-google').'</a>'; }
			if ( in_array('linkedin', $social_media) ) { $variable .= '<a class="ssb-linked" href="'.$linkedURL.'" target="_blank">'.get_svg_path('icon-linkedin').'</a>'; }
			if ( in_array('pinterest', $social_media) ) { $variable .= '<a class="ssb-pinterest" href="'.$pinterestURL.'" target="_blank">'.get_svg_path('icon-pinterest').'</a>'; }
			if ( in_array('email', $social_media) ) { $variable .= '<a class="ssb-email" href="mailto:?subject=I wanted you to see this site&amp;body='.$ssbURL.'">'.get_svg_path('icon-envelope').'</a>'; }
			$variable .= '</span>';

			if ( is_single() && $ss_location=="post" || !is_single() && $ss_location=="excerpt" || $ss_location=="all" ){
				echo $variable;
			}
		}
	}
endif;

// Comment Layout
function braftonium_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>
   <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
	 <article  class="cf">
	   <header class="comment-author vcard">
		 <?php
		 /*
		   this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular WordPress gravatar call:
		   echo get_avatar($comment,$size='32',$default='<path_to_url>' );
		 */
		 ?>
		 <?php // custom gravatar call ?>
		 <?php
		   // create variable
		   $bgauthemail = get_comment_author_email();
		 ?>
		 <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
		 <?php // end custom gravatar call ?>
		 <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'braftonium' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'braftonium' ),'  ','') ) ?>
		 <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'braftonium' )); ?> </a></time>
 
	   </header>
	   <?php if ($comment->comment_approved == '0') : ?>
		 <div class="alert alert-info">
		   <p><?php _e( 'Your comment is awaiting moderation.', 'braftonium' ) ?></p>
		 </div>
	   <?php endif; ?>
	   <section class="comment_content cf">
		 <?php comment_text() ?>
	   </section>
	   <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	 </article>
   <?php // </li> is added by WordPress automatically ?>
 <?php
 }



// Add new constant that returns true if WooCommerce is active
define( 'WPEX_WOOCOMMERCE_ACTIVE', class_exists( 'WooCommerce' ) );

// Checking if WooCommerce is active
if ( WPEX_WOOCOMMERCE_ACTIVE ) {
	add_action( 'after_setup_theme', function() {
		add_theme_support( 'woocommerce' );
	} );

	add_action('woocommerce_before_main_content', 'theme_prefix_wrapper_start', 10);
	add_action('woocommerce_after_main_content', 'theme_prefix_wrapper_end', 10);
	
	function theme_prefix_wrapper_start() {
		echo '<div id="content"><div id="inner-content" class="wrap cf"><main id="main" class="m-all t-2of3 d-5of7 cf"><article class="hentry">';
	}
	
	function theme_prefix_wrapper_end() {
		echo '</article></main></div></div>';
	}
}


/* Excerpt shortening*/
$layout = get_field('blog_layout', 'option');
if ( $layout=='rich' ) {
	function custom_excerpt_length( $length ) {
		return 10;
	}
	add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
}
/* DON'T DELETE THIS CLOSING TAG */ ?>