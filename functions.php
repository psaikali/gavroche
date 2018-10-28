<?php
/**
 * Gavroche functions and definitions
 *
 * @package Gavroche
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since 1.0
 */
	
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Define theme constants (relative to licensing)
define('GAVROCHE_STORE_URL', 'https://www.themesdefrance.fr');
define('GAVROCHE_THEME_NAME', 'Gavroche');
define('GAVROCHE_THEME_VERSION', '1.0.0');
define('GAVROCHE_LICENSE_KEY', 'gavroche_license_edd');

//Set the content width (in pixels) based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
	$content_width = 720; 
}

// Include theme updater (relative to licensing)
if(!class_exists('EDD_SL_Theme_Updater'))
	include(dirname( __FILE__ ).'/admin/EDD_SL_Theme_Updater.php');

// Define framework constant then load the Cocorico Framework
define('GAVROCHE_COCORICO_PREFIX', 'gavroche_');
if(is_admin())
	require_once 'admin/Cocorico/Cocorico.php';

// Load the widgets
require 'admin/widgets/social.php';
require 'admin/widgets/calltoaction.php';
require 'admin/widgets/video.php';

// Load other theme functions
require 'admin/functions/intro-functions.php';

//Refresh the permalink structure
add_action('after_switch_theme', 'flush_rewrite_rules');

//Remove accents in uploaded files
add_filter( 'sanitize_file_name', 'remove_accents' );

//Remove extra stuff from header
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

/**
 * Pretty print, useful in debug dev mode
 *
 * @since 1.0
 * @return void
 */
