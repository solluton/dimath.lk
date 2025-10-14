"use strict";

// Initialize Timepicker Basic
function initTimepickerBasic() {
	$("#basicTimepicker").timepicker();
}

// Initialize
function initTimepickerDuration() {
	$("#durationTimepicker").timepicker({
		minTime: "2:00pm",
		maxTime: "11:30pm",
		showDuration: true,
	});
}

// Initialize Timepicker Disable
function initTimepickerDisable() {
	$("#disableTimeRangesTimepicker").timepicker({
		disableTimeRanges: [
			["12am", "3am"],
			["4am", "4:30am"],
			["10am", "11:30am"],
		],
	});
}

// Initialize Timepicker Timeformat
function initTimepickerTimeformat() {
	$("#timeformatTimepicker1").timepicker({ timeFormat: "H:i:s" });
	$("#timeformatTimepicker2").timepicker({ timeFormat: "h:i A" });
}

// Initialize Datepair
function initTimepickerDatepair() {
	$("#datepairExample .time").timepicker({
		showDuration: true,
		timeFormat: "g:ia",
	});

	$("#datepairExample .date").datepicker({
		format: "m/d/yyyy",
		autoclose: true,
	});

	$("#datepairExample").datepair();
}

//Public method to initialize all charts
(function () {
	initTimepickerBasic();
	initTimepickerDuration();
	initTimepickerDisable();
	initTimepickerTimeformat();
	initTimepickerDatepair();
})();
