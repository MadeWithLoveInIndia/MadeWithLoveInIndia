<?php
	include "database.php";
	include "header.php";

	if (isset($_SESSION["user"]["id"])) {
		if ($_POST["returnto"]) {
			header("Location: " . $_POST["returnto"]);
		} else {
			header("Location: /profile/" . $_SESSION["user"]["username"]);
		}
	}

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
		
		$errorMessage = null;

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
			$errorMessage = "Incorrect captcha.";
		}

		$name = $_POST["name"];
		$cityName = explode(",", $_POST["cityName"])[0];
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

		if (!($name && $cityName && $gender && $bd_date && $bd_month && $bd_year && $email && $password && $password2)) {
			$errorMessage = "Please enter all the fields.";
		}

		if ($password != $password2) {
			$errorMessage = "Your passwords do not match.";
		}

		if (DB::queryFirstRow("SELECT id FROM users WHERE email=%s", $email)["id"]) {
			$errorMessage = "There already exists an account with this email.";
		}

		if ($errorMessage == null) {
			$userInfo = [
				"name" => $name,
				"username" => $username,
				"password" => password_hash($password, PASSWORD_DEFAULT),
				"city" => explode(",", $cityName),
				"gender" => $gender,
				"email" => $email,
				"bd_day" => $bd_date,
				"bd_month" => $bd_month,
				"bd_year" => $bd_year,
				"lastlogin" => time(),
				"joined" => time()
			];
			DB::insert("users", $userInfo);
			$_SESSION["user"] = DB::queryFirstRow("SELECT * FROM users WHERE username=%s", $username);
			$recoverCode = md5(rand());
			DB::update("users", [
				"activationcode" => $recoverCode
			], "id=%s", $_SESSION["user"]["id"]);
			sendAnEmail($_POST["email"], "Verification - Made with Love in India", "Hey, here's the link to reset your password on Made with Love in India: https://madewithlove.org.in/activate/" . $recoverCode);
			header("Location: /profile/" . $userInfo["username"]);
		}

	}

	getHeader("Register", "Register");
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
							<option<?php echo $gender == "M" ? " selected" : ""; ?> value="M">Male</option>
							<option<?php echo $gender == "F" ? " selected" : ""; ?> value="F">Female</option>
							<option<?php echo $gender == "O" ? " selected" : ""; ?> value="O">Other</option>
						</select>
					</div>
					<div class="form-group">
						<label for="birthday">Birthday</label>
						<div class="row">
							<div class="col">
								<select value="<?php echo $bd_date; ?>" name="bd-day" class="form-control">
									<?php for ($i = 1; $i < 32; $i++) { ?>
									<option<?php echo $bd_date == $i ? " selected" : ""; ?>><?php echo $i; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-5">
								<select value="<?php echo $bd_month; ?>" name="bd-month" class="form-control">
									<?php foreach (["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"] as $monthN => $month) { ?>
										<option<?php echo $bd_month == $monthN + 1 ? " selected" : ""; ?> value="<?php echo ($monthN + 1); ?>"><?php echo $month; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col">
								<select value="<?php echo $bd_year; ?>" name="bd-year" class="form-control">
									<?php for ($i = (2017 - 102); $i < (2017 - 13); $i++) { ?>
									<option<?php echo $bd_year == $i ? " selected" : ""; ?>><?php echo $i; ?></option>
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
					<div class="g-recaptcha" data-sitekey="6LdExBIUAAAAAPB6nhoIar2LDZQDEpJb2eDCopUu"></div>
					<button class="btn btn-primary mt-3" type="submit">Register</button>
				</form>
				<p class="mt-3">Already have an account? <a href="/login">Login</a></p>
			</div>
		</div>
	</div>
</main>
<?php getFooter(); ?>