<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package Gavroche
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since 1.0
 */
?>

<?php if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

if (have_posts()) {

	while (have_posts()) :

		the_post();

		get_template_part('content', 'portfolio');

	endwhile;

	//gavroche_single_post_nav();

	if (comments_open()) comments_template();

} else {

	get_template_part('content', 'none');

}

get_footer(); ?>