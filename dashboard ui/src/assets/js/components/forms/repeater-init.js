"use strict";

$(function () {
	// Initialize repeaters
	initRepeater("#repeaterBasic");
	initNestedRepeater("#repeaterNested");
	initRepeater("#repeaterAdvanced");

	var room = 1;

	function initRepeater(selector) {
		$(selector).repeater({
			initEmpty: false,
			defaultValues: {
				"text-input": "foo",
			},
			show: function () {
				$(this).slideDown();
			},
			hide: function (deleteElement) {
				$(this).slideUp(deleteElement);
			},
		});
	}

	function initNestedRepeater(selector) {
		$(selector).repeater({
			initEmpty: false,
			defaultValues: {
				"text-input": "foo",
			},
			show: function () {
				$(this).slideDown();
			},
			hide: function (deleteElement) {
				$(this).slideUp(deleteElement);
			},
			repeaters: [
				{
					selector: ".inner-repeater",
					initEmpty: false,
					defaultValues: {
						"text-input": "foo",
					},
					show: function () {
						$(this).slideDown();
					},
					hide: function (deleteElement) {
						$(this).slideUp(deleteElement);
					},
				},
			],
		});
	}

	function addDynamicRepeater() {
		room++;
		var objTo = document.getElementById("dynamicRepeaterPlace");
		var divtest = document.createElement("div");
		divtest.setAttribute("class", "mb-4 removeclass" + room);
		var rdiv = "removeclass" + room;
		divtest.innerHTML = '<form class="row">' + '<div class="col-lg-2 mb-2 mb-md-0">' + '<label class="form-label">Username:</label>' + '<input type="text" class="form-control mb-2 mb-md-0" id="dyn-username" name="dyn-username" />' + "</div>" + '<div class="col-lg-2 mb-2 mb-md-0">' + '<label class="form-label">Email:</label>' + '<input type="email" class="form-control" id="dyn-email" name="dyn-email" />' + "</div>" + '<div class="col-lg-2 mb-2 mb-md-0">' + '<label class="form-label">Password:</label>' + '<input type="password" class="form-control" id="dyn-password" name="dyn-password" />' + "</div>" + '<div class="col-lg-2 mb-2 mb-md-0">' + '<label class="form-label">Gender:</label>' + '<select class="form-select" id="dyn-genger" name="dyn-genger">' + "<option></option>" + '<option value="male">Male</option>' + '<option value="female">Female</option>' + '<option value="others">Others</option>' + "</select>" + "</div>" + '<div class="col-lg-2 mb-2 mb-md-0">' + '<label class="form-label">Profession:</label>' + '<select class="form-select" id="dyn-profession" name="dyn-profession">' + "<option ></option>" + '<option value="designer">Designer</option>' + '<option value="developer">Developer</option>' + '<option value="marketer">Marketer</option>' + '<option value="others">Others</option>' + "</select>" + "</div>" + '<div class="col-lg-2 mb-2 mb-md-0 pt-1">' + '<a href="javascript:void(0);" class="btn btn-md btn-soft-danger d-block mt-4" onclick="removeDynamicRepeater(' + room + ');">' + '<i class="fi fi-rr-trash"></i>' + '<span class="ms-2">Delete</span>' + "</a>" + "</div>" + "</form>";

		objTo.appendChild(divtest);
	}

	function removeDynamicRepeater(rid) {
		$(".removeclass" + rid).remove();
	}

	// Expose the functions to the global scope if needed
	window.addDynamicRepeater = addDynamicRepeater;
	window.removeDynamicRepeater = removeDynamicRepeater;
});
