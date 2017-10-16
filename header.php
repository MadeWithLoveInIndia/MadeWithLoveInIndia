<?php
function getHeader($cat = null, $title = null) {
		if ($cat == "Cities") {
			$title = "Startups in " . $title;
		} else if ($cat == "Startups" || $cat == "Technologies") {
			$title .= " Startups";
		}
		if (isset($title)) {
			$title .= " &middot; Made with Love in India";
		} else {
			$title = "Made with Love in India";
		}
?>
<!doctype html>
<html lang="en" ng-app="love">

	<head>

		<base href="/">

		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title><?php echo $title; ?></title>

		<link rel="apple-touch-icon" sizes="180x180" href="/assets/icons/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/assets/icons/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="194x194" href="/assets/icons/favicon-194x194.png">
		<link rel="icon" type="image/png" sizes="192x192" href="/assets/icons/android-chrome-192x192.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/assets/icons/favicon-16x16.png">
		<link rel="manifest" href="/manifest.json">
		<link rel="mask-icon" href="/assets/icons/safari-pinned-tab.svg" color="#f44336">
		<link rel="shortcut icon" href="/assets/icons/favicon.ico">
		<meta name="apple-mobile-web-app-title" content="Made with ❤ in India">
		<meta name="application-name" content="Made with ❤ in India">
		<meta name="msapplication-TileColor" content="#f44336">
		<meta name="msapplication-TileImage" content="/assets/icons/mstile-144x144.png">
		<meta name="msapplication-config" content="/browserconfig.xml">
		<meta name="theme-color" content="#fafafa">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
		<link rel="stylesheet" href="https://anandchowdhary.github.io/ionicons-3-cdn/icons.css" integrity="sha384-+iqgM+tGle5wS+uPwXzIjZS5v6VkqCUV7YQ/e/clzRHAxYbzpUJ+nldylmtBWCP0" crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/css?family=Halant:300,400,500,600,700|Hind:300,400,500,600,700" rel="stylesheet">
		<link rel="stylesheet" href="/assets/css/design.css">

		<!-- <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.6/angular.min.js"></script>
		<script src="https://unpkg.com/angular-ui-router/release/angular-ui-router.min.js"></script>
		<script src="/app.js"></script> -->

	</head>

	<body>
<?php
		getNav($cat);
	}
	function getNav($x = null) {
		if (isset($x)) {
			$current = $x;
		}
?>

		<nav class="navbar navbar-expand-lg navbar-light bg-white love-navbar border border-top-0">
			<div class="container">
				<a class="navbar-brand" href="#">&hearts;</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
						<?php $listItem = "Startups"; ?>
						<li class="nav-item<?php if ($listItem == $current) { echo " active"; } ?>">
							<a class="nav-link" href="#">Startups</span></a>
						</li>
						<?php $listItem = "Cities"; ?>
						<li class="nav-item<?php if ($listItem == $current) { echo " active"; } ?>">
							<a class="nav-link" href="/cities">Cities</a>
						</li>
						<?php $listItem = "People"; ?>
						<li class="nav-item<?php if ($listItem == $current) { echo " active"; } ?>">
							<a class="nav-link" href="#">People</a>
						</li>
						<?php $listItem = "Benefits"; ?>
						<li class="nav-item<?php if ($listItem == $current) { echo " active"; } ?>">
							<a class="nav-link" href="#">Benefits</a>
						</li>
						<?php $listItem = "About"; ?>
						<li class="nav-item<?php if ($listItem == $current) { echo " active"; } ?>">
							<a class="nav-link" href="#">About</a>
						</li>
					</ul>
					<ul class="navbar-nav">
						<?php $listItem = "Login"; ?>
						<li class="nav-item<?php if ($listItem == $current) { echo " active"; } ?>">
							<a class="nav-link" href="/login">Login</a>
						</li>
						<?php $listItem = "Register"; ?>
						<li class="nav-item<?php if ($listItem == $current) { echo " active"; } ?>">
							<a class="nav-link" href="/register">Register</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="ion ion-ios-more zoomer"></i>
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
								<a class="dropdown-item" href="#">Action</a>
								<a class="dropdown-item" href="#">Another action</a>
								<a class="dropdown-item" href="#">Something else here</a>
							</div>
						</li>
					</ul>
					<a class="btn btn-outline-danger ml-2" href="/submit">Submit Startup</a>
				</div>
			</div>
		</nav>
<?php
	}
	function getFooter() {
?>
		<!-- <footer>
			<div class="login-intro text-center pt-5 pb-5 mt-5 border">
				<h3>Made with love, in India</h3>
				<p>Hello world</p>
			</div>
		</footer> -->

		<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
			<script> $(function () {
				$('[data-toggle="tooltip"]').tooltip();
			}) </script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/vibrant.js/1.0.0/Vibrant.min.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCuiZevIb1G87KAoLRSECEdWNBQ06JCMjU&libraries=places&callback=initMap" async defer></script>
		<script>
			$(".startup-image img").on("load", function() {
				var vibrant = new Vibrant($(".startup-image img")[0]);
				var swatches = vibrant.swatches();
				$(".btn-visit-website").css("background-color", "rgb(" + swatches.Vibrant.rgb[0] + ", " + swatches.Vibrant.rgb[1] + ", " + swatches.Vibrant.rgb[2] + ")");
				$(".btn-visit-website").css("border-color", "rgb(" + swatches.Vibrant.rgb[0] + ", " + swatches.Vibrant.rgb[1] + ", " + swatches.Vibrant.rgb[2] + ")");
			});
			function initMap() {
				if ($(".cityAutoComplete")[0]) {
					var options = {
						types: ["(cities)"],
						componentRestrictions: {country: "in"}
					}
					var autocomplete = new google.maps.places.Autocomplete($(".cityAutoComplete")[0], options);
				}
			}
		</script>

	</body>

</html>
<?php } ?>