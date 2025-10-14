"use strict";

// Initialize Basic Line
function initBasicLine() {
	const data = [
		{
			label: "BITCOIN",
			data: [
				[1, 10],
				[2, 20],
				[3, 30],
				[4, 25],
				[5, 40],
				[6, 35],
				[7, 45],
				[8, 50],
				[9, 38],
				[10, 28],
				[11, 42],
				[12, 32],
			],
		},
		{
			label: "ETHEREUM ",
			data: [
				[1, 20],
				[2, 24],
				[3, 32],
				[4, 28],
				[5, 38],
				[6, 40],
				[7, 48],
				[8, 55],
				[9, 40],
				[10, 30],
				[11, 45],
				[12, 35],
			],
		},
	];

	const options = {
		series: {
			lines: {
				show: true,
			},
			points: {
				show: true,
			},
		},
		colors: ["#015941", "#e49e3d"],
		grid: {
			hoverable: true,
			clickable: true,
			borderWidth: 1,
			labelMargin: 10,
			tickColor: "rgba(170, 180, 195, 0.1)",
			borderColor: "rgba(170, 180, 195, 0.1)",
			backgroundColor: "transparent",
		},
		yaxis: {
			color: "rgba(170, 180, 195, 0.1)",
			tickColor: "rgba(170, 180, 195, 0.1)",
			font: {
				size: 12,
				fill: "#6c757d",
				family: "Outfit, sans-serif",
			},
		},
		xaxis: {
			ticks: [
				[1, "Jan"],
				[2, "Feb"],
				[3, "Mar"],
				[4, "Apr"],
				[5, "May"],
				[6, "Jun"],
				[7, "Jul"],
				[8, "Aug"],
				[9, "Sep"],
				[10, "Oct"],
				[11, "Nov"],
				[12, "Dec"],
			],
			color: "rgba(170, 180, 195, 0.1)",
			tickColor: "rgba(170, 180, 195, 0.1)",
			font: {
				size: 12,
				fill: "#6c757d",
				family: "Outfit, sans-serif",
			},
		},
		legend: {
			show: true,
		},
		tooltip: {
			show: true,
			content: "%s: Value of %x is %y",
			shifts: { x: -60, y: 25 },
			cssClass: "flot-tooltip-dark",
		},
	};

	const plot = $.plot("#basicLine", data, options);
}

// Initialize Crosshair Tracking
function initCrosshairTracking() {
	var sin = [],
		cos = [];
	for (var i = 0; i < 14; i += 0.1) {
		sin.push([i, Math.sin(i)]);
		cos.push([i, Math.cos(i)]);
	}

	const plot = $.plot(
		"#crosshairTracking",
		[
			{ data: sin, label: "sin(x) = -0.00" },
			{ data: cos, label: "cos(x) = -0.00" },
		],
		{
			legend: {
				show: true,
			},
			series: {
				lines: {
					show: true,
				},
			},
			colors: ["#015941", "#e49e3d"],
			crosshair: {
				mode: "xy",
			},
			grid: {
				hoverable: true,
				clickable: true,
				autoHighlight: false,
				borderWidth: 1,
				labelMargin: 10,
				tickColor: "rgba(170, 180, 195, 0.1)",
				borderColor: "rgba(170, 180, 195, 0.1)",
				backgroundColor: "transparent",
			},
			yaxis: {
				min: -1.2,
				max: 1.2,
				color: "rgba(170, 180, 195, 0.1)",
				tickColor: "rgba(170, 180, 195, 0.1)",
				font: {
					size: 12,
					fill: "#6c757d",
					family: "Outfit, sans-serif",
				},
			},
			xaxis: {
				color: "rgba(170, 180, 195, 0.1)",
				tickColor: "rgba(170, 180, 195, 0.1)",
				font: {
					size: 12,
					fill: "#6c757d",
					family: "Outfit, sans-serif",
				},
			},
			tooltip: {
				show: true,
				content: "%s: Value of %x is %y",
				shifts: { x: -60, y: 25 },
				cssClass: "flot-tooltip-dark",
			},
		}
	);

	var legends = $("#crosshairTracking .legendLayer text tspan");

	legends.each(function () {
		// fix the widths so they don't jump around
		$(this).css("width", $(this).width());
	});

	var updateLegendTimeout = null;
	var latestPosition = null;

	function updateLegend() {
		updateLegendTimeout = null;
		var pos = latestPosition;
		var axes = plot.getAxes();

		if (pos.x < axes.xaxis.min || pos.x > axes.xaxis.max || pos.y < axes.yaxis.min || pos.y > axes.yaxis.max) {
			return;
		}

		var i,
			j,
			dataset = plot.getData();

		for (i = 0; i < dataset.length; ++i) {
			var series = dataset[i];
			// Find the nearest points, x-wise
			for (j = 0; j < series.data.length; ++j) {
				if (series.data[j][0] > pos.x) {
					break;
				}
			}
			// Now Interpolate
			var y,
				p1 = series.data[j - 1],
				p2 = series.data[j];
			if (p1 == null) {
				y = p2[1];
			} else if (p2 == null) {
				y = p1[1];
			} else {
				y = p1[1] + ((p2[1] - p1[1]) * (pos.x - p1[0])) / (p2[0] - p1[0]);
			}
			legends.eq(i).text(series.label.replace(/=.*/, "= " + y.toFixed(2)));
		}
	}

	$("#crosshairTracking")
		.bind("plothover", function (event, pos, item) {
			latestPosition = pos;
			if (!updateLegendTimeout) {
				updateLegendTimeout = setTimeout(updateLegend, 50);
			}
		})
		.bind("plotclick", function (event, pos, item) {
			plot.lockCrosshair(pos);
		});
}

