"use strict";

// Initialize Sweetalert Basic
function initSweetalertBasic() {
	const button = document.getElementById("sweetalertBasic");

	button.addEventListener("click", (e) => {
		e.preventDefault();

		Swal.fire("Any fool can use a computer");
	});
}

// Initialize Sweetalert WithTitle
function initSweetalertWithTitle() {
	const button = document.getElementById("sweetalertWithTitle");

	button.addEventListener("click", (e) => {
		e.preventDefault();

		Swal.fire("The Internet?", "That thing is still around?", "question");
	});
}

// Initialize Sweetalert WithFooter
function initSweetalertWithFooter() {
	const button = document.getElementById("sweetalertWithFooter");

	button.addEventListener("click", (e) => {
		e.preventDefault();

		Swal.fire({
			icon: "error",
			title: "Oops...",
			text: "Something went wrong!",
			footer: '<a href="">Why do I have this issue?</a>',
		});
	});
}

// Initialize Sweetalert HTML
function initSweetalertHTML() {
	const button = document.getElementById("sweetalertHTML");

	button.addEventListener("click", (e) => {
		e.preventDefault();

		Swal.fire({
			title: "<strong>HTML <u>example</u></strong>",
			icon: "info",
			html: "You can use <b>bold text</b>, " + '<a href="//sweetalert2.github.io">links</a> ' + "and other HTML tags",
			showCloseButton: true,
			showCancelButton: true,
			focusConfirm: false,
			confirmButtonText: '<i class="fi fi-rr-social-network me-2"></i> Great!',
			confirmButtonAriaLabel: "Thumbs up, great!",
			cancelButtonText: '<i class="fi fi-rr-hand"></i>',
			cancelButtonAriaLabel: "Thumbs down",
			customClass: {
				confirmButton: "btn btn-success",
				cancelButton: "btn btn-danger",
			},
		});
	});
}

// Initialize Sweetalert Actions
function initSweetalertActions() {
	const button = document.getElementById("sweetalertActions");

	button.addEventListener("click", (e) => {
		e.preventDefault();

		Swal.fire({
			title: "Do you want to save the changes?",
			showDenyButton: true,
			showCancelButton: true,
			confirmButtonText: "Save",
			denyButtonText: `Don't save`,
		}).then((result) => {
			/* Read more about isConfirmed, isDenied below */
			if (result.isConfirmed) {
				Swal.fire("Saved!", "", "success");
			} else if (result.isDenied) {
				Swal.fire("Changes are not saved", "", "info");
			}
		});
	});
}

// Initialize Sweetalert Top Start
function initSweetalertTopStart() {
	const button = document.getElementById("sweetalertTopStart");

	button.addEventListener("click", (e) => {
		e.preventDefault();

		Swal.fire({
			position: "top-start",
			icon: "success",
			title: "Your work has been saved",
			showConfirmButton: false,
			timer: 1500,
		});
	});
}

// Initialize Sweetalert Top End
function initSweetalertTopEnd() {
	const button = document.getElementById("sweetalertTopEnd");

	button.addEventListener("click", (e) => {
		e.preventDefault();

		Swal.fire({
			position: "top-end",
			icon: "success",
			title: "Your work has been saved",
			showConfirmButton: false,
			timer: 1500,
		});
	});
}

// Initialize Sweetalert Bottom Start
function initSweetalertBottomStart() {
	const button = document.getElementById("sweetalertBottomStart");

	button.addEventListener("click", (e) => {
		e.preventDefault();

		Swal.fire({
			position: "bottom-start",
			icon: "success",
			title: "Your work has been saved",
			showConfirmButton: false,
			timer: 1500,
		});
	});
}

// Initialize Sweetalert Bottom End
function initSweetalertBottomEnd() {
	const button = document.getElementById("sweetalertBottomEnd");

	button.addEventListener("click", (e) => {
		e.preventDefault();

		Swal.fire({
			position: "bottom-end",
			icon: "success",
			title: "Your work has been saved",
			showConfirmButton: false,
			timer: 1500,
		});
	});
}

// Initialize Sweetalert Success
function initSweetalertSuccess() {
	const button = document.getElementById("sweetalertTypeSuccess");

	button.addEventListener("click", (e) => {
		e.preventDefault();

		Swal.fire({
			text: "Success: Good job!",
			icon: "success",
			buttonsStyling: false,
			confirmButtonText: "Ok, got it!",
			customClass: {
				confirmButton: "btn btn-success",
			},
		});
	});
}

// Initialize Sweetalert Info
function initSweetalertInfo() {
	const button = document.getElementById("sweetalertTypeInfo");

	button.addEventListener("click", (e) => {
		e.preventDefault();

		Swal.fire({
			text: "Info: About informations",
			icon: "info",
			buttonsStyling: false,
			confirmButtonText: "Ok, got it!",
			customClass: {
				confirmButton: "btn btn-info",
			},
		});
	});
}

