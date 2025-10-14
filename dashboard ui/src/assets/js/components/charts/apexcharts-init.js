"use strict";

// Initialize Basic Line
function initGradientLine() {
	var options = {
		series: [
			{
				name: "Sales",
				data: [4, 3, 10, 9, 29, 19, 22, 9, 12, 7, 19, 5, 13, 9, 17, 2, 7, 5],
			},
		],
		chart: {
			height: 350,
			type: "line",
			foreColor: "#6c757d",
			fontFamily: "Outfit, sans-serif",
			toolbar: {
				show: false,
			},
		},
		forecastDataPoints: {
			count: 7,
		},
		stroke: {
			width: 5,
			curve: "smooth",
		},
		grid: {
			show: false,
		},
		markers: {
			size: 3,
		},
		xaxis: {
			type: "datetime",
			categories: ["1/11/2000", "2/11/2000", "3/11/2000", "4/11/2000", "5/11/2000", "6/11/2000", "7/11/2000", "8/11/2000", "9/11/2000", "10/11/2000", "11/11/2000", "12/11/2000", "1/11/2001", "2/11/2001", "3/11/2001", "4/11/2001", "5/11/2001", "6/11/2001"],
			tickAmount: 10,
			labels: {
				formatter: function (value, timestamp, opts) {
					return opts.dateFormatter(new Date(timestamp), "dd MMM");
				},
			},
			axisBorder: {
				show: false,
			},
			axisTicks: {
				show: false,
			},
		},
		fill: {
			type: "gradient",
			gradient: {
				shade: "dark",
				gradientToColors: ["#FDD835"],
				shadeIntensity: 1,
				type: "horizontal",
				opacityFrom: 1,
				opacityTo: 1,
				stops: [0, 100, 100, 100],
			},
		},
		yaxis: {
			min: -10,
			max: 40,
		},
		tooltip: {
			theme: "dark",
		},
	};

	var chart = new ApexCharts(document.querySelector("#gradientLine"), options);
	chart.render();
}

// Initialize Line with Data Labels
function initLineDataLabels() {
	var options = {
		series: [
			{
				name: "High - 2023",
				data: [28, 29, 33, 36, 32, 32, 33],
			},
			{
				name: "Low - 2023",
				data: [12, 11, 14, 18, 17, 13, 13],
			},
		],
		chart: {
			height: 350,
			type: "line",
			foreColor: "#6c757d",
			fontFamily: "Outfit, sans-serif",
			toolbar: {
				show: false,
			},
		},
		colors: ["#25b865", "#015941"],
		dataLabels: {
			enabled: true,
		},
		stroke: {
			curve: "smooth",
		},
		grid: {
			show: false,
		},
		markers: {
			size: 1,
		},
		xaxis: {
			categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
			title: {
				text: "Month",
			},
			axisBorder: {
				show: false,
			},
			axisTicks: {
				show: false,
			},
		},
		yaxis: {
			title: {
				text: "Temperature",
			},
			min: 5,
			max: 40,
		},
		legend: {
			position: "top",
			horizontalAlign: "right",
			floating: true,
			offsetY: -25,
			offsetX: -5,
		},
		tooltip: {
			theme: "dark",
		},
	};

	var chart = new ApexCharts(document.querySelector("#lineDataLabels"), options);
	chart.render();
}