// Initialize Basic Area
function initBasicArea() {
	const data = [
		{
			label: "BITCOIN",
			data: [
				[1, 10],
				[2, 5],
				[3, 20],
				[4, 10],
				[5, 30],
				[6, 15],
				[7, 40],
				[8, 20],
				[9, 50],
				[10, 25],
				[11, 60],
				[12, 30],
			],
		},
		{
			label: "ETHEREUM ",
			data: [
				[1, 15],
				[2, 10],
				[3, 30],
				[4, 20],
				[5, 45],
				[6, 30],
				[7, 60],
				[8, 40],
				[9, 75],
				[10, 50],
				[11, 90],
				[12, 60],
			],
		},
	];

	const options = {
		series: {
			lines: {
				show: true,
				fill: true,
				lineWidth: 3,
			},
			points: {
				show: true,
			},
		},
		colors: ["rgba(40, 70, 170, 0.5)", "rgba(35, 185, 100, 0.5)"],
		grid: {
			hoverable: true,
			clickable: true,
			borderWidth: 1,
			labelMargin: 10,
			tickColor: "rgba(170, 180, 195, 0.1)",
			borderColor: "rgba(170, 180, 195, 0.1)",
			backgroundColor: "transparent",
		},
		yaxis: {
			color: "rgba(170, 180, 195, 0.1)",
			tickColor: "rgba(170, 180, 195, 0.1)",
			font: {
				size: 12,
				fill: "#6c757d",
				family: "Outfit, sans-serif",
			},
		},
		xaxis: {
			ticks: [
				[1, "Jan"],
				[2, "Feb"],
				[3, "Mar"],
				[4, "Apr"],
				[5, "May"],
				[6, "Jun"],
				[7, "Jul"],
				[8, "Aug"],
				[9, "Sep"],
				[10, "Oct"],
				[11, "Nov"],
				[12, "Dec"],
			],
			color: "rgba(170, 180, 195, 0.1)",
			tickColor: "rgba(170, 180, 195, 0.1)",
			font: {
				size: 12,
				fill: "#6c757d",
				family: "Outfit, sans-serif",
			},
		},
		legend: {
			show: true,
		},
		tooltip: {
			show: true,
			content: "%s: Value of %x is %y",
			shifts: { x: -60, y: 25 },
			cssClass: "flot-tooltip-dark",
		},
	};

	const plot = $.plot("#basicArea", data, options);
}

