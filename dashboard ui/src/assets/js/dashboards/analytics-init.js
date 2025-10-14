"use strict";

/*
<--!----------------------------------------------------------------!-->
<--! Bounce Rate !-->
<--!----------------------------------------------------------------!-->
*/
function initBounceRate() {
	var options = {
		chart: {
			type: "area",
			height: 60,
			sparkline: {
				enabled: true,
			},
		},
		series: [
			{
				name: "Bounce Rate (Avg)",
				data: [25, 60, 20, 90, 45, 100, 45, 100, 55],
			},
		],
		stroke: {
			width: 1,
			curve: "smooth",
		},
		fill: {
			opacity: [0.85, 0.25, 1, 1],
			gradient: {
				inverseColors: false,
				shade: "light",
				type: "vertical",
				opacityFrom: 0.5,
				opacityTo: 0.1,
				stops: [0, 65, 100],
			},
		},
		yaxis: {
			min: 0,
		},
		colors: ["#25b865"],
		tooltip: {
			theme: "dark",
			y: {
				formatter: function (e) {
					return +e + "K";
				},
			},
		},
	};
	var chart = new ApexCharts(document.querySelector("#bounce-rate"), options);
	chart.render();
}

/*
<--!----------------------------------------------------------------!-->
<--! Page Views !-->
<--!----------------------------------------------------------------!-->
*/
function initPageViews() {
	var options = {
		chart: {
			type: "area",
			height: 60,
			sparkline: {
				enabled: true,
			},
		},
		series: [
			{
				name: "Page Views (Avg)",
				data: [25, 60, 20, 90, 45, 100, 45, 100, 55],
			},
		],
		stroke: {
			width: 1,
			curve: "smooth",
		},
		fill: {
			opacity: [0.85, 0.25, 1, 1],
			gradient: {
				inverseColors: false,
				shade: "light",
				type: "vertical",
				opacityFrom: 0.5,
				opacityTo: 0.1,
				stops: [0, 65, 100],
			},
		},
		yaxis: {
			min: 0,
		},
		colors: ["#015941"],
		tooltip: {
			theme: "dark",
			y: {
				formatter: function (e) {
					return +e + "K";
				},
			},
		},
	};
	var chart = new ApexCharts(document.querySelector("#page-views"), options);
	chart.render();
}

/*
<--!----------------------------------------------------------------!-->
<--! Site Impression !-->
<--!----------------------------------------------------------------!-->
*/
function initSiteImpressions() {
	var options = {
		chart: {
			type: "area",
			height: 60,
			sparkline: {
				enabled: true,
			},
		},
		series: [
			{
				name: "Site Impression (Avg)",
				data: [25, 60, 20, 90, 45, 100, 45, 100, 55],
			},
		],
		stroke: {
			width: 1,
			curve: "smooth",
		},
		fill: {
			opacity: [0.85, 0.25, 1, 1],
			gradient: {
				inverseColors: false,
				shade: "light",
				type: "vertical",
				opacityFrom: 0.5,
				opacityTo: 0.1,
				stops: [0, 65, 100],
			},
		},
		yaxis: {
			min: 0,
		},
		colors: ["#e49e3d"],
		tooltip: {
			theme: "dark",
			y: {
				formatter: function (e) {
					return +e + "K";
				},
			},
		},
	};
	var chart = new ApexCharts(document.querySelector("#site-impressions"), options);
	chart.render();
}

/*
<--!----------------------------------------------------------------!-->
<--! Conversions Rate !-->
<--!----------------------------------------------------------------!-->
*/
function initConversionsRate() {
	var options = {
		chart: {
			type: "area",
			height: 60,
			sparkline: {
				enabled: true,
			},
		},
		series: [
			{
				name: "Conversions Rate (Avg)",
				data: [25, 60, 20, 90, 45, 100, 45, 100, 55],
			},
		],
		stroke: {
			width: 1,
			curve: "smooth",
		},
		fill: {
			opacity: [0.85, 0.25, 1, 1],
			gradient: {
				inverseColors: false,
				shade: "light",
				type: "vertical",
				opacityFrom: 0.5,
				opacityTo: 0.1,
				stops: [0, 65, 100],
			},
		},
		yaxis: {
			min: 0,
		},
		colors: ["#d13b4c"],
		tooltip: {
			theme: "dark",
			y: {
				formatter: function (e) {
					return +e + "K";
				},
			},
		},
	};
	var chart = new ApexCharts(document.querySelector("#conversions-rate"), options);
	chart.render();
}