// Initialize Basic Bar
function initBasicBar() {
	var options = {
		chart: {
			height: 350,
			type: "bar",
			foreColor: "#6c757d",
			fontFamily: "Outfit, sans-serif",
			toolbar: {
				show: false,
			},
		},
		stroke: {
			show: true,
			width: 2,
			colors: ["transparent"],
		},
		plotOptions: {
			bar: {
				borderRadius: 3,
				endingShape: "rounded",
				columnWidth: "35%",
				distributed: false,
				dataLabels: {
					position: "top",
				},
			},
		},
		dataLabels: {
			enabled: true,
			formatter: function (val) {
				return val + " K";
			},
			offsetY: 20,
		},
		colors: ["#e5e7eb", "#015941", "#e49e3d"],
		series: [
			{
				name: "Revenue",
				data: [20, 30, 40, 50, 46, 42, 38, 34, 30, 28, 26, 25],
			},
			{
				name: "Profite",
				data: [15, 25, 35, 45, 41, 38, 33, 28, 23, 18, 13, 10],
			},
			{
				name: "Expenses",
				data: [10, 20, 30, 40, 40, 30, 30, 20, 20, 10, 10, 5],
			},
		],
		xaxis: {
			categories: ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUE", "AUG", "SEP", "OCT", "NOV", "DEC"],
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
					return +e + " K";
				},
				offsetX: -5,
				offsetY: 0,
			},
		},
		grid: {
			show: false,
		},
		dataLabels: {
			enabled: false,
		},
		tooltip: {
			theme: "dark",
			y: {
				formatter: function (e) {
					return +e + " K";
				},
			},
		},
		legend: {
			show: false,
		},
	};
	var chart = new ApexCharts(document.querySelector("#basicBar"), options);
	chart.render();
}

// Initialize Column Data Labels
function initColumnDataLabels() {
	var options = {
		series: [
			{
				name: "Expenses",
				data: [50, 60, 70, 80, 140, 80, 70, 60, 50, 40, 30, 20],
			},
			{
				name: "Revenue",
				data: [60, 70, 80, 90, 150, 90, 80, 70, 60, 50, 40, 30],
			},
		],
		chart: {
			height: 350,
			type: "bar",
			foreColor: "#6c757d",
			fontFamily: "Outfit, sans-serif",
			toolbar: {
				show: false,
			},
		},
		stroke: {
			show: true,
			width: 3,
			colors: ["transparent"],
		},
		plotOptions: {
			bar: {
				borderRadius: 5,
				columnWidth: "70%",
				dataLabels: {
					position: "top",
				},
			},
		},
		colors: ["#ced4da", "#015941"],
		dataLabels: {
			enabled: true,
			formatter: function (val) {
				return val + "K";
			},
			offsetY: -20,
			style: {
				fontSize: "10px",
				colors: ["#adb5bd", "#015941"],
			},
		},
		grid: {
			show: false,
		},
		xaxis: {
			categories: ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUE", "AUG", "SEP", "OCT", "NOV", "DEC"],
			position: "bottom",
			axisBorder: {
				show: false,
			},
			axisTicks: {
				show: false,
			},
			crosshairs: {
				fill: {
					type: "gradient",
					gradient: {
						colorFrom: "#D8E3F0",
						colorTo: "#BED1E6",
						stops: [0, 100],
						opacityFrom: 0.4,
						opacityTo: 0.5,
					},
				},
			},
		},
		yaxis: {
			axisBorder: {
				show: false,
			},
			axisTicks: {
				show: false,
			},
			labels: {
				show: false,
				formatter: function (val) {
					return val + "K";
				},
			},
		},
		legend: {
			position: "top",
			horizontalAlign: "start",
		},
		tooltip: {
			theme: "dark",
		},
	};

	var chart = new ApexCharts(document.querySelector("#columnDataLabels"), options);
	chart.render();
}