// Initialize Stacked Bar
function initStackedBar() {
	var d1 = [];
	for (var i = 0; i <= 10; i += 1) {
		d1.push([i, parseInt(Math.random() * 30)]);
	}

	var d2 = [];
	for (var i = 0; i <= 10; i += 1) {
		d2.push([i, parseInt(Math.random() * 30)]);
	}

	var d3 = [];
	for (var i = 0; i <= 10; i += 1) {
		d3.push([i, parseInt(Math.random() * 30)]);
	}

	var stack = 0,
		bars = true,
		lines = false,
		steps = false;

	function plotWithOptions() {
		$.plot(
			"#stackedBar",
			[
				{ data: d1, label: "Earnings" },
				{ data: d2, label: "Revenues" },
				{ data: d3, label: "Expenses" },
			],
			{
				series: {
					stack: stack,
					lines: {
						show: lines,
						fill: true,
						steps: steps,
						fill: 1,
					},
					bars: {
						show: bars,
						barWidth: 0.25,
						fill: 1,
					},
				},
				grid: {
					hoverable: true,
					clickable: true,
					borderWidth: 1,
					labelMargin: 10,
					tickColor: "rgba(170, 180, 195, 0.1)",
					borderColor: "rgba(170, 180, 195, 0.1)",
					backgroundColor: "transparent",
				},
				yaxis: {
					autoScale: "exact",
					color: "rgba(170, 180, 195, 0.1)",
					tickColor: "rgba(170, 180, 195, 0.1)",
					font: {
						size: 12,
						fill: "#6c757d",
						family: "Outfit, sans-serif",
					},
				},
				xaxis: {
					color: "rgba(170, 180, 195, 0.1)",
					tickColor: "rgba(170, 180, 195, 0.1)",
					font: {
						size: 12,
						fill: "#6c757d",
						family: "Outfit, sans-serif",
					},
				},
				legend: {
					show: true,
				},
				tooltip: {
					show: true,
					content: "%s: Value of %x is %y",
					shifts: { x: -60, y: 25 },
					cssClass: "flot-tooltip-dark",
				},
			}
		);
	}

	plotWithOptions();

	$(".stackControls button").click(function (e) {
		e.preventDefault();
		stack = $(this).text() == "With stacking" ? true : null;
		plotWithOptions();
	});

	$(".graphControls button").click(function (e) {
		e.preventDefault();
		bars = $(this).text().indexOf("Bars") != -1;
		lines = $(this).text().indexOf("Lines") != -1;
		steps = $(this).text().indexOf("steps") != -1;
		plotWithOptions();
	});
}

