"use strict";

// Initialize Basic Tagify
function initBasicTagify() {
	var input = document.querySelector("input[name=basic]");
	new Tagify(input);
}

// Initialize Suggestions Tagify
function initSuggestionsTagify() {
	var input = document.querySelector('input[name="suggestions"]'),
		tagify = new Tagify(input, {
			whitelist: ["A# .NET", "A# (Axiom)", "A-0 System", "A+", "A++", "ABAP", "ABC", "ABC ALGOL", "ABSET", "ABSYS", "ACC", "Accent", "Ace DASL", "ACL2", "Avicsoft", "ACT-III", "Action!", "ActionScript", "Ada", "Adenine", "Agda", "Agilent VEE", "Agora", "AIMMS", "Alef", "ALF", "ALGOL 58", "ALGOL 60", "ALGOL 68", "ALGOL W", "Alice", "Alma-0", "AmbientTalk", "Amiga E", "AMOS", "AMPL", "Apex (Salesforce.com)", "APL", "AppleScript", "Arc", "ARexx", "Argus", "AspectJ", "Assembly language", "ATS", "Ateji PX", "AutoHotkey", "Autocoder", "AutoIt", "AutoLISP / Visual LISP", "Averest", "AWK", "Axum", "Active Server Pages", "ASP.NET", "B", "Babbage", "Bash", "BASIC", "bc", "BCPL", "BeanShell", "Batch (Windows/Dos)", "Bertrand", "BETA", "Bigwig", "Bistro", "BitC", "BLISS", "Blockly", "BlooP", "Blue", "Boo", "Boomerang", "Bourne shell (including bash and ksh)", "BREW", "BPEL", "B", "C--", "C++ - ISO/IEC 14882", "C# - ISO/IEC 23270", "C/AL", "Caché ObjectScript", "C Shell", "Caml", "Cayenne", "CDuce", "Cecil", "Cesil", "Céu", "Ceylon", "CFEngine", "CFML", "Cg", "Ch", "Chapel", "Charity", "Charm", "Chef", "CHILL", "CHIP-8", "chomski", "ChucK", "CICS", "Cilk", "Citrine (programming language)", "CL (IBM)", "Claire", "Clarion", "Clean", "Clipper", "CLIPS", "CLIST", "Clojure", "CLU", "CMS-2", "COBOL - ISO/IEC 1989", "CobolScript - COBOL Scripting language", "Cobra", "CODE", "CoffeeScript", "ColdFusion", "COMAL", "Combined Programming Language (CPL)", "COMIT", "Common Intermediate Language (CIL)", "Common Lisp (also known as CL)", "COMPASS", "Component Pascal", "Constraint Handling Rules (CHR)", "COMTRAN", "Converge", "Cool", "Coq", "Coral 66", "Corn", "CorVision", "COWSEL", "CPL", "CPL", "Cryptol", "csh", "Csound", "CSP", "CUDA", "Curl", "Curry", "Cybil", "Cyclone", "Cython", "Java", "Javascript", "M2001", "M4", "M#", "Machine code", "MAD (Michigan Algorithm Decoder)", "MAD/I", "Magik", "Magma", "make", "Maple", "MAPPER now part of BIS", "MARK-IV now VISION:BUILDER", "Mary", "MASM Microsoft Assembly x86", "MATH-MATIC", "Mathematica", "MATLAB", "Maxima (see also Macsyma)", "Max (Max Msp - Graphical Programming Environment)", "Maya (MEL)", "MDL", "Mercury", "Mesa", "Metafont", "Microcode", "MicroScript", "MIIS", "Milk (programming language)", "MIMIC", "Mirah", "Miranda", "MIVA Script", "ML", "Model 204", "Modelica", "Modula", "Modula-2", "Modula-3", "Mohol", "MOO", "Mortran", "Mouse", "MPD", "Mathcad", "MSIL - deprecated name for CIL", "MSL", "MUMPS", "Mystic Programming L"],
			maxTags: 10,
			dropdown: {
				maxItems: 20, // <- mixumum allowed rendered suggestions
				classname: "tags-look", // <- custom classname for this dropdown, so it could be targeted
				enabled: 0, // <- show suggestions on focus
				closeOnSelect: false, // <- do not hide the suggestions dropdown once an item has been selected
			},
		});
}

