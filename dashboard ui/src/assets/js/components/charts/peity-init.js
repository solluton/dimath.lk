"use strict";

// Initialize Pie Charts
function initPieCharts() {
	$("span.pie").peity("pie", {
		width: 50,
		height: 50,
		fill: function (_, i, all) {
			var g = parseInt((i / all.length) * 255);
			return "rgb(60, " + g + ", 230)";
		},
	});
}

// Initialize Donut Charts
function initDonutCharts() {
	$("span.donut").peity("donut", {
		width: 50,
		height: 50,
		fill: function (_, i, all) {
			var g = parseInt((i / all.length) * 255);
			return "rgb(60, " + g + ", 230)";
		},
	});
}

// Initialize Line Charts
function initLineCharts() {
	$("span.line").peity("line", {
		width: 50,
		height: 50,
		stroke: ["#015941"],
	});
}

// Initialize Bar Charts
function initBarCharts() {
	$("span.bar").peity("bar", {
		width: 50,
		height: 50,
		fill: ["#015941"],
	});
}

// Initialize Data Attributes
function initDataAttributes() {
	$(".data-attributes span").peity("donut");
}

// Initialize Dynamic Colours
function initDynamicColours() {
	$(".bar-colours-1").peity("bar", {
		width: 50,
		height: 50,
		fill: ["#d13b4c", "#25b865", "#015941"],
	});

	$(".bar-colours-2").peity("bar", {
		width: 50,
		height: 50,
		fill: function (value) {
			return value > 0 ? "#25b865" : "#d13b4c";
		},
	});

	$(".bar-colours-3").peity("bar", {
		width: 50,
		height: 50,
		fill: function (_, i, all) {
			var g = parseInt((i / all.length) * 255);
			return "rgb(255, " + g + ", 0)";
		},
	});

	$(".pie-colours-1").peity("pie", {
		width: 50,
		height: 50,
		fill: ["#41b2c4", "#e83e8c", "#ffa21d", "#283c50"],
	});

	$(".pie-colours-2").peity("pie", {
		width: 50,
		height: 50,
		fill: function (_, i, all) {
			var g = parseInt((i / all.length) * 255);
			return "rgb(255, " + g + ", 0)";
		},
	});
}

// Initialize Updating Charts
function initUpdatingCharts() {
	var updatingChart = $(".updating-chart").peity("line", {
		width: 320,
		height: 79,
		stroke: ["#015941"],
	});

	setInterval(function () {
		var random = Math.round(Math.random() * 10);
		var values = updatingChart.text().split(",");
		values.shift();
		values.push(random);

		updatingChart.text(values.join(",")).change();
	}, 1000);
}

//Public method to initialize all charts
(function () {
	initPieCharts();
	initDonutCharts();
	initLineCharts();
	initBarCharts();
	initDataAttributes();
	initDynamicColours();
	initUpdatingCharts();
})();
