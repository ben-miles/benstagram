<?php 

// Restrict access to signed-in users
if(!isset($_SESSION["user_id"])){
	// Redirect to home
	header("Location: $root");
	exit;
}

require "./template/header.php"; ?>

<!-- ======= POST ======= -->
<section id="post" class="post" style="min-height:calc(100vh - 93px - 70px);">
	<div class="container">
		<div class="section-title">
			<h2>New Post</h2>
			<form id="form-post" class="ajax-form" action="/post-logic" enctype="multipart/form-data" method="post">
				<div id="response-container"></div>
				<div class="mb-3">
					<label for="post-date" class="form-label">Date</label>
					<input type="datetime-local" class="form-control" id="post-date" name="post-date" aria-describedby="post-date-help">
					<div id="post-date-help" class="form-text">Leave blank for current date and time.</div>
				</div>
				<div class="mb-3">
					<label for="post-description" class="form-label">Description</label>
					<textarea class="form-control" id="post-description" name="post-description" rows="3"></textarea>
				</div>
				<div class="mb-3">
					<label for="post-cover" class="form-label">Cover</label>
					<input class="form-control" type="file" id="post-cover" name="post-cover" aria-describedby="post-cover-help">
					<div id="post-cover-help" class="form-text">For <b>image posts</b>, this should be your first image. For <b>video posts</b>, this should be a still frame.</div>
				</div>
				<div class="mb-3">
					<label for="post-files" class="form-label">Files</label>
					<input class="form-control" type="file" id="post-files" name="post-files[]" multiple>
				</div>
				<button type="submit" class="btn btn-primary" id="post-submit-btn">Submit</button>
			</form>
		</div>
	</div>
</section>

<?php require "./template/footer.php"; ?>