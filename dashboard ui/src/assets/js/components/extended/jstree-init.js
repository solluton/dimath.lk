"use strict";

// Initialize jsTree Basic
function initjsTreeBasic() {
	$("#jstreeBasic").jstree({
		core: {
			themes: {
				responsive: false,
			},
			// so that create works
			check_callback: true,
			data: [
				{
					text: "Parent Node",
					children: [
						{
							text: "Initially selected",
							state: {
								selected: true,
							},
						},
						{
							text: "Custom Icon",
							icon: "fi fi-rr-calendar text-danger",
						},
						{
							text: "Initially open",
							icon: "fi fi-rr-folder text-success",
							state: {
								opened: true,
							},
							children: [
								{
									text: "Another node",
									icon: "fi fi-rr-document text-waring",
								},
							],
						},
						{
							text: "Another Custom Icon",
							icon: "fi fi-rr-user-add text-waring",
						},
						{
							text: "Disabled Node",
							icon: "fi fi-rr-check-double text-success",
							state: {
								disabled: true,
							},
						},
						{
							text: "Sub Nodes",
							icon: "fi fi-rr-folder text-danger",
							children: [
								{ text: "Item 1", icon: "fi fi-rr-document text-waring" },
								{ text: "Item 2", icon: "fi fi-rr-document text-success" },
								{ text: "Item 3", icon: "fi fi-rr-document text-primary" },
								{ text: "Item 4", icon: "fi fi-rr-document text-danger" },
								{ text: "Item 5", icon: "fi fi-rr-document text-info" },
							],
						},
					],
				},
				"Another Node",
			],
		},
		types: {
			default: {
				icon: "fi fi-rr-folder text-primary",
			},
			file: {
				icon: "fi fi-rr-file  text-primary",
			},
		},
		state: { key: "demo2" },
		plugins: ["types"],
	});
}

// Initialize jsTree Contextual
function initjsTreeContextual() {
	$("#jstreeContextual").jstree({
		core: {
			themes: {
				responsive: false,
			},
			// so that create works
			check_callback: true,
			data: [
				{
					text: "Parent Node",
					children: [
						{
							text: "Initially selected",
							state: {
								selected: true,
							},
						},
						{
							text: "Custom Icon",
							icon: "fi fi-rr-calendar text-danger",
						},
						{
							text: "Initially open",
							icon: "fi fi-rr-folder text-success",
							state: {
								opened: true,
							},
							children: [
								{
									text: "Another node",
									icon: "fi fi-rr-document text-waring",
								},
							],
						},
						{
							text: "Another Custom Icon",
							icon: "fi fi-rr-user-add text-waring",
						},
						{
							text: "Disabled Node",
							icon: "fi fi-rr-check-double text-success",
							state: {
								disabled: true,
							},
						},
						{
							text: "Sub Nodes",
							icon: "fi fi-rr-folder text-danger",
							children: [
								{ text: "Item 1", icon: "fi fi-rr-document text-waring" },
								{ text: "Item 2", icon: "fi fi-rr-document text-success" },
								{ text: "Item 3", icon: "fi fi-rr-document text-primary" },
								{ text: "Item 4", icon: "fi fi-rr-document text-danger" },
								{ text: "Item 5", icon: "fi fi-rr-document text-info" },
							],
						},
					],
				},
				"Another Node",
			],
		},
		types: {
			default: {
				icon: "fi fi-rr-folder text-primary",
			},
			file: {
				icon: "fi fi-rr-file  text-primary",
			},
		},
		state: { key: "demo2" },
		plugins: ["contextmenu", "state", "types"],
	});
}

// Initialize jsTree DragDrop
function initjsTreeDragDrop() {
	$("#jstreeDragDrop").jstree({
		core: {
			themes: {
				responsive: false,
			},
			// so that create works
			check_callback: true,
			data: [
				{
					text: "Parent Node",
					children: [
						{
							text: "Initially selected",
							state: {
								selected: true,
							},
						},
						{
							text: "Custom Icon",
							icon: "fi fi-rr-calendar text-danger",
						},
						{
							text: "Initially open",
							icon: "fi fi-rr-folder text-success",
							state: {
								opened: true,
							},
							children: [
								{
									text: "Another node",
									icon: "fi fi-rr-document text-waring",
								},
							],
						},
						{
							text: "Another Custom Icon",
							icon: "fi fi-rr-user-add text-waring",
						},
						{
							text: "Disabled Node",
							icon: "fi fi-rr-check-double text-success",
							state: {
								disabled: true,
							},
						},
						{
							text: "Sub Nodes",
							icon: "fi fi-rr-folder text-danger",
							children: [
								{ text: "Item 1", icon: "fi fi-rr-document text-waring" },
								{ text: "Item 2", icon: "fi fi-rr-document text-success" },
								{ text: "Item 3", icon: "fi fi-rr-document text-primary" },
								{ text: "Item 4", icon: "fi fi-rr-document text-danger" },
								{ text: "Item 5", icon: "fi fi-rr-document text-info" },
							],
						},
					],
				},
				"Another Node",
			],
		},
		types: {
			default: {
				icon: "fi fi-rr-folder text-primary",
			},
			file: {
				icon: "fi fi-rr-file  text-primary",
			},
		},
		plugins: ["dnd", "sort"],
	});
}

// Initialize jsTree Checkbox
function initjsTreeCheckbox() {
	$("#jstreeCheckbox").jstree({
		core: {
			themes: {
				responsive: false,
			},
			// so that create works
			check_callback: true,
			data: [
				{
					text: "Parent Node",
					children: [
						{
							text: "Initially selected",
							state: {
								selected: true,
							},
						},
						{
							text: "Custom Icon",
							icon: "fi fi-rr-calendar text-danger",
						},
						{
							text: "Initially open",
							icon: "fi fi-rr-folder text-success",
							state: {
								opened: true,
							},
							children: [
								{
									text: "Another node",
									icon: "fi fi-rr-document text-waring",
								},
							],
						},
						{
							text: "Another Custom Icon",
							icon: "fi fi-rr-user-add text-waring",
						},
						{
							text: "Disabled Node",
							icon: "fi fi-rr-check-double text-success",
							state: {
								disabled: true,
							},
						},
						{
							text: "Sub Nodes",
							icon: "fi fi-rr-folder text-danger",
							children: [
								{ text: "Item 1", icon: "fi fi-rr-document text-waring" },
								{ text: "Item 2", icon: "fi fi-rr-document text-success" },
								{ text: "Item 3", icon: "fi fi-rr-document text-primary" },
								{ text: "Item 4", icon: "fi fi-rr-document text-danger" },
								{ text: "Item 5", icon: "fi fi-rr-document text-info" },
							],
						},
					],
				},
				"Another Node",
			],
		},
		types: {
			default: {
				icon: "fi fi-rr-folder text-primary",
			},
			file: {
				icon: "fi fi-rr-file  text-primary",
			},
		},
		plugins: ["checkbox", "types", "dnd"],
	});
}

//Public method to initialize all charts
(function () {
	initjsTreeBasic();
	initjsTreeContextual();
	initjsTreeDragDrop();
	initjsTreeCheckbox();
})();
