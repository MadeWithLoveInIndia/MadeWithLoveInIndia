<?php
	header("Content-type: application/json");
	include "../database.php";
	if (isset($_GET["q"])) {
		$qry = DB::query("SELECT id, name, shortbio, city, email FROM users WHERE name LIKE %ss", unurlify($_GET["q"]));
	} else {
		$qry = DB::query("SELECT id, name, shortbio, city, email FROM users");
	}
	for ($i = 0; $i < sizeof($qry); $i++) {
		$qry[$i]["icon"] = avatarUrl($qry[$i]["email"]);
	}
	echo json_encode($qry);
?>