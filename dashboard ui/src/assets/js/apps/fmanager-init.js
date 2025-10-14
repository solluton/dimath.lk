"use strict";

/*
<--!----------------------------------------------------------------!-->
<--! Dropzone Files Uploader !-->
<--!----------------------------------------------------------------!-->
*/
function initDropzoneFilesUploader() {
	$("#fileUploadDropzone").dropzone({
		url: "/file/post",
	});
}

/*
<--!----------------------------------------------------------------!-->
<--! Initialize Functions !-->
<--!----------------------------------------------------------------!-->
*/
$(function () {
	initDropzoneFilesUploader();
});
