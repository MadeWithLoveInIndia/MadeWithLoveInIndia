<?php
	require_once "database.php";
	include "header.php";
	$type = $currentURL[3];
	if (!$currentURL[5]) {
		$page = 1;
	} else {
		$page = $currentURL[5];
	}
	switch ($type) {
		case "city":
			$nResults = DB::queryFirstRow("SELECT COUNT(*) as a FROM startups WHERE city=%s", unurlify($currentURL[4]))["a"];
			$nPages = intval($nResults / $startupsPerPage);
			$nPages += $nResults % $startupsPerPage > 0 ? 1 : 0;
			$myStartups = DB::query("SELECT * FROM startups WHERE city=%s LIMIT %d OFFSET %d", unurlify($currentURL[4]), $startupsPerPage, ($page - 1) * $startupsPerPage);
			$city = DB::queryFirstRow("SELECT * FROM cities WHERE slug=%s", $currentURL[4]);
			if (!$city) { header("Location: /404"); }
			if ($city["name"] == "Delhi") { $city["name"] = "New Delhi"; }
			getHeader("Cities", $city["name"]);
			break;
		case "industry":
			$nResults = DB::queryFirstRow("SELECT COUNT(*) as a FROM startups WHERE industry=%s", unurlify($currentURL[4]))["a"];
			$nPages = intval($nResults / $startupsPerPage);
			$nPages += $nResults % $startupsPerPage > 0 ? 1 : 0;
			$myStartups = DB::query("SELECT * FROM startups WHERE industry=%s", unurlify($currentURL[4]));
			$city = DB::queryFirstRow("SELECT * FROM industries WHERE slug=%s", $currentURL[4]);
			if (!$city) { header("Location: /404"); }
			getHeader("Startups", $city["name"]);
			break;
		case "technology":
			$nResults = DB::queryFirstRow("SELECT COUNT(*) as a FROM startups WHERE industry=%s OR tag1=%s OR tag2=%s OR tag3=%s OR tag4=%s OR tag5=%s", unurlify($currentURL[4]), unurlify($currentURL[4]), unurlify($currentURL[4]), unurlify($currentURL[4]), unurlify($currentURL[4]), unurlify($currentURL[4]))["a"];
			$nPages = intval($nResults / $startupsPerPage);
			$nPages += $nResults % $startupsPerPage > 0 ? 1 : 0;
			$myStartups = DB::query("SELECT * FROM startups WHERE industry=%s OR tag1=%s OR tag2=%s OR tag3=%s OR tag4=%s OR tag5=%s", unurlify($currentURL[4]), unurlify($currentURL[4]), unurlify($currentURL[4]), unurlify($currentURL[4]), unurlify($currentURL[4]), unurlify($currentURL[4]));
			$city = DB::queryFirstRow("SELECT * FROM technologies WHERE slug=%s", $currentURL[4]);
			if (!$city) { $city = [
				"name" => ucfirst($currentURL[4]),
				"slug" => $currentURL[4]
			]; }
			$city["summary"] = sizeof($myStartups) . " startup" . (sizeof($myStartups) == 1 ? "" : "s");
			getHeader("Technologies", $city["name"]);
			break;
	}
