<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<!--Studiode2 theme by utkusarioglu-->
<!--Visit utkusarioglu.com for details and contact info-->
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="theme-color" content="#cccccc" />
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/manifest.json">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#636363">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="head-test"></div>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'studiode2' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
	
	<?php if ( is_front_page() ) : ?>
		
		<div class="site-title-front-page DisplayNone"><div class="fp-desc"><?php bloginfo( 'description' ); ?></div><div class="fp-name"><?php bloginfo( 'name' ); ?></div></div>
		
		<?php if ( has_nav_menu( 'top' ) ) : ?>
			<div class="navigation-front-page DisplayNone">
				<div class="wrap">
					<?php get_template_part( 'template-parts/navigation/navigation', 'top' ); ?>
				</div><!-- .wrap -->
			</div><!-- .navigation-top -->
		<?php endif;
		
		if ( has_nav_menu( 'social' ) ) : ?>
				<nav class="front-page-social-navigation DisplayNone" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'studiode2' ); ?>">
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
			
			<div class="fp-shading-top"></div>
			<div class="fp-shading-bottom"></div>
		
	<?php else : ?>
		
		<div class="name-and-page">
			<a href="<?php echo get_bloginfo('siteurl') ?>">
				<div class="site-name">
					<div class="site-desc site-name-comp"><?php echo get_bloginfo('description') ?></div><div class="site-de site-name-comp"><?php echo get_bloginfo('name') ?></div>
				</div>
			</a>
		<?php //get_template_part( 'template-parts/header/header', 'image' ); 		
		
		echo '<div class="current-p"><div class="slash">/</div><div class="p-name">';
		if(is_category()) { 
			echo single_cat_title();
		}else {
			echo single_post_title();
		}
		echo '</div></div>';
		?></div>
		
		<?php if ( has_nav_menu( 'top' ) ) : ?>
			<div class="navigation-top">
				<div class="wrap">
					<?php get_template_part( 'template-parts/navigation/navigation', 'top' ); ?>
				</div><!-- .wrap -->
			</div><!-- .navigation-top -->
		<?php endif; ?>
	
	</header><!-- #masthead -->
	<?php endif; ?>
	<?php

	/*
	 * If a regular post or page, and not the front page, show the featured image.
	 * Using get_queried_object_id() here since the $post global may not be set before a call to the_post().
	 */ 
	 
	if (  is_single() && has_post_thumbnail( get_queried_object_id() ) ) { 
		
		$postImg = get_the_post_thumbnail_url( get_queried_object_id(), 'studiode2-featured-image');
		//first slider item
		?><div class="post-image-slider">
			<div class="post-image-wrap" style="touch-action: auto;">
				<div id="slider-1" class="slider-item active-slider" style="background-image:url('<?php echo $postImg ?>')"></div>
		<?php
		
		//next slider items
		if( class_exists('Dynamic_Featured_Image') ) {
			
		   global $dynamic_featured_image;
		   $round = 1;
		   $featured_images = $dynamic_featured_image->get_featured_images( get_queried_object_id() );
		   
		   foreach ($featured_images as $value) {
			   $round += 1;
			   //echo '<div id="slider-' . $round . '" class="slider-item slider-secondary" style="background-image:url(' . $value['full'] . ')"></div>';
			   echo '<div id="slider-' . $round . '" class="slider-item slider-secondary"></div>';
			   }
			echo '</div>';
			
			echo '<script type="text/javascript">',
				'var sliderList = [];';
			list($width, $height) = getimagesize($postImg);	
			echo 'sliderList.push(["' . $postImg . '", ' . $width . ', ' . $height . ']);';

			foreach ($featured_images as $value) {
				list($width, $height) = getimagesize($value['full']);
				echo 'sliderList.push(["' . $value['full'] . '", ' . $width . ', ' . $height . ']);';
		   }
			echo '</script>';
		}
		
		if ( $round > 1 ) {
			echo '<div class="slider-arrows">';
			echo '<a href="javascript:slider.click.advance(-1)"><div class="slider-left"><span class="dashicons dashicons-arrow-left-alt2"></span></div></a>';
			echo '<a href="javascript:slider.click.advance()"><div class="slider-right"><span class="dashicons dashicons-arrow-right-alt2"></span></div></a>';
			echo '</div>';
		}
		?>
	</div>	
	<?php
		
		
		
		
	} 
	
	if ( $round > 1 ) {
		
		echo '<div class="slider-bullets"><div class="slider-wrap">';
		
		echo '<a href="javascript:slider.click.jump(1)"><div class="bullet-item bullet-1 active-bullet"></div></a>';
		
		for ($s = 2; $s <= $round; $s++) {
			echo '<a href="javascript:slider.click.jump('. $s .')"><div class="bullet-item bullet-'. $s . '"></div></a>';
		}
		
		echo '</div></div>';
	}
	
	?>

	<div class="site-content-contain">
		<div id="content" class="site-content">
