<?php
/**
 * Displays top navigation
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>
<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'studiode2' ); ?>">
	<button class="menu-toggle" aria-controls="top-menu" aria-expanded="false">
		<?php
		echo studiode2_get_svg( array( 'icon' => 'bars' ) );
		echo studiode2_get_svg( array( 'icon' => 'close' ) );
		?><div class="menu-text"><?php _e( 'Menu', 'studiode2' ); ?></div><?php
		?>
	</button>

	<?php wp_nav_menu( array(
		'theme_location' => 'top',
		'menu_id'        => 'top-menu',
	) ); ?>


</nav><!-- #site-navigation -->
