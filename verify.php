<?php
	include "database.php";
	include "header.php";
	if ($currentURL[4] == "user") {
		$user = DB::queryFirstRow("SELECT * FROM users WHERE username=%s", $currentURL[5]);
		if ($user["emailverified"] == 1) {
			$error = 'This profile is already claimed. <a href="/about">Get in touch</a> with us if this is your profile and we will help you verify it.';
		}
	}
	if (!$user) {
		header("HTTP/1.0 404 Not Found");
		getHeader("Page", "404 Error");
?>
<main id="content" class="pt-4">
	<div class="container text-center mt-5 mb-5 pb-5">
		<h1>404 Error</h1>
		<p>This page doesn't exist.</p>
	</div>
</main>
<?php
		getFooter();
		die();
		exit();
	}
	if (isset($_POST["email"])) {
		if ($_POST["email"] == $user["email"]) {
			$recoverCode = md5(rand());
			DB::update("users", [
				"activationcode" => $recoverCode
			], "id=%s", $user["id"]);
			sendAnEmail($_POST["email"], "Verification - Made with Love in India", "Hey, here's the link to reset your password on Made with Love in India: https://madewithlove.org.in/activate/" . $recoverCode);
			$success = "Great, we&rsquo;ve have sent you a link to verify this email.";
		} else {
			$error = "Sorry, this is not the right email. Please try again or <a href='/about'>get in touch</a> with us.";
		}
	}
	getHeader("Page", "Verify Profile");
	if ($currentURL[4] == "user") {
?>
<main id="content">
	<div class="container pt-4 mt-4 pb-4">
		<div class="row justify-content-center">
			<div class="col-md-5">
				<h2>Verify Profile</h2>
				<?php display('<div class="alert alert-danger mt-4" role="alert">%s</div>', $error); ?>
				<?php display('<div class="alert alert-success mt-4" role="alert">%s</div>', $success); ?>
				<?php if (!$error || $error == "Sorry, this is not the right email. Please try again or <a href='/about'>get in touch</a> with us.") { ?><form class="mt-4" method="post">
					<p>To verify that you are <?php echo $user["name"]; ?>, please enter your email as per our records: <strong><?php echo obfuscate_email($user["email"]); ?></strong>.</p>
					<p>If this is not your email, <a href="/about">get in touch</a> with us and we will help you verify your profile.</p>
					<div class="form-group mt-3">
						<label for="email">Email</label>
						<input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
					</div>
					<input type="hidden" name="username" value="<?php echo $currentURL[5]; ?>">
					<button class="btn btn-primary" type="submit">Send Confirmation Link</button>
					</form><?php } ?>
			</div>
		</div>
	</div>
</main>
<?php } else { ?>
	for people verifying
<?php } getFooter(); ?>