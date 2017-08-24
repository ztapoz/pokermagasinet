<?php
	
	$error = "true";

	$name = urlencode("No Name");
	$email = urlencode("No E-Mail");
	$subject = urlencode("No Subject");
	$message = urlencode("No Message");

	$site = urlencode($_GET['site']);

	$fields = unserialize(urldecode($_GET['fields']));

	if($fields['name']){
		$name = urlencode($_POST[$fields['name']]);
		if($name == "" || empty($name)){ 
			$error = "empty&field=name";
		}
	}

	if($fields['email']){
		$email = urlencode($_POST[$fields['email']]);
		if($email == "" || empty($email)){
			$error = "false";
		}
		if(!strpos($email, ".")){
			$error = "empty&field=email";
		}
	}

	if($fields['subject']){
		$subject = urlencode($_POST[$fields['subject']]);
		if($subject == "" || empty($subject)){
			$error = "empty&field=subject";
		}
	}

	if($fields['message']){
		$message = urlencode(trim(preg_replace('/\s\s+/', '<br/>', $_POST[$fields['message']])));
		if($message == "" || empty($message)){
			$error = "empty&field=message";
		}
	}

	if(isset($_GET['honeypot'])){
		if($_GET['honeypot'] == "true"){
			if($_POST['honey'] != ""){
				$error = "false";
			}
		}
	}

	if(isset($_GET['callback'])){
		header('Location: '.urldecode($_GET['callback']) . "?success=" . $error);
	}


	$post_action = "";
	if(isset($_POST['action'])){
		$post_action = "&action=" . urlencode($_POST['action']);
	}

	$ip = "fail";

	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
	    $ip = $_SERVER['REMOTE_ADDR'];
	}

	

	$jekyll_mail = "http://raketech-mail.herokuapp.com/?site=".$site."&name=".$name."&email=".$email."&subject=".$subject."&message=" . $message . "&ip=".$ip."&cache-control=" . uniqid() . $post_action;
	
	if($error == "true"){
		echo file_get_contents($jekyll_mail);
	}
?>
