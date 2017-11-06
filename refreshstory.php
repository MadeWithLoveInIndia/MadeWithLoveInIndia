<?php
	include "database.php";
	include "header.php";
	$storyID = $_GET["id"];
	$startupOwner = DB::queryFirstRow("SELECT owner, slug FROM startups WHERE id=%s", $storyID);
	if ($startupOwner["owner"] == $_SESSION["user"]["id"] || $_SESSION["user"]["is_su"] == "1") {
		unlink("assets/uploads/cached/screenshots/" . $startupOwner["slug"] . ".png");
		unlink("assets/uploads/cached/logos/" . $startupOwner["slug"] . ".png");
		echo "refreshed";
	} else {
		echo "not refreshed";
	}
?>