function pp($arr) {
	echo "<pre style='background:#b9e0f5;padding:1em;margin:1em 0;border-radius:4px;overflow-x:scroll;'>";
	print_r($arr);
	echo "</pre>";
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_setup')){
	function gavroche_setup(){

		// Load translation
		load_theme_textdomain('gavroche', get_template_directory() . '/languages');

		// Register menus
		register_nav_menus(
			array(
				'primary'   => __('Main menu', 'gavroche'),
				'footer' => __('Footer menu', 'gavroche'),
			)
		);

		// Register sidebars
		register_sidebar(array(
			'name'          => __('Sidebar', 'gavroche'),
			'id'            => 'sidebar',
			'description'   => __('Add widgets in the sidebar.', 'gavroche'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		));

		register_sidebar(array(
			'name'          => __('Footer left', 'gavroche'),
			'id'            => 'footer_left',
			'description'   => __('Display one (or many) widget(s) in the small left part of the footer.', 'gavroche'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		));

		register_sidebar(array(
			'name'          => __('Footer right', 'gavroche'),
			'id'            => 'footer_right',
			'description'   => __('Display one (or many) widget(s) in the large right part of the footer.', 'gavroche'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		));

		register_sidebar(array(
			'name'          => __('Call-to-action left', 'gavroche'),
			'id'            => 'cta_left',
			'description'   => __('The call-to-action bar is loaded just before main content, at the top of the page.', 'gavroche'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		));

		register_sidebar(array(
			'name'          => __('Call-to-action right', 'gavroche'),
			'id'            => 'cta_right',
			'description'   => __('The call-to-action bar is loaded just before main content, at the top of the page.', 'gavroche'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		));

		// Disable post formats
		remove_theme_support('post-formats');

		// Enable excerpt on pages
		add_post_type_support( 'page', 'excerpt' );

		// Enable thumbnails
		add_theme_support('post-thumbnails');

		// Enable custom title tag for 4.1
		add_theme_support( 'title-tag' );
		
		// Enable Feed Links
		add_theme_support( 'automatic-feed-links' );
		
		// Enable HTML5 markup
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

		// Set images sizes
		set_post_thumbnail_size('intro-post-thumbnail', 580, 9999, true);
		//add_image_size('intro-post-thumbnail-full', 1140, 605, true);

		// Add meta boxes
		//require 'admin/metaboxes/post-formats.php';
		require 'admin/metaboxes/page-templates.php';

	}
}
add_action('after_setup_theme', 'gavroche_setup');

/**
 * Add custom image sizes in the WordPress Media Library
 *
 * @since 1.0
 * @param array $sizes The current image sizes list
 * @return array
 */
/*if (!function_exists('gavroche_image_size_names_choose')){
	function gavroche_image_size_names_choose($sizes) {
		$added = array('intro-post-thumbnail'=>__('Post width', 'gavroche'));
		$added = array('intro-post-thumbnail-full'=>__('Fullpage width', 'gavroche'));
		$newsizes = array_merge($sizes, $added);
		return $newsizes;
	}
}
add_filter('image_size_names_choose', 'gavroche_image_size_names_choose');*/

/**
 * Register supported post formats
 *
 * @since 1.0
 * @return void
 */
/*if (!function_exists('gavroche_custom_format')){
	function gavroche_custom_format() {
		$cpts = array('post' => array('video', 'link', 'quote'));
		$current_post_type = $GLOBALS['typenow'];
		if ($current_post_type == 'post') add_theme_support('post-formats', $cpts[$GLOBALS['typenow']]);
	}
}
add_action( 'load-post.php', 'gavroche_custom_format' );
add_action( 'load-post-new.php', 'gavroche_custom_format' );*/


/**
 * Admin WYSIWYG editor CSS customization
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_editor_css')) {
	function gavroche_editor_css() {
		add_editor_style('editor-style.css');
	}
}
add_action( 'admin_init', 'gavroche_editor_css' );

if (!function_exists('gavroche_editor_styles')) {
	function gavroche_editor_styles() {
		//$font_url = str_replace(',', '%2C', '//fonts.googleapis.com/css?family=Martel+Sans:900|Roboto:400,300,300italic,400italic,700,700italic');
		$font_url = str_replace(',', '%2C', '//fonts.googleapis.com/css?family=IBM+Plex+Serif:600,600i|Roboto:400,300,300italic,400italic,700,700italic');
		add_editor_style($font_url);
	}
}
add_action('admin_css', 'gavroche_editor_styles');


/**
 * Enqueue styles & scripts
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_enqueue')){
	function gavroche_enqueue(){

		$theme = wp_get_theme();

		wp_register_script('gavroche', get_template_directory_uri().'/js/min/gavroche.min.js', array('jquery'), false, true);

		// custom Google fonts
		//wp_enqueue_style('gavroche-fonts', '//fonts.googleapis.com/css?family=Martel+Sans:900|Roboto:400,300,300italic,400italic,700,700italic');
		wp_enqueue_style('gavroche-fonts', '//fonts.googleapis.com/css?family=IBM+Plex+Serif:600,600i|Roboto:400,300,300italic,400italic,700,700italic');

		//main stylesheet
		wp_enqueue_style('stylesheet', get_stylesheet_directory_uri().'/style.css', array(), false);

		wp_enqueue_script('fitvids');
		wp_enqueue_script('gavroche');
		
		if ( is_singular() ){
			wp_enqueue_script( "comment-reply" );
		}
	}
}
add_action('wp_enqueue_scripts', 'gavroche_enqueue');

/**
 * Register the theme options page in the administration
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_admin_menu')){
	function gavroche_admin_menu(){
		add_theme_page(__('Gavroche Settings', 'gavroche'),__('Gavroche Settings', 'gavroche'), 'edit_theme_options', 'gavroche_options', 'gavroche_options');
	}
}
add_action('admin_menu', 'gavroche_admin_menu');


/**
 * Loads the theme options page
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_options')){
	function gavroche_options(){
		if (!current_user_can('edit_theme_options')) {
			wp_die(__('You do not have sufficient permissions to access this page.'));
		}

		include 'admin/index.php';
	}
}


/**
 * Get specific option
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_option')){
	function gavroche_option($option){
		return get_option("gavroche_$option");
	}
}


/**
 * Custom HTML in <head>
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_custom_html_head')){
	function gavroche_custom_html_head(){
		if (gavroche_option("custom_html_head")){
			echo gavroche_option("custom_html_head");
		}
	}
}
add_action('wp_head', 'gavroche_custom_html_head', 51);


/**
 * Custom HTML before </body>
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_custom_html_body')){
	function gavroche_custom_html_body(){
		if (gavroche_option("custom_html_body")){
			echo gavroche_option("custom_html_body");
		}
	}
}
add_action('wp_footer', 'gavroche_custom_html_body', 50);


/**
 * Add favicon to <head>
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_favicon')){
	function gavroche_favicon(){
		if (gavroche_option("favicon")){
			echo '<link rel="icon" type="image/x-icon" href="' . esc_url(gavroche_option('favicon')) . '">';
		}
	}
}
add_action('wp_head', 'gavroche_favicon', 10);


/**
 * Applying the theme main color
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_user_styles')){
	function gavroche_user_styles(){

		global $post;

		if (isset($post) and isset($post->ID) && get_post_meta($post->ID, 'gavroche_body_background', true) != '') {
			$body_bg = get_post_meta($post->ID, 'gavroche_body_background', true);
		} else {
			$body_bg = gavroche_option('default_background');
		} ?>

		<style type="text/css">body { background-image:url(<?php echo esc_url($body_bg); ?>); }</style>

		<?php echo gavroche_generate_custom_css();

	}
}
add_action('wp_head','gavroche_user_styles', 98);


/**
 * Generate custom CSS
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_generate_custom_css')) {
	function gavroche_generate_custom_css() {
		?>

		<style type="text/css">

			<?php echo strip_tags(stripslashes(get_option('gavroche_generated_css'))); ?>
			<?php if (gavroche_option("custom_css")) echo strip_tags(stripslashes(gavroche_option("custom_css"))); ?>

		</style>

	<?php
	}
}

/**
 * Generate new CSS when the main color option has been changed
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_generate_custom_css_when_changing_color')) {
	function gavroche_generate_custom_css_when_changing_color() {
		if (gavroche_option('color')) {
			$color = gavroche_option('color');
		} else {
			$color = '#d05050';
		}

		$clr = apply_filters('gavroche_color', $color);

		// Load color functions
		require_once 'admin/functions/color-functions.php';

		$clr_object = new Mexitek\PHPColors\Color($clr);

		$hsl = $clr_object->getHsl();

		$h = $hsl['H'];
		$s = $hsl['S'];
		$l = $hsl['L'];

		$footer_sec_clr = '#' . $clr_object->lighten(30);
		$footer_extra_row_border_color = '#' . $clr_object->darken(10);

		ob_start(); ?>

		/* style.scss */
		.button,
		button, input[type=submit], input[type=button],
		.comment-form input[type="submit"],
		.widget_calendar #next a, .widget_calendar #prev a {
		color: <?php echo $clr; ?>;
		border-color: <?php echo $clr; ?>;
		}

		.button:before,
		button:before,
		.widget_calendar #next a:before, .widget_calendar #prev a:before {
		background: <?php echo $clr; ?>;
		}

		.button:after,
		button:after,
		.widget_calendar #next a:after, .widget_calendar #prev a:after {
		color: <?php echo $clr; ?>;
		}

		.button:hover,
		button:hover, input[type=submit]:hover, input[type=button]:hover,
		.comment-form input[type="submit"]:hover,
		.widget_calendar #next a:hover, .widget_calendar #prev a:hover {
		border-color: <?php echo $clr; ?>;
		}

		article.portfolio-project div.project-info ul.project-categories li:hover,
		footer.entry-footer ul.entry-footer-meta li:hover {
		background: <?php echo $clr; ?>;
		}

		h1 i.typcn, h2 i.typcn, h3 i.typcn, h4 i.typcn, h5 i.typcn, h6 i.typcn {
		color: <?php echo $clr; ?>;
		}

		a,
		h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover,
		h1 span.dot, h2 span.dot, h3 span.dot, h4 span.dot, h5 span.dot, h6 span.dot {
		color: <?php echo $clr; ?>;
		}

		a:hover {
		border-bottom-color: <?php echo $clr; ?>;
		}

		textarea:focus, select:focus, input[type=text]:focus, input[type=password]:focus, input[type=email]:focus, input[type=url]:focus, input[type=time]:focus, input[type=date]:focus, input[type=datetime-local]:focus, input[type=tel]:focus, input[type=number]:focus, input[type=search]:focus {
		outline-color: <?php echo $clr_object->rgba(.25); ?>;
		border-color: <?php echo $clr; ?>;
		}

		hr:after {
		background: <?php echo $clr; ?>;
		}

		blockquote:before {
		color: <?php echo $clr; ?>;
		}

		figure:hover a {
		background: <?php echo $clr; ?>;
		}

		article.portfolio-project:hover figure,
		div.featured-post:hover figure {
		background: <?php echo $clr; ?>;
		}

		.callout { border-top-color: <?php echo $clr; ?>; }
		.callout:before { color: <?php echo $clr; ?>; }

		/* _aside.scss */
		#aside header.header-section a#toggle-menu-icon .typcn {
		color: <?php echo $clr; ?>;
		}

		#aside header.header-section nav.main-menu ul li:hover > a > .typcn, #aside header.header-section nav.main-menu ul li.active-parent > a > .typcn, #aside header.header-section nav.main-menu ul li.active > a > .typcn {
		color: <?php echo $clr; ?>;
		}

		#aside #sidebar .button, #aside #sidebar button, #aside #sidebar input[type=submit], #aside #sidebar input[type=button], #aside #sidebar .comment-form input[type="submit"], .comment-form #aside #sidebar input[type="submit"], #aside #sidebar .widget_calendar #next a, .widget_calendar #next #aside #sidebar a, #aside #sidebar .widget_calendar #prev a, .widget_calendar #prev #aside #sidebar a, #aside #sidebar button, #aside #sidebar input[type='submit'], #aside #sidebar input[type='button'] {
		border-color: <?php echo $clr; ?>;
		background: <?php echo $clr; ?>;
		}

		#aside #sidebar .button:hover:after, #aside #sidebar button:hover:after, #aside #sidebar input[type=submit]:hover:after, #aside #sidebar input[type=button]:hover:after, #aside #sidebar .comment-form input[type="submit"]:hover:after, .comment-form #aside #sidebar input[type="submit"]:hover:after, #aside #sidebar .widget_calendar #next a:hover:after, .widget_calendar #next #aside #sidebar a:hover:after, #aside #sidebar .widget_calendar #prev a:hover:after, .widget_calendar #prev #aside #sidebar a:hover:after, #aside #sidebar button:hover:after, #aside #sidebar input[type='submit']:hover:after, #aside #sidebar input[type='button']:hover:after {
		color: <?php echo $clr; ?>;
		}

		/* _comments.scss */
		.comment.bypostauthor .comment-author cite {
		border-color: <?php echo $clr; ?>;
		}

		/* _featherlight.scss */
		.featherlight-next:hover, .featherlight-previous:hover {
		background: <?php echo $clr; ?>;
		}

		/* _footer.scss */
		#footer, #call-to-action {
		background: <?php echo $clr; ?>;
		}

		#footer a, #call-to-action a {
		border-bottom-color: <?php echo $footer_sec_clr; ?>;
		}

		#footer h1, #footer h2, #footer h3, #footer h4, #footer h5, #footer h6,
		#footer .footer-credits,
		#footer .footer-credits nav.secondary-nav ul.secondary-menu li a,
		#call-to-action h1, #call-to-action h2, #call-to-action h3, #call-to-action h4, #call-to-action h5, #call-to-action h6 {
		color: <?php echo $footer_sec_clr; ?>;
		}

		#footer .button, #footer button, #footer input[type='submit'], #footer input[type='button'],
		#footer .button:after, #footer button:after, #footer input[type='submit']:after, #footer input[type='button']:after,
		#footer .button:hover:after, #footer button:hover:after, #footer input[type='submit']:hover:after, #footer input[type='button']:hover:after,
		#call-to-action .button, #call-to-action button, #call-to-action input[type='submit'], #call-to-action input[type='button'],
		#call-to-action .button:after, #call-to-action button:after, #call-to-action input[type='submit']:after, #call-to-action input[type='button']:after,
		#call-to-action .button:hover:after, #call-to-action button:hover:after, #call-to-action input[type='submit']:hover:after, #call-to-action input[type='button']:hover:after {
		color: <?php echo $clr; ?>;
		}

		#footer .button:before, #footer button:before, #footer input[type='submit']:before, #footer input[type='button']:before,
		#call-to-action .button:before, #call-to-action button:before, #call-to-action input[type='submit']:before, #call-to-action input[type='button']:before {
		background: <?php echo $clr; ?>;
		}

		#footer .footer-extra-row,
		#call-to-action .footer-extra-row {
		border-top-color: <?php echo $footer_extra_row_border_color; ?>;
		}

		#footer .footer-credits {
		background: <?php echo $footer_extra_row_border_color; ?>;
		}

		/* _portfolio.scss */
		article.portfolio-project div.project-info h4.project-title:hover a {
		color: <?php echo $clr; ?>;
		}

		/* _post.scss */
		.entry-content ul li:before {
		color: <?php echo $clr; ?>;
		}

		.entry-content ol > li:before {
		background: <?php echo $clr; ?>;
		}

		/* _widgets.scss */
		.widget_search div .submit-btn {
		background: <?php echo $clr; ?>;
		}

		.widget_search div .submit-btn:hover:before {
		color: <?php echo $clr; ?>;
		}

		.widget_tag_cloud .tagcloud a:hover {
		background: <?php echo $clr; ?>;
		}

		.widget_calendar caption {
		background: <?php echo $clr; ?>;
		}

		<?php $generated_css = ob_get_clean();

		update_option('gavroche_generated_css', $generated_css);
	}
}
add_action('update_option_gavroche_color', 'gavroche_generate_custom_css_when_changing_color', 99, 1);
add_action('after_switch_theme', 'gavroche_generate_custom_css_when_changing_color', 99, 1);


