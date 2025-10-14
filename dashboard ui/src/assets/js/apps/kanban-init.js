"use strict";

/*
<--!----------------------------------------------------------------!-->
<--! Draggble item !-->
<--!----------------------------------------------------------------!-->
*/
function initKanbanSortable() {
	$('[data-sortable="true"]').sortable({
		connectWith: ".connect-sorting-content",
		items: ".card",
		cursor: "move",
		placeholder: "ui-state-highlight",
		refreshPosition: true,
		stop: function (event, ui) {
			var parent_ui = ui.item.parent().attr("data-item");
		},
		update: function (event, ui) {
			console.log(ui);
			console.log(ui.item);
		},
	});
}

/*
<--!----------------------------------------------------------------!-->
<--! Clear all task on click !-->
<--!----------------------------------------------------------------!-->
*/
function initClearItem() {
	$(".list-clear-all")
		.off("click")
		.on("click", function (event) {
			event.preventDefault();
			$(this).parents('[data-action="sorting"]').find(".connect-sorting-content .card").remove();
		});
}

/*
<--!----------------------------------------------------------------!-->
<--! Add task and open modal !-->
<--!----------------------------------------------------------------!-->
*/
function initAddKanbanItem() {
	$(".addTask").on("click", function (event) {
		event.preventDefault();

		var getParentElement;

		getParentElement = $(this).parents('[data-action="sorting"]').attr("data-item");
		$(".edit-task-title").hide();
		$(".add-task-title").show();
		$('[data-btn-action="addTask"]').show();
		$('[data-btn-action="editTask"]').hide();
		kanban_add(getParentElement);
	});
}

/*
<--!----------------------------------------------------------------!-->
<--! Add default item !-->
<--!----------------------------------------------------------------!-->
*/
function kanban_add(getParent) {
	$('[data-btn-action="addTask"]')
		.off("click")
		.on("click", function (e) {
			e.preventDefault();

			var getAddBtnClass;

			getAddBtnClass = $(this).attr("class").split(" ")[1];

			var $_getParent = getParent;

			var itemTitle = document.getElementById("kanban-title").value;
			var itemText = document.getElementById("kanban-text").value;

			var item_html;

			item_html = '<div class="card card-item ui-sortable-handle" data-draggable="true">' + '<div class="card-header px-3 py-2 d-flex align-items-center gap-4">' + '<h5 class="fs-14 fw-medium card-title" data-item-title="' + itemTitle + '">' + itemTitle + "</h5>" + '<div class="dropdown ms-auto">' + '<a href="javascript:void(0);" data-bs-toggle="dropdown">' + '<i class="fi fi-br-menu-dots fs-12"></i>' + "</a>" + '<div class="dropdown-menu dropdown-menu-end dropdown-sm">' + '<div data-edash-trigger="edash-aside-right-open">' + '<a class="dropdown-item kanban-item-edit" href="javascript:void(0);">' + '<i class="fi fi-rr-pen-nib fs-12"></i>' + '<span class="ms-2">Edit</span>' + "</a>" + "</div>" + '<a class="dropdown-item kanban-item-delete" href="javascript:void(0);">' + '<i class="fi fi-rr-delete fs-12"></i>' + '<span class="ms-2">Delete</span>' + "</a>" + "</div>" + "</div>" + "</div>" + '<div class="card-body p-3">' + '<p class="fs-12 fw-light text-muted mb-0" data-item-text="' + itemText + '">' + itemText + "</p>" + '<div class="my-3">' + '<span class="badge bg-success-subtle text-success">Admin</span>' + '<span class="badge bg-danger-subtle text-danger">Dashboard</span>' + "</div>" + '<div class="d-flex align-items-center">' + '<div class="avatar-group avatar-group-sm">' + '<div class="avatar avatar-sm">' + '<img src="./../assets/images/avatar/1.png" class="img-fluid rounded-circle" alt="User Avatar">' + "</div>" + '<div class="avatar avatar-sm">' + '<img src="./../assets/images/avatar/2.png" class="img-fluid rounded-circle" alt="User Avatar">' + "</div>" + '<div class="avatar avatar-sm">' + '<img src="./../assets/images/avatar/3.png" class="img-fluid rounded-circle" alt="User Avatar">' + "</div>" + "</div>" + '<div class="hstack gap-3 ms-auto">' + '<a href="javascript:void(0);" class="hstack gap-1">' + '<i class="fi fi-rr-comment-alt-dots fs-12"></i>' + '<span class="fs-12">8</span>' + "</a>" + '<a href="javascript:void(0);" class="hstack gap-1">' + '<i class="fi fi-rr-paperclip-vertical fs-12"></i>' + '<span class="fs-12">4</span>' + "</a>" + "</div>" + "</div>" + "</div>" + "</div>";

			$("[data-item='" + $_getParent + "'] .connect-sorting-content").append(item_html);

			initKanbanEdit();
			initKanbanDelete();
		});
}

