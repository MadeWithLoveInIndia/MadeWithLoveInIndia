<?php
	include "database.php";
	include "header.php";
	if (isset($_POST["email"])) {
		$account = DB::queryFirstRow("SELECT id FROM users WHERE email=%s", $_POST["email"])["id"];
		if (!$account) {
			$error = "We could not find an account with this email.";
		} else {
			$recoverCode = md5(rand());
			DB::update("users", [
				"passwordresetcode" => $recoverCode
			], "id=%s", $account);
			sendAnEmail($_POST["email"], "Password Reset - Made with Love in India", "Hey, here's the link to reset your password on Made with Love in India: https://madewithlove.org.in/reset/" . $recoverCode);
			$success = "Great, we&rsquo;ve sent you an email to recover your password.";
		}
	}
	getHeader("Page", "Recover Password");
?>
<main id="content">
	<div class="container pt-4 mt-4 pb-4">
		<div class="row justify-content-center">
			<div class="col-md-5">
				<h2>Recover Password</h2>
				<?php display('<div class="alert alert-danger mt-4" role="alert">%s</div>', $error); ?>
				<?php display('<div class="alert alert-success mt-4" role="alert">%s</div>', $success); ?>
				<form class="mt-4" method="post">
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
					</div>
					<button class="btn btn-primary" type="submit">Send Recover Link</button>
				</form>
			</div>
		</div>
	</div>
</main>
<?php getFooter(); ?>