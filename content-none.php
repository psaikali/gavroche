<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * @package Gavroche
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since 1.0
 */
?>

<?php if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

	<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'gavroche' ), admin_url( 'post-new.php' ) ); ?></p>

<?php elseif ( is_search() ) : ?>

	<p><?php _e('Sorry but no post match what you are looking for. Try some new keywords below :', 'gavroche'); ?></p>

	<?php get_search_form(); ?>

	<?php gavroche_no_content_dummy_text(); ?>

<?php else: ?>

	<p><?php printf( __('Sorry but no post match what you are looking for. You should <a href="%1$s">go back to the homepage</a> and start again.', 'gavroche'), home_url()); ?></p>

<?php endif;

get_footer(); ?>