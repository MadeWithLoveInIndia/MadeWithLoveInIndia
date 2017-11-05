<?php
	require_once "database.php";
	DB::insert("startups", [
		"slug" => urlify($_POST["startupname"]),
		"name" => $_POST["startupname"],
		"url" => $_POST["url"],
		"tagline" => $_POST["subtitle"],
		"about" => $_POST["description"],
		"city" => explode(",", $_POST["city"])[0],
		"industry" => $_POST["industry"],
		"email" => $_POST["email"],
		"tag1" => $_POST["technology"]
	]);
	$_SESSION["user"]["justPublished"] = urlify($_POST["startupname"]);
	header("Location: /startup/" . urlify($_POST["startupname"]));
?>