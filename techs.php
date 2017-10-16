<?php 

	include "database.php";

	$industries = ["SmartClient", "Webix", "WinJS", "Gijgo", "Ample SDK", "Glow", "Lively Kernel", "Script.aculo.us", "YUI Library", "Google Closure Library", "Joose", "JsPHP", "Microsoft's Ajax library", "MochiKit", "PDF.js", "Rico", "Socket.IO", "Spry framework", "Underscore.js", "Cascade Framework", "jQuery Mobile", "Mustache", "Jinja-JS", "Twig.js", "Jasmine", "Mocha", "QUnit", "Tape", "Unit.js", "Aurelia", "Backbone.js", "Cappuccino", "Chaplin.js", "Echo", "Ember.js", "Enyo", "Ext JS", "Google Web Toolkit", "Inferno", "JavaScriptMVC", "Knockout", "MagJS", "Meteor", "Mojito", "MooTools", "Node.js", "OpenUI5 of SAP", "Prototype JavaScript Framework", "Rialto Toolkit", "SproutCore", "Strudel.js", "Vue.js", "Wakanda Framework", "Modernizr", "Cannon.js"];

	function slugify($text) {
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		$text = preg_replace('~[^-\w]+~', '', $text);
		$text = trim($text, '-');
		$text = preg_replace('~-+~', '-', $text);
		$text = strtolower($text);
		if (empty($text)) {
			return 'n-a';
		}
		return $text;
	}

	for ($i = 0; $i < sizeof($industries); $i++) {
		DB::insert("technologies", [
			"name" => $industries[$i],
			"slug" => slugify($industries[$i])
		]);
		echo "Done " . $industries[$i] . "<br>";
	}

?>