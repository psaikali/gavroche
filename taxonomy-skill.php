<?php
/**
 * Archives page for skill taxonomy
 *
 * @package Gavroche
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since 1.0
 */
?>

<?php if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

if (have_posts()) { ?>

	<div class="portfolio-projects grid row" data-columns>

	<?php while (have_posts()) :

		the_post();

		gavroche_display_project_box($post);

	endwhile; ?>

	</div>

	<nav class="pagination"><?php gavroche_posts_nav(false, '<span class="sep">|</span>', __('Pages : ', 'gavroche')); ?></nav>

	<?php if (comments_open()) comments_template();

} else {

	get_template_part('content', 'none');

}

get_footer(); ?>