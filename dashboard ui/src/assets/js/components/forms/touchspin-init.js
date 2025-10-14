"use strict";

// Default TouchSpin
$("input[name='edash_touchspin_default']").TouchSpin();

// TouchSpin with custom button classes
$("input[name='edash_touchspin_basic']").TouchSpin({
	buttondown_class: "btn btn-light",
	buttonup_class: "btn btn-light",
});

// TouchSpin with empty initial value and custom button classes
$("input[name='edash_touchspin_empty_value']").TouchSpin({
	buttondown_class: "btn btn-light",
	buttonup_class: "btn btn-light",
});

// TouchSpin with prefix, min, max, step, and custom button classes
$("input[name='edash_touchspin_prefix']").TouchSpin({
	min: 0,
	max: 100,
	step: 1,
	boostat: 5,
	prefix: "$",
	maxboostedstep: 10,
	buttondown_class: "btn btn-light",
	buttonup_class: "btn btn-light",
});

// TouchSpin with postfix, min, max, step, decimals, and custom button classes
$("input[name='edash_touchspin_postfix']").TouchSpin({
	min: 0,
	max: 100,
	step: 0.1,
	decimals: 2,
	boostat: 5,
	postfix: "%",
	maxboostedstep: 10,
	buttondown_class: "btn btn-light",
	buttonup_class: "btn btn-light",
});

// TouchSpin with vertical buttons, prefix, and custom button classes
$("input[name='edash_touchspin_vertical']").TouchSpin({
	prefix: "$",
	verticalbuttons: true,
	buttondown_class: "btn btn-light",
	buttonup_class: "btn btn-light",
});

// TouchSpin with initial value and prefix
$("input[name='edash_touchspin_initval']").TouchSpin({
	prefix: "$",
	initval: 40,
	buttondown_class: "btn btn-light",
	buttonup_class: "btn btn-light",
});

// TouchSpin with small size, prefix, and custom button classes
$("input[name='edash_touchspin_sm']").TouchSpin({
	prefix: "$",
	buttondown_class: "btn btn-light",
	buttonup_class: "btn btn-light",
});

// TouchSpin with large size, prefix, and custom button classes
$("input[name='edash_touchspin_lg']").TouchSpin({
	prefix: "$",
	buttondown_class: "btn btn-light",
	buttonup_class: "btn btn-light",
});

// TouchSpin with prefix, postfix, and custom button classes
$("input[name='edash_touchspin_button_group']").TouchSpin({
	prefix: "$",
	postfix: "%",
	buttondown_class: "btn btn-light",
	buttonup_class: "btn btn-light",
});
