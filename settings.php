<?php
	include "database.php";
	include "header.php";
	$profile = DB::queryFirstRow("SELECT * FROM users WHERE id=%s", $_SESSION["user"]["id"]);
	if (!isset($_SESSION["user"])) {
		header("Location: /login?returnto=$_SERVER[REQUEST_URI]&message=You+have+to+log+in+to+edit+your+profile.");
	}
	if (isset($_POST["name"])) {
		if ($_POST["course1A"] == "Select Program") {
			$_POST["course1"] = null;
		} else {
			$_POST["course1"] = $_POST["course1A"] . ($_POST["course1B"] ? ", " . $_POST["course1B"] : "");
		}
		if ($_POST["course2A"] == "Select Program") {
			$_POST["course2"] = null;
		} else {
			$_POST["course2"] = $_POST["course2A"] . ($_POST["course2B"] ? ", " . $_POST["course2B"] : "");
		}
		if ($_POST["course3A"] == "Select Program") {
			$_POST["course3"] = null;
		} else {
			$_POST["course3"] = $_POST["course3A"] . ($_POST["course3B"] ? ", " . $_POST["course3B"] : "");
		}
		DB::update("users", [
			"name" => $_POST["name"],
			"username" => $_POST["username"],
			"email" => $_POST["email"],
			"shortbio" => $_POST["shortbio"],
			"city" => explode(",", $_POST["city"])[0],
			"gender" => $_POST["gender"],
			"bd_day" => $_POST["bd_day"],
			"bd_month" => $_POST["bd_month"],
			"bd_year" => $_POST["bd_year"],
			"show_age" => $_POST["show_age"],
			"link_website" => $_POST["link_website"],
			"link_facebook" => $_POST["link_facebook"],
			"link_twitter" => $_POST["link_twitter"],
			"link_linkedin" => $_POST["link_linkedin"],
			"university1" => explode(",", $_POST["university1"])[0],
			"course1" => $_POST["course1"],
			"university2" => explode(",", $_POST["university2"])[0],
			"course2" => $_POST["course2"],
			"university3" => explode(",", $_POST["university3"])[0],
			"course3" => $_POST["course3"]
		], "id=%s", $_SESSION["user"]["id"]);
		$profile = DB::queryFirstRow("SELECT * FROM users WHERE id=%s", $_SESSION["user"]["id"]);
		$_SESSION["user"] = $profile;
	}
	getHeader("Page", "Settings");
