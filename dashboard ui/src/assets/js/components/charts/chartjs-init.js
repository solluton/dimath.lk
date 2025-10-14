"use strict";

// Initialize Multiple Bar
function initMultipleBar() {
	var multipleBar = document.getElementById("multipleBar");
	new Chart(multipleBar, {
		type: "bar",
		data: {
			labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
			datasets: [
				{
					label: "Revenue",
					data: [22, 39, 30, 20, 25, 28, 22, 39, 30, 30, 25, 38],
					backgroundColor: "#015941",
				},
				{
					label: "Expenses",
					data: [20, 35, 27, 18, 20, 25, 20, 35, 25, 28, 22, 35],
					backgroundColor: "#E1E3EA",
				},
				{
					label: "Profit",
					data: [25, 30, 25, 22, 24, 22, 25, 30, 28, 32, 20, 30],
					backgroundColor: "#e49e3d",
				},
			],
		},
		options: {
			responsive: true,
			barPercentage: 0.75,
			categoryPercentage: 0.5,
			maintainAspectRatio: false,
			scales: {
				y: {
					grid: {
						display: false,
					},
					border: {
						display: false,
					},
					ticks: {
						stepSize: 15,
						color: "#6c757d",
						font: {
							family: "Outfit, sans-serif",
						},
					},
				},
				x: {
					grid: {
						display: false,
					},
					border: {
						display: false,
					},
					ticks: {
						color: "#6c757d",
						font: {
							family: "Outfit, sans-serif",
						},
					},
				},
			},
			elements: {
				bar: {
					borderRadius: 3,
				},
			},
			plugins: {
				legend: {
					labels: {
						usePointStyle: true,
						font: {
							color: "#6c757d",
							family: "Outfit, sans-serif",
						},
					},
				},
			},
		},
	});
}

// Initialize StackedBar
function initStackedBar() {
	var stackedBar = document.getElementById("stackedBar");
	new Chart(stackedBar, {
		type: "bar",
		data: {
			labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
			datasets: [
				{
					label: "Revenue",
					data: [22, 39, 30, 20, 25, 28, 22, 39, 30, 30, 25, 38],
					backgroundColor: "#015941",
				},
				{
					label: "Expenses",
					data: [20, 35, 27, 18, 20, 25, 20, 35, 25, 28, 22, 35],
					backgroundColor: "#E1E3EA",
				},
				{
					label: "Profit",
					data: [25, 30, 25, 22, 24, 22, 25, 30, 28, 32, 20, 30],
					backgroundColor: "#e49e3d",
				},
			],
		},
		options: {
			responsive: true,
			barPercentage: 0.75,
			categoryPercentage: 0.25,
			maintainAspectRatio: false,
			scales: {
				y: {
					stacked: true,
					grid: {
						display: false,
					},
					border: {
						display: false,
					},
					ticks: {
						stepSize: 15,
						color: "#6c757d",
						font: {
							family: "Outfit, sans-serif",
						},
					},
				},
				x: {
					stacked: true,
					grid: {
						display: false,
					},
					border: {
						display: false,
					},
					ticks: {
						color: "#6c757d",
						font: {
							family: "Outfit, sans-serif",
						},
					},
				},
			},
			elements: {
				bar: {
					borderRadius: 5,
				},
			},
			plugins: {
				legend: {
					labels: {
						usePointStyle: true,
						font: {
							color: "#6c757d",
							family: "Outfit, sans-serif",
						},
					},
				},
			},
		},
	});
}

// Initialize Rounded Line
function initRoundedLine() {
	var roundedLine = document.getElementById("roundedLine");
	new Chart(roundedLine, {
		type: "line",
		data: {
			labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
			datasets: [
				{
					label: "Revenue",
					data: [22, 39, 30, 20, 25, 28, 22, 39, 30, 30, 25, 38],
					backgroundColor: "#015941",
				},
				{
					label: "Expenses",
					data: [20, 35, 27, 18, 20, 25, 20, 35, 25, 28, 22, 35],
					backgroundColor: "#E1E3EA",
				},
				{
					label: "Profit",
					data: [25, 30, 25, 22, 24, 22, 25, 30, 28, 32, 20, 30],
					backgroundColor: "#e49e3d",
				},
			],
		},
		options: {
			tension: 0.5,
			responsive: true,
			maintainAspectRatio: false,
			scales: {
				y: {
					grid: {
						display: false,
					},
					border: {
						display: false,
					},
					ticks: {
						stepSize: 15,
						color: "#E1E3EA",
						font: {
							family: "Outfit, sans-serif",
						},
					},
				},
				x: {
					grid: {
						display: false,
					},
					border: {
						display: false,
					},
					ticks: {
						color: "#6c757d",
						font: {
							family: "Outfit, sans-serif",
						},
					},
				},
			},
			plugins: {
				legend: {
					labels: {
						usePointStyle: true,
						font: {
							color: "#6c757d",
							family: "Outfit, sans-serif",
						},
					},
				},
			},
		},
	});
}

