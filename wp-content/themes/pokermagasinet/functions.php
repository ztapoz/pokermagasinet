<?php
require_once get_template_directory().'/core/ThemeBuilder.php';

function get_theme_builder(){
    return ThemeBuilder::create_builder();
}

function init_theme(){
    $builder = get_theme_builder();
    $builder->init_theme();
    $builder->add_bootstrap_shortcode();
    $builder->create_option_page();
}
add_action('after_setup_theme','init_theme');


function get_theme_logo(){
    $builder = get_theme_builder();
    return $builder->get_theme_logo();
}

function import_theme_styles(){
    $style_list = array(
        'main-style' => array(
            'src' => 'pokermagasinet.css'
        ),
    );
    $builder = get_theme_builder();
    $builder->import_google_fonts(array('Lato:400,700'));
    $builder->import_assets_style($style_list);
}
add_action("wp_enqueue_scripts","import_theme_styles");

function import_theme_scripts(){
    $script_list = array(
        'vendor-js' => array(
            'src' => 'pokermagasinet-vendor.js'
        ),
        'main-js' => array(
            'src' => 'pokermagasinet.js'
        ),
        
    );
    $builder = get_theme_builder();
    $builder->import_assets_script($script_list);
}
add_action("wp_enqueue_scripts","import_theme_scripts");

function get_page_slider_data(){
   $builder = get_theme_builder();
   return $builder->get_slider_data('website_slider','slider',array('link'));
}

function has_sidebar_widget(){
    $builder = get_theme_builder();
    return $builder->has_sidbar_widget();
}

function body_classes( $classes ) {
    // Adds a class of custom-background-image to sites with a custom background image.
    if ( get_background_image() ) {
        $classes[] = 'custom-background-image';
    }

    // Adds a class of group-blog to sites with more than 1 published author.
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    // Adds a class of no-sidebar to sites without active sidebar.
   
    if ( is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'has-sidebar';
    } else {
        $classes[] = 'no-sidebar';
    }

    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    return $classes;
}
add_filter( 'body_class', 'body_classes' );

function shortcode_casino_boxes(){
    ob_start();
    if(!class_exists('acf')) return ob_get_clean();
    $frontpage_id = get_option('page_on_front' );
    if(have_rows("casino_boxes",$frontpage_id)): 
?>
        <div class="pokermagasinet-casino-boxes"> 
            <div class="row">
                <?php 
                    while(have_rows("casino_boxes", $frontpage_id)): the_row(); 
                        $image = get_sub_field("logo");
                        $rate = get_sub_field("rate");
                ?> 
                    <div class="col-xs-12 col-sm-4">
                        <div class="pokermagasinet-casino-box">
                            <div class="pokermagasinet-casino-logo">
                                 <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
                            </div>
                            <div class="pokermagasinet-casino-detail">
                                <ul class="pokermagasinet-rate">
                                    <?php for($i=1;$i <= 5; $i++ ):?>
                                        <?php if($i<=$rate):?>
                                            <li class="rated">&#9733;</li>
                                        <?php else:?>
                                            <li></li>
                                        <?php endif;?>
                                    <?php endfor;?>
                                </ul>
                                <div class="description">
                                    <?php echo get_sub_field("description"); ?>
                                </div>
                                <a class="btn btn-primary" href="<?php echo get_sub_field("besok"); ?>"><?php echo get_sub_field_object("besok")['label'] ?> >></a>
                            </div>
                        </div>
                    </div> 
                <?php endwhile; ?>
            </div>
        </div>
<?php
    endif;
    return ob_get_clean();
}
add_shortcode( 'casino-boxes', 'shortcode_casino_boxes' );

