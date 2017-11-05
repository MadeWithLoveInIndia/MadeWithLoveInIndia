<?php
	include "database.php";
	include "header.php";
	$startup = DB::queryFirstRow("SELECT * FROM startups WHERE slug=%s", $currentURL[4]);
	if (!isset($_SESSION["user"])) {
		header("Location: /login?returnto=$_SERVER[REQUEST_URI]&message=You+have+to+log+in+to+edit+this+profile.");
	}
	if ($startup["owner"] != $_SESSION["user"]["id"]) {
		header("Location: /404");
	}
	if (isset($_POST["name"])) {
		if (isset($_POST["deleteStartup"])) {
			DB::delete("startups", "id=%s", $startup["id"]);
			header("Location: /profile/" . $_SESSION["user"]["username"]);
		}
		DB::update("startups", [
			"name" => $_POST["name"],
			"tagline" => $_POST["subtitle"],
			"slug" => $_POST["slug"],
			"email" => $_POST["email"],
			"founded_day" => $_POST["founded_day"],
			"founded_month" => $_POST["founded_month"],
			"founded_year" => $_POST["founded_year"],
			"city" => explode(",", $_POST["city"])[0],
			"about" => $_POST["description"],
			"employees" => $_POST["employees"],
			"link_blog" => $_POST["link_blog"],
			"link_facebook" => $_POST["link_facebook"],
			"link_twitter" => $_POST["link_twitter"],
			"link_linkedin" => $_POST["link_linkedin"],
			"link_youtube" => $_POST["link_youtube"],
			"link_googlemaps" => $_POST["link_googlemaps"],
			"link_googleplus" => $_POST["link_googleplus"],
			"link_angellist" => $_POST["link_angellist"],
			"link_f6s" => $_POST["link_f6s"],
			"founder1" => $_POST["founder1"],
			"founder2" => $_POST["founder2"],
			"founder3" => $_POST["founder3"],
			"founder4" => $_POST["founder4"],
			"founder5" => $_POST["founder5"]
		], "id=%s", $startup["id"]);
		DB::insert("log", [
			"datetime" => time(),
			"who" => $_SESSION["user"]["id"],
			"who_ip" => $_SERVER["REMOTE_ADDR"],
			"what" => "update_startup_profile",
			"what_info" => $startup["id"]
		]);
		$error = null;
		if ($_POST["publication_name"] != "") {
			if ($_POST["publication_name"] == "" || $_POST["story_date"] == "" || $_POST["story_month"] == "" || $_POST["story_year"] == "" || $_POST["publication_link"] == "") {
				$error = "Please enter all info about the news story.";
			} else {
				DB::insert("news", [
					"startup" => $startup["id"],
					"datetime" => strtotime($_POST["story_date"] . " " . $_POST["story_month"] . " " . $_POST["story_year"]),
					"title" => $_POST["story_title"],
					"link" => $_POST["publication_link"],
					"publication" => $_POST["publication_name"],
					"addedon" => time(),
					"addedby" => $_SESSION["user"]["id"],
				]);
			}
		}
		$startup = DB::queryFirstRow("SELECT * FROM startups WHERE slug=%s", $_POST["slug"]);
		if ($startup["slug"] != $currentURL[4]) {
			header("Location: /edit/" . $startup["slug"]);
		}
	}
	getHeader("Page", "Edit " . $startup["name"]);
