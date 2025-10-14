"use strict";

// Initialize Basic TinyMCE
function initBasicTinyMCE() {
	tinymce.init({
		selector: "textarea#basicTinyMCE",
		height: "350",
		menubar: false,
		plugins: ["advlist", "autolink", "lists", "link", "image", "charmap", "preview", "anchor", "searchreplace", "visualblocks", "code", "fullscreen", "insertdatetime", "media", "table", "help", "wordcount"],
		toolbar: "undo redo | blocks | " + "bold italic backcolor | alignleft aligncenter " + "alignright alignjustify | bullist numlist outdent indent | " + "removeformat | help",
		content_style: "body { font-family:Outfit,sans-serif; font-size:13px; color: #495057;}",
	});
}

// Initialize Inline TinyMCE
function initInlineTinyMCE() {
	const emailHeaderConfig = {
		selector: ".tinymce-heading",
		menubar: false,
		inline: true,
		height: "350",
		plugins: ["lists", "autolink"],
		toolbar: "undo redo | bold italic underline",
		valid_elements: "strong,em,span[style],a[href]",
		valid_styles: {
			"*": "font-size,font-family,color,text-decoration,text-align",
		},
		content_style: "body { font-family:Outfit,sans-serif; font-size:13px; color: #495057;}",
	};

	const emailBodyConfig = {
		selector: ".tinymce-body",
		menubar: false,
		inline: true,
		height: "350",
		plugins: ["link", "lists", "autolink"],
		toolbar: ["undo redo | bold italic underline | fontfamily fontsize", "forecolor backcolor | alignleft aligncenter alignright alignfull | numlist bullist outdent indent"],
		valid_elements: "p[style],strong,em,span[style],a[href],ul,ol,li",
		valid_styles: {
			"*": "font-size,font-family,color,text-decoration,text-align",
		},
		content_style: "body { font-family:Outfit,sans-serif; font-size:13px; color: #495057;}",
	};

	tinymce.init(emailHeaderConfig);
	tinymce.init(emailBodyConfig);
}

// Initialize Full Featured
function initFullFeaturedTinyMCE() {
	tinymce.init({
		height: "350",
		selector: "#fullFeaturedTinyMCE",
		toolbar: ["styleselect fontselect fontsizeselect", "typography | fontfamily fontsize | blocks", "undo redo | cut copy paste | bold italic underline strikethrough | link image | alignleft aligncenter alignright alignjustify", "bullist numlist | outdent indent | blockquote subscript superscript | advlist | autolink | lists charmap |  preview |  code"],
		plugins: "advlist autolink link image lists charmap preview code",
		menubar: "file edit view insert format tools table tc help",
		valid_styles: {
			"*": "font-size,font-family,color,text-decoration,text-align",
		},
		content_style: "body { font-family:Outfit,sans-serif; font-size:13px; color: #495057;}",
		toolbar_sticky: true,
		toolbar_sticky_offset: 80,
		autosave_ask_before_unload: true,
		autosave_interval: "30s",
		autosave_prefix: "{path}{query}-{id}-",
		autosave_restore_when_empty: false,
		autosave_retention: "2m",
	});
}

//Public method to initialize all charts
(function () {
	initBasicTinyMCE();
	initInlineTinyMCE();
	initFullFeaturedTinyMCE();
})();
