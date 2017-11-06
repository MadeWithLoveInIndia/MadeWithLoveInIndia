<?php
	include "database.php";
	include "header.php";

	if (isset($_SESSION["user"]["id"])) {
		if ($_SESSION["user"]["is_su"] != "1") {
			if ($_POST["returnto"]) {
				header("Location: " . $_POST["returnto"]);
			} else {
				header("Location: /profile/" . $_SESSION["user"]["username"]);
			}
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

		if ($_SESSION["user"]["is_su"] != "1") {
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
					$number++;
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
			if (isset($_POST["shortbio"])) {
				if ($_SESSION["user"]["is_su"] == "1") {
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
						"joined" => time(),
						"shortbio" => $_POST["shortbio"],
						"link_facebook" => $_POST["link_facebook"],
						"link_website" => $_POST["link_website"],
						"link_twitter" => $_POST["link_twitter"],
						"link_linkedin" => $_POST["link_linkedin"],
						"university1" => explode(",", $_POST["university1"]),
						"course1" => $_POST["course1"],
						"university2" => explode(",", $_POST["university2"]),
						"course2" => $_POST["course2"],
						"university3" => explode(",", $_POST["university3"]),
						"course3" => $_POST["course3"],
						"show_age" => $_POST["show_age"],
						"is_su" => $_POST["is_su"],
						"f_account" => $_POST["f_account"],
						"emailverified" => $_POST["emailverified"]
					];
					DB::insert("users", $userInfo);
					$newUser = DB::queryFirstRow("SELECT * FROM users WHERE username=%s", $username);
					if ($_POST["sendVerify"] == "1") {
						$recoverCode = md5(rand());
						DB::update("users", [
							"activationcode" => $recoverCode
						], "id=%s", $newUser["id"]);
						sendAnEmail($_POST["email"], "Verification - Made with Love in India", "Hey, here's the link to reset your password on Made with Love in India: https://madewithlove.org.in/activate/" . $recoverCode);
					}
					header("Location: /profile/" . $newUser["username"]);
				} else {
					$errorMessage = "You do not have permission to do this.";
				}
			} else {
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
					<?php $defPass = mt_rand(); ?>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" value="<?php echo $_SESSION["user"]["is_su"] == "1" ? $defPass : ""; ?>" required>
					</div>
					<div class="form-group">
						<label for="password2">Confirm Password</label>
						<input type="password" class="form-control" name="password2" id="password2" placeholder="Re-enter your password" value="<?php echo $_SESSION["user"]["is_su"] == "1" ? $defPass : ""; ?>" required>
					</div>
					<?php if ($_SESSION["user"]["is_su"] == "1") { ?>
						<table class="table">
							<thead>
								<tr>
									<th>Property</th>
									<th>Value</th>
								</tr>
							</thead>
							<tbody>
								<tr> 
									<td>Short Bio</td>
									<td><input type="text" placeholder="Enter one-line bio" name="shortbio" id="shortbio" class="form-control"></td>
								</tr>
								<tr>
									<td>Website</td>
									<td><input type="text" placeholder="Link to website" name="link_website" id="link_website" class="form-control"></td>
								</tr>
								<tr>
									<td>Facebook</td>
									<td><input type="text" placeholder="Facebook username" name="link_facebook" id="link_facebook" class="form-control"></td>
								</tr>
								<tr>
									<td>Twitter</td>
									<td><input type="text" placeholder="Twitter username without @" name="link_twitter" id="link_twitter" class="form-control"></td>
								</tr>
								<tr> 
									<td>Linkedin</td>
									<td><input type="text" placeholder="LinkedIn username" name="link_linkedin" id="link_linkedin" class="form-control"></td>
								</tr>
								<tr>
									<td>University</td>
									<td><input type="text" placeholder="Name of university" name="university1" id="university1" class="form-control schoolAutoComplete"></td>
								</tr>
								<tr>
									<td>Course</td>
									<td><input type="text" placeholder="Degree, Specialization" name="course1" id="course1" class="form-control"></td>
								</tr>
								<tr>
									<td>University</td>
									<td><input type="text" placeholder="Name of university" name="university2" id="university2" class="form-control schoolAutoComplete"></td>
								</tr>
								<tr>
									<td>Course</td>
									<td><input type="text" placeholder="Degree, Specialization" name="course2" id="course2" class="form-control"></td>
								</tr>
								<tr>
									<td>University</td> 
									<td><input type="text" placeholder="Name of university" name="university3" id="university3" class="form-control schoolAutoComplete"></td>
								</tr>
								<tr> 
									<td>Course</td>
									<td><input type="text" placeholder="Degree, Specialization" name="course3" id="course3" class="form-control"></td>
								</tr>
								<tr>
									<td>Age?</td>
									<td>
										<select id="show_age" name="show_age" class="form-control">
											<option value="0">Don&rsquo;t show age or birthday on profile</option>
											<option value="1" selected>Only show age on profile, not birthday</option>
											<option value="2">Show birthday and age on profile</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>SUDO</td>
									<td>
										<select name="is_su" id="is_su" class="form-control">
											<option value="0" selected>Not a superuser</option>
											<option value="1">Superuser</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Fake?</td>
									<td>
										<select name="f_account" id="f_account" class="form-control">
											<option value="0" selected>Not a fake account</option>
											<option value="1">Fake account</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Verified?</td>
									<td>
										<select name="emailverified" id="emailverified" class="form-control">
											<option value="0" selected>Community account</option>
											<option value="1">Verified account</option>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<select name="sendVerify" id="sendVerify" class="form-control">
											<option value="0" selected>Don't sent verification email</option>
											<option value="1">Send verification email</option>
										</select>
									</td>
								</tr>
							</tbody>
						</table>
					<?php } else { ?>
					<div class="g-recaptcha" data-sitekey="6LdExBIUAAAAAPB6nhoIar2LDZQDEpJb2eDCopUu"></div>
					<?php } ?>
					<button class="btn btn-primary mt-3" type="submit">Register</button>
				</form>
				<p class="mt-3">Already have an account? <a href="/login">Login</a></p>
			</div>
		</div>
	</div>
</main>
<?php getFooter(); ?>