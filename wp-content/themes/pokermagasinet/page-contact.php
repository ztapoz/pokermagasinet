<?php
/**
 *
 * Template Name: Contact
 * This is the template that displays contactpage.
 *
 */
get_header(); ?>
    <div id="pokermagasinet-primary" class="pokermagasinet-content-area">
       	<main id="pokermagasinet-main" class="pokermagasinet-site-main" >
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
            <div class="pokermagasinet-contact-form">
                <?php echo do_shortcode('[rtmail name="input:Ditt namn" email="input:Din mailadress" subject="input:Ämne" message="textarea:Ditt meddelande" submit="SKICKA" custom="form-control" ] '); ?>
            </div>
        </main><!-- .site-main -->
    </div><!-- .content-area -->
<?php get_footer(); ?>