<?php
/**
 * The template for displaying the search form
 *
 * @package Gavroche
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since 1.0
 */
?>

<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<form role="search" method="get" class="search-form widget_search" action="<?php echo home_url( '/' ); ?>">
	<label>
		<span class="visuallyhidden"><?php _e('Search for:', 'gavroche') ?></span>
	</label>

	<div>
		<input type="search" class="search-field" placeholder="<?php esc_attr_e('Search ...', 'gavroche') ?>" value="" name="s" title="<?php esc_attr_e('Search for:', 'gavroche') ?>" />
		<button class="submit-btn typcn typcn-arrow-right" type="submit"></button>
	</div>
</form>