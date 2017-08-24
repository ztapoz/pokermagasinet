<?php
/**
 *
 * This is the template that displays all pages by default.
 *
 */
get_header(); ?>
    <div id="pokermagasinet-primary" class="pokermagasinet-content-area">
       	<main id="pokermagasinet-main" class="pokermagasinet-site-main" >
            
            <div class="pokermagasinet-page-title">
                <h1><?php the_title();?></h1>
            </div>
            <?php
                //Get page content
                // Start the loop.
                while ( have_posts() ) : the_post();
            ?>
                    <div class="pokermagasinet-the-content">
                        <?php
                            the_content();
                        ?>
                    </div>
            <?php
            // End the loop.
            endwhile;
            ?>
        </main><!-- .site-main -->
    </div><!-- .content-area -->
<?php get_footer(); ?>