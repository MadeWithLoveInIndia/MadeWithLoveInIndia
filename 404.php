<?php
	include "header.php";
	header("HTTP/1.0 404 Not Found");
	getHeader("404", "Error 404");
?>
<main id="content" class="pt-4">
	<div class="container text-center mt-5 mb-5 pb-5">
		<h1>404 Error</h1>
		<p>This page doesn't exist.</p>
	</div>
</main>
<?php
	getFooter();
?>