// Initialize Sweetalert Warning
function initSweetalertWarning() {
	const button = document.getElementById("sweetalertTypeWarning");

	button.addEventListener("click", (e) => {
		e.preventDefault();

		Swal.fire({
			text: "Warning: Your attentions",
			icon: "warning",
			buttonsStyling: false,
			confirmButtonText: "Ok, got it!",
			customClass: {
				confirmButton: "btn btn-warning",
			},
		});
	});
}

// Initialize Sweetalert Error
function initSweetalertError() {
	const button = document.getElementById("sweetalertTypeError");

	button.addEventListener("click", (e) => {
		e.preventDefault();

		Swal.fire({
			text: "Error: Something error",
			icon: "error",
			buttonsStyling: false,
			confirmButtonText: "Ok, got it!",
			customClass: {
				confirmButton: "btn btn-danger",
			},
		});
	});
}

// Initialize Sweetalert Question
function initSweetalertQuestion() {
	const button = document.getElementById("sweetalertTypeQuestion");

	button.addEventListener("click", (e) => {
		e.preventDefault();

		Swal.fire({
			text: "Question: What's matter?",
			icon: "question",
			buttonsStyling: false,
			confirmButtonText: "Ok, got it!",
			customClass: {
				confirmButton: "btn btn-secondary",
			},
		});
	});
}

// Initialize Sweetalert Alert
function initSweetalertAlert() {
	const button = document.getElementById("sweetalertAlert");

	button.addEventListener("click", (e) => {
		e.preventDefault();

		Swal.fire({
			title: "Are you sure?",
			text: "You won't be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, delete it!",
		}).then((result) => {
			if (result.isConfirmed) {
				Swal.fire("Deleted!", "Your file has been deleted.", "success");
			}
		});
	});
}

// Initialize Sweetalert Confirm
function initSweetalertConfirm() {
	const button = document.getElementById("sweetalertConfirm");

	button.addEventListener("click", (e) => {
		e.preventDefault();

		const swalWithBootstrapButtons = Swal.mixin({
			customClass: {
				confirmButton: "btn btn-success",
				cancelButton: "btn btn-danger",
			},
			buttonsStyling: false,
		});

		swalWithBootstrapButtons
			.fire({
				title: "Are you sure?",
				text: "You won't be able to revert this!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel!",
				reverseButtons: true,
			})
			.then((result) => {
				if (result.isConfirmed) {
					swalWithBootstrapButtons.fire("Deleted!", "Your file has been deleted.", "success");
				} else if (
					/* Read more about handling dismissals below */
					result.dismiss === Swal.DismissReason.cancel
				) {
					swalWithBootstrapButtons.fire("Cancelled", "Your imaginary file is safe :)", "error");
				}
			});
	});
}

// Initialize Sweetalert Mixin
function initSweetalertMixin() {
	const button = document.getElementById("sweetalertMixin");

	button.addEventListener("click", (e) => {
		e.preventDefault();

		const Toast = Swal.mixin({
			toast: true,
			position: "top-end",
			showConfirmButton: false,
			timer: 3000,
			timerProgressBar: true,
			didOpen: (toast) => {
				toast.addEventListener("mouseenter", Swal.stopTimer);
				toast.addEventListener("mouseleave", Swal.resumeTimer);
			},
		});

		Toast.fire({
			icon: "success",
			title: "Signed in successfully",
		});
	});
}

// Initialize Sweetalert Custom Success
function initSweetalertCustomSuccess() {
	const button = document.getElementById("sweetalertCustomSuccess");

	button.addEventListener("click", (e) => {
		e.preventDefault();
		Swal.fire({
			html: '<div class="mt-3"><img src="./../../assets/images/general/success.png" alt=""  height="150"></img><div class="mt-4 pt-2"><h4>Well done!!!</h4><p class="text-muted mx-4 mb-0">Aww yeah, you successfully read this important message.</p></div></div>',
			showCancelButton: true,
			showConfirmButton: false,
			cancelButtonText: "Back",
			buttonsStyling: true,
			showCloseButton: true,
		});
	});
}

// Initialize Sweetalert Custom Error
function initSweetalertCustomError() {
	const button = document.getElementById("sweetalertCustomError");

	button.addEventListener("click", (e) => {
		e.preventDefault();

		Swal.fire({
			html: '<div class="mt-3"><i class="fi fi-rr-times-hexagon text-danger" style="font-size: 5rem"></i><div class="mt-4 pt-2"><h4>Oops...! Something went Wrong!!!</h4><p class="text-muted mx-4 mb-0">Your email Address is invalid</p></div></div>',
			showCancelButton: true,
			showConfirmButton: false,
			cancelButtonText: "Dismiss",
			buttonsStyling: true,
			showCloseButton: true,
		});
	});
}

