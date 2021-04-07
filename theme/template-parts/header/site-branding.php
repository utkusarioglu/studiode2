<?php
/**
 * Displays header site branding
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>
<div class="site-branding">
	<!-- <div class="brand-wrap"> -->

		<?php the_custom_logo(); ?>

		<div class="site-branding-text">
			<?php if ( ! is_front_page() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'description' ); ?><b><?php bloginfo( 'name' ); ?></b></a></h1>
			<?php endif; ?>

			<?php
			//$description = get_bloginfo( 'description', 'display' );

			if ( $description || is_customize_preview() ) :
			?>
				<p class="site-description"><?php echo $description; ?></p>
			<?php endif; ?>
		</div><!-- .site-branding-text -->

		<?php if ( ( studiode2_is_frontpage() || ( is_home() && is_front_page() ) ) && ! has_nav_menu( 'top' ) ) : ?>
		<a href="#content" class="menu-scroll-down"><?php echo studiode2_get_svg( array( 'icon' => 'arrow-right' ) ); ?><span class="screen-reader-text"><?php _e( 'Scroll down to content', 'studiode2' ); ?></span></a>
	<?php endif; ?>

	<!-- </div><!-- .wrap --> 
</div><!-- .site-branding -->
