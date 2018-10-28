<?php
/**
 * The template for displaying the header
 *
 * @package Gavroche
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since 1.0
 */
?>
<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<!doctype html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	
	<!-- Scripts that need to be loaded first -->
	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">

	<?php do_action('gavroche_body_top'); ?>
	
	<div class="page-wrapper">

		<section id="aside">

			<?php do_action('gavroche_aside_top'); ?>

			<header class="header-section" role="banner" itemscope="itemscope" itemtype="http://schema.org/WPHeader">

				<div class="logo">

					<?php do_action('gavroche_logo_top'); ?>

					<?php if (gavroche_option('logo')) : ?>

						<a href="<?php echo home_url(); ?>" title="<?php echo esc_attr(get_bloginfo('name')); ?>" class="logo-img">
							<img src="<?php echo esc_url(gavroche_option('logo')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?> &mdash; <?php echo esc_attr(get_bloginfo('description')); ?>">
						</a>

					<?php else : ?>

						<a href="<?php echo home_url(); ?>" title="<?php echo esc_attr(get_bloginfo('name')); ?>" class="logo-text">
							<?php echo esc_attr(get_bloginfo('name')); ?>
							<small><?php echo esc_attr(get_bloginfo('description')); ?></small>
						</a>

					<?php endif; ?>

					<?php do_action('gavroche_logo_bottom'); ?>

				</div><!--END .logo-->

				<a href="#" id="toggle-menu-icon"><i class="typcn typcn-th-menu"></i> <span><?php _e('Navigation', 'gavroche'); ?></span></a>

				<nav class="main-menu" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">

					<?php do_action('gavroche_primary_nav_top'); ?>

					<?php wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_class'     => 'primary-menu',
							'container'      => false,
							'fallback_cb'    => 'gavroche_nomenu',
							'walker'         => new Gavroche_Nav_Walker()
						)
					); ?>

					<?php do_action('gavroche_primary_nav_bottom'); ?>

				</nav><!--END .main-menu-->

			</header><!--END .site-header-->

			<aside id="sidebar" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">

				<?php do_action('gavroche_sidebar_top'); ?>

				<?php dynamic_sidebar('sidebar'); ?>

				<?php do_action('gavroche_sidebar_bottom'); ?>

			</aside><!--END #sidebar-->

			<?php do_action('gavroche_aside_bottom'); ?>

		</section><!--END #aside-->

		<?php do_action('gavroche_before_content'); ?>