// Initialize Users Tagify
function initUsersTagify() {
	var inputElm = document.querySelector("input[name=users]");

	const usersList = [
		{
			value: 1,
			name: "Justinian Hattersley",
			avatar: "https://i.pravatar.cc/80?img=1",
			email: "jhattersley0@ucsd.edu",
			team: "A",
		},
		{
			value: 2,
			name: "Antons Esson",
			avatar: "https://i.pravatar.cc/80?img=2",
			email: "aesson1@ning.com",
			team: "B",
		},
		{
			value: 3,
			name: "Ardeen Batisse",
			avatar: "https://i.pravatar.cc/80?img=3",
			email: "abatisse2@nih.gov",
			team: "A",
		},
		{
			value: 4,
			name: "Graeme Yellowley",
			avatar: "https://i.pravatar.cc/80?img=4",
			email: "gyellowley3@behance.net",
			team: "C",
		},
		{
			value: 5,
			name: "Dido Wilford",
			avatar: "https://i.pravatar.cc/80?img=5",
			email: "dwilford4@jugem.jp",
			team: "A",
		},
		{
			value: 6,
			name: "Celesta Orwin",
			avatar: "https://i.pravatar.cc/80?img=6",
			email: "corwin5@meetup.com",
			team: "C",
		},
		{
			value: 7,
			name: "Sally Main",
			avatar: "https://i.pravatar.cc/80?img=7",
			email: "smain6@techcrunch.com",
			team: "A",
		},
		{
			value: 8,
			name: "Grethel Haysman",
			avatar: "https://i.pravatar.cc/80?img=8",
			email: "ghaysman7@mashable.com",
			team: "B",
		},
		{
			value: 9,
			name: "Marvin Mandrake",
			avatar: "https://i.pravatar.cc/80?img=9",
			email: "mmandrake8@sourceforge.net",
			team: "B",
		},
		{
			value: 10,
			name: "Corrie Tidey",
			avatar: "https://i.pravatar.cc/80?img=10",
			email: "ctidey9@youtube.com",
			team: "A",
		},
		{
			value: 11,
			name: "Laura Foreman",
			avatar: "https://i.pravatar.cc/80?img=11",
			email: "laura.foreman@bar.com",
			team: "B",
		},
		{
			value: 12,
			name: "Ursula Sanders",
			avatar: "https://i.pravatar.cc/80?img=12",
			email: "ursula.sanders@foo.com",
			team: "A",
		},
	];

	function tagTemplate(tagData) {
		return `
        <tag title="${tagData.title || tagData.email}"
                contenteditable='false'
                spellcheck='false'
                tabIndex="-1"
                class="${this.settings.classNames.tag} ${tagData.class ? tagData.class : ""}"
                ${this.getAttributes(tagData)}>
            <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
            <div class="d-flex align-items-center">
                <div class='tagify__tag__avatar-wrap ps-0'>
                    <img onerror="this.style.visibility='hidden'" class="img-fluid rounded-circle wd-20 me-2" src="${tagData.avatar}">
                </div>
                <span class='tagify__tag-text'>${tagData.name}</span>
            </div>
        </tag>
    `;
	}

	function suggestionItemTemplate(tagData) {
		return `
        <div ${this.getAttributes(tagData)}
            class='tagify__dropdown__item d-flex align-items-center mb-2 ${tagData.class ? tagData.class : ""}'
            tabindex="0"
            role="option">

            ${
				tagData.avatar
					? `
                    <div class='tagify__dropdown__item__avatar-wrap me-2'>
                        <img onerror="this.style.visibility='hidden'" class="img-fluid rounded-circle me-2" src="${tagData.avatar}" style="width:35px; height: 35px;">
                    </div>`
					: ""
			}

            <div class="d-flex flex-column">
                <strong>${tagData.name}</strong>
                <span>${tagData.email}</span>
            </div>
        </div>
    `;
	}

	// initialize Tagify on the above input node reference
	var tagify = new Tagify(inputElm, {
		tagTextProp: "name", // very important since a custom template is used with this property as text. allows typing a "value" or a "name" to match input with whitelist
		enforceWhitelist: true,
		skipInvalid: true, // do not remporarily add invalid tags
		dropdown: {
			closeOnSelect: false,
			enabled: 0,
			classname: "users-list",
			searchKeys: ["name", "email"], // very important to set by which keys to search for suggesttions when typing
		},
		templates: {
			tag: tagTemplate,
			dropdownItem: suggestionItemTemplate,
		},
		whitelist: usersList,
	});

	tagify.on("dropdown:show dropdown:updated", onDropdownShow);
	tagify.on("dropdown:select", onSelectSuggestion);

	var addAllSuggestionsElm;

	function onDropdownShow(e) {
		var dropdownContentElm = e.detail.tagify.DOM.dropdown.content;

		if (tagify.suggestedListItems.length > 1) {
			addAllSuggestionsElm = getAddAllSuggestionsElm();

			// insert "addAllSuggestionsElm" as the first element in the suggestions list
			dropdownContentElm.insertBefore(addAllSuggestionsElm, dropdownContentElm.firstChild);
		}
	}

	function onSelectSuggestion(e) {
		if (e.detail.elm == addAllSuggestionsElm) tagify.dropdown.selectAll.call(tagify);
	}

	// create a "add all" custom suggestion element every time the dropdown changes
	function getAddAllSuggestionsElm() {
		// suggestions items should be based on "dropdownItem" template
		return tagify.parseTemplate("dropdownItem", [
			{
				class: "addAll",
				name: "Add all",
				email:
					tagify.settings.whitelist.reduce(function (remainingSuggestions, item) {
						return tagify.isTagDuplicate(item.value) ? remainingSuggestions : remainingSuggestions + 1;
					}, 0) + " Members",
			},
		]);
	}
}