// Initialize Stacked Columns
function initStackedColumns() {
	var options = {
		chart: {
			type: "bar",
			height: 350,
			stacked: true,
			foreColor: "#6c757d",
			fontFamily: "Outfit, sans-serif",
			toolbar: {
				show: false,
			},
		},
		plotOptions: {
			bar: {
				borderRadius: 5,
				columnWidth: "20%",
				horizontal: false,
			},
		},
		colors: ["#00275E", "#85D00B", "#007BFF", "#00CCCC", "#6610F2"],
		series: [
			{
				name: "Leads",
				data: [4, 5, 4, 6, 3, 4, 5, 4, 6, 3, 4, 5],
			},
			{
				name: "Active",
				data: [3, 4, 3, 6, 5, 3, 3, 6, 4, 5, 4, 3],
			},
			{
				name: "Pending",
				data: [4, 5, 4, 6, 3, 4, 5, 4, 6, 3, 4, 6],
			},
			{
				name: "Resolved",
				data: [4, 5, 4, 6, 3, 4, 5, 4, 5, 3, 4, 5],
			},
			{
				name: "Calcelled",
				data: [4, 5, 4, 6, 3, 4, 5, 4, 6, 3, 4, 5],
			},
		],
		xaxis: {
			categories: ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUE", "AUG", "SEP", "OCT", "NOV", "DEC"],
			axisBorder: {
				show: false,
			},
			axisTicks: {
				show: false,
			},
			labels: {
				style: {
					fontSize: "10px",
					colors: "#64748b",
				},
			},
		},
		yaxis: {
			labels: {
				formatter: function (e) {
					return +e + " K";
				},
				offsetX: -5,
				offsetY: 0,
				style: {
					color: "#64748b",
				},
			},
		},
		grid: {
			xaxis: {
				lines: {
					show: false,
				},
			},
			yaxis: {
				lines: {
					show: false,
				},
			},
		},
		dataLabels: {
			enabled: false,
		},
		tooltip: {
			theme: "dark",
			shared: true,
			followCursor: false,
			intersect: false,
			y: {
				formatter: function (e) {
					return +e + "K";
				},
			},
		},
		legend: {
			show: true,
			position: "top",
			horizontalAlign: "left",
			fontSize: "12px",
			fontFamily: "Outfit",
			labels: {
				fontSize: "12px",
				colors: "#64748b",
			},
			markers: {
				width: 10,
				height: 10,
				radius: 25,
			},
			itemMargin: {
				horizontal: 15,
				vertical: 5,
			},
		},
	};
	var chart = new ApexCharts(document.querySelector("#stackedColumns"), options);
	chart.render();
}

// Initialize Basic Area
function initBasicArea() {
	var options = {
		chart: {
			height: 365,
			type: "area",
			foreColor: "#6c757d",
			fontFamily: "Outfit, sans-serif",
			toolbar: {
				show: false,
			},
		},
		xaxis: {
			categories: ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUE", "AUG", "SEP", "OCT", "NOV", "DEC"],
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
			curve: "smooth",
			width: [1, 2, 3, 4],
			lineCap: "round",
		},
		grid: {
			padding: {
				left: 0,
				right: 0,
			},
			strokeDashArray: 3,
			borderColor: "rgba(170, 180, 195, 0.2)",
		},
		legend: {
			show: false,
		},
		colors: ["#015941", "#25b865", "#e49e3d"],
		dataLabels: {
			enabled: false,
		},
		fill: {
			type: "gradient",
			gradient: {
				shadeIntensity: 1,
				opacityFrom: 0.4,
				opacityTo: 0.3,
				stops: [0, 100],
			},
		},
		series: [
			{
				name: "Completed",
				data: [20, 45, 25, 60, 30, 65, 35, 70, 40, 75, 45, 80],
				type: "area",
			},
			{
				name: "Project",
				data: [30, 25, 40, 35, 50, 40, 60, 45, 65, 50, 70, 55],
				type: "area",
			},
			{
				name: "Upcomming",
				data: [45, 20, 50, 25, 65, 30, 75, 35, 80, 40, 85, 45],
				type: "area",
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
	var chart = new ApexCharts(document.querySelector("#basicArea"), options);
	chart.render();
}

// Initialize Bar Line
function initBarLine() {
	var options = {
		chart: {
			height: 380,
			width: "100%",
			foreColor: "#6c757d",
			fontFamily: "Outfit, sans-serif",
			toolbar: {
				show: false,
			},
		},
		stroke: {
			width: [1, 2, 3],
			curve: "smooth",
			lineCap: "round",
		},
		plotOptions: {
			bar: {
				borderRadius: 2,
				endingShape: "rounded",
				columnWidth: "30%",
			},
		},
		colors: ["#015941", "#a2acc7", "#E1E3EA"],
		series: [
			{
				name: "Payment Rejected",
				type: "bar",
				data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30, 21],
			},
			{
				name: "Payment Completed",
				type: "line",
				data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43, 41],
			},
			{
				name: "Awaiting Payment",
				type: "bar",
				data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43, 56],
			},
		],
		fill: {
			opacity: [0.85, 0.25, 1, 1],
			gradient: {
				shade: "dark",
				type: "vertical",
				opacityFrom: 0.5,
				opacityTo: 0.1,
				stops: [0, 100, 100, 100],
			},
		},
		markers: {
			size: 0,
		},
		xaxis: {
			categories: ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUE", "AUG", "SEP", "OCT", "NOV", "DEC"],
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
				offsetX: -5,
				offsetY: 0,
			},
		},
		grid: {
			xaxis: {
				lines: {
					show: false,
				},
			},
			yaxis: {
				lines: {
					show: false,
				},
			},
		},
		dataLabels: {
			enabled: false,
		},
		tooltip: {
			theme: "dark",
			y: {
				formatter: function (e) {
					return +e + "K";
				},
			},
		},
		legend: {
			show: false,
		},
	};
	var chart = new ApexCharts(document.querySelector("#barLine"), options);
	chart.render();
}

