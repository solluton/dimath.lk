"use strict";

// Initialize Swiper Default
function initSwiperDefault() {
	var swiper = new Swiper("#swiperDefault");
}

// Initialize Swiper Navigation
function initSwiperNavigation() {
	var swiper = new Swiper("#swiperNavigation", {
		navigation: {
			nextEl: ".swiper-button-next",
			prevEl: ".swiper-button-prev",
		},
	});
}

// Initialize Swiper Pagination
function initSwiperPagination() {
	var swiper = new Swiper("#swiperPagination", {
		pagination: {
			el: ".swiper-pagination",
		},
	});
}

// Initialize Swiper Progress
function initSwiperProgress() {
	var swiper = new Swiper("#swiperProgress", {
		pagination: {
			el: ".swiper-pagination",
			type: "progressbar",
		},
		navigation: {
			nextEl: ".swiper-button-next",
			prevEl: ".swiper-button-prev",
		},
	});
}

// Initialize Swiper Scrollbar
function initSwiperScrollbar() {
	var swiper = new Swiper("#swiperScrollbar", {
		scrollbar: {
			el: ".swiper-scrollbar",
			hide: true,
		},
	});
}

// Initialize Swiper Vertical
function initSwiperVertical() {
	var swiper = new Swiper("#swiperVertical", {
		direction: "vertical",
		pagination: {
			el: ".swiper-pagination",
			clickable: true,
		},
	});
}

// Initialize Swiper Nested
function initSwiperNested() {
	var swiper = new Swiper("#swiperNestedHorizontal", {
		spaceBetween: 50,
		pagination: {
			el: ".swiper-pagination",
			clickable: true,
		},
	});
	var swiper2 = new Swiper("#swiperNestedVertical", {
		direction: "vertical",
		spaceBetween: 50,
		pagination: {
			el: ".swiper-pagination",
			clickable: true,
		},
	});
}

// Initialize Swiper Autoplay
function initSwiperAutoplay() {
	const progressCircle = document.querySelector(".autoplay-progress svg");
	const progressContent = document.querySelector(".autoplay-progress span");
	var swiper = new Swiper("#swiperAutoplay", {
		spaceBetween: 30,
		centeredSlides: true,
		autoplay: {
			delay: 2500,
			disableOnInteraction: false,
		},
		pagination: {
			el: ".swiper-pagination",
			clickable: true,
		},
		navigation: {
			nextEl: ".swiper-button-next",
			prevEl: ".swiper-button-prev",
		},
		on: {
			autoplayTimeLeft(s, time, progress) {
				progressCircle.style.setProperty("--progress", 1 - progress);
				progressContent.textContent = `${Math.ceil(time / 1000)}s`;
			},
		},
	});
}

// Initialize Swiper Thumbs Gallery
function initSwiperThumbsGallery() {
	var swiper = new Swiper("#swiperGalleryThumbs", {
		loop: true,
		spaceBetween: 10,
		slidesPerView: 4,
		freeMode: true,
		watchSlidesProgress: true,
	});
	var swiper2 = new Swiper("#swiperGalleryImages", {
		loop: true,
		spaceBetween: 10,
		navigation: {
			nextEl: ".swiper-button-next",
			prevEl: ".swiper-button-prev",
		},
		thumbs: {
			swiper: swiper,
		},
	});
}

//Public method to initialize all charts
(function () {
	initSwiperDefault();
	initSwiperNavigation();
	initSwiperPagination();
	initSwiperProgress();
	initSwiperScrollbar();
	initSwiperVertical();
	initSwiperNested();
	initSwiperAutoplay();
	initSwiperThumbsGallery();
})();
