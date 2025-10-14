"use strict";

// Initialize Summernote Basic
function initSummernoteBasic() {
	$("#summernoteBasic").summernote({
		tabsize: 2,
		height: 300,
	});
}

// Initialize Summernote Multiple
function initSummernoteMultiple() {
	$(".summernoteMultiple").summernote({
		tabsize: 2,
		height: 200,
	});
}

// Initialize Summernote AirMode
function initSummernoteAirMode() {
	$("#summernoteAirMode").summernote({
		tabsize: 2,
		height: 300,
		airMode: true,
	});
}

// Initialize Summernote ClickToEdit
function initSummernoteClickToEdit() {
	(window.edit = function () {
		$(".click2edit").summernote();
	}),
		(window.save = function () {
			$(".click2edit").summernote("destroy");
		});

	var edit = function () {
		$(".click2edit").summernote({ focus: true });
	};

	var save = function () {
		var markup = $(".click2edit").summernote("code");
		$(".click2edit").summernote("destroy");
	};
}

//Public method to initialize all charts
(function () {
	initSummernoteBasic();
	initSummernoteMultiple();
	initSummernoteAirMode();
	initSummernoteClickToEdit();
})();
