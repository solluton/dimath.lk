"use strict";

function createSlider(id, options) {
	const slider = document.getElementById(id);
	if (slider) {
		noUiSlider.create(slider, options);
	}
}

function initializeSliders() {
	const isRtl = false;

	createSlider("sliderBasic", {
		start: [50],
		connect: [true, false],
		direction: isRtl ? "rtl" : "ltr",
		range: {
			min: 0,
			max: 100,
		},
	});

	createSlider("sliderHandles", {
		start: [0, 50],
		direction: isRtl ? "rtl" : "ltr",
		step: 5,
		connect: true,
		range: {
			min: 0,
			max: 100,
		},
		pips: {
			mode: "range",
			density: 5,
			stepped: true,
		},
	});

	createSlider("sliderSteps", {
		start: [0, 50],
		snap: true,
		connect: true,
		direction: isRtl ? "rtl" : "ltr",
		range: {
			min: 0,
			"10%": 10,
			"20%": 20,
			"30%": 30,
			"40%": 40,
			"50%": 50,
			max: 100,
		},
	});

	createSlider("sliderTap", {
		start: [10, 30],
		behaviour: "tap",
		direction: isRtl ? "rtl" : "ltr",
		connect: true,
		range: {
			min: 10,
			max: 100,
		},
	});

	createSlider("sliderDrag", {
		start: [40, 60],
		limit: 20,
		behaviour: "drag",
		direction: isRtl ? "rtl" : "ltr",
		connect: true,
		range: {
			min: 20,
			max: 80,
		},
	});

	createSlider("sliderFixedDrag", {
		start: [40, 60],
		behaviour: "drag-fixed",
		direction: isRtl ? "rtl" : "ltr",
		connect: true,
		range: {
			min: 20,
			max: 80,
		},
	});

	createSlider("sliderCombinedOptions", {
		start: [40, 60],
		behaviour: "drag-tap",
		direction: isRtl ? "rtl" : "ltr",
		connect: true,
		range: {
			min: 20,
			max: 80,
		},
	});

	createSlider("sliderPips", {
		start: [10],
		behaviour: "tap-drag",
		step: 10,
		tooltips: true,
		range: {
			min: 0,
			max: 100,
		},
		pips: {
			mode: "steps",
			stepped: true,
			density: 5,
		},
		direction: isRtl ? "rtl" : "ltr",
	});
}

function initializeDynamicSlider() {
	const dynamicSlider = document.getElementById("sliderDynamic");
	const selectSlider = document.getElementById("sliderSelect");
	const inputSlider = document.getElementById("sliderInput");

	if (dynamicSlider) {
		// Initialize the slider with appropriate options
		noUiSlider.create(dynamicSlider, {
			start: [10, 30],
			connect: true,
			direction: "ltr", // Change "isRtl" to "ltr" for left-to-right direction
			range: {
				min: -20,
				max: 40,
			},
		});

		// Update input and select elements when the slider changes
		dynamicSlider.noUiSlider.on("update", function (values, handle) {
			if (handle === 1) {
				inputSlider.value = Math.round(values[handle]);
			} else {
				selectSlider.value = Math.round(values[handle]);
			}
		});
	}

	if (selectSlider) {
		for (let value = -20; value <= 40; value++) {
			const option = document.createElement("option");
			option.text = value;
			option.value = value;
			selectSlider.appendChild(option);
		}

		selectSlider.addEventListener("change", function () {
			dynamicSlider.noUiSlider.set([this.value, null]);
		});
	}

	if (inputSlider) {
		inputSlider.addEventListener("change", function () {
			dynamicSlider.noUiSlider.set([null, this.value]);
		});
	}
}

