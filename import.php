<?php

require_once "./data/credentials.php";
require_once "./logic/database.php";

// Source
$json_file = file_get_contents("./data/posts_1.json");
$raw_posts = json_decode($json_file, true);

// Destination
$computed_posts = [];

// Processing
foreach($raw_posts as $index => $post_data){

	/*** DATE ***/
	if(array_key_exists("creation_timestamp", $post_data)){
		$date = $post_data["creation_timestamp"];
		// echo date("F jS, Y",$date) . "<br>";
	} else if(array_key_exists("creation_timestamp", $post_data["media"][0])){
		$date = $post_data["media"][0]["creation_timestamp"];
		// echo date("F jS, Y",$date) . "<br>";
	}
	$computed_posts[$date]["date"] = $date;

	/*** CAPTION ***/
	if(array_key_exists("title", $post_data)){
		$caption = $post_data["title"];
		// echo $caption . "<br>";
	} else if(array_key_exists("title", $post_data["media"][0])){
		$caption = $post_data["media"][0]["title"];
		// echo $caption . "<br>";
	}
	$computed_posts[$date]["caption"] = $caption;
	
	/*** LOCATION ***/
	$latitude = $longitude = NULL;
	if(array_key_exists("media_metadata", $post_data["media"][0])){
		if(array_key_exists("photo_metadata", $post_data["media"][0]["media_metadata"])){
			if(array_key_exists("latitude", $post_data["media"][0]["media_metadata"]["photo_metadata"]["exif_data"][0])){
				$latitude = $post_data["media"][0]["media_metadata"]["photo_metadata"]["exif_data"][0]["latitude"];
				$longitude = $post_data["media"][0]["media_metadata"]["photo_metadata"]["exif_data"][0]["longitude"];
				// echo "lat: " . $latitude . ", lon: " . $longitude . ".<br>";
			}
		} else if(array_key_exists("video_metadata", $post_data["media"][0]["media_metadata"])){
			if(array_key_exists("latitude", $post_data["media"][0]["media_metadata"]["video_metadata"]["exif_data"][0])){
				$latitude = $post_data["media"][0]["media_metadata"]["video_metadata"]["exif_data"][0]["latitude"];
				$longitude = $post_data["media"][0]["media_metadata"]["video_metadata"]["exif_data"][0]["longitude"];
				// echo "lat: " . $latitude . ", lon: " . $longitude . ".<br>";
			}
		}
	}
	$computed_posts[$date]["latitude"] = $latitude;
	$computed_posts[$date]["longitude"] = $longitude;
	
	/*** MEDIA ***/
	$i = 0;
	foreach($post_data["media"] as $media){
		$file = substr($media["uri"], 19);
		$type = substr($file, -3);
		// echo "type: " . $type . ", file: " . $file . "<br>";
		$computed_posts[$date]["media"][$i]["type"] = $type; 
		$computed_posts[$date]["media"][$i]["file"] = $file;
		$i++; 
	}
	// echo "<br>";

}

// Sort the array of posts by their keys (date, asc)
ksort($computed_posts);

// Re-key the array of posts to use sequential indexes (starting at 1)
$computed_posts = array_values($computed_posts);

// Copy every "media" item into a new array for a separate sql insert statement
$computed_media = [];
foreach($computed_posts as $computed_post_index => $computed_post_data){
	$post_id = $computed_post_index +1;
	foreach($computed_post_data["media"] as $computed_media_item){
		array_push($computed_media,
			[
				"post_id" => $post_id, 
				"type" => $computed_media_item["type"], 
				"file" => $computed_media_item["file"]
			]
		);
	}
	// Remove the nested "media" array from the posts array
	unset($computed_posts[$computed_post_index]["media"]);
}

// SQL Insert Posts
$stmt = DB::prepare("INSERT INTO posts (id, date, caption, latitude, longitude) VALUES (?, ?, ?, ?, ?)");
foreach($computed_posts as $insert_post_key => $insert_post_data){
    // $stmt->execute([
	// 	$insert_post_key + 1,
	// 	date('Y-m-d H:i:s', $insert_post_data["date"]),
	// 	$insert_post_data["caption"],
	// 	$insert_post_data["latitude"],
	// 	$insert_post_data["longitude"]
	// ]);
}

// SQL Insert Media
$stmt = DB::prepare("INSERT INTO media (id, post_id, type, file) VALUES (?, ?, ?, ?)");
foreach($computed_media as $insert_media_key => $insert_media_data){
    // $stmt->execute([
	// 	$insert_media_key + 1,
	// 	$insert_media_data["post_id"],
	// 	$insert_media_data["type"],
	// 	$insert_media_data["file"]
	// ]);
}

// DEBUG
// echo "<pre>";
// print_r($raw_posts);
// print_r($computed_posts);
// print_r($computed_media);