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
			if (trim(file_get_contents($url)) != $code) {
				$error = "We were unable to verify that you have uploaded the file. Try again or use a different method.";
			} else {
				DB::update("startups", [
					"owner" => $_SESSION["user"]["id"],
					"badge_verified" => 1
				], "slug=%s", $startupInfo["slug"]);
				header("Location: /startup/" . $startupInfo["slug"]);
			}
		} else if ($_POST["verifymethod"] == "txtrecord") {
			$verified = 0;
			$records = dns_get_record(websiteify($startupInfo["url"]));
			foreach ($records as $record) {
				if ($record["type"] == "TXT") {
					if ($record["txt"] == "mwlii=" . $code) {
						$verified++;
					}
				}
			}
			if ($verified == 0) {
				$error = "We were unable to verify that you have added a TXT record. It could take up to 24 hours, so please try again in a while or use a different method.";
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
					<?php display('<div class="alert alert-danger mt-4 mb-5" role="alert">%s</div>', $error); ?>
					<!-- a -->
					<h3 class="bigger">Option 1: File Upload (Recommended)</h3>
					<p>To verify that you own <?php echo $startupInfo["name"]; ?>, you have the download this file and upload it to the root directory of your website:</p>
					<p><button onclick='download("<?php echo $code; ?>", "mwlii_verify.html", "text/html");' class="btn btn-secondary"><i class="ion ion-md-download mr-2"></i>Download File</button></p>
					<p>After uploading the file, you can go to this webpage and check if it works: <a href="<?php echo $startupInfo["url"]; ?>/mwlii_verify.html" target="_blank"><?php echo $startupInfo["url"]; ?>/mwlii_verify.html</a></p>
					<p>If you see a code on the page, click on the button below to verify, and you can make changes to the page:</p>
					<form class="mt-3" method="post">
						<input type="hidden" name="verifymethod" value="html">
						<p><button class="btn btn-primary" type="submit">Verify Ownership</button></p>
					</form>
					<hr class="mt-5 mb-5">
					<h3 class="bigger">Option 2: Add TXT Record</h3>
					<p>You have to add a TXT record to your domain&rsquo;s DNS system with the following value:</p>
					<input data-placement="top" title="Copied!" data-clipboard-target="#domainCode" id="domainCode" class="form-control mb-4" onclick="this.setSelectionRange(0, this.value.length)" readonly="" type="text" value="mwlii=<?php echo $code; ?>">
					<ol>
						<li>Sign in to your domain host account.</li>
						<li>Go to your domain&rsquo;s DNS records. The page might be called something like DNS Management, Name Server Management, Control Panel, or Advanced Settings.</li>
						<li>Select the option to add a new record.</li>
						<li>For the record type, select <strong>TXT</strong>.</li>
						<li>In the <strong>Name/Host/Alias</strong> field, enter @ or leave it blank. Your other DNS records may indicate which you should use.</li>
						<li>In the Value/Answer/Destination field, paste the verification record from above.</li>
						<li>In the <strong>Time to Live (TTL)</strong> field, enter <strong>86400</strong> or leave the default.</li>
						<li>Save the record.</li>
					</ol>
					<p>You can learn how to add a TXT record on <a href="https://support.google.com/a/answer/183895?hl=en" target="_blank">Google&rsquo;s page</a> about it.</p>
					<p>Once you&rsquo;ve done it, click on the button below to verify. Note that for some hosts, it can take up to 24 hours before your DNS is updated:</p>
					<form class="mt-3" method="post">
						<input type="hidden" name="verifymethod" value="txtrecord">
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
					<hr class="mt-5 mb-5">
					<h3 class="bigger">Option 2: Manual Email Verification</h3>
					<p>If you cannot the file upload method, send us  an email to <a href="mailto:hello@madewithlove.org.in">hello@madewithlove.org.in</a> with your Made with Love in India profile username, startup name, and we will manually verify you.</p>
					<p>It can take up to 48 hours to verify your profile.</p>
				</div>
			</div>
		</div>
	</main>
<?php getFooter(); ?>