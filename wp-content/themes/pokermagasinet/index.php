<?php
/**
 * The main template file
 *
 */
get_header(); ?>
	<div id="pokermagasinet-primary" class="pokermagasinet-content-area">
		<main id="pokermagasinet-main" class="pokermagasinet-site-main" >
			<div class="row">
				<div class="col-xs-12 <?php if(has_sidebar_widget()): ?>col-sm-7 col-md-8<?php endif;?> blog-content">
					<?php if ( have_posts() ) : ?>

						<?php if ( is_home() && ! is_front_page() ) : ?>
							<header>
								<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
							</header>
						<?php endif; ?>

						<?php
						// Start the loop.
						while ( have_posts() ) : the_post();

							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'content', get_post_format() );

						// End the loop.
						endwhile;

						// Previous/next page navigation.
						the_posts_pagination( array(
							'prev_text'          => __( 'Previous page', 'twentyfifteen' ),
							'next_text'          => __( 'Next page', 'twentyfifteen' ),
							'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>',
						) );

					// If no content, include the "No posts found" template.
					else :
						get_template_part( 'content', 'none' );

					endif;
					?>
				</div>
				<?php get_sidebar(); ?>
		</div>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
