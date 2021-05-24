<?php

// Exit if $_POST is empty
if(empty($_POST)){
	exit;
}

// Expected POST data
$submitted_email = $_POST["signup-email"];
$submitted_password = $_POST["signup-password"];

// If submitted email already exists in DB, return error
$email_exists = DB::run("SELECT id FROM users WHERE email=?", [$submitted_email])->fetch();
if($email_exists){
	echo "|e|A user with that email address already exists.";
	exit;
}

// Salt and hash the submitted password
$salted_hashed_password = password_hash($submitted_password, PASSWORD_DEFAULT);

// Store to DB
$insert = DB::prepare("INSERT INTO users (email, password) VALUES (:email, :password);");
$insert->bindParam(':email', $submitted_email);
$insert->bindParam(':password', $salted_hashed_password);
$insert->execute();
$new_user_id = DB::lastInsertId();

// Return status message
if(!$new_user_id){
	echo "|e|New user insert failed.";
	exit;
}
echo "|s|New user created.";
