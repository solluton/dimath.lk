"use strict";

// Initialize Snow Theme
function initQuillSnowTheme() {
	var quill = new Quill("#quillSnowTheme", {
		modules: {
			toolbar: [[{ header: [1, 2, 3, 4, 5, 6] }], [{ color: [] }, { background: [] }], ["bold", "italic", "underline"], ["image", "code-block"]],
		},
		placeholder: "Compose an epic...",
		theme: "snow",
	});
}

// Initialize Bubble Theme
function initQuillBubbleTheme() {
	var quill = new Quill("#quillBubbleTheme", {
		modules: {
			toolbar: [[{ header: [1, 2, 3, 4, 5, 6] }], [{ color: [] }, { background: [] }], ["bold", "italic", "underline"], ["image", "code-block"]],
		},
		placeholder: "Compose an epic...",
		theme: "bubble",
	});
}

// Initialize Autosave
function initQuillAutosave() {
	var Delta = Quill.import("delta");
	var quill = new Quill("#quillAutosave", {
		modules: {
			toolbar: [[{ header: [1, 2, 3, 4, 5, 6] }], [{ color: [] }, { background: [] }], ["bold", "italic", "underline"], ["image", "code-block"]],
		},
		placeholder: "Compose an epic...",
		theme: "snow",
	});

	// Store accumulated changes
	var change = new Delta();
	quill.on("text-change", function (delta) {
		change = change.compose(delta);
	});

	// Save periodically
	setInterval(function () {
		if (change.length() > 0) {
			console.log("Saving changes", change);
			/* 
			Send partial changes
			$.post('/your-endpoint', { 
			partial: JSON.stringify(change) 
			});
			
			Send entire document
			$.post('/your-endpoint', { 
			doc: JSON.stringify(quill.getContents())
			});
			*/
			change = new Delta();
		}
	}, 5 * 1000);

	// Check for unsaved data
	window.onbeforeunload = function () {
		if (change.length() > 0) {
			return "There are unsaved changes. Are you sure you want to leave?";
		}
	};
}

// Initialize Full Editor
function initQuillFullEditor() {
	var quill = new Quill("#quillFullEditor", {
		modules: {
			toolbar: [[{ header: [1, 2, 3, 4, 5, 6] }], [{ font: [] }, { size: [] }], ["bold", "italic", "underline", "strike"], [{ color: [] }, { background: [] }], [{ script: "super" }, { script: "sub" }], ["blockquote", "code-block"], [{ list: "ordered" }, { list: "bullet" }, { indent: "-1" }, { indent: "+1" }], ["direction", { align: [] }], ["link", "image", "video", "formula"], ["clean"]],
		},
		placeholder: "Compose an epic...",
		theme: "snow",
	});
}

//Public method to initialize all charts
(function () {
	initQuillSnowTheme();
	initQuillBubbleTheme();
	initQuillAutosave();
	initQuillFullEditor();
})();
