"use strict";

// Initialize Dropzone Basic
function initDropzoneBasic() {
	var dropzone = new Dropzone("#dropzoneBasic", {
		url: "./../../assets/images/upload",
		paramName: "file",
		paramName: "file",
		maxFiles: 1,
		maxFilesize: 5,
		addRemoveLinks: true,
	});
}

// Initialize Dropzone Multiple
function initDropzoneMultiple() {
	var dropzone = new Dropzone("#dropzoneMultiple", {
		url: "./../../assets/images/upload",
		paramName: "file",
		paramName: "file",
		maxFiles: 10,
		maxFilesize: 10,
		addRemoveLinks: true,
	});
}

//Public method to initialize all charts
(function () {
	initDropzoneBasic();
	initDropzoneMultiple();
})();
