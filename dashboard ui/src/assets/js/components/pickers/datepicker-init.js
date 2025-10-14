"use strict";

// Initialize Datepicke Basic
function initBSDatepickerBasic() {
	$("#bsDatepickerBasic").datepicker({
		todayHighlight: true,
	});
}

// Initialize Datepicke Disabled
function initBSDatepickerDisabled() {
	$("#bsDatepickerDisabled").datepicker({
		todayHighlight: true,
		daysOfWeekDisabled: [0, 6],
	});
}

// Initialize Datepicke Options
function initBSDatepickerOptions() {
	$("#bsDatepickerOptions").datepicker({
		calendarWeeks: true,
		clearBtn: true,
	});
}

// Initialize Datepicke Multidate
function initBSDatepickerMultidate() {
	$("#bsDatepickerMultidate").datepicker({
		multidate: true,
	});
}

// Initialize Datepicke DateRange
function initBSDatepickerDateRange() {
	$("#bsDatepickerDateRange").datepicker({
		calendarWeeks: true,
		clearBtn: true,
	});
}

//Public method to initialize all charts
(function () {
	initBSDatepickerBasic();
	initBSDatepickerDisabled();
	initBSDatepickerOptions();
	initBSDatepickerMultidate();
	initBSDatepickerDateRange();
})();