// Initialize Rounded Area
function initRoundedArea() {
	var roundedArea = document.getElementById("roundedArea");
	new Chart(roundedArea, {
		type: "line",
		data: {
			labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
			datasets: [
				{
					label: "Current",
					borderDash: [5, 6],
					borderColor: "#e49e3d",
					backgroundColor: "#fff",
					data: [35, 48, 45, 65, 60, 85, 70],
				},
				{
					fill: true,
					label: "Previous",
					borderColor: "rgba(170, 180, 195, 0.1)",
					backgroundColor: "rgba(142, 212, 172, 0.25)",
					data: [32, 42, 42, 62, 52, 75, 62],
				},
			],
		},
		options: {
			tension: 0.5,
			responsive: true,
			maintainAspectRatio: false,
			plugins: {
				legend: {
					display: false,
				},
			},
			scales: {
				y: {
					grid: {
						display: false,
					},
					border: {
						display: false,
					},
					ticks: {
						stepSize: 15,
						color: "#6c757d",
						font: {
							family: "Outfit, sans-serif",
						},
					},
				},
				x: {
					border: {
						display: false,
					},
					ticks: {
						color: "#6c757d",
						font: {
							family: "Outfit, sans-serif",
						},
					},
				},
			},
		},
	});
}

// Initialize Doughnut Chart
function initDoughnutChart() {
	var doughnutChart = document.getElementById("doughnutChart");
	new Chart(doughnutChart, {
		type: "doughnut",
		data: {
			labels: ["Sumi", "Swapan", "Sojib", "Swampa", "Sourav"],
			datasets: [
				{
					data: [30, 25, 30, 25, 30],
					backgroundColor: ["#3454d1", "#e83e8c", "rgba(170, 180, 195, 0.1)", "#e49e3d", "#3dc7be"],
				},
			],
		},
		options: {
			cutout: 120,
			responsive: true,
			maintainAspectRatio: false,
			plugins: {
				legend: {
					position: "bottom",
					labels: {
						usePointStyle: true,
						font: {
							color: "#6c757d",
							family: "Outfit, sans-serif",
						},
					},
				},
			},
		},
	});
}

// Initialize Pie Chart
function initPieChart() {
	var pieChart = document.getElementById("pieChart");
	new Chart(pieChart, {
		type: "pie",
		data: {
			labels: ["Sumi", "Swapan", "Sojib", "Swampa", "Sourav"],
			datasets: [
				{
					data: [30, 25, 30, 25, 30],
					backgroundColor: ["#3454d1", "#e83e8c", "rgba(170, 180, 195, 0.1)", "#e49e3d", "#3dc7be"],
				},
			],
		},
		options: {
			cutout: 0,
			responsive: true,
			maintainAspectRatio: false,
			plugins: {
				legend: {
					position: "bottom",
					labels: {
						usePointStyle: true,
						font: {
							color: "#6c757d",
							family: "Outfit, sans-serif",
						},
					},
				},
			},
		},
	});
}

// Initialize Polar Area
function initPolarArea() {
	var polarArea = document.getElementById("polarArea");
	new Chart(polarArea, {
		type: "polarArea",
		data: {
			labels: ["Sumi", "Swapan", "Sojib", "Swampa", "Sourav"],
			datasets: [
				{
					data: [50, 25, 40, 50, 35],
					backgroundColor: ["#3454d1", "#e83e8c", "rgba(170, 180, 195, 0.1)", "#e49e3d", "#3dc7be"],
				},
			],
		},
		options: {
			cutout: 120,
			responsive: true,
			maintainAspectRatio: false,
			plugins: {
				legend: {
					position: "bottom",
					labels: {
						usePointStyle: true,
						font: {
							color: "#6c757d",
							family: "Outfit, sans-serif",
						},
					},
				},
			},
		},
	});
}

// Initialize Radar Chart
function initRadarChart() {
	var radarChart = document.getElementById("radarChart");
	new Chart(radarChart, {
		type: "radar",
		data: {
			labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
			datasets: [
				{
					label: "5:00AM - 12:00AM",
					data: [65, 59, 90, 81, 56, 55, 40],
					fill: true,
					backgroundColor: "rgba(255, 99, 132, 0.2)",
					borderColor: "rgb(255, 99, 132)",
					pointBackgroundColor: "rgb(255, 99, 132)",
					pointBorderColor: "#fff",
					pointHoverBackgroundColor: "#fff",
					pointHoverBorderColor: "rgb(255, 99, 132)",
				},
				{
					label: "12:00AM - 11:00PM",
					data: [28, 48, 40, 19, 96, 27, 100],
					fill: true,
					backgroundColor: "rgba(54, 162, 235, 0.2)",
					borderColor: "rgb(54, 162, 235)",
					pointBackgroundColor: "rgb(54, 162, 235)",
					pointBorderColor: "#fff",
					pointHoverBackgroundColor: "#fff",
					pointHoverBorderColor: "rgb(54, 162, 235)",
				},
			],
		},
		options: {
			cutout: 120,
			responsive: true,
			maintainAspectRatio: false,
			plugins: {
				legend: {
					position: "bottom",
					labels: {
						usePointStyle: true,
						font: {
							color: "#6c757d",
							family: "Outfit, sans-serif",
						},
					},
				},
			},
		},
	});
}

//Public method to initialize all charts
(function () {
	initMultipleBar();
	initStackedBar();
	initRoundedLine();
	initRoundedArea();
	initDoughnutChart();
	initPieChart();
	initPolarArea();
	initRadarChart();
})();
