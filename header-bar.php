<?php
/**
 * The template for displaying the header bar (between the header and the main content)
 *
 * @package Gavroche
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since 1.0
 */
?>

<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php do_action('gavroche_before_header_bar'); ?>

<section id="page-title" class="header-bar">
	
	<?php do_action('gavroche_top_header_bar'); ?>

	<?php if (is_single()) { ?>

		<h2 class="header-bar-title visuallyhidden"><?php echo apply_filters('gavroche_main_title', get_the_title(get_option('page_for_posts', true))); ?></h2>

	<?php } else if (is_404()) { ?>

		<h1 class="header-bar-title" itemprop="headline"><?php echo apply_filters('gavroche_main_title', __('Page not found', 'gavroche')); ?></h1>

	<?php } else if (is_page()) { ?>

		<h1 class="header-bar-title" itemprop="headline"><?php echo apply_filters('gavroche_main_title', get_the_title()); ?></h1>

	<?php } else if (is_category()) { ?>

		<h1 class="header-bar-title" itemprop="headline">
			<?php echo apply_filters('gavroche_main_title', single_cat_title(__('Posts from ', 'gavroche'), false)); ?>
		</h1>

	<?php } else if (is_tag()) { ?>

		<h1 class="header-bar-title" itemprop="headline">
			<?php echo apply_filters('gavroche_main_title', single_tag_title(__('Posts tagged by ', 'gavroche'), false)); ?>
		</h1>

	<?php } else if (is_tax()) { ?>

		<h1 class="header-bar-title" itemprop="headline">
			<?php echo apply_filters('gavroche_main_title', single_term_title('', false)); ?>
		</h1>

	<?php } else if (is_search()) { ?>

		<h1 class="header-bar-title" itemprop="headline">
			<?php echo apply_filters('gavroche_main_title', sprintf( __( 'Search results for : %s', 'gavroche' ), get_search_query() )); ?>
		</h1>

	<?php } else if (is_author()) { ?>

		<?php $author = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); ?>

		<h1 class="header-bar-title" itemprop="headline">
			<?php echo apply_filters('gavroche_main_title', sprintf( __( 'About %s', 'gavroche' ), $author->display_name )); ?>
		</h1>

	<?php } else if (is_post_type_archive('portfolio')) { ?>

		<h1 class="header-bar-title" itemprop="headline">
			<?php echo apply_filters('gavroche_main_title', apply_filters('gavroche_portfolio_title', __('Portfolio', 'gavroche'))); ?>
		</h1>

	<?php } else if (is_archive()) { ?>
		<h1 class="header-bar-title" itemprop="headline">
			<?php if (is_day()) {
				echo apply_filters('gavroche_main_title', sprintf(__('Archives from %s', 'gavroche'), get_the_time(get_option('date_format'))));
			}
			else if (is_month()) {
				echo apply_filters('gavroche_main_title', sprintf(__('Archives for %s', 'gavroche'), get_the_time('F Y')));
			}
			else if (is_year()) {
				echo apply_filters('gavroche_main_title', sprintf(__('Archives for %s', 'gavroche'), get_the_time('Y')));
			}
			else {
				echo apply_filters('gavroche_main_title', __('Archives', 'gavroche'));
			} ?>
		</h1>

	<?php } else { ?>

		<h1 class="header-bar-title" itemprop="headline"><?php echo apply_filters('gavroche_main_title', get_the_title(get_option('page_for_posts', true))); ?></h1>

	<?php } ?>

	<?php the_archive_description('<div class="description">', '</div>'); ?>

	<?php do_action('gavroche_bottom_header_bar'); ?>

</section><!--END .header-bar-->

<?php do_action('gavroche_after_header_bar'); ?>