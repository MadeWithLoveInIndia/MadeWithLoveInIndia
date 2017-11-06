<?php
	include "database.php";
	include "header.php";
	$error = null;
	if (!isset($_POST["to"])) {
		$error = "There is no user in your email.";
	} else {
		$user = DB::queryFirstRow("SELECT * FROM users WHERE id=%s", $_POST["to"]);
		if (!$user["id"]) {
			$error = "This is no such user you can message.";
		}
	}
	if (!isset($_POST["subject"])) {
		$error = "There is no subject in your email.";
	}
	if (!isset($_POST["message"])) {
		$error = "There is no message in your email.";
	}
	if (!$error) {
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
			sendAnEmail($user["email"], $_POST["subject"], $_POST["message"] .= "\r\n\r\nThis message was sent to you by " . $_SESSION["user"]["name"] . " on your Made with Love in India profile: https://madewithlove.org.in/profile/" . $user["username"], $_SESSION["user"]["name"], $_SESSION["user"]["email"]);
			$success = "Your message to " . $user["name"] . " has been sent.";
		}
	}
	getHeader("Page", "Message");
?>
<main id="content">
	<div class="container pt-4 mt-4 pb-4">
		<div class="row justify-content-center">
			<div class="col-md-5">
				<h2>Message <?php echo explode(" ", $user["name"])[0]; ?></h2>
				<?php display('<div class="alert alert-danger mt-4" role="alert"><p>%s</p><div><a href="/profile/%s/message" class="btn btn-danger mt-2">Try Again</a></div></div>', $error, $user["username"]); ?>
				<?php display('<div class="alert alert-success mt-4" role="alert"><p>%s</p><div><a href="/profile/%s" class="btn btn-success mt-2">Back to Profile</a></div></div>', $success, $user["username"]); ?>
			</div>
		</div>
	</div>
</main>
<?php getFooter(); ?>