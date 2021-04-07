(function( $ ) {
	
	//jQuery vars
	var sliderItem = $(".slider-item");
	var postImageWrap = $(".post-image-wrap");
	var sliderSecondary = $(".slider-secondary");
	
	//pure JS vars
	var postImageWrapJs = document.getElementsByClassName("post-image-wrap")[0];
	var postImagesliderJs = document.getElementsByClassName("post-image-slider")[0];
	var sliderBulletsJs = document.getElementsByClassName("slider-bullets")[0];
	var postImageWrapJs = document.getElementsByClassName("post-image-wrap")[0];
	var postImageSliderJs = document.getElementsByClassName("post-image-slider")[0];
	
	//other
	var postImageSliderHammer;
	var postImageWrapHammer;
	var fixedZoom;
	
	//these are redefined on resize
	var wh = window.innerHeight/100;
	var vw = window.innerWidth/100;
	
	//slider object
	window.Slider = function() {
		var sld = this;
		
		var animationDuration = 5000; //set default duration here
		var state = "start"; //start state for the slider - means default
		
		sld.state = {}
		//show slider state
		sld.state.show = function() {return state }
		//set slider state
		sld.state.set = function(param) { state = param }
		
		//
		// properties that are available for the slider.
		//
		sld.available = {}
		//width
		sld.available.width = function() {
			return 100*vw;
		}
		//height
		sld.available.height = function() {
			return 100*wh - 95; // removes top menu and footer
		}
		// top offset
		sld.available.topOffset = function() {
			return Number(postImageWrap.css("padding-top").replace("px","") );
		}
		
		//switch to given slide
		sld.jump = function(sliderNo)  {
			if ( state !== "expanded" ) {
				//set active slider
				sliderItem.removeClass("active-slider");
				$("#slider-" + sliderNo).addClass("active-slider");
				
				//set bullet
				$(".bullet-item").removeClass("active-bullet");
				$(".bullet-" + sliderNo).addClass("active-bullet");
				
				//retrieve images for active and next slider for smooth viewing
				sld.retrieveImage(sliderNo);
				sld.retrieveImage( sld.next() , animationDuration/2 );
			}
		}
		
		//retrieves the image for the given slider number
		sld.retrieveImage = function(sliderNo, delay) {
			
			delay = delay || 0;
			var activeSlider = $("#slider-" + sliderNo);
			
			if (sliderNo > 1 && activeSlider.css("background-image") == "none") {
				setTimeout(function() {
					activeSlider.css("background-image", 'url("' + sliderList[sliderNo-1][0] + '")');
				},delay);
			}
		}
		
		
		//
		//Total number of slides
		//
		
		sld.total = {}
		//total slide number
		sld.total.no = function() {
			return parseInt(postImageWrap.children().length);
		}
		
		
		//
		// active slide
		//
		
		sld.active = {}
		//active slide no
		sld.active.no = function() {
			return parseInt($(".active-slider").attr("id").replace("slider-",""));
		}
		//active slide url
		sld.active.url = function() {
			return sliderList[ sld.active.no() -1 ][0];
		}
		//active slide width
		sld.active.width = function() {
			return sliderList[ sld.active.no() -1 ][1];
		}
		//active slide heght
		sld.active.height = function() {
			return sliderList[ sld.active.no() -1 ][2];
		}
		//active image current properties
		sld.active.current = {}
		sld.active.current.dimensions = function() {
			
		}

		
		
		//
		// next slide
		//
		
		//gets the next (or previous slide number)
		sld.next = function(skipNumber) {

			skipNumber = skipNumber || 1;	
		
			var active = sld.active.no();
			var total = sld.total.no();
			return  1 + (total + active + skipNumber - 1) % ( total );
			
		}
		
		//advance from current slider no + skipNumber (negative numbers allowed) default: 1
		sld.advance = function(skipNumber) {
			if( state !== "expanded" ) {
				sld.jump( sld.next(skipNumber) ) ;	
			}
		}
		
		
		//
		//click 
		//
		sld.click = {}
				
		//click switch function, window scrolls up
		sld.click.jump = function(sliderNo) {
			
			sld.jump(sliderNo);
			goTop();
			
			try {
				sld.animation.stop();
				window.slider.timer = new Timer(sld.animation.queue, animationDuration);
			} catch(e) {}	
		}
		//click advancement, window scrolls up
		sld.click.advance = function(skipNo) {
			
			sld.advance(skipNo);
			goTop();
			
			try {
				sld.animation.stop();
				window.slider.timer = new Timer(sld.animation.queue, animationDuration);
			} catch(e) {}
		}
		
		
		
		
		
		//
		//animation
		//
		sld.animation = {};
		
		//sets the duration every slide will be visible
		sld.animation.duration = {};
		sld.animation.duration.set = function(dur) {
			var currentDur = animationDuration;	
			if (dur >= 200) {
				animationDuration = dur;
				sld.animation.stop();
				sld.animation.start();
			} else {
				console.error("Minimum allowed animation duration is 200ms.");
			}
		}
		//display current animation duration
		sld.animation.duration.show = function() {
			return animationDuration;
		}
		
		//advances the slide and queues the next switch
		sld.animation.queue = function() {
			sld.advance();
			sld.animation.start();
		}
		
		//starts countdown for next switch if not in debug
		sld.animation.start = function() {
			if (state !== "expanded") {
				window.slider.timer = new Timer(sld.animation.queue, animationDuration);
			}
		}

		//stops and removes animation
		sld.animation.stop = function() {
			if(sld.timer) {
				sld.timer.clear();
				delete sld.timer;
			}
		}
		
		
		
		//
		// view modes
		//
		sld.mode = {}
		//expand the slider and enable zoom & pan
		sld.mode.expanded = function() {
			
			//setting the needed state for the expanded view
			sld.state.set("expanded");
			goTop(); // go to the top of the page
			sld.animation.stop(); // stop the animation
			postImageSliderHammer.off("swipeleft swiperight"); // disable normal slider left right swipes
			
			//assigning needed variables
			var total = sld.total.no();
			var sliderNo = sld.active.no();
			var imgWidth = sld.active.width();
			var imgHeight = sld.active.height();
			var actSlider = document.getElementById( "slider-" + sliderNo ).style;
			var availWidth = sld.available.width();
			var availHeight = sld.available.height();
			var startWidth = ( imgWidth/2 ) * availHeight / ( imgHeight/2 );
			var startHeight = availHeight;
			var topPos = sld.available.topOffset();
			
			//static css styles
			postImageWrapJs.style.paddingBottom = "30px";
			if( sliderBulletsJs ) {	sliderBulletsJs.style.marginTop = "-63px"; }
			
			postImagesliderJs.style.padding = "0";
			postImagesliderJs.style.height = 100*wh + "px";
			postImageWrapJs.style.height = 100*wh + "px";
			actSlider.backgroundSize = String(startWidth) + "px " + String(startHeight) + "px";
			actSlider.backgroundPosition = String( -( startWidth - availWidth)/2 ) + "px 0px";
			sliderSecondary.css("margin-top", 90 - 100*wh + "px");

			//starting hammer
			postImageWrapHammer = new Hammer(postImageWrapJs);
			postImageWrapHammer.get('pinch').set({ enable: true });
			
			postImageWrapHammer.on('pinch pan', function(ev) {
				
				//data gathering
				var scl = ev.scale;
				
				//position
				var activePosition = actSlider.backgroundPosition.replace("px","").replace("px","").split(" ");
				var xPosition = Number( activePosition[0] );
				var yPosition = Number( activePosition[1] );
				//size
				var activeDims = actSlider.backgroundSize.replace("px","").replace("px","").split(" ");
				var activeWidth = Number(activeDims[0]);
				var activeHeight = Number(activeDims[1]);
				
				
				//
				//setting new values
				//

				//zoom
				var zoom = ( (scl - 1) < 0 ? -1 : 1  ) * Math.abs(scl - 1) / 30 + 1 ;
				//error fixing
				var rawHeight = activeHeight*zoom;
				var pixelFactor = 2;
				if( rawHeight < startHeight ) { zoom = startHeight / activeHeight } //fix for smaller than allowed
				if( rawHeight > imgHeight * pixelFactor ) { zoom = imgHeight / activeHeight * pixelFactor } //fix for bigger than allowed
				 
				//imge size expansion
				var zoomWidth = activeWidth*zoom;
				var zoomHeight = activeHeight*zoom;
				//img size repositioning
				
				// testPrint({
					// "v.x": ev.velocityX,
					// "v.y": ev.velocityY
				// });
			
				//yPosition -=  ( zoom - 1 ) * activeHeight / 2; // zooms to image center
				//xPosition -= ( zoom - 1 ) * ( -xPosition + availWidth/2 ); // zooms to screen center
				xPosition -= ( zoom - 1 ) * ( -xPosition + ev.center.x ); // zooms to finger position
				yPosition -= ( zoom - 1 ) * ( -yPosition + ev.center.y - topPos);
				
				//position x - y
				xPosition += ev.velocityX * availWidth * activeWidth / imgWidth / 12; // doesnt move at the same speed with the finger
				yPosition += ev.velocityY * availHeight * activeHeight / imgHeight / 12;

				//error fixing position x
				if( xPosition < availWidth - zoomWidth + 1 ) { xPosition = availWidth - zoomWidth + 1 } //disable going too right
				xLimit = activeWidth < availWidth ? (availWidth-activeWidth)/2 : 0; // checking if the image is narrower than the screen
				if( xPosition > xLimit) { xPosition = xLimit } // disable going too left
				
				//error fixing for position y
				if( yPosition < availHeight - zoomHeight ) { yPosition = availHeight - zoomHeight } //disable going too down
				if( yPosition > 0) { yPosition = 0 } // disable going too up
				
				//final style assignment
				actSlider.backgroundSize = String( zoomWidth ) + "px " + String( zoomHeight ) + "px";
				actSlider.backgroundPosition = String( xPosition ) + "px " + String( yPosition ) + "px";

			});
		}
		

		//return slider to normal mode
		sld.mode.normal = function() {
			
			sld.state.set("normal");
			goTop(); // go to the top of the page
			
			sliderSecondary.css({ "margin-top": "" });
			sliderItem.css({ "background-size": "", "background-position": "" });
			
			postImageWrapJs.style.height = "";
			postImageWrapJs.style.paddingBottom = "";
			postImagesliderJs.style.height = "";
			postImagesliderJs.style.padding = "";

			postImageSliderHammer.on("swipeleft", function() { sld.click.advance(-1) });
			postImageSliderHammer.on("swiperight", function() { sld.click.advance() });
			
			if( sliderBulletsJs ) { sliderBulletsJs.style.marginTop = ""; }
			
			if ( postImageWrapHammer ) {
				postImageWrapHammer.get('pinch').set({ enable: false });
				postImageWrapHammer.off('pan pinch');
			}
			
			sld.animation.start();
			
		}
		
		//toggles between two modes, always toggles to normal mode if screen width is bigger than 768
		sld.mode.toggle = function() {
			if( vw*100 <= 768 && state !== "expanded") {
				slider.mode.expanded();
			} else { 
				slider.mode.normal();
			}
		}

		//slider mode check for resize and other events
		sld.mode.detect = function() {
			
			var h = hash.get();
			var c = hash.count;
			var s = state;
			var v = 100*vw;
			var e = "expanded";
			
			if( v >= 768 && h == e && s == e ) {
				
				c > 0 ? hash.goback() : hash.clear();
				
			} else if ( v < 768 && h == e && s !== e) {
				
				slider.mode.expanded();
				
			} else if ( s == e && h !== e ) {
				
				slider.mode.normal();
				
			}
		}
	}


	
	//timer object
	function Timer(func, delay) {
		
		var self = this;
		var args = arguments, timer, start, state;
			
		state = "stop";
		
		//resume timer
		self.resume = function () {
			//this stops double resume commands that may occur.
			if( state !== "resume") {
				state = "resume";
				start = new Date();
				timer = setTimeout( function () { func(delay); }, delay);
			}
		};
		
		//clear time
		self.clear = function () {
			state = "clear";
			clearTimeout(timer);
		};
		
		//pause timer
		self.pause = function () {
			self.clear();
			state = "pause";
			delay -= new Date() - start;
		};
		
		//start timer
		self.resume();
	}
	
	
	
	
	//hash handler object
	window.HashHandler = function() {
		var hs = this;
		
		//number of hashes till the
		//back button reaches the beginning
		hs.count = 0;
		
		// get current hash
		hs.get = function() {
			return window.location.hash.substr(1);
		}
		
		// set hash
		hs.set = function(str) {
			window.location.hash = str;
			hs.count += 1;
		}
		
		// go back
		hs.goback = function() {
			if( hs.count > 0 ) {
				window.history.back();
				hs.count -= 1;
			}
		}
		//clear hash
		hs.clear = function() {
			history.replaceState("", document.title, window.location.pathname + window.location.search);
		}
	}

	
	
	//go to top
	function goTop() {
		var scrTop = $(window).scrollTop();
		
		if (scrTop > 0) {
			$('html, body').animate({
				scrollTop: 0
			}, 500);
		}
	}
	

	
	
	//document ready actions
	$( document ).ready(function() {
		
		//slider definitions
		window.slider = new Slider();
		window.hash = new HashHandler();
		postImageSliderHammer = new Hammer(postImagesliderJs);
		
		//
		// slider init
		//
		if( 100*vw > 768) { hash.clear() }
		//detect slider mode
		slider.mode.detect();
		//start Slider animation
		if (slider.state.show() !== "expanded") {
			slider.animation.start();
		}
		//get next image
		slider.retrieveImage( 2, slider.animationDuration/2 ); 

		
		//
		//slider hover stuff
		//
		//mouse enter
		sliderItem.mouseenter(function() {
			try {
				slider.timer.pause();
			} catch(e) {}
		});	
		
		// mouse leave
		sliderItem.mouseleave(function() {
			try {
				slider.timer.resume();
			} catch(e) {}
		});
		
		//swipe advance
		postImageSliderHammer.on("swipeleft swiperight", function(ev) { 
			if( vw*100 <= 768 ) {
				var dir
				ev.direction == 4 ? dir = -1 : dir = 1; //2 means left 4 means right
				slider.click.advance(dir);
			}
		});
		
		//tap to enable expanded view
		postImageSliderHammer.on("tap", function() {
			if( vw*100 <= 768) {
				var v = hash.get();
				var c = hash.count;
				if( v == "expanded" && c > 0) {
					hash.goback();
				} else if (v == "expanded" && c == 0) {
					hash.clear();
					slider.mode.detect();
				} else {
					hash.set("expanded");
				}
			}
		});
		
		//hash listener
		window.addEventListener("hashchange", function () {
			slider.mode.detect();
		});

	});

	
	//resize events and vars
	$( window ).resize(function() {
		
		//adjust screen size parameters
		wh = window.innerHeight/100;
		vw = window.innerWidth/100;
		
		//check if slider is in the right mode
		slider.mode.detect();
		
	});
	
	
	//scroll events
	$( window ).on( 'scroll', function() {
		navLinks();
	});
	
	//navigation links
	function navLinks() {
		var scrTop = $(window).scrollTop();
		var scrHeight = window.innerHeight;
		
		if (scrTop > scrHeight) {
			$('.post-navigation').addClass('post-navigation-active');
		} else {
			$('.post-navigation').removeClass('post-navigation-active');
		}
	}
	

	
	//keypress events
	$( window ).on( "keydown", function(event) {
		switch( event.keyCode ) {
			case 37: 
				slider.click.advance(-1);
				break;
			case 39:
				slider.click.advance();
				break;
		}
	});

}) (jQuery);