/**
 * Display pages and posts on 404 and no-content pages
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_no_content_dummy_text')) {
	function gavroche_no_content_dummy_text() {
		?>
		<hr>

		<div class="row no-gutters entry-content">
			<div class="unit half">
				<h4><?php _e('Site pages', 'gavroche'); ?></h4>

				<ul>
					<?php wp_list_pages(
						array(
							'title_li' => false
						)
					); ?>
				</ul>
			</div>

			<div class="unit half">
				<h4><?php _e('Blog categories and posts', 'gavroche'); ?></h4>

				<ul>
					<?php $categories = get_categories(
						array(
							'orderby' => 'name',
							'order' => 'ASC'
						)
					);

					foreach ($categories as $category) {

						$posts = get_posts(
							array(
								'showposts' => -1,
								'category' => $category->term_id,
							)
						);

						if ($posts) {
							echo '<li>';
							echo '<a class="strong" href="' . get_category_link( $category->term_id ) . '" title="' . sprintf(__( 'View all posts in %s', 'gavroche' ), $category->name ) . '">' . $category->name . '</a><ul>';

							foreach($posts as $article) { ?>

								<li>
									<a href="<?php get_the_permalink($article->ID); ?>" rel="bookmark" title="<?php echo esc_attr($article->post_title); ?>">
										<?php echo $article->post_title; ?>
									</a>
								</li>

							<?php
							}

							echo '</ul>';

							echo '</li>';
						}
					} ?>
				</ul>
			</div>

		</div>

	<?php
	}
}



/**
 * License activation stuff (from Easy Digital Downloads Software Licensing Addon)
 * This function will activate the theme licence on Themes de France
 * 
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_edd')){
	function gavroche_edd(){
		$license = trim(get_option(GAVROCHE_LICENSE_KEY));
		$status = gavroche_option('license_status');
		
		// No license is activated yet
		if (!$status){
			
			// Activate the license
			$api_params = array(
				'edd_action'=>'activate_license',
				'license'=>$license,
				'item_name'=>urlencode(GAVROCHE_THEME_NAME)
			);

			$response = wp_remote_get(add_query_arg($api_params, GAVROCHE_STORE_URL), array('timeout'=>15, 'sslverify'=>false));
			
			if (!is_wp_error($response)){
				$license_data = json_decode(wp_remote_retrieve_body($response));
				if ($license_data->license === 'valid') update_option('gavroche_license_status', true);
			}
		}

		$edd_updater = new EDD_SL_Theme_Updater(array(
				'remote_api_url'=> GAVROCHE_STORE_URL,
				'version' 	=> GAVROCHE_THEME_VERSION,
				'license' 	=> $license,
				'item_name' => GAVROCHE_THEME_NAME,
				'author'	=> __('Themes de France', 'gavroche')
			)
		);
	}
}
add_action('admin_init', 'gavroche_edd');

/**
 * Display an admin notice if the licence isn't activated
 * 
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_admin_notice')){
	function gavroche_admin_notice(){
		global $current_user;
        $user_id = $current_user->ID;
		
		if(current_user_can('edit_theme_options')){
		
			if(!gavroche_option('license_status')){
				
				if ( ! get_user_meta($user_id, 'ignore_purchasegavroche_notice') ) {
					echo '<div class="error"><p>';
					
						printf(__("To get Gavroche support and automatic updates, enter the licence key your received after your purchase. | <a href='%s'>It's ok, I don't want to update my theme</a>", 'gavroche'), '?ignore_notice=introlicense');
					
					echo '</p></div>';
				}
			}
		}
	}
}
//add_action('admin_notices', 'gavroche_admin_notice');


/**
 * Add CTA bar before content
 *
 * @since 1.0
 * @return void
 */
