<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>


<div class="wrap wrap-page">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/page/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				//if ( comments_open() || get_comments_number() ) :
				//	comments_template();
				//endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer(); ?>
	
<script type="text/javascript">
	//function for fixing mobile browser related issues
	function pageActionsOnStart() {

		var ih = window.innerHeight;
		
		try {
			document.getElementById("harita").style.height = String( ih - 95 ) + "px";
			document.getElementById("bp-map-0").style.height = String( ih - 95 ) + "px";
		} catch(e) {}
	
	}
	
	function pageActionsOnResize() {
		//place actions here
		var ih = window.innerHeight;
		
	}
	
	// run on start
	pageActionsOnStart();
	// run on resize
	window.onresize = function(event) {
		pageActionsOnResize();
	}
</script>
<?php
