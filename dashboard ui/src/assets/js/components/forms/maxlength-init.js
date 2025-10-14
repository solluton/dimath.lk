"use strict";

// Default maxlength setup
$("input[name='edash_maxlength_default']").maxlength();

// Maxlength with a threshold of 20
$("input[name='edash_maxlength_threshold']").maxlength({
	threshold: 20,
});

// Maxlength with a threshold of 10 and alwaysShow option
$("input[name='edash_maxlength_always_show']").maxlength({
	threshold: 10,
	alwaysShow: true,
});

// Maxlength with a threshold of 10, alwaysShow option, and custom separator and texts
$("input[name='edash_maxlength_with_text']").maxlength({
	threshold: 10,
	alwaysShow: true,
	separator: " of ",
	preText: "You have ",
	postText: " chars remaining",
});

// Maxlength with a threshold of 10, alwaysShow option, and custom warning and limitReached classes
$("input[name='edash_maxlength_with_badge']").maxlength({
	threshold: 10,
	alwaysShow: true,
	warningClass: "badge bg-success",
	limitReachedClass: "badge bg-danger",
});

// Maxlength for a textarea with a threshold of 10, alwaysShow option, and custom separator and texts
$("textarea[name='edash_maxlength_textarea']").maxlength({
	threshold: 10,
	alwaysShow: true,
	separator: " of ",
	preText: "You have ",
	postText: " chars remaining",
	warningClass: "badge bg-success",
	limitReachedClass: "badge bg-danger",
});

// Maxlength with a threshold of 10, alwaysShow option, and custom placement at top-left
$("input[name='edash_maxlength_placement_top_left']").maxlength({
	threshold: 10,
	alwaysShow: true,
	warningClass: "badge bg-success",
	limitReachedClass: "badge bg-danger",
	placement: "top-left",
});

// Maxlength with a threshold of 10, alwaysShow option, and custom placement at top-right
$("input[name='edash_maxlength_placement_top_right']").maxlength({
	threshold: 10,
	alwaysShow: true,
	warningClass: "badge bg-success",
	limitReachedClass: "badge bg-danger",
	placement: "top-right",
});

// Maxlength with a threshold of 10, alwaysShow option, and custom placement at bottom-left
$("input[name='edash_maxlength_placement_bottom_left']").maxlength({
	threshold: 10,
	alwaysShow: true,
	warningClass: "badge bg-success",
	limitReachedClass: "badge bg-danger",
	placement: "bottom-left",
});

// Maxlength with a threshold of 10, alwaysShow option, and custom placement at bottom-right
$("input[name='edash_maxlength_placement_bottom_right']").maxlength({
	threshold: 10,
	alwaysShow: true,
	warningClass: "badge bg-success",
	limitReachedClass: "badge bg-danger",
	placement: "bottom-right",
});

// Maxlength with a threshold of 10, alwaysShow option, and custom placement at centered-right
$("input[name='edash_maxlength_placement_centered_right']").maxlength({
	threshold: 10,
	alwaysShow: true,
	warningClass: "badge bg-success",
	limitReachedClass: "badge bg-danger",
	placement: "centered-right",
});