function gavroche_add_call_to_action_bar_before_content() {
	if (is_active_sidebar('cta_left') || is_active_sidebar('cta_right')) {
		get_template_part('sidebar-cta');
	}
}
add_action('gavroche_after_main_content', 'gavroche_add_call_to_action_bar_before_content', 10);


/**
 * Hide admin notice if the user isn't interested in the license.
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_admin_ignore')){
	function gavroche_admin_ignore() {
	
	    global $current_user;
        $user_id = $current_user->ID;
        /* If user clicks to ignore the notice, add that to their user meta */
        if ( isset($_GET['ignore_notice']) && 'introlicense' == $_GET['ignore_notice'] ) {
             add_user_meta($user_id, 'ignore_introlicense_notice', 'true', true);
	    }
	}
}
add_action('admin_init', 'gavroche_admin_ignore');

if (!function_exists('gavroche_admin_custom_css')){
	function gavroche_admin_custom_css()
	{
		echo '<style type="text/css">'; ?>

		#gavroche_layout table.form-table tr th, #gavroche_layout table.form-table tr td {
		width:100%;
		display:block;
		padding:0;
		}

		#gavroche_layout table.form-table tbody tr th {
		padding-bottom:.25em;
		}

		#gavroche_layout table.form-table p.description {
		font-size:.8em;
		}

		#gavroche_layout table.form-table .cocorico-upload, #gavroche_layout table.form-table .cocorico-upload-button, #alt_title {
		width:100%;
		}

		#gavroche_layout table.form-table tbody tr:not(:first-child) {
		margin-top:1em;
		}

		<?php echo '</style>';
	}
}
add_action('admin_enqueue_scripts', 'gavroche_admin_custom_css');


/**
 * Cleanup WP Nav Menu walker for cleaner and simpler markup
 * Credits to https://github.com/roots/soil/blob/master/modules/nav-walker.php
 *
 * @since 1.0
 * @return void
 */
function gavroche_url_compare($url, $rel) {
	$url = trailingslashit($url);
	$rel = trailingslashit($rel);
	return ((strcasecmp($url, $rel) === 0));
}

class Gavroche_Nav_Walker extends Walker_Nav_Menu {
	private $cpt; // Boolean, is current post a custom post type
	private $archive; // Stores the archive page for current URL

	public function __construct() {
		//add_filter('nav_menu_css_class', array($this, 'cssClasses'), 99, 2);

		//add_filter('nav_menu_item_id', '__return_null');

		$cpt           = get_post_type();
		$this->cpt     = in_array($cpt, get_post_types(array('_builtin' => false)));
		$this->archive = get_post_type_archive_link($cpt);
	}

	public function checkCurrent($classes) {
		return preg_match('/(current[-_])|active/', $classes);
	}

	public function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
		//$element->is_subitem = ((!empty($children_elements[$element->ID]) && (($depth + 1) < $max_depth || ($max_depth === 0))));
		$element->has_children = !empty($children_elements[$element->ID]);

		if ($element->is_subitem) {
			foreach ($children_elements[$element->ID] as $child) {
				if ($child->current_item_parent || gavroche_url_compare($this->archive, $child->url)) {
					$element->classes[] = 'active';
				}
			}
		}
		$element->is_active = strpos($this->archive, $element->url);
		if ($element->is_active) {
			$element->classes[] = 'active';
		}

		parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}

	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		//$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes = array();
		$classes[] = 'menu-item-' . $item->ID;
		if ($item->has_children) $classes[] = 'has-children';

		//$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_merge(array_filter( $classes ), $item->classes), $item, $args, $depth ) );
		$class_names = array_merge(array_filter($classes), $item->classes);

		//

		$slug = sanitize_title($item->title);

		/*if ($this->cpt) {
			$classes = str_replace('current_page_parent', '', $classes);

			if (gavroche_url_compare($this->archive, $item->url)) {
				$classes[] = 'active';
			}
		}*/

		$class_names = preg_replace('/(current(-menu-|[-_]page[-_])(parent|ancestor))/', 'active-parent', $class_names);
		$class_names = preg_replace('/(current(-menu-|[-_]page[-_])(item))/', 'active', $class_names);

		$class_names = preg_replace('/^((menu|page)[-_\w+]+)+/', '', $class_names);

		$class_names = join(' ', array_filter(array_unique($class_names)));

		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names .'>';

		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';

		if ($item->classes[0] != '') $item_output .= '<i class="typcn typcn-' . $item->classes[0] . '"></i>';

		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

		if ($item->description != '') $item_output .= '<small class="item-desc">' . $item->description . '</small>';

		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	public function cssClasses($classes, $item) {
		$slug = sanitize_title($item->title);

		/*if ($this->cpt) {
			$classes = str_replace('current_page_parent', '', $classes);
			if (gavroche_url_compare($this->archive, $item->url)) {
				$classes[] = 'active';
			}
		}*/

		$classes = preg_replace('/(current(-menu-|[-_]page[-_])(parent|ancestor))/', 'active-parent', $classes);
		$classes = preg_replace('/(current(-menu-|[-_]page[-_])(item))/', 'active', $classes);

		$classes = preg_replace('/^((menu|page)[-_\w+]+)+/', '', $classes);
		$classes[] = 'menu-' . $slug;

		$classes = array_filter(array_unique($classes));

		return $classes;
	}
}


