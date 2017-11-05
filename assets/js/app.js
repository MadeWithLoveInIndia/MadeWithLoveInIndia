var clipboard = new Clipboard("#joinCode");
clipboard.on("success", function() {
	$("#joinCode").attr("data-toggle", "tooltip");
	$("#joinCode").tooltip();
	$("#joinCode").tooltip("show");
});
$("#industry").easyAutocomplete({
	url: "/assets/json/industries.json"
});
$("#technology").easyAutocomplete({
	url: "/assets/json/tech.json"
});
function deleteStory(id) {
	$.get("/addstory.php?id=" + id).always(function() {
		$("form").submit();
	});
}
function refreshShots(id) {
	$.get("/refreshstory.php?id=" + id).always(function() {
		$("form").submit();
	});
}
(function () {
	var options = {
		url: function(q) {
			return "api/people?q=" + q;
		},
		getValue: "id",
		cssClasses: "sheroes",
		// template: {
		// 	type: "iconLeft",
		// 	fields: {
		// 		iconSrc: "icon"
		// 	}
		// },
		template: {
			type: "custom",
			method: function(value, item) {
				return '<div class="row">' + 
					'<div class="startup-image.hero-pic ml-3 mr-3">' + 
						'<img class="rounded-circle" alt="Anand Chowdhary" src="' + item.icon + '" style="height: 50px; width: 50px">' +
					'</div>' + 
					'<div class="startup-info col">' + 
						'<h3 class="h5 mb-1" style="width: 100%">' + item.name + '</h3>' + 
						'<p class="text-muted mb-1" style="width: 100%">' + item.shortbio + '</p>' +
					'</div>' + 
				'</div>';
			}
		},
		list: {
			onChooseEvent: function(x) {
				console.log(x);
			},
			showAnimation: {
				type: "slide"
			},
			hideAnimation: {
				type: "slide"
			}
		}
	};
	$(".userAutocomplete").easyAutocomplete(options);
})();

function initMap() {
	if ($(".cityAutoComplete")[0]) {
		var options = {
			types: ["(cities)"],
			componentRestrictions: {country: "in"}
		}
		var autocomplete = new google.maps.places.Autocomplete($(".cityAutoComplete")[0], options);
	}
	initMap2();
}
function initMap2() {
	if ($(".schoolAutoComplete")[0]) {
		var options = {
			types: ["establishment"],
		}
		var autocomplete = new google.maps.places.Autocomplete($(".schoolAutoComplete")[0], options);
	}
}

$(function () {
	$('[data-toggle="tooltip"]').tooltip();
	if ($(".startup-image.hero-pic img").length > 0) {
		$(".startup-image.hero-pic img").on("load", function() {
			var vibrant = new Vibrant($(".startup-image.hero-pic img")[0]);
			var swatches = vibrant.swatches();
			$(".btn-visit-website.btn-out").css("background-color", "rgb(" + swatches.Vibrant.rgb[0] + ", " + swatches.Vibrant.rgb[1] + ", " + swatches.Vibrant.rgb[2] + ")");
			$(".btn-visit-website.btn-out").css("border-color", "rgb(" + swatches.Vibrant.rgb[0] + ", " + swatches.Vibrant.rgb[1] + ", " + swatches.Vibrant.rgb[2] + ")");
			$(".btn-visit-website.btn-out").mouseover(function() {
				$(".btn-visit-website.btn-out").css("background-color", "rgb(" + Math.max(0, swatches.Vibrant.rgb[0] - 40) + ", " + Math.max(0, swatches.Vibrant.rgb[1] - 40) + ", " + Math.max(swatches.Vibrant.rgb[2] - 40) + ")");
				$(".btn-visit-website.btn-out").css("border-color", "rgb(" + Math.max(0, swatches.Vibrant.rgb[0] - 40) + ", " + Math.max(0, swatches.Vibrant.rgb[1] - 40) + ", " + Math.max(swatches.Vibrant.rgb[2] - 40) + ")");
			});
			$(".btn-visit-website.btn-out").mouseout(function() {
				$(".btn-visit-website.btn-out").css("background-color", "rgb(" + swatches.Vibrant.rgb[0] + ", " + swatches.Vibrant.rgb[1] + ", " + swatches.Vibrant.rgb[2] + ")");
				$(".btn-visit-website.btn-out").css("border-color", "rgb(" + swatches.Vibrant.rgb[0] + ", " + swatches.Vibrant.rgb[1] + ", " + swatches.Vibrant.rgb[2] + ")");
			});
		});
	}
})