function initializeVerticalSliders() {
	const verticalSlider = document.getElementById("sliderVertical");
	const upperConnectSlider = document.getElementById("sliderConnectUpper");
	const verticalTooltipSlider = document.getElementById("sliderVerticalTooltip");
	const verticalLimitSlider = document.getElementById("sliderVerticalLimit");

	if (verticalSlider) {
		verticalSlider.style.height = "200px";
		noUiSlider.create(verticalSlider, {
			start: [40, 60],
			orientation: "vertical",
			behaviour: "drag",
			connect: true,
			range: { min: 0, max: 100 },
		});
	}

	if (upperConnectSlider) {
		upperConnectSlider.style.height = "200px";
		noUiSlider.create(upperConnectSlider, {
			start: 40,
			orientation: "vertical",
			behaviour: "drag",
			connect: "upper",
			range: { min: 0, max: 100 },
		});
	}

	if (verticalTooltipSlider) {
		verticalTooltipSlider.style.height = "200px";
		noUiSlider.create(verticalTooltipSlider, {
			start: 10,
			orientation: "vertical",
			behaviour: "drag",
			tooltips: true,
			range: { min: 0, max: 100 },
		});
	}

	if (verticalLimitSlider) {
		verticalLimitSlider.style.height = "200px";
		noUiSlider.create(verticalLimitSlider, {
			start: [0, 40],
			orientation: "vertical",
			behaviour: "drag",
			limit: 60,
			tooltips: true,
			connect: true,
			range: { min: 0, max: 100 },
		});
	}
}

function initializeThemesSlider() {
	const isRtl = false; // Replace false with true if you need RTL direction
	const primarySlider = document.getElementById("sliderPrimary");
	if (primarySlider) {
		const sliderOptions = {
			start: [20, 50],
			connect: true,
			behaviour: "tap-drag",
			step: 10,
			tooltips: true,
			range: {
				min: 0,
				max: 100,
			},
			direction: isRtl ? "rtl" : "ltr",
		};

		createSlider("sliderPrimary", sliderOptions);
		createSlider("sliderSuccess", sliderOptions);
		createSlider("sliderDanger", sliderOptions);
		createSlider("sliderInfo", sliderOptions);
		createSlider("sliderWarning", sliderOptions);
	}
	function createSlider(sliderId, options) {
		const sliderElement = document.getElementById(sliderId);
		noUiSlider.create(sliderElement, options);

		// Custom color styling based on the slider ID
		switch (sliderId) {
			case "sliderPrimary":
				sliderElement.querySelector(".noUi-connect").classList.add("bg-primary");
				break;
			case "sliderSuccess":
				sliderElement.querySelector(".noUi-connect").classList.add("bg-success");
				break;
			case "sliderDanger":
				sliderElement.querySelector(".noUi-connect").classList.add("bg-danger");
				break;
			case "sliderInfo":
				sliderElement.querySelector(".noUi-connect").classList.add("bg-info");
				break;
			case "sliderWarning":
				sliderElement.querySelector(".noUi-connect").classList.add("bg-warning");
				break;
			default:
				// Handle default color for other sliders
				sliderElement.querySelector(".noUi-connect").classList.add("bg-primary");
				break;
		}

		// Event listener to handle the upper handle's background color
		sliderElement.noUiSlider.on("update", function (values, handle) {
			const upperHandleIndex = sliderElement.noUiSlider.get().length - 1;
			if (handle === upperHandleIndex) {
				const upperHandle = sliderElement.querySelector(".noUi-handle-upper");
				if (upperHandle) {
					switch (sliderId) {
						case "sliderPrimary":
							upperHandle.classList.add("bg-primary");
							break;
						case "sliderSuccess":
							upperHandle.classList.add("bg-success");
							break;
						case "sliderDanger":
							upperHandle.classList.add("bg-danger");
							break;
						case "sliderInfo":
							upperHandle.classList.add("bg-info");
							break;
						case "sliderWarning":
							upperHandle.classList.add("bg-warning");
							break;
						default:
							// Handle default color for other sliders
							upperHandle.classList.add("bg-primary");
							break;
					}
				}
			}
		});
	}
}

(function () {
	initializeSliders();
	initializeDynamicSlider();
	initializeVerticalSliders();
	initializeThemesSlider();
})();
