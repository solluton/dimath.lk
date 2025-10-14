"use strict";

function initializeBasicClipboard() {
	var clipboard = new ClipboardJS("#clipboardBasicTrigger", {
		text: function () {
			var input = document.getElementById("clipboardBasic");
			return input.value;
		},
	});

	clipboard.on("success", function (e) {
		e.clearSelection();
		var input = document.getElementById("clipboardBasic");
		input.select();

		var copyButton = document.getElementById("clipboardBasicTrigger");
		copyButton.textContent = "Copied!";

		setTimeout(function () {
			copyButton.textContent = "Copy";
		}, 3000);
	});
}

function initializeCutClipboard() {
	var textarea = document.getElementById("clipboardCut");
	var copyButton = document.getElementById("clipboardCutTrigger");

	copyButton.addEventListener("click", function () {
		textarea.select();
		document.execCommand("cut");
		copyButton.textContent = "Copied!";
		setTimeout(function () {
			copyButton.textContent = "Cut to clipboard";
		}, 3000);
	});
}

function initializePredefinedClipboard() {
	var copyButton = document.getElementById("clipboardPredefinedTrigger");

	// Initialize Clipboard.js with the target button
	var clipboard = new ClipboardJS(copyButton);

	// When the copy event is successful
	clipboard.on("success", function (e) {
		copyButton.textContent = "Copied!";
		setTimeout(function () {
			copyButton.textContent = "Cut to clipboard";
		}, 3000);
	});

	// When the copy event fails (not supported by the browser)
	clipboard.on("error", function (e) {
		console.error("Action:", e.action);
		console.error("Trigger:", e.trigger);
	});
}

function initializeCustomClipboard() {
	var clipboard = new ClipboardJS("#clipboardCustomTrigger", {
		text: function () {
			var input = document.getElementById("clipboardCustom");
			return input.value;
		},
	});

	clipboard.on("success", function (e) {
		e.clearSelection();

		var input = document.getElementById("clipboardCustom");
		var copyButton = document.getElementById("clipboardCustomTrigger");
		var copyIcon = document.getElementById("copyIcon");

		// Change the icon to a checkmark (Feather)
		copyIcon.setAttribute("data-feather", "check");
		// Update the Feather icon to reflect the changes
		// feather.replace();

		// Remove the soft-primary class and add btn-success class
		copyButton.classList.remove("btn-soft-primary");
		copyButton.classList.add("btn-success");

		// Change input border color and text color on success
		input.style.borderColor = "#28a745"; // Green color for success
		input.style.color = "#28a745"; // Green color for success

		setTimeout(function () {
			// Reset the icon to the copy icon (Feather)
			copyIcon.setAttribute("data-feather", "copy");

			// Remove the btn-success class and add btn-soft-primary class
			copyButton.classList.remove("btn-success");
			copyButton.classList.add("btn-soft-primary");

			// Reset input border color and text color
			input.style.borderColor = ""; // Reset to default
			input.style.color = ""; // Reset to default
		}, 3000);
	});
}

document.addEventListener("DOMContentLoaded", function () {
	initializeBasicClipboard();
	initializeCutClipboard();
	initializePredefinedClipboard();
	initializeCustomClipboard();
});