/*
<--!----------------------------------------------------------------!-->
<--! Visitors Overview !-->
<--!----------------------------------------------------------------!-->
*/
function initVisitorsOverview() {
	var options = {
		chart: {
			height: 310,
			width: "100%",
			type: "bar",
			stacked: false,
			foreColor: "#7d8aa2",
			fontFamily: "Outfit, sans-serif",
			toolbar: {
				show: false,
			},
		},
		plotOptions: {
			bar: {
				horizontal: false,
				borderRadius: 3,
				endingShape: "rounded",
				columnWidth: "30%",
			},
		},
		xaxis: {
			categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
			axisBorder: {
				show: false,
			},
			axisTicks: {
				show: false,
			},
		},
		yaxis: {
			labels: {
				formatter: function (e) {
					return +e + "K";
				},
			},
		},
		grid: {
			padding: {
				left: 0,
				right: 0,
			},
			strokeDashArray: 3,
			borderColor: "rgba(170, 180, 195, 0.25)",
		},
		legend: {
			show: false,
		},
		colors: ["#015941", "#E4E8EF"],
		dataLabels: {
			enabled: false,
		},
		series: [
			{
				name: "Unique Visitors",
				data: [10, 25, 11, 28, 12, 32, 10, 25, 11, 28, 12, 32],
			},
			{
				name: "Returning Visitors",
				data: [20, 11, 26, 10, 30, 14, 20, 11, 26, 10, 30, 14],
			},
		],
		tooltip: {
			theme: "dark",
			y: {
				formatter: function (e) {
					return +e + "K";
				},
			},
		},
	};
	var chart = new ApexCharts(document.querySelector("#visitors-overview-statistics-chart"), options);
	chart.render();
}

/*
<--!----------------------------------------------------------------!-->
<--! Traffic Channel !-->
<--!----------------------------------------------------------------!-->
*/
function initTrafficChannel() {
	var options = {
		chart: {
			width: 275,
			type: "donut",
		},
		dataLabels: {
			enabled: false,
		},
		series: [20, 15, 10, 18],
		labels: ["Organic Search", "Social Media", "Referrals", "Others"],
		colors: ["#015941", "#d13b4c", "#25b865", "#e49e3d"],
		stroke: {
			width: 0,
			lineCap: "round",
		},
		legend: {
			show: false,
		},
		plotOptions: {
			pie: {
				donut: {
					size: "85%",
					labels: {
						show: false,
						name: {
							show: false,
							fontSize: "16px",
							colors: "#A0ACBB",
							fontFamily: "Outfit",
						},
						value: {
							show: false,
							fontSize: "30px",
							fontFamily: "Outfit",
							color: "#A0ACBB",
							formatter: function (o) {
								return o;
							},
						},
					},
				},
			},
		},
		responsive: [
			{
				breakpoint: 380,
				options: {
					chart: {
						width: 280,
					},
					legend: {
						show: false,
					},
				},
			},
		],
		tooltip: {
			theme: "dark",
			y: {
				formatter: function (o) {
					return +o + "%";
				},
			},
			style: {
				colors: "#A0ACBB",
				fontFamily: "Outfit",
			},
		},
	};
	var chart = new ApexCharts(document.querySelector("#traffic-channel-donut"), options);
	chart.render();
}

