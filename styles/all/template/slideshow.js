var slides = document.getElementsByClassName("slideshow-slides");
var slideIndex = Math.floor(Math.random() * slides.length);
var showLoopTime = S_SLIDESHOW_DURATION;
showSlides(slideIndex);
var slideShowTimer = setInterval(loopSlides, showLoopTime);

function showSlides(n) {
	if (slides.length == 0) {
		return;
	}
	
	var i;
	if (n > slides.length) {
		slideIndex = 1;
	}
	if (n < 1) {
		slideIndex = slides.length;
	}
	for (i = 0; i < slides.length; i++) {
		slides[i].style.opacity = 0;
		slides[i].style.height= 0;
	}
	slides[slideIndex-1].style.opacity = 1;
	slides[slideIndex-1].style.height = "100%";
	
	/* Dot navigator */
	if (S_SLIDESHOW_NAV_DOT == 1)
	{
		var dotNav = document.getElementsByClassName("slideshow-dot-navigator");
		for (i = 0; i < dotNav.length; i++) {
			dotNav[i].className = dotNav[i].className.replace(" slideshow-active", "");
		}
		dotNav[slideIndex-1].className += " slideshow-active";
	}
	/* Image navigator */
	if (S_SLIDESHOW_NAV_IMAGE == 1)
	{
		var imgNav = document.getElementsByClassName("slideshow-image-navigator");
		for (i = 0; i < imgNav.length; i++) {
			imgNav[i].className = imgNav[i].className.replace(" slideshow-active", "");
		}
		imgNav[slideIndex-1].className += " slideshow-active";
		imgNav[slideIndex-1].parentElement.scrollTop = imgNav[slideIndex-1].offsetTop;
	}
}

function loopSlides() {
	slideIndex++;
	if (slideIndex > slides.length) {
		slideIndex = 1;
	}
	if (slideIndex < 1) {
		slideIndex = slides.length;
	}
	showSlides(slideIndex);
}

function plusSlides(n) {
	showSlides(slideIndex += n);
	resetShowTimer();
}

function currentSlide(n) {
	slideIndex = n;
	showSlides(n);
	resetShowTimer();
}

function resetShowTimer() {
	clearInterval(slideShowTimer);
	slideShowTimer = setInterval(loopSlides, showLoopTime);
}

/* Swipe event */
for (i = 0; i < slides.length; i++) {
	slides[i].addEventListener('touchstart', handleTouchStart, false);
	slides[i].addEventListener('touchmove', slideShow_handleTouchMove, false);
}

var xDown = null;
var yDown = null;

function getTouches(evt) {
	return evt.touches || evt.originalEvent.touches; // jQuery
}

function handleTouchStart(evt) {
	const firstTouch = getTouches(evt)[0];
	xDown = firstTouch.clientX;
	yDown = firstTouch.clientY;
}

function slideShow_handleTouchMove(evt) {
	if (!xDown || !yDown) {
		return;
	}

	var xUp = evt.touches[0].clientX;
	var yUp = evt.touches[0].clientY;

	var xDiff = xDown - xUp;
	var yDiff = yDown - yUp;

	/* Most significant */
	if (Math.abs(xDiff) > Math.abs(yDiff)) {
		if (xDiff > 0) {
			/* Swipe right */
			plusSlides(1);
		} else {
			/* Swipe left */
			plusSlides(-1);
		}
	} else {
		if (yDiff > 0) {
			/* Swipe down */ 
		} else { 
			/* Swipe up */
		}
	}
	/* Reset values */
	xDown = null;
	yDown = null;
}