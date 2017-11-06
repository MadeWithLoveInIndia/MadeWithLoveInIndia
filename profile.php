<?php
	require_once "database.php";
	include "header.php";
	$profile = DB::queryFirstRow("SELECT * FROM users WHERE username=%s", $currentURL[4]);
	$page = $currentURL[5];
	if (!$page) {
		$page = "profile";
	}
	if (!$profile || !in_array($page, ["profile", "startups", "education", "skills", "message"])) {
		header("HTTP/1.0 404 Not Found");
		getHeader("Page", "404 Error");
?>
<main id="content" class="pt-4">
	<div class="container text-center mt-5 mb-5 pb-5">
		<h1>404 Error</h1>
		<p>This page doesn't exist.</p>
	</div>
</main>
<?php
		getFooter();
		die();
		exit();
	}
	$nStartups = getnStartups($profile["id"]);
	$error = null;
	if ($page == "message") {
		if (!isset($_SESSION["user"])) {
			header("Location: /login?returnto=$_SERVER[REQUEST_URI]&message=Please+log+in+to+message+" . urlencode($profile["name"]) . ".");
		}
		if ($_SESSION["user"]["id"] == $profile["id"]) {
			$error = "You cannot message yourself.";
		}
		if ($profile["emailverified"] == 0) {
			$error = "You cannot message a community profile.";
		}
		$title = "Message " . $profile["name"];
	} else {
		$title = $profile["name"] . "&rsquo;s " . ucfirst($page);
	}
	$description = null;
	if ($page == "startups") {
		$description = "View " . $profile["name"] . "&rsquo;s profile and the startups ";
		$description .= $profile["gender"] == "M" ? "he" : "she";
		$description .= " founded on Made with Love in India";
		$description .= ", a movement to celebrate, promote, and build a brand &mdash; India.";
		if ($nStartups > 0) {
			$description .= $profile["gender"] == "M" ? " He" : " She";
			$description .= " has founded " . $nStartups . " startups.";
		}
	} else if ($page == "education") {
		$description = "View " . $profile["name"] . "&rsquo;s profile and ";
		$description .= $profile["gender"] == "M" ? "his" : "her";
		$description .= " education on Made with Love in India";
		$description .= ", a movement to celebrate, promote, and build a brand &mdash; India.";
		if ($profile["university1"]) {
			$description .= $profile["gender"] == "M" ? " He" : " She";
			$description .= " studied at " . $profile["university1"];
			if ($profile["course1"]) {
				$description .= " (" . $profile["course1"] . ")";
			}
			$description .= ".";
		}
	} else {
		$description = "View " . $profile["name"] . "&rsquo;s profile on Made with Love in India.";
		if ($profile["city"] || $nStartups) {
			$description .= " " . explode(" ", $profile["name"])[0];
		}
		if ($profile["city"]) {
			$description .= " is from " . $profile["city"];
		}
		if ($profile["city"] && $nStartups > 0) {
			$description .= " and";
		}
		if ($nStartups > 0) {
			$description .= " has founded " . $nStartups . " startups";
		}
		$description .= ".";
		if ($profile["university1"]) {
			$description .= $profile["gender"] == "M" ? " He" : " She";
			$description .= " studied at " . $profile["university1"];
			if ($profile["course1"]) {
				$description .= " (" . $profile["course1"] . ")";
			}
			$description .= ".";
		}
		$description .= " Made with Love in India is a movement to celebrate, promote, and build a brand &mdash; India.";
	}


	$schema = [];
	$schema["@type"] = "Person";
	$schema["name"] = $profile["name"];
	$schema["url"] = "https://madewithlove.org.in/profile/" . $profile["username"];
	$schema["nationality"] = "India";
	$schema["image"] = avatarUrl($profile["email"]);

	$bd = null;
	if ($profile["show_age"] == 2) {
		if ($profile["bd_year"]) {
			$bd = $profile["bd_year"];
			if ($profile["bd_month"]) {
				$bd .= "-" . $profile["bd_month"];
				if ($profile["bd_day"]) {	
					$bd .= "-" . $profile["bd_day"];
				}
			}
			$schema["birthDate"] = $bd;
		}
	}

	$gender = null;
	if ($profile["gender"]) {
		switch ($profile["gender"]) {
			case "M":
				$gender = "Male";
				break;
			case "F":
				$gender = "Female";
				break;
			default:
				$gender = "Other";
				break;
		}
		$schema["gender"] = $gender;
	}

	if ($profile["link_website"]) {
		$schema["sameAs"] = $profile["link_website"];
	}
	if ($profile["link_facebook"]) {
		$schema["sameAs__1"] = "https://www.facebook.com/" . $profile["link_facebook"];
	}
	if ($profile["link_twitter"]) {
		$schema["sameAs__2"] = "https://twitter.com/" . $profile["link_twitter"];
	}
	if ($profile["link_linkedin"]) {
		$schema["sameAs__3"] = "https://www.linkedin.com/in/" . $profile["link_linkedin"] . "/";
	}
	$schema["sameAs__4"] = "https://madewithlove.org.in/profile/" . $profile["username"] . "/startups";
	$schema["sameAs__5"] = "https://madewithlove.org.in/profile/" . $profile["username"] . "/education";

	$myStartups = DB::query("SELECT * FROM startups WHERE founder1 = %s OR founder2 = %s OR founder3 = %s OR founder4 = %s OR founder5 = %s", $profile["id"], $profile["id"], $profile["id"], $profile["id"], $profile["id"]);
	for ($i = 0; $i < sizeof($myStartups); $i++) { if ($myStartups[$i]) {
		// echo "PL";
		// this is for schema data
	} }

	// if ($profile["city"]) {
	// 	$schema["homeLocation"] = $profile["city"];
	// }

	getHeader("People", $title, null, null, $description, $schema);
