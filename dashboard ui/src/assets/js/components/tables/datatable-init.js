"use strict";

// Initialize Zero Config DataTable
var initZeroConfig = function () {
	$("#zeroConfig").dataTable({
		pagingType: "simple_numbers",
		lengthMenu: [
			[10, 25, 50, -1],
			[10, 25, 50, "All"],
		],
		language: {
			paginate: {
				previous: '<i class="bi bi-chevron-left"></i>',
				next: '<i class="bi bi-chevron-right"></i>',
			},
		},
	});
};

// Initialize Complex Headers DataTable
var initComplexHeaders = function () {
	$("#complexHeaders").dataTable({
		pagingType: "simple_numbers",
		lengthMenu: [
			[10, 25, 50, -1],
			[10, 25, 50, "All"],
		],
		language: {
			paginate: {
				previous: '<i class="bi bi-chevron-left"></i>',
				next: '<i class="bi bi-chevron-right"></i>',
			},
		},
	});
};

// Initialize Scroll Vertical DataTable
var initScrollVertical = function () {
	$("#scrollVertical").dataTable({
		paging: false,
		scrollCollapse: true,
		scrollY: 300,
	});
};

// Initialize Both Scrolls DataTable
var initBothScrolls = function () {
	$("#bothScrolls").dataTable({
		scrollX: true,
		scrollY: 300,
		lengthMenu: [
			[10, 25, 50, -1],
			[10, 25, 50, "All"],
		],
		pagingType: "simple_numbers",
		language: {
			paginate: {
				previous: '<i class="bi bi-chevron-left"></i>',
				next: '<i class="bi bi-chevron-right"></i>',
			},
		},
	});
};

// Initialize Stripe Hover DataTable
var initStripeHover = function () {
	$("#stripeHover").dataTable({
		pagingType: "simple_numbers",
		lengthMenu: [
			[10, 25, 50, -1],
			[10, 25, 50, "All"],
		],
		language: {
			paginate: {
				previous: '<i class="bi bi-chevron-left"></i>',
				next: '<i class="bi bi-chevron-right"></i>',
			},
		},
	});
};

// Initialize Row Grouping DataTable
var initRowGrouping = function () {
	var groupColumn = 2;
	var table = $("#rowGrouping").DataTable({
		columnDefs: [{ visible: false, targets: groupColumn }],
		order: [[groupColumn, "asc"]],
		displayLength: 25,
		drawCallback: function (settings) {
			var api = this.api();
			var rows = api.rows({ page: "current" }).nodes();
			var last = null;

			api.column(groupColumn, { page: "current" })
				.data()
				.each(function (group, i) {
					if (last !== group) {
						$(rows)
							.eq(i)
							.before('<tr class="group"><td colspan="5">' + group + "</td></tr>");

						last = group;
					}
				});
		},
	});

	$("#rowGrouping tbody").on("click", "tr.group", function () {
		var currentOrder = table.order()[0];
		if (currentOrder[0] === groupColumn && currentOrder[1] === "asc") {
			table.order([groupColumn, "desc"]).draw();
		} else {
			table.order([groupColumn, "asc"]).draw();
		}
	});
};

// Initialize Footer Callback DataTable
var initFooterCallback = function () {
	$("#footerCallback").DataTable({
		footerCallback: function (row, data, start, end, display) {
			var api = this.api();

			// Remove the formatting to get integer data for summation
			var intVal = function (i) {
				return typeof i === "string" ? i.replace(/[\$,]/g, "") * 1 : typeof i === "number" ? i : 0;
			};

			// Total over all pages
			var total = api
				.column(4)
				.data()
				.reduce(function (a, b) {
					return intVal(a) + intVal(b);
				}, 0);

			// Total over this page
			var pageTotal = api
				.column(4, { page: "current" })
				.data()
				.reduce(function (a, b) {
					return intVal(a) + intVal(b);
				}, 0);

			// Update footer
			$(api.column(4).footer()).html("$" + pageTotal + " ( $" + total + " total)");
		},
	});
};

// Initialize Export DataTable
var initDataTablesExport = function () {
	$("#dataTablesExport").DataTable({
		dom: "Bfrtip",
		responsive: true,
		buttons: {
			dom: {
				button: {
					className: "btn btn-light btn-rounded",
				},
			},
			buttons: [
				"copy",
				"csv",
				"excel",
				"pdf",
				{
					extend: "print",
					text: "Print Alls",
					exportOptions: {
						modifier: {
							selected: null,
						},
					},
				},
			],
		},
	});
};

// Initialize Visiblity DataTable
var initDataTablesVisiblity = function () {
	$("#dataTablesVisiblity").DataTable({
		dom: "Bfrtip",
		responsive: true,
		buttons: {
			dom: {
				button: {
					className: "btn btn-light btn-rounded",
				},
			},
			buttons: [
				{
					extend: "print",
					exportOptions: {
						columns: ":visible",
					},
				},
				"colvis",
			],
		},
		columnDefs: [
			{
				targets: -1,
				visible: false,
			},
		],
	});
};

// Public method to initialize all DataTables
(function () {
	initZeroConfig();
	initComplexHeaders();
	initScrollVertical();
	initBothScrolls();
	initStripeHover();
	initRowGrouping();
	initFooterCallback();
	initDataTablesExport();
	initDataTablesVisiblity();
})();
