<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap wrap-single">

	<?php
	/* Start the Loop */
	while ( have_posts() ) : the_post();
	the_title( '<h1 class="entry-title">', '</h1>' );
	echo '<h3 class="page-excerpt">' . get_the_excerpt() . '</h3>'
	
		/* kunye fields - as sidebar*/
		
		?>
				

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main"><?php
			


				get_template_part( 'template-parts/post/content', get_post_format() );

				// If comments are open or we have at least one comment, load up the comment template.
				//if ( comments_open() || get_comments_number() ) :
				//	comments_template();
				//endif;


				

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
	
	<div class="sidebar-kunye" id="secondary"><?php
		$kunyeKeys = get_post_custom_keys($post->ID);
		
		foreach ( $kunyeKeys as $key => $value ) {
			
			$fieldName = $value;
			$fieldData = get_post_meta($post->ID, $fieldName, true);
			
			//string alterations
			$fieldData = str_replace(",","<br>",$fieldData);
			$fieldData = str_replace("/",",",$fieldData);
			$fieldData = str_replace(",", ", ",$fieldData);
			$fieldData = str_replace("  ", " ",$fieldData);
			$fieldData = str_replace(" m2","m²",$fieldData);
			$fieldData = str_replace("m2","m²",$fieldData);
			
			//echo gettype($fieldData);
			if ( $fieldData != '' and substr($value,0,1) != "_" and gettype($fieldData) == "string")  {
				?><table><tr><td class="kunye-title"><b><?php echo $fieldName ?>:</></td><td class="kunye-data"><?php echo $fieldData ?></td></tr></table><?php
			}
		}
		if ( is_single() ) {
			echo '<table><tr><td class="kunye-title"><b>Kategoriler:</></td><td class="kunye-data">'; 
			echo studiode2_entry_footer() . '</td></tr></table>';
		}
	?>
		</div>

	<?php //get_sidebar(); 
		the_post_navigation( array(
		'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'studiode2' ) . '</span><span class="nav-title"><span class="nav-title-icon-wrapper">' . studiode2_get_svg( array( 'icon' => 'arrow-left' ) ) . '</span><div class="page-nam">%title</div></span>',
		'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'studiode2' ) . '</span><span class="nav-title"><span class="nav-title-icon-wrapper">' . studiode2_get_svg( array( 'icon' => 'arrow-right' ) ) . '</span><div class="page-nam">%title</div></span>',
	) );
	?>
</div><!-- .wrap -->

<?php 
singlePageScripts();
get_footer();
