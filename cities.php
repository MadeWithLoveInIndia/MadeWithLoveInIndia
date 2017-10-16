<?php
	require_once "database.php";
	include "header.php";
	$type = "cities";
	if (!$currentURL[4]) {
		$page = 1;
	} else {
		$page = $currentURL[4];
	}
	$nResults = sizeof(DB::query("SELECT city FROM startups GROUP BY city"));
	$nPages = intval($nResults / $startupsPerPage);
	$nPages += $nResults % $startupsPerPage > 0 ? 1 : 0;
	$x = DB::query("SELECT city FROM startups GROUP BY city LIMIT %d OFFSET %d", $startupsPerPage, ($page - 1) * $startupsPerPage);
	$myStartups = [];
	foreach($x as $y) {
		$a = DB::queryFirstRow("SELECT * FROM cities WHERE name=%s", $y["city"]);
		$n = DB::queryFirstRow("SELECT COUNT(*) AS a FROM startups WHERE city=%s", $y["city"])["a"];
		array_push($myStartups, [
			"name" => $a["name"],
			"nStartups" => $n,
			"tagline" => $a["state"],
			"slug" => urlify($a["name"]),
			"city" => $y["city"]
		]);
	}
	$sortArray = [];
	foreach($myStartups as $person) {
		foreach($person as $key => $value) {
			if (!isset($sortArray[$key])) {
				$sortArray[$key] = [];
			}
			$sortArray[$key][] = $value;
		}
	}
	$orderby = "nStartups";
	array_multisort($sortArray[$orderby], SORT_DESC, $myStartups); 
	getHeader("Cities", "India");
?>
		<main id="content" class="pt-4 pb-4">
			<div class="container">
				<div class="row">
					<div class="col-md">
						<div class="card mb-4">
							<div class="card-body pb-1">
								<h4 class="card-title border pb-2 mb-0 border-top-0 border-left-0 border-right-0 bigger">Top Startup Cities in India</h4>
							</div>
							<div class="list-group">
								<?php
								for ($i = 0; $i < sizeof($myStartups); $i++) { if ($myStartups[$i]) { ?>
								<a href="/city/<?php echo urlify($myStartups[$i]["slug"]); ?>" class="list-group-item list-group-item-action p-4">
									<div class="d-flex flex-row">
										<div class="startup-image mr-3">
											<?php display('<img alt="%s" src="/assets/uploads/cities/%s_%s.jpg">', $myStartups[$i]["name"], md5($myStartups[$i]["slug"]), $myStartups[$i]["slug"]); ?>
										</div>
										<div class="startup-info">
											<h3 class="h5 mb-1">
												<?php display('<span>%s</span>', $myStartups[$i]["name"]); ?>
											</h3>
											<?php display('<p class="text-muted mb-1">%s</p>', $myStartups[$i]["tagline"]); ?>
											<div class="startup-tags">
												<?php display('<span class="badge badge-light">%s</span>', $myStartups[$i]["nStartups"] . " startup" . ($myStartups[$i]["nStartups"] == 1 ? "" : "s")); ?>
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
							<li<?php if ($x + 1 == $page) { echo " class='active'"; } ?>><a href="/<?php echo $type; ?>/<?php echo $x + 1; ?>"><?php echo ($x + 1); ?></a></li>
							<?php } ?>
						</ul>
						<?php } ?>
					</div>
					<div class="col-md-4">
						<div class="card mb-4">
							<div class="card-body">
								ob_clean
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
<?php getFooter(); ?>