"use strict";

// Single Select
function initSingleSelect() {
	$('[data-select="single"]').select2({
		placeholder: "--select--",
	});
}

// Multiple Select
function initMultipleSelect() {
	$('[data-select="multiple"]').select2({
		tags: true,
		closeOnSelect: false,
		placeholder: "--select--",
	});
}

// Image Select
function initImageSelect() {
	$('[data-select="image"]').select2({
		placeholder: "--select--",
		templateResult: function (data) {
			if (!data.id || data.id === "") {
				return data.text;
			}
			return $(`<span class="hstack gap-3"><img src="${data.element.getAttribute("data-image")}" class="img-fluid wd-20 ht-20 rounded-circle" /> ${data.text}</span>`);
		},
		escapeMarkup: function (markup) {
			return markup;
		},
		templateSelection: function (selected) {
			if (!selected.id || selected.id === "") {
				return selected.text;
			}
			const imageSrc = selected.element.getAttribute("data-image");
			return $(`<span class="hstack gap-3"><img src="${imageSrc}" class="img-fluid wd-20 ht-20 rounded-circle" /> ${selected.text}</span>`);
		},
	});
}

// Icon Select
function initIconSelect() {
	$('[data-select="icon"]').select2({
		placeholder: "--select--",
		templateResult: function (data) {
			if (!data.id || data.id === "") {
				return data.text;
			}
			return $(`<span class="hstack gap-3"><i class="${data.element.getAttribute("data-icon")} select-icon"></i> ${data.text}</span>`);
		},
		escapeMarkup: function (markup) {
			return markup;
		},
		templateSelection: function (selected) {
			if (!selected.id || selected.id === "") {
				return selected.text;
			}
			return $(`<span class="hstack gap-3"><i class="${selected.element.getAttribute("data-icon")} select-icon"></i> ${selected.text}</span>`);
		},
	});
}

function initBgSelect() {
	$('[data-select="bg"]').select2({
		placeholder: "--select--",
		templateResult: function (data) {
			if (!data.id || data.id === "") {
				return data.text;
			}
			const bgColorClass = data.element.getAttribute("data-bg");
			return $(`
                <span>
                    <span class="d-inline-block wd-6 ht-6 rounded-circle flex-shrink-0 me-2 bg-${bgColorClass}"></span>
                    ${data.text}
                </span>
            `);
		},
		escapeMarkup: function (markup) {
			return markup;
		},
		templateSelection: function (selected) {
			if (!selected.id || selected.id === "") {
				return selected.text;
			}
			const bgColorClass = selected.element.getAttribute("data-bg");
			return $(`
                <span>
                    <span class="d-inline-block wd-6 ht-6 rounded-circle flex-shrink-0 me-2 bg-${bgColorClass}"></span>
                    ${selected.text}
                </span>
            `);
		},
	});
}

//Public method to initialize all charts
(function () {
	initSingleSelect();
	initMultipleSelect();
	initImageSelect();
	initIconSelect();
	initBgSelect();
})();
