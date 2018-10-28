<?php
/**
 * The default template for displaying content
 *
 * @package Gavroche
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since 1.0
 */
?>


<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?> itemscope="itemscope" itemtype="http://schema.org/Article">

	<?php if (is_single()) : ?>

		<h1 class="entry-title" itemprop="headline">

			<?php echo apply_filters('gavroche_title', get_the_title()); ?>

		</h1><!--END .entry-title-->

	<?php else : ?>

		<?php if (has_post_thumbnail()) { ?>
			<figure class="featured-image blog">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark" itemprop="url">
					<?php the_post_thumbnail('full'); ?>
				</a>
			</figure>
		<?php } ?>

		<h2 class="entry-title" itemprop="headline">

			<a class="entry-permalink" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark" itemprop="url">
				<?php the_title(); ?>
			</a>

		</h2><!--END .entry-title-->

	<?php endif; ?>

	<?php do_action('gavroche_before_the_content'); ?>

	<?php get_template_part('content', 'body'); ?>

	<?php do_action('gavroche_after_the_content'); ?>

</article><!--END .post -->