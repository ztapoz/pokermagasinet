<?php
/**
 * The sidebar containing the main widget area
 *
 */

if (is_active_sidebar( 'sidebar-1' )  ) : ?>
	 <aside class="col-xs-12 col-sm-2 col-md-2 pokermagasinet-rate-sidebar">
		<div id="widget-area" class="widget-area" >
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div><!-- .widget-area -->
	</aside><!-- .secondary -->

<?php endif; ?>
