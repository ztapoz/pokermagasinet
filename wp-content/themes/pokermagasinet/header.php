<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header class="pokermagasinet-header" id="pokermagasinet-header">
        <nav class="navbar">
          <div class="container">
            <div class="rows">
                <div class="navbar-header">
                    <button class="navbar-toggle" id="menu-button" data-toggle="collapse" data-target="#pokermagasinet-menu-nav">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span><span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand logo" href="<?php echo home_url();?>">
                        <img src="<?php echo get_theme_logo(); ?>" alt="<?php bloginfo('name'); ?>" />
                 </a>
                </div>
                <div class="collapse navbar-collapse" id="pokermagasinet-menu-nav">
                    <?php
                        wp_nav_menu( array(
                            'menu' => 'top_menu',
                            'theme_location' => 'primary',
                            'depth' => 2,
                            'container' => false,
                            'menu_class' => 'nav navbar-nav',
                            //Process nav menu using our custom nav walker
                            'walker' => new wp_bootstrap_navwalker())
                        );
                    ?>
                </div>
            </div>
          </div>
        </nav>
    </header>
    <?php 
        $sliders = get_page_slider_data();
        if($sliders) :
    ?>
        <div class="pokermagasinet-page-slider">
            <?php $i = 0 ; foreach($sliders as $slider):?>
                <?php if($slider['image']):?>
                    <div class="pokermagasinet-slide">

                        <?php if($slider['link']): ?>
                            <a href="<?php echo $slider['link'];?>">
                        <?php endif;?>
                           
                            <img class="pokermagasinet-slider-image" src="<?php echo $slider['image']; ?>" alt="<?php echo empty($slider['alt']) == false ? $slider['alt'] : 'slider-'.++$i; ?>" />
                        <?php if($slider['link']): ?>
                            </a>
                        <?php  endif;?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <div class="container pokermagasinet-base-container">
            