$("#addKanbanBoard")
	.off("click")
	.on("click", function (event) {
		event.preventDefault();

		$(".add-list").show();
		$(".edit-list").hide();
		$(".edit-list-title").hide();
		$(".add-list-title").show();
		$("#addBoardModal").modal("show");
	});

$(".add-list")
	.off("click")
	.on("click", function (event) {
		var itemTitle = document.getElementById("item-name").value;

		var itemNameLowercase = itemTitle.toLowerCase();
		var itemNameRemoveWhiteSpace = itemNameLowercase.split(" ").join("_");
		var itemDataAttr = itemNameRemoveWhiteSpace;

		var item_html;

		item_html = '<div class="connect-sorting-content d-flex flex-column gap-3 ui-sortable" data-sortable="true">' + '<div data-item="item-' + itemDataAttr + '" class="task-list-container wd-300 flex-shrink-0" data-action="sorting">' + '<div class="connect-sorting connect-sorting-' + itemDataAttr + '">' + '<div class="d-flex align-items-center mb-4">' + '<h6 class="item-head fs-16 fw-bold mb-0" data-item-title="' + itemTitle + '">' + itemTitle + "</h6>" + '<div class="dropdown ms-auto">' + '<a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">' + '<i class="fi fi-br-menu-dots-vertical fs-12"></i>' + "</a>" + '<div class="dropdown-menu dropdown-menu-end dropdown-sm">' + '<a class="dropdown-item list-edit" href="javascript:void(0);">' + '<i class="fi fi-rr-pen-nib fs-12"></i>' + '<span class="ms-2">Edit</span>' + "</a>" + '<a class="dropdown-item list-delete" href="javascript:void(0);">' + '<i class="fi fi-rr-delete fs-12"></i>' + '<span class="ms-2">Delete</span>' + "</a>" + '<a class="dropdown-item list-clear-all" href="javascript:void(0);">' + '<i class="fi fi-rr-trash fs-12"></i>' + '<span class="ms-2">Clear Alls</span>' + "</a>" + "</div>" + "</div>" + "</div>" + '<div class="connect-sorting-content d-flex flex-column gap-3" data-sortable="true">' + +"</div>" + '<div class="d-grid mt-3">' + '<a class="addTask btn btn-md btn-soft-primary w-100" data-edash-trigger="edash-aside-right-open">Add Tasks</a>' + "</div>" + "</div>" + "</div>" + "</div>";

		$(".task-list-section").append(item_html);
		$("#addBoardModal").modal("hide");
		$("#item-name").val("");
		initKanbanSortable();
		initEditItem();
		initDeleteItem();
		initClearItem();
		initAddKanbanItem();
		initKanbanEdit();
		initKanbanDelete();
	});