?>
<main id="content">
	<div class="container pt-4 mt-4 pb-4">
		<div class="row justify-content-center">
				<form method="post" class="col-md-8">
						<h2>Edit Your Profile</h2>
						<?php display('<span style="display: none">%s</span><div class="alert alert-info mt-4" role="alert">Your changes have been published. <a href="/profile/%s">View your profile.</a></div>', isset($_POST["name"]), $profile["username"]); ?>
						<?php display('<div class="alert alert-danger mt-4" role="alert">%s</div>', $error); ?>
		
		
						<div id="accordion" role="tablist" class="mt-4">
							<div class="card">
								<div class="card-header" role="tab" id="headingOne">
									<h5 class="mb-0">
										<a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
											Basic Info
										</a>
									</h5>
								</div>
		
								<div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
									<div class="card-body">
										<div class="form-group">
											<label for="name">Name</label>
											<input type="name" class="form-control" name="name" id="name" placeholder="Enter your full name" value="<?php echo $profile["name"]; ?>" required>
										</div>
										<div class="form-group">
											<label for="username">Username</label>
											<div class="input-group">
												<span class="input-group-addon" id="basic-addon3">madewithlove.org.in/profile/</span>
												<input type="username" class="form-control" name="username" id="username" placeholder="Enter your startup username" value="<?php echo $profile["username"]; ?>" aria-describedby="usernameHelp" required>
											</div>
											<small id="usernameHelp" class="form-text text-muted">For SEO purposes, we don&rsquo;t recommend changing this username.</small>
										</div>
										<div class="form-group">
											<label for="email">Email</label>
											<input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" value="<?php echo $profile["email"]; ?>" required>
										</div>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header" role="tab" id="headingTwo">
									<h5 class="mb-0">
										<a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
											Profile
										</a>
									</h5>
								</div>
								<div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
									<div class="card-body">
										<div class="form-group">
											<label for="shortbio">Short Bio</label>
											<input type="text" class="form-control" name="shortbio" id="shortbio" placeholder="Enter a short shortbio, eg. Uber for cats" value="<?php echo $profile["shortbio"]; ?>">
										</div>
										<div class="form-group">
											<label for="city">Location</label>
											<input type="text" class="form-control cityAutoComplete" name="city" id="city" placeholder="Enter your city name" autocomplete="new-password" value="<?php echo $profile["city"]; ?>">
										</div>
										<div class="form-group">
											<label for="gender">Gender</label>
											<select value="<?php echo $profile["gender"]; ?>" name="gender" class="form-control">
												<option<?php echo $profile["gender"] == "F" ? " selected" : ""; ?> value="F">Female</option>
												<option<?php echo $profile["gender"] == "M" ? " selected" : ""; ?> value="M">Male</option>
												<option<?php echo $profile["gender"] == "O" ? " selected" : ""; ?> value="O">Other</option>
											</select>
										</div>
										<div class="form-group">
											<label for="birthday">Birthday</label>
											<div class="row">
												<div class="col">
													<select value="<?php echo $profile["bd_day"]; ?>" name="bd_day" class="form-control">
														<?php for ($i = 1; $i < 32; $i++) { ?>
														<option<?php echo $profile["bd_day"] == $i ? " selected" : ""; ?>><?php echo $i; ?></option>
														<?php } ?>
													</select>
												</div>
												<div class="col-md-5">
													<select value="<?php echo $profile["bd_month"]; ?>" name="bd_month" class="form-control">
														<?php foreach (["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"] as $monthN => $month) { ?>
															<option<?php echo $profile["bd_month"] == $monthN + 1 ? " selected" : ""; ?> value="<?php echo $monthN + 1; ?>"><?php echo $month; ?></option>
														<?php } ?>
													</select>
												</div>
												<div class="col">
													<select value="<?php echo $profile["bd_year"]; ?>" name="bd_year" class="form-control">
														<?php for ($i = (2017 - 102); $i < (2017 - 13); $i++) { ?>
														<option<?php echo $profile["bd_year"] == $i ? " selected" : ""; ?>><?php echo $i; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="show_age">Age/Birthday Visibility</label>
											<select value="<?php echo $profile["show_age"]; ?>" name="show_age" class="form-control">
												<option<?php echo $profile["show_age"] == "0" ? " selected" : ""; ?> value="0">Don&rsquo;t show age or birthday on profile</option>
												<option<?php echo $profile["show_age"] == "1" ? " selected" : ""; ?> value="1">Only show age on profile, not birthday</option>
												<option<?php echo $profile["show_age"] == "2" ? " selected" : ""; ?> value="2">Show birthday and age on profile</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header" role="tab" id="headingThree">
									<h5 class="mb-0">
										<a class="collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
											Social Media &amp; Links
										</a>
									</h5>
								</div>
								<div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
									<div class="card-body">
										<div class="form-group">
											<label for="link_website">Personal Website</label>
											<input type="url" class="form-control" name="link_website" id="link_website" placeholder="Enter link to your website" value="<?php echo $profile["link_website"]; ?>">
										</div>
										<div class="form-group">
											<label for="link_facebook">Facebook Profile</label>
											<div class="input-group">
												<span class="input-group-addon" id="basic-addon3"><i class="ion ion-logo-facebook mr-2"></i>facebook.com/</span>
												<input type="text" class="form-control" name="link_facebook" id="link_facebook" placeholder="Enter Facebook profile username" value="<?php echo $profile["link_facebook"]; ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="link_twitter">Twitter Profile</label>
											<div class="input-group">
												<span class="input-group-addon" id="basic-addon3"><i class="ion ion-logo-twitter mr-2"></i>twitter.com/@</span>
												<input type="text" class="form-control" name="link_twitter" id="link_twitter" placeholder="Enter Twitter profile username" value="<?php echo $profile["link_twitter"]; ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="link_linkedin">LinkedIn Profile</label>
											<div class="input-group">
												<span class="input-group-addon" id="basic-addon3"><i class="ion ion-logo-linkedin mr-2"></i>linkedin.com/in/</span>
												<input type="text" class="form-control" name="link_linkedin" id="link_linkedin" placeholder="Enter LinkedIn ID" value="<?php echo $profile["link_linkedin"]; ?>">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header" role="tab" id="headingFour">
									<h5 class="mb-0">
										<a class="collapsed" data-toggle="collapse" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
											Education
										</a>
									</h5>
								</div>
								<div id="collapseFour" class="collapse" role="tabpanel" aria-labelledby="headingFour" data-parent="#accordion">
									<div class="card-body">
										<h4 class="h5">Academic Degree</h4>
										<div class="form-group">
											<label for="university1">Institute</label>
											<input type="text" class="form-control schoolAutoComplete" name="university1" id="university1" placeholder="Enter the name of the institute" value="<?php echo $profile["university1"]; ?>">
										</div>
										<div class="form-group">
											<label for="course1A">Program</label>
											<select class="form-control" id="course1A" name="course1A" value="<?php echo explode("," ,$profile["course1"])[0]; ?>">
												<option>Select Program</option>
												<?php foreach (["Bachelor of Arts", "Bachelor of Business Administration", "Bachelor of Science", "Bachelor of Engineering", "Bachelor of Technology", "Bachelor of Medicine", "Bachelor of Surgery", "Bachelor of Dental Surgery", "Bachelor of Computer Application", "Bachelor of Laws", "Bachelor of Education", "Bachelor of Nursing", "Bachelor's Degree", "Master of Arts", "Master of Business Administration", "Master of Science", "Master of Engineering", "Master of Technology", "Master of Medicine", "Master of Surgery", "Master of Dental Surgery", "Master of Computer Application", "Master of Laws", "Master of Education", "Master of Nursing", "Master's Degree", "Doctor of Laws", "Doctor of Theology", "Doctor of Divinity", "Doctor of Philosophy", "Doctor of Sciences", "Doctor of Education", "Doctor of Letters", "Doctor of Education", "Doctor of Psychology", "Doctor of Engineering", "Doctor of Letters", "Doctor's Degree", Diploma, "Certification", "High School", "Junior School", "Middle School"] as $degree) { ?>
													<option<?php echo explode(",", $profile["course1"])[0] == $degree ? " selected" : ""; ?>><?php echo $degree; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="form-group">
											<label for="course1B">Specialization</label>
											<input type="text" class="form-control schoolAutoComplete" name="course1B" id="course1B" placeholder="Enter the name of the institute" value="<?php echo explode(", " ,$profile["course1"])[1]; ?>">
										</div>
										<hr class="mt-4 mb-4">
										<h4 class="h5">Academic Degree</h4>
										<div class="form-group">
											<label for="university2">Institute</label>
											<input type="text" class="form-control schoolAutoComplete" name="university2" id="university2" placeholder="Enter the name of the institute" value="<?php echo $profile["university2"]; ?>">
										</div>
										<div class="form-group">
											<label for="course2A">Program</label>
											<select class="form-control" id="course2A" name="course2A" value="<?php echo explode("," ,$profile["course1"])[0]; ?>">
												<option>Select Program</option>
												<?php foreach (["Bachelor of Arts", "Bachelor of Business Administration", "Bachelor of Science", "Bachelor of Engineering", "Bachelor of Technology", "Bachelor of Medicine", "Bachelor of Surgery", "Bachelor of Dental Surgery", "Bachelor of Computer Application", "Bachelor of Laws", "Bachelor of Education", "Bachelor of Nursing", "Bachelor's Degree", "Master of Arts", "Master of Business Administration", "Master of Science", "Master of Engineering", "Master of Technology", "Master of Medicine", "Master of Surgery", "Master of Dental Surgery", "Master of Computer Application", "Master of Laws", "Master of Education", "Master of Nursing", "Master's Degree", "Doctor of Laws", "Doctor of Theology", "Doctor of Divinity", "Doctor of Philosophy", "Doctor of Sciences", "Doctor of Education", "Doctor of Letters", "Doctor of Education", "Doctor of Psychology", "Doctor of Engineering", "Doctor of Letters", "Doctor's Degree", Diploma, "Certification", "High School", "Junior School", "Middle School"] as $degree) { ?>
													<option<?php echo explode(",", $profile["course2"])[0] == $degree ? " selected" : ""; ?>><?php echo $degree; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="form-group">
											<label for="course2B">Specialization</label>
											<input type="text" class="form-control schoolAutoComplete" name="course2B" id="course2B" placeholder="Enter the name of the institute" value="<?php echo explode(", " ,$profile["course2"])[1]; ?>">
										</div>
										<hr class="mt-4 mb-4">
										<h4 class="h5">Academic Degree</h4>
										<div class="form-group">
											<label for="university3">Institute</label>
											<input type="text" class="form-control schoolAutoComplete" name="university3" id="university3" placeholder="Enter the name of the institute" value="<?php echo $profile["university3"]; ?>">
										</div>
										<div class="form-group">
											<label for="course3A">Program</label>
											<select class="form-control" id="course3A" name="course3A" value="<?php echo explode("," ,$profile["course3"])[0]; ?>">
												<option>Select Program</option>
												<?php foreach (["Bachelor of Arts", "Bachelor of Business Administration", "Bachelor of Science", "Bachelor of Engineering", "Bachelor of Technology", "Bachelor of Medicine", "Bachelor of Surgery", "Bachelor of Dental Surgery", "Bachelor of Computer Application", "Bachelor of Laws", "Bachelor of Education", "Bachelor of Nursing", "Bachelor's Degree", "Master of Arts", "Master of Business Administration", "Master of Science", "Master of Engineering", "Master of Technology", "Master of Medicine", "Master of Surgery", "Master of Dental Surgery", "Master of Computer Application", "Master of Laws", "Master of Education", "Master of Nursing", "Master's Degree", "Doctor of Laws", "Doctor of Theology", "Doctor of Divinity", "Doctor of Philosophy", "Doctor of Sciences", "Doctor of Education", "Doctor of Letters", "Doctor of Education", "Doctor of Psychology", "Doctor of Engineering", "Doctor of Letters", "Doctor's Degree", Diploma, "Certification", "High School", "Junior School", "Middle School"] as $degree) { ?>
													<option<?php echo explode(",", $profile["course3"])[0] == $degree ? " selected" : ""; ?>><?php echo $degree; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="form-group">
											<label for="course3B">Specialization</label>
											<input type="text" class="form-control schoolAutoComplete" name="course3B" id="course3B" placeholder="Enter the name of the institute" value="<?php echo explode(", " ,$profile["course3"])[1]; ?>">
										</div>
									</div>
								</div>
							</div>
							<button class="btn btn-primary mt-3" type="submit">Publish Changes</button>
							<a class="btn btn-secondary mt-3 ml-2" href="/profile/<?php echo $profile["username"]; ?>">Cancel &amp; Go Back</a>
						</form>
		</div>
	</div>
</main>
<?php getFooter(); ?>