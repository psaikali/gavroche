<?php
/**
 * The template for displaying a sitemap
 *
 * @package Gavroche
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since 1.0
 */
?>

<?php 
/*
Template Name: Sitemap
*/
__('Sitemap', 'gavroche'); ?>

<?php if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

if (have_posts()) {

	while (have_posts()) :

		the_post(); ?>

		<article id="page-<?php the_ID(); ?>" <?php post_class('page'); ?> itemscope="itemscope" itemtype="http://schema.org/CreativeWork">

			<?php do_action('gavroche_before_the_content'); ?>

			<div class="entry-content" itemprop="articleBody">

				<?php the_content(); ?>

			</div>

			<hr>

			<div class="row no-gutters">
				<div class="unit third">
					<h4><?php _e('Site pages', 'gavroche'); ?></h4>
					<ul>
						<?php wp_list_pages( array(
							'title_li' => '',
						) ); ?>
					</ul>
				</div>

				<div class="unit third">
					<h4><?php _e('All blog posts', 'gavroche'); ?></h4>
					<ul>
						<?php wp_get_archives( array(
							'type' => 'alpha',
						) ); ?>
					</ul>
				</div>

				<div class="unit third">
					<h4><?php _e('Blog categories', 'gavroche'); ?></h4>
					<ul>
						<?php
						wp_list_categories( array(
							'title_li' => ''
						) ); ?>
					</ul>
				</div>
			</div>

			<?php do_action('gavroche_after_the_content'); ?>

		</article><!--END .page -->

	<?php endwhile;

} else {

	get_template_part('content', 'none');

}

get_footer(); ?>