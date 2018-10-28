<?php
/**
 * Intro post formats metaboxes registering
 *
 * @package Intro
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Register post formats metaboxes
 *
 * @since 1.0
 * @return void
 */
if(!function_exists('gavroche_add_metaboxes_for_posts')){
	function gavroche_add_metaboxes_for_posts(){
		add_meta_box(
			'gavroche_link',
			__('Link', 'gavroche'),
			'gavroche_link_callback',
			'post',
			'normal',
			'high'
		);

		add_meta_box(
			'gavroche_quote',
			__('Quote', 'gavroche'),
			'gavroche_quote_callback',
			'post',
			'normal',
			'high'
		);

		add_meta_box(
			'gavroche_video',
			__('Video', 'gavroche'),
			'gavroche_video_callback',
			'post',
			'normal',
			'high'
		);
	}
}
add_action('add_meta_boxes_post', 'gavroche_add_metaboxes_for_posts');


/**
 * Link format callback functtion using the Cocorico Framework
 *
 * @link 		https://github.com/y-lohse/Cocorico
 * @since 1.0
 * @return void
 */
if(!function_exists('gavroche_link_callback')){
	function gavroche_link_callback( $post ) {

		$form = new Cocorico(GAVROCHE_COCORICO_PREFIX, false);
		$form->startForm();

		$form->setting(
			array(
				'type' => 'url',
				'name' => '_link_meta',
				'label' => __('Link to feature', 'gavroche'),
				'description' => __('Add a link to feature for this post. You\'re free to talk about it in the post content.', 'gavroche'),
				'options' => array(
					'class' => 'widefat',
				)
			)
		);

		$form->endForm();
		$form->render();
	}
}

/**
 * Quote format callback functtion using the Cocorico Framework
 *
 * @link 		https://github.com/y-lohse/Cocorico
 * @since 1.0
 * @return void
 */
if(!function_exists('gavroche_quote_callback')){
	function gavroche_quote_callback( $post ) {

		$form = new Cocorico(GAVROCHE_COCORICO_PREFIX, false);
		$form->startForm();

		$form->setting(
			array(
				'type'=>'textarea',
				'name'=>'_quote_meta',
				'label'=>__('Quote to feature', 'gavroche'),
				'description' => __('Add some wise words and talk about it in the post content.', 'gavroche'),
				'options' => array(
					'class' => 'widefat',
				)
			)
		);

		$form->setting(
			array(
				'type'=>'text',
				'name'=>'_quote_author_meta',
				'label'=>__('Quote author (optional)', 'gavroche'),
				'description' => __('Be nice and don\'t forget to credit the quote author.', 'gavroche'),
			)
		);

		$form->endForm();
		$form->render();

	}
}

/**
 * Video format callback functtion using the Cocorico Framework
 *
 * @link 		https://github.com/y-lohse/Cocorico
 * @since 1.0
 * @return void
 */
if(!function_exists('gavroche_video_callback')){
	function gavroche_video_callback( $post ) {

		$form = new Cocorico(GAVROCHE_COCORICO_PREFIX, false);
		$form->startForm();

		$form->setting(
			array(
				'type'=>'url',
				'name'=>'_video_meta',
				'label'=>__('Video to feature', 'gavroche'),
				'description' => __('Add a video link from Youtube, Dailymotion or Vimeo.', 'gavroche'),
				'options' => array(
					'class' => 'widefat',
				)
			)
		);

		$form->endForm();
		$form->render();
	}
}

/**
 * Show the right metabox for each post format
 *
 * @since 1.0
 * @return void
 */
if(!function_exists('gavroche_display_metaboxes_for_posts')){
	function gavroche_display_metaboxes_for_posts() {

		if ( get_post_type() == "post" ){ ?>

			<script>
				jQuery(document).ready(function($) {

					// Set variables
					var link_radio = $('#post-format-link'),
						quote_radio = $('#post-format-quote'),
						video_radio = $('#post-format-video'),
						link_metabox = $('#gavroche_link'),
						quote_metabox = $('#gavroche_quote'),
						video_metabox = $('#gavroche_video'),
						all_formats = $('#post-formats-select input');

					hideAllMetaBoxes();

					all_formats.change( function() {
						hideAllMetaBoxes();

						if( $(this).val() == 'link' ) {
							link_metabox.show();
						}
						else if( $(this).val() == 'quote' ) {
							quote_metabox.show();
						}
						else if( $(this).val() == 'video' ) {
							video_metabox.show();
						}

					});

					if(link_radio.is(':checked'))
						link_metabox.show();

					if(quote_radio.is(':checked'))
						quote_metabox.show();

					if(video_radio.is(':checked'))
						video_metabox.show();


					function hideAllMetaBoxes(){
						link_metabox.hide();
						quote_metabox.hide();
						video_metabox.hide();
					}
				});
			</script>

		<?php
		}
	}
}
// Add inline js in admin
add_action( 'admin_print_scripts', 'gavroche_display_metaboxes_for_posts', 1000);