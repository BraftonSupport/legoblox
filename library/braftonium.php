<?php
/* Braftonium Theme

/*********************
Removing all stuff in WP_HEAD we don't need.
*********************/

function braftonium_head_cleanup() {
	// category feeds
	// remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
	// remove WP version from css
	add_filter( 'style_loader_src', 'braftonium_remove_wp_ver_css_js', 9999 );
	// remove Wp version from scripts
	add_filter( 'script_loader_src', 'braftonium_remove_wp_ver_css_js', 9999 );

} /* end braftonium head cleanup */

// A better title
// http://www.deluxeblogtips.com/2012/03/better-title-meta-tag.html
function rw_title( $title, $sep, $seplocation ) {
  global $page, $paged;

  // Don't affect in feeds.
  if ( is_feed() ) return $title;

  // Add the blog's name
  if ( 'right' == $seplocation ) {
    $title .= get_bloginfo( 'name' );
  } else {
    $title = get_bloginfo( 'name' ) . $title;
  }

  // Add the blog description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );

  if ( $site_description && ( is_home() || is_front_page() ) ) {
    $title .= " {$sep} {$site_description}";
  }

  // Add a page number if necessary:
  if ( $paged >= 2 || $page >= 2 ) {
    $title .= " {$sep} " . sprintf( __( 'Page %s', 'braftonium' ), max( $paged, $page ) );
  }

  return $title;

} // end better title

// remove WP version from RSS
function braftonium_rss_version() { return ''; }

// remove WP version from scripts
function braftonium_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}

// remove injected CSS for recent comments widget
function braftonium_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}

// remove injected CSS from recent comments widget
function braftonium_remove_recent_comments_style() {
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
	}
}


/*********************
SCRIPTS & ENQUEUEING
*********************/

// loading modernizr and jquery, and reply script
function braftonium_scripts_and_styles() {

  global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way

  if (!is_admin()) {

		// modernizr (without media query polyfill)
		wp_register_script( 'braftonium-modernizr', get_template_directory_uri() . '/library/js/libs/modernizr.custom.min.js', array(), '2.5.3', false );

		// register main stylesheet
		wp_register_style( 'braftonium-stylesheet', get_template_directory_uri() . '/library/css/style.css', array(), '', 'all' );

		// ie-only style sheet
		wp_register_style( 'braftonium-ie-only', get_template_directory_uri() . '/library/css/ie.css', array(), '' );

 		//adding scripts file in the footer
		wp_register_script( 'braftonium-js', get_template_directory_uri() . '/library/js/scripts.js', array( 'jquery' ), '', true );

		// enqueue styles and scripts
		wp_enqueue_script( 'braftonium-modernizr' );
		wp_enqueue_style( 'braftonium-stylesheet' );
		wp_enqueue_style( 'braftonium-ie-only' );

		$wp_styles->add_data( 'braftonium-ie-only', 'conditional', 'lt IE 9' ); // add conditional wrapper around ie stylesheet

		/*
		I recommend using a plugin to call jQuery
		using the google cdn. That way it stays cached
		and your site will load faster.
		*/
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'braftonium-js' );

	}
}

/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function braftonium_support() {

	// wp thumbnails (sizes handled in functions.php)
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'mediumsquared', 300, 300, true );

	// wp custom background (thx to @bransonwerner for update)
	add_theme_support( 'custom-background',
	    array(
	    'default-image' => '',    // background image default
	    'default-color' => '',    // background color default (dont add the #)
	    'wp-head-callback' => '_custom_background_cb',
	    'admin-head-callback' => '',
	    'admin-preview-callback' => ''
	    )
	);

	// rss thingy
	add_theme_support('automatic-feed-links');

	// registering title tag
	add_theme_support( "title-tag" );

	// registering menus
	register_nav_menus(
		array(
			'main-nav' => __( 'Navigation', 'braftonium' ),   // main nav in header
			'social' => __( 'Social Media', 'braftonium' ),   // social nav in media
		)
	);

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		// 'comment-list',
		'search-form',
		// 'comment-form'
	) );

} /* end theme support */


/*********************
RELATED POSTS FUNCTION
*********************/

// Related Posts Function (call using related_posts(); )
function related_posts() {
	echo '<ul id="related-posts">';
	global $post;
	$tags = wp_get_post_tags( $post->ID );
	if($tags) {
		foreach( $tags as $tag ) {
			$tag_arr .= $tag->slug . ',';
		}
		$args = array(
			'tag' => $tag_arr,
			'numberposts' => 3, /* you can change this to show more */
			'post__not_in' => array($post->ID)
		);
		$related_posts = get_posts( $args );
		if($related_posts) {
			foreach ( $related_posts as $post ) : setup_postdata( $post ); ?>
				<li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
			<?php endforeach; }
		else { ?>
			<?php echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'braftonium' ) . '</li>'; ?>
		<?php }
	}
	wp_reset_postdata();
	echo '</ul>';
} /* end related posts function */


/*********************
PAGE NAVI
*********************/

// Numeric Page Navi (built into the theme by default)
function page_navi() {
  global $wp_query;
  $bignum = 999999999;
  if ( $wp_query->max_num_pages <= 1 )
    return;
  echo '<nav class="pagination">';
  echo paginate_links( array(
    'base'         => str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
    'format'       => '',
    'current'      => max( 1, get_query_var('paged') ),
    'total'        => $wp_query->max_num_pages,
    'prev_text'    => '&larr;',
    'next_text'    => '&rarr;',
    'type'         => 'list',
    'end_size'     => 3,
    'mid_size'     => 3
  ) );
  echo '</nav>';
} /* end page navi */

/*********************
RANDOM CLEANUP ITEMS
*********************/

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function filter_ptags_on_images($content){
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// This removes the annoying […] to a Read More link
function excerpt_more($more) {
	global $post;
	// edit here if you like
	return '...  <a class="read-more" href="'. get_permalink( $post->ID ) . '" title="'. __( 'Read ', 'braftonium' ) . esc_attr( get_the_title( $post->ID ) ).'">'. __( 'Read more &raquo;', 'braftonium' ) .'</a>';
}

/**
 * Let's redo the social media nav
 *
 * @return array $social_links_icons
 */
	// changing it up
	class Social_Nav_Menu extends Walker_Nav_Menu {
		function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
			if ( 'social' === $args->theme_location ) {
				$social_media = preg_replace('#^www\.|\.com$#', '$1', parse_url($item->url)['host']);
				$svg = get_svg_path('icon-'.$social_media);
				$output .= sprintf("\n<li %s><a href='%s' target='_blank' title='%s'>".$svg."</a>\n", ( array_search('current-menu-item', $item->classes) ) ? '' : '', $item->url, $item->title );
			};
		}
	}
/**
 * Now the Main Nav adding the svg
 * */	
function be_arrows_in_menus( $item_output, $item, $depth, $args ) {
	if( in_array( 'menu-item-has-children', $item->classes ) ) {
		$arrow = '<button>'.get_svg_path('icon-expand').'</button>';
		$item_output = str_replace( '</a>', '</a>' . $arrow, $item_output );
	}
	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'be_arrows_in_menus', 10, 4 );
?>
