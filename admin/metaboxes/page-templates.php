<?php
/**
 * Intro page templates metaboxes registering
 *
 * @package Intro
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Register layout metabox
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_layout_metabox')){
	function gavroche_layout_metabox(){
		$screens = array('page', 'post', 'portfolio');

		foreach ($screens as $screen) {
			add_meta_box(
				'gavroche_layout',
				__('Layout', 'gavroche'),
				'gavroche_layout_callback',
				$screen,
				'side',
				'high'
			);
		}
	}
}
add_action('admin_init', 'gavroche_layout_metabox');


/**
 * Extra right content callback function using the Cocorico Framework
 *
 * @link 		https://github.com/y-lohse/Cocorico
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_layout_callback')){
	function gavroche_layout_callback( $post ) {

		$form = new Cocorico(GAVROCHE_COCORICO_PREFIX, false);
		$form->startForm();

		switch ($post->post_type) {
			case 'portfolio' :
				$form->setting(
					array(
						'type' => 'select',
						'name' => 'portfolio_thumb_type',
						'selects' => array(
							'thumbnail' => __('Large thumbnail', 'gavroche'),
							'icon' => __('Small icon', 'gavroche'),
						),
						'label' => __('Project thumbnail type', 'gavroche'),
						'description' => __("Use the <a href='#postimagediv'>Featured image</a> to upload the large thumbnail or small icon.", 'gavroche')
					)
				);
				break;

			case 'page';
				$form->setting(
					array(
						'type' => 'text',
						'name' => 'alt_title',
						'label' => __('Alternative title', 'gavroche')
					)
				);
				break;
		}

		$form->setting(
			array(
				'type' => 'checkbox',
				'name' => 'double_content',
				'options' => array(
					'before' => '<div id="double_content-checkbox">',
					'after' => '</div>'
				),
				'checkboxes' => array(
					1 => __('Enable', 'gavroche')
				),
				'label' => __('Double content layout', 'gavroche'),
				'description' => __("If enabled, the main content section width will be reduced and a complementary content section will be displayed.", 'gavroche')
			)
		);

		$form->setting(
			array(
				'type' => 'upload',
				'name' => 'body_background',
				'label' => __('Body background', 'gavroche'),
				'description' => __("Upload an image to override the default background.", 'gavroche')
			)
		);

		$form->setting(
			array(
				'type' => 'upload',
				'name' => 'page_header_image',
				'label' => __('Page header image', 'gavroche'),
				'description' => __("This (optional) image will be displayed before the title and content.", 'gavroche')
			)
		);

		$form->endForm();
		$form->render();
	}
}

/**
 * Register complementary content metabox
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_complementary_content_metabox')){
	function gavroche_complementary_content_metabox(){
		$screens = array('page', 'post', 'portfolio');

		foreach ($screens as $screen) {
			add_meta_box(
				'gavroche_complementary_content',
				__('Complementary content', 'gavroche'),
				'gavroche_complementary_content_callback',
				$screen,
				'normal',
				'high'
			);
		}
	}
}
add_action('admin_init', 'gavroche_complementary_content_metabox');


/**
 * Extra right content callback function using the Cocorico Framework
 *
 * @link 		https://github.com/y-lohse/Cocorico
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_complementary_content_callback')){
	function gavroche_complementary_content_callback( $post ) {
	
		$form = new Cocorico(GAVROCHE_COCORICO_PREFIX, false);
		$form->startForm();
		
		$form->setting(
			array(
				'type' => 'editor',
				'name' => 'complementary_content',
				'label' => __('Content', 'gavroche'),
				'description' => __('This complementary content will be used on the right part of your page, next to the small content section.', 'gavroche'),
				'options' => array(
					'media_buttons' => true
				)
			)
		);
		
		$form->endForm();
		$form->render();
	}
}


/**
 * Register homepage portfolio projects metabox
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_homepage_portfolio_projects_metaboxes')){
	function gavroche_homepage_portfolio_projects_metaboxes(){
		add_meta_box(
			'gavroche_homepage_portfolio_projects',
			__('Homepage Portfolio Projects', 'gavroche'),
			'gavroche_homepage_portfolio_projects_metaboxes_callback',
			'page',
			'normal',
			'high'
		);
	}
}
add_action('admin_init', 'gavroche_homepage_portfolio_projects_metaboxes');


/**
 * Homepage skills callback function using the Cocorico Framework
 *
 * @link 		https://github.com/y-lohse/Cocorico
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_homepage_portfolio_projects_metaboxes_callback')){
	function gavroche_homepage_portfolio_projects_metaboxes_callback( $post ) {

		$form = new Cocorico(GAVROCHE_COCORICO_PREFIX, false);
		$form->startForm();

		$form->setting(
			array(
				'type' => 'text',
				'name' => 'portfolio_title',
				'label' => __('Title', 'gavroche'),
				'description' => __('This title will be displayed before the portfolio projects.', 'gavroche'),
				'options' => array(
					'class' => 'widefat',
					'default' => __('Some of my projects', 'gavroche')
				)
			)
		);

		/*$form->setting(
			array(
				'type' => 'number',
				'name' => 'portfolio_number',
				'label' => __('Number of projects', 'gavroche'),
				'description' => __('How many projects should be displayed on the homepage ?', 'gavroche'),
				'options' => array(
					'default' => 6
				)
			)
		);*/

		$projects_pages = get_posts(
			array(
				'post_type' => 'portfolio',
				'posts_per_page' => -1,
				'orderby' => 'menu_order',
				'order' => 'ASC'
			)
		);

		$projects_boxes = array();

		foreach ($projects_pages as $projects_page) {
			$projects_boxes[$projects_page->ID] = $projects_page->post_title . '<br>';
		}

		$form->setting(
			array(
				'type' => 'checkbox',
				'name' => 'portfolio_items',
				'label' => __('Featured projects', 'gavroche'),
				'description' => __('Select the projects to be featured on the homepage.', 'gavroche'),
				'checkboxes' => $projects_boxes
			)
		);

		$form->endForm();
		$form->render();
	}
}



