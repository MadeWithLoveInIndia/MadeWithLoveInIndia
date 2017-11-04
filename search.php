<?php

	include "database.php";
	include "header.php";

	if (!$currentURL[5]) {
		$currentURL[5] = 1;
	}
	if (!$currentURL[4]) {
		header("Location: " . "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" . "/all");
	}

	$page = $currentURL[5];
	$type = $currentURL[4];
	$sort = str_replace("sort=", "", explode("?", $_SERVER[REQUEST_URI])[1]);
	if (!$sort) {
		$sort = "oldest";
		$suffix = null;
	} else {
		$suffix = "?sort=" . $sort;
		$page = explode("?", $page)[0];
		$currentURL[5] = explode("?", $currentURL[5])[0];
	}
	switch ($sort) {
		case "recent":
			$orderBy = "id DESC";
			break;
		case "az":
			$orderBy = "name ASC";
			break;
		case "za":
			$orderBy = "name DESC";
			break;
		default:
			$orderBy = "id ASC";
			break;
	}
	
	$title = null;
	if ($type == "all") {
		$title = "Startups";
		if ($page > 1) {
			$title .= " (Page $page)";
		}
	} else {
		$title = unurlify($currentURL[4]) . " Startups";
		if ($page > 1) {
			$title .= " (Page $page)";
		}
	}

	if ($type == "all") { $type = "startups"; }

	if ($currentURL[4] == "all") {
		$startups = DB::query("SELECT * FROM startups ORDER BY $orderBy LIMIT %d OFFSET %d", $startupsPerPage, ($page - 1) * $startupsPerPage);
		$nStartups = intval(DB::queryFirstRow("SELECT COUNT(*) as a FROM startups")["a"]);
		$nPages = ceil($nStartups / $startupsPerPage);
	} else if ($currentURL[3] == "search") {
		$startups = DB::query("SELECT * FROM startups WHERE name LIKE %ss ORDER BY $orderBy LIMIT %d OFFSET %d", (unurlify($currentURL[4])), $startupsPerPage, ($page - 1) * $startupsPerPage);
		$nStartups = intval(DB::queryFirstRow("SELECT COUNT(*) as a FROM startups WHERE industry LIKE %ss", unurlify($currentURL[4]))["a"]);
		$nPages = ceil($nStartups / $startupsPerPage);
	} else if ($currentURL[3] == "industry") {
		$startups = DB::query("SELECT * FROM startups WHERE industry LIKE %ss ORDER BY $orderBy LIMIT %d OFFSET %d", (unurlify($currentURL[4])), $startupsPerPage, ($page - 1) * $startupsPerPage);
		$nStartups = intval(DB::queryFirstRow("SELECT COUNT(*) as a FROM startups WHERE industry LIKE %ss", unurlify($currentURL[4]))["a"]);
		$nPages = ceil($nStartups / $startupsPerPage);
	} else {
		$startups = DB::query("SELECT * FROM startups WHERE tag1 LIKE %ss ORDER BY $orderBy LIMIT %d OFFSET %d", $currentURL[4], $startupsPerPage, ($page - 1) * $startupsPerPage);
		$nStartups = intval(DB::queryFirstRow("SELECT COUNT(*) as a FROM startups WHERE tag1 LIKE %ss", $currentURL[4])["a"]);
		$nPages = ceil($nStartups / $startupsPerPage);
	}

	if ($page < 1 || $page > ($nPages + 1)) {
		header("Location: /404");
	}

	$nextLink = null;
	$prevLink = null;
	if ($page < $nPages) {
		$nextLink = "/$currentURL[3]/$currentURL[4]/" . ($page + 1) . $suffix;
	}
	if ($page > 1) {
		$prevLink = "/$currentURL[3]/$currentURL[4]/" . ($page - 1) . $suffix;
	}

	getHeader(null, $title, $nextLink, $prevLink);

