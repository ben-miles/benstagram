<?php require "./template/header.php"; ?>

<!-- ======= SIGN UP ======= -->
<section id="signup" class="signup" style="min-height:calc(100vh - 93px - 70px);">
	<div class="container">

	<div class="section-title">
		<h2>Sign Up</h2>
		<form id="form-signup" action="/signup-logic">
			<div id="response-container"></div>
				<div class="mb-3">
					<label for="signup-email" class="form-label">Email address</label>
					<input type="email" class="form-control" id="signup-email" name="signup-email" aria-describedby="signup-email-help">
					<div id="signup-email-help" class="form-text">We'll never share your email with anyone else.</div>
				</div>
				<div class="mb-3">
					<label for="signup-password" class="form-label">Password</label>
					<input type="password" class="form-control" id="signup-password" name="signup-password">
				</div>
				<button type="submit" class="btn btn-primary" id="signup-submit">Submit</button>
			</form>
		</div>

	</div>
</section>

<?php 
$script = "signup";
require "./template/footer.php"; ?>