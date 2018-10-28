<?php
/**
 * The template for displaying the main content or excerpt
 *
 * @package Gavroche
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since 1.0
 */
?>

<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php get_template_part('content', 'partial-meta'); ?>

<div class="entry-content" itemprop="articleBody">

	<?php if (is_single()) :
			
			// Display an excerpt on comments page
			if (get_query_var('cpage') > 0) :

				echo gavroche_excerpt(50);

			else :

				the_content();

			endif;
		
		elseif (is_category() || is_tax() || is_search()) :
	
			echo gavroche_excerpt(25, $post->ID); ?>

			<p><?php gavroche_button(
				get_the_permalink(),
				apply_filters('gavroche_skill_button_txt', __('Read more', 'gavroche')),
				the_title_attribute(array('echo' => false)),
				array('small'),
				array(
					'rel' => 'bookmark',
					'itemprop' => 'url'
				)
			); ?></p>

		<?php elseif (is_tag()) :

			// No excerpt for tags archives
			echo gavroche_excerpt(0);
	
		else :
	
			echo gavroche_excerpt(40); ?>

			<p><?php gavroche_button(
				get_the_permalink(),
				apply_filters('gavroche_skill_button_txt', __('Read more', 'gavroche')),
				the_title_attribute(array('echo' => false)),
				array('small'),
				array(
					'rel' => 'bookmark',
					'itemprop' => 'url'
				)
			); ?></p>
	
			<?php endif; ?>

</div><!--END .entry-content -->

<footer class="entry-footer">

	<?php do_action('gavroche_top_footer_post'); ?>

	<?php if (apply_filters('gavroche_display_post_tags', true)) { ?>

		<?php if (has_tag() && is_single()) { ?>

			<?php echo get_the_tag_list('<ul class="entry-footer-meta" itemscope="keywords"><li>','</li><li>','</li></ul>'); ?>

		<?php } ?>

	<?php } ?>

	<?php if (gavroche_is_paginated_post()) { ?>

		<nav class="pagination">

			<?php wp_link_pages(array(
				'before'=>'<div class="post-pagination"><span class="page-links-title">'.__('Pages:', 'gavroche').'</span>',
				'after'=>'</div>'
			)); ?>

		</nav>

	<?php } ?>

	<?php do_action('gavroche_bottom_footer_post'); ?>

</footer><!--END .entry-footer-->