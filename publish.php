<?php
	require_once "database.php";
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
?>