<?php
	include "database.php";
	include "header.php";
	if (isset($_POST["email"]) && isset($_POST["password"])) {
		$me = DB::queryFirstRow("SELECT * FROM users WHERE email=%s", $_POST["email"]);
		if (password_verify($_POST["password"], $me["password"])) {
			$_SESSION["user"] = $me;
			if ($_POST["returnto"]) {
				header("Location: " . $_POST["returnto"]);
			} else {
				header("Location: /profile/" . $me["username"]);
			}
		} else {
			$wrongPass = "Incorrect email or password.";
		}
	}
	getHeader("Page", "Login");
?>
<main id="content">
	<div class="container pt-4 mt-4 pb-4">
		<div class="row justify-content-center">
			<div class="col-md-5">
				<h2>Login</h2>
				<?php display('<div class="alert alert-danger mt-4" role="alert">%s</div>', $wrongPass); ?>
				<?php display('<div class="alert alert-info mt-4" role="alert">%s</div>', $_GET["message"]); ?>
				<form class="mt-4" method="post">
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
					</div>
					<input type="hidden" name="returnto" value="<?php echo $_GET["returnto"]; ?>">
					<button class="btn btn-primary" type="submit">Log in</button>
					<a class="btn btn-secondary ml-1" href="/register">Register</a>
				</form>
				<p class="mt-3">Forgot your password? <a href="/recover">Recover it now</a></p>
			</div>
		</div>
	</div>
</main>
<?php getFooter(); ?>