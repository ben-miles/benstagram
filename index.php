<?php 
session_start();
require "data/variables.php";
require "data/credentials.php";
require "logic/database.php";
require "logic/routing.php";

// TODOs:
// - Lightbox for individual posts
// - Lazy loading (and SQL)?
// - Update URL on click of images
// - Add new post / File upload -- Start out simple, no image editing in-app, use Camera app for that. Then add ImageMagick(?) for automating thumbnails
// - Interactivity? Think I want to avoid "likes" and maybe even "comments"
// - Add fields to Signup View
