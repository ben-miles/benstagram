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
// echo $html;
// echo "<pre>";
// print_r($data);

require "./template/header.php";

?>

<!-- ======= Portfolio Section ======= -->

<!-- Move to CSS file -->
<style>
	.badge-meta {
		position: absolute;
		top: 10px;
		right: 20px;
		z-index: 10;
	}
</style>

<section id="portfolio" class="portfolio">
      <div class="container">

        <div class="section-title">
          <h2>Portfolio</h2>
          <p>Sit sint consectetur velit quisquam cupiditate impedit suscipit</p>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-8">
            <ul id="portfolio-flters">
              <li data-filter="*" class="filter-active">All</li>
              <li data-filter=".filter-app">App</li>
              <li data-filter=".filter-card">Card</li>
              <li data-filter=".filter-web">Web</li>
            </ul>

        <div class="row portfolio-container">

          <!-- <div class="col-lg-4 col-md-6 portfolio-item filter-app wow fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="assets/img/portfolio/portfolio-1.jpg" class="img-fluid" alt="">
                <a href="assets/img/portfolio/portfolio-1.jpg" data-gallery="portfolioGallery" class="link-preview portfolio-lightbox" title="Preview"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" class="link-details" title="More Details"><i class="bx bx-link"></i></a>
              </figure>

              <div class="portfolio-info">
                <h4><a href="portfolio-details.html">App 1</a></h4>
                <p>App</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-web wow fadeInUp" data-wow-delay="0.1s">
            <div class="portfolio-wrap">
              <figure>
                <img src="assets/img/portfolio/portfolio-2.jpg" class="img-fluid" alt="">
                <a href="assets/img/portfolio/portfolio-2.jpg" class="link-preview portfolio-lightbox" data-gallery="portfolioGallery" title="Preview"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" class="link-details" title="More Details"><i class="bx bx-link"></i></a>
              </figure>

              <div class="portfolio-info">
                <h4><a href="portfolio-details.html">Web 3</a></h4>
                <p>Web</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-app wow fadeInUp" data-wow-delay="0.2s">
            <div class="portfolio-wrap">
              <figure>
                <img src="assets/img/portfolio/portfolio-3.jpg" class="img-fluid" alt="">
                <a href="assets/img/portfolio/portfolio-3.jpg" class="link-preview portfolio-lightbox" data-gallery="portfolioGallery" title="Preview"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" class="link-details" title="More Details"><i class="bx bx-link"></i></a>
              </figure>

              <div class="portfolio-info">
                <h4><a href="portfolio-details.html">App 2</a></h4>
                <p>App</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-card wow fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="assets/img/portfolio/portfolio-4.jpg" class="img-fluid" alt="">
                <a href="assets/img/portfolio/portfolio-4.jpg" class="link-preview portfolio-lightbox" data-gallery="portfolioGallery" title="Preview"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" class="link-details" title="More Details"><i class="bx bx-link"></i></a>
              </figure>

              <div class="portfolio-info">
                <h4><a href="portfolio-details.html">Card 2</a></h4>
                <p>Card</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-web wow fadeInUp" data-wow-delay="0.1s">
            <div class="portfolio-wrap">
              <figure>
                <img src="assets/img/portfolio/portfolio-5.jpg" class="img-fluid" alt="">
                <a href="assets/img/portfolio/portfolio-5.jpg" class="link-preview portfolio-lightbox" data-gallery="portfolioGallery" title="Preview"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" class="link-details" title="More Details"><i class="bx bx-link"></i></a>
              </figure>

              <div class="portfolio-info">
                <h4><a href="portfolio-details.html">Web 2</a></h4>
                <p>Web</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-app wow fadeInUp" data-wow-delay="0.2s">
            <div class="portfolio-wrap">
              <figure>
                <img src="assets/img/portfolio/portfolio-6.jpg" class="img-fluid" alt="">
                <a href="assets/img/portfolio/portfolio-6.jpg" class="link-preview portfolio-lightbox" data-gallery="portfolioGallery" title="Preview"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" class="link-details" title="More Details"><i class="bx bx-link"></i></a>
              </figure>

              <div class="portfolio-info">
                <h4><a href="portfolio-details.html">App 3</a></h4>
                <p>App</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-card wow fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="assets/img/portfolio/portfolio-7.jpg" class="img-fluid" alt="">
                <a href="assets/img/portfolio/portfolio-7.jpg" class="link-preview portfolio-lightbox" data-gallery="portfolioGallery" title="Preview"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" class="link-details" title="More Details"><i class="bx bx-link"></i></a>
              </figure>

              <div class="portfolio-info">
                <h4><a href="portfolio-details.html">Card 1</a></h4>
                <p>Card</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-card wow fadeInUp" data-wow-delay="0.1s">
            <div class="portfolio-wrap">
              <figure>
                <img src="assets/img/portfolio/portfolio-8.jpg" class="img-fluid" alt="">
                <a href="assets/img/portfolio/portfolio-8.jpg" class="link-preview portfolio-lightbox" data-gallery="portfolioGallery" title="Preview"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" class="link-details" title="More Details"><i class="bx bx-link"></i></a>
              </figure>

              <div class="portfolio-info">
                <h4><a href="portfolio-details.html">Card 3</a></h4>
                <p>Card</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-web wow fadeInUp" data-wow-delay="0.2s">
            <div class="portfolio-wrap">
              <figure>
                <img src="assets/img/portfolio/portfolio-9.jpg" class="img-fluid" alt="">
                <a href="assets/img/portfolio/portfolio-9.jpg" class="link-preview portfolio-lightbox" data-gallery="portfolioGallery" title="Preview"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" class="link-details" title="More Details"><i class="bx bx-link"></i></a>
              </figure>

              <div class="portfolio-info">
                <h4><a href="portfolio-details.html">Web 1</a></h4>
                <p>Web</p>
              </div>
            </div>
          </div> -->

		  <?php echo $html; ?>

        </div>
		</div>
        </div>

      </div>
    </section><!-- End Portfolio Section -->

<?php require "./template/footer.php"; ?>