?>

		<main id="content" class="pt-4 pb-4">
			<div class="container">
				<div class="row">
					<div class="col-md">
						<div class="card card-body city-card mb-4">
							<div class="before" style='background-image: url("<?php display('/assets/uploads/cities/%s_%s.jpg', md5($city["slug"]), urlify($city["slug"])); ?>")'>
								<span class="no-opacity"><?php display('There %s %s startup%s in New Delhi on Made with Love in India. Find and connect with Made in India startups, founders, and programs.', sizeof($myStartups) == 1 ? "is" : "are", sizeof($myStartups), sizeof($myStartups) == 1 ? "" : "s"); ?></span>
							</div>
							<div class="container">
								<div class="row">
									<div class="col-md-3">
										<?php display('<img class="rounded-circle" alt="Startup Name" src="/assets/uploads/cities/%s_%s.jpg">', md5($city["slug"]), urlify($city["slug"])); ?>
									</div>
									<div class="col-md ml-2 text-white d-flex align-items-center">
									<header>
										<?php display('<h2 class="h4 mb-0">%s</h2>', $city["name"]); ?>
										<?php display('<p class="lead">%s</p>', $city["state"]); ?>
										<?php display('<p>%s</p>', $city["summary"]); ?>
									</header>
									</div>
									<div class="col-md-2 d-flex align-items-center flex-row-reverse profile-links">
										<?php display('<a target="_blank" href="%s"><i class="ion ion-ios-link"></i></a>', $city["url"]); ?>
										<?php display('<a target="_blank" href="https://duckduckgo.com/?q=!ducky+site:facebook.com+%s"><i class="ion ion-logo-facebook"></i></a>', $type == "city" ? $city["name"] : false); ?>
									</div>
								</div>
							</div>
						</div>
						<div class="card mb-4">
							<div class="card-body pb-1">
								<?php display('<h4 class="card-title border pb-2 mb-0 border-top-0 border-left-0 border-right-0 bigger">%s %s%s</h4>', $type == "city" ? "Startups in" : " ", $city["name"], $type == "city" ? "" : " Startups"); ?>
							</div>
							<div class="list-group">
								<?php
								for ($i = 0; $i < sizeof($myStartups); $i++) { if ($myStartups[$i]) { ?>
								<a href="/startup/<?php echo urlify($myStartups[$i]["slug"]); ?>" class="list-group-item list-group-item-action p-4">
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
												<?php display('<span class="badge badge-light">%s</span>', $myStartups[$i]["tag1"]); ?>
											</div>
										</div>
									</div>
								</a>
								<?php } } if (sizeof($myStartups) == 0) { ?>
								<div class="text-muted text-center p-4">
									<h4 class="h6">There are no startups listed.</h4>
									<p>Know about a startup <?php echo $type == "technology" ? "using" : "in"; ?> <?php echo $city["name"]; ?>? <a href="#">Tell us</a>.</p>
								</div>
								<?php } ?>
							</div>
						</div>
						<?php if ($nPages > 1) { ?>
						<ul class="ppagination">
							<?php for ($x = 0; $x < $nPages; $x++) { ?>
							<li<?php if ($x + 1 == $page) { echo " class='active'"; } ?>><a href="/<?php echo $type; ?>/<?php echo $currentURL[4]; ?>/<?php echo $x + 1; ?>"><?php echo ($x + 1); ?></a></li>
							<?php } ?>
						</ul>
						<?php } ?>
					</div>
					<div class="col-md-4">
						<div class="card mb-4">
							<div class="card-body">
								<?php display('<h4 class="card-title border pb-2 border-top-0 border-left-0 border-right-0 text-uppercase smaller">Share%s %s%s</h4>', $type == "city" ? " Startups in " : " ", $city["name"], $type == "city" ? "" : " Startups"); ?>
								<div class="row">
									<div class="col">
										<a target="_blank" href="https://twitter.com/share?text=<?php echo urlencode("Startups in " . $city["name"] . " on Made with Love in India @mwlii"); ?>&url=<?php echo urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>" class="btn btn-twitter btn-block">
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
						<?php if ($city["description"]) { display('<div class="card mb-4">
							<div class="card-body">
								<h4 class="card-title border pb-2 border-top-0 border-left-0 border-right-0 text-uppercase smaller">About %s</h4>
								<p class="mb-0">%s</p>
							</div>
						</div>', $city["name"], $city["description"]); } ?>
						<?php if ($type == "city") { ?>
							<div class="card mb-4">
								<div class="card-body">
									<h4 class="card-title border pb-2 border-top-0 border-left-0 border-right-0 text-uppercase smaller">Quick Facts</h4>
									<div class="p">
										<table>
											<tbody>
												<tr>
													<td style="width: 40%">Population</td>
													<td><?php echo nice_number(intval(str_replace(",", "", $city["population"]))); ?></td>
												</tr>
												<tr>
													<td style="vertical-align: top">Weather</td>
													<script> window.onload = function() {
														$.get("https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%20in%20(select%20woeid%20from%20geo.places(1)%20where%20text%3D%22<?php echo $city["name"]; ?>%20india%22)&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys", function(data) {
															$(".local-weather").html(parseInt((parseInt(data.query.results.channel.item.condition.temp) - 32) * 5 / 9) + "&deg;C " + data.query.results.channel.item.condition.text);
													}); } </script>
													<td class="local-weather"></td>
												</tr>
												<tr>
													<td>Local Time</td>
													<td><?php echo date("h:i a"); ?></td>
												</tr>
												<?php if ($city["elevation"]): ?>
												<tr>
													<td>Elevation</td>
													<td><?php echo $city["elevation"]; ?></td>
												</tr>
												<?php endif; ?>
												<tr>
													<td>Location</td>
													<td><a target="_blank" href="https://www.google.com/maps/search/?api=1&query=<?php echo $city["name"]; ?>+India">Open map</a></td>
												</tr>
												<!-- <tr>
													<td>Airport</td>
													<td>{{ cityAirport }}</td>
												</tr>
												<tr>
													<td>Flights</td>
													<td>From $1,200</td>
												</tr> -->
											</tbody>
										</table>
									</div>
								</div>
							</div>
						<?php } ?>
						<div class="card mb-4">
							<div class="card-body">
								<h4 class="card-title border pb-2 border-top-0 border-left-0 border-right-0 text-uppercase smaller">Community Page</h4>
								<p class="card-text">This page is owned by the community. To modify or add to the information, you can <a href="#">suggest a change</a>.</p>
								<p class="card-text small text-muted">This page is not affiliated with or endorsed by anyone associated with the topic.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>

		<?php getFooter(); ?>