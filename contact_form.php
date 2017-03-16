<?php
	/*Plugin Name:Simple Contact Form
	Plugin URI:https://example.com
	Description:This is just a simple contact form to contact with an organization
	Version: 1.0
	Author: Heena Trivedi
	Author URI:---*/
	
	function html_form_code(){
		echo "<form action='".esc_url($_SERVER['REQUEST_URI'])."' method='post'>";
		echo "<p>Your Name(required):<br/>";
		echo "<input type='text' name='nm' pattern='[a-zA-Z ]+' value='".(isset($_POST['nm'])?esc_attr($_POST['nm']):'')."' size=40/>";
		echo "</p>";
		echo "<p>Your Email(required):<br/>";
		echo "<input type='email' name='email' value='".(isset($_POST['email'])?esc_attr($_POST['email']):'')."' size=40/></p>";
		echo "<p>Subject(required):<br/>";
		echo "<input type='text' name='subject'  pattern='[a-zA-Z0-9 ]+' value='".(isset($_POST['subject'])?esc_attr($_POST['subject']):'')."' size=40/></p>";
		echo "<p>Your Message(required):<br/>";
		echo "<textarea name='msg' rows=10 cols=35>".(isset($_POST['msg'])?esc_attr($_POST['msg']):'')."</textarea></p>";
		echo "<p><input type='submit' name='submit' value='Send'/></p>";
		echo "</form>";
	}
	function deliver_mail(){
		if(isset($_POST['submit']))
		{
			//sanitize form values
			$nm=sanitize_text_field($_POST['nm']);
			$email=sanitize_email($_POST['email']);
			$sub=sanitize_text_field($_POST['subject']);
			$msg=esc_textarea($_POST['msg']);
			
			//get the blog administration's email address
			$to=get_option('admin_email');
			
			$header="From: $name <$email>"."\r\n";
			// If email has been process for sending display a success msg
			if(wp_mail($to,$sub,$msg,$header)){
				echo "<div>";
				echo "<p>Thanks for contacting me, expect a response soon...</p>";
				echo "</div>";
			}
			else{
				echo "An unexpected error occurred";
			}
		}
	}
	function cf_shortcode(){
		ob_start();
		deliver_mail();
		html_form_code();
		
		return ob_get_clean();
	}
	add_shortcode('contact_form','cf_shortcode');
?>