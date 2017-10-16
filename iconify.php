<?php

	include "database.php";

	$_GET["q"] = str_replace(".jpg", "", str_replace("_", " ", $_GET["q"]));
	$_GET["q"] = substr($_GET["q"], 33);

	if (file_exists("assets/uploads/cached/logos/" . urlencode($_GET["q"]) . ".png")) {
		header("Location: " . "/assets/uploads/cached/logos/" . urlencode($_GET["q"]) . ".png");
	} else {
		$website = addhttp(DB::queryFirstRow("SELECT url FROM startups WHERE slug=%s", $_GET["q"])["url"]);
		header("Content-Type: image/jpeg");
		$ip = file_get_contents("https://icons.better-idea.org/icon?url=" . urlencode($website) . "&size=80..120..200");
		echo $ip;
		file_put_contents("assets/uploads/cached/logos/" . urlencode($_GET["q"]) . ".png", $ip);
	}

?>