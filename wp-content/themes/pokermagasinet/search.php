<?php
/**
 * The template for displaying search results pages.
 *
 */

get_header(); ?>

	 <div id="base-prefix-primary" class="base-prefix-content-area">
       	<main id="base-prefix-main" class="base-prefix-site-main" >
			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="base-prefix-page-title"><?php printf('Search Results for: %s', get_search_query() ); ?></h1>
				</header><!-- .page-header -->
				
				<?php
				// Start the loop.
				while ( have_posts() ) : the_post(); ?>

					<?php
					/*
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					get_template_part( 'content', 'search' );

				// End the loop.
				endwhile;

				// Previous/next page navigation.
				the_posts_pagination( array(
					'prev_text'          => 'Previous page',
					'next_text'          => 'Next page',
					'before_page_number' => '<span class="meta-nav screen-reader-text">' .'Page' . ' </span>',
				) ); ?>
			
			<?php	
			// If no content, include the "No posts found" template.
			else :
				get_template_part( 'content', 'none' );
			?>
				
			<?php endif; ?>
		</main>
	</div>
<?php get_footer(); ?>