/*
<--!----------------------------------------------------------------!-->
<--! Marketing Gaol Chart !-->
<--!----------------------------------------------------------------!-->
*/
function initMarketingGaolChart() {
	var options = {
		chart: {
			height: 100,
			width: "100%",
			type: "area",
			stacked: false,
			foreColor: "#7d8aa2",
			fontFamily: "Outfit, sans-serif",
			toolbar: {
				show: false,
			},
		},
		stroke: {
			curve: "straight",
			show: true,
			width: 2,
		},
		colors: ["#015941"],
		series: [
			{
				name: "Growth",
				data: [0, 15, 10, 20, 12, 25, 15, 30, 17, 35, 20, 40],
			},
		],
		dataLabels: {
			enabled: false,
		},
		legend: {
			show: false,
		},
		xaxis: {
			categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
			axisBorder: {
				show: false,
			},
			axisTicks: {
				show: false,
			},
			labels: {
				show: false,
			},
		},
		yaxis: {
			labels: {
				show: false,
			},
		},
		grid: {
			show: false,
			padding: {
				top: -12,
				left: -6,
				right: 6,
				bottom: -12,
			},
		},
		fill: {
			type: "gradient",
			gradient: {
				shadeIntensity: 1,
				opacityFrom: 0.4,
				opacityTo: 0.2,
				stops: [15, 120, 100],
			},
		},
		tooltip: {
			theme: "dark",
			y: {
				formatter: function (e) {
					return +e + "%";
				},
			},
		},
		markers: {
			size: 3.5,
			fillColor: "#015941",
			strokeColors: "transparent",
			strokeWidth: 3.2,
			discrete: [
				{
					size: 5,
					shape: "circle",
					seriesIndex: 0,
					dataPointIndex: 5,
					fillColor: "#fff",
					strokeColor: "#015941",
				},
			],
			hover: {
				size: 5.5,
			},
		},
	};

	var chart = new ApexCharts(document.querySelector("#marketing-gaol-chart"), options);
	chart.render();
}

/*
<--!----------------------------------------------------------------!-->
<--! Sessions Device Radar !-->
<--!----------------------------------------------------------------!-->
*/
function initSessionsDeviceRadar() {
	var options = {
		series: [
			{
				name: "Desktop",
				data: [80, 50, 30, 40, 100, 20],
			},
			{
				name: "Mobile",
				data: [20, 30, 40, 80, 20, 80],
			},
			{
				name: "Tablet",
				data: [44, 76, 78, 13, 43, 10],
			},
		],
		chart: {
			height: 325,
			type: "radar",
			toolbar: {
				show: false,
			},
		},
		colors: ["#3454D1", "#41B2C4", "#EA4D4D"],
		xaxis: {
			categories: ["Sun", "Mon", "Tue", "Wen", "Thu", "Fri"],
		},
		yaxis: {
			show: false,
		},
		stroke: {
			show: false,
		},
		tooltip: {
			theme: "dark",
			y: {
				formatter: function (o) {
					return +o + "K";
				},
			},
			style: {
				colors: "#64748b",
				fontFamily: "Outfit",
			},
		},
		legend: {
			show: false,
		},
	};

	var chart = new ApexCharts(document.querySelector("#sessions-device-radar"), options);
	chart.render();
}

/*
<--!----------------------------------------------------------------!-->
<--! Initialize Markers Vector Map !-->
<--!----------------------------------------------------------------!-->
*/
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
				fill: "#015941",
			},
		},
	];

	var map = new jsVectorMap({
		map: "world",
		zoomButtons: false,
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
				fill: "rgba(170, 180, 195, 0.25)",
			},
		},
		markerLabelStyle: {
			initial: {
				fontFamily: "Outfit",
				fontSize: 13,
				fontWeight: 500,
				fill: "#64748b",
			},
		},
		regionStyle: {
			initial: {
				fill: "rgba(170, 180, 195, 0.25)",
			},
		},
	});
}

/*
<--!----------------------------------------------------------------!-->
<--! Initialize Functions !-->
<--!----------------------------------------------------------------!-->
*/
$(function () {
	initBounceRate();
	initPageViews();
	initSiteImpressions();
	initConversionsRate();
	initVisitorsOverview();
	initTrafficChannel();
	initMarketingGaolChart();
	initSessionsDeviceRadar();
	initMarkersVectorMap();
});
