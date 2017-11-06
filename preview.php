<?php
	require_once "database.php";
	include "header.php";
	$url = "https://www.google.com/recaptcha/api/siteverify";
	if ($_SESSION["user"]["is_su"] != "1") {
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
			header("Location: /submit?error=captcha");
		}
	}
	if (!($_POST["startupname"] && $_POST["subtitle"] && $_POST["city"] && $_POST["url"] && $_POST["email"])) {
		header("Location: /submit?error=missinginfo");
	} else {
		$slug = urlify($_POST["startupname"]);
		$exists = 1;
		$number = 1;
		while ($exists == 1) {
			if (DB::queryFirstRow("SELECT slug FROM startups WHERE slug=%s", $slug)) {
				if ($number != 0) {
					$slug .= "-" . $number;
					$number++;
				}
			} else {
				$exists = 0;
			}
		}
		DB::insert("startups", [
			"slug" => $slug,
			"name" => $_POST["startupname"],
			"url" => $_POST["url"],
			"tagline" => $_POST["subtitle"],
			"about" => $_POST["description"],
			"city" => explode(",", $_POST["city"])[0],
			"industry" => $_POST["industry"],
			"email" => $_POST["email"],
			"tag1" => json_encode([$_POST["technology"]])
		]);
		$_SESSION["user"]["justPublished"] = $slug;
		header("Location: /startup/" . $slug);
	}
	getHeader("Page", "Submit Startup");
?>
<main id="content">
	<div class="container pt-4 mt-4 pb-4">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<h2>Submit Startup</h2>
				<form class="mt-4" method="post" action="/publish">
					<input type="hidden" name="startupname" value="<?php echo $_POST["startupname"]; ?>">
					<input type="hidden" name="subtitle" value="<?php echo $_POST["subtitle"]; ?>">
					<input type="hidden" name="url" value="<?php echo $_POST["url"]; ?>">
					<input type="hidden" name="email" value="<?php echo $_POST["email"]; ?>">
					<input type="hidden" name="description" value="<?php echo $_POST["description"]; ?>">
					<input type="hidden" name="city" value="<?php echo $_POST["city"]; ?>">
					<input type="hidden" name="industry" value="<?php echo $_POST["industry"]; ?>">
					<input type="hidden" name="technology" value="<?php echo $_POST["technology"]; ?>">
					<button class="btn btn-primary mt-2" type="submit">Publish<i class="ion ion-md-arrow-forward ml-2"></i></button>
				</form>
			</div>
		</div>
	</div>
</main>
<?php getFooter(); ?>