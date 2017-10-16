<?php

	$_GET["q"] = str_replace(".jpg", "", str_replace("_", " ", $_GET["q"]));
	$_GET["q"] = substr($_GET["q"], 33);

	if ($_GET["type"] == "news") {
		switch($_GET["q"]) {
			case "hindustan-times":
				$_GET["q"] .= " app icon";
				break;
			default:
				$_GET["q"] .= " square logo";
				break;
		}
	} else if ($_GET["type"] == "institute") {
		$_GET["q"] .= " square logo";
	}

	if (trim($_GET["q"]) !== "") {
		if (file_exists("assets/uploads/cached/common/" . str_replace("+", "-", strtolower(urlencode($_GET["q"]))) . ".png")) {
			header("Location: " . "/assets/uploads/cached/common/" . str_replace("+", "-", strtolower(urlencode($_GET["q"]))) . ".png");
		} else {
			header("Content-Type: image/jpeg");
			$ip = file_get_contents("https://tse2.mm.bing.net/th?q=" . urlencode($_GET["q"]) . "&w=70&h=70&c=7&rs=1&p=0&dpr=3&pid=1.7&mkt=en-IN&adlt=moderate");
			if ($ip !== "") {
				file_put_contents("assets/uploads/cached/common/" . str_replace("+", "-", strtolower(urlencode($_GET["q"]))) . ".png", $ip);
			}
			echo $ip;
		}
	}

?>