// Initialize Candlestick Charts
function initCandlestickCharts() {
	var options = {
		series: [
			{
				data: [
					{
						x: new Date(1538778600000),
						y: [6629.81, 6650.5, 6623.04, 6633.33],
					},
					{
						x: new Date(1538780400000),
						y: [6632.01, 6643.59, 6620, 6630.11],
					},
					{
						x: new Date(1538782200000),
						y: [6630.71, 6648.95, 6623.34, 6635.65],
					},
					{
						x: new Date(1538784000000),
						y: [6635.65, 6651, 6629.67, 6638.24],
					},
					{
						x: new Date(1538785800000),
						y: [6638.24, 6640, 6620, 6624.47],
					},
					{
						x: new Date(1538787600000),
						y: [6624.53, 6636.03, 6621.68, 6624.31],
					},
					{
						x: new Date(1538789400000),
						y: [6624.61, 6632.2, 6617, 6626.02],
					},
					{
						x: new Date(1538791200000),
						y: [6627, 6627.62, 6584.22, 6603.02],
					},
					{
						x: new Date(1538793000000),
						y: [6605, 6608.03, 6598.95, 6604.01],
					},
					{
						x: new Date(1538794800000),
						y: [6604.5, 6614.4, 6602.26, 6608.02],
					},
					{
						x: new Date(1538796600000),
						y: [6608.02, 6610.68, 6601.99, 6608.91],
					},
					{
						x: new Date(1538798400000),
						y: [6608.91, 6618.99, 6608.01, 6612],
					},
					{
						x: new Date(1538800200000),
						y: [6612, 6615.13, 6605.09, 6612],
					},
					{
						x: new Date(1538802000000),
						y: [6612, 6624.12, 6608.43, 6622.95],
					},
					{
						x: new Date(1538803800000),
						y: [6623.91, 6623.91, 6615, 6615.67],
					},
					{
						x: new Date(1538805600000),
						y: [6618.69, 6618.74, 6610, 6610.4],
					},
					{
						x: new Date(1538807400000),
						y: [6611, 6622.78, 6610.4, 6614.9],
					},
					{
						x: new Date(1538809200000),
						y: [6614.9, 6626.2, 6613.33, 6623.45],
					},
					{
						x: new Date(1538811000000),
						y: [6623.48, 6627, 6618.38, 6620.35],
					},
					{
						x: new Date(1538812800000),
						y: [6619.43, 6620.35, 6610.05, 6615.53],
					},
					{
						x: new Date(1538814600000),
						y: [6615.53, 6617.93, 6610, 6615.19],
					},
					{
						x: new Date(1538816400000),
						y: [6615.19, 6621.6, 6608.2, 6620],
					},
					{
						x: new Date(1538818200000),
						y: [6619.54, 6625.17, 6614.15, 6620],
					},
					{
						x: new Date(1538820000000),
						y: [6620.33, 6634.15, 6617.24, 6624.61],
					},
					{
						x: new Date(1538821800000),
						y: [6625.95, 6626, 6611.66, 6617.58],
					},
					{
						x: new Date(1538823600000),
						y: [6619, 6625.97, 6595.27, 6598.86],
					},
					{
						x: new Date(1538825400000),
						y: [6598.86, 6598.88, 6570, 6587.16],
					},
					{
						x: new Date(1538827200000),
						y: [6588.86, 6600, 6580, 6593.4],
					},
					{
						x: new Date(1538829000000),
						y: [6593.99, 6598.89, 6585, 6587.81],
					},
					{
						x: new Date(1538830800000),
						y: [6587.81, 6592.73, 6567.14, 6578],
					},
					{
						x: new Date(1538832600000),
						y: [6578.35, 6581.72, 6567.39, 6579],
					},
					{
						x: new Date(1538834400000),
						y: [6579.38, 6580.92, 6566.77, 6575.96],
					},
					{
						x: new Date(1538836200000),
						y: [6575.96, 6589, 6571.77, 6588.92],
					},
					{
						x: new Date(1538838000000),
						y: [6588.92, 6594, 6577.55, 6589.22],
					},
					{
						x: new Date(1538839800000),
						y: [6589.3, 6598.89, 6589.1, 6596.08],
					},
					{
						x: new Date(1538841600000),
						y: [6597.5, 6600, 6588.39, 6596.25],
					},
					{
						x: new Date(1538843400000),
						y: [6598.03, 6600, 6588.73, 6595.97],
					},
					{
						x: new Date(1538845200000),
						y: [6595.97, 6602.01, 6588.17, 6602],
					},
					{
						x: new Date(1538847000000),
						y: [6602, 6607, 6596.51, 6599.95],
					},
					{
						x: new Date(1538848800000),
						y: [6600.63, 6601.21, 6590.39, 6591.02],
					},
					{
						x: new Date(1538850600000),
						y: [6591.02, 6603.08, 6591, 6591],
					},
					{
						x: new Date(1538852400000),
						y: [6591, 6601.32, 6585, 6592],
					},
					{
						x: new Date(1538854200000),
						y: [6593.13, 6596.01, 6590, 6593.34],
					},
					{
						x: new Date(1538856000000),
						y: [6593.34, 6604.76, 6582.63, 6593.86],
					},
					{
						x: new Date(1538857800000),
						y: [6593.86, 6604.28, 6586.57, 6600.01],
					},
					{
						x: new Date(1538859600000),
						y: [6601.81, 6603.21, 6592.78, 6596.25],
					},
					{
						x: new Date(1538861400000),
						y: [6596.25, 6604.2, 6590, 6602.99],
					},
					{
						x: new Date(1538863200000),
						y: [6602.99, 6606, 6584.99, 6587.81],
					},
					{
						x: new Date(1538865000000),
						y: [6587.81, 6595, 6583.27, 6591.96],
					},
					{
						x: new Date(1538866800000),
						y: [6591.97, 6596.07, 6585, 6588.39],
					},
					{
						x: new Date(1538868600000),
						y: [6587.6, 6598.21, 6587.6, 6594.27],
					},
					{
						x: new Date(1538870400000),
						y: [6596.44, 6601, 6590, 6596.55],
					},
					{
						x: new Date(1538872200000),
						y: [6598.91, 6605, 6596.61, 6600.02],
					},
					{
						x: new Date(1538874000000),
						y: [6600.55, 6605, 6589.14, 6593.01],
					},
					{
						x: new Date(1538875800000),
						y: [6593.15, 6605, 6592, 6603.06],
					},
					{
						x: new Date(1538877600000),
						y: [6603.07, 6604.5, 6599.09, 6603.89],
					},
					{
						x: new Date(1538879400000),
						y: [6604.44, 6604.44, 6600, 6603.5],
					},
					{
						x: new Date(1538881200000),
						y: [6603.5, 6603.99, 6597.5, 6603.86],
					},
					{
						x: new Date(1538883000000),
						y: [6603.85, 6605, 6600, 6604.07],
					},
					{
						x: new Date(1538884800000),
						y: [6604.98, 6606, 6604.07, 6606],
					},
				],
			},
		],
		chart: {
			type: "candlestick",
			height: 350,
			foreColor: "#6c757d",
			fontFamily: "Outfit, sans-serif",
			toolbar: {
				show: false,
			},
		},
		plotOptions: {
			candlestick: {
				colors: {
					upward: "#e49e3d",
					downward: "#015941",
				},
			},
		},
		grid: {
			show: false,
		},
		xaxis: {
			type: "datetime",
			axisBorder: {
				show: false,
			},
		},
		yaxis: {
			yaxisBorder: {
				show: false,
			},
		},
		tooltip: {
			theme: "dark",
		},
	};

	var chart = new ApexCharts(document.querySelector("#candlestickCharts"), options);
	chart.render();
}

