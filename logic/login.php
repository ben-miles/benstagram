<?php

// Exit if $_POST is empty
if(empty($_POST)){
	exit;
}

// Expected POST data
$submitted_email = $_POST["login-email"];
$submitted_password = $_POST["login-password"];

// If submitted email doesn't exist in DB, return error
$user_found = DB::run("SELECT * FROM users WHERE email=?", [$submitted_email])->fetch();
if(!$user_found){
	echo "|e|No user with that email address exists.";
	exit;
}

// Verify the submitted password
$password_matches = password_verify($submitted_password, $user_found['password'] );
if(!$password_matches){
	echo "|e|Password does not match.";
	exit;
}

// Set retrieved user data in session 
$_SESSION['user_id'] = $user_found['id'];

// Return status message
echo "|s|Logged in successfully.";
