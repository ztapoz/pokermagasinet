<?php

require_once get_template_directory().'/core/libs/wp_bootstrap_navwalker.php';
require_once get_template_directory().'/core/libs/template-tags.php';
require_once get_template_directory().'/core/libs/BootstrapShortcode.php';

class ThemeBuilder{

	private static $builder = null;
	private $theme_directory;
	private $theme_directory_uri;
	private $theme_assets_uri;
	private $google_fonts;
	private $bootstrap_shortcode;
	
	private function __construct(){
		$this->theme_directory = get_template_directory();
		$this->theme_directory_uri = get_template_directory_uri();
		$this->theme_assets_uri = $this->theme_directory_uri."/assets";
		$this->bootstrap_shortcode = new BootstrapShortCode();
	}

	public static function create_builder(){
		if(self::$builder === null){
			self::$builder = new ThemeBuilder();
		}
		return self::$builder;
	}

	public function init_theme(){
		$this->register_features();
		add_action('widgets_init', array($this,'register_widget_sidebar'));
	}

	public function get_theme_assets_uri(){
		return $this->theme_assets_uri;
	}

	public function get_assets_child($child_path){
		return $this->theme_assets_uri.'/'.$child_path;
	}

	public function add_bootstrap_shortcode(){
		$this->bootstrap_shortcode->create_bootstrap_shortcode();
	}

	private function register_features(){
		/* Hide admin bar at frontend */
		show_admin_bar(false);

		/* Register Primary navigation for site */
		register_nav_menu('primary', 'Primary navigation');
		/* Register Right Sidebar navigation for site */
		register_nav_menu('right-sidebar', 'Right Sidebar navigation');
		/* Enable dynamic title for another page */
		add_theme_support('title-tag');

		/*  Enable feature image for post and page */
		add_theme_support('post-thumbnails');

		/*  Enable custom logo setting */
		add_theme_support('custom-logo');

		/*  Enable custom header image setting */
		add_theme_support('custom-header');

		/*  Enable custom background setting */
		add_theme_support('custom-background');

		/*  Enable selective-refresh-widgets */
		add_theme_support('customize-selective-refresh-widgets');

		/*  Enable html5 element for form */
		add_theme_support('html5', array(
			'search-form',
	        'comment-form',
	        'comment-list',
	        'gallery',
	        'caption'
	    ));

		/*  Enable post format types */
	    add_theme_support('post-formats', array(
	        'aside',
	        'gallery',
	        'link',
	        'image',
	        'quote',
	        'status',
	        'video',
	        'audio',
	        'chat'
	    ));

	    add_post_type_support( 'page' , 'excerpt');
	}

	public function register_widget_sidebar(){
		register_sidebar( array(
	        'name'          => 'Widget Area',
	        'id'            => 'sidebar-1',
	        'description'   => 'Add widgets here to appear in your sidebar.',
	        'before_widget' => '<div id="%1$s" class="widget %2$s">',
	        'after_widget'  => '</div>',
	        'before_title'  => '<h2 class="widget-title">',
	        'after_title'   => '</h2>',
	    ));
	     register_sidebar( array(
	        'name'          => 'Footer Widget Area',
	        'id'            => 'footer-widget',
	        'description'   => 'Add widgets here to appear in your footer.',
	        'before_widget' => '<div id="%1$s" class="widget %2$s">',
	        'after_widget'  => '</div>',
	        'before_title'  => '<h2 class="widget-title">',
	        'after_title'   => '</h2>',
	    ));
	}

	public function import_google_fonts($font_list = array()){
		$fonts_url = '';
		if(count($font_list) > 0){
			$query_args = array(
	        	"family" => implode("|",$font_list)
	    	);
	    	$fonts_url = add_query_arg($query_args, "https://fonts.googleapis.com/css");
	    	 
		}
		$this->google_fonts = esc_url_raw($fonts_url);
	}

	public function get_favicon(){
		return $this->theme_directory_uri."/favicon.png";
	}

	public function get_theme_logo(){
		if(!function_exists('the_custom_logo')){
        	return;
	    }
	    $custom_logo_id = get_theme_mod("custom_logo");
	    $logo = wp_get_attachment_image_src($custom_logo_id ,"full");
	    return $logo[0];
	}

	public function import_assets_style($style_list = array()){
		$style_folder = $this->get_assets_child('styles').'/';
		$site_name = str_replace(" ","-", strtolower(get_bloginfo("name")));
		if($this->google_fonts){
			wp_enqueue_style($site_name.'-google-fonts',$this->google_fonts);
		}
		foreach($style_list as $style => $options){
			if(!array_key_exists('deps',$options)){
				$options['deps'] = array();
			}
			if(!array_key_exists('ver',$options)){
				$options['ver'] = '1.0';
			}
			if(!array_key_exists('media',$options)){
				$options['media'] = 'all';
			}
			wp_enqueue_style($style, $style_folder.$options['src'], $options['deps'], $options['ver'],$options['media']);
		}
		
	}

	public function import_assets_script($script_list = array()){
		$script_folder = $this->get_assets_child('scripts').'/';
		foreach($script_list as $script => $options){
			if(!array_key_exists('deps',$options)){
				$options['deps'] = array();
			}
			if(!array_key_exists('ver',$options)){
				$options['ver'] = '1.0';
			}
			if(!array_key_exists('in_footer',$options)){
				$options['in_footer'] = 'true';
			}
			wp_enqueue_script($script, $script_folder.$options['src'], $options['deps'], $options['ver'],$options['in_footer']);
		}
	}

	public function get_slider_data($option_id, $image_field, $meta_fields = array()){

		if(!function_exists('get_sub_field') || !$image_field){
	        return null;
	    }
	    
	    if(have_rows($option_id, 'option')){
	    	$sliderData = array();
	    	$count = 0;
	        while(have_rows($option_id, 'option')){
	            the_row();
	            $sliderImage = get_sub_field($image_field);
	            $sliderData[$count] = array(
	            	'image' => $sliderImage['url'],
	            	'alt' => $sliderImage['alt']
	            );
	            foreach($meta_fields as $field){
		            $sliderData[$count][$field] =  get_sub_field($field);
	            }
	            $count++;
	        }	
	    }
	    else{
	        $sliderData = null;
	    }
	    return $sliderData;
	}

	public function create_option_page($option = array()){
		if(!function_exists("acf_add_options_page")){
        	return;
	    }
	    if(empty($option)){
	    	$option  = array(
		        'page_title' => 'Theme Settings',
		        'menu_title' => 'Theme Settings'
	    	);
	    }
	    acf_add_options_page($option);
	}

	public function has_sidbar_widget(){
		$widgets = wp_get_sidebars_widgets();
		if(count($widgets['sidebar-1']) > 0){
			return true;
		}
		return false;
	}


}