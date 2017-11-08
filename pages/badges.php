<?php
	include "../database.php";
	include "../header.php";
	getHeader("Badges", "Badges");
?>
<main id="content">
	<div class="container pt-4 mt-4 pb-4">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<h2>Badges</h2>
				<p>Made with Love in India awards badges to startups. They are:</p>
				<ol>
					<li><strong>Added MWLII Badge: </strong>Startups has added the Made with Love in India badge on their website or products.</li>
					<li><strong>Secure Website: </strong>Website uses TLS security and is accessible through the HTTPS protocol. This badge is automatically awarded.</li>
					<li><strong>Verified Profile: </strong>Startup profile has been claimed and has an owner who can edit it.</li>
					<li><strong>Newsworthy Startup: </strong>Startup has been featured by the press on multiple occasions.</li>
					<li><strong>Featured Startup: </strong>Startup has been featured on the home page of Made with Love in India.</li>
					<li><strong>Unicorn Startup: </strong>Startup has a billion-dollar reputation.</li>
				</ol>
				<p>Please get in touch with us if you think your startup deserves a badge.</p>
			</div>
		</div>
	</div>
</main>
<?php getFooter(); ?>