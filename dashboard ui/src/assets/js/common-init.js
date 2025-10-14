"use strict";

/*
<--!----------------------------------------------------------------!-->
<--! Expodash Main Menu !-->
<--!----------------------------------------------------------------!-->
*/
function initExpodashMenu() {
	// Expodash metismenu init
	$("#edash-metismenu").metisMenu();

	// Event handler for the "edash-menu-mini" click
	$("#edash-menu-mini").on("click", function (e) {
		e.preventDefault();
		$("#edash-menu-mini").hide();
		$("#edash-menu-expand").show();
		$("html").addClass("edash-minimenu");
	});

	// Event handler for the "edash-menu-expand" click
	$("#edash-menu-expand").on("click", function (e) {
		e.preventDefault();
		$("#edash-menu-expand").hide();
		$("#edash-menu-mini").show();
		$("html").removeClass("edash-minimenu");
	});

	// Event handler for the "edash-menu-show" click
	$("#edash-menu-show").on("click", function (e) {
		e.preventDefault();
		$("html").addClass("edash-menu-show");
	});

	// Event handler for the "edash-menu-hide" click
	$("#edash-menu-hide").on("click", function (e) {
		e.preventDefault();
		$("html").removeClass("edash-menu-show");
	});

	// PerfectScrollbar for the "edash-sidebar-nav"
	$("#edash-sidebar-nav").each(function () {
		new PerfectScrollbar($(this)[0], {
			wheelSpeed: 0.5,
			suppressScrollX: true,
		});
	});
}

/*
<--!----------------------------------------------------------------!-->
<--! Expodash Aside Toggler !-->
<--!----------------------------------------------------------------!-->
*/
function initAsideToggler() {
	$('[data-edash-trigger="edash-aside-left-open"]').on("click", function (e) {
		e.preventDefault();
		$("#edash-aside-left").addClass("aside-left-open");
		$("#edash-left-backdrop").addClass("edash-left-backdrop");
	});
	$('[data-edash-trigger="edash-aside-left-close"]').on("click", function (e) {
		e.preventDefault();
		$("#edash-aside-left").removeClass("aside-left-open");
		$("#edash-left-backdrop").removeClass("edash-left-backdrop");
	});

	$('[data-edash-trigger="edash-aside-right-open"]').on("click", function (e) {
		e.preventDefault();
		$("#edash-aside-right").addClass("aside-right-open");
		$("#edash-right-backdrop").addClass("edash-right-backdrop");
	});
	$('[data-edash-trigger="edash-aside-right-close"]').on("click", function (e) {
		e.preventDefault();
		$("#edash-aside-right").removeClass("aside-right-open");
		$("#edash-right-backdrop").removeClass("edash-right-backdrop");
	});
}

/*
<--!----------------------------------------------------------------!-->
<--! Expodash Header Search !-->
<--!----------------------------------------------------------------!-->
*/
function initHeaderSearch() {
	$("#edash-search-show").on("click", function (e) {
		e.preventDefault();
		$(".edash-search").addClass("show");
	});
	$("#edash-search-hide").on("click", function (e) {
		e.preventDefault();
		$(".edash-search").removeClass("show");
	});
}

/*
--------------------------------------------------------------------
Active Menu
--------------------------------------------------------------------
*/
function initActiveMenuItem() {
	$("ul#edash-metismenu li a").each(function () {
		var pageUrl = window.location.href.split(/[?#]/)[0];
		if (this.href == pageUrl && $(this).attr("href") != "") {
			// 1st level
			$(this).parent("li").addClass("mm-active");

			// 2nd level
			$(this).parents("ul.mm-collapse").first().addClass("mm-show");
			$(this).parents("ul.mm-collapse").first().parent("li").addClass("mm-active");

			// 3rd level
			$(this).parents("ul.mm-collapse").eq(1).addClass("mm-show");
			$(this).parents("ul.mm-collapse").eq(1).parent("li").addClass("mm-active");

			// 4th level
			$(this).parents("ul.mm-collapse").eq(2).addClass("mm-show");
			$(this).parents("ul.mm-collapse").eq(2).parent("li").addClass("mm-active");

			// 5th level
			$(this).parents("ul.mm-collapse").eq(3).addClass("mm-show");
			$(this).parents("ul.mm-collapse").eq(3).parent("li").addClass("mm-active");
		}
	});
}

/*
<--!----------------------------------------------------------------!-->
<--! BS5 Tooltip + Popover !-->
<--!----------------------------------------------------------------!-->
*/
function initBS5TooltipPopover() {
	// Initialize BS5 tooltips
	const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
	const tooltipList = [...tooltipTriggerList].map((tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl));

	// Initialize BS5 popovers
	const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
	const popoverList = [...popoverTriggerList].map((popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl));
}

/*
<--!----------------------------------------------------------------!-->
<--! Expodash PerfectScrollbar !-->
<--!----------------------------------------------------------------!-->
*/
function initPerfectScrollbar() {
	$(".init-perfect-scroll-bar").each(function () {
		new PerfectScrollbar($(this)[0], {
			wheelSpeed: 0.5,
			suppressScrollX: true,
		});
	});
}

/*
<--!----------------------------------------------------------------!-->
<--! Initialize Functions !-->
<--!----------------------------------------------------------------!-->
*/
$(function () {
	initExpodashMenu();
	initAsideToggler();
	initHeaderSearch();
	initActiveMenuItem();
	initBS5TooltipPopover();
	initPerfectScrollbar();
});
