"use strict";

function initializeFooTables() {
	// Custom Filtering
	FooTable.MyFiltering = FooTable.Filtering.extend({
		construct: function (instance) {
			this._super(instance);
			this.statuses = ["Active", "Disabled", "Suspended"];
			this.def = "Alls";
			this.$status = null;
		},
		$create: function () {
			this._super();
			var self = this,
				$form_grp = $("<div/>", { class: "form-group" }).prependTo(self.$form);

			self.$status = $("<select/>", { class: "form-select" })
				.on("change", { self: self }, self._onStatusDropdownChanged)
				.append($("<option/>", { text: self.def }))
				.appendTo($form_grp);

			$.each(self.statuses, function (i, status) {
				self.$status.append($("<option/>").text(status));
			});
		},
		_onStatusDropdownChanged: function (e) {
			var self = e.data.self,
				selected = $(this).val();
			if (selected !== self.def) {
				self.addFilter("status", selected, ["status"]);
			} else {
				self.removeFilter("status");
			}
			self.filter();
		},
		draw: function () {
			this._super();
			var status = this.find("status");
			if (status instanceof FooTable.Filter) {
				this.$status.val(status.query.val());
			} else {
				this.$status.val(this.def);
			}
		},
	});

	FooTable.components.register("filtering", FooTable.MyFiltering);

	// Initialization
	$("#fooTableFiltering").footable({
		columns: $.get("./../assets/js/components/data/footable_columns.min.json"),
		rows: $.get("./../assets/js/components/data/footable_rows.min.json"),
	});

	var $modal = $("#fooTableEditorModal"),
		$editor = $("#fooTableEdito"),
		$editorTitle = $("#fooTableEditoTitle"),
		ft = FooTable.init("#fooTableEditing", {
			editing: {
				enabled: true,
				addRow: function () {
					$modal.removeData("row");
					$editor[0].reset();
					$editorTitle.text("Add a new row");
					$modal.modal("show");
				},
				editRow: function (row) {
					var values = row.val();
					$editor.find("#id").val(values.id);
					$editor.find("#firstName").val(values.firstName);
					$editor.find("#lastName").val(values.lastName);
					$editor.find("#jobTitle").val(values.jobTitle);
					$editor.find("#startedOn").val(values.startedOn.format("YYYY-MM-DD"));
					$editor.find("#dob").val(values.dob.format("YYYY-MM-DD"));

					$modal.data("row", row);
					$editorTitle.text("Edit Row #" + values.id);
					$modal.modal("show");
				},
				deleteRow: function (row) {
					if (confirm("Are you sure you want to delete the row?")) {
						row.delete();
					}
				},
			},
		});

	var uid = 10;

	$editor.on("submit", function (e) {
		if (this.checkValidity && !this.checkValidity()) return;
		e.preventDefault();
		var row = $modal.data("row"),
			values = {
				id: $editor.find("#id").val(),
				firstName: $editor.find("#firstName").val(),
				lastName: $editor.find("#lastName").val(),
				jobTitle: $editor.find("#jobTitle").val(),
				startedOn: moment($editor.find("#startedOn").val(), "YYYY-MM-DD"),
				dob: moment($editor.find("#dob").val(), "YYYY-MM-DD"),
			};

		if (row instanceof FooTable.Row) {
			row.val(values);
		} else {
			values.id = uid++;
			ft.rows.add(values);
		}
		$modal.modal("hide");
	});

	$("#fooTableToggle").footable();

	$("[data-page-size]").on("click", function (e) {
		e.preventDefault();
		var newSize = $(this).data("pageSize");
		FooTable.get("#fooTablePageSize").pageSize(newSize);
	});

	$("#fooTablePageSize").footable({
		columns: $.get("./../assets/js/components/data/footable_columns.min.json"),
		rows: $.get("./../assets/js/components/data/footable_rows.min.json"),
	});

	$("#fooTableCollapse").footable({
		columns: $.get("./../assets/js/components/data/footable_columns.min.json"),
		rows: $.get("./../assets/js/components/data/footable_rows.min.json"),
	});

	$("#fooTableModal").footable({
		useParentWidth: true,
		columns: $.get("./../assets/js/components/data/footable_columns.min.json"),
		rows: $.get("./../assets/js/components/data/footable_rows.min.json"),
	});
}

// Call the custom initialization function
(function ($) {
	initializeFooTables();
})();
