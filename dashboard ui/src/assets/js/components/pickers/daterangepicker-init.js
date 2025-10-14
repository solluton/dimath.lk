"use strict";

// Initialize Simple Date Picker
function initSimpleDatePicker() {
	$(function () {
		$('input[name="simpleDatePicker"]').daterangepicker(
			{
				opens: "right",
				cancelClass: "btn-light",
			},
			function (start, end, label) {
				console.log("A new date selection was made: " + start.format("YYYY-MM-DD") + " to " + end.format("YYYY-MM-DD"));
			}
		);
	});
}

// Initialize Single Date Picker
function initSingleDatePicker() {
	$('input[name="singleDatePicker"]').daterangepicker(
		{
			opens: "right",
			cancelClass: "btn-light",
			singleDatePicker: true,
			showDropdowns: true,
			minYear: 1901,
			maxYear: parseInt(moment().format("YYYY"), 10),
		},
		function (start, end, label) {
			var years = moment().diff(start, "years");
			alert("You are " + years + " years old!");
		}
	);
}

// Initialize Predefined Date Ranges
function initPredefinedDateRanges() {
	var start = moment().subtract(29, "days");
	var end = moment();

	function cb(start, end) {
		$("#predefinedDateRanges input.input-filed").html(start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"));
	}

	$("#predefinedDateRanges").daterangepicker(
		{
			opens: "right",
			cancelClass: "btn-light",
			startDate: start,
			endDate: end,
			ranges: {
				Today: [moment(), moment()],
				Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
				"Last 7 Days": [moment().subtract(6, "days"), moment()],
				"Last 30 Days": [moment().subtract(29, "days"), moment()],
				"This Month": [moment().startOf("month"), moment().endOf("month")],
				"Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")],
			},
		},
		cb
	);

	cb(start, end);
}

//Public method to initialize all charts
(function () {
	initSimpleDatePicker();
	initSingleDatePicker();
	initPredefinedDateRanges();
})();