// Initialize Countries Tagify
function initCountriesTagify() {
	var tagify = new Tagify(document.querySelector("input[name=countries]"), {
		delimiters: null,
		templates: {
			tag: function (tagData) {
				try {
					return `<tag title='${tagData.value}' contenteditable='false' spellcheck="false"
                    class='tagify__tag ${tagData.class ? tagData.class : ""}' ${this.getAttributes(tagData)}>
                        <x title='remove tag' class='tagify__tag__removeBtn'></x>
                        <div class="d-flex align-items-center">
                            ${tagData.code ? `<img onerror="this.style.visibility = 'hidden'" class="img-fluid rounded-circle wd-20 me-2" src='https://flagicons.lipis.dev/flags/1x1/${tagData.code.toLowerCase()}.svg' />` : ""}
                            <span class='tagify__tag-text'>${tagData.value}</span>
                        </div>
                    </tag>`;
				} catch (err) {}
			},

			dropdownItem: function (tagData) {
				try {
					return `<div ${this.getAttributes(tagData)} class='tagify__dropdown__item ${tagData.class ? tagData.class : ""}'>
                            <img onerror="this.style.visibility = 'hidden'" class="img-fluid rounded-circle me-2" style="width:30px; height: 30px;"
                                    src='https://flagicons.lipis.dev/flags/1x1/${tagData.code.toLowerCase()}.svg' />
                            <span>${tagData.value}</span>
                        </div>`;
				} catch (err) {}
			},
		},
		enforceWhitelist: true,
		whitelist: [
			{ value: "Afghanistan", code: "AF" },
			{ value: "Åland Islands", code: "AX" },
			{ value: "Albania", code: "AL" },
			{ value: "Algeria", code: "DZ" },
			{ value: "American Samoa", code: "AS" },
			{ value: "Andorra", code: "AD" },
			{ value: "Angola", code: "AO" },
			{ value: "Anguilla", code: "AI" },
			{ value: "Antarctica", code: "AQ" },
			{ value: "Antigua and Barbuda", code: "AG" },
			{ value: "Argentina", code: "AR" },
			{ value: "Armenia", code: "AM" },
			{ value: "Aruba", code: "AW" },
			{ value: "Australia", code: "AU", searchBy: "beach, sub-tropical" },
			{ value: "Austria", code: "AT" },
			{ value: "Azerbaijan", code: "AZ" },
			{ value: "Bahamas", code: "BS" },
			{ value: "Bahrain", code: "BH" },
			{ value: "Bangladesh", code: "BD" },
			{ value: "Barbados", code: "BB" },
			{ value: "Belarus", code: "BY" },
			{ value: "Belgium", code: "BE" },
			{ value: "Belize", code: "BZ" },
			{ value: "Benin", code: "BJ" },
			{ value: "Bermuda", code: "BM" },
			{ value: "Bhutan", code: "BT" },
			{ value: "Bolivia", code: "BO" },
			{ value: "Bosnia and Herzegovina", code: "BA" },
			{ value: "Botswana", code: "BW" },
			{ value: "Bouvet Island", code: "BV" },
			{ value: "Brazil", code: "BR" },
			{ value: "British Indian Ocean Territory", code: "IO" },
			{ value: "Brunei Darussalam", code: "BN" },
			{ value: "Bulgaria", code: "BG" },
			{ value: "Burkina Faso", code: "BF" },
			{ value: "Burundi", code: "BI" },
			{ value: "Cambodia", code: "KH" },
			{ value: "Cameroon", code: "CM" },
			{ value: "Canada", code: "CA" },
			{ value: "Cape Verde", code: "CV" },
			{ value: "Cayman Islands", code: "KY" },
			{ value: "Central African Republic", code: "CF" },
			{ value: "Chad", code: "TD" },
			{ value: "Chile", code: "CL" },
			{ value: "China", code: "CN" },
			{ value: "Christmas Island", code: "CX" },
			{ value: "Cocos (Keeling) Islands", code: "CC" },
			{ value: "Colombia", code: "CO" },
			{ value: "Comoros", code: "KM" },
			{ value: "Congo", code: "CG" },
			{ value: "Congo, The Democratic Republic of the", code: "CD" },
			{ value: "Cook Islands", code: "CK" },
			{ value: "Costa Rica", code: "CR" },
			{ value: "Cote D'Ivoire", code: "CI" },
			{ value: "Croatia", code: "HR" },
			{ value: "Cuba", code: "CU" },
			{ value: "Cyprus", code: "CY" },
			{ value: "Czech Republic", code: "CZ" },
			{ value: "Denmark", code: "DK" },
			{ value: "Djibouti", code: "DJ" },
			{ value: "Dominica", code: "DM" },
			{ value: "Dominican Republic", code: "DO" },
			{ value: "Ecuador", code: "EC" },
			{ value: "Egypt", code: "EG" },
			{ value: "El Salvador", code: "SV" },
			{ value: "Equatorial Guinea", code: "GQ" },
			{ value: "Eritrea", code: "ER" },
			{ value: "Estonia", code: "EE" },
			{ value: "Ethiopia", code: "ET" },
			{ value: "Falkland Islands (Malvinas)", code: "FK" },
			{ value: "Faroe Islands", code: "FO" },
			{ value: "Fiji", code: "FJ" },
			{ value: "Finland", code: "FI" },
			{ value: "France", code: "FR" },
			{ value: "French Guiana", code: "GF" },
			{ value: "French Polynesia", code: "PF" },
			{ value: "French Southern Territories", code: "TF" },
			{ value: "Gabon", code: "GA" },
			{ value: "Gambia", code: "GM" },
			{ value: "Georgia", code: "GE" },
			{ value: "Germany", code: "DE" },
			{ value: "Ghana", code: "GH" },
			{ value: "Gibraltar", code: "GI" },
			{ value: "Greece", code: "GR" },
			{ value: "Greenland", code: "GL" },
			{ value: "Grenada", code: "GD" },
			{ value: "Guadeloupe", code: "GP" },
			{ value: "Guam", code: "GU" },
			{ value: "Guatemala", code: "GT" },
			{ value: "Guernsey", code: "GG" },
			{ value: "Guinea", code: "GN" },
			{ value: "Guinea-Bissau", code: "GW" },
			{ value: "Guyana", code: "GY" },
			{ value: "Haiti", code: "HT" },
			{ value: "Heard Island and Mcdonald Islands", code: "HM" },
			{ value: "Holy See (Vatican City State)", code: "VA" },
			{ value: "Honduras", code: "HN" },
			{ value: "Hong Kong", code: "HK" },
			{ value: "Hungary", code: "HU" },
			{ value: "Iceland", code: "IS" },
			{ value: "India", code: "IN" },
			{ value: "Indonesia", code: "ID" },
			{ value: "Iran, Islamic Republic Of", code: "IR" },
			{ value: "Iraq", code: "IQ" },
			{ value: "Ireland", code: "IE" },
			{ value: "Isle of Man", code: "IM" },
			{ value: "Israel", code: "IL", searchBy: "holy land, desert" },
			{ value: "Italy", code: "IT" },
			{ value: "Jamaica", code: "JM" },
			{ value: "Japan", code: "JP" },
			{ value: "Jersey", code: "JE" },
			{ value: "Jordan", code: "JO" },
			{ value: "Kazakhstan", code: "KZ" },
			{ value: "Kenya", code: "KE" },
			{ value: "Kiribati", code: "KI" },
			{ value: "Korea, Democratic People'S Republic of", code: "KP" },
			{ value: "Korea, Republic of", code: "KR" },
			{ value: "Kuwait", code: "KW" },
			{ value: "Kyrgyzstan", code: "KG" },
			{ value: "Lao People'S Democratic Republic", code: "LA" },
			{ value: "Latvia", code: "LV" },
			{ value: "Lebanon", code: "LB" },
			{ value: "Lesotho", code: "LS" },
			{ value: "Liberia", code: "LR" },
			{ value: "Libyan Arab Jamahiriya", code: "LY" },
			{ value: "Liechtenstein", code: "LI" },
			{ value: "Lithuania", code: "LT" },
			{ value: "Luxembourg", code: "LU" },
			{ value: "Macao", code: "MO" },
			{ value: "Macedonia, The Former Yugoslav Republic of", code: "MK" },
			{ value: "Madagascar", code: "MG" },
			{ value: "Malawi", code: "MW" },
			{ value: "Malaysia", code: "MY" },
			{ value: "Maldives", code: "MV" },
			{ value: "Mali", code: "ML" },
			{ value: "Malta", code: "MT" },
			{ value: "Marshall Islands", code: "MH" },
			{ value: "Martinique", code: "MQ" },
			{ value: "Mauritania", code: "MR" },
			{ value: "Mauritius", code: "MU" },
			{ value: "Mayotte", code: "YT" },
			{ value: "Mexico", code: "MX" },
			{ value: "Micronesia, Federated States of", code: "FM" },
			{ value: "Moldova, Republic of", code: "MD" },
			{ value: "Monaco", code: "MC" },
			{ value: "Mongolia", code: "MN" },
			{ value: "Montserrat", code: "MS" },
			{ value: "Morocco", code: "MA" },
			{ value: "Mozambique", code: "MZ" },
			{ value: "Myanmar", code: "MM" },
			{ value: "Namibia", code: "NA" },
			{ value: "Nauru", code: "NR" },
			{ value: "Nepal", code: "NP" },
			{ value: "Netherlands", code: "NL" },
			{ value: "Netherlands Antilles", code: "AN" },
			{ value: "New Caledonia", code: "NC" },
			{ value: "New Zealand", code: "NZ" },
			{ value: "Nicaragua", code: "NI" },
			{ value: "Niger", code: "NE" },
			{ value: "Nigeria", code: "NG" },
			{ value: "Niue", code: "NU" },
			{ value: "Norfolk Island", code: "NF" },
			{ value: "Northern Mariana Islands", code: "MP" },
			{ value: "Norway", code: "NO" },
			{ value: "Oman", code: "OM" },
			{ value: "Pakistan", code: "PK" },
			{ value: "Palau", code: "PW" },
			{ value: "Palestinian Territory, Occupied", code: "PS" },
			{ value: "Panama", code: "PA" },
			{ value: "Papua New Guinea", code: "PG" },
			{ value: "Paraguay", code: "PY" },
			{ value: "Peru", code: "PE" },
			{ value: "Philippines", code: "PH" },
			{ value: "Pitcairn", code: "PN" },
			{ value: "Poland", code: "PL" },
			{ value: "Portugal", code: "PT" },
			{ value: "Puerto Rico", code: "PR" },
			{ value: "Qatar", code: "QA" },
			{ value: "Reunion", code: "RE" },
			{ value: "Romania", code: "RO" },
			{ value: "Russian Federation", code: "RU" },
			{ value: "RWANDA", code: "RW" },
			{ value: "Saint Helena", code: "SH" },
			{ value: "Saint Kitts and Nevis", code: "KN" },
			{ value: "Saint Lucia", code: "LC" },
			{ value: "Saint Pierre and Miquelon", code: "PM" },
			{ value: "Saint Vincent and the Grenadines", code: "VC" },
			{ value: "Samoa", code: "WS" },
			{ value: "San Marino", code: "SM" },
			{ value: "Sao Tome and Principe", code: "ST" },
			{ value: "Saudi Arabia", code: "SA" },
			{ value: "Senegal", code: "SN" },
			{ value: "Serbia and Montenegro", code: "CS" },
			{ value: "Seychelles", code: "SC" },
			{ value: "Sierra Leone", code: "SL" },
			{ value: "Singapore", code: "SG" },
			{ value: "Slovakia", code: "SK" },
			{ value: "Slovenia", code: "SI" },
			{ value: "Solomon Islands", code: "SB" },
			{ value: "Somalia", code: "SO" },
			{ value: "South Africa", code: "ZA" },
			{ value: "South Georgia and the South Sandwich Islands", code: "GS" },
			{ value: "Spain", code: "ES" },
			{ value: "Sri Lanka", code: "LK" },
			{ value: "Sudan", code: "SD" },
			{ value: "Suriname", code: "SR" },
			{ value: "Svalbard and Jan Mayen", code: "SJ" },
			{ value: "Swaziland", code: "SZ" },
			{ value: "Sweden", code: "SE" },
			{ value: "Switzerland", code: "CH" },
			{ value: "Syrian Arab Republic", code: "SY" },
			{ value: "Taiwan", code: "TW" },
			{ value: "Tajikistan", code: "TJ" },
			{ value: "Tanzania, United Republic of", code: "TZ" },
			{ value: "Thailand", code: "TH" },
			{ value: "Timor-Leste", code: "TL" },
			{ value: "Togo", code: "TG" },
			{ value: "Tokelau", code: "TK" },
			{ value: "Tonga", code: "TO" },
			{ value: "Trinidad and Tobago", code: "TT" },
			{ value: "Tunisia", code: "TN" },
			{ value: "Turkey", code: "TR" },
			{ value: "Turkmenistan", code: "TM" },
			{ value: "Turks and Caicos Islands", code: "TC" },
			{ value: "Tuvalu", code: "TV" },
			{ value: "Uganda", code: "UG" },
			{ value: "Ukraine", code: "UA" },
			{ value: "United Arab Emirates", code: "AE" },
			{ value: "United Kingdom", code: "GB" },
			{ value: "United States", code: "US" },
			{ value: "United States Minor Outlying Islands", code: "UM" },
			{ value: "Uruguay", code: "UY" },
			{ value: "Uzbekistan", code: "UZ" },
			{ value: "Vanuatu", code: "VU" },
			{ value: "Venezuela", code: "VE" },
			{ value: "Viet Nam", code: "VN" },
			{ value: "Virgin Islands, British", code: "VG" },
			{ value: "Virgin Islands, U.S.", code: "VI" },
			{ value: "Wallis and Futuna", code: "WF" },
			{ value: "Western Sahara", code: "EH" },
			{ value: "Yemen", code: "YE" },
			{ value: "Zambia", code: "ZM" },
			{ value: "Zimbabwe", code: "ZW" },
		],
		dropdown: {
			enabled: 1, // suggest tags after a single character input
			classname: "extra-properties", // custom class for the suggestions dropdown
		}, // map tags' values to this property name, so this property will be the actual value and not the printed value on the screen
	});

	// add the first 2 tags and makes them readonly
	var tagsToAdd = tagify.settings.whitelist.slice(0, 2);
	tagify.addTags(tagsToAdd);
}