// Initialize Axis Tick Labels
function initAxisTickLabels() {
	var index = 100;
	function generate(start, end, fn) {
		var res = [];
		for (var i = 0; i <= 40; ++i) {
			var x = start + (i / 40) * (end - start);
			res.push([x, fn(x)]);
		}
		return res;
	}

	var data = [
		{
			data: generate(index, 2, function (x) {
				return Math.cos(x);
			}),
			xaxis: 1,
			yaxis: 1,
			lines: { show: true },
		},
	];

	var plot = $.plot("#AxisTickLabels", data, {
		grid: {
			tickColor: "rgba(170, 180, 195, 0.1)",
			borderColor: "rgba(170, 180, 195, 0.1)",
			backgroundColor: "transparent",
		},
		yaxis: {
			min: -3,
			max: 3,
			position: "left",
			autoScale: "exact",
			color: "rgba(170, 180, 195, 0.1)",
			tickColor: "rgba(170, 180, 195, 0.1)",
			font: {
				size: 12,
				fill: "#6c757d",
				family: "Outfit, sans-serif",
			},
		},
		xaxis: {
			color: "rgba(170, 180, 195, 0.1)",
			tickColor: "rgba(170, 180, 195, 0.1)",
			position: "bottom",
			font: {
				size: 12,
				fill: "#6c757d",
				family: "Outfit, sans-serif",
			},
		},
	});

	function update() {
		index += 0.0025;
		data = [
			{
				data: generate(index, index + 2, function (x) {
					return Math.cos(x);
				}),
				xaxis: 1,
				yaxis: 1,
				lines: { show: true },
			},
		];
		plot.setData(data);
		plot.setupGrid(true);
		plot.draw();
		window.requestAnimationFrame(update);
	}

	window.requestAnimationFrame(update);

	$("#tickLabels input").on("change", function () {
		var val = $('input[name="tickLabels"]:checked', "#tickLabels").val();
		var axes = plot.getXAxes().concat(plot.getYAxes());
		axes.forEach(function (axis) {
			axis.options.showTickLabels = val;
		});
	});

	$("#tickMarks input").on("change", function () {
		var val = $('input[name="tickMarks"]:checked', "#tickMarks").val();
		var axes = plot.getXAxes().concat(plot.getYAxes());
		axes.forEach(function (axis) {
			switch (val) {
				case "none":
					axis.options.showTicks = false;
					break;
				case "major":
					axis.options.showTicks = true;
					axis.options.showMinorTicks = false;
					break;
				case "all":
					axis.options.showTicks = true;
					axis.options.showMinorTicks = true;
					break;
			}
		});
	});

	$("#scaling input").on("change", function () {
		var val = $('input[name="scaling"]:checked', "#scaling").val();
		var y = plot.getAxes().yaxis;

		switch (val) {
			case "none":
				y.options.autoScale = "none";
				y.options.min = -3;
				y.options.max = 3;
				y.options.autoScaleMargin = null;
				y.options.growOnly = null;
				break;
			case "fitLoosely":
				y.options.autoScale = "loose";
				y.options.min = undefined;
				y.options.max = undefined;
				y.options.autoScaleMargin = 0.1;
				y.options.growOnly = false;
				break;
			case "fitExactly":
				y.options.autoScale = "exact";
				y.options.min = undefined;
				y.options.max = undefined;
				y.options.autoScaleMargin = null;
				y.options.growOnly = false;
				break;
			case "growLoosely":
				y.options.autoScale = "loose";
				y.options.min = -2.0;
				y.options.max = 2.0;
				y.options.autoScaleMargin = 0.1;
				y.options.growOnly = true;
				break;
			case "growExactly":
				y.options.autoScale = "exact";
				y.options.min = undefined;
				y.options.max = undefined;
				y.options.autoScaleMargin = null;
				y.options.growOnly = true;
				break;
		}
	});

	$("#verticalPosition input").on("change", function () {
		var val = $('input[name="verticalPosition"]:checked', "#verticalPosition").val();
		var axes = plot.getYAxes();
		axes.forEach(function (axis) {
			axis.options.position = val;
		});
	});

	$("#horizontalPosition input").on("change", function () {
		var val = $('input[name="horizontalPosition"]:checked', "#horizontalPosition").val();
		var axes = plot.getXAxes();
		axes.forEach(function (axis) {
			axis.options.position = val;
		});
	});
}

