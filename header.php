<?php
function getHeader($cat = null, $title = null, $next = null, $prev = null) {
		if ($cat == "Cities") {
			$title = "Startups in " . $title;
		} else if ($cat == "Technologies") {
			$title .= " Startups";
		} else if ($cat == "Startups") {
			// $title .= " Startups";
		} else if ($cat == "Page") {
			if ($title == "Home") {
				$title = null;
			}
		} else if ($cat == "People") {
			// $title .= "&rsquo;s Profile";
		}
		if (isset($title)) {
			$title .= " &middot; Made with Love in India";
		} else {
			$title = "Made with Love in India";
		}
		$metaDescription = "Founded in April 2013, the Made with Love in India initiative is a movement to celebrate, promote, and build a brand &mdash; India."
?>
<!doctype html>
<html lang="en" ng-app="love">

	<head>

		<base href="/">

		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title><?php echo $title; ?></title>
		<meta property="og:title" content="<?php echo $title; ?>">
		<meta http-equiv="content-type" content="text/html; charset=utf-8">

		<meta name="description" content="<?php echo $metaDescription; ?>">
		<meta property="og:description" content="<?php echo $metaDescription; ?>">

		<meta name="twitter:card" content="summary">
		<meta name="twitter:site" content="@mwlii">
		<meta name="twitter:creator" content="@AnandChowdhary">
		<meta property="og:image" content="IMAGE URL">

		<meta property="og:url" content="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
		<link rel="canonical" href="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">

		<?php if ($next) { ?>
		<link rel="next" href="<?php echo $next; ?>">
		<?php } if ($prev) { ?>
		<link rel="prev" href="<?php echo $prev; ?>">
		<?php } ?>

		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=ngkxyOrw9y">
		<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png?v=ngkxyOrw9y">
		<link rel="icon" type="image/png" sizes="194x194" href="/favicon-194x194.png?v=ngkxyOrw9y">
		<link rel="icon" type="image/png" sizes="192x192" href="/android-chrome-192x192.png?v=ngkxyOrw9y">
		<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png?v=ngkxyOrw9y">
		<link rel="manifest" href="/manifest.json?v=ngkxyOrw9y">
		<link rel="mask-icon" href="/safari-pinned-tab.svg?v=ngkxyOrw9y" color="#dc3545">
		<link rel="shortcut icon" href="/favicon.ico?v=ngkxyOrw9y">
		<meta name="apple-mobile-web-app-title" content="Made with Love in India">
		<meta name="application-name" content="Made with Love in India">
		<meta name="msapplication-TileColor" content="#dc3545">
		<meta name="msapplication-TileImage" content="/mstile-144x144.png?v=ngkxyOrw9y">
		<meta name="theme-color" content="#dc3545">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
		<link rel="stylesheet" href="https://anandchowdhary.github.io/ionicons-3-cdn/icons.css" integrity="sha384-+iqgM+tGle5wS+uPwXzIjZS5v6VkqCUV7YQ/e/clzRHAxYbzpUJ+nldylmtBWCP0" crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/css?family=Halant:300,400,500,600,700|Hind:300,400,500,600,700" rel="stylesheet">
		<link rel="stylesheet" href="/assets/css/design.css">

		<script src="https://www.google.com/recaptcha/api.js"></script>

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
				<a class="navbar-brand" href="/">Made with <i class="ion ion-md-heart red"></i> in India</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
						<?php $listItem = "Startups"; ?>
						<li class="nav-item<?php if ($listItem == $current) { echo " active"; } ?>">
							<a class="nav-link" href="/startups">Startups</span></a>
						</li>
						<?php $listItem = "Cities"; ?>
						<li class="nav-item<?php if ($listItem == $current) { echo " active"; } ?>">
							<a class="nav-link" href="/cities">Cities</a>
						</li>
						<?php $listItem = "People"; ?>
						<li class="nav-item<?php if ($listItem == $current) { echo " active"; } ?>">
							<a class="nav-link" href="/people">People</a>
						</li>
						<?php $listItem = "About"; ?>
						<li class="nav-item<?php if ($listItem == $current) { echo " active"; } ?>">
							<a class="nav-link" href="/about">About</a>
						</li>
					</ul>
					<?php if (isset($_SESSION["user"])) { ?>
					<ul class="navbar-nav">
						<?php $listItem = "Login"; ?>
						<li class="nav-item<?php if ($listItem == $current) { echo " active"; } ?>">
							<a class="nav-link" href="/profile/<?php echo $_SESSION["user"]["username"]; ?>"><?php echo $_SESSION["user"]["name"]; ?></a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="ion ion-ios-more zoomer"></i>
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
								<a class="dropdown-item" href="/responsibilities">Responsibilities</a>
								<a class="dropdown-item" href="/badges">Badges</a>
								<a class="dropdown-item" href="/industries">Industries</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="/settings">Settings</a>
								<a class="dropdown-item" href="<?php echo "/logout?returnto=$_SERVER[REQUEST_URI]"; ?>">Logout</a>
							</div>
						</li>
					</ul>
					<?php } else { ?>
					<ul class="navbar-nav">
						<?php $listItem = "Login"; ?>
						<li class="nav-item<?php if ($listItem == $current) { echo " active"; } ?>">
							<a class="nav-link" href="<?php echo "/login?returnto=$_SERVER[REQUEST_URI]"; ?>">Login</a>
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
								<a class="dropdown-item" href="/responsibilities">Responsibilities</a>
								<a class="dropdown-item" href="/badges">Badges</a>
								<a class="dropdown-item" href="/industries">Industries</a>
							</div>
						</li>
					</ul>
					<?php } ?>
					<a class="btn btn-outline-danger ml-2" href="/submit"><i class="ion ion-md-add-circle mr-2 zoomed"></i>Submit Startup</a>
				</div>
			</div>
		</nav>
<?php
	}
	function getFooter() {
?>
		<footer>
			<div class="login-intro text-center pt-5 pb-5 mt-5 border">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-md-6">
							<h3 class="mb-3">Join the Movement</h3>
							<p>If you use the <em>Made with Love in India</em> badge in your startup&rsquo;s website or products, submit it and get featured on our platform.</p>
							<p>Copy and paste the following code in your footer:</p>
							<input data-placement="top" title="Copied!" data-clipboard-target="#joinCode" id="joinCode" class="form-control mt-2" onclick="this.setSelectionRange(0, this.value.length)" readonly type="text" value='&lt;a href="https://madewithlove.org.in" target="_blank"&gt;Made with &lt;span style="color: #e74c3c"&gt;&amp;hearts;&lt;/span&gt; in India&lt;/a&gt;'>
							<a href="/submit" class="btn btn-outline-danger mt-3">Submit Startup <i class="ion ion-md-arrow-forward ml-1"></i></a>
						</div>
					</div>
				</div>
			</div>
			<div id="colophon">
				<div class="container pt-5 pb-5">
					<div class="row">
						<div class="col-6 col-md-3">
							<h4 class="card-title pb-2 mb-0 bigger">Find Startups</h4>
							<ul>
								<li><a href="/startups">Top Startups in India</a></li>
								<li><a href="/cities">Startup Cities</a></li>
								<li><a href="/industries">Popular Industries</a></li>
								<li><a href="/tags">Tags &amp; Categories</a></li>
							</ul>
						</div>
						<div class="col-6 col-md-3">
							<h4 class="card-title pb-2 mb-0 bigger">Learn More</h4>
							<ul>
								<li><a href="/about">About the Initiative</a></li>
								<li><a href="mailto:hello@madewithlove.org.in?subject=Work@MadewithLoveinIndia">Work with Us</a></li>
								<li><a href="/responsibilities">Responsibilities</a></li>
								<li><a href="/badges">Earn Badges</a></li>
							</ul>
						</div>
						<div class="col-6 col-md-3 mt-5 mt-md-0">
							<h4 class="card-title pb-2 mb-0 bigger">Policies</h4>
							<ul>
								<li><a href="/terms">Terms of Use</a></li>
								<li><a href="/privacy">Privacy Policy</a></li>
								<li><a href="/cookies">Cookie Policy</a></li>
								<li><a href="/a11y">A11Y Statement</a></li>
							</ul>
						</div>
						<div class="col-6 col-md-3 mt-5 mt-md-0">
							<p>Founded in April 2013, the Made with Love in India initiative is a movement to celebrate, promote, and build a brand — India.</p>
							<p><a href="/about">Learn more about us <i class="ion ion-md-arrow-forward ml-1"></i></a></p>
						</div>
					</div>
				</div>
				<div class="pb-5 text-center">
					<p>&copy; 2013&ndash;<?php echo date("Y"); ?> &middot; <a href="/" class="text-dark">Made with <i class="ion ion-md-heart red"></i> in India</a></p>
				</div>
			</div>
		</footer>

		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.7.1/clipboard.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/clipboard@1/dist/clipboard.min.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCuiZevIb1G87KAoLRSECEdWNBQ06JCMjU&libraries=places&callback=initMap" async defer></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/jquery.easy-autocomplete.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/vibrant.js/1.0.0/Vibrant.min.js"></script>
		<script src="/assets/js/min/download-min.js"></script>
		<script src="/assets/js/min/app-min.js"></script>

	</body>

</html>
<?php } ?>