// Initialize Sweetalert Custom Warning
function initSweetalertCustomWarning() {
	const button = document.getElementById("sweetalertCustomWarning");

	button.addEventListener("click", (e) => {
		e.preventDefault();

		Swal.fire({
			html: '<div class="mt-3"><div class="avatar avatar-xl bg-danger-subtle"><i class="fi fi-rr-trash text-danger"></i></div><div class="mt-4 pt-2 mx-5"><h4>Are you Sure ?</h4><p class="text-muted mx-4 mb-0">Are you Sure You want to Delete this Account ?</p></div></div>',
			showCancelButton: true,
			confirmButtonText: "Yes, Delete It!",
			buttonsStyling: true,
			showCloseButton: true,
		});
	});
}

// Initialize Sweetalert Custom Join Community
function initSweetalertCustomJoinCommunity() {
	const button = document.getElementById("sweetalertCustomJoinCommunity");

	button.addEventListener("click", (e) => {
		e.preventDefault();

		Swal.fire({
			title: "<h4>Join Our Community</h4>",
			html: '<div class="mt-3 mb-4 text-start px-md-16"><input type="email" class="form-control" id="input-email" placeholder="Enter Email Address"></div>',
			imageUrl: "./../../assets/images/logo-abbr.png",
			footer: '<p class="text-muted mb-0">Already have an account ? <a href="#" class="fw-semibold text-decoration-underline"> Signin </a> </p>',
			imageHeight: 40,
			confirmButtonText: 'Register <i class="fi fi-rr-arrow-small-right ms-1 align-bottom"></i>',
			buttonsStyling: true,
			showCloseButton: true,
		});
	});
}

// Initialize Sweetalert Custom Email Verification
function initSweetalertCustomEmailVerification() {
	const button = document.getElementById("sweetalertCustomEmailVerification");

	button.addEventListener("click", (e) => {
		e.preventDefault();

		Swal.fire({
			html: '<div class="mt-3"><div class="avatar avatar-xxl bg-success-subtle text-success mx-auto"><i class="fi fi-rr-envelope-dot fs-3"></i></div><div class="mt-4 pt-2 "><h4 class="fw-semibold">Verify Your Email</h4><p class="text-muted mb-0 mt-3">We have sent you verification email <span class="fw-medium">example@abc.com</span>, <br/> Please check it.</p></div></div>',
			showCancelButton: false,
			confirmButtonText: "Verify Email",
			buttonsStyling: true,
			footer: '<p class="text-muted mb-0">Didn\'t receive an email ? <a href="#" class="fw-semibold text-decoration-underline">Resend</a></p>',
			showCloseButton: true,
		});
	});
}

// Initialize Sweetalert Custom Notification Message
function initSweetalertCustomNotificationMessage() {
	const button = document.getElementById("sweetalertCustomNotificationMessage");

	button.addEventListener("click", (e) => {
		e.preventDefault();

		Swal.fire({
			html: '<div class="mt-3"><div class="avatar avatar-xxl mx-auto"><img src="./../../assets/images/avatar/1.png" class="rounded-circle img-thumbnail" alt="thumbnail"></div><div class="mt-4 pt-2"><h4 class="fw-semibold">Welcome <span class="fw-semibold">Alexandra Della</span></h4><p class="text-muted mb-0">You have <span class="fw-semibold text-success">5+</span> Notifications</p></div></div>',
			showCancelButton: false,
			confirmButtonText: 'Show Me <i class="fi fi-rr-arrow-small-right ms-1 align-bottom"></i>',
			buttonsStyling: true,
			showCloseButton: true,
		});
	});
}

//Public method to initialize all charts
(function () {
	initSweetalertBasic();
	initSweetalertWithTitle();
	initSweetalertWithFooter();
	initSweetalertHTML();
	initSweetalertActions();
	initSweetalertTopStart();
	initSweetalertTopEnd();
	initSweetalertBottomStart();
	initSweetalertBottomEnd();
	initSweetalertSuccess();
	initSweetalertInfo();
	initSweetalertWarning();
	initSweetalertError();
	initSweetalertQuestion();
	initSweetalertAlert();
	initSweetalertConfirm();
	initSweetalertMixin();
	initSweetalertCustomSuccess();
	initSweetalertCustomError();
	initSweetalertCustomWarning();
	initSweetalertCustomJoinCommunity();
	initSweetalertCustomEmailVerification();
	initSweetalertCustomNotificationMessage();
})();