// Initialize Pie Charts
function initPieCharts() {
	var data = [],
		series = Math.floor(Math.random() * 6) + 3;

	for (var i = 0; i < series; i++) {
		data[i] = {
			label: "Series" + (i + 1),
			data: Math.floor(Math.random() * 100) + 1,
		};
	}

	var placeholder = $("#pieCharts");

	$("#example-1").click(function () {
		placeholder.unbind();

		$.plot(placeholder, data, {
			series: {
				pie: {
					show: true,
				},
			},
		});
	});

	$("#example-2").click(function () {
		placeholder.unbind();
		$.plot(placeholder, data, {
			series: {
				pie: {
					show: true,
				},
			},
			legend: {
				show: false,
			},
		});
	});

	$("#example-3").click(function () {
		placeholder.unbind();
		$.plot(placeholder, data, {
			series: {
				pie: {
					show: true,
					radius: 1,
					label: {
						show: true,
						radius: 1,
						formatter: labelFormatter,
						background: {
							opacity: 0.8,
						},
					},
				},
			},
			legend: {
				show: false,
			},
		});
	});

	$("#example-4").click(function () {
		placeholder.unbind();

		$.plot(placeholder, data, {
			series: {
				pie: {
					show: true,
					radius: 1,
					label: {
						show: true,
						radius: 3 / 4,
						formatter: labelFormatter,
						background: {
							opacity: 0.5,
						},
					},
				},
			},
			legend: {
				show: false,
			},
		});
	});

	$("#example-5").click(function () {
		placeholder.unbind();

		$.plot(placeholder, data, {
			series: {
				pie: {
					show: true,
					radius: 1,
					label: {
						show: true,
						radius: 3 / 4,
						formatter: labelFormatter,
						background: {
							opacity: 0.5,
							color: "#000",
						},
					},
				},
			},
			legend: {
				show: false,
			},
		});
	});

	$("#example-6").click(function () {
		placeholder.unbind();

		$.plot(placeholder, data, {
			series: {
				pie: {
					show: true,
					radius: 3 / 4,
					label: {
						show: true,
						radius: 3 / 4,
						formatter: labelFormatter,
						background: {
							opacity: 0.5,
							color: "#000",
						},
					},
				},
			},
			legend: {
				show: false,
			},
		});
	});

	$("#example-7").click(function () {
		placeholder.unbind();

		$.plot(placeholder, data, {
			series: {
				pie: {
					show: true,
					radius: 1,
					label: {
						show: true,
						radius: 2 / 3,
						formatter: labelFormatter,
						threshold: 0.1,
					},
				},
			},
			legend: {
				show: false,
			},
		});
	});

	$("#example-8").click(function () {
		placeholder.unbind();

		$.plot(placeholder, data, {
			series: {
				pie: {
					show: true,
					combine: {
						color: "#999",
						threshold: 0.05,
					},
				},
			},
			legend: {
				show: false,
			},
		});
	});

	$("#example-9").click(function () {
		placeholder.unbind();

		$.plot(placeholder, data, {
			series: {
				pie: {
					show: true,
					radius: 500,
					label: {
						show: true,
						formatter: labelFormatter,
						threshold: 0.1,
					},
				},
			},
			legend: {
				show: false,
			},
		});
	});

	$("#example-10").click(function () {
		placeholder.unbind();

		$.plot(placeholder, data, {
			series: {
				pie: {
					show: true,
					radius: 1,
					tilt: 0.5,
					label: {
						show: true,
						radius: 1,
						formatter: labelFormatter,
						background: {
							opacity: 0.8,
						},
					},
					combine: {
						color: "#999",
						threshold: 0.1,
					},
				},
			},
			legend: {
				show: false,
			},
		});
	});

	$("#example-11").click(function () {
		placeholder.unbind();

		$.plot(placeholder, data, {
			series: {
				pie: {
					innerRadius: 0.5,
					show: true,
				},
			},
		});
	});

	$("#example-12").click(function () {
		placeholder.unbind();

		$.plot(placeholder, data, {
			series: {
				pie: {
					show: true,
				},
			},
			grid: {
				hoverable: true,
				clickable: true,
			},
		});

		placeholder.bind("plothover", function (event, pos, obj) {
			if (!obj) {
				return;
			}

			var percent = parseFloat(obj.series.percent).toFixed(2);
			$("#hover").html("<span style='font-weight:bold; color:" + obj.series.color + "'>" + obj.series.label + " (" + percent + "%)</span>");
		});

		placeholder.bind("plotclick", function (event, pos, obj) {
			if (!obj) {
				return;
			}

			percent = parseFloat(obj.series.percent).toFixed(2);
			alert("" + obj.series.label + ": " + percent + "%");
		});
	});

	//Show the initial default chart
	$("#example-1").click();

	// A custom label formatter used by several of the plots
	function labelFormatter(label, series) {
		return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
	}
}

//Public method to initialize all charts
(function () {
	initBasicLine();
	initCrosshairTracking();
	initBasicArea();
	initStackedBar();
	initAxisTickLabels();
	initPieCharts();
})();
