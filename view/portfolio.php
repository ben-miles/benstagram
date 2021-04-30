<?php

// Retrieve user data
$user = DB::run("SELECT * FROM users")->fetchAll();
$user_bio = $user[0]["bio"];
$user_name = $user[0]["name"];
$user_photo = $root . "/media/" . $user[0]["photo"] . ".jpg";
$user_username = $user[0]["username"];

// Retrieve all media
$media = DB::run("SELECT * FROM media")->fetchAll();

// Retrieve all posts
$posts = DB::run("SELECT * FROM posts")->fetchAll();

// Get post count
$post_count = count($posts);
// echo $post_count;

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
$i = 1;
foreach($data as $post){
	$id = $post["id"];
	$caption = $post["caption"];
	$date = $post["date"];
	$latitude = $post["latitude"];
	$longitude = $post["longitude"];
	$file = $post["media"][0]["file"];
	$type = $post["media"][0]["type"];
	// Badges
	$badge = $badge_class = $badge_svg = "";
	$multi_file = (count($post["media"]) > 1) ? true : false;
	$is_video = ($type == "mp4") ? true : false;
	if($multi_file || $is_video){
		if($multi_file){
			$badge_class = "multi";
			$badge_svg = $badge_multi;
		}
		if($is_video){
			$badge_class = "video";
			$badge_svg = $badge_video;
		}
		$badge = "<div class=\"badge-meta {$badge_class}\">{$badge_svg}</div>";
	}
	// Build img srcset
	$path = $size = "";
	foreach($image_sizes as $image_key => $image_size){
		$path .= "./media/{$file}_{$image_size}.jpg {$image_size}w";
		$size .= "(min-width: {$image_size}px)";
		if($image_key + 1 < count($image_sizes)){
			$path .=", "; 
			$size .=", ";
		}
	}
	// Build post div
	$html .= "<div class=\"post col-4 portfolio-item filter-app wow fadeInUp\" id=\"post_{$id}\">
		<div class=\"portfolio-wrap\">
			{$badge}
			<figure>
				<img srcset=\"{$path}\" sizes=\"{$size}\" class=\"img-fluid\" alt=\"{$caption}\" />
				<a href=\"./media/{$file}.{$type}\" data-gallery=\"portfolioGallery\" class=\"link-preview portfolio-lightbox\" title=\"{$caption}\">
					<i class=\"bx bx-plus\"></i>
				</a>
				<a href=\"portfolio-details.html\" class=\"link-details\" title=\"More Details\">
					<i class=\"bx bx-link\"></i>
				</a>
			</figure>
			<!--div class=\"portfolio-info\">
				<h4><a href=\"portfolio-details.html\">App 1</a></h4>
				<p>App</p>
				<p>{$caption}</p>
			</div-->
		</div>
	</div>";

	// Iterate sentinel, break at a low number to reduce initial payload
	if( $i == 18 ){
		break;
	}
	$i++;
}

require "./template/header.php";

?>
<!-- ======= Bio Section ======= -->
<section id="bio" class="bio">
	<div class="container">
		<div class="row">
			<div class="col-2">
				<img src="<?php echo $user_photo; ?>" class="img-fluid" id="profile-photo" style="border-radius: 50%;" />
			</div>
			<div class="col-10">
				<h2><?php echo $user_username; ?></h2>
				<b><?php echo $post_count; ?> posts</b>
				<h2><?php echo $user_name; ?></h2>
				<p><?php echo $user_bio; ?></p>
			</div>
		</div>
	</div>
</section>

<!-- ======= Stories Section ======= -->

<!-- ======= Portfolio Section ======= -->
<section id="portfolio" class="portfolio">
	<div class="container">

        <!--<div class="section-title">
			<h2>Portfolio</h2>
			<p>Sit sint consectetur velit quisquam cupiditate impedit suscipit</p>
        </div>-->

		<ul id="portfolio-flters">
			<li data-filter="*" class="filter-active">All</li>
			<li data-filter=".filter-app">App</li>
			<li data-filter=".filter-card">Card</li>
			<li data-filter=".filter-web">Web</li>
		</ul>
		<div class="row portfolio-container">
			<?php echo $html; ?>
		</div>

    </div>
</section><!-- End Portfolio Section -->

<?php require "./template/footer.php"; ?>