/**
 * Clean up wp_nav_menu_args
 *
 * Remove the container
 * Remove the id="" on nav menu items
 */
function gavroche_nav_menu_args($args = '') {
	$nav_menu_args = [];
	$nav_menu_args['container'] = false;

	if (!$args['items_wrap']) {
		$nav_menu_args['items_wrap'] = '<ul class="%2$s">%3$s</ul>';
	}
	return array_merge($args, $nav_menu_args);
}
//add_filter('wp_nav_menu_args', 'gavroche_nav_menu_args');
//add_filter('nav_menu_item_id', '__return_null');


/**
 * Gavroche Cocorico plugins/extensions
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_admin_enqueue')){
	function gavroche_admin_enqueue($uri) {
		define('ETENDARD_COCO_URI', get_template_directory_uri().'/admin/Cocorico');
		wp_register_style( 'gavroche_custom_admin_css', ETENDARD_COCO_URI.'/extensions/gavroche/admin-style.css', false );
		wp_enqueue_style( 'gavroche_custom_admin_css' );
	}
}
add_action('admin_enqueue_scripts', 'gavroche_admin_enqueue');



/**
 * Hook inside the loop to inject and store custom fields in a WP Post Object property
 *
 * @since 1.0
 * @return void
 */
function gavroche_add_complementary_content_to_post($current_object) {
	if (isset($current_object->queried_object_id)) {
		global $post;
		$custom_fields = get_post_custom($post->ID);

		$post->custom_fields = $custom_fields;
	}
}
add_action('loop_start', 'gavroche_add_complementary_content_to_post', 1);
//add_action('the_post', 'gavroche_add_complementary_content_to_post', 1);


/**
 * Function to know if the current layout is a double content
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_is_double_content_layout')) {
	function gavroche_is_double_content_layout() {
		$double_content = (!is_single() && !is_page()) ? FALSE : get_post_meta(get_the_ID(), 'gavroche_double_content', true);
		return ($double_content != '' && $double_content[0] == 1) ? TRUE : FALSE;
	}
}


/**
 * Generate markup before content
 *
 * @since 1.0
 * @return void
 */
function gavroche_markup_before_content() {
	?>
	<section id="content" class="content-block" role="main" itemprop="mainContentOfPage">
	<?php do_action('gavroche_before_main_content'); ?>

	<main class="main-content <?php if (gavroche_is_double_content_layout()) echo 'small'; ?>">
	<?php do_action('gavroche_before_main_content_inside'); ?>

	<?php if (!is_front_page()) {
		get_template_part('header-bar');
	}
}
add_action('gavroche_before_content', 'gavroche_markup_before_content', 1, 10);


/**
 * Generate markup after content
 *
 * @since 1.0
 * @return void
 */
function gavroche_markup_after_content($post) {
	?>
	<?php do_action('gavroche_after_main_content_inside'); ?>
	</main><!--END .main-content-->

	<?php if (gavroche_is_double_content_layout()) { ?>
	<aside class="complementary-content">
		<?php do_action('gavroche_before_complementary_content'); ?>
		<?php echo do_shortcode(get_post_meta(get_the_ID(), 'gavroche_complementary_content', true)); ?>
		<?php do_action('gavroche_after_complementary_content'); ?>
	</aside><!--END .complementary-content-->
<?php } ?>

	<?php do_action('gavroche_after_main_content'); ?>

	</section> <!-- END #content -->
<?php
}
add_action('gavroche_after_content', 'gavroche_markup_after_content', 1, 10);


function gavroche_transform_gallery_into_grid($data) {
	//if (!did_action('gavroche_before_complementary_content')) {
		$data = str_replace('<div id', '<div data-columns id', $data);
		$data = str_replace('class=\'gallery', 'class=\'grid row gallery', $data);
	//}

	return $data;
}
add_filter( 'gallery_style', 'gavroche_transform_gallery_into_grid', 1);

/**
 * Display featured image before content
 *
 * @since 1.0
 * @return void
 */
function gavroche_display_header_featured_image() {
	if (
		(
			get_queried_object_id() && !post_password_required(get_queried_object_id())
		)
		&& (
			is_singular(
				array(
					'page',
					'post',
					'portfolio'
				)
			)
		)
	) {
		$header_image = get_post_meta(get_queried_object_id(), 'gavroche_page_header_image');

		if (isset($header_image) && is_array($header_image) && count($header_image) > 0) {
			if ($header_image[0] != '') {
				?>

				<figure class="featured-image">
					<img src="<?php echo esc_url($header_image[0]); ?>" alt="<?php echo esc_attr(get_the_title(get_queried_object_id())); ?>" />
				</figure><!--END .entry-thumbnail-->

			<?php
			}
		}
	}
}
add_action('gavroche_before_header_bar', 'gavroche_display_header_featured_image');


