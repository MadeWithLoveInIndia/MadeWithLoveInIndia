<?php
	include "database.php";
	include "header.php";
	getHeader("Page", "Login");
?>
<main id="content">
	<div class="container pt-4 mt-4 pb-4">
		<div class="row justify-content-center">
			<div class="col-md-5">
				<h2>Login</h2>
				<form class="mt-4" method="post">
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
					</div>
					<button class="btn btn-primary" type="submit">Log in</button>
					<a class="btn btn-secondary ml-1" href="/register">Register</a>
				</form>
				<p class="mt-3">Forgot your password? <a href="/recover">Recover</a></p>
			</div>
		</div>
	</div>
</main>