?>
<main id="content">
	<div class="container pt-4 mt-4 pb-4">
		<div class="row justify-content-center">
			<form method="post" class="col-md-8">
				<h2><?php echo "Edit " . $startup["name"]; ?></h2>
				<?php display('<span style="display: none">%s</span><div class="alert alert-info mt-4" role="alert">Your changes have been published. <a href="/startup/%s">View startup page.</a></div>', isset($_POST["name"]), $startup["slug"]); ?>
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
									<label for="name">Startup Name</label>
									<input type="name" class="form-control" name="name" id="name" placeholder="Enter your startup name" value="<?php echo $startup["name"]; ?>" required>
								</div>
								<div class="form-group">
									<label for="subtitle">Subtitle</label>
									<input type="text" class="form-control" name="subtitle" id="subtitle" placeholder="Enter a short subtitle, eg. Uber for cats" value="<?php echo $startup["tagline"]; ?>" required>
								</div>
								<div class="form-group">
									<label for="slug">Startup Username</label>
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon3">madewithlove.org.in/startup/</span>
										<input type="slug" class="form-control" name="slug" id="slug" placeholder="Enter your startup slug" value="<?php echo $startup["slug"]; ?>" aria-describedby="slugHelp" required>
									</div>
									<small id="slugHelp" class="form-text text-muted">For SEO purposes, we don&rsquo;t recommend changing this username.</small>
								</div>
								<div class="form-group">
									<label for="url">Startup URL</label>
									<input type="url" class="form-control" name="url" id="url" placeholder="Enter your startup URL" value="<?php echo $startup["url"]; ?>" aria-describedby="urlHelp" disabled>
									<small id="urlHelp" class="form-text text-muted">You cannot change this URL. <a href="/about">Get in touch</a> to move your page.</small>
								</div>
								<div class="form-group">
									<label for="email">Official Email</label>
									<input type="email" class="form-control" name="email" id="email" placeholder="Enter the startup email" value="<?php echo $startup["email"]; ?>">
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
									<label for="founded_year">Founded</label>
									<div class="row">
										<div class="col">
											<select class="form-control" name="founded_day">
												<option value="">Day</option>
												<?php for ($day = 1; $day <= 31; $day++) { ?>
													<option<?php echo $startup["founded_day"] == $day ? " selected" : ""; ?>><?php echo $day; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-5">
											<select class="form-control" name="founded_month">
												<option value="">Month</option>
												<?php foreach (["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"] as $monthN => $month) { ?>
													<option<?php echo $startup["founded_month"] == $monthN + 1 ? " selected" : ""; ?> value="<?php echo ($monthN + 1); ?>"><?php echo $month; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col">
											<select class="form-control" name="founded_year">
												<option value="">Year</option>
												<?php for ($year = 2000; $year <= intval(date("Y")); $year++) { ?>
													<option<?php echo $startup["founded_year"] == $year ? " selected" : ""; ?>><?php echo $year; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="city">City</label>
									<input type="text" class="form-control cityAutoComplete" name="city" id="city" placeholder="Enter your city name" autocomplete="new-password" value="<?php echo $startup["city"]; ?>">
								</div>
								<div class="form-group">
									<label for="description">Description</label>
									<textarea class="form-control" name="description" id="description" placeholder="Enter the description for the startup." rows="4"><?php echo $startup["about"]; ?></textarea>
								</div>
								<div class="form-group">
									<label for="employees">Number of Employees</label>
									<select class="form-control" name="employees" id="employees" value="<?php echo $startup["employees"]; ?>">
										<option value="0">Select an option</option>
										<?php for ($i = 1; $i < 6; $i++) { ?>
											<option value="<?php echo $i; ?>"<?php echo $startup["employees"] == $i ? " selected" : ""; ?>><?php echo getEmployeesRanges($i); ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group">
									<label for="employees">Startup Logo &amp; Screenshot</label>
									<button class="btn btn-secondary btn-block" aria-labelledby="logoHelp" type="button" onclick="refreshShots('<?php echo $startup["id"]; ?>');">Refresh Logo &amp; Screenshot</button>
									<small id="logoHelp" class="form-text text-muted">Your logo is fetched from your website automatically. To change it, add Apple Touch Icons or <a href="https://realfavicongenerator.net/blog/favicon-why-youre-doing-it-wrong/" target="_blank">large favicons</a> to your website.</small>
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
									<label for="link_blog">Company Blog</label>
									<input type="url" class="form-control" name="link_blog" id="link_blog" placeholder="Enter link to company blog" value="<?php echo $startup["link_blog"]; ?>">
								</div>
								<div class="form-group">
									<label for="link_facebook">Facebook Page</label>
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon3"><i class="ion ion-logo-facebook mr-2"></i>facebook.com/</span>
										<input type="text" class="form-control" name="link_facebook" id="link_facebook" placeholder="Enter Facebook page username" value="<?php echo $startup["link_facebook"]; ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="link_twitter">Twitter Profile</label>
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon3"><i class="ion ion-logo-twitter mr-2"></i>twitter.com/@</span>
										<input type="text" class="form-control" name="link_twitter" id="link_twitter" placeholder="Enter Twitter profile username" value="<?php echo $startup["link_twitter"]; ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="link_linkedin">LinkedIn Company Page</label>
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon3"><i class="ion ion-logo-linkedin mr-2"></i>linkedin.com/company/</span>
										<input type="text" class="form-control" name="link_linkedin" id="link_linkedin" placeholder="Enter LinkedIn ID" value="<?php echo $startup["link_linkedin"]; ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="link_youtube">YouTube Channel</label>
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon3"><i class="ion ion-logo-youtube mr-2"></i>youtube.com/user/</span>
										<input type="text" class="form-control" name="link_youtube" id="link_youtube" placeholder="Enter YouTube channel" value="<?php echo $startup["link_youtube"]; ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="link_googlemaps">Google Maps Location</label>
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon3"><i class="ion ion-md-map"></i></span>
										<input type="url" class="form-control" name="link_googlemaps" id="link_googlemaps" placeholder="Enter Google Maps location link" value="<?php echo $startup["link_googlemaps"]; ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="link_googleplus">Google+ Profile</label>
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon3"><i class="ion ion-logo-googleplus mr-2"></i>plus.google.com/+</span>
										<input type="text" class="form-control" name="link_googleplus" id="link_googleplus" placeholder="Enter Google+ username" value="<?php echo $startup["link_googleplus"]; ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="link_angellist">AngelList Profile</label>
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon3">angel.co/</span>
										<input type="text" class="form-control" name="link_angellist" id="link_angellist" placeholder="Enter AngelList username" value="<?php echo $startup["link_angellist"]; ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="link_f6s">F6S Profile</label>
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon3">f6s.com/</span>
										<input type="text" class="form-control" name="link_f6s" id="link_f6s" placeholder="Enter F6S username" value="<?php echo $startup["link_f6s"]; ?>">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-header" role="tab" id="headingFour">
							<h5 class="mb-0">
								<a class="collapsed" data-toggle="collapse" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
									News
								</a>
							</h5>
						</div>
						<div id="collapseFour" class="collapse" role="tabpanel" aria-labelledby="headingFour" data-parent="#accordion">
							<div class="card-body">

								<?php $s = 0; $stories = DB::query("SELECT * FROM news WHERE startup=%s", $startup["id"]); foreach ($stories as $story) { $s++; ?>
									<div class="card card-body">
										<p><?php echo $story["publication"]; ?>: <?php echo $story["title"]; ?> &middot; <?php echo timeMe($story["datetime"]); ?></p>
										<p><button class="btn btn-secondary" type="button" onclick="deleteStory('<?php echo $story["id"]; ?>'); $(this).parent().parent().fadeOut();">Delete Story</button></p>
									</div>
								<?php } if ($s != 0) { ?>
									<hr class="mt-4 mb-4">
								<?php } ?>

								<h4 class="h5">Add News Story</h4>
								
								<div class="form-group">
									<label for="publication_name">Publication Name</label>
									<input type="text" class="form-control" name="publication_name" id="publication_name" placeholder="Enter the name of publication (eg. Hindustan Times)">
								</div>
								<div class="form-group">
									<label for="story_title">Story Title</label>
									<input type="text" class="form-control" name="story_title" id="story_title" placeholder="Enter the title of the story">
								</div>
								<div class="form-group">
									<label for="story_date">Story Date</label>
									<div class="row">
										<div class="col">
											<select class="form-control" name="story_date">
												<option value="">Day</option>
												<?php for ($day = 1; $day <= 31; $day++) { ?>
													<option><?php echo $day; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-5">
											<select class="form-control" name="story_month">
												<option value="">Month</option>
												<?php foreach (["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"] as $month) { ?>
													<option value="<?php echo $month; ?>"><?php echo $month; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col">
											<select class="form-control" name="story_year">
												<option value="">Year</option>
												<?php for ($year = 2000; $year <= intval(date("Y")); $year++) { ?>
													<option><?php echo $year; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="publication_link">Link to Story</label>
									<input type="url" class="form-control" name="publication_link" id="publication_link" placeholder="Enter the link to the story">
								</div>
								<button class="btn btn-secondary" type="submit">Add Story</button>
							</div>
						</div>
						<div class="card">
							<div class="card-header" role="tab" id="headingFive">
								<h5 class="mb-0">
									<a class="collapsed" data-toggle="collapse" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
										Founders
									</a>
								</h5>
							</div>
							<div id="collapseFive" class="collapse" role="tabpanel" aria-labelledby="headingFive" data-parent="#accordion">
								<div class="card-body">
									<div class="form-group">
										<label for="founder1">Founder 1</label>
										<input type="text" class="form-control userAutocomplete" name="founder1" id="founder1" placeholder="Enter a founder" value="<?php echo $startup["founder1"]; ?>">
									</div>
								</div>
								<div class="card-body">
									<div class="form-group">
										<label for="founder2">Founder 2</label>
										<input type="text" class="form-control userAutocomplete" name="founder2" id="founder2" placeholder="Enter a founder" value="<?php echo $startup["founder2"]; ?>">
									</div>
								</div>
								<div class="card-body">
									<div class="form-group">
										<label for="founder3">Founder 3</label>
										<input type="text" class="form-control userAutocomplete" name="founder3" id="founder3" placeholder="Enter a founder" value="<?php echo $startup["founder3"]; ?>">
									</div>
								</div>
								<div class="card-body">
									<div class="form-group">
										<label for="founder4">Founder 4</label>
										<input type="text" class="form-control userAutocomplete" name="founder4" id="founder4" placeholder="Enter a founder" value="<?php echo $startup["founder4"]; ?>">
									</div>
								</div>
								<div class="card-body">
									<div class="form-group">
										<label for="founder5">Founder 5</label>
										<input type="text" class="form-control userAutocomplete" name="founder5" id="founder5" placeholder="Enter a founder" value="<?php echo $startup["founder5"]; ?>">
									</div>
								</div>
							</div>
						</div>
						<div class="card">
							<div class="card-header" role="tab" id="headingSix">
								<h5 class="mb-0">
									<a class="collapsed" data-toggle="collapse" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
										Delete Startup
									</a>
								</h5>
							</div>
							<div id="collapseSix" class="collapse" role="tabpanel" aria-labelledby="headingSix" data-parent="#accordion">
								<div class="card-body">
									<p><strong>Danger Zone:</strong> Do you want to delete this startup from the Made with Love in India platform?</p>
									<p>This action cannot be reversed.</p>
									<p><button onclick='var x = confirm("Are you sure you want to delete your startup? This cannot be reversed."); if (!x) { return false; }' type="submit" name="deleteStartup" class="btn btn-danger">Delete <?php echo $startup["name"]; ?></button></p>
								</div>
							</div>
						</div>
					</div>
					<button class="btn btn-primary mt-3" type="submit">Publish Changes</button>
					<a class="btn btn-secondary mt-3 ml-2" href="/startup/<?php echo $startup["slug"]; ?>">Cancel &amp; Go Back</a>
				</form>
			</div>
		</div>
	</div>
</main>
<script src="https://cdn.ckeditor.com/4.7.3/basic/ckeditor.js"></script>
<script> CKEDITOR.replace("description"); </script>
<?php getFooter(); ?>