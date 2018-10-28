<?php
/**
 * The template for displaying the footer
 *
 * @package Gavroche
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since 1.0
 */
?>

<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

		<?php do_action('gavroche_after_content'); ?>

		<footer id="footer" class="site-footer content-block" role="contentinfo" itemscope="itemscope" itemtype="http://schema.org/WPFooter">

			<?php if (is_active_sidebar('footer_left') || is_active_sidebar('footer_right')) { ?>

			<section class="footer-sidebar row no-gutters">

				<?php $footer_sidebar_classes = array('whole', 'whole');

				if (is_active_sidebar('footer_left')) {
					if (!is_active_sidebar('footer_right')) $footer_sidebar_classes = array('whole', 'whole');
					else $footer_sidebar_classes = array('third', 'two-thirds');
				} ?>

				<?php if (is_active_sidebar('footer_left')) { ?>
				<div class="widgets-left unit <?php echo $footer_sidebar_classes[0]; ?>">
					<?php dynamic_sidebar('footer_left'); ?>
				</div>
				<?php } ?>

				<?php if (is_active_sidebar('footer_right')) { ?>
				<div class="widgets-right unit <?php echo $footer_sidebar_classes[1]; ?>">
					<?php dynamic_sidebar('footer_right'); ?>
				</div>
				<?php } ?>

			</section><!--END .footer-sidebar-->

			<?php } ?>

			<?php do_action('gavroche_between_footers'); ?>

			<section class="footer-credits row no-gutters">

				<div class="copyright unit half">
					<?php if (gavroche_option('copyright')):
						echo str_replace('%YEAR%', date('Y'), strip_tags(gavroche_option('copyright'), '<strong><a><em><img>'));
					else:
						printf(__('<strong>&copy; %1$s %2$s</strong> - Gavroche WordPress theme by <a href="https://www.themesdefrance.fr/" rel="nofollow" target="_blank">Thèmes de France</a>', 'gavroche'), date('Y'), get_option('blogname'));
					endif; ?>
				</div>

				<nav class="secondary-nav unit half">
					<?php wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'menu_class'     => 'secondary-menu',
							'container'      => false,
							'depth'          => 1,
							'fallback_cb'    => '',
							'walker'         => new Gavroche_Nav_Walker()
						)
					); ?>
				</nav>

			</section><!--END .footer-credits-->

		</footer><!--END #footer-->

	</div><!-- END .page-wrapper -->

<?php do_action('gavroche_body_bottom'); ?>

<?php wp_footer(); ?>

</body>
</html>