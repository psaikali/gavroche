<?php
/**
 * The template part for displaying the call to action sidebar before content
 *
 * @package Gavroche
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since 1.0
 */
?>

<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<aside id="call-to-action" class="content-block" role="complementary">

	<a href="#" class="opener">
		<?php echo gavroche_option('cta_txt'); ?>
	</a>

	<?php if (is_active_sidebar('cta_left') || is_active_sidebar('cta_right')) { ?>

		<section class="footer-sidebar cta-content footer-extra-row row no-gutters">

			<?php $cta_sidebar_classes = array('whole', 'whole');

			if (is_active_sidebar('cta_left')) {
				if (!is_active_sidebar('cta_right')) $cta_sidebar_classes = array('whole', 'whole');
				else $cta_sidebar_classes = array('third', 'two-thirds');
			} ?>

			<?php if (is_active_sidebar('cta_left')) { ?>
				<div class="widgets-left unit <?php echo $cta_sidebar_classes[0]; ?>">
					<?php dynamic_sidebar('cta_left'); ?>
				</div>
			<?php } ?>

			<?php if (is_active_sidebar('cta_right')) { ?>
				<div class="widgets-right unit <?php echo $cta_sidebar_classes[1]; ?>">
					<?php dynamic_sidebar('cta_right'); ?>
				</div>
			<?php } ?>

		</section><!--END .footer-sidebar-->

	<?php } ?>

</aside><!--END #footer-->