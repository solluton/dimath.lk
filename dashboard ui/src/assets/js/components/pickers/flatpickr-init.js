"use strict";

// Initialize Basic Flatpickr
function initbasicFlatpickr() {
	flatpickr("#basicFlatpickr");
}

// Initialize DateTime Flatpickr
function initDateTimeFlatpickr() {
	flatpickr("#dateTimeFlatpickr", {
		enableTime: true,
		dateFormat: "Y-m-d H:i",
	});
}

// Initialize Disabling Flatpickr
function initDisablingFlatpickr() {
	flatpickr("#disablingFlatpickr", {
		onReady: function () {
			this.jumpToDate("2024-06");
		},
		disable: ["2024-06-5", "2024-06-6", "2024-06-17", "2024-06-18", "2024-06-19"],
		dateFormat: "Y-m-d",
	});
}

// Initialize  Multiple Dates Flatpickr
function initMultipleDatesFlatpickr() {
	$("#multipleDatesFlatpickr").flatpickr({
		mode: "multiple",
		dateFormat: "Y-m-d",
		defaultDate: ["2023-10-20", "2023-11-04"],
	});
}

// Initialize Range Calendar Flatpickr
function initRangeCalendarFlatpickr() {
	$("#rangeCalendarFlatpickr").flatpickr({
		mode: "range",
		dateFormat: "Y-m-d",
		defaultDate: ["2023-10-05", "2023-10-20"],
	});
}

// Initialize Time Picker Flatpickr
function initTimePickerFlatpickr() {
	$("#timePickerFlatpickr").flatpickr({
		enableTime: true,
		noCalendar: true,
		dateFormat: "H:i",
		minTime: "16:00",
		maxTime: "22:30",
	});
}

// Initialize Week Numbers Flatpickr
function initWeekNumbersFlatpickr() {
	$("#weekNumbersFlatpickr").flatpickr({
		weekNumbers: true,
		dateFormat: "Y-m-d",
	});
}

// Initialize Custom Events Flatpickr
function initCustomEvents() {
	$("#customEventsFlatpickr").flatpickr({
		onDayCreate: function (dObj, dStr, fp, dayElem) {
			if (Math.random() < 0.15) dayElem.innerHTML += "<span class='event'></span>";
			else if (Math.random() > 0.85) dayElem.innerHTML += "<span class='event busy'></span>";
		},
	});
}

//Public method to initialize all charts
(function () {
	initbasicFlatpickr();
	initDateTimeFlatpickr();
	initDisablingFlatpickr();
	initMultipleDatesFlatpickr();
	initRangeCalendarFlatpickr();
	initTimePickerFlatpickr();
	initWeekNumbersFlatpickr();
	initCustomEvents();
})();
