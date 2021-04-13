<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="description" content="Instagram Clone">
  <meta name="author" content="SitePoint">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Instagram Clone</title>


  <!--link rel="stylesheet" href="css/styles.css?v=1.0"-->

</head>

<body>

<?php 
require_once './data/variables.php';
require_once './data/credentials.php';
require_once './logic/database.php';


// TODO: Update filename field in db (remove ".ext")
// TODO: Frontend for displaying all photos
// TODO: Lightbox for individual posts
// TODO: Lazy loading (and SQL)?
// TODO: Profile
// TODO: Update URL on click of images
// TODO: User login (see salt and hash)
// TODO: Add new post
// TODO: Interactivity?

// Retrieve all media
$media = DB::run("SELECT * FROM media")->fetchAll();

// Retrieve all posts
$posts = DB::run("SELECT * FROM posts")->fetchAll();

// Reverse order (newest first)
krsort($posts);

// Merge the posts and media arrays
$data = [];
foreach($posts as $k => $v){
	$data[$k] = $v;
	//check for post_id in media, assign to
	$post_id = $v["id"];
	foreach($media as $media_item){
		if($media_item["post_id"] === $post_id){
			$data[$k]["media"][] = $media_item;
		}
	}
}

// Output Posts as HTML
$html = "";
foreach($data as $post){
	$id = $post["id"];
	$caption = $post["caption"];
	$date = $post["date"];
	$latitude = $post["latitude"];
	$longitude = $post["longitude"];
	$file = $post["media"][0]["file"];
	$type = $post["media"][0]["type"];
	// Build img srcset
	$path = $size = "";
	foreach($image_sizes as $image_key => $image_size){
		$path .= "./media/{$file}_{$image_size}.{$type} {$image_size}w";
		$size .= "(min-width: {$image_size}px)";
		if($image_key + 1 < count($image_sizes)){
			$path .=", "; 
			$size .=", ";
		}
	}
	// Build post div
	$html .= "<div class=\"post\" id=\"post_{$id}\">
		<!--p>{$caption}</p-->
		<img srcset=\"{$path}\" sizes=\"{$size}\" src=\"\" />
	</div>";
}

echo $html;
// echo "<pre>";
// print_r($data);

?>

<!--script src="js/scripts.js"></script-->
</body>
</html>