/**
 * Generate portfolio project block
 * TODO : include this in Cocorico-portfolio plugin
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_display_project_box')) {
	function gavroche_display_project_box($project) {
		$project_data = get_post_custom($project->ID);
		$type = $project_data['gavroche_portfolio_thumb_type'][0];

		$classes = array(
			'portfolio-project',
			"with-$type",
			//'unit third'
		);

		$thumbnail_id = (array_key_exists('_thumbnail_id', $project_data)) ? $project_data['_thumbnail_id'][0] : FALSE;
		$title = apply_filters('gavroche_title', $project->post_title);
		$title_esc = esc_attr($project->post_title);
		$excerpt = wpautop($project->post_excerpt);
		$url = get_permalink($project->ID);

		?>

		<article class="<?php echo join(' ', $classes); ?>">
			<div class="project-inner">
				<?php if ($type == 'thumbnail' && $thumbnail_id) { ?>
					<figure class="project-thumbnail">
						<a href="<?php echo $url; ?>" title="<?php echo $title_esc; ?>">
							<?php echo get_the_post_thumbnail($project->ID, 'post-thumbnail'); ?>
						</a>
					</figure>
				<?php } ?>

				<div class="project-info">
					<?php if ($type == 'icon' && $thumbnail_id) { ?>
						<figure class="project-icon">
							<a href="<?php echo $url; ?>" title="<?php echo $title_esc; ?>">
								<?php echo get_the_post_thumbnail($project->ID, 'post-thumbnail'); ?>
							</a>
						</figure>
					<?php } ?>

					<header>
						<h4 class="project-title"><a href="<?php echo $url; ?>" title="<?php echo $title_esc; ?>"><?php echo $title; ?></a></h4>
					</header>

					<div class="project-excerpt"><?php echo wpautop($excerpt); ?></div>

					<?php gavroche_display_project_categories($project->ID); ?>
				</div>
			</div>
		</article>

		<?php
	}
}


/**
 * Generate portfolio project categories labels (links)
 * TODO : include this in Cocorico-portfolio plugin
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_display_project_categories')) {
	function gavroche_display_project_categories($id)
	{
		$categories = wp_get_post_terms($id, 'skill');

		if (!empty($categories)) {
		?>

		<ul class="project-categories">

		<?php foreach ($categories as $category) {
			$category_title = ($category->description != '') ? $category->description : $category->name;
			$category_url = get_term_link($category, 'portfolio_cat');
			?>

			<li><a href="<?php echo esc_url($category_url); ?>" title="<?php echo esc_attr($category_title); ?>"><?php echo esc_attr($category->name); ?></a></li>

		<?php } ?>

		</ul>

		<?php
		}
	}
}


/**
 * Generate page block to be used in the Skills section on the homepage
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_display_page_box')) {
	function gavroche_display_page_box($page, $show_thumbnail = true, $show_excerpt = true, $show_button = true, $title_tag = 'h3') {
		$page_data = get_post_custom($page->ID);
		$type = get_post_type($page->ID);

		$thumbnail_id = (array_key_exists('_thumbnail_id', $page_data)) ? $page_data['_thumbnail_id'][0] : FALSE;

		$classes = array('page-box');
		if ($thumbnail_id && $show_thumbnail) $classes[] = 'with-image';

		$title = apply_filters('gavroche_title', $page->post_title);
		$title_esc = esc_attr($page->post_title);
		$excerpt = ($type == 'post') ? $excerpt = gavroche_excerpt(25, $page->ID) : wpautop($page->post_excerpt);
		//$excerpt = wpautop($page->post_excerpt);
		$url = get_permalink($page->ID);

		?>

		<article class="<?php echo join(' ', $classes); ?>">
			<?php if ($thumbnail_id && $show_thumbnail) { ?>
				<figure class="page-thumbnail">
					<a href="<?php echo $url; ?>" title="<?php echo $title_esc; ?>"><div><?php echo get_the_post_thumbnail($page->ID, 'post-thumbnail'); ?></div></a>
				</figure>
			<?php } ?>

			<div class="page-info">
				<<?php echo $title_tag; ?> class="page-title"><a href="<?php echo $url; ?>" title="<?php echo $title_esc; ?>"><?php echo $title; ?></a></<?php echo $title_tag; ?>>

				<?php if ($show_excerpt) echo $excerpt; ?>

				<?php if ($show_button) gavroche_button($url, apply_filters('gavroche_skill_button_txt', __('Discover more', 'gavroche')), '', array('small')); ?>
			</div>
		</article>

	<?php
	}
}


/**
 * Generate a button
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_button')) {
	function gavroche_button($url, $text, $title_attr = '', $extra_classes = array(), $attrs = array()) {
		if ($title_attr == '') $title_attr = $text;

		if (!empty($attrs)) {
			$extra_attrs = array();

			foreach ($attrs as $attr_name => $attr_value) {
				$extra_attrs[] = esc_attr($attr_name) . '="' . esc_attr($attr_value) . '"';
			}
		}

		$classes = array_unique(array_merge(array('button'), $extra_classes));

		$output = '<a class="' . join(' ', $classes) . '" href="' . esc_url($url) . '" title="' . esc_attr($title_attr) . '" ';
		if (!empty($attrs)) $output .= join(' ', $extra_attrs);

		$output .= '>';
		$output .= esc_textarea($text);
		$output .= '</a>';

		echo $output;
	}
}


/**
 * Displays alternative title for pages
 *
 * @since 1.0
 * @return void
 */
function gavroche_page_alternative_title($title) {
	if (is_page()) {
		global $post;

		if (get_post_meta($post->ID, 'gavroche_alt_title', true) != '')
			return get_post_meta($post->ID, 'gavroche_alt_title', true);
	}

	return $title;
}
add_filter('gavroche_main_title', 'gavroche_page_alternative_title', 10);


/**
 * Add span.dot to end of titles
 *
 * @since 1.0
 * @return void
 */
function gavroche_add_dot_to_titles($title) {
	if (!apply_filters('gavroche_display_dot_after_titles', true) || $title == '') return $title;
	return $title . '<span class="dot">.</span>';
}
add_filter('gavroche_title', 'gavroche_add_dot_to_titles', 20);
add_filter('gavroche_main_title', 'gavroche_add_dot_to_titles', 30);
//add_filter('the_title', 'gavroche_add_dot_to_titles');
add_filter('widget_title', 'gavroche_add_dot_to_titles');