/*
<--!----------------------------------------------------------------!-->
<--! Edit item !-->
<--!----------------------------------------------------------------!-->
*/
function initEditItem() {
	$(".list-edit")
		.off("click")
		.on("click", function (event) {
			event.preventDefault();

			var parentItem = $(this);

			$(".add-list").hide();
			$(".edit-list").show();

			$(".add-list-title").hide();
			$(".edit-list-title").show();

			var itemTitle = parentItem.parents('[data-action="sorting"]').find(".item-head").attr("data-item-title");
			$("#item-name").val(itemTitle);

			$(".edit-list")
				.off("click")
				.on("click", function (event) {
					var $_innerThis = $(this);
					var $_getListTitle = document.getElementById("item-name").value;

					var $_editedListTitle = parentItem.parents('[data-action="sorting"]').find(".item-head").html($_getListTitle);
					var $_editedListTitleDataAttr = parentItem.parents('[data-action="sorting"]').find(".item-head").attr("data-item-title", $_getListTitle);

					$("#addBoardModal").modal("hide");
					$("#item-name").val("");
				});
			$("#addBoardModal").modal("show");
			$("#addBoardModal").on("hidden.bs.modal", function (e) {
				$("#item-name").val("");
			});
		});
}

/*
<--!----------------------------------------------------------------!-->
<--! All list delete !-->
<--!----------------------------------------------------------------!-->
*/
function initDeleteItem() {
	$(".list-delete")
		.off("click")
		.on("click", function (event) {
			event.preventDefault();
			$(this).parents("[data-action]").remove();
		});
}

/*
<--!----------------------------------------------------------------!-->
<--! Delete item on click !-->
<--!----------------------------------------------------------------!-->
*/
function initKanbanDelete() {
	$(".card-item .kanban-item-delete")
		.off("click")
		.on("click", function (event) {
			event.preventDefault();

			var get_card_parent;

			get_card_parent = $(this).parents(".card-item");

			$("#deleteConformation").modal("show");

			$('[data-remove="task"]').on("click", function (event) {
				event.preventDefault();
				get_card_parent.remove();
				$("#deleteConformation").modal("hide");
			});
		});
}

/*
<--!----------------------------------------------------------------!-->
<--! Edit item on click !-->
<--!----------------------------------------------------------------!-->
*/
function initKanbanEdit() {
	$(".card-item .kanban-item-edit")
		.off("click")
		.on("click", function (event) {
			event.preventDefault();

			var parentItem = $(this);

			$(".add-task-title").hide();
			$(".edit-task-title").show();

			$('[data-btn-action="addTask"]').hide();
			$('[data-btn-action="editTask"]').show();

			var itemKanbanTitle = parentItem.parents(".card-item").find("h5").attr("data-item-title");
			var get_kanban_title = $(".task-text-progress #kanban-title").val(itemKanbanTitle);

			var itemText = parentItem.parents(".card-item").find('p:not(".progress-count")').attr("data-item-text");
			var get_kanban_text = $(".task-text-progress #kanban-text").val(itemText);

			$('[data-btn-action="editTask"]')
				.off("click")
				.on("click", function (event) {
					var kanbanValueTitle = document.getElementById("kanban-title").value;
					var kanbanValueText = document.getElementById("kanban-text").value;

					var itemDataAttr = parentItem.parents(".card-item").find("h5").attr("data-item-title", kanbanValueTitle);
					var itemKanbanTitle = parentItem.parents(".card-item").find("h5").html(kanbanValueTitle);
					var itemTextDataAttr = parentItem.parents(".card-item").find('p:not(".progress-count")').attr("data-tasktext", kanbanValueText);
					var itemText = parentItem.parents(".card-item").find('p:not(".progress-count")').html(kanbanValueText);
				});
		});
}

/*
<--!----------------------------------------------------------------!-->
<--! Initialize Functions !-->
<--!----------------------------------------------------------------!-->
*/
$(function () {
	initEditItem();
	initDeleteItem();
	initClearItem();
	initAddKanbanItem();
	initKanbanEdit();
	initKanbanDelete();
	initKanbanSortable();
});
