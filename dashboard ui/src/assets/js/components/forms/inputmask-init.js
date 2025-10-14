"use strict";

$(function (e) {
	// Date InputMask
	$("#inputmaskDate").inputmask({
		alias: "datetime",
		inputFormat: "mm/dd/yyyy",
	});

	// Placeholder InputMask
	$("#inputmaskPlaceholder").inputmask({
		mask: "(999) 999-9999",
		placeholder: "(xxx) xxx-xxxx",
	});
	// Phone InputMask
	$("#inputmaskPhone").inputmask("(999) 999-9999");

	// Card InputMask
	$("#inputmaskCard").inputmask("9999 9999 9999 9999");

	// IP InputMask
	$("#inputmaskIP").inputmask("999.999.999.999");

	// SSN InputMask
	$("#inputmaskSSN").inputmask("999-99-9999");

	// ISBN InputMask
	$("#inputmaskISBN").inputmask("999-99-999-9999-9");

	// Currency InputMask
	$("#inputmaskCurrency").inputmask("$999.999,99");

	// Purchase InputMask
	$("#inputmaskPurchase").inputmask("AAAA 9999-****");

	// Optional InputMask
	$("#inputmaskOptional").inputmask("(99) 9999[9]-9999");

	// numLetter InputMask
	$("#inputmaskNumLetter").inputmask("999-AAA");

	// Decimal InputMask
	$("#inputmaskDecimal").inputmask({
		alias: "decimal",
		radixPoint: ".",
	});

	// Email InputMask
	$("#inputmaskEmail").inputmask({
		mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[*{2,6}][*{1,2}].*{1,}[.*{2,6}][.*{1,2}]",
		greedy: !1,
		onBeforePaste: function (n, a) {
			return (e = e.toLowerCase()).replace("mailto:", "");
		},
		definitions: {
			"*": {
				validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~/-]",
				cardinality: 1,
				casing: "lower",
			},
		},
	});

	// RTL InputMask
	$("#inputmaskRTL").inputmask("99/999/9999");
});
