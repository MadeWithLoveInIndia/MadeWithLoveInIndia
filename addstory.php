<?php
	include "database.php";
	include "header.php";
	$storyID = $_GET["id"];
	$storyStartup = DB::queryFirstRow("SELECT startup FROM news WHERE id=%s", $storyID)["startup"];
	$startupOwner = DB::queryFirstRow("SELECT owner FROM startups WHERE id=%s", $storyStartup)["owner"];
	if ($startupOwner == $_SESSION["user"]["id"]) {
		DB::delete("news", "id=%s", $storyID);
		echo "deleted";
	} else {
		echo "not deleted";
	}
?>