?>

		<?php if ($page == "profile") { ?>
		<main id="content" class="pt-4 pb-4">
			<div class="container">
				<?php display('<div class="alert alert-info mb-4">Welcome to your new profile! Please <strong>verify your email</strong> to claim this profile. Otherwise, your profile will display a &ldquo;Community Profile&rdquo; notice.</div>', ($profile["emailverified"] == 0 && $_SESSION["user"]["id"] == $profile["id"])); ?>
				<div class="row">
					<div class="col-md">
						<div class="card card-body profile-card mb-4">
							<div class="before" style='background-image: url("<?php echo avatarUrl($profile["email"]); ?>")'>
								<span class="no-opacity">View <?php display('%s', $profile["name"]); ?>'s Profile on Made with Love in India, including startups founded, education, and more.</span>
							</div>
							<div class="container">
								<div class="row">
									<div class="col-md-3">
										<img class="rounded-circle" alt="Anand Chowdhary" src="<?php echo avatarUrl($profile["email"]); ?>">
									</div>
									<div class="col-md ml-2 text-white d-flex align-items-center">
										<header>
											<?php display('<h2 class="h4 mb-2">%s</h2>', $profile["name"]); ?>
											<?php display('<p class="h6 mb-0">%s</p>', $profile["shortbio"]); ?>
										</header>
									</div>
									<div class="col-md-2 d-flex align-items-center flex-row-reverse profile-links">
										<?php display('<a target="_blank" title="LinkedIn profile" href="https://www.linkedin.com/in/%s/"><i class="ion ion-logo-linkedin"></i></a>', ($profile["link_linkedin"])); ?>
										<?php display('<a target="_blank" title="Facebook profile" href="https://www.facebook.com/%s"><i class="ion ion-logo-facebook"></i></a>', ($profile["link_facebook"])); ?>
										<?php display('<a target="_blank" title="Twitter profile" href="https://twitter.com/%s"><i class="ion ion-logo-twitter"></i></a>', ($profile["link_twitter"])); ?>
									</div>
								</div>
							</div>
						</div>
						<div class="card mb-4">
							<div class="card-body pb-1">
								<h4 class="card-title border pb-2 mb-0 border-top-0 border-left-0 border-right-0 bigger"><a href="/profile/<?php echo $profile["username"]; ?>/startups" class="text-dark">Startups</a></h4>
							</div>
							<div class="list-group">
								<?php
								$myStartups = get3Startups($profile["id"]);
								for ($i = 0; $i < 3; $i++) { if ($myStartups[$i]) { ?>
								<a href="/startup/<?php echo $myStartups[$i]["slug"]; ?>" class="list-group-item list-group-item-action p-4">
									<div class="d-flex flex-row">
										<div class="startup-image mr-3">
											<?php display('<img alt="%s" src="/assets/uploads/logo/%s_%s.jpg">', $myStartups[$i]["name"], md5($myStartups[$i]["slug"]), $myStartups[$i]["slug"]); ?>
										</div>
										<div class="startup-info">
											<h3 class="h5 mb-1">
												<?php display('<span>%s</span>', $myStartups[$i]["name"]); ?>
												<span class="badges">
													<?php display('<span data-toggle="tooltip" data-placement="top" title="Verified page"><i class="ion ion-md-checkmark-circle ml-1 checkbox-icon text-success"></i></span>', boolify($myStartups[$i]["badge_verified"])); ?>
												</span>
											</h3>
											<?php display('<p class="text-muted mb-1">%s</p>', $myStartups[$i]["tagline"]); ?>
											<div class="startup-tags">
												<?php display('<span class="badge badge-light">%s</span>', $myStartups[$i]["city"]); ?>
												<?php display('<span class="badge badge-light">%s</span>', $myStartups[$i]["industry"]); ?>
												<?php display('<span class="badge badge-light">%s</span>', json_decode($myStartups[$i]["tag1"])[0]); ?>
											</div>
										</div>
									</div>
								</a>
								<?php } } if (sizeof($myStartups) == 0) { ?>
								<div class="text-muted text-center p-4">
									<h1><i class="ion ion-ios-briefcase bigger"></i></h1>
									<h4 class="h6"><?php echo explode(" ", $profile["name"])[0]; ?> has not founded any startups yet.</h4>
								</div>
								<?php } ?>
							</div>
						</div>
						<div class="card mb-4">
							<div class="card-body pb-1">
							<h4 class="card-title border pb-2 mb-0 border-top-0 border-left-0 border-right-0 bigger"><a href="/profile/<?php echo $profile["username"]; ?>/education" class="text-dark">Education</a></h4>
							</div>
							<div class="list-group">
								<?php $nUnis = 0; for ($i = 0; $i < 5; $i++) {
									if ($profile["university" . $i]) {
										$nUnis++;
									}
									display('<a href="/institute/%s" class="list-group-item list-group-item-action">
										<div class="d-flex flex-row">
											<div class="education-image mr-3">
												<img alt="Startup Name" src="/assets/uploads/institutes/%s_%s.jpg">
											</div>
											<div class="startup-info d-flex align-items-center">
												<div>
													<h3 class="h6 mb-1">%s</h3>
													<p class="text-muted mb-1">%s</p>
												</div>
											</div>
										</div>
									</a>', urlencode($profile["university" . ($i + 1)]), md5($profile["university" . ($i + 1)]), slugify($profile["university" . ($i + 1)]), $profile["university" . ($i + 1)], $profile["course" . ($i + 1)]);
								} if ($nUnis == 0) { ?>
								<div class="text-muted text-center p-4">
									<h1><i class="ion ion-ios-school bigger"></i></h1>
									<h4 class="h6"><?php echo explode(" ", $profile["name"])[0]; ?> has not added <?php echo $profile["gender"] == "M" ? "his" : "her"; ?> education yet.</h4>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<?php if (isset($_SESSION["user"])) { display('<span style="display: none">%s</span><a href="/settings" class="btn btn-danger btn-block btn-visit-website text-left p-3 mb-4">
							<div class="text-truncate">Edit Your Profile</div>
							<div class="text-lighter small mt-1 text-truncate">Only you can see this</div>
							<i class="ion ion-md-create text-lighter"></i>
						</a>', boolify($profile["id"] == $_SESSION["user"]["id"])); } ?>
						<?php display('<span style="display: none">%s</span><a href="/profile/%s/message" class="btn btn-danger btn-block btn-visit-website text-left p-3 mb-4">
							<div>Message %s</div>
							<div class="text-lighter small mt-1">Available for messages</div>
							<i class="ion ion-md-arrow-forward text-lighter"></i>
						</a>', $_SESSION["user"]["id"] != $profile["id"] && $profile["emailverified"] == 1, $profile["username"], explode(" ", $profile["name"])[0]); ?>
						<div class="card mb-4">
							<div class="card-body">
								<h4 class="card-title border pb-2 border-top-0 border-left-0 border-right-0 text-uppercase smaller">Share Profile</h4>
								<div class="row">
									<div class="col">
										<a target="_blank" href="https://twitter.com/share?text=<?php echo urlencode($profile["name"] . "'s profile on Made with Love in India @mwlii"); ?>&url=<?php echo urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>" class="btn btn-twitter btn-block">
											<i class="ion ion-logo-twitter"></i>
										</a>
									</div>
									<div class="col pl-0">
										<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>" class="btn btn-facebook btn-block">
											<i class="ion ion-logo-facebook"></i>
										</a>
									</div>
									<div class="col pl-0">
										<a target="_blank" href="https://www.linkedin.com/cws/share?url=<?php echo urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>" class="btn btn-linkedin btn-block">
											<i class="ion ion-logo-linkedin"></i>
										</a>
									</div>
									<div class="col pl-0 d-none d-md-block">
										<a target="_blank" href="http://plus.google.com/share?url=<?php echo urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>" class="btn btn-google btn-block">
											<i class="ion ion-logo-googleplus"></i>
										</a>
									</div>
									<div class="col pl-0 d-md-none d-lg-none d-xl-none">
										<a target="_blank" href="whatsapp://send?text=<?php echo urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>" class="btn btn-success btn-block">
											<i class="ion ion-logo-whatsapp"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="card mb-4">
							<div class="card-body">
								<h4 class="card-title border pb-2 border-top-0 border-left-0 border-right-0 text-uppercase smaller">About Anand</h4>
								<div class="p">
									<table>
										<tbody>
											<?php display('<tr>
												<td style="width: 40%%">Website</td>
												<td><a target="_blank" href="%s">%s</a></td>
											</tr>', $profile["link_website"], websiteify($profile["link_website"])); ?>
											<?php display('<tr>
												<td style="width: 40%%">City</td>
												<td><a href="/city/%s">%s</a></td>
											</tr>', urlify($profile["city"]), $profile["city"]); ?>
											<?php display('<tr>
												<td style="width: 40%%">Gender</td>
												<td>%s</td>
											</tr>', genderify($profile["gender"])); ?>
											<?php if ($profile["show_age"] == 2) { ?>
											<?php display('<tr>
												<td style="vertical-align: top; width: 40%%">Birthday</td>
												<td>%s %s, %s<br>(%s years old)</td>
											</tr>', monthify($profile["bd_month"]), $profile["bd_day"], $profile["bd_year"], ageify($profile["bd_day"], $profile["bd_month"], $profile["bd_year"])); ?>
											<?php } else if ($profile["show_age"] == 1) { ?>
											<?php display('<tr>
												<td style="width: 40%%">Age</td>
												<td>%s years</td>
											</tr>', ageify($profile["bd_day"], $profile["bd_month"], $profile["bd_year"])); ?>
											<?php } ?>
											<?php display('<tr>
												<td style="vertical-align: top; width: 40%%">Skills</td>
												<td>%s</td>
											</tr>', listify($profile["hobbies"])); ?>
											<tr>
												<td>Founded</td>
												<td><?php echo $nStartups; ?> startup<?php display('s', $nStartups != 1) ?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<?php if ($profile["emailverified"] == 1) { ?>
						<div class="card mb-4">
							<div class="card-body">
								<h4 class="card-title border pb-2 border-top-0 border-left-0 border-right-0 text-uppercase smaller">Verified Profile</h4>
								<p class="card-text"><span class="d-none">%s</span>This a verified profile and only its owner can make changes to it.</p>
								<p class="card-text small text-muted">You can, however, <a href="#">suggest a change</a> to this page and we will get back to you.</p>
							</div>
						</div>
						<?php } else { ?>
						<div class="card mb-4">
							<div class="card-body">
								<h4 class="card-title border pb-2 border-top-0 border-left-0 border-right-0 text-uppercase smaller">Community Profile</h4>
								<p class="card-text">This profile is owned by the community. <a href="/verify/user/<?php echo $profile["username"]; ?>">Claim this profile</a> to modify or add to the information, or <a href="#">suggest a change</a>.</p>
								<p class="card-text small text-muted">This profile is not affiliated with or endorsed by anyone associated with the topic.</p>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</main>

		<?php } else { ?>

		<main id="content">
			<div class="container pt-4 mt-4 pb-4">
				<div class="row justify-content-center">
					<div class="col-md-8">
						<div class="card card-body profile-card mb-4">
							<div class="before" style='background-image: url("<?php echo avatarUrl($profile["email"]); ?>")'>
								<span class="no-opacity">View <?php display('%s', $profile["name"]); ?>'s Profile on Made with Love in India, including startups founded, education, and more.</span>
							</div>
							<div class="container">
								<div class="row">
									<div class="col-md-3">
										<a href="/profile/<?php echo $profile["username"]; ?>">
											<img class="rounded-circle" alt="Anand Chowdhary" src="<?php echo avatarUrl($profile["email"]); ?>"	>
										</a>
									</div>
									<div class="col-md ml-2 text-white d-flex align-items-center">
										<header>
											<?php display('<h2 class="h4 mb-2">%s</h2>', $profile["name"]); ?>
											<?php display('<p class="h6 mb-0"><a href="/profile/%s" class="text-light"><i class="ion ion-md-arrow-back mr-2"></i>%s</a></p>', $profile["username"], "Back to Profile"); ?>
										</header>
									</div>
								</div>
							</div>
						</div>
						<?php if ($error) { ?>
						<?php display('<div class="alert alert-danger mt-4" role="alert"><strong>Error: </strong>%s</div>', $error); ?>
						<?php } else { ?>
						<?php if ($currentURL[5] == "startups") { ?>
						<div class="card mb-4">
							<div class="card-body pb-1">
								<h4 class="card-title border pb-2 mb-0 border-top-0 border-left-0 border-right-0 bigger">Startups</h4>
							</div>
							<div class="list-group">
								<?php
								$myStartups = DB::query("SELECT * FROM startups WHERE founder1 = %s OR founder2 = %s OR founder3 = %s OR founder4 = %s OR founder5 = %s", $profile["id"], $profile["id"], $profile["id"], $profile["id"], $profile["id"]);
								for ($i = 0; $i < sizeof($myStartups); $i++) { if ($myStartups[$i]) { ?>
								<a href="/startup/<?php echo $myStartups[$i]["slug"]; ?>" class="list-group-item list-group-item-action p-4">
									<div class="d-flex flex-row">
										<div class="startup-image mr-3">
											<?php display('<img alt="%s" src="/assets/uploads/logo/%s_%s.jpg">', $myStartups[$i]["name"], md5($myStartups[$i]["slug"]), $myStartups[$i]["slug"]); ?>
										</div>
										<div class="startup-info">
											<h3 class="h5 mb-1">
												<?php display('<span>%s</span>', $myStartups[$i]["name"]); ?>
												<span class="badges">
													<?php display('<span data-toggle="tooltip" data-placement="top" title="Verified page"><i class="ion ion-md-checkmark-circle ml-1 checkbox-icon text-success"></i></span>', boolify($myStartups[$i]["badge_verified"])); ?>
												</span>
											</h3>
											<?php display('<p class="text-muted mb-1">%s</p>', $myStartups[$i]["tagline"]); ?>
											<div class="startup-tags">
												<?php display('<span class="badge badge-light">%s</span>', $myStartups[$i]["city"]); ?>
												<?php display('<span class="badge badge-light">%s</span>', $myStartups[$i]["industry"]); ?>
												<?php display('<span class="badge badge-light">%s</span>', json_decode($myStartups[$i]["tag1"])[0]); ?>
											</div>
										</div>
									</div>
								</a>
								<?php } } if (sizeof($myStartups) == 0) { ?>
								<div class="text-muted text-center p-4">
									<h1><i class="ion ion-ios-briefcase bigger"></i></h1>
									<h4 class="h6"><?php echo explode(" ", $profile["name"])[0]; ?> has not founded any startups yet.</h4>
								</div>
								<?php } ?>
							</div>
						</div>
						<?php } if ($currentURL[5] == "message") { ?>
						<div class="card mb-4">
							<div class="card-body pb-1">
								<h4 class="card-title border pb-2 mb-0 border-top-0 border-left-0 border-right-0 bigger">Message</h4>
								<form class="mt-3 mb-3" action="/message" method="post">
									<div class="form-group">
										<label for="email">Your Email</label>
										<input type="text" class="form-control" value="<?php echo $_SESSION["user"]["email"]; ?>" placeholder="Enter your email" disabled>
									</div>
									<div class="form-group">
										<label for="subject">Subject</label>
										<input type="text" class="form-control" name="subject" id="subject" placeholder="Enter a subject for this message" required>
									</div>
									<div class="form-group">
										<label for="message">Message</label>
										<textarea class="form-control" name="message" id="message" placeholder="Enter your message" rows="10" required></textarea>
									</div>
									<input type="hidden" name="to" value="<?php echo $profile["id"]; ?>">
									<div class="g-recaptcha" data-sitekey="6LdExBIUAAAAAPB6nhoIar2LDZQDEpJb2eDCopUu"></div>
									<button type="submit" class="btn btn-danger mt-3">Send Message</button>
								</form>
							</div>
						</div>
						<?php } if ($currentURL[5] == "education") { ?>
						<div class="card mb-4">
							<div class="card-body pb-1">
								<h4 class="card-title border pb-2 mb-0 border-top-0 border-left-0 border-right-0 bigger">Education</h4>
							</div>
							<div class="list-group">
								<?php $nUnis = 0; for ($i = 0; $i < 5; $i++) {
									if ($profile["university" . $i]) {
										$nUnis++;
									}
									display('<a href="/institute/%s" class="list-group-item list-group-item-action">
										<div class="d-flex flex-row">
											<div class="education-image mr-3">
												<img alt="Startup Name" src="/assets/uploads/institutes/%s_%s.jpg">
											</div>
											<div class="startup-info d-flex align-items-center">
												<div>
													<h3 class="h6 mb-1">%s</h3>
													<p class="text-muted mb-1">%s</p>
												</div>
											</div>
										</div>
									</a>', urlencode($profile["university" . ($i + 1)]), md5($profile["university" . ($i + 1)]), slugify($profile["university" . ($i + 1)]), $profile["university" . ($i + 1)], $profile["course" . ($i + 1)]);
								} if ($nUnis == 0) { ?>
								<div class="text-muted text-center p-4">
									<h1><i class="ion ion-ios-school bigger"></i></h1>
									<h4 class="h6"><?php echo explode(" ", $profile["name"])[0]; ?> has not added <?php echo $profile["gender"] == "M" ? "his" : "her"; ?> education yet.</h4>
								</div>
								<?php } ?>
							</div>
						</div>
						<?php } } ?>
					</div>
				</div>
			</div>
		</main>

		<?php } getFooter(); ?>