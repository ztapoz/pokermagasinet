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
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-md-10">
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
                        <?php echo do_shortcode('[rtmail name="input:Navn*" email="input:E-post*" subject="input:Emne*" message="textarea:Kommentar*" custom="contact-form" submit="Send inn" custom="contact-form form-control" error="Noe gikk galt" success="Melding sendt!" field_error="Vær nøye med å fylle inn alle de markerte feltene"]'); ?>
                    </div>
                </div>
                <?php get_sidebar();?>
            </div>
        </main><!-- .site-main -->
    </div><!-- .content-area -->
<?php get_footer(); ?>