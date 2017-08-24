<?php
	/*
		Plugin Name: RakeTech Mail
		Description: Sends all e-mails to contact1@raketech.com
		Version: 1.2.0 (CR1)
		Author: Tom Gouder (RakeTech)
	*/

	/**********************************
	*			Activation			  *
	***********************************/

	function raketech_mail_activate() {

		$file_name = uniqid() . ".php";
		$file_content = file_get_contents(plugin_dir_path(  __FILE__ ) . 'Mailer.php');

		if(get_option('RTMail')){
			$file = get_option('RTMail');
			if(!file_exists(plugin_dir_path( __FILE__ ) . $file)){
				file_put_contents(plugin_dir_path( __FILE__ ) . $file_name, $file_content) or die("<p style='font-family: sans-serif;'>Plugin files could not be generated..</p>");
				update_option( 'RTMail', $file_name);
			}
		} else {
			file_put_contents(plugin_dir_path( __FILE__ ) . $file_name, $file_content) or die("<p style='font-family: sans-serif;'>Plugin files could not be generated..</p>");
			add_option( 'RTMail', $file_name, '', 'yes' );
		}

		checkForUpdate();
	}

	register_activation_hook( __FILE__, 'raketech_mail_activate' );

	/**********************************
	*			Shortcode			  *
	***********************************/

	function raketech_mail_shortcode( $atts ){
		global $post;
		$html = '';
		$success = false;
		$fieldsc = false;
		$field_css = '';
		$field_attr = '';

		if(isset($_GET['success'])){

			// Generate random class name
			$random_class_name = "mail-".substr(str_shuffle(str_repeat("qwertyuiopasdfghjklzxcvbnm", 5)), 0, 5);

			// Set up html
			$custom_error = '<div class="'.$random_class_name.'-failure '.$random_class_name.'-notification-box">Something went wrong..</div>';
			if(isset($atts['error'])){
				$custom_error = '<div class="'.$random_class_name.'-failure '.$random_class_name.'-notification-box">'.$atts['error'].'</div>';
			}

			$custom_field_error = '<div class="'.$random_class_name.'-failure '.$random_class_name.'-notification-box">Please fill in the highlighted field(s)..</div>';
			if(isset($atts['field_error'])){
				$custom_field_error = '<div class="'.$random_class_name.'-failure '.$random_class_name.'-notification-box">'.$atts['field_error'].'</div>';
			}

			$custom_success = '<div class="'.$random_class_name.'-success '.$random_class_name.'-notification-box">Your message has been sent!</div>';
			if(isset($atts['success'])){
				$custom_success = '<div class="'.$random_class_name.'-success '.$random_class_name.'-notification-box">'.$atts['success'].'</div>';
			}

			// Inline css output
			$inline_css = "<style>.".$random_class_name."-notification-box{-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px;color:#fff;margin-bottom:25px;padding:10px 14px 10px 44px;position:relative;width:-moz-fit-content;width:-webkit-fit-content;width:fit-content}.".$random_class_name."-success{background-color:#2ecc71}.".$random_class_name."-failure{background-color:#e74c3c}.".$random_class_name."-warning{background-color:#e67e22}.".$random_class_name."-information{background-color:#3498db}.".$random_class_name."-question{background-color:#f1c40f}.".$random_class_name."-tip{background-color:#16a085}.".$random_class_name."-notice{background-color:#bea474}</style>";

			// Check what notification type to show
			if($_GET['success'] == "false"){
				$html = $html . $inline_css . $custom_error;
			}

			if($_GET['success'] == "true"){
				$html = $html . $inline_css . $custom_success;
				$success = true;
			}

			if($_GET['success'] == "empty"){
				$html = $html . $inline_css . $custom_field_error;
				$fieldsc = true;
				$field_attr = $_GET['field'];
			}
		}

		$html = $html . "<form method='post' onsubmit='document.getElementById(".'"submitButton"'.").disabled = true; return true;' action='".get_raketech_mailer("name","email","subject","message", get_page_link(), true)."'>";


		$classes = '';
		if(isset($atts['custom'])){
			$classes = 'class="'.$atts['custom'].'"';
		}


		foreach ($atts as $field => $att) {
			if($field != "submit" && $field != "custom" && $field != "error" && $field != "success" && $field != "field_error"){
				$title = explode(":", $att)[1];
				$type = explode(":", $att)[0];

				$disabled = '';
				if($success){
					$disabled = 'disabled';
				}

				if($fieldsc && isset($_GET['field'])){
					if($_GET['field'] == $field){
						$field_css = 'style="border-color: red;"';
					} else {
						$field_css = '';
					}
				} else {
					$field_css = '';
				}

				if($field == "email") {
					$html = $html . '<'.$type.' type="email" '.' '.$classes.' placeholder="'.$title.'" name="'.$field.'" '.$field_css.' required>';
				} else {
					if($type == "textarea"){
						$html = $html . '<'.$type.' '.' '.$classes.' placeholder="'.$title.'" name="'.$field.'" '.$field_css.' required>';
					} else {
						$html = $html . '<'.$type.' type="text" '.' '.$classes.' placeholder="'.$title.'" name="'.$field.'" '.$field_css.' required>';
					}
				}

				if($type == "textarea"){
					$html = $html . "</textarea><br/>";
				} else {
					$html = $html . "<br/>";
				}
			} else {
				if($field == "submit"){
					$html = $html . "<button id='submitButton' type='submit'>".$att."</button>";
				}
			}
		}
		$html = $html . generate_honeypot();
		$html = $html . generate_taddletail(get_post_permalink($post->ID));
		$html = $html . "</form>";

		checkForUpdate();

		return $html;
	}
	
	add_shortcode( 'rtmail', 'raketech_mail_shortcode' );


	/**********************************
	*			Custom Func.		  *
	***********************************/


	function get_raketech_mailer($field_name = false, $field_email = false, $field_subject = false, $field_message = false, $callback = false, $honeypot = false){
		$site = get_bloginfo('name');

		$fields = ["name" => $field_name, "email" => $field_email, "subject" => $field_subject, "message" => $field_message];

		$serialised_fields = urlencode(serialize($fields));

		if($callback){
			$callback = "&callback=" . urlencode($callback);
		}

		if($honeypot){
			$honeypot = "&honeypot=true";
		}

		return plugins_url( get_option('RTMail') , __FILE__ ) . "?site=" . urlencode($site) . "&fields=" . $serialised_fields . $callback . $honeypot;
	}

	function generate_honeypot(){
		return '<input type="text" name="honey" style="display:none;"><br/>';
	}

	function generate_taddletail($url) {
		return '<input type="hidden" name="action" style="display:none;" value="'.$url.'"><br/>';
	}

	/**********************************
	*			Update Func.		  *
	***********************************/

	
	function checkForUpdate(){

		$rtd = plugin_dir_path( __FILE__ );
		delete($rtd . "tmp");

		// Check to see if the Update Key is set.
		if(!get_option("rtmail_update_key")){
			// Key does not exist.
			getUpdate();
		} else {
			// Key exists.. Proceed to compare..
			$updateKey = get_option("rtmail_update_key");
			$comparerKey = getUpdateKey();
			if($updateKey != $comparerKey) {
				getUpdate();
			}
		}
	}

	function getUpdateKey() {
		// Retrieves update key
		
		if(get_option('rtmail-checkbox') == 1 || get_option('rtmail-checkbox') == "1"){
			$updateKey = file_get_contents("http://raketech-mail.herokuapp.com/plugin/?source=development");
		} else {
			$updateKey = file_get_contents("http://raketech-mail.herokuapp.com/plugin/?source=release");
		}
		return $updateKey;
	}

	function getUpdate() {

		$rtd = plugin_dir_path( __FILE__ );
		// Retrieves the update and makes filesystem changes
		// First, get the .ZIP file, and create it.
		mkdir($rtd . "tmp") or die("Error creating temporary directory for RakeTech Mail Upgrade..");
		$zip = new ZipArchive();
		$zip->open($rtd . 'tmp/tmp.zip', ZipArchive::CREATE);
		$zip->addFromString($rtd . 'tmp', '');
		$zip->close();

		/* Get the URL file */
		// IMPORTANT: The following conditional statement retrieves the plugin source code

		$url = "http://raketech-mail.herokuapp.com/plugin/release/RTMail.zip";

		if(get_option('rtmail-checkbox') == 1 || get_option('rtmail-checkbox') == "1"){
			$url = "http://raketech-mail.herokuapp.com/plugin/development/RTMail.zip";
		}

		$zipFile = $rtd . "tmp/tmp.zip";
		$zipResource = fopen($zipFile, "w");

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
		curl_setopt($ch, CURLOPT_FILE, $zipResource);
		$page = curl_exec($ch);

		if(!$page) {
			echo "Error :- ".curl_error($ch);
		}
		curl_close($ch);

		$zip = new ZipArchive;
		$extractPath = $rtd . "tmp";
		if($zip->open($zipFile) != "true"){
			echo "Error :- Unable to open the Zip File";
		}

		/* Extract ZIP File */

		$zip->extractTo($extractPath);
		$zip->close();

		unlink($rtd . "tmp/tmp.zip");
		delete($rtd . "tmp/__MACOSX");

		/* Loop through all files in current directory */

		file_put_contents($rtd . "RTMail.php", file_get_contents($rtd . "tmp/RTMail/RTMail.php"));
		file_put_contents($rtd . "Mailer.php", file_get_contents($rtd . "tmp/RTMail/Mailer.php"));


		$file_whitelist = array("RTMail.php", "Mailer.php", ".DS_Store");
		$dir = new DirectoryIterator(dirname(__FILE__));
		foreach ($dir as $fileinfo) {
		    if (!$fileinfo->isDot()) {
		    	if(!in_array($fileinfo->getFilename(), $file_whitelist) && strpos($fileinfo->getFilename(), ".php") && strpos($fileinfo->getFilename(), "tmp") !== true){
					file_put_contents($rtd . $fileinfo->getFilename(), file_get_contents($rtd . "tmp/RTMail/Mailer.php"));
		    	}
		    }
		}


		$option_name = 'rtmail_update_key';
		$new_value = getUpdateKey();

		if ( get_option( $option_name ) != $new_value ) {
			update_option( $option_name, $new_value );
		} else {
			$deprecated = ' ';
			$autoload = 'no';
			add_option( $option_name, $new_value, $deprecated, $autoload );
		}
		

		delete($rtd . "tmp");
	}

	function delete($path)
	{
	    if (is_dir($path) === true)
	    {
	        $files = array_diff(scandir($path), array('.', '..'));

	        foreach ($files as $file)
	        {
	            Delete(realpath($path) . '/' . $file);
	        }

	        return rmdir($path);
	    }

	    else if (is_file($path) === true)
	    {
	        return unlink($path);
	    }

	    return false;
	}

	/**********************************
	*			Settings Func.		  *
	***********************************/

	function rtmail_settings_page()
	{
	    add_settings_section("section", "Plugin Source Control", null, "rtmail");
	    add_settings_field("rtmail-checkbox", "Development Release", "rtmail_checkbox_display", "rtmail", "section");  
	    register_setting("section", "rtmail-checkbox");
	}

	function rtmail_checkbox_display()
	{
	   ?>
	        <!-- Here we are comparing stored value with 1. Stored value is 1 if user checks the checkbox otherwise empty string. -->
	        <input type="checkbox" name="rtmail-checkbox" value="1" <?php checked(1, get_option('rtmail-checkbox'), true); ?> /> 

	   <?php
	   	
	   checkForUpdate();
	}

	add_action("admin_init", "rtmail_settings_page");

	function rtmail_page()
	{
	  ?>
	      <div class="wrap">
	         <h1>RakeTech Mail Configuration</h1>
	  
	         <form method="post" action="options.php">
	            <?php
	               settings_fields("section");
	  
	               do_settings_sections("rtmail");
	                 
	               submit_button(); 
	            ?>
	         </form>
	      </div>
	   <?php
	}

	function menu_item()
	{
	  add_submenu_page("options-general.php", "rtmail", "RakeTech Mail", "manage_options", "rtmail", "rtmail_page"); 
	}
	 
	add_action("admin_menu", "menu_item");
?>
