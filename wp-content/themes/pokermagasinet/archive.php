<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 */

get_header(); ?>
	<div id="pokermagasinet-primary" class="pokermagasinet-content-area">
		<main id="pokermagasinet-main" class="pokermagasinet-site-main" >
			<div class="row">
				<div class="col-xs-12 <?php if(has_sidebar_widget()): ?>col-sm-7 col-md-8<?php endif;?>">
					<?php if ( have_posts() ) : ?>

						<header class="page-header">
							<?php
								the_archive_title( '<h1 class="pokermagasinet-page-title">', '</h1>' );
								the_archive_description( '<div class="taxonomy-description">', '</div>' );
							?>
						</header>

						<?php
						// Start the Loop.
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
							'prev_text'          => 'Previous page',
							'next_text'          => 'Next page',
							'before_page_number' => '<span class="meta-nav screen-reader-text">' .'Page'. ' </span>',
						) );

					// If no content, include the "No posts found" template.
					else :
						get_template_part( 'content', 'none' );

					endif;
					?>

				</div>
				<?php get_sidebar(); ?>
			</div>
		</main>
	</div><!-- .content-area -->

<?php get_footer(); ?>

