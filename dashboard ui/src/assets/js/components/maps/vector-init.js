"use strict";

// Initialize Basic Vector Map
function initBasicVectorMap() {
	var map = new jsVectorMap({
		map: "world",
		selector: "#basicVectorMap",
	});
}

// Initialize Markers Vector Map
function initMarkersVectorMap() {
	var markers = [
		{
			name: "Russia",
			coords: [61, 105],
			style: {
				fill: "#d13b4c",
			},
		},
		{
			name: "Geenland",
			coords: [72, -42],
			style: {
				fill: "#3dc7be",
			},
		},
		{
			name: "Canada",
			coords: [56, -106],
			style: {
				fill: "#ea4d4d",
			},
		},
		{
			name: "Palestine",
			coords: [31.5, 34.8],
			style: {
				fill: "#fd7e14",
			},
		},
		{
			name: "Brazil",
			coords: [-14.235, -51.9253],
			style: {
				fill: "#000000",
			},
		},
		{
			name: "China",
			coords: [35.8617, 104.1954],
			style: {
				fill: "#25b865",
			},
		},
		{
			name: "United States",
			coords: [37.0902, -95.7129],
			style: {
				image: "./../assets/images/general/pin.png",
			},
			offsets: [2, 2],
		},
	];

	var map = new jsVectorMap({
		map: "world",
		selector: "#markersVectorMap",
		markersSelectable: true,

		onMarkerSelected(index, isSelected, selectedMarkers) {
			console.log(index, isSelected, selectedMarkers);
		},

		labels: {
			markers: {
				render: function (marker) {
					return marker.name;
				},
			},
		},

		markers: markers,
		markerStyle: {
			hover: {
				stroke: "#DDD",
				strokeWidth: 3,
				fill: "#FFF",
			},
			selected: {
				fill: "#ff525d",
			},
		},
		markerLabelStyle: {
			initial: {
				fontFamily: "Outfit",
				fontSize: 13,
				fontWeight: 500,
				fill: "#35373e",
			},
		},
	});
}

// Initialize Lines Vector Map
function initLinesVectorMap() {
	var markers = [
		{ name: "Russia", coords: [61.524, 105.3188] },
		{ name: "Egypt", coords: [26.8206, 30.8025] },
		{ name: "Canada", coords: [56, -106], offsets: [-7, 12] },
		{ name: "United States", coords: [37.0902, -95.7129], offsets: [-7, 12] },
		{ name: "Brazil", coords: [-14.235, -51.9253] },
		{ name: "China", coords: [35.8617, 104.1954], offsets: [-7, 12] },
		{ name: "Australia", coords: [-25.2744, 133.7751], offsets: [7, 12] },
		{ name: "United Kingdom", coords: [55.3781, -3.436], offsets: [-7, -25] },
		{ name: "South Africa", coords: [-30.5595, 22.9375], offsets: [7, 12] },
	];

	var lines = [
		{ from: "Russia", to: "Egypt", style: { stroke: "#abb0b7", strokeWidth: 1.5 } },
		{ from: "Canada", to: "Russia", style: { stroke: "#abb0b7", strokeWidth: 1.5 } },
		{ from: "United States", to: "Russia", style: { stroke: "#abb0b7", strokeWidth: 1.5 } },
		{ from: "Brazil", to: "Russia", style: { stroke: "#abb0b7", strokeWidth: 1.5 } },
		{ from: "China", to: "Russia", style: { stroke: "#abb0b7", strokeWidth: 1.5 } },
		{ from: "Egypt", to: "Canada", style: { stroke: "#abb0b7", strokeWidth: 1.5 } },
		{ from: "Australia", to: "Russia", style: { stroke: "#abb0b7", strokeWidth: 1.5 } },
		{ from: "United Kingdom", to: "Russia", style: { stroke: "#abb0b7", strokeWidth: 1.5 } },
		{ from: "South Africa", to: "Russia", style: { stroke: "#abb0b7", strokeWidth: 1.5 } },
		{ from: "United States", to: "Brazil", style: { stroke: "#abb0b7", strokeWidth: 1.5 } },
		{ from: "Brazil", to: "China", style: { stroke: "#abb0b7", strokeWidth: 1.5 } },
		{ from: "Canada", to: "Australia", style: { stroke: "#abb0b7", strokeWidth: 1.5 } },
		{ from: "South Africa", to: "Egypt", style: { stroke: "#abb0b7", strokeWidth: 1.5 } },
	];

	new jsVectorMap({
		map: "world",
		selector: document.querySelector("#linesVectorMap"),

		labels: {
			markers: {
				render: function (marker) {
					return marker.name;
				},
				offsets: function (index) {
					return markers[index].offsets || [0, 0];
				},
			},
		},

		markers: markers,
		lines: lines,
		lineStyle: {
			animation: true,
			strokeDasharray: "6 3 6",
		},
		markerStyle: {
			initial: {
				r: 6,
				fill: "#1266f1",
				stroke: "#fff",
				strokeWidth: 3,
			},
		},
		markerLabelStyle: {
			initial: {
				fontSize: 13,
				fontWeight: 500,
				fill: "#35373e",
			},
		},
	});
}

