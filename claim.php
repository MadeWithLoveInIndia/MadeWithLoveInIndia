<?php
	include "database.php";
	include "header.php";
	if (!isset($_SESSION["user"])) {
		header("Location: /login?returnto=$_SERVER[REQUEST_URI]&message=You+have+to+log+in+to+claim+this+page.");
	}
	$startupInfo = DB::queryFirstRow("SELECT * FROM startups WHERE slug=%s", $currentURL[4]);
	$code = hash("sha256", $_SESSION["user"]["username"] . $startupInfo["slug"]);
	if (isset($_POST["verifymethod"])) {
		if ($_POST["verifymethod"] == "html") {
			// Test HTML method
			$url = $startupInfo["url"] . "/mwlii_verify.html";
			if (file_get_contents($url) != $code) {
				$error = "We were unable to verify that you have uploaded the file. Try again or use a different method.";
			} else {
				DB::update("startups", [
					"owner" => $_SESSION["user"]["id"],
					"badge_verified" => 1
				], "slug=%s", $startupInfo["slug"]);
				header("Location: /startup/" . $startupInfo["slug"]);
			}
		}
	}
	getHeader("Page", "Claim " . $startupInfo["name"]);
?>
<main id="content">
		<div class="container pt-4 mt-4 pb-4">
			<div class="row justify-content-center">
				<div class="col-md-5">
					<h2 class="mb-4"><?php echo "Claim " . $startupInfo["name"]; ?></h2>
					<?php display('<div class="alert alert-danger mt-4" role="alert">%s</div>', $error); ?>
					<h3 class="bigger">Option 1: File Upload (Recommended)</h3>
					<p>To verify that you own <?php echo $startupInfo["name"]; ?>, you have the download this file and upload it to the root directory of your website:</p>
					<p><button onclick='download("<?php echo $code; ?>", "mwlii_verify.html", "text/html");' class="btn btn-secondary"><i class="ion ion-md-download mr-2"></i>Download File</button></p>
					<p>After uploading the file, you can go to this webpage and check if it works: <a href="<?php echo $startupInfo["url"]; ?>/mwlii_verify.html" target="_blank"><?php echo $startupInfo["url"]; ?>/mwlii_verify.html</a></p>
					<p>If you see a code on the page, click on the button below to verify, and you can make changes to the page:</p>
					<form class="mt-3" method="post">
						<input type="hidden" name="verifymethod" value="html">
						<p><button class="btn btn-primary" type="submit">Verify Ownership</button></p>
					</form>
					<!-- <hr class="mt-5 mb-5">
					<h3 class="bigger">Option 2: Verify Through Email</h3>
					<p>If you cannot the file upload method, you can verify your @<?php echo websiteify($startupInfo["url"]); ?> email to confirm that you own <?php echo $startupInfo["name"]; ?>.</p>
					<form class="mt-4" method="post">
						<div class="form-group">
							<label for="email">Email</label>
							<div class="input-group">
								<input type="text" class="form-control" placeholder="Enter your email">
								<span class="input-group-addon" id="basic-addon2">@<?php echo websiteify($startupInfo["url"]); ?></span>
							</div>
						</div>
						<input type="hidden" name="verifymethod" value="email">
						<button class="btn btn-primary" type="submit">Verify Ownership</button>
					</form> -->
				</div>
			</div>
		</div>
	</main>
<?php getFooter(); ?>