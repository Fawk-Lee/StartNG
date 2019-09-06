<?php
/*
This is a php code that sends content of my contact form directly to my mailbox.
*/
$webmaster_email = "fawklee7@gmail.com";

/*
This bit sets the URLs of the supporting pages.
*/
$ContactForm = "ContactForm.html";
$error_page = "error_message.html";
$thankyou_page = "thank_you.html";

/*
This next bit loads the form field data into variables.
*/
$email_address = $_REQUEST['email_address'] ;
$message = $_REQUEST['Message'] ;
$Name = $_REQUEST['Name'] ;
$Title = $_REQUEST['Title'] ;
$Phone = $_REQUEST['Phone'] ;
$msg = 
"Name: " . $Name . "\r\n" . 
"Email: " . $email_address . "\r\n" .
"Phone: " . $Phone . "\r\n" . 
"Message: " . $Message ;
"Title: " . $Title ;


/*
The following function checks for email injection.
Specifically, it checks for carriage returns - typically used by spammers to inject a CC list.
*/
function isInjected($str) {
	$injections = array('(\n+)',
	'(\r+)',
	'(\t+)',
	'(%0A+)',
	'(%0D+)',
	'(%08+)',
	'(%09+)'
	);
	$inject = join('|', $injections);
	$inject = "/$inject/i";
	if(preg_match($inject,$str)) {
		return true;
	}
	else {
		return false;
	}
}

// If the user tries to access this script directly, redirect them to the feedback form,
if (!isset($_REQUEST['email_address'])) {
header( "Location: $ContactForm" );
}

// If the form fields are empty, redirect to the error page.
elseif (empty($Name) || empty($email_address)) {
header( "Location: $error_page" );
}

/* 
If email injection is detected, redirect to the error page.
If you add a form field, you should add it here.
*/
elseif ( isInjected($email_address) || isInjected($Name)  || isInjected($Message) ) {
header( "Location: $error_page" );
}

// If we passed all previous tests, send the email then redirect to the thank you page.
else {

	mail( "$webmaster_email", "Contact Form Results", $msg );

	header( "Location: $thankyou_page" );
}
?>