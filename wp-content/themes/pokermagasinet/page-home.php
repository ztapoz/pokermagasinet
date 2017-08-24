<?php
/**
 *
 * Template Name: Home page
 * This is the template that displays home page.
 *
 */
get_header(); ?>
    <div id="pokermagasinet-primary" class="pokermagasinet-content-area">
       	<main id="pokermagasinet-main" class="pokermagasinet-site-main" >
            <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-10">
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
            </div>
            <?php get_sidebar();?>
            </div>
        </main><!-- .site-main -->
    </div><!-- .content-area -->
<?php get_footer(); ?>