		</main><!-- End #main -->

		<!-- ======= Footer ======= -->
		<footer id="footer">
			<div class="container d-md-flex py-4">
				<div class="me-md-auto text-center text-md-start">
					<div class="copyright">
						&copy; <?php echo date("Y", strtotime("now")); ?> <a href="<?php echo $root; ?>/">Ben Miles</a>. All Rights Reserved. 
					</div>
					<div class="credits">
						Site by <a href="https://benmiles.com/">Ben Miles</a>.
					</div>
				</div>
			</div>
		</footer><!-- End Footer -->

		<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

		<!-- Vendor JS Files -->
		<script src="<?php echo $root; ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="<?php echo $root; ?>/assets/vendor/glightbox/js/glightbox.min.js"></script>
		<script src="<?php echo $root; ?>/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

		<!-- Template Main JS File -->
		<script src="<?php echo $root; ?>/assets/js/main.js"></script>

		<!-- View-Specific JS File(s) -->
		<?php if(isset($script)) echo "<script src=\"{$root}/assets/js/{$script}.js\"></script>"; ?>

	</body>

</html>
