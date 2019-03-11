<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

					<main id="main" class="m-all t-2of3 d-5of7 cf" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

						<article id="post-not-found" class="hentry cf">

							<header class="article-header">

								<h1><?php _e( 'Page Not Found', 'braftonium' ); ?></h1>

							</header>

							<section class="entry-content">

								<p><?php _e( 'The article you were looking for was not found, but maybe try looking again!', 'braftonium' ); ?></p>

							</section>

							<section class="search">

									<p><?php get_search_form(); ?></p>

							</section>

						</article>

					</main>
					<div class="sidebar m-all t-1of3 d-2of7 last-col cf" role="complementary">
						<h2><?php _e( 'Or were you looking for:', 'braftonium' ); ?></h2>
						<h3><?php _e( 'Our Latest Post', 'braftonium' ); ?></h3>
						<?php
							$args = array( 'numberposts' => '1' );
							$recent_posts = wp_get_recent_posts( $args );
							foreach( $recent_posts as $recent ){
								echo '<a href="' . get_permalink($recent["ID"]) . '" class="blue-btn">'. $recent["post_title"].'</a>';
							}
							wp_reset_query();
						?>
						<h3><?php _e( 'A Way to Contact Us', 'braftonium' ); ?></h3>
							<?php $page = get_page_by_title_search('contact');
							if ($page):
								echo '<a href="' . get_permalink($page[0]->ID) . '" class="blue-btn">'. $page[0]->post_title.'</a>';
							endif; ?>
						<h3><?php _e( 'Our Homepage', 'braftonium' ); ?></h3>
						<?php $frontpage_id = get_option( 'page_on_front' ); 
							echo '<a href="' . get_permalink($frontpage_id) . '" class="blue-btn">'.get_the_title($frontpage_id).'</a>'; ?>
					</div>
				</div>

			</div>

<?php get_footer(); ?>
