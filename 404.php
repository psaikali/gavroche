<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Gavroche
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since 1.0
 */
?>

<?php if ( ! defined( 'ABSPATH' ) ) exit;

get_header(); ?>

<p>
	<?php printf(__("The page you requested does not seem to exist. You can go back to <a href=\"%s\">the home page</a> or browse the sitemap below.", 'gavroche'), home_url()); ?>
</p>

<?php gavroche_no_content_dummy_text(); ?>

<?php get_footer(); ?>