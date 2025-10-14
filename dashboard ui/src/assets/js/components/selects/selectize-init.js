"use strict";

//  Default Selectize
function initDefaultSelectize() {
	$("#default").selectize();
}

//  Multiple Selectize
function initMultipleSelectize() {
	$("#multiple").selectize();
}

// Option Group Selectize
function initOptionGroupSelectize() {
	$("#OptionGroup").selectize({
		options: [
			{ manufacturer: "nintendo", value: "nes", name: "Nintendo Entertainment System" },
			{ manufacturer: "nintendo", value: "snes", name: "Super Nintendo Entertainment System" },
			{ manufacturer: "nintendo", value: "n64", name: "Nintendo 64" },
			{ manufacturer: "nintendo", value: "gamecube", name: "GameCube" },
			{ manufacturer: "nintendo", value: "wii", name: "Wii" },
			{ manufacturer: "microsoft", value: "xss", name: "Xbox Series S" },
			{ manufacturer: "nintendo", value: "wiiu", name: "Wii U" },
			{ manufacturer: "nintendo", value: "switch", name: "Switch" },
			{ manufacturer: "sony", value: "ps1", name: "PlayStation" },
			{ manufacturer: "sony", value: "ps2", name: "PlayStation 2" },
			{ manufacturer: "sony", value: "ps3", name: "PlayStation 3" },
			{ manufacturer: "sony", value: "ps4", name: "PlayStation 4" },
			{ manufacturer: "sony", value: "ps5", name: "PlayStation 5" },
			{ manufacturer: "microsoft", value: "xbox", name: "Xbox" },
			{ manufacturer: "microsoft", value: "360", name: "Xbox 360" },
			{ manufacturer: "microsoft", value: "xbone", name: "Xbox One" },
			{ manufacturer: "microsoft", value: "xsx", name: "Xbox Series X" },
		],
		optionGroupRegister: function (optgroup) {
			var capitalised = optgroup.charAt(0).toUpperCase() + optgroup.substring(1);
			var group = {
				label: "Manufacturer: " + capitalised,
			};

			group[this.settings.optgroupValueField] = optgroup;

			return group;
		},
		optgroupField: "manufacturer",
		labelField: "name",
		searchField: ["name"],
		sortField: "name",
	});
}

// Dynamic Selectize
function initDynamicSelectize() {
	$("#dynamic").selectize({
		maxItems: null,
		valueField: "id",
		labelField: "title",
		searchField: "title",
		options: [
			{ id: 1, title: "Spectrometer", url: "http://en.wikipedia.org/wiki/Spectrometers" },
			{ id: 2, title: "Star Chart", url: "http://en.wikipedia.org/wiki/Star_chart" },
			{ id: 3, title: "Electrical Tape", url: "http://en.wikipedia.org/wiki/Electrical_tape" },
		],
		create: false,
	});
}

// Validation Selectize
function initSelectizeValidation() {
	const REGEX_EMAIL = "([a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@" + "(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)";

	$("#validation").selectize({
		persist: false,
		maxItems: null,
		valueField: "email",
		labelField: "name",
		searchField: ["name", "email"],
		options: [{ email: "brian@thirdroute.com", name: "Brian Reavis" }, { email: "nikola@tesla.com", name: "Nikola Tesla" }, { email: "malanie@hanvey.com", name: "Malanie Hanvey" }, { email: "socrates@itumay.com", name: "Socrates Itumay" }, { email: "someone@gmail.com" }],
		render: {
			item: function (item, escape) {
				return "<div class='px-3 py-2'>" + (item.name ? '<span class="h6 me-2">' + escape(item.name) + "</span>" : "") + (item.email ? '<span class="fs-12 text-muted">' + escape(item.email) + "</span>" : "") + "</div>";
			},
			option: function (item, escape) {
				var label = item.name || item.email;
				var caption = item.name ? item.email : null;
				return "<div class='px-3 py-2'>" + '<span class="h6 mb-1 d-block">' + escape(label) + "</span>" + (caption ? '<span class="fs-12 text-muted d-block">' + escape(caption) + "</span>" : "") + "</div>";
			},
		},
		createFilter: function (input) {
			var match, regex;

			// email@address.com
			regex = new RegExp("^" + REGEX_EMAIL + "$", "i");
			match = input.match(regex);
			if (match) return !this.options.hasOwnProperty(match[0]);

			// name <email@address.com>
			regex = new RegExp("^([^<]*)<" + REGEX_EMAIL + ">$", "i");
			match = input.match(regex);
			if (match) return !this.options.hasOwnProperty(match[2]);

			return false;
		},
		create: function (input) {
			if (new RegExp("^" + REGEX_EMAIL + "$", "i").test(input)) {
				return { email: input };
			}
			var match = input.match(new RegExp("^([^<]*)<" + REGEX_EMAIL + ">$", "i"));
			if (match) {
				return {
					email: match[2],
					name: $.trim(match[1]),
				};
			}
			alert("Invalid email address.");
			return false;
		},
	});
}

// Maximum Selectize
function initMaximumSelectize() {
	$("#maximum").selectize({ maxItems: 3 });
}

// Columns Selectize
function initColumnsSelectize() {
	$("#columns").selectize({
		options: [
			{ id: "avenger", make: "dodge", model: "Avenger" },
			{ id: "caliber", make: "dodge", model: "Caliber" },
			{
				id: "caravan-grand-passenger",
				make: "dodge",
				model: "Caravan Grand Passenger",
			},
			{ id: "challenger", make: "dodge", model: "Challenger" },
			{ id: "ram-1500", make: "dodge", model: "Ram 1500" },
			{ id: "viper", make: "dodge", model: "Viper" },
			{ id: "a3", make: "audi", model: "A3" },
			{ id: "a6", make: "audi", model: "A6" },
			{ id: "r8", make: "audi", model: "R8" },
			{ id: "rs-4", make: "audi", model: "RS 4" },
			{ id: "s4", make: "audi", model: "S4" },
			{ id: "s8", make: "audi", model: "S8" },
			{ id: "tt", make: "audi", model: "TT" },
			{ id: "avalanche", make: "chevrolet", model: "Avalanche" },
			{ id: "aveo", make: "chevrolet", model: "Aveo" },
			{ id: "cobalt", make: "chevrolet", model: "Cobalt" },
			{ id: "silverado", make: "chevrolet", model: "Silverado" },
			{ id: "suburban", make: "chevrolet", model: "Suburban" },
			{ id: "tahoe", make: "chevrolet", model: "Tahoe" },
			{ id: "trail-blazer", make: "chevrolet", model: "TrailBlazer" },
		],
		optgroups: [
			{ id: "dodge", name: "Dodge" },
			{ id: "audi", name: "Audi" },
			{ id: "chevrolet", name: "Chevrolet" },
		],
		labelField: "model",
		valueField: "id",
		optgroupField: "make",
		optgroupLabelField: "name",
		optgroupValueField: "id",
		optgroupOrder: ["chevrolet", "dodge", "audi"],
		searchField: ["model"],
		plugins: ["optgroup_columns"],
	});
}

// Remove Selectize
function initRemoveSelectize() {
	$("#remove").selectize({
		plugins: ["remove_button"],
		delimiter: ",",
		persist: false,
		create: function (input) {
			return {
				value: input,
				text: input,
			};
		},
	});
}

//Public method to initialize all charts
(function () {
	initDefaultSelectize();
	initMultipleSelectize();
	initOptionGroupSelectize();
	initDynamicSelectize();
	initSelectizeValidation();
	initMaximumSelectize();
	initColumnsSelectize();
	initRemoveSelectize();
})();
