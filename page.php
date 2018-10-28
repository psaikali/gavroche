<?php
/**
 * The template for displaying pages
 *
 * @package Gavroche
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since 1.0
 */
?>

<?php if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

if (have_posts()) {

while (have_posts()) :

the_post();

get_template_part('content', 'page');

endwhile;

} else {

get_template_part('content', 'none');

}

get_footer(); ?>