// Initialize Simple Pie
function initSimplePie() {
	var options = {
		series: [44, 55, 13, 43, 22],
		chart: {
			width: 380,
			type: "pie",
			foreColor: "#6c757d",
			fontFamily: "Outfit, sans-serif",
		},
		colors: ["#00275E", "#85D00B", "#007BFF", "#00CCCC", "#6610F2"],
		labels: ["Sumi", "Swapan", "Sojib", "Swampa", "Sowrav"],
		responsive: [
			{
				breakpoint: 480,
				options: {
					chart: {
						width: 200,
					},
					legend: {
						position: "bottom",
					},
				},
			},
		],
		legend: {
			show: true,
			position: "bottom",
			itemMargin: {
				vertical: 15,
			},
		},
		dataLabels: {
			enabled: false,
		},
		tooltip: {
			theme: "dark",
		},
	};

	var chart = new ApexCharts(document.querySelector("#simplePie"), options);
	chart.render();
}

// Initialize Simple Donut
function initSimpleDonut() {
	var options = {
		series: [44, 55, 41, 17, 15],
		colors: ["#00275E", "#85D00B", "#007BFF", "#00CCCC", "#6610F2"],
		labels: ["Sumi", "Swapan", "Sojib", "Swampa", "Sowrav"],
		chart: {
			width: 380,
			type: "donut",
			foreColor: "#6c757d",
			fontFamily: "Outfit, sans-serif",
		},
		responsive: [
			{
				breakpoint: 480,
				options: {
					chart: {
						width: 200,
					},
				},
			},
		],
		legend: {
			show: true,
			position: "bottom",
			itemMargin: {
				vertical: 15,
			},
		},
		dataLabels: {
			enabled: false,
		},
		tooltip: {
			theme: "dark",
		},
	};

	var chart = new ApexCharts(document.querySelector("#simpleDonut"), options);
	chart.render();
}

