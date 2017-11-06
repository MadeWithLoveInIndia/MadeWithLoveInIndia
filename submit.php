<?php
	require_once "database.php";
	include "header.php";
	if (!isset($_SESSION["user"])) {
		header("Location: /login?returnto=$_SERVER[REQUEST_URI]&message=Please+log+in+or+create+an+account+to+submit+your+startup.");
	}
	getHeader("Page", "Submit Startup");
?>
<main id="content">
	<div class="container pt-4 mt-4 pb-4">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<h2>Submit Startup</h2>
				<?php if (isset($_GET["error"])) { ?>
				<div class="alert alert-warning alert-danger mt-4 fade show" role="alert">
					<strong>Error: </strong> <?php switch($_GET["error"]) {
						case "missinginfo":
							echo "Please fill in all details.";
							break;
						case "captcha":
							echo "Invalid captcha, sorry robots.";
							break;
						default:
							echo "There seems to be an error with this form.";
							break;
					} ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<?php } ?>
				<form class="mt-4" method="post" action="/preview">
					<div class="form-group">
						<label for="startupname">Startup Name</label>
						<input type="text" class="form-control" name="startupname" id="startupname" placeholder="Enter the name of the startup" required>
					</div>
					<div class="form-group">
						<label for="subtitle">Subtitle</label>
						<input type="text" class="form-control" name="subtitle" id="subtitle" placeholder="Enter a short subtitle, eg. Uber for cats" required>
					</div>
					<div class="form-group">
						<label for="url">Website URL</label>
						<input type="text" class="form-control" name="url" id="url" placeholder="Enter the website URL" required>
					</div>
					<div class="form-group">
						<label for="email">Official Email</label>
						<input type="email" class="form-control" name="email" id="email" placeholder="Enter the startup email" required>
					</div>
					<div class="form-group">
						<label for="description">Description</label>
						<textarea class="form-control" name="description" id="description" placeholder="Enter the description for the startup." rows="4"></textarea>
					</div>
					<div class="form-group">
						<label for="city">City</label>
						<input type="text" class="form-control cityAutoComplete" name="city" id="city" placeholder="Enter your city name" autocomplete="new-password">
					</div>
					<div class="form-group">
						<label for="industry">Industry</label>
						<input type="text" class="form-control" name="industry" id="industry" placeholder="Enter an industry" autocomplete="new-password">
					</div>
					<div class="form-group">
						<label for="technology">Technology</label>
						<input type="text" class="form-control" name="technology" id="technology" placeholder="Enter a technology" autocomplete="new-password">
					</div>
					<?php if ($_SESSION["user"]["is_su"] == "1") { ?>
						
					<?php } else { ?>
					<div class="g-recaptcha" data-sitekey="6LdExBIUAAAAAPB6nhoIar2LDZQDEpJb2eDCopUu"></div>
					<?php } ?>
					<p class="mt-3">By submitting this form, you agree with our <a target="_blank" href="/terms">terms of use</a> and <a  target="_blank"href="/privacy">privacy policy</a>. You also confirm that you are an owner of this startup, use the Made with Love in India badge, and adhere to its <a target="_blank" href="/responsibilities">responsibilities</a>.</p>
					<button class="btn btn-primary mt-3" type="submit">Continue<i class="ion ion-md-arrow-forward ml-2"></i></button>
				</form>
			</div>
		</div>
	</div>
</main>
<script src="https://cdn.ckeditor.com/4.7.3/basic/ckeditor.js"></script>
<script> CKEDITOR.replace("description"); </script>
<?php getFooter(); ?>