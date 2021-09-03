<?php

// Exit if $_POST is empty
if(empty($_POST)){
	exit;
}

// Error and exit if there's no files
if(empty($_FILES)){
	echo "|danger|Error: You must include at least one file. If this is an image post with only one image, upload it using the Cover input.";
	exit;
}

// Error and exit if there's no cover
if(empty($_FILES["post-cover"])){
	echo "|danger|Error: You must include a Cover Image.";
	exit;
}

// Expected POST data
$submitted_timestamp = $_POST["post-date"] ? date('Y-m-d H:i:s', strtotime($_POST["post-date"])) : date('Y-m-d H:i:s');
$submitted_description = $_POST["post-description"];
$submitted_cover = $_FILES["post-cover"];
$submitted_files = $_FILES["post-files"];

// Reorganize the ridiculous default $_FILES array
$files = array();
$file_count = count($submitted_files['name']);
$file_keys = array_keys($submitted_files);
for ($i=0; $i<$file_count; $i++) {
	foreach ($file_keys as $key) {
		$files[$i][$key] = $submitted_files[$key][$i];
	}
}

// Process Cover
// Copy over, rename, resize
// Committ to DB (?)

// Process Media
// Video gets copied into place, then done
// Images get copied over, renamed and resized to 1080
// All files get committed to DB


// $submitted_cover = Array ( 
// 	[name] => little-red-bird-counseling_header_bird_360.png 
// 	[type] => image/png 
// 	[tmp_name] => C:\Users\bcgm3\AppData\Local\Temp\php3840.tmp 
// 	[error] => 0 
// 	[size] => 194684 
// );

// $files = Array (    
// 	[0] => Array (
// 		[name] => Little-Red-Bird-black-high-res_type-sample.gif
// 		[type] => image/gif
// 		[tmp_name] => C:\Users\bcgm3\AppData\Local\Temp\php4401.tmp
// 		[error] => 0
// 		[size] => 16035
// 	)
//     [1] => Array (
// 		[name] => Little-Red-Bird-black-low-res.png
// 		[type] => image/png
// 		[tmp_name] => C:\Users\bcgm3\AppData\Local\Temp\php4402.tmp
// 		[error] => 0
// 		[size] => 24825
// 	)
// )

// Process $files
for($i=0; $i<count($files); $i++){
	// if($i[type] == IMAGE) (the first image will always be the "cover" or "thumbnail" for the overview)
		// move_uploaded_file() (the original file)
		// resize to make thumbnails (use sizes from variables.php)
		// commit filepath & type to db:media 
		// $thumbnail = true; (update bool to show cover has been made)
	// else (processing for video)

	$filename = $files[$i]["name"];
	$filepath = "media/" . $filename;
	$filetype = $files[$i]["type"];
	// check 1080px sq dimensions -- if not, resize to 1080px sq, maybe keep original as "[filename]_original"?
	$source = imagecreatefromjpeg($filepath);
	list($width, $height) = getimagesize($filepath);
	
	// $getimagesize($filepath) = Array (
	// 	[0] => 720
	// 	[1] => 720
	// 	[2] => 2
	// 	[3] => width="720" height="720"
	// 	[bits] => 8
	// 	[channels] => 3
	// 	[mime] => image/jpeg
	// );
	
	// if video, create still from first frame -- for now, this can be done on-device
	// copy & resize to make thumbnails
	// Handle existing filenames, so we don't overwrite identically-named files
	if (move_uploaded_file($files[$i]['tmp_name'], $filepath)){ 
		echo 'Success: ' . $filename . " saved."; 
	} else { 
		echo 'Error: ' . $filename . " was not saved.";
	}
}
exit;

// Store to DB
$insert = DB::prepare("INSERT INTO posts (description) VALUES (:email, :password);");
$insert->bindParam(':email', $submitted_email);
$insert->bindParam(':password', $salted_hashed_password);
$insert->execute();
$new_user_id = DB::lastInsertId();

// Return status message
if(!$new_user_id){
	echo "|danger|Error: New user insert failed.";
	exit;
}
echo "|success|Success: New user created.";