// Initialize CustomLook Tagify
function initCustomLookTagify() {
	// generate random whilist items (for the demo)
	var randomStringsArr = Array.apply(null, Array(100)).map(function () {
		return (
			Array.apply(null, Array(~~(Math.random() * 10 + 3)))
				.map(function () {
					return String.fromCharCode(Math.random() * (123 - 97) + 97);
				})
				.join("") + "@gmail.com"
		);
	});

	var input = document.querySelector('[name="customLook"]'),
		tagify = new Tagify(input, {
			// email address validation (https://stackoverflow.com/a/46181/104380)
			pattern: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
			whitelist: randomStringsArr,
			callbacks: {
				invalid: onInvalidTag,
			},
			dropdown: {
				position: "text",
				enabled: 1, // show suggestions dropdown after 1 typed character
			},
		}),
		button = input.nextElementSibling; // "add new tag" action-button

	button.addEventListener("click", onAddButtonClick);

	function onAddButtonClick() {
		tagify.addEmptyTag();
	}

	function onInvalidTag(e) {
		console.log("invalid", e.detail);
	}
}

// Initialize Advance Tagify
function initAdvanceTagify() {
	var input = document.querySelector("input[name=advance]"),
		tagify = new Tagify(input, {
			pattern: /^.{0,20}$/, // Validate typed tag(s) by Regex. Here maximum chars length is defined as "20"
			delimiters: ",| ", // add new tags when a comma or a space character is entered
			trim: false, // if "delimiters" setting is using space as a delimeter, then "trim" should be set to "false"
			keepInvalidTags: true, // do not remove invalid tags (but keep them marked as invalid)
			// createInvalidTags: false,
			editTags: {
				clicks: 2, // single click to edit a tag
				keepInvalid: false, // if after editing, tag is invalid, auto-revert
			},
			maxTags: 10,
			blacklist: ["foo", "bar", "baz"],
			whitelist: ["temple", "stun", "detective", "sign", "passion", "routine", "deck", "discriminate", "relaxation", "fraud", "attractive", "soft", "forecast", "point", "thank", "stage", "eliminate", "effective", "flood", "passive", "skilled", "separation", "contact", "compromise", "reality", "district", "nationalist", "leg", "porter", "conviction", "worker", "vegetable", "commerce", "conception", "particle", "honor", "stick", "tail", "pumpkin", "core", "mouse", "egg", "population", "unique", "behavior", "onion", "disaster", "cute", "pipe", "sock", "dialect", "horse", "swear", "owner", "cope", "global", "improvement", "artist", "shed", "constant", "bond", "brink", "shower", "spot", "inject", "bowel", "homosexual", "trust", "exclude", "tough", "sickness", "prevalence", "sister", "resolution", "cattle", "cultural", "innocent", "burial", "bundle", "thaw", "respectable", "thirsty", "exposure", "team", "creed", "facade", "calendar", "filter", "utter", "dominate", "predator", "discover", "theorist", "hospitality", "damage", "woman", "rub", "crop", "unpleasant", "halt", "inch", "birthday", "lack", "throne", "maximum", "pause", "digress", "fossil", "policy", "instrument", "trunk", "frame", "measure", "hall", "support", "convenience", "house", "partnership", "inspector", "looting", "ranch", "asset", "rally", "explicit", "leak", "monarch", "ethics", "applied", "aviation", "dentist", "great", "ethnic", "sodium", "truth", "constellation", "lease", "guide", "break", "conclusion", "button", "recording", "horizon", "council", "paradox", "bride", "weigh", "like", "noble", "transition", "accumulation", "arrow", "stitch", "academy", "glimpse", "case", "researcher", "constitutional", "notion", "bathroom", "revolutionary", "soldier", "vehicle", "betray", "gear", "pan", "quarter", "embarrassment", "golf", "shark", "constitution", "club", "college", "duty", "eaux", "know", "collection", "burst", "fun", "animal", "expectation", "persist", "insure", "tick", "account", "initiative", "tourist", "member", "example", "plant", "river", "ratio", "view", "coast", "latest", "invite", "help", "falsify", "allocation", "degree", "feel", "resort", "means", "excuse", "injury", "pupil", "shaft", "allow", "ton", "tube", "dress", "speaker", "double", "theater", "opposed", "holiday", "screw", "cutting", "picture", "laborer", "conservation", "kneel", "miracle", "brand", "nomination", "characteristic", "referral", "carbon", "valley", "hot", "climb", "wrestle", "motorist", "update", "loot", "mosquito", "delivery", "eagle", "guideline", "hurt", "feedback", "finish", "traffic", "competence", "serve", "archive", "feeling", "hope", "seal", "ear", "oven", "vote", "ballot", "study", "negative", "declaration", "particular", "pattern", "suburb", "intervention", "brake", "frequency", "drink", "affair", "contemporary", "prince", "dry", "mole", "lazy", "undermine", "radio", "legislation", "circumstance", "bear", "left", "pony", "industry", "mastermind", "criticism", "sheep", "failure", "chain", "depressed", "launch", "script", "green", "weave", "please", "surprise", "doctor", "revive", "banquet", "belong", "correction", "door", "image", "integrity", "intermediate", "sense", "formal", "cane", "gloom", "toast", "pension", "exception", "prey", "random", "nose", "predict", "needle", "satisfaction", "establish", "fit", "vigorous", "urgency", "X-ray", "equinox", "variety", "proclaim", "conceive", "bulb", "vegetarian", "available", "stake", "publicity", "strikebreaker", "portrait", "sink", "frog", "ruin", "studio", "match", "electron", "captain", "channel", "navy", "set", "recommend", "appoint", "liberal", "missile", "sample", "result", "poor", "efflux", "glance", "timetable", "advertise", "personality", "aunt", "dog"],
			transformTag: transformTag,
			backspace: "edit",
			dropdown: {
				enabled: 1, // show suggestion after 1 typed character
				fuzzySearch: false, // match only suggestions that starts with the typed characters
				position: "text", // position suggestions list next to typed text
				caseSensitive: true, // allow adding duplicate items if their case is different
			},
			templates: {
				dropdownItemNoMatch: function (data) {
					return `<div class='${this.settings.classNames.dropdownItem}' value="noMatch" tabindex="0" role="option">
                    No suggestion found for: <strong>${data.value}</strong>
                </div>`;
				},
			},
		});

	// generate a random color (in HSL format, which I like to use)
	function getRandomColor() {
		function rand(min, max) {
			return min + Math.random() * (max - min);
		}

		var h = rand(1, 360) | 0,
			s = rand(40, 70) | 0,
			l = rand(65, 72) | 0;

		return "hsl(" + h + "," + s + "%," + l + "%)";
	}

	function transformTag(tagData) {
		tagData.color = getRandomColor();
		tagData.style = "--tag-bg:" + tagData.color;

		if (tagData.value.toLowerCase() == "shit") tagData.value = "s✲✲t";
	}

	tagify.on("add", function (e) {
		console.log(e.detail);
	});

	tagify.on("invalid", function (e) {
		console.log(e, e.detail);
	});

	var clickDebounce;

	tagify.on("click", function (e) {
		const { tag: tagElm, data: tagData } = e.detail;

		// a delay is needed to distinguish between regular click and double-click.
		// this allows enough time for a possible double-click, and noly fires if such
		// did not occur.
		clearTimeout(clickDebounce);
		clickDebounce = setTimeout(() => {
			tagData.color = getRandomColor();
			tagData.style = "--tag-bg:" + tagData.color;
			tagify.replaceTag(tagElm, tagData);
		}, 200);
	});

	tagify.on("dblclick", function (e) {
		// when souble clicking, do not change the color of the tag
		clearTimeout(clickDebounce);
	});
}

//Public method to initialize all charts
(function () {
	initBasicTagify();
	initSuggestionsTagify();
	initUsersTagify();
	initCountriesTagify();
	initCustomLookTagify();
	initAdvanceTagify();
})();
