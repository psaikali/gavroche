<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php
$portfolio_header_client = apply_filters('gavroche_portfolio_header_client', true);
$portfolio_header_site   = apply_filters('gavroche_portfolio_header_site', true);

$client = get_post_meta(get_the_id(), 'cocoportfolio_client', true);
$website = get_post_meta(get_the_id(), 'cocoportfolio_website', true);
?>

<aside class="meta" >

	<?php

	$output = array();

	if ($portfolio_header_client && $client != '') {
		$output[] = sprintf(__('Client : %s', 'gavroche'), $client);
	}

	if ($portfolio_header_site && $website != '') {
		$output[] = '<a href="' . esc_url($website) . '" rel="external" target="_blank">' . __('Visit project website', 'gavroche') . '</a>';
	}

	echo join('<span class="sep">|</span>', $output);

	?>

</aside><!--END .entry-meta-->