/**
 * Register homepage skills metabox
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_homepage_skills_metaboxes')){
	function gavroche_homepage_skills_metaboxes(){
		add_meta_box(
			'gavroche_homepage_skills',
			__('Homepage Skills', 'gavroche'),
			'gavroche_homepage_skills_metaboxes_callback',
			'page',
			'normal',
			'high'
		);
	}
}
add_action('admin_init', 'gavroche_homepage_skills_metaboxes');


/**
 * Homepage skills callback function using the Cocorico Framework
 *
 * @link 		https://github.com/y-lohse/Cocorico
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_homepage_skills_metaboxes_callback')){
	function gavroche_homepage_skills_metaboxes_callback( $post ) {

		$skills_pages = get_pages(
			array(
				'sort_column' => 'menu_order',
				'sort_order' => 'ASC'
			)
		);

		$skills_boxes = array();

		foreach ($skills_pages as $skills_page) {
			$skills_boxes[$skills_page->ID] = $skills_page->post_title . '<br>';
		}

		$form = new Cocorico(GAVROCHE_COCORICO_PREFIX, false);
		$form->startForm();

		$form->setting(
			array(
				'type' => 'text',
				'name' => 'skills_title',
				'label' => __('Title (left)', 'gavroche'),
				'description' => __('This title will be displayed at the top left of the skills section.', 'gavroche'),
				'options' => array(
					'class' => 'widefat',
					'default' => __('What I can do', 'gavroche')
				)
			)
		);

		$form->setting(
			array(
				'type' => 'editor',
				'name' => 'skills_content',
				'label' => __('Text content (left)', 'gavroche'),
				'description' => __('This content will be display in the skills box, on the left.', 'gavroche'),
				'options' => array(
					'media_buttons' => true
				)
			)
		);

		$form->setting(
			array(
				'type' => 'checkbox',
				'name' => 'skills_items',
				'label' => __('Boxes (right)', 'gavroche'),
				'description' => __('Select the pages that will be displayed in the boxes, on the right.', 'gavroche'),
				'checkboxes' => $skills_boxes
			)
		);

		$form->endForm();
		$form->render();
	}
}


/**
 * Register homepage references metabox
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_homepage_references_metaboxes')){
	function gavroche_homepage_references_metaboxes(){
		add_meta_box(
			'gavroche_homepage_references',
			__('Homepage References', 'gavroche'),
			'gavroche_homepage_references_metaboxes_callback',
			'page',
			'normal',
			'high'
		);
	}
}
add_action('admin_init', 'gavroche_homepage_references_metaboxes');


/**
 * Homepage references callback function using the Cocorico Framework
 *
 * @link 		https://github.com/y-lohse/Cocorico
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_homepage_references_metaboxes_callback')){
	function gavroche_homepage_references_metaboxes_callback( $post ) {

		$form = new Cocorico(GAVROCHE_COCORICO_PREFIX, false);
		$form->startForm();

		$form->setting(
			array(
				'type' => 'text',
				'name' => 'references_title',
				'label' => __('Title (left)', 'gavroche'),
				'description' => __('This title will be displayed at the top left of the references section.', 'gavroche'),
				'options' => array(
					'class' => 'widefat',
					'default' => __('Some of my clients', 'gavroche')
				)
			)
		);

		$form->setting(
			array(
				'type' => 'editor',
				'name' => 'references_content',
				'label' => __('Text content (left)', 'gavroche'),
				'description' => __('This content will be display in the references section, just above the footer.', 'gavroche'),
				'options' => array(
					'media_buttons' => true
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
if(!function_exists('gavroche_display_metaboxes_for_pages')){
	function gavroche_display_metaboxes_for_pages() { ?>
	
	        <script>
	            jQuery(document).ready(function($) {
	            
		            // Set variables
		            var $extra_content_metabox = $('#gavroche_complementary_content'),
			            $portfolio_projects_metabox = $('#gavroche_homepage_portfolio_projects'),
			            $skills_metabox = $('#gavroche_homepage_skills'),
			            $references_metabox = $('#gavroche_homepage_references'),
		            	$double_content = $('#double_content-checkbox input[type=checkbox]'),
			            $page_template = $('select#page_template');

		            // Hide everything first
		            hideExtraContentMetaBox();
		            hideHomepageMetaboxes();

		            // Double content checkbox change
		            $double_content.change(function() {
					    
				        hideExtraContentMetaBox();

			            if ($(this).is(':checked')) {
				            $extra_content_metabox.show();
			            }

					});

		            // Page template select change
		            $page_template.change(function() {

			            hideHomepageMetaboxes();

			            if ($(this).find('option:selected').val() == 'template-homepage.php') {
				            $portfolio_projects_metabox.show();
				            $skills_metabox.show();
				            $references_metabox.show();
			            }
		            });

		            // Initial state
		            if ($double_content.is(':checked')) {
			            $extra_content_metabox.show();
		            }

		            if ($page_template.find('option:selected').val() == 'template-homepage.php') {
			            $portfolio_projects_metabox.show();
			            $skills_metabox.show();
			            $references_metabox.show();
		            }

		            // Hider functions
		            function hideExtraContentMetaBox() {
			            $extra_content_metabox.hide();
		            }

		            function hideHomepageMetaboxes() {
			            $portfolio_projects_metabox.hide();
			            $skills_metabox.hide();
			            $references_metabox.hide();
		            }
	            });
	        </script>
	        
	<?php
	}
}
// Add inline js in admin
add_action( 'admin_print_scripts', 'gavroche_display_metaboxes_for_pages', 1000);