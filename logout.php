<?php
	include "database.php";
	session_unset();
	session_destroy();
	if (isset($_GET["returnto"])) {
		header("Location: " . $_GET["returnto"]);
	} else {
		header("Location: /");
	}
?>