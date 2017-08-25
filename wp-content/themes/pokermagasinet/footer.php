	</div>
	<footer class="pokermagasinet-footer" id="pokermagasinet-footer">
        <div class="container">
        	<div class="row">
        		<div class="col-xs-12 col-sm-12 col-md-12">
                    <?php if (is_active_sidebar( 'footer-widget' )  ) : ?>
                            <div id="footer-area" class="widget-area" >
                                <?php dynamic_sidebar( 'footer-widget' ); ?>
                            </div><!-- .widget-area -->
                    <?php endif; ?>
			        <div class="pokermagasinet-contact-link">
                    <a href="<?php echo get_contact_link();?>">Kontakt oss</a></div>
			         <div class="pokermagasinet-copyright"><span>Poker</span>|&copy; <?php echo date('Y') ?>PokerMagasinet.com / Malta. </div>
		        	</div>
	        	</div>
        </div>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>