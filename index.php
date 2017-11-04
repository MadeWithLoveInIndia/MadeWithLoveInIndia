<?php
	include "database.php";
	include "header.php";
	getHeader("Page", "Home");
	$x = DB::query("SELECT city FROM startups GROUP BY city");
	$cities = [];
	foreach($x as $y) {
		$a = DB::queryFirstRow("SELECT * FROM cities WHERE name=%s", $y["city"]);
		$n = DB::queryFirstRow("SELECT COUNT(*) AS a FROM startups WHERE city=%s", $y["city"])["a"];
		array_push($cities, [
			"name" => $a["name"],
			"nStartups" => $n,
			"tagline" => $a["state"],
			"slug" => urlify($a["name"]),
			"city" => $y["city"]
		]);
	}
	$sortArray = [];
	foreach($cities as $person) {
		foreach($person as $key => $value) {
			if (!isset($sortArray[$key])) {
				$sortArray[$key] = [];
			}
			$sortArray[$key][] = $value;
		}
	}
	$orderby = "nStartups";
	array_multisort($sortArray[$orderby], SORT_DESC, $cities);
?>
<main id="content">
	<div class="container pt-4 mt-4 pb-4">
		<div class="row justify-content-center text-center">
			<div class="col-md-6">
				<p class="lead">Made with Love in India is an initiative is a movement to celebrate, promote, and build a brand &mdash; India.</p>
				<p>Find startups using the Made with Love in India badge, connect with entrepreneurs, and share your startup story.</p>
				<div class="mt-3">
					<?php if (isset($_SESSION["user"])) { ?>
						<a href="/submit" class="btn btn-danger">Submit Startup</a>
					<?php } else { ?>
						<a href="/register" class="btn btn-danger">Register Now</a>
					<?php } ?>
					<a href="/startups/all/1" class="btn btn-outline-danger ml-2">Explore Startups</a>
				</div>
			</div>
		</div>
		<section>
			<h2 class="h6 text-uppercase mt-5 mb-3">Recently Featured</h2>
			<div class="row">
				<div class="col-md-4 d-flex mb-4 mb-md-0">
					<a href="/startup/oswald-labs" class="card">
						<img alt="" class="card-img-top" src="/assets/uploads/cached/screenshots/oswald-labs.png">
						<div class="card-body d-flex flex-column">
							<h3 class="h5 mb-1">
								<span>Oswald Labs</span>
								<span class="badges">
									<span data-toggle="tooltip" data-placement="top" title="" data-original-title="Verified page"><i class="ion ion-md-checkmark-circle ml-1 checkbox-icon text-success"></i></span>
								</span>
							</h3>
							<p class="text-muted mb-2">Accessibility technology for the next billion users</p>
							<div class="startup-tags mt-auto">
								<span class="badge badge-light">Delhi</span>
								<span class="badge badge-light">Accessibility</span>
								<span class="badge badge-light">Mobile</span>
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-4 d-flex mb-4 mb-md-0">
					<a href="/startup/oswald-labs" class="card">
						<img alt="" class="card-img-top" src="/assets/uploads/cached/screenshots/undercult.png">
						<div class="card-body d-flex flex-column">
							<h3 class="h5 mb-1">
								<span>Undercult</span>
								<span class="badges"></span>
							</h3>
							<p class="text-muted mb-2">Indie music collective for charity</p>
							<div class="startup-tags mt-auto">
								<span class="badge badge-light">Delhi</span>
								<span class="badge badge-light">Accessibility</span>
								<span class="badge badge-light">Mobile</span>
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-4 d-flex mb-4 mb-md-0">
					<a href="/startup/oswald-labs" class="card">
						<img alt="" class="card-img-top" src="/assets/uploads/cached/screenshots/flairlift.png">
						<div class="card-body d-flex flex-column">
							<h3 class="h5 mb-1">
								<span>Flairlift</span>
								<span class="badges">
									<span data-toggle="tooltip" data-placement="top" title="" data-original-title="Verified page"><i class="ion ion-md-checkmark-circle ml-1 checkbox-icon text-success"></i></span>
								</span>
							</h3>
							<p class="text-muted mb-2">Accessibility technology for the next billion users</p>
							<div class="startup-tags mt-auto">
								<span class="badge badge-light">Delhi</span>
								<span class="badge badge-light">Accessibility</span>
								<span class="badge badge-light">Mobile</span>
							</div>
						</div>
					</a>
				</div>
			</div>
		</section>
		<section>
			<h2 class="h6 text-uppercase mt-5 mb-3">Startup Cities</h2>
			<div class="row">
				<?php $countCities = 0; foreach ($cities as $city) { if ($countCities < 5) { $countCities++; $city["name"] = $city["name"] === "Delhi" ? "New Delhi" : $city["name"]; ?>
				<div class="col-6 col-md-2 d-flex mb-4 mb-md-0">
					<a href="/city/<?php echo ($city['slug']); ?>" class="card">
						<?php display('<img alt="%s" src="/assets/uploads/cities/%s_%s.jpg">', $city["name"], md5($city["slug"]), $city["slug"]); ?>
						<div class="card-body">
							<?php display('<div class="bigger text-truncate">%s</div>', $city["name"]); ?>
							<?php display('<div class="text-muted mb-2 text-truncate">%s</div>', $city["tagline"]); ?>
							<div class="startup-tags">
								<?php display('<span class="badge badge-light">%s</span>', $city["nStartups"] . " startup" . ($city["nStartups"] == 1 ? "" : "s")); ?>
							</div>
						</div>
					</a>
				</div>
				<?php } } ?>
				<div class="col-6 col-md-2 d-flex">
					<a href="/cities" class="card d-flex justify-content-center align-items-center text-muted" style="width: 100%">
						<i class="ion ion-ios-arrow-forward display-4 mb-2"></i>
						<p>More Cities</p>
					</a>
				</div>
			</div>
		</section>
		<section>
			<h2 class="h6 text-uppercase mt-5 mb-3">Our Favorites</h2>
			<div class="row">
				<div class="col-md-6 d-flex mb-4 mb-md-0">
					<a href="/startup/hike-messenger" class="card">
						<img alt="" class="card-img-top" src="/assets/uploads/cached/screenshots/hike-messenger.png">
						<div class="card-body row">
							<div class="ml-3 mr-2 mb-3 mb-md-0 startup-image">
								<img alt="Hike Messenger" src="/assets/uploads/logo/1e5cb7e03b41ac402b81b3526fe5756d_hike-messenger.jpg">
							</div>
							<div class="col">
								<h3 class="h5 mb-1">
									<span>Hike Messenger</span>
								</h3>
								<p class="text-muted mb-2">India's largest instant messaging service</p>
								<div class="startup-tags mt-auto">
									<span class="badge badge-light">Delhi</span>
									<span class="badge badge-light">Mobile App</span>
									<span class="badge badge-light">Android</span>
								</div>
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-6 d-flex mb-4 mb-md-0">
					<a href="/startup/snapdeal" class="card">
						<img alt="" class="card-img-top" src="/assets/uploads/cached/screenshots/snapdeal.png">
						<div class="card-body row">
							<div class="ml-3 mr-2 mb-3 mb-md-0 startup-image">
								<img alt="Hike Messenger" src="/assets/uploads/logo/053b9260269146ec901fbbdfd30ffde5_snapdeal.jpg">
							</div>
							<div class="col">
								<h3 class="h5 mb-1">
									<span>Snapdeal</span>
									<span class="badges"></span>
								</h3>
								<p class="text-muted mb-2">One of India's largest online marketplaces</p>
								<div class="startup-tags mt-auto">
									<span class="badge badge-light">Delhi</span>
									<span class="badge badge-light">Shopping</span>
									<span class="badge badge-light">E-commerce</span>
								</div>
							</div>
						</div>
					</a>
				</div>
			</div>
		</section>
		<section>
			<h2 class="h6 text-uppercase mt-5 mb-3">Popular Industries</h2>
			<div class="row">
				<?php foreach (DB::query("SELECT industry, COUNT(*) as nStartups FROM startups GROUP BY industry ORDER BY COUNT(*) DESC LIMIT 5") as $city) { ?>
				<div class="col-6 col-md-2 d-flex mb-4 mb-md-0">
					<a href="/industry/<?php echo slugify($city['industry']); ?>" class="card">
						<?php display('<img alt="%s" src="/assets/uploads/industries/%s_%s.jpg">', $city["industry"], md5($city["industry"]), slugify($city["industry"])); ?>
						<div class="card-body">
							<?php display('<div class="bigger text-truncate mb-2">%s</div>', $city["industry"]); ?>
							<div class="startup-tags">
								<?php display('<span class="badge badge-light">%s</span>', $city["nStartups"] . " startup" . ($city["nStartups"] == 1 ? "" : "s")); ?>
							</div>
						</div>
					</a>
				</div>
				<?php } ?>
				<div class="col-6 col-md-2 d-flex">
					<a href="/cities" class="card d-flex justify-content-center align-items-center text-muted" style="width: 100%">
						<i class="ion ion-ios-arrow-forward display-4 mb-2"></i>
						<p>More Industries</p>
					</a>
				</div>
			</div>
		</section>
	</div>
</main>
<?php getFooter(); ?>