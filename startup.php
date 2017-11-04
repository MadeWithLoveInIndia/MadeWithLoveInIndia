<?php
	require_once "database.php";
	include "header.php";
	$profile = DB::queryFirstRow("SELECT * FROM startups WHERE slug=%s", $currentURL[4]);
	if (!$profile) { header("Location: /404"); }
	getHeader("Startups", $profile["name"]);
?>

		<main id="content" class="pt-4 pb-4">
			<div class="container">
				<div class="mb-4 pb-2 pt-2">
					<div class="row">
						<div class="pl-3 mr-2 mb-3 mb-md-0 startup-image">
							<?php display('<img alt="%s" src="/assets/uploads/logo/%s_%s.jpg">', $profile["name"], md5($profile["slug"]), $profile["slug"]); ?>
						</div>
						<div class="col-md">
							<header>
								<h2 class="h5 mb-1">
									<?php display('<span>%s</span>', $profile["name"]); ?>
									<span class="badges">
										<?php display('<a href="#" data-toggle="tooltip" data-placement="top" title="Verified page"><i class="ion ion-md-checkmark-circle ml-1 checkbox-icon text-success"></i></a>', boolify($profile["badge_verified"])); ?>
									</span>
								</h2>
								<?php display('<p class="text-muted mb-1">%s</p>', $profile["tagline"]); ?>
								<div class="startup-tags">
									<?php display('<a href="/city/%s" class="badge badge-light">%s</a>', slugify($profile["city"]), $profile["city"]); ?>
									<?php display('<a href="/industry/%s" class="badge badge-light">%s</a>', slugify($profile["industry"]), $profile["industry"]); ?>
									<?php display('<a href="/startups/%s" class="badge badge-light">%s</a>', json_decode($profile["tag1"])[0], json_decode($profile["tag1"])[0]); ?>
								</div>
							</header>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md" style="max-width: 713px">
						<?php display('<div class="card card-body mb-4">
							<img alt="" src="/assets/uploads/screenshot/%s_%s.jpg">
						</div>', md5($profile["slug"]), $profile["slug"]); ?>
						<div class="card mb-4">
							<div class="card-body pb-0">
								<h4 class="card-title border pb-2 mb-0 border-top-0 border-left-0 border-right-0 bigger">About</h4>
							</div>
							<div class="card-body pt-3">
								<?php display('%s', $profile["about"]); ?>
								<?php if (!isset($profile["about"]) || $profile["about"] == "") { ?>
								<div class="text-muted text-center p-4">
									<h4 class="h6">This section is currently empty.</h4>
									<p>Do you know about <?php echo $profile["name"]; ?>? <a href="#">Contribute info.</a></p>
								</div>
								<?php } ?>
							</div>
						</div>
						<div class="card mb-4">
							<div class="card-body pb-1">
								<h4 class="card-title border pb-2 mb-0 border-top-0 border-left-0 border-right-0 bigger">Founders</h4>
							</div>
							<div class="list-group">
								<?php $nFounders = 0; for ($i = 0; $i < 5; $i++) {
									$founder = getProfileById($profile["founder" . $i]);
									if ($founder) {
										$nFounders++;
									}
									display('<a href="/profile/%s" class="list-group-item list-group-item-action">
									<div class="d-flex flex-row">
										<div class="education-image mr-3">
											<img alt="Startup Name" src="%s">
										</div>
										<div class="startup-info d-flex align-items-center">
											<div>
												<h3 class="h6 mb-1">%s</h3>
												<p class="text-muted mb-1">%s</p>
											</div>
										</div>
									</div>
								</a>', $founder["username"], avatarUrl($founder["email"]), $founder["name"], $founder["shortbio"]); }
								if ($nFounders == 0) { ?>
								<div class="text-muted text-center p-4">
									<h4 class="h6">There are no founders listed.</h4>
									<p>Do you know who founded <?php echo $profile["name"]; ?>? <a href="#">Tell us.</a></p>
								</div>
								<?php } ?>
							</div>
						</div>
						<div class="card mb-4">
							<div class="card-body pb-0">
								<h4 class="card-title border pb-2 mb-0 border-top-0 border-left-0 border-right-0 bigger">Reviews</h4>
							</div>
							<div class="card-body pb-1">
								<?php $comments = get3Comments($profile["id"]);
									$nComments = getnComments($profile["id"]);
									for ($i = 0; $i < 3; $i++) {
										$stars = [];
										$author = getProfileById($comments[$i]["author"]);
										if (isset($author["name"])) {
											$stars = ["-outline", "-outline", "-outline", "-outline", "-outline"];
											for ($x = 0; $x < intval($comments[$i]["rating"]); $x++) {
												$stars[$x] = " ";
											}
										}
										display('<div class="card card-body p-4 mb-3 comment-body bg-light border-0">
										<p class="mb-2">
											<span class="star-rating text-warning mr-2">
												<i class="ion ion-md-star%s"></i>
												<i class="ion ion-md-star%s"></i>
												<i class="ion ion-md-star%s"></i>
												<i class="ion ion-md-star%s"></i>
												<i class="ion ion-md-star%s"></i>
											</span>
											<span>%s</span>
										</p>
										<div class="row">
											<div class="col-md-8 text-truncate">
												<a href="%s" class="small text-dark">
													<span>%s</span> &middot;
													<span class="text-muted">%s</span>
													<a href="#" data-toggle="tooltip" data-placement="top" title="Verified profile"><i class="ion ion-md-checkmark-circle ml-1 checkbox-icon text-success"></i></a>
													<a href="#" data-toggle="tooltip" data-placement="top" data-html="true" title="Founder of<br>Made with &hearts; in India"><i class="ion ion-md-heart ml-1 checkbox-icon text-danger"></i></a>
												</a>
											</div>
											<div class="col-md text-right">
												<span class="small text-muted">%s</span>
											</div>
										</div>
									</div>', $stars[0], $stars[1], $stars[2], $stars[3], $stars[4], $comments[$i]["content"], $author["username"], $author["name"], $author["shortbio"], timeMe($comments[$i]["datetime"]));
								} ?>
								<?php if ($nComments == 0) { ?>
								<div class="text-muted text-center p-4">
									<?php display('<h4 class="h6">%s has no reviews so far.</h4>', $profile["name"]) ?>
									<p>Have an experience to share? <a href="#">Write a review!</a></p>
								</div>
								<?php } ?>
								<!-- <p class="mt-4 mb-1"><a href="#">Log in</a> or <a href="#">register</a> to add your review of Shoppingo</p> -->
							</div>
							<?php $commentsPerPage = 3;
							if ($nComments > $commentsPerPage) { ?>
							<a href="#" class="list-group-item list-group-item-action text-center p-3">
								<h3 class="h6 mb-0">View <?php echo numberify($nComments, $commentsPerPage); ?> more reviews<i class="ion ion-ios-arrow-down ml-2"></i></h3>
							</a>
							<?php } ?>
						</div>
						<div class="card mb-4">
							<div class="card-body pb-1">
								<h4 class="card-title border pb-2 mb-0 border-top-0 border-left-0 border-right-0 bigger">News</h4>
							</div>
							<?php $news = get3News($profile["id"]);
							$nNews = getnNews($profile["id"]); ?>
							<div class="list-group">
								<?php for ($i = 0; $i < 3; $i++) {
									display('<a target="_blank" href="%s" class="list-group-item list-group-item-action">
									<div class="d-flex flex-row">
										<div class="education-image mr-3">
											<img alt="Startup Name" src="/assets/uploads/news/%s_%s.jpg">
										</div>
										<div class="startup-info d-flex align-items-center">
											<div class="">
												<h3 class="h6 mb-1">%s  <span class="text-muted ml-1 mr-1">&middot;</span> <span class="text-muted font-weight-normal">%s</span></h3>
												<p class="text-muted mb-1">%s</p>
											</div>
										</div>
									</div>
								</a>', $news[$i]["link"], $news[$i]["publication"] ? md5($news[$i]["publication"]) : null, slugify($news[$i]["publication"]), $news[$i]["publication"], timeMe($news[$i]["datetime"]), strlen($news[$i]["title"]) > 65 ? trim(mb_substr($news[$i]["title"], 0, 65)) . "&hellip;" : $news[$i]["title"]); } ?>
								<?php $newsPerPage = 3;
								if ($nNews > $newsPerPage) { ?>
								<a href="#" class="list-group-item list-group-item-action text-center p-3">
									<h3 class="h6 mb-0">View <?php echo numberify($nNews, $newsPerPage); ?> more articles<i class="ion ion-ios-arrow-down ml-2"></i></h3>
								</a>
								<?php } if ($nNews == 0) { ?>
								<div class="text-muted text-center p-4">
									<?php display('<h4 class="h6">There is no news about %s.</h4>', $profile["name"]) ?>
									<p>Have an article to share? <a href="#">Add it here.</a></p>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<aside class="col-md-4">
						<?php display('<a target="_blank" href="%sref=Made+with+Love+in+India" class="btn btn-primary btn-block btn-visit-website text-left p-3 mb-3">
							<div class="text-truncate">Visit %s</div>
							<div class="text-lighter small mt-1 text-truncate">%s</div>
							<i class="ion ion-md-arrow-forward text-lighter"></i>
						</a>', $profile["url"] . (strpos($profile["url"], "?") == false ? "?" : "&"), $profile["name"], websiteify($profile["url"])); ?>
						<?php display('<a href="/message/%s" class="btn btn-secondary btn-block mb-4">
							<div class="text-truncate">
								<i class="ion ion-ios-mail mr-2 larger-icon"></i>
								<span>Send Message</span>
							</div>
						</a>', $profile["slug"]); ?>
						<div class="card mb-4">
							<div class="card-body">
								<h4 class="card-title border pb-2 border-top-0 border-left-0 border-right-0 text-uppercase smaller">Share Startup</h4>
								<div class="row">
									<div class="col">
										<a target="_blank" href="https://twitter.com/share?text=<?php echo urlencode($profile["name"] . "'s page on Made with Love in India @mwlii"); ?>&url=<?php echo urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>" class="btn btn-twitter btn-block">
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
							<div class="card-body pb-1">
								<h4 class="card-title border pb-2 border-top-0 border-left-0 border-right-0 text-uppercase smaller d-flex justify-content-between">
									<span>Badges Earned</span>
									<a href="#" class="text-muted" data-toggle="tooltip" data-placement="top" title="About Badges">
										<i class="ion ion-md-help-circle"></i>
									</a>
								</h4>
							</div>
							<div class="list-group" style="margin-top: -15px">
								<?php display('<a href="#" class="list-group-item list-group-item-action">
									<div class="d-flex flex-row">
										<div class="badge-earned mr-3">
											<i class="ion ion-md-trophy bg-dark"></i>
										</div>
										<div class="badges-info d-flex align-items-center">
											<div>
												<h3 class="h6 mb-1">Unicorn</h3>
											</div>
										</div>
									</div>
								</a>', boolify($profile["badge_unicorn"])); ?>
								<?php display('<a href="#" class="list-group-item list-group-item-action">
									<div class="d-flex flex-row">
										<div class="badge-earned mr-3">
											<i class="ion ion-md-ribbon bg-warning"></i>
										</div>
										<div class="badges-info d-flex align-items-center">
											<div>
												<h3 class="h6 mb-1">Featured Startup</h3>
											</div>
										</div>
									</div>
								</a>', boolify($profile["badge_featured"])); ?>
								<?php display('<a href="#" class="list-group-item list-group-item-action">
									<div class="d-flex flex-row">
										<div class="badge-earned mr-3">
											<i class="ion ion-md-paper bg-secondary"></i>
										</div>
										<div class="badges-info d-flex align-items-center">
											<div>
												<h3 class="h6 mb-1">Newsworthy Startup</h3>
											</div>
										</div>
									</div>
								</a>', boolify($profile["badge_newsworthy"])); ?>
								<?php display('<a href="#" class="list-group-item list-group-item-action">
									<div class="d-flex flex-row">
										<div class="badge-earned mr-3">
											<i class="ion ion-md-ice-cream bg-info"></i>
										</div>
										<div class="badges-info d-flex align-items-center">
											<div>
												<h3 class="h6 mb-1">Exclusive Offers</h3>
											</div>
										</div>
									</div>
								</a>', boolify($profile["badge_offers"])); ?>
								<?php display('<a href="#" class="list-group-item list-group-item-action">
									<div class="d-flex flex-row">
										<div class="badge-earned mr-3">
											<i class="ion ion-md-flag bg-tomato"></i>
										</div>
										<div class="badges-info d-flex align-items-center">
											<div>
												<h3 class="h6 mb-1">India&rsquo;s Pride</h3>
											</div>
										</div>
									</div>
								</a>', boolify($profile["badge_addedbadge"])); ?>
								<?php display('<a href="#" class="list-group-item list-group-item-action">
									<div class="d-flex flex-row">
										<div class="badge-earned mr-3">
											<i class="ion ion-md-checkmark bg-success"></i>
										</div>
										<div class="badges-info d-flex align-items-center">
											<div>
												<h3 class="h6 mb-1">Verified Startup</h3>
											</div>
										</div>
									</div>
								</a>', boolify($profile["badge_verified"])); ?>
								<?php if (!(boolify($profile["badge_offers"]) || boolify($profile["badge_verified"]) || boolify($profile["badge_newsworthy"]) || boolify($profile["badge_featured"]) || boolify($profile["badge_addedbadge"]))) { ?>
								<div class="text-center p-4 text-muted">
									<?php display('<h4 class="h6">%s has not earned any badges so far.</h4>', $profile["name"]) ?>
									<p>Want to learn how to earn badges? <a href="#">Get started now!</a></p>
								</div>
								<?php } ?>
							</div>
						</div>
						<?php if ($profile["founded_year"] || $profile["employees"] || $profile["founded_year"] || $profile["link_facebook"] || $profile["link_twitter"] || $profile["link_googleplus"] || $profile["link_linkedin"] || $profile["link_youtube"] || $profile["link_f6s"] || $profile["link_angellist"] || $profile["link_blog"] || $profile["link_googlemaps"]) { ?>
							<div class="card mb-4">
								<div class="card-body">
									<h4 class="card-title border pb-2 border-top-0 border-left-0 border-right-0 text-uppercase smaller">Quick Facts</h4>
									<div class="p">
										<table>
											<tbody>
											<?php if (boolify($profile["founded_day"])) { ?>
												<?php display('<tr>
													<td style="vertical-align: top">Founded</td>
													<td>%s %s, %s<br>(%s year%s ago)</td>
												</tr>', monthify($profile["founded_month"]), $profile["founded_day"], $profile["founded_year"], ageify($profile["founded_day"], $profile["founded_month"], $profile["founded_year"]), ageify($profile["founded_day"], $profile["founded_month"], $profile["founded_year"]) == 1 ? "" : "s"); ?>
												<?php } else if (boolify($profile["founded_month"])) { ?>
												<?php display('<tr>
													<td style="vertical-align: top">Founded</td>
													<td>%s %s<br>(%s year%s ago)</td>
												</tr>', monthify($profile["founded_month"]), $profile["founded_year"], ageify(1, $profile["founded_month"], $profile["founded_year"]), ageify(1, $profile["founded_month"], $profile["founded_year"]) == 1 ? "" : "s"); ?>
												<?php } else { ?>
												<?php display('<tr>
													<td style="vertical-align: top">Founded</td>
													<td>%s<br>(%s year%s ago)</td>
												</tr>', $profile["founded_year"], ageify(1, 1, $profile["founded_year"]), ageify(1, 1, $profile["founded_year"]) == 1 ? "" : "s"); ?>
												<?php } ?>
												<?php display('<tr>
													<td>Employees</td>
													<td>%s</td>
												</tr>', getEmployeesRanges($profile["employees"])); ?>
												<?php if ($profile["link_facebook"] || $profile["link_twitter"] || $profile["link_linkedin"] || $profile["link_youtube"] || $profile["link_googleplus"] || $profile["link_angellist"] || $profile["link_f6s"]) { ?>
												<tr>
													<td style="vertical-align: top">Profiles</td>
													<td>
														<?php display('<div>
															<a target="_blank" href="%s">
																<i class="ion ion-logo-facebook larger-icon text-dark fixed-width-icon"></i>
																<span>Facebook</span>
															</a>
														</div>', socialMediaLink($profile["link_facebook"])); ?>
														<?php display('<div>
															<a target="_blank" href="%s">
																<i class="ion ion-logo-twitter larger-icon text-dark fixed-width-icon"></i>
																<span>Twitter</span>
															</a>
														</div>', socialMediaLink($profile["link_twitter"])); ?>
														<?php display('<div>
															<a target="_blank" href="%s">
																<i class="ion ion-logo-googleplus larger-icon text-dark fixed-width-icon"></i>
																<span>Google+</span>
															</a>
														</div>', socialMediaLink($profile["link_googleplus"])); ?>
														<?php display('<div>
															<a target="_blank" href="%s">
																<i class="ion ion-logo-linkedin larger-icon text-dark fixed-width-icon"></i>
																<span>LinkedIn</span>
															</a>
														</div>', socialMediaLink($profile["link_linkedin"])); ?>
														<?php display('<div>
															<a target="_blank" href="%s">
																<i class="ion ion-logo-youtube larger-icon text-dark fixed-width-icon"></i>
																<span>YouTube</span>
															</a>
														</div>', socialMediaLink($profile["link_youtube"])); ?>
														<?php display('<div>
															<a target="_blank" href="%s">
																<i class="ion ion-md-link larger-icon text-dark fixed-width-icon"></i>
																<span>F6S</span>
															</a>
														</div>', socialMediaLink($profile["link_f6s"])); ?>
														<?php display('<div>
															<a target="_blank" href="%s">
																<i class="ion ion-md-link larger-icon text-dark fixed-width-icon"></i>
																<span>AngelList</span>
															</a>
														</div>', socialMediaLink($profile["link_angellist"])); ?>
													</td>
												</tr>
												<?php } ?>
												<?php if ($profile["link_blog"] || $profile["link_googlemaps"]) { ?>
													<tr>
														<td style="vertical-align: top">Other Links</td>
														<td>
															<?php display('<div>
																<a target="_blank" href="%s">
																	<i class="ion ion-md-list-box larger-icon text-dark fixed-width-icon"></i>
																	<span>Blog</span>
																</a>
															</div>', socialMediaLink($profile["link_blog"])); ?>
															<?php display('<div>
																<a target="_blank" href="%s">
																	<i class="ion ion-md-map larger-icon text-dark fixed-width-icon"></i>
																	<span>Google Maps</span>
																</a>
															</div>', socialMediaLink($profile["link_googlemaps"])); ?>
														</td>
													</tr>
													<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						<?php } ?>
						<div class="card mb-4">
							<div class="card-body pb-1">
								<h4 class="card-title border pb-2 border-top-0 border-left-0 border-right-0 text-uppercase smaller">Featured in Lists</h4>
							</div>
							<div class="list-group" style="margin-top: -15px">
							<?php display('<a href="/city/%s" class="list-group-item list-group-item-action">
									<div class="d-flex flex-row">
										<div class="education-image mr-3">
											<img alt="Startup Name" src="/assets/uploads/cities/%s_%s.jpg">
										</div>
										<div class="startup-info d-flex align-items-center">
											<div>
												<h3 class="h6 mb-1">Startups in %s</h3>
												<p class="text-muted mb-1 smaller-caption">More startups from %s</p>
											</div>
										</div>
									</div>
								</a>', slugify($profile["city"]), md5($profile["city"]), $profile["city"], $profile["city"], $profile["city"]); ?>
								<?php display('<a href="/industry/%s" class="list-group-item list-group-item-action">
									<div class="d-flex flex-row">
										<div class="education-image mr-3">
											<img alt="Startup Name" src="/assets/uploads/cities/%s_%s.jpg">
										</div>
										<div class="startup-info d-flex align-items-center">
											<div>
												<h3 class="h6 mb-1">%s Startups</h3>
												<p class="text-muted mb-1 smaller-caption">Find more %s startups</p>
											</div>
										</div>
									</div>
								</a>', slugify($profile["industry"]), md5($profile["industry"]), $profile["industry"], $profile["industry"], $profile["industry"], $profile["industry"], slugify($profile["industry"])); ?>
								<?php display('<a href="/startups/%s" class="list-group-item list-group-item-action">
									<div class="d-flex flex-row">
										<div class="education-image mr-3">
											<img alt="Startup Name" src="/assets/uploads/cities/%s_%s.jpg">
										</div>
										<div class="startup-info d-flex align-items-center">
											<div>
												<h3 class="h6 mb-1">%s Startups</h3>
												<p class="text-muted mb-1 smaller-caption">Startups using %s</p>
											</div>
										</div>
									</div>
								</a>', (json_decode($profile["tag1"])[0]), md5(json_decode($profile["tag1"])[0]), json_decode($profile["tag1"])[0], json_decode($profile["tag1"])[0], json_decode($profile["tag1"])[0], json_decode($profile["tag1"])[0]); ?>
								<?php
								$nTags = sizeof(json_decode($profile["tag1"]));
								if ($nTags > 1) { ?>
								<a href="/startup/<?php echo $profile["slug"]; ?>/lists" class="list-group-item list-group-item-action text-center p-3">
									<h3 class="h6 smaller mb-0">View <?php echo numberify($nTags, 0); ?> more featured lists<i class="ion ion-ios-arrow-down ml-2"></i></h3>
								</a>
								<?php } ?>
							</div>
						</div>
						<?php display('<div class="card mb-4"><span style="display: none">%s</span>
							<div class="card-body">
								<h4 class="card-title border pb-2 border-top-0 border-left-0 border-right-0 text-uppercase smaller">Community Page</h4>
								<p class="card-text">This profile is owned by the community. To modify or add to the information, you can <a href="#">suggest a change</a> or <a href="/claim/%s">claim this page</a>.</p>
								<p class="card-text small text-muted">This page is not affiliated with or endorsed by anyone associated with the topic.</p>
							</div>
						</div>', boolify(!$profile["badge_verified"]), $profile["name"]); ?>
						<?php display('<div class="card mb-4">
							<div class="card-body">
								<h4 class="card-title border pb-2 border-top-0 border-left-0 border-right-0 text-uppercase smaller">Verified Page</h4>
								<p class="card-text"><span class="d-none">%s</span>This startup page is verified by %s. Only company employees can make changes to this page.</p>
								<p class="card-text small text-muted">You can, however, <a href="#">suggest a change</a> to this page and we will get back to you.</p>
							</div>
						</div>', boolify($profile["badge_verified"]), $profile["name"]); ?>
						<nav class="nav small">
							<a class="nav-link text-muted pl-0 pr-3" href="#">Flag Page</a>
							<a class="nav-link text-muted pl-3 pr-0" href="#" rel="nofollow">Update Screenshot</a>
						</nav>
					</aside>
				</div>
			</div>
		</main>

<?php getFooter(); ?>