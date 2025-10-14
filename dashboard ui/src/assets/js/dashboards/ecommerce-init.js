"use strict";

/*
<--!----------------------------------------------------------------!-->
<--! Earning & Expense  !-->
<--!----------------------------------------------------------------!-->
*/
function initEarningExpense() {
	var options = {
		series: [
			{
				name: "Expenses",
				data: [20, 45, 10, 75, 35, 80, 40, 85, 45, 90, 55, 105],
				type: "area",
			},
			{
				name: "Earnings",
				data: [25, 60, 20, 90, 45, 100, 55, 105, 60, 115, 65, 120],
				type: "area",
			},
		],
		chart: {
			height: 290,
			width: "100%",
			type: "area",
			stacked: false,
			foreColor: "#7d8aa2",
			fontFamily: "Outfit, sans-serif",
			toolbar: {
				show: false,
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
				offsetX: -22,
				offsetY: 0,
			},
		},
		stroke: {
			width: 2,
			lineCap: "round",
			curve: "smooth",
			dashArray: [0, 5],
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
		colors: ["#015941", "#e49e3d"],
		dataLabels: {
			enabled: false,
		},
		fill: {
			type: "gradient",
			gradient: {
				shadeIntensity: 1,
				opacityFrom: 0.4,
				opacityTo: 0.3,
				stops: [0, 90, 100],
			},
		},
		tooltip: {
			theme: "dark",
			y: {
				formatter: function (e) {
					return +e + "K";
				},
			},
		},
	};

	var chart = new ApexCharts(document.querySelector("#earning-expense-chart"), options);
	chart.render();
}

/*
<--!----------------------------------------------------------------!-->
<--! Growth Chart !-->
<--!----------------------------------------------------------------!-->
*/
function initGrowthChart() {
	var options = {
		chart: {
			height: 88,
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
				data: [0, 20, 10, 30, 20, 40],
			},
		],
		dataLabels: {
			enabled: false,
		},
		legend: {
			show: false,
		},
		xaxis: {
			categories: ["Sat", "Sun", "Mon", "Tue", "Wen", "Thu", "Fri"],
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
					return +e + "K";
				},
			},
		},
		markers: {
			size: 3.5,
			fillColor: "#e49e3d",
			strokeColors: "transparent",
			strokeWidth: 3.2,
			discrete: [
				{
					size: 5,
					shape: "circle",
					seriesIndex: 0,
					dataPointIndex: 5,
					fillColor: "#fff",
					strokeColor: "#e49e3d",
				},
			],
			hover: {
				size: 5.5,
			},
		},
	};

	var chart = new ApexCharts(document.querySelector("#growth-straight-chart"), options);
	chart.render();
}

/*
<--!----------------------------------------------------------------!-->
<--! Earning Chart !-->
<--!----------------------------------------------------------------!-->
*/
function initEarningChart() {
	var options = {
		series: [
			{
				name: "Earning",
				data: [10, 25, 11, 28, 12, 32, 20],
			},
		],
		chart: {
			height: 88,
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
				borderRadius: 2,
				endingShape: "rounded",
				columnWidth: "25%",
			},
		},
		dataLabels: {
			enabled: false,
		},
		legend: {
			show: false,
		},
		colors: ["#015941"],
		xaxis: {
			categories: ["Sat", "Sun", "Mon", "Tue", "Wen", "Thu", "Fri"],
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
		tooltip: {
			theme: "dark",
			y: {
				formatter: function (e) {
					return +e + "K";
				},
			},
		},
	};
	var chart = new ApexCharts(document.querySelector("#earning-bar-chart"), options);
	chart.render();
}

/*
<--!----------------------------------------------------------------!-->
<--! Sales Revenue !-->
<--!----------------------------------------------------------------!-->
*/
function initSalesRevenue() {
	var options = {
		series: [
			{
				name: "Total Sales",
				data: ["300", "325", "280", "350", "320", "315", "320"],
			},
			{
				name: "Total Revenue",
				data: ["-325", "-300", "-350", "-280", "-315", "-320", "-315"],
			},
		],
		chart: {
			type: "bar",
			height: 182,
			width: "100%",
			stacked: true,
			foreColor: "#7d8aa2",
			fontFamily: "Outfit, sans-serif",
			toolbar: {
				show: false,
			},
		},
		plotOptions: {
			bar: {
				borderRadius: 3,
				columnWidth: "15%",
				horizontal: false,
			},
		},
		colors: ["#015941", "#E4E8EF"],
		dataLabels: {
			enabled: false,
		},
		legend: {
			show: false,
		},
		xaxis: {
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
				top: -42,
				left: -12,
				right: 6,
				bottom: -16,
			},
		},
		tooltip: {
			theme: "dark",
			y: {
				formatter: function (e) {
					return +e + "K";
				},
			},
		},
	};
	var chart = new ApexCharts(document.querySelector("#sales-revenue-chart"), options);
	chart.render();
}

/*
<--!----------------------------------------------------------------!-->
<--! Sales Transactions  !-->
<--!----------------------------------------------------------------!-->
*/
function initTransactions() {
	var options = {
		chart: {
			height: 111,
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
			curve: "smooth",
			show: true,
			width: 2,
		},
		colors: ["#015941"],
		series: [
			{
				name: "Transactions",
				data: [2, 4, 1, 7, 3, 8],
				type: "area",
			},
		],
		dataLabels: {
			enabled: false,
		},
		legend: {
			show: false,
		},
		xaxis: {
			categories: ["Sat", "Sun", "Mon", "Tue", "Wen", "Thu", "Fri"],
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
				top: 0,
				left: 16,
				right: 24,
				bottom: 0,
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
					return +e + "K";
				},
			},
		},
	};

	var chart = new ApexCharts(document.querySelector("#sales-transactions-chart"), options);
	chart.render();
}

/*
<--!----------------------------------------------------------------!-->
<--! Initialize Functions !-->
<--!----------------------------------------------------------------!-->
*/
$(function () {
	initEarningExpense();
	initGrowthChart();
	initEarningChart();
	initSalesRevenue();
	initTransactions();
});