/**
 * Shortcode to generate the span.dot markup
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_shortcode_dot')) {
	function gavroche_shortcode_dot($atts) {
		return '<span class="dot">.</span>';
	}
}
add_shortcode('gavroche_dot', 'gavroche_shortcode_dot');


/**
 * Shortcode to generate relative pages
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_shortcode_relative_pages')) {
	function gavroche_shortcode_relative_pages($atts) {
		global $post;

		extract(
			shortcode_atts(
				array(
					'page_id' => $post->ID,
					'exclude' => '',
					'include' => '',
					'title' => '',
					'title_tag' => 'h3',
					'page_title_tag' => 'h4',
					'show_thumbnail' => 0,
					'show_excerpt' => 1,
					'show_button' => 0,
					'columns' => 4,
					'limit' => '4',
				),
				$atts
			)
		);

		$exclude_array = array();
		$exclude_array[] = $post->ID;
		if ($exclude != '') $exclude_array = array_unique(array_merge($exclude_array, explode(',', $exclude)));

		$args = array(
			'post_status' => 'publish',
			'post_type' => 'page',
			'post_parent' => $page_id,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'numberposts' => (int)$limit,
		);

		if ($include == '') {
			$args['post__not_in'] = $exclude_array;
		} else {
			$include_array = explode(',', $include);
			$args['post__in'] = $include_array;
			$args['post_parent'] = 0;
			unset($args['post_parent']);
			unset($args['numberposts']);
		}

		$pages = get_posts(
			$args
		);

		if (empty($pages)) {
			$pages = get_posts(
				array(
					'post_status' => 'publish',
					'post_type' => 'page',
					'post_parent' => $post->post_parent,
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'numberposts' => (int)$limit,
					'post__not_in' => $exclude_array,
				)
			);
		}

		if (!empty($pages)) {

			ob_start();

			if ($title != '') echo "<$title_tag class='relative-section'>" . apply_filters('gavroche_title', $title) . "</$title_tag>";

			echo '<div class="relative-pages grid-size-' . $columns . ' grid row" data-columns>';

			foreach ($pages as $page) {
				gavroche_display_page_box($page, $show_thumbnail, $show_excerpt, $show_button, $page_title_tag);
			}

			echo '</div>';

			$output = ob_get_clean();
		}

		return $output;
	}
}
add_shortcode('gavroche_relative_pages', 'gavroche_shortcode_relative_pages');


/**
 * Shortcode to generate relative pages
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_shortcode_relative_posts')) {
	function gavroche_shortcode_relative_posts($atts) {
		global $post;

		extract(
			shortcode_atts(
				array(
					'post_id' => $post->ID,
					'categories' => '',
					'title' => '',
					'limit' => '4',
					'columns' => 4,
					'title_tag' => 'h3',
					'page_title_tag' => 'h4',
					'show_thumbnail' => 0,
					'show_excerpt' => 1,
					'show_button' => 0,
					'orderby' => 'rand',
				),
				$atts
			)
		);

		if ($categories == '') {
			$categories = wp_get_post_categories($post->ID);
			$cats = join(',', $categories);
		} else {
			$cats = $categories;
		}

		$pages = get_posts(
			array(
				'post_status' => 'publish',
				'post_type' => 'post',
				'orderby' => $orderby,
				'numberposts' => $limit,
				'cat' => $cats,
				'post__not_in' => array($post->ID)
			)
		);

		$output = '';

		if (!empty($pages)) {

			ob_start();

			if ($title != '') echo "<$title_tag class='relative-section'>" . apply_filters('gavroche_title', $title) . "</$title_tag>";

			echo '<div class="relative-pages relative-posts grid-size-' . $columns . ' grid row" data-columns>';

			foreach ($pages as $page) {
				gavroche_display_page_box($page, $show_thumbnail, $show_excerpt, $show_button, $page_title_tag);
			}

			echo '</div>';

			$output = ob_get_clean();
		}

		return $output;
	}
}
add_shortcode('gavroche_relative_posts', 'gavroche_shortcode_relative_posts');


/**
 * Shortcode to generate portfolio boxes (sometimes from a category)
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_shortcode_portfolio_projects')) {
	function gavroche_shortcode_portfolio_projects($atts) {
		extract(
			shortcode_atts(
				array(
					'title' => '',
					'columns' => 4,
					'title_tag' => 'h3',
					'page_title_tag' => 'h4',
					'limit' => '4',
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'categories' => '',
					'ids' => ''
				),
				$atts
			)
		);

		$args = array(
			'post_type' => 'portfolio',
			'posts_per_page' => $limit,
			'orderby' => $orderby,
			'order' => $order
		);

		if ($ids != '') {
			$args['post__in'] = explode(',', $ids);
		}

		if ($categories != '') {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'skill',
					'field'    => 'term_id',
					'terms'    => explode(',', $categories)
				)
			);
		}

		$projects = get_posts(
			$args
		);

		$output = '';

		if (!empty($projects)) {

			ob_start();
			if ($title != '') echo "<$title_tag class='relative-section'>" . apply_filters('gavroche_title', $title) . "</$title_tag>";
			echo '<div class="relative-pages projects grid-size-' . $columns . ' grid row" data-columns>';
			foreach ($projects as $project) {
				gavroche_display_project_box($project);
			}
			echo '</div>';
			$output = ob_get_clean();
		}

		return $output;
	}
}
add_shortcode('gavroche_portfolio_projects', 'gavroche_shortcode_portfolio_projects');


/**
 * Shortcode to generate a button
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_shortcode_button')) {
	function gavroche_shortcode_button($atts, $content) {
		global $post;

		extract(
			shortcode_atts(
				array(
					'link' => home_url(),
					'title' => esc_attr($content),
					'class' => '',
					'id' => '',
					'rel' => ''
				),
				$atts
			)
		);

		$output = '';
		$output .= '<a href="' . $link . '" ';
		$output .= 'class="button ' . $class . '" ';
		$output .= 'title="' . $title . '" ';
		if ($id != '')
			$output .= 'id="' . $id . '" ';
		if ($rel != '')
			$output .= 'rel="' . $rel . '" ';
		$output .= '>' . $content . '</a>';

		return $output;
	}
}
add_shortcode('gavroche_button', 'gavroche_shortcode_button');


/**
 * Shortcode to generate a section
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_shortcode_section')) {
	function gavroche_shortcode_section($atts, $content) {
		global $post;

		extract(
			shortcode_atts(
				array(
					'style' => '',
					'id' => '',
					'row' => ''
				),
				$atts
			)
		);

		$output = '';
		$output .= '<section ';
		$output .= 'class="section ' . $style . '" ';
		if ($id != '')
			$output .= 'id="' . $id . '" ';
		$output .= '>';
		if ($row != '') $output .= '<div class="row no-gutters">';
		$output .= do_shortcode($content);
		if ($row != '') $output .= '</div>';
		$output .= '</section>';

		return $output;
	}
}
add_shortcode('gavroche_section', 'gavroche_shortcode_section');


/**
 * Shortcode to a callout block
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('gavroche_shortcode_callout')) {
	function gavroche_shortcode_callout($atts, $content) {
		global $post;

		extract(
			shortcode_atts(
				array(
					'style' => ''
				),
				$atts
			)
		);

		$output = '';
		$output .= '<div class="callout ' . $style . '" ';
		$output .= '>' . $content . '</div>';

		return $output;
	}
}
add_shortcode('gavroche_callout', 'gavroche_shortcode_callout');


/**
 * Action to add Yoast breadcrumbs between top and bottom footer
 *
 * @since 1.0
 * @return void
 */
function gavroche_add_breacrumbs_between_footers() {
	if (function_exists('yoast_breadcrumb')) {
		$output = '<nav class="site-breadcrumbs footer-extra-row">';

		$output .= yoast_breadcrumb(
			__('<p>You are here :</p>', 'gavroche'),
			'',
			false
		);

		$output .= '</nav>';

		echo $output;
	}
}
add_action('gavroche_between_footers', 'gavroche_add_breacrumbs_between_footers');

