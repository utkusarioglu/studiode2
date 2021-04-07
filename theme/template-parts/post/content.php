<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	if ( is_sticky() && is_home() ) :
		echo studiode2_get_svg( array( 'icon' => 'thumb-tack' ) );
	endif;
	?>
	
	<?php if ( ! is_single() ) : ?>
	
		
		
			<div class="proj-item">
			
			<a href=" <?php echo esc_url( get_permalink() ) ?>">
			
				<?php if ( '' !== get_the_post_thumbnail() && ! is_single() ) : ?>
					<div class="post-thumbnail" style="background-image:url('<?php echo the_post_thumbnail_url( 'medium' ); ?>')"></div><!-- .post-thumbnail -->
				<?php endif; ?>
				
				<div class="proj-hover">
					<header class="entry-wrap"> <?php 
							echo '<h2 class="entry-title">' . get_the_title() . '</h2>';
							echo '<div class="excerpt">' . get_the_excerpt() . '</div>'; ?>
						</div>
					</header><!-- .entry-header -->
				</div>
				</a>
			
		
	
	<?php else : ?>

		<header class="entry-header">
			<?php
			
			//if ( is_single() ) {
			//	the_title( '<h1 class="entry-title">', '</h1>' );
			//} elseif ( is_front_page() && is_home() ) {
			//	the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
			//} else {
			//	the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			//}

			
			//if ( 'post' === get_post_type() ) {
			//	echo '<div class="entry-meta">';
			//		if ( is_single() ) {
			//			studiode2_posted_on();
			//		} else {
						//echo studiode2_time_link();
			//			studiode2_edit_link();
			//		};
			//	echo '</div><!-- .entry-meta -->';
			//};
			?>

		</header><!-- .entry-header -->
		
		<div class="entry-content">
		<?php
		/* translators: %s: Name of current post */
 		the_content( sprintf(
			__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'studiode2' ),
			get_the_title()
		) );

		wp_link_pages( array(
			'before'      => '<div class="page-links">' . __( 'Pages:', 'studiode2' ),
			'after'       => '</div>',
			'link_before' => '<span class="page-number">',
			'link_after'  => '</span>',
		) ); 
		?>
	</div><!-- .entry-content -->
		<div class="bottom-pillow"></div>

	<?php endif ?>
	
	


	<?php
	//if ( is_single() ) {
	//	studiode2_entry_footer();
	//}
	?>

</article><!-- #post-## -->
