<?php
	require_once "database.php";
	include "header.php";
	$profile = DB::queryFirstRow("SELECT * FROM users WHERE username=%s", $currentURL[4]);
	if (!$profile) { header("Location: /404"); }
	getHeader("People", $profile["name"]);
	$nStartups = getnStartups($profile["id"]);
?>

		<main id="content" class="pt-4 pb-4">
			<div class="container">
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
										<?php display('<a target="_blank" title="LinkedIn profile" href="%s"><i class="ion ion-logo-linkedin"></i></a>', "https://www.linkedin.com/in/" . ($profile["link_linkedin"] . "/")); ?>
										<?php display('<a target="_blank" title="Facebook profile" href="%s"><i class="ion ion-logo-facebook"></i></a>', "https://www.facebook.com/" . ($profile["link_facebook"])); ?>
										<?php display('<a target="_blank" title="Twitter profile" href="%s"><i class="ion ion-logo-twitter"></i></a>', "https://twitter.com/" . ($profile["link_twitter"])); ?>
									</div>
								</div>
							</div>
						</div>
						<div class="card mb-4">
							<div class="card-body pb-1">
								<h4 class="card-title border pb-2 mb-0 border-top-0 border-left-0 border-right-0 bigger">Startups</h4>
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
									<h4 class="h6"><?php echo explode(" ", $profile["name"])[0]; ?> has not founded any startups yet.</h4>
									<p>Do you want to get in touch with <?php echo explode(" ", $profile["name"])[0]; ?>? <a href="#">Message now.</a></p>
								</div>
								<?php } ?>
							</div>
						</div>
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
									<h4 class="h6"><?php echo explode(" ", $profile["name"])[0]; ?> has not added his education.</h4>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<?php if (isset($_SESSION["user"])) { display('<span style="display: none">%s</span><a href="/settings" class="btn btn-danger btn-block btn-visit-website text-left p-3 mb-3">
							<div class="text-truncate">Edit Your Profile</div>
							<div class="text-lighter small mt-1 text-truncate">Only you can see this</div>
							<i class="ion ion-md-create text-lighter"></i>
						</a>', boolify($profile["id"] == $_SESSION["user"]["id"])); } ?>
						<!-- <a href="#" class="btn btn-primary btn-block btn-visit-website text-left p-3 mb-4">
							<div>Message <?php echo explode(" ", $profile["name"])[0]; ?></div>
							<div class="text-lighter small mt-1">Available for messages</div>
							<i class="ion ion-md-arrow-forward text-lighter"></i>
						</a> -->
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
												<td>City</td>
												<td><a href="/city/%s">%s</a></td>
											</tr>', urlify($profile["city"]), $profile["city"]); ?>
											<?php display('<tr>
												<td>Gender</td>
												<td>%s</td>
											</tr>', genderify($profile["gender"])); ?>
											<?php if ($profile["show_age"] == 2) { ?>
											<?php display('<tr>
												<td style="vertical-align: top">Birthday</td>
												<td>%s %s, %s<br>(%s years old)</td>
											</tr>', monthify($profile["bd_month"]), $profile["bd_day"], $profile["bd_year"], ageify($profile["bd_day"], $profile["bd_month"], $profile["bd_year"])); ?>
											<?php } else if ($profile["show_age"] == 1) { ?>
											<?php display('<tr>
												<td>Age</td>
												<td>%s years</td>
											</tr>', ageify($profile["bd_day"], $profile["bd_month"], $profile["bd_year"])); ?>
											<?php } ?>
											<?php display('<tr>
												<td style="vertical-align: top">Hobbies</td>
												<td>%s</td>
											</tr>', $profile["hobbies"]); ?>
											<tr>
												<td>Founded</td>
												<td><?php echo $nStartups; ?> startup<?php display('s', $nStartups != 1) ?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="card mb-4">
							<div class="card-body">
								<h4 class="card-title border pb-2 border-top-0 border-left-0 border-right-0 text-uppercase smaller">Community Profile</h4>
								<p class="card-text">This profile is owned by the community. <a href="#">Claim this profile</a> to modify or add to the information, or <a href="#">suggest a change</a>.</p>
								<p class="card-text small text-muted">This profile is not affiliated with or endorsed by anyone associated with the topic.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>

		<?php getFooter(); ?>