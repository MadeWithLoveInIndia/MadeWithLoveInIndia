<?php
	require_once "database.php";
	include "header.php";
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
		header("Location: /submit?error=captcha");
	}
	if (!($_POST["startupname"] && $_POST["subtitle"] && $_POST["url"] && $_POST["email"] && $_POST["description"])) {
		header("Location: /submit?error=missinginfo");
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
					<div class="form-group">
						<label for="city">City</label>
						<select id="city" name="city" class="form-control">
							<?php $cities = DB::query("SELECT name, id FROM cities");
							foreach ($cities as $city) { ?>
							<option><?php echo $city["name"]; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label for="industry">Industry</label>
						<select id="industry" name="industry" class="form-control">
							<?php $cities = DB::query("SELECT name, id FROM industries");
							foreach ($cities as $city) { ?>
							<option><?php echo $city["name"]; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label for="technology">Technology</label>
						<select id="technology" name="technology" class="form-control">
							<?php $cities = DB::query("SELECT name, id FROM technologies");
							foreach ($cities as $city) { ?>
							<option><?php echo $city["name"]; ?></option>
							<?php } ?>
						</select>
					</div>
					<button class="btn btn-primary mt-2" type="submit">Publish<i class="ion ion-md-arrow-forward ml-2"></i></button>
				</form>
			</div>
		</div>
	</div>
</main>
<?php getFooter(); ?>