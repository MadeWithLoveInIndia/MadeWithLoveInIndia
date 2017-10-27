<?php
	include "database.php";
	include "header.php";

	$name = null;
	$cityName = null;
	$gender = null;
	$bd_date = null;
	$bd_month = null;
	$bd_year = null;
	$email = null;
	$password = null;
	$password2 = null;

	if (isset($_POST["name"])) {

		$name = $_POST["name"];
		$cityName = $_POST["cityName"];
		$gender = $_POST["gender"];
		$bd_date = $_POST["bd-day"];
		$bd_month = $_POST["bd-month"];
		$bd_year = $_POST["bd-year"];
		$email = $_POST["email"];
		$password = $_POST["password"];
		$password2 = $_POST["password2"];

		$username = slugify($name);

		$exists = 1;
		$number = 1;
		while ($exists == 1) {
			if (DB::queryFirstRow("SELECT username FROM users WHERE username=%s", $username)) {
				if ($number != 0) {
					$username .= "-" . $number;
				}
			} else {
				$exists = 0;
			}
		}

		$errorMessage = null;

		if (!($name && $cityName && $gender && $bd_date && $bd_month && $bd_year && $email && $password && $password2)) {
			$errorMessage = "Please enter all the fields.";
		}

		if ($password != $password2) {
			$errorMessage = "Your passwords do not match.";
		}

		if ($errorMessage == null) {
			$userInfo = [
				"name" => $name,
				"username" => $username,
				"password" => password_hash($password, PASSWORD_DEFAULT),
				"city" => explode(",", $cityName),
				"gender" => $gender,
				"email" => $email,
				"bd_day" => $bd_day,
				"bd_month" => $bd_month,
				"bd_year" => $bd_year,
				"lastlogin" => time(),
				"joined" => time()
			];
			DB::insert("users", $userInfo);
			$_SESSION["user"] = $userInfo;
			header("Location: /profile/" . $userInfo["username"]);
		}

	}

	getHeader("Page", "Register");
?>
<main id="content">
	<div class="container pt-4 mt-4 pb-4">
		<div class="row justify-content-center">
			<div class="col-md-5">
				<h2>Register</h2>
				<?php display('<div class="alert alert-danger mt-4" role="alert">%s</div>', $errorMessage); ?>
				<form class="mt-3" method="post">
					<div class="form-group">
						<label for="name">Name</label>
						<input value="<?php echo $name; ?>" type="text" class="form-control" name="name" id="name" placeholder="Enter your full name" required>
					</div>
					<div class="form-group">
						<label for="city">Location</label>
						<input value="<?php echo $cityName; ?>" class="cityAutoComplete form-control" type="text" name="cityName" id="cityName" placeholder="Enter your city name" required>
					</div>
					<div class="form-group">
						<label for="gender">Gender</label>
						<select value="<?php echo $gender; ?>" name="gender" class="form-control">
							<option>Male</option>
							<option>Female</option>
							<option>Other</option>
						</select>
					</div>
					<div class="form-group">
						<label for="birthday">Birthday</label>
						<div class="row">
							<div class="col">
								<select value="<?php echo $bd_day; ?>" name="bd-day" class="form-control">
									<?php for ($i = 1; $i < 32; $i++) { ?>
									<option><?php echo $i; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-5">
								<select value="<?php echo $bd_month; ?>" name="bd-month" class="form-control">
									<option>January</option>
									<option>February</option>
									<option>March</option>
									<option>April</option>
									<option>May</option>
									<option>June</option>
									<option>July</option>
									<option>August</option>
									<option>September</option>
									<option>October</option>
									<option>November</option>
									<option>December</option>
								</select>
							</div>
							<div class="col">
								<select value="<?php echo $bd_year; ?>" name="bd-year" class="form-control">
									<?php for ($i = (2017 - 102); $i < (2017 - 13); $i++) { ?>
									<option><?php echo $i; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<label for="email">Email</label>
						<input value="<?php echo $email; ?>" type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
					</div>
					<div class="form-group">
						<label for="password2">Confirm Password</label>
						<input type="password" class="form-control" name="password2" id="password2" placeholder="Re-enter your password" required>
					</div>
					<button class="btn btn-primary" type="submit">Register</button>
				</form>
				<p class="mt-3">Already have an account? <a href="/login">Login</a></p>
			</div>
		</div>
	</div>
</main>
<?php getFooter(); ?>