?>
<main id="content" class="pt-4 pb-4">
	<div class="container">
		<div class="row">
			<div class="col-md">
				<?php if ($currentURL[4] != "all" && $currentURL[3] != "search" && $nStartups > 0) { ?><div class="card card-body city-card mb-4">
					<div class="before" style="background-image: url('/assets/uploads/cities/4f4b914d6db35e19101ff003c4e7ea3a_<?php echo slugify($currentURL[4]); ?>.jpg')">
						<span class="no-opacity">There are <?php echo $nStartups; ?> startups in New Delhi on Made with Love in India. Find and connect with Made in India startups, founders, and programs.</span>
					</div>
					<div class="container">
						<div class="row">
							<div class="col-md-3">
								<img class="rounded-circle" alt="Startup Name" src="/assets/uploads/cities/4f4b914d6db35e19101ff003c4e7ea3a_<?php echo slugify($currentURL[4]); ?>.jpg">
							</div>
							<div class="col-md ml-2 text-white d-flex align-items-center">
								<header>
									<h2 class="h4 mb-0"><?php echo unurlify($currentURL[4]); ?></h2>
									<p><?php echo $nStartups; ?> startups</p>
								</header>
							</div>
						</div>
					</div>
				</div><?php } ?>
				<div class="card mb-4">
					<div class="card-body pb-1">
						<h4 class="card-title border pb-2 mb-0 border-top-0 border-left-0 border-right-0 bigger"><?php echo $title; ?></h4>
						<select class="form-control absolute-select" onchange="window.location.href = '<?php echo "/$currentURL[3]/$currentURL[4]/$currentURL[5]"; ?>' + this.value">
							<option<?php if ("?" . explode("?", $_SERVER[REQUEST_URI])[1] == "?sort=oldest") { echo " selected"; } ?> value="?sort=oldest">Oldest First</option>
							<option<?php if ("?" . explode("?", $_SERVER[REQUEST_URI])[1] == "?sort=recent") { echo " selected"; } ?> value="?sort=recent">Most Recent First</option>
							<option<?php if ("?" . explode("?", $_SERVER[REQUEST_URI])[1] == "?sort=az") { echo " selected"; } ?> value="?sort=az">A to Z</option>
							<option<?php if ("?" . explode("?", $_SERVER[REQUEST_URI])[1] == "?sort=za") { echo " selected"; } ?> value="?sort=za">Z to A</option>
						</select>
					</div>
					<div class="list-group">
						<?php
						for ($i = 0; $i < sizeof($startups); $i++) { if ($startups[$i]) { ?>
						<a href="/startup/<?php echo urlify($startups[$i]["slug"]); ?>" class="list-group-item list-group-item-action p-4">
							<div class="d-flex flex-row">
								<div class="startup-image mr-3">
									<?php display('<img alt="%s" src="/assets/uploads/logo/%s_%s.jpg">', $startups[$i]["name"], md5($startups[$i]["slug"]), $startups[$i]["slug"]); ?>
								</div>
								<div class="startup-info">
									<h3 class="h5 mb-1">
										<?php display('<span>%s</span>', $startups[$i]["name"]); ?>
										<span class="badges">
											<?php display('<span data-toggle="tooltip" data-placement="top" title="Verified page"><i class="ion ion-md-checkmark-circle ml-1 checkbox-icon text-success"></i></span>', boolify($startups[$i]["badge_verified"])); ?>
										</span>
									</h3>
									<?php display('<p class="text-muted mb-1">%s</p>', $startups[$i]["tagline"]); ?>
									<div class="startup-tags">
										<?php display('<span class="badge badge-light">%s</span>', $startups[$i]["city"]); ?>
										<?php display('<span class="badge badge-light">%s</span>', $startups[$i]["industry"]); ?>
										<?php display('<span class="badge badge-light">%s</span>', json_decode($startups[$i]["tag1"])[0]); ?>
									</div>
								</div>
							</div>
						</a>
						<?php } } if (sizeof($startups) == 0) { ?>
						<div class="text-muted text-center p-4">
							<h4 class="h6">There are no startups listed.</h4>
							<p>Know of a startup? <a href="#">Tell us</a>.</p>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php if ($nPages > 1) { ?>
					<ul class="ppagination">
						<?php if ($prevLink) { ?><li>
							<a href="<?php echo $prevLink; ?>"><i class="ion ion-ios-arrow-back"></i></a>
						</li><?php } ?>
						<?php if ($nPages > 3) { ?>
							<?php if ($page == 3) { ?>
								<li><a href="/<?php echo $currentURL[3]; ?>/<?php echo $currentURL[4] . "/1" . $suffix; ?>"><?php echo 1; ?></a></li>
							<?php } ?>
							<?php if ($page > 3) { ?>
								<li><a href="/<?php echo $currentURL[3]; ?>/<?php echo $currentURL[4] . "/1" . $suffix; ?>"><?php echo 1; ?></a></li>
								<li>&nbsp;&nbsp;&nbsp;&middot; &middot; &middot;&nbsp;&nbsp;&nbsp;</li>
							<?php } ?>
							<?php for ($x = max($page - 2, 0); $x < min($page + 2, $nPages); $x++) { ?>
							<li<?php if ($x + 1 == $page) { echo " class='active'"; } ?>><a href="/<?php echo $currentURL[3]; ?>/<?php echo $currentURL[4]; ?>/<?php echo ($x + 1) . $suffix; ?>"><?php echo ($x + 1); ?></a></li>
							<?php } ?>
							<?php if ($page < $nPages - 2) { ?>
								<li>&nbsp;&nbsp;&nbsp;&middot; &middot; &middot;&nbsp;&nbsp;&nbsp;</li>
								<li><a href="/<?php echo $currentURL[3]; ?>/<?php echo $currentURL[4]; ?>/<?php echo $nPages . $suffix; ?>"><?php echo ($nPages); ?></a></li>
							<?php } ?>
						<?php } else { ?>
						<?php for ($x = 0; $x < $nPages; $x++) { ?>
						<li<?php if ($x + 1 == $page) { echo " class='active'"; } ?>><a href="/<?php echo $currentURL[3]; ?>/<?php echo $currentURL[4]; ?>/<?php echo ($x + 1) . $suffix; ?>"><?php echo ($x + 1); ?></a></li>
						<?php } } ?>
						<?php if ($nextLink) { ?><li>
							<a href="<?php echo $nextLink; ?>"><i class="ion ion-ios-arrow-forward"></i></a>
						</li><?php } ?>
					</ul>
					<?php } ?>
			</div>
			<div class="col-md-4">
				<form onsubmit="window.location.href = '/search/' + encodeURIComponent(document.querySelector('.searchinput').value); return false" class="mb-4">
				<div class="input-group">
					<input type="text" class="form-control searchinput border-secondary" placeholder="Search for startups..." value="<?php echo urldecode($currentURL[4]) === "all" || $currentURL[3] != "search" ? "" : urldecode($currentURL[4]); ?>"<?php echo $currentURL[3] == "search" ? "autofocus" : ""; ?>>
					<span class="input-group-btn">
						<button class="btn border-secondary border-left-0" type="submit"><i class="ion ion-md-search" aria-label="Search"></i></button>
					</span>
				</div>
			</form>
				<div class="card mb-4">
					<div class="card-body">
						<?php display('<h4 class="card-title border pb-2 border-top-0 border-left-0 border-right-0 text-uppercase smaller">Share%s %s%s</h4>', $type == "city" ? " Startups in " : " ", $city["name"], $type == "city" ? "" : " Startups"); ?>
						<div class="row">
							<div class="col">
								<a target="_blank" href="https://twitter.com/share?text=<?php echo urlencode("#MadewithLoveinIndia @mwlii"); ?>&url=<?php echo urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>" class="btn btn-twitter btn-block">
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
				<?php
					if ($currentURL[4] != "all" && $currentURL[3] != "search") {
						$info = DB::queryFirstRow("SELECT intro FROM descriptions WHERE title=%s", $currentURL[4])["intro"];
						if (!$info) {
							$apiURL = "https://en.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro=&explaintext=&titles=" . ucfirst(str_replace("-", "+", $currentURL[4]));
							$content = json_decode(file_get_contents($apiURL));
							$a = 0;
							foreach ($content->query->pages as $page => $val) {
								if ($a == 0) {
									$info = trim(preg_replace("/\([^)]+\)/","", explode(".", $val->extract)[0])) . ".";
									$info = str_replace("()", "", $info);
									$info = str_replace(" ,", ",", $info);
									if (strpos($info, "From a related word or phrase") == false) {
										$info = ".";
									}
									DB::insert("descriptions", [
										"title" => $currentURL[4],
										"intro" => $info
									]);
									$a++;
								}
							}
						}
						if ($info != ".") {
				?>
				<div class="card mb-4">
					<div class="card-body">
						<h4 class="card-title border pb-2 border-top-0 border-left-0 border-right-0 text-uppercase smaller">About this Topic</h4>
						<?php echo "<p>" . $info . "</p>"; ?>
						<p class="card-text small text-muted">Content licensed <a target="_blank" class="text-dark" href="https://creativecommons.org/licenses/by-sa/3.0/">CC BY-SA</a> from <a target="_blank" class="text-dark" href="https://en.wikipedia.org/w/index.php?search=<?php echo $currentURL[4]; ?>">Wikipedia</a>.</p>
					</div>
				</div> <?php } } ?>
				<div class="card mb-4">
					<div class="card-body">
						<h4 class="card-title border pb-2 border-top-0 border-left-0 border-right-0 text-uppercase smaller">Community Page</h4>
						<p class="card-text">This page is owned by the community. To modify or add to the information, you can <a href="#">suggest a change</a>.</p>
						<p class="card-text small text-muted">This page generated based on what Made with Love in India users are talking about.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<?php getFooter(); ?>