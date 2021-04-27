<?php

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
				<img srcset=\"{$path}\" sizes=\"{$size}\" class=\"img-fluid\" alt=\"\" />
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
}

require "./template/header.php";

?>

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