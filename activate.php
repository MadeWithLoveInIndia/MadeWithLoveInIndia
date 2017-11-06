<?php
	include "database.php";
	include "header.php";
	$recoverCode = $currentURL[4];
	if (!$recoverCode) {
		$error = "We could not find a recovery code.";
	}
	$user = DB::queryFirstRow("SELECT id FROM users WHERE activationcode=%s", $recoverCode)["id"];
	if (!$user) {
		$error = "This is an invalid recovery code.";
	} else {
		if (isset($_POST["password"])) {
			$url = "https://www.google.com/recaptcha/api/siteverify";
			$options = array(
				"http" => array(
					"header"  => "Content-type: application/x-www-form-urlencoded\r\n",
					"method"  => "POST",
					"content" => http_build_query([
						"secret" => "6LdExBIUAAAAAKJf_kG2yAMqvMdhehrU_nazjUMm", // It's okay for you to see this :)
						"response" => $_POST["g-recaptcha-response"]
					])
				)
			);
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			if ($result === FALSE || json_decode($result)->success == false) {
				$error = "Invalid captcha. Please try again.";
			} else {
				DB::update("users", [
					"emailverified" => 1,
					"password" => password_hash($_POST["password"], PASSWORD_DEFAULT),
					"activationcode" => NULL
				], "id=%s", $user);
				$_SESSION["user"] = DB::queryFirstRow("SELECT * FROM users WHERE id=%s", $user);
				header("Location: /login/?message=Your+profile+was+verified.+You+may+log+in+now.");
			}
		}
	}
	getHeader("Page", "Recover Account");
?>
<main id="content">
<div class="container pt-4 mt-4 pb-4">
	<div class="row justify-content-center">
		<div class="col-md-5">
			<h2>Activate Account</h2>
			<?php display('<div class="alert alert-danger mt-4" role="alert">%s</div>', $error); ?>
			<?php display('<div class="alert alert-success mt-4" role="alert">%s</div>', $success); ?>
			<?php if (!$error || $error == "Invalid captcha. Please try again.") { ?><form class="mt-4" method="post">
				<div class="form-group">
					<label for="password">New Password</label>
					<input type="password" class="form-control" name="password" id="password" placeholder="Enter your new password" required>
				</div>
				<input type="hidden" name="recovercode" value="<?php echo $recoverCode; ?>">
				<div class="g-recaptcha" data-sitekey="6LdExBIUAAAAAPB6nhoIar2LDZQDEpJb2eDCopUu"></div>
				<button class="btn btn-primary mt-3" type="submit">Activate Account</button>
			</form><?php } ?>
		</div>
	</div>
</div>
</main>
<?php getFooter(); ?>