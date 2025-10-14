"use strict";

/*
<--!----------------------------------------------------------------!-->
<--! Select All Checked !-->
<--!----------------------------------------------------------------!-->
*/
function initSelectChecked() {
	$("#checkAll").on("click", function () {
		if (this.checked) {
			$('.edash-email-check > [type="checkbox"]').each(function () {
				this.checked = true;
			});
		} else {
			$('.edash-email-check > [type="checkbox"]').each(function () {
				this.checked = false;
			});
		}
	});

	$('.edash-email-check > [type="checkbox"]').on("click", function () {
		if ($(this).is(":checked")) {
			var isAllChecked = 0;
			$('.edash-email-check > [type="checkbox"]').each(function () {
				if (!this.checked) isAllChecked = 1;
			});
			if (isAllChecked == 0) {
				$("#checkAll").prop("checked", true);
			}
		} else {
			$("#checkAll").prop("checked", false);
		}
	});
}

/*
<--!----------------------------------------------------------------!-->
<--! Email CC/BCC Toggler !-->
<--!----------------------------------------------------------------!-->
*/
function initCcBccToggler() {
	$("#edash-cc-toggle").on("click", function () {
		$("#edash-field-cc-toggle").toggle("fast");
	});
	$("#edash-bcc-toggle").on("click", function () {
		$("#edash-field-bcc-toggle").toggle("fast");
	});
}

/*
<--!----------------------------------------------------------------!-->
<--! Email Details Toggler !-->
<--!----------------------------------------------------------------!-->
*/
function initDetailsToggler() {
	$('[data-edash-trigger="edash-email-details-open"]').on("click", function () {
		$("#edash-email-details").addClass("edash-email-open");
	});
	$('[data-edash-trigger="edash-email-details-close"]').on("click", function () {
		$("#edash-email-details").removeClass("edash-email-open");
	});
}

/*
<--!----------------------------------------------------------------!-->
<--! Email Editor Toggler !-->
<--!----------------------------------------------------------------!-->
*/
function initEditorToggler() {
	$('[data-edash-target="edash-email-editor-show"]').on("click", function () {
		$("#edash-email-editor").show();
		$("#edash-email-reply-btn").hide();
		$("html,body").animate({
			scrollTop: $("#edash-email-editor").offset().top,
		});
	});
	$('[data-edash-target="edash-email-editor-hide"]').on("click", function () {
		$("#edash-email-editor").hide();
		$("#edash-email-reply-btn").show();
	});
}

/*
<--!----------------------------------------------------------------!-->
<--! Email Editor !-->
<--!----------------------------------------------------------------!-->
*/
function initEmailEditor() {
	var toolbarOptions = [
		["bold", "italic", "underline", "strike", "blockquote"],
		[{ list: "ordered" }, { list: "bullet" }],
		["link", "image", "code-block"],
	];
	var quill = new Quill("#mailEditor", {
		modules: {
			toolbar: toolbarOptions,
		},
		theme: "snow",
		placeholder: "Compose an epic...",
	});
}

/*
<--!----------------------------------------------------------------!-->
<--! Email Editor Modal !-->
<--!----------------------------------------------------------------!-->
*/
function initEmailEditorModal() {
	var toolbarOptions = [
		["bold", "italic", "underline", "strike", "blockquote"],
		[{ list: "ordered" }, { list: "bullet" }],
		["link", "image", "code-block"],
	];
	var quill = new Quill("#mailEditorModal", {
		modules: {
			toolbar: toolbarOptions,
		},
		theme: "snow",
		placeholder: "Compose an epic...",
	});
}

/*
<--!----------------------------------------------------------------!-->
<--! Initialize Functions !-->
<--!----------------------------------------------------------------!-->
*/
$(function () {
	initDetailsToggler();
	initSelectChecked();
	initCcBccToggler();
	initEditorToggler();
	initEmailEditor();
	initEmailEditorModal();
});
