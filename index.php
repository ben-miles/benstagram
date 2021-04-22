<?php 

require "./data/variables.php";
require "./data/credentials.php";
require "./logic/database.php";

// TODO: Lightbox for individual posts
// TODO: Lazy loading (and SQL)?
// TODO: Profile
// TODO: Update URL on click of images
// TODO: User login (see salt and hash)
// TODO: Add new post / File upload -- Start out simple, no image editing in-app, use Camera app for that. Then add ImageMagick(?) for automating thumbnails
// TODO: Interactivity? Think I want to avoid "likes" and maybe even "comments"

// Routing
$request = $_SERVER['REQUEST_URI'];
switch ($request) {
    case '' :
    case '/' :
        require "./view/portfolio.php";
        break;
    case '/about' :
        require __DIR__ . '/views/about.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}