// Initialize Gradient Donut
function initGradientDonut() {
	var options = {
		series: [44, 55, 41, 17, 15],
		colors: ["#00275E", "#85D00B", "#007BFF", "#00CCCC", "#6610F2"],
		labels: ["Sumi", "Swapan", "Sojib", "Swampa", "Sowrav"],
		chart: {
			width: 380,
			type: "donut",
			foreColor: "#6c757d",
			fontFamily: "Outfit, sans-serif",
		},
		responsive: [
			{
				breakpoint: 480,
				options: {
					chart: {
						width: 200,
					},
				},
			},
		],
		fill: {
			type: "gradient",
		},
		legend: {
			show: true,
			position: "bottom",
			itemMargin: {
				vertical: 15,
			},
		},
		dataLabels: {
			enabled: false,
		},
		tooltip: {
			theme: "dark",
		},
	};

	var chart = new ApexCharts(document.querySelector("#gradientDonut"), options);
	chart.render();
}

// Initialize Apexchart
function initBasicRadar() {
	var options = {
		chart: {
			height: 350,
			type: "radar",
			foreColor: "#6c757d",
			fontFamily: "Outfit, sans-serif",
			toolbar: {
				show: false,
			},
		},
		series: [
			{
				name: "Basic Radar",
				data: [80, 50, 30, 40, 100, 20, 60],
			},
		],
		xaxis: {
			categories: ["SUN", "SAR", "MON", "TUE", "WEN", "THU", "FRI"],
		},
		tooltip: {
			theme: "dark",
		},
	};

	var chart = new ApexCharts(document.querySelector("#basicRadar"), options);
	chart.render();
}

