<?php
// Routing
$request = $_SERVER["REQUEST_URI"];
switch ($request) {
    case "" :
    case "/" :
        require "view/portfolio.php";
        break;
	case "/login" :
		require "view/login.php";
		break;
	case "/login-logic" :
		require "logic/login.php";
		break;
	case "/logout" :
		require "logic/logout.php";
		break;
	case "/signup" :
		require "view/signup.php";
		break;
	case "/signup-logic" :
		require "logic/signup.php";
		break;
	case "/post" :
		require "view/post.php";
		break;
    default:
        http_response_code(404);
        require "view/404.php";
        break;
}