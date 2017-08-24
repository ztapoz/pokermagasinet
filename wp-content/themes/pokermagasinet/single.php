<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

	<div id="pokermagasinet-primary" class="pokermagasinet-content-area">
		<main id="pokermagasinet-main" class="pokermagasinet-site-main" >
			<div class="row">
				<div class="col-xs-12 <?php if(has_sidebar_widget()): ?>col-sm-7 col-md-8<?php endif;?>">
					<?php
					// Start the loop.
					while ( have_posts() ) : the_post();

						/*
						 * Include the post format-specific template for the content. If you want to
						 * use this in a child theme, then include a file called called content-___.php
						 * (where ___ is the post format) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );

						// Previous/next post navigation.
						the_post_navigation( array(
							'next_text' => '<span class="meta-nav" aria-hidden="true">' .'Next'. '</span> ' .
								'<span class="screen-reader-text">' .'Next post:'. '</span> ' .
								'<span class="post-title">%title</span>',
							'prev_text' => '<span class="meta-nav" aria-hidden="true">' .'Previous'. '</span> ' .
								'<span class="screen-reader-text">' .'Previous post:'. '</span> ' .
								'<span class="post-title">%title</span>',
						) );

					// End the loop.
					endwhile;
					?>

				</div><!-- .site-main -->
				<?php get_sidebar(); ?>
			</div>
		</main>
	</div><!-- .content-area -->

<?php get_footer(); ?>

