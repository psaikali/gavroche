<?php
/**
 * The template used for displaying page content
 *
 * @package Gavroche
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since 1.0
 */
?>

<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<article id="page-<?php the_ID(); ?>" <?php post_class('page'); ?> itemscope="itemscope" itemtype="http://schema.org/CreativeWork">
	
	<?php do_action('gavroche_before_the_content'); ?>

	<div class="entry-content" itemprop="articleBody">

		<?php the_content(); ?>

	</div>

	<footer class="entry-footer">

		<?php do_action('gavroche_top_footer_post'); ?>

		<?php wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', '_s' ),
				'after'  => '</div>',
			)
		); ?>

		<?php do_action('gavroche_bottom_footer_post'); ?>

	</footer><!--END .entry-footer-->
		
	<?php do_action('gavroche_after_the_content'); ?>

</article><!--END .page -->