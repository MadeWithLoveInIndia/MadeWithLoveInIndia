<?php
	include "database.php";
	include "header.php";
	getHeader("Page", "Register");
?>
<main id="content">
	<div class="container pt-4 mt-4 pb-4">
		<div class="row justify-content-center">
			<div class="col-md-5">
				<h2>Register</h2>
				<form class="mt-4" method="post">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" name="name" id="name" placeholder="Enter your full name" required>
					</div>
					<div class="form-group">
						<label for="city">Location</label>
						<input class="cityAutoComplete form-control" type="text" name="cityName" id="cityName" placeholder="Enter your city name" required>
					</div>
					<hr>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
					</div>
					<div class="form-group">
						<label for="password2">Confirm Password</label>
						<input type="password" class="form-control" name="password2" id="password2" placeholder="Re-enter your password" required>
					</div>
					<button class="btn btn-primary" type="submit">Register</button>
				</form>
				<p class="mt-3">Already have an account? <a href="/login">Login</a></p>
			</div>
		</div>
	</div>
</main>
<?php getFooter(); ?>