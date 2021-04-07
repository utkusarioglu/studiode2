<?php
/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>



<?php get_footer(); ?>
<script type="text/javascript">
	//script for placing frontpage elements
	//for fixing positioning issues with mobile browsers
	function frontpageActions() {
		var ww = window.innerWidth;
		
		var logo = document.getElementsByClassName("site-title-front-page")[0];
		var nav = document.getElementsByClassName("navigation-front-page")[0];
		
		var social = document.getElementsByClassName("front-page-social-navigation")[0];
		
		var latencyFactor = 700;
		var visibleClass = "goVisible";
			
		var ih = window.innerHeight / 100;
		var navA = nav.getElementsByTagName('a');
		var marg = ( ih - 2.2 ) * 5;

		logo.style.top = ih * 12 + "px";
		nav.style.top = ih * 50 + "px";
		social.style.top = ih * 90 + "px";
		
		if(ih <= 621) {
			for( a = 0; a < navA.length; a++ ) {
				navA[a].style.margin = marg + "px auto";
			}
		}

		setTimeout(function() {
			if( !(logo.classList.contains(visibleClass)) ) {
				logo.className += " " + visibleClass;
			}
		},latencyFactor );
		
		setTimeout(function() {
			if( !(nav.classList.contains(visibleClass)) ) {
				nav.className += " " + visibleClass;
			}
		}, latencyFactor * 2 );
		
		setTimeout(function() {
			if( !(social.classList.contains(visibleClass)) ) {
				social.className += " " + visibleClass;
			}
		}, latencyFactor * 3 );
	}
	
	// run on start
	frontpageActions();
	// run on resize
	window.onresize = function(event) {
		frontpageActions();
	}
	
</script>