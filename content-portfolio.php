<?php
/**
 * The default template for portfolio items
 *
 * @package Gavroche
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since 1.0
 */
?>


<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('project'); ?> itemscope="itemscope" itemtype="http://schema.org/Article">

	<?php if (is_single()) : ?>

		<h1 class="entry-title" itemprop="headline">

			<?php echo apply_filters('gavroche_title', get_the_title()); ?>

		</h1><!--END .entry-title-->

	<?php else : ?>

		<h2 class="entry-title" itemprop="headline">

			<a class="entry-permalink" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark" itemprop="url">
				<?php the_title(); ?>
			</a>

		</h2><!--END .entry-title-->

	<?php endif; ?>

	<?php do_action('gavroche_before_the_content'); ?>

	<?php get_template_part('content', 'partial-meta-portfolio'); ?>

	<div class="entry-content" itemprop="articleBody">

		<?php the_content(); ?>

	</div><!--END .entry-content -->

	<footer class="entry-footer">

		<?php do_action('gavroche_top_footer_post'); ?>

		<?php

		$testimonial_content = get_post_meta(get_the_id(), 'cocoportfolio_testimonial_content', true);
		$testimonial_author = get_post_meta(get_the_id(), 'cocoportfolio_testimonial_author', true);

		if ($testimonial_content != '') { ?>

			<blockquote class="portfolio-testimonial" itemscope itemtype="http://schema.org/Review">
				<?php echo wpautop(do_shortcode(esc_textarea($testimonial_content))); ?>

				<?php if ($testimonial_author != '') { ?>
					<footer itemprop="author" itemscope itemtype="http://schema.org/Person"><cite itemprop="name"><?php echo esc_textarea($testimonial_author); ?></cite></footer>
				<?php } ?>

				<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" style="display:none;"><meta itemprop="worstRating" content="0"><span itemprop="ratingValue">4.5</span>/<span itemprop="bestRating">5</span></div>
			</blockquote>

		<?php }

		?>

		<?php do_action('gavroche_bottom_footer_post'); ?>

	</footer><!--END .entry-footer-->

	<?php do_action('gavroche_after_the_content'); ?>

</article><!--END .post -->