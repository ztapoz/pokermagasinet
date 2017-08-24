<?php
/**
 * The template for displaying 404 pages (not found)
 *
 */

get_header(); ?>
	<div id="pokermagasinet-primary" class="pokermagasinet-content-area">
		<main id="pokermagasinet-main" class="pokermagasinet-site-main" >
			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="pokermagasinet-page-title">Oops! That page can&rsquo;t be found.</h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p>It looks like nothing was found at this location. Maybe try a search?</p>

					<?php get_search_form(); ?>
				</div>
			</section>

		</main>
	</div>

<?php get_footer(); ?>
