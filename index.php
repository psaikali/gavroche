<?php
/**
 * The main template file
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

		get_template_part('content', get_post_format());

	endwhile; ?>

	<nav class="pagination"><?php gavroche_posts_nav(true, '<span class="sep">|</span>', __('Pages : ', 'gavroche')); ?></nav>

	<?php if (comments_open()) comments_template();

} else {

	get_template_part('content', 'none');

}

get_footer(); ?>