// Initialize Radar Multiple
function initRadarMultiple() {
	var options = {
		series: [
			{
				name: "Revenue",
				data: [80, 50, 30, 40, 100, 20],
			},
			{
				name: "Expenses",
				data: [20, 30, 40, 80, 20, 80],
			},
			{
				name: "Profit",
				data: [44, 76, 78, 13, 43, 10],
			},
		],
		chart: {
			height: 350,
			type: "radar",
			foreColor: "#6c757d",
			fontFamily: "Outfit, sans-serif",
			toolbar: {
				show: false,
			},
			dropShadow: {
				enabled: true,
				blur: 1,
				left: 1,
				top: 1,
			},
		},
		xaxis: {
			categories: ["2011", "2012", "2013", "2014", "2015", "2016"],
		},
		stroke: {
			width: 2,
		},
		fill: {
			opacity: 0.1,
		},
		markers: {
			size: 0,
		},
		legend: {
			show: false,
		},
		tooltip: {
			theme: "dark",
		},
	};

	var chart = new ApexCharts(document.querySelector("#radarMultiple"), options);
	chart.render();
}

// Initialize Apexchart
function initRadarPolygon() {
	var options = {
		series: [
			{
				name: "Radar Polygon",
				data: [20, 100, 40, 30, 50, 80, 33],
			},
		],
		chart: {
			height: 350,
			type: "radar",
			foreColor: "#6c757d",
			fontFamily: "Outfit, sans-serif",
			toolbar: {
				show: false,
			},
		},
		dataLabels: {
			enabled: true,
		},
		plotOptions: {
			radar: {
				size: 140,
			},
		},
		colors: ["#FF4560"],
		markers: {
			size: 4,
			colors: ["#fff"],
			strokeColor: "#FF4560",
			strokeWidth: 2,
		},
		tooltip: {
			theme: "dark",
			y: {
				formatter: function (val) {
					return val;
				},
			},
		},
		xaxis: {
			categories: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
		},
		yaxis: {
			tickAmount: 7,
			labels: {
				formatter: function (val, i) {
					if (i % 2 === 0) {
						return val;
					} else {
						return "";
					}
				},
			},
		},
	};

	var chart = new ApexCharts(document.querySelector("#radarPolygon"), options);
	chart.render();
}

// Public method to initialize all charts
(function () {
	initGradientLine();
	initLineDataLabels();
	initBasicBar();
	initColumnDataLabels();
	initStackedColumns();
	initBasicArea();
	initBarLine();
	initCandlestickCharts();
	initSimplePie();
	initSimpleDonut();
	initGradientDonut();
	initBasicRadar();
	initRadarMultiple();
	initRadarPolygon();
})();
