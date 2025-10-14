"use strict";

// Initialize
function initOwlCarouselBasic() {
	$("#owlCarouselBasic").owlCarousel({
		loop: true,
		margin: 10,
		nav: true,
		responsive: {
			0: {
				items: 1,
			},
			600: {
				items: 3,
			},
			1000: {
				items: 5,
			},
		},
	});
}

// Initialize OwlCarousel Responsive
function initOwlCarouselResponsive() {
	$("#owlCarouselResponsive").owlCarousel({
		loop: true,
		margin: 10,
		responsiveClass: true,
		responsive: {
			0: {
				items: 1,
				nav: true,
			},
			600: {
				items: 3,
				nav: false,
			},
			1000: {
				items: 5,
				nav: true,
				loop: false,
			},
		},
	});
}

// Initialize OwlCarousel Merge
function initOwlCarouselMerge() {
	$("#owlCarouselMerge").owlCarousel({
		items: 5,
		loop: true,
		margin: 10,
		merge: true,
		responsive: {
			678: {
				mergeFit: true,
			},
			1000: {
				mergeFit: false,
			},
		},
	});
}

// Initialize OwlCarousel AutoWidth
function initOwlCarouselAutoWidth() {
	$("#owlCarouselAutoWidth").owlCarousel({
		margin: 10,
		loop: true,
		autoWidth: true,
		items: 4,
	});
}

// Initialize OwlCarousel StagePadding
function initOwlCarouselStagePadding() {
	$("#owlCarouselStagePadding").owlCarousel({
		stagePadding: 50,
		loop: true,
		margin: 10,
		nav: true,
		responsive: {
			0: {
				items: 1,
			},
			600: {
				items: 3,
			},
			1000: {
				items: 5,
			},
		},
	});
}

// Initialize OwlCarousel Video
function initOwlCarouselVideo() {
	$("#owlCarouselVideo").owlCarousel({
		items: 1,
		merge: true,
		loop: true,
		margin: 10,
		video: true,
		//lazyLoad: true,
		center: true,
		responsive: {
			480: {
				items: 2,
			},
			600: {
				items: 4,
			},
		},
	});
}

// Initialize OwlCarousel Autoplay
function initOwlCarouselAutoplay() {
	var owl = $("#owlCarouselAutoplay");
	owl.owlCarousel({
		items: 4,
		loop: true,
		margin: 10,
		autoplay: true,
		autoplayTimeout: 1000,
		autoplayHoverPause: true,
	});
	$(".play").on("click", function () {
		owl.trigger("play.owl.autoplay", [1000]);
	});
	$(".stop").on("click", function () {
		owl.trigger("stop.owl.autoplay");
	});
}

// Initialize OwlCarousel Mousewheel
function initOwlCarouselMousewheel() {
	var owl = $("#owlCarouselMousewheel");
	owl.owlCarousel({
		loop: true,
		nav: true,
		margin: 10,
		responsive: {
			0: {
				items: 1,
			},
			600: {
				items: 3,
			},
			960: {
				items: 5,
			},
			1200: {
				items: 6,
			},
		},
	});
	owl.on("mousewheel", ".owl-stage", function (e) {
		if (e.deltaY > 0) {
			owl.trigger("next.owl");
		} else {
			owl.trigger("prev.owl");
		}
		e.preventDefault();
	});
}

//Public method to initialize all charts
(function () {
	initOwlCarouselBasic();
	initOwlCarouselResponsive();
	initOwlCarouselMerge();
	initOwlCarouselAutoWidth();
	initOwlCarouselStagePadding();
	initOwlCarouselVideo();
	initOwlCarouselAutoplay();
	initOwlCarouselMousewheel();
})();