function get_casino_list_shortcode( $atts ) {
    ob_start();
    if(!class_exists('acf')) return ob_get_clean();
    if(have_rows("casino_list")): 
        $logo_lbl = get_sub_field_object('po_logo')['label'];
        $casino_lbl = get_sub_field_object('po_bonus')['label'];
        $info_lbl = get_sub_field_object('po_info')['label'];
        $character_lbl = get_sub_field_object('po_karakter')['label'];
?>      
        <table class="pokermagasinet-casino-list ">
            <thead>
                <tr>
                    <th><?php echo $logo_lbl  ?></th>
                    <th><?php echo $casino_lbl ?></th>
                    <th><?php echo $info_lbl  ?></th>
                    <th><?php echo $character_lbl  ?></th>
                </tr>
            </thead>
            <tbody>
            <?php while(have_rows("casino_list")): the_row();
                $images = get_sub_field("po_logo");
            ?>
                <tr>
                    <td data-title="<?php echo $logo_lbl  ?>">
                        <img src="<?php echo $images['url']; ?>" alt="<?php echo $images['alt']; ?>">
                    </td>
                    <td data-title="<?php echo $casino_lbl ?>">
                        <?php echo get_sub_field("po_bonus"); ?>
                    </td>
                    <td data-title="<?php echo $info_lbl  ?>">
                     <?php echo get_sub_field("po_info"); ?>
                    </td>
                    <td data-title="<?php echo $character_lbl  ?>">
                         <?php echo get_sub_field("po_karakter").'%'; ?>
                    </td>
                </tr>
            <?php endwhile;?>
            </tbody>
        </table>
    <?php endif;
    return ob_get_clean();
}
add_shortcode( 'casino-list', 'get_casino_list_shortcode' );
function get_review_postype()
{
    $label = array(
        'name' => 'Review',
        'singular_name' => 'Review',
        'all_items'          => 'All Review',
        'menu_icon' => 'dashicons-cart',
    );
    $args = array(
        'labels' => $label,
        'description' => 'Post type Review',
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail',
            'custom-fields'
        ),
        'taxonomies' => array('review'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'menu_icon' => '',
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'menu_icon' => 'dashicons-format-chat',
    );
    register_post_type('review', $args);
}
add_action('init', 'get_review_postype');
function remove_casinos_slug( $post_link, $post, $leavename ) {
    if ( 'review' != $post->post_type || 'publish' != $post->post_status ) {
        return $post_link;
    }

    $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );

    return $post_link;
}
add_filter( 'post_type_link', 'remove_casinos_slug', 10, 3 );
function parse_request( $query ) {
    if ( ! $query->is_main_query() || 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
        return;
    }
    if ( ! empty( $query->query['name'] ) ) {
        $query->set( 'post_type', array( 'post', 'review', 'page' ) );
    }
}
add_action( 'pre_get_posts', 'parse_request' );

function get_top_list_shortcode( $att ) {
    ob_start();
    if(!class_exists('acf')) return ob_get_clean();
    if(have_rows("top_list")): 
        $site_lbl = get_sub_field_object('name_site')['label'];
        $program_lbl = get_sub_field_object('program')['label'];
        $info_lbl = get_sub_field_object('info')['label'];
        $rate_lbl = get_sub_field_object('rate')['label'];
?>      
        <table class="pokermagasinet-top-list ">
            <thead>
                <tr>
                    <th></th>
                    <th><?php echo $site_lbl  ?></th>
                    <th></th>
                    <th><?php echo $program_lbl ?></th>
                    <th><?php echo $info_lbl  ?></th>
                    <th><?php echo $rate_lbl  ?></th>
                </tr>
            </thead>
            <tbody>
            <?php while(have_rows("top_list")): the_row();
                $images = get_sub_field("flag");
            ?>
                <tr>
                    <td>
                        <?php if($images): ?>
                        <img src="<?php echo $images['url']; ?>" alt="<?php echo $images['alt']; ?>">
                        <?php endif;?>
                    </td>
                    <td data-title="<?php echo $site_lbl ?>">
                        <a href="<?php echo get_sub_field('url');?>">
                        <?php echo get_sub_field("name_site"); ?>
                        </a>
                    </td>
                    <td >
                         <?php  $medal = get_sub_field("medal");
                            switch ($medal) {
                                    case 1:
                                        echo '<i class="medal-gold"></i>';
                                        break;
                                    case 2:
                                         echo '<i class="medal-silver"></i>';
                                        break;
                                    case 3:
                                        echo '<i class="medal-copper"></i>';
                                        break;
                                }
                           ?>

                    </td>
                    <td data-title="<?php echo $program_lbl  ?>">
                     <?php echo get_sub_field("program"); ?>
                    </td>
                    <td data-title="<?php echo $info_lbl  ?>">
                     <?php echo get_sub_field("info"); ?>
                    </td>
                    <td data-title="<?php echo $rate_lbl  ?>">
                         <?php echo get_sub_field("rate").'%'; ?>
                    </td>
                </tr>
            <?php endwhile;?>
            </tbody>
        </table>
    <?php endif;    
    return ob_get_clean();
}
add_shortcode( 'top-list', 'get_top_list_shortcode' );

function get_contact_link(){
  $pages = get_pages(array(
      'post_type'  => 'page',
      'meta_key'   => '_wp_page_template',
      'meta_value' => 'page-contact.php'
  ));
  if(!empty($pages) && $pages[0]->ID) return get_page_link($pages[0]->ID);
  return '#';
}