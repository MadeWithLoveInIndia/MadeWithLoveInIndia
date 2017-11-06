<?php
	include "database.php";
	include "header.php";
	$recoverCode = $currentURL[4];
	if (!$recoverCode) {
		$error = "We could not find a verification code.";
	}
	$user = DB::queryFirstRow("SELECT id FROM users WHERE activationcode=%s", $recoverCode)["id"];
	if (!$user) {
		$error = "This is an invalid verification code.";
	} else {
		DB::update("users", [
			"emailverified" => 1,
			"activationcode" => NULL
		], "id=%s", $user);
		$success = "Great, your new email is verified!";
	}
	getHeader("Page", "Recover Account");
?>
<main id="content">
<div class="container pt-4 mt-4 pb-4">
	<div class="row justify-content-center">
		<div class="col-md-5">
			<h2>Verify Email</h2>
			<?php display('<div class="alert alert-danger mt-4" role="alert">%s</div>', $error); ?>
			<?php display('<div class="alert alert-success mt-4" role="alert">%s</div>', $success); ?>
		</div>
	</div>
</div>
</main>
<?php getFooter(); ?>