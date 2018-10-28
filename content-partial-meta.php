<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php
$post_header_date     = apply_filters('gavroche_post_header_date', true);
$post_header_author   = apply_filters('gavroche_post_header_author', true);
$post_header_category = apply_filters('gavroche_post_header_category', true);
$post_header_comments = apply_filters('gavroche_post_header_comments', true);
?>

<aside class="meta" >

	<?php

	if ($post_header_date || $post_header_author || $post_header_category) {
		_e('Published ', 'gavroche');
	}
	if ($post_header_date) { ?>

		<?php _e('on', 'gavroche'); ?>

		<time class="date published" itemprop="datePublished" datetime="<?php the_time('c'); ?>">
			<?php the_time( get_option( 'date_format' ) ); ?>
		</time>

		<?php if (get_the_modified_time() != get_the_time()) { ?>

			<time class="date updated" itemprop="dateModified" datetime="<?php the_modified_time('c'); ?>" >
				<?php echo sprintf(__(' and updated on %s', 'gavroche'), get_the_modified_time(get_option( 'date_format' ))); ?>
			</time>

		<?php }

	}

	if ($post_header_author) { ?>

		<?php _e('by', 'gavroche'); ?>

		<span class="vcard author">
			<span class="fn" itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person">
				<a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" itemprop="url" rel="author"><?php the_author_meta('display_name'); ?></a>
			</span>
		</span><!-- END .vcard.author -->

	<?php
	}

	if ($post_header_category) {
		if (!is_category()) {
			printf(__('in', 'gavroche') . ' ' . get_the_category_list(', ') . ' ');
		}
	}

	if ($post_header_comments) {

		if (comments_open()) {
			if ($post_header_date || $post_header_author || $post_header_category) {
				echo '<span class="sep">|</span>';
			} ?>

			<a href="<?php the_permalink(); ?>#comments" itemprop="discussionUrl">

				<?php comments_number(	__('No Comment', 'gavroche') . '<meta itemprop="interactionCount" content="0 UserComments">',
					__('One Comment', 'gavroche') . '<meta itemprop="interactionCount" content="1 UserComments">',
					__('% Comments', 'gavroche') . '<meta itemprop="interactionCount" content="% UserComments">'); ?></a>
		<?php
		}
	}

	edit_post_link(__('Edit', 'gavroche'), '<span class="sep">|</span> '); ?>

</aside><!--END .entry-meta-->