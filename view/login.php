<?php require "./template/header.php"; ?>

<!-- ======= LOG IN ======= -->
<section id="login" class="login" style="min-height:calc(100vh - 93px - 70px);">
	<div class="container">
		<div class="section-title">
			<h2>Log In</h2>
			<form id="form-login" action="/login-logic">
				<div id="response-container"></div>
				<div class="mb-3">
					<label for="login-email" class="form-label">Email address</label>
					<input type="email" class="form-control" id="login-email" name="login-email" aria-describedby="login-email-help">
					<div id="login-email-help" class="form-text">We'll never share your email with anyone else.</div>
				</div>
				<div class="mb-3">
					<label for="login-password" class="form-label">Password</label>
					<input type="password" class="form-control" id="login-password" name="login-password">
				</div>
				<button type="submit" class="btn btn-primary" id="login-submit">Submit</button>
			</form>
		</div>
	</div>
</section>

<?php 
$script = "login";
require "./template/footer.php"; ?>