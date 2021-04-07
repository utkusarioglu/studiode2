<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>

		</div><!-- #content -->

	<?php if ( ! is_front_page() ) : ?>
	
		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="wrap-footer">
			
				<div class="site-name-and-date">
					<p class="footer-sitename"><?php echo date("Y") ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'description' ); ?><b><?php bloginfo( 'name' ); ?></b></a></p>
				</div>
				
				
				<?php
				//get_template_part( 'template-parts/footer/footer', 'widgets' );
				
				
				
				

				if ( has_nav_menu( 'social' ) ) : ?>
					<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'studiode2' ); ?>">
						<?php
							wp_nav_menu( array(
								'theme_location' => 'social',
								'menu_class'     => 'social-links-menu',
								'depth'          => 1,
								'link_before'    => '<span class="screen-reader-text">',
								'link_after'     => '</span>' . studiode2_get_svg( array( 'icon' => 'chain' ) ),
							) );
						?>
					</nav><!-- .social-navigation -->
				<?php endif;

				//get_template_part( 'template-parts/footer/site', 'info' );
				?>
			</div><!-- .wrap -->
		</footer><!-- #colophon -->
		
	<?php endif; ?>
	
	</div><!-- .site-content-contain -->
</div><!-- #page -->
<?php wp_footer(); ?>

</body>
</html>
