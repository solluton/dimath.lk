"use strict";

// Initialize Limited Items
function initLimitedItems() {
	const choicesLimitedItems = new Choices(document.getElementById("choicesLimitedItems"), {
		allowHTML: true,
		delimiter: ",",
		editItems: true,
		maxItemCount: 5,
		removeItemButton: true,
	});
}

// Initialize Unique Values
function initUniqueValues() {
	const choicesUniqueValues = new Choices(document.getElementById("choicesUniqueValues"), {
		allowHTML: true,
		paste: false,
		duplicateItemsAllowed: false,
		editItems: true,
	});
}

// Initialize Email Addresses
function initEmailAddresses() {
	const choicesEmailAddresses = new Choices(document.getElementById("choicesEmailAddresses"), {
		allowHTML: true,
		editItems: true,
		addItemFilter: function (value) {
			if (!value) {
				return false;
			}

			const regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			const expression = new RegExp(regex.source, "i");
			return expression.test(value);
		},
	});
}

// Initialize Disabled Items
// function initDisabledItems() {
// 	const choicesDisabledItems = new Choices(document.getElementById("choicesDisabledItems"), {
// 		allowHTML: true,
// 		editItems: true,
// 	}).disable();
// }

// Initialize Choices Multiple Select
function initChoicesMultipleSelect() {
	const choicesMultipleSelect = new Choices(document.getElementById("choicesMultipleSelect"), {
		allowHTML: true,
		editItems: true,
		maxItemCount: 4,
		removeItemButton: true,
	});
}

// Initialize Choices Multiple Select
function initChoicesOptiontGroups() {
	const choicesOptiontGroups = new Choices(document.getElementById("choicesOptiontGroups"), {
		allowHTML: true,
		editItems: true,
		maxItemCount: 8,
		removeItemButton: true,
	});
}

// Initialize Choices Custom Templates
function initChoicesCustomTemplates() {
	const choicesCustomTemplates = new Choices(document.getElementById("choicesCustomTemplates"), {
		allowHTML: true,
		editItems: true,
		maxItemCount: 5,
		removeItemButton: true,
		callbackOnCreateTemplates: function (strToEl) {
			var classNames = this.config.classNames;
			var itemSelectText = this.config.itemSelectText;
			return {
				item: function ({ classNames }, data) {
					return strToEl(
						'\
                <div\
                  class="' +
							String(classNames.item) +
							" " +
							String(data.highlighted ? classNames.highlightedState : classNames.itemSelectable) +
							'"\
                  data-item\
                  data-id="' +
							String(data.id) +
							'"\
                  data-value="' +
							String(data.value) +
							'"\
                  ' +
							String(data.active ? 'aria-selected="true"' : "") +
							"\
                  " +
							String(data.disabled ? 'aria-disabled="true"' : "") +
							'\
                  >\
                  <span style="margin-right:4px;">🎉</span> ' +
							String(data.label) +
							"\
                </div>\
              "
					);
				},
				choice: function ({ classNames }, data) {
					return strToEl(
						'\
                <div\
                  class="' +
							String(classNames.item) +
							" " +
							String(classNames.itemChoice) +
							" " +
							String(data.disabled ? classNames.itemDisabled : classNames.itemSelectable) +
							'"\
                  data-select-text="' +
							String(itemSelectText) +
							'"\
                  data-choice \
                  ' +
							String(data.disabled ? 'data-choice-disabled aria-disabled="true"' : "data-choice-selectable") +
							'\
                  data-id="' +
							String(data.id) +
							'"\
                  data-value="' +
							String(data.value) +
							'"\
                  ' +
							String(data.groupId > 0 ? 'role="treeitem"' : 'role="option"') +
							'\
                  >\
                  <span style="margin-right:4px;">🎉</span> ' +
							String(data.label) +
							"\
                </div>\
              "
					);
				},
			};
		},
	});
}

//Public method to initialize all charts
(function () {
	initLimitedItems();
	initUniqueValues();
	initEmailAddresses();
	//initDisabledItems();
	initChoicesMultipleSelect();
	initChoicesOptiontGroups();
	initChoicesCustomTemplates();
})();
