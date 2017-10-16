<?php

	include "database.php";

	$_GET["q"] = str_replace(".jpg", "", str_replace("_", " ", $_GET["q"]));
	$_GET["q"] = substr($_GET["q"], 33);

	if (file_exists("assets/uploads/cached/screenshots/" . urlencode($_GET["q"]) . ".png")) {
		header("Location: " . "/assets/uploads/cached/screenshots/" . urlencode($_GET["q"]) . ".png");
	} else {
		$website = addhttp(DB::queryFirstRow("SELECT url FROM startups WHERE slug=%s", $_GET["q"])["url"]);
		header("Content-Type: image/jpeg");
		$ip = file_get_contents("https://api.thumbnail.ws/api/abafd003582ed20b0351d0ac1996336332b8ee775486/thumbnail/get?url=" . urlencode($website) . "&width=720");
		echo $ip;
		if ($ip !== "") {
			file_put_contents("assets/uploads/cached/screenshots/" . urlencode($_GET["q"]) . ".png", $ip);
		}
	}

?>