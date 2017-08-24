<?php

class BootstrapShortCode{
	private $allow_html;
	private $assets;
	public function __construct(){
		$this->assets = get_template_directory_uri().'/core/libs/bootstrap_shortcode';
	}
	private function set_filter_list(){
		$this->allow_html = array();;
	}

	public function create_bootstrap_shortcode(){
		$this->register_shortcode();
		add_action('admin_head', array($this,'create_section_editor_button'));
		add_action( 'admin_enqueue_scripts', array($this,'import_admin_styles'));
		add_filter( 'the_content', array($this,'clean_shortcode_content'));
		add_filter( 'acf_the_content', array($this,'clean_acf_editor_shortcode'));
	}

	private function register_shortcode(){
		$short_code = array(
			'col-1' => 'create_column_1_shortcode',
			'col-2' => 'create_column_2_shortcode',
			'col-3' => 'create_column_3_shortcode',
			'col-4' => 'create_column_4_shortcode',
			'col-5' => 'create_column_5_shortcode',
			'col-6' => 'create_column_6_shortcode',
			'col-7' => 'create_column_7_shortcode',
			'col-8' => 'create_column_8_shortcode',
			'col-9' => 'create_column_9_shortcode',
			'col-10' => 'create_column_10_shortcode',
			'col-11' => 'create_column_11_shortcode',
			'col-12' => 'create_column_12_shortcode',
			'section' => 'create_section_shortcode'
		);
		foreach($short_code as $name => $callback){
			add_shortcode($name, array($this,$callback));
		}
	}

	private function create_column_shortcode($column_type,$class = '',$id='',$content){
		$content = do_shortcode($content);
		$column = '<div class="col-xs-12 col-sm-'.$column_type;
		if($class){
			$column .= ' '.$class;
		}
		$column .= '"';
		if($id){
			$column .= ' id="'.$id.'"';
		}
		$column .= '>'.$content.'</div>';
		return $column;
	}

	private function get_default_attributes($atts){
		return shortcode_atts(array(
			'class' => '',
			'id' => ''
		), $atts);
	}

	public function create_column_1_shortcode($atts = [], $content){
		$attributes = $this->get_default_attributes($atts);
		$shortcode = $this->create_column_shortcode(1,$attributes['class'],$attributes['id'],$content);
    	return $shortcode;
	}
	
	public function create_column_2_shortcode($atts = [], $content){
	    $attributes = $this->get_default_attributes($atts);
		$shortcode = $this->create_column_shortcode(2,$attributes['class'],$attributes['id'],$content);
    	return $shortcode;
	}

	public function create_column_3_shortcode($atts = [], $content){
	   $attributes = $this->get_default_attributes($atts);
		$shortcode = $this->create_column_shortcode(3,$attributes['class'],$attributes['id'],$content);
    	return $shortcode;
	}

	public function create_column_4_shortcode($atts = [], $content){
	    $attributes = $this->get_default_attributes($atts);
		$shortcode = $this->create_column_shortcode(4,$attributes['class'],$attributes['id'],$content);
    	return $shortcode;
	}

	public function create_column_5_shortcode($atts = [], $content){
	    $attributes = $this->get_default_attributes($atts);
		$shortcode = $this->create_column_shortcode(5,$attributes['class'],$attributes['id'],$content);
    	return $shortcode;
	}

	public function create_column_6_shortcode($atts = [], $content){
	    $attributes = $this->get_default_attributes($atts);
		$shortcode = $this->create_column_shortcode(6,$attributes['class'],$attributes['id'],$content);
    	return $shortcode;
	}

	public function create_column_7_shortcode($atts = [], $content){
	    $attributes = $this->get_default_attributes($atts);
		$shortcode = $this->create_column_shortcode(7,$attributes['class'],$attributes['id'],$content);
    	return $shortcode;
	}

	public function create_column_8_shortcode($atts = [], $content){
	    $attributes = $this->get_default_attributes($atts);
		$shortcode = $this->create_column_shortcode(8,$attributes['class'],$attributes['id'],$content);
    	return $shortcode;
	}

	public function create_column_9_shortcode($atts = [], $content){
	    $attributes = $this->get_default_attributes($atts);
		$shortcode = $this->create_column_shortcode(9,$attributes['class'],$attributes['id'],$content);
    	return $shortcode;
	}

	public function create_column_10_shortcode($atts = [], $content){
	    $attributes = $this->get_default_attributes($atts);
		$shortcode = $this->create_column_shortcode(10,$attributes['class'],$attributes['id'],$content);
    	return $shortcode;
	}

	public function create_column_11_shortcode($atts = [], $content){
	    $attributes = $this->get_default_attributes($atts);
		$shortcode = $this->create_column_shortcode(11,$attributes['class'],$attributes['id'],$content);
    	return $shortcode;
	}

	public function create_column_12_shortcode($atts = [], $content){
	    $attributes = $this->get_default_attributes($atts);
		$shortcode = $this->create_column_shortcode(12,$attributes['class'],$attributes['id'],$content);
    	return $shortcode;
	}

	public function create_section_shortcode($atts = [], $content){
	    $content = do_shortcode($content);
	    $attributes = $this->get_default_attributes($atts);
	    $section = '<div class="row shortcode-section';
		if($attributes['class']){
			$section .= ' '.$attributes['class'];
		}
		$section .= '"';
		if($attributes['id']){
			$section .= ' id="'.$attributes['id'].'"';
		}
		$section .= '>'.$content.'</div>';
		return $section;
	}

	public function import_script_section_button($plugin_array){
	    $plugin_array['section_button'] = $this->assets.'/custom_editor.js';
	    return $plugin_array;
	}

	public function import_admin_styles(){
		wp_enqueue_style('bootstrap-shortcode',$this->assets.'/editor_styles.css');
	}

	public function register_section_button($buttons){
	    $re_orders = array();
	    foreach ($buttons as $button){
	        if($button == 'wp_adv'){
	           $re_orders[] =  'section_button';
	           $re_orders[] =  'column_button';
	           if(shortcode_exists('casino-list')){
	           		$re_orders[] =  'casino_list_button';
	           }

	           if(shortcode_exists('casino-boxes')){
	           		$re_orders[] =  'casino_boxes_button';
	           }
	           
	        }
	        $re_orders[] =  $button;
	    }
	    return $re_orders;
	}

	public function create_section_editor_button(){
	    if(!current_user_can('edit_posts' ) || !current_user_can('edit_pages')){
	        return false;
	    }
	    if(get_user_option('rich_editing')){
	        add_filter('mce_external_plugins', array($this,'import_script_section_button'));
	        add_filter('mce_buttons', array($this,'register_section_button'));
	    }
	}

	public function clean_shortcode_content($content){
	    $array = array (
	        '<p>[' => '[', 
	        ']</p>' => ']', 
	        ']<br />' => ']'
	    );
	    $content = strtr($content, $array);

    	return $content;
	}

	function clean_acf_editor_shortcode($content){
	    remove_filter( 'the_content', 'wpautop' );
	    add_filter( 'the_content', 'wpautop' , 12);
	    $array = array(
	        '<p>[' => '[',
	        ']</p>' => ']',
	        ']<br />' => ']',
	        '<p><div' => '[',
	        '</div></p>' => ']',
	        '</div><br />' => ']'
    	);
    	$content = strtr( $content, $array );
    	return $content;
	}
}