/**
 * Change portfolio title
 *
 * @since 1.0
 * @return void
 */
function gavroche_portfolio_custom_title() {
	return __('My references', 'gavroche');
}
//add_filter('gavroche_portfolio_title', 'gavroche_portfolio_custom_title');

/**
 * Change portfolio title
 *
 * @since 1.0
 * @return void
 */
function gavroche_custom_title_blog_homepage() {
	return __('My latest publications', 'gavroche');
}
//add_filter('gavroche_title_blog_homepage', 'gavroche_custom_title_blog_homepage');


/**
 * Filter the portfolio rewrite slugs based on settings
 *
 * @since 1.0
 * @return void
 */
function gavroche_coco_portfolio_archive_slug_from_setting($slug) {
	$new_slug = sanitize_title(gavroche_option('archive_slug'));
	if ($new_slug != '') $slug = $new_slug;

	return $slug;
}
add_filter('coco_portfolio_archive_slug', 'gavroche_coco_portfolio_archive_slug_from_setting', 10, 1);

function gavroche_coco_portfolio_project_slug_from_setting($slug) {
	$new_slug = sanitize_title(gavroche_option('project_slug'));
	if ($new_slug != '') $slug = $new_slug;

	return $slug;
}
add_filter('coco_portfolio_project_slug', 'gavroche_coco_portfolio_project_slug_from_setting', 10, 1);

function gavroche_coco_portfolio_category_slug_from_setting($slug) {
	$new_slug = sanitize_title(gavroche_option('project_category_slug'));
	if ($new_slug != '') $slug = $new_slug;

	return $slug;
}
add_filter('coco_portfolio_category_slug', 'gavroche_coco_portfolio_category_slug_from_setting', 10, 1);


/**
 * Enable style select dropdown in TinyMCE
 *
 * @since 1.0
 * @return void
 */
function gavroche_add_style_select_tinymce($buttons) {
	array_unshift($buttons, 'styleselect');
	return $buttons;
}
add_filter('mce_buttons_2', 'gavroche_add_style_select_tinymce');


/**
 * Add new styles to TinyMCE
 *
 * @since 1.0
 * @return void
 */
function gavroche_add_new_styles_tinymce($styles) {
	$style_formats = array(
		array(
			'title' => '.intro',
			'selector' => 'p',
			'classes' => 'intro',
		),
	);

	$styles['style_formats'] = json_encode($style_formats);

	return $styles;
}
add_filter('tiny_mce_before_init', 'gavroche_add_new_styles_tinymce');


/**
 * Remove empty paragraphs created by wpautop()
 * @author Ryan Hamilton
 * @link https://gist.github.com/Fantikerz/5557617
 */
function gavroche_remove_empty_p($content) {
	$content = force_balance_tags($content);
	$content = preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
	$content = preg_replace('~\s?<p>(\s|&nbsp;)+</p>\s?~', '', $content);
	return $content;
}
add_filter('the_content', 'gavroche_remove_empty_p', 20, 1);


/**
 * List all portfolio projects on portfolio archive page and skill taxonomy page
 *
 * @since 1.0
 * @return void
 */
function gavroche_list_all_portfolio_projects($query) {
	if (
		(!is_admin() && $query->is_main_query())
		&&
		($query->is_tax('skill') || $query->is_post_type_archive('portfolio'))
	) {
		$query->set('posts_per_page', -1);
		$query->set('orderby', 'menu_order');
		$query->set('order', 'ASC');
	}
}
add_action('pre_get_posts', 'gavroche_list_all_portfolio_projects');

function gavroche_change_cf7_loader() {
	return get_template_directory_uri() . '/img/cf7_loader.png';
}
add_filter('wpcf7_ajax_loader', 'gavroche_change_cf7_loader');


add_action( 'admin_menu', 'compare_settings' );
function compare_settings() {
    add_options_page( __( 'Compare Settings', 'compare' ), __( 'Compare Settings', 'compare' ), 'manage_options', 'compare-settings', 'compare_settings_page' );
}

function compare_settings_page() {
    $tabs = array( 'awin', 'boulanger', 'help' );
    if ( isset( $_GET['tab'] ) ) {
        $active_tab = $_GET['tab'];

    } else {
        $active_tab = array_slice( $tabs, 0, 1 );
    }
    ?>
    <div class="wrap">
        <h2><?php _e( 'Settings', 'compare' ); ?></h2>
        <div class="description">This is description of the page.</div>
        <?php settings_errors(); ?>

        <h2 class="nav-tab-wrapper">
            <?php
            foreach ( $tabs as $tab ) {
                ?>
                <a href="?page=compare-settings&tab=<?php echo esc_html( $tab ); ?>"
                   class="nav-tab <?php echo $active_tab === $tab ? 'nav-tab-active' : ''; ?>"><?php echo $tab ?></a>
            <?php } ?>
        </h2>

        <form method="post" action="options.php">
            <?php
            if ( isset( $_GET['tab'] ) ) {
                $tab = $_GET['tab'];
            }
            switch ( $tab ) {
                case 'awin':
                    settings_fields( 'compare-awin-connect' );
                    settings_fields( 'compare-awin-secret' );
                    do_settings_sections( 'compare-awin' );
                    break;
                case 'help':
                    settings_fields( 'compare-help' );
                    do_settings_sections( 'compare-help' );
                    break;
            }


            submit_button(); ?>
        </form>


    </div>
    <?php
}

add_action( 'admin_init', 'compare_register_settings' );
function compare_register_settings() {
    add_settings_section( 'compare-awin', '', '', 'compare-awin' );
    register_setting( 'compare-awin-connect', 'zozozozozoz' );
	add_settings_field( 'compare-awin-connect', __( 'ConnectID', 'compare' ), 'compare_awin_connectID', 'compare-awin', 'compare-awin' );
	register_setting('compare-awin-secret', 'awin-secretID');

    add_settings_field( 'compare-awin-secret', __( 'SecretID', 'compare' ), 'compare_awin_secretID', 'compare-awin', 'compare-awin' );
}

function compare_awin_connectID() {
    $connect = get_option( 'zozozozozoz' );
	var_dump( $connect );
	$value = '';
    if ( ! empty( $connect ) ) {
        $value = 'value="' . $connect . '"';
    }
    ?>
    <input type="text" name="zozozozozoz" <?php echo $value; ?>>
    <?php
}

function compare_awin_secretID() {
    $secret = get_option( 'awin-secretID' );
    var_dump( $secret );
    if ( ! empty( $secret ) ) {
        $value = 'value="' . $secret . '"';
    }
    ?>
    <input type="text" name="awin-secretID" <?php echo $value; ?>>
    <?php
}