// Initialize Events Vector Map
function initEventsVectorMap() {
	var markers = [
		{
			name: "Palestine",
			coords: [31.5, 34.8],
		},
		{
			name: "Russia",
			coords: [61, 105],
		},
		{
			name: "Geenland",
			coords: [72, -42],
		},
		{
			name: "Canada",
			coords: [56, -106],
		},
	];

	var map = new jsVectorMap({
		map: "world",
		selector: "#eventsVectorMap",

		regionsSelectable: true,
		markersSelectable: true,

		labels: {
			markers: {
				render: function (marker) {
					return marker.name;
				},
			},
		},

		markers: markers,

		onRegionSelected: function (index, isSelected, selectedRegions) {
			console.log(index, isSelected, selectedRegions);
		},
		onRegionTooltipShow: function (event, tooltip, index) {
			console.log(tooltip, index);
			tooltip.text(`<h6 class="text-white mb-0">${tooltip.text()} - Country</h6>` + `<p class="text-xs mb-0">This message is gonna appear when hovering over every single reion.</p>`, true);
		},
		onMarkerSelected: function (code, isSelected, selectedMarkers) {
			console.log(code, isSelected, selectedMarkers);
		},
		onMarkerTooltipShow: function (event, tooltip, code) {
			tooltip.text(tooltip.text() + " (Marked)");
		},
	});
}

// Initialize Series Vector Map
function initSeriesVectorMap() {
	var markers = [
		{
			name: "Palestine",
			coords: [31.5, 34.8],
		},
		{
			name: "Russia",
			coords: [61, 105],
		},
		{
			name: "Geenland",
			coords: [72, -42],
		},
		{
			name: "Canada",
			coords: [56, -106],
		},
	];

	var map = new jsVectorMap({
		map: "world",
		selector: "#seriesVectorMap",

		labels: {
			markers: {
				render: function (marker) {
					return marker.name;
				},
			},
		},

		markers: markers,
		markerStyle: {
			initial: {
				image: true,
			},
		},

		series: {
			markers: [
				{
					attribute: "image",
					legend: {
						title: "Some title!",
						vertical: true,
					},
					scale: {
						marker1title: {
							url: "./../assets/images/general/marker.png",
							offset: [10, 0],
						},
						marker2title: {
							url: "./../assets/images/general/marker2.png",
							offset: [0, 0],
						},
					},
					values: {
						0: "marker1title",
						1: "marker2title",
						2: "marker2title",
						3: "marker1title",
					},
				},
			],

			regions: [
				{
					attribute: "fill",
					legend: {
						title: "Something",
					},
					scale: {
						scale1: "#3454d1",
						scale2: "#d13b4c",
						scale3: "#25b865",
					},
					values: {
						US: "scale1",
						EG: "scale2",
						IT: "scale3",
						BR: "scale2",
					},
				},
			],
		},
	});
}

// Initialize Advanced Vector Map
function initAdvancedVectorMap() {
	var markers = [
		{
			name: "Russia",
			coords: [61, 105],
			style: {
				r: 10,
			},
		},
		{
			name: "Geenland",
			coords: [72, -42],
			style: {
				r: 11,
			},
		},
		{
			name: "Canada",
			coords: [56, -106],
			style: {
				r: 15,
			},
		},
		{
			name: "Palestine",
			coords: [31.5, 34.8],
			style: {
				r: 7,
			},
		},
		{
			name: "Brazil",
			coords: [-14.235, -51.9253],
		},
		{
			name: "China",
			coords: [35.8617, 104.1954],
			style: {
				image: "./../assets/images/general/pin.png",
			},
			offsets: [2, 2],
		},
	];

	var map = new jsVectorMap({
		map: "world",
		selector: "#advancedVectorMap",

		regionsSelectable: true,
		markersSelectable: true,

		onRegionSelected: function (index, isSelected, selectedRegions) {
			console.log(index, isSelected, selectedRegions);
		},
		onMarkerSelected: function (code, isSelected, selectedMarkers) {
			console.log(code, isSelected, selectedMarkers);
		},
		onRegionTooltipShow: function (event, tooltip, code) {
			if (code === "RU") {
				tooltip.getElement().innerHTML = tooltip.text() + " <b>(Hello Russia)</b>";
			}
		},
		onMarkerTooltipShow: function (event, tooltip, index) {
			tooltip.getElement().innerHTML = '<h6 class="text-white mb-0">' + tooltip.text() + "</h6>" + '<p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p><small class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit.</small>';
		},

		labels: {
			markers: {
				render: function (marker) {
					return marker.name;
				},
				offsets: function (index) {
					return markers[index].offsets || [0, 0];
				},
			},
			regions: {
				render: function (code) {
					var codes = ["EG", "KZ", "CN"];

					if (codes.indexOf(code) > -1) {
						return "";
					}
				},
			},
		},

		regionStyle: {
			selected: {
				fill: "#015941",
			},
		},
		regionLabelStyle: {},

		markers: markers,
		markerStyle: {
			initial: {
				fill: "#ff5566",
			},
			hover: {
				stroke: "#676767",
				fillOpacity: 1,
				strokeWidth: 2.5,
				fill: "#ff5566",
			},
			selected: {
				fill: "#ff9251",
			},
		},
		markerLabelStyle: {
			initial: {
				fontSize: 13,
				fontWeight: 500,
				fill: "#35373e",
			},
		},

		series: {
			markers: [
				{
					attribute: "fill",
					legend: {
						title: "Something (marker)",
						// vertical: true,
					},
					scale: {
						"Criteria one": "#ffd400",
						"Criteria two": "#4761ff",
					},
					values: {
						0: "Criteria one",
						1: "Criteria two",
						2: "Criteria two",
					},
				},
			],

			regions: [
				{
					attribute: "fill",
					attributes: {
						// EG: 'red'
					},
					legend: {
						title: "Some title (region)",
						vertical: true,
					},
					scale: {
						Criteria: "#4bdc77",
						"Another Criteria": "#ff5566",
					},
					values: {
						GB: "Another Criteria",
						MX: "Criteria",
						// LY: "Criteria",
					},
				},
			],
		},
	});

	function $(selector) {
		return document.querySelector(selector);
	}

	$("#reset").addEventListener("click", function () {
		map.reset();
	});

	$("#get-regions").addEventListener("click", function () {
		if (!map.getSelectedRegions().length) {
			alert("No regions selected");
		} else {
			alert(map.getSelectedRegions());
		}
	});

	$("#clear-regions").addEventListener("click", function () {
		map.clearSelectedRegions();
	});

	$("#get-markers").addEventListener("click", function () {
		var selectedMarkers = map.getSelectedMarkers();

		if (!selectedMarkers.length) {
			alert("No regions markers");
		} else {
			alert(selectedMarkers);
		}
	});

	$("#clear-markers").addEventListener("click", function () {
		map.clearSelectedMarkers();
	});

	$("#add-marker").addEventListener("click", function () {
		map.addMarkers({
			name: "Egypt",
			coords: [26.8, 30],
			offsets: [0, 0],
		});
	});

	$("#change-bg-color").addEventListener("click", function () {
		var colors = ["#015941", "#ff9251", "#56de80", "#FFF", "#000", "#f5d4f5"],
			index = Math.floor(Math.random() * colors.length - 1 + 1);
		map.setBackgroundColor(colors[index]);
	});
}

//Public method to initialize all charts
(function () {
	initBasicVectorMap();
	initMarkersVectorMap();
	initLinesVectorMap();
	initEventsVectorMap();
	initSeriesVectorMap();
	initAdvancedVectorMap();
})();
