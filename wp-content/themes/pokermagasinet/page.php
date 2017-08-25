<?php
/**
 *
 * This is the template that displays all pages by default.
 *
 */
get_header(); ?>
    <div id="pokermagasinet-primary" class="pokermagasinet-content-area">
       	<main id="pokermagasinet-main" class="pokermagasinet-site-main" >
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-md-10">
                    <?php if(has_post_thumbnail()): ?>
                    <div class="page-thubnail">
                        <?php the_post_thumbnail(); ?>
                     </div>
                    <?php endif; ?>
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
                </div>
                <?php get_sidebar();?>
            </div>
        </main><!-- .site-main -->
    </div><!-- .content-area -->
<?php get_footer(); ?>