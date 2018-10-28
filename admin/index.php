<?php
/**
* The template for displaying theme options using the Cocorico Framework
*
* @package Gavroche
* @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
* @link 		https://github.com/y-lohse/Cocorico
* @since 1.0
*/

if ( ! defined( 'ABSPATH' ) ) exit; ?>

<h2 style="font-size: 23px;font-weight: 400;padding: 9px 15px 4px 0px;line-height: 29px;">
<?php _e('Gavroche Settings', 'gavroche'); ?>
</h2>

<?php

// Create a new set of options
$form = new Cocorico(GAVROCHE_COCORICO_PREFIX);

// Registering tabs
$form->groupHeader(
array(
	'general' => __('General', 'gavroche'),
	'portfolio' => __('Portfolio', 'gavroche'),
	'advanced' => __('Advanced', 'gavroche'),
	'addons' => __('Addons', 'gavroche')
)
);

// General tab
$form->startWrapper('tab', 'general');

$form->startForm();

	// $form->setting(
	// 	array(
	// 		'type' => 'text',
	// 		'name' => substr(GAVROCHE_LICENSE_KEY, strlen(GAVROCHE_COCORICO_PREFIX)),
	// 		'label' => __("License", 'gavroche'),
	// 		'description' => __('Purchase a licence key in order to receive Gavroche updates and get access to support. Then paste it in the field above.', 'gavroche') . '<br><br><a href="https://www.themesdefrance.fr/themes/intro/#acheter?utm_source=theme&utm_medium=licenselink&utm_campaign=intro" target="_blank" class="button button-primary">' . __('Get Gavroche updates & support', 'gavroche') . '</a>'
	// 	)
	// );

	$form->setting(
		array(
			'type' => 'color',
			'name' => 'color',
			'options' => array(
				'default' => '#d05050'
			),
			'label' => __("Main color", 'gavroche'),
			'description' => __('This color will be used across your website for buttons, links, etc.', 'gavroche')
		)
	);

	$form->setting(
		array(
			'type' => 'upload',
			'name' => 'logo',
			'label' => __('Logo', 'gavroche'),
			'description' => __("Upload a logo to display in the header (if you don't have a logo, the name of your website will be displayed instead).", 'gavroche')
		)
	);

	$form->setting(
		array(
			'type' => 'upload',
			'name' => 'favicon',
			'label' => __('Favicon', 'gavroche'),
			'description' => __("Upload the favicon of your website.", 'gavroche')
		)
	);

	$form->setting(
		array(
			'type' => 'upload',
			'name' => 'default_background',
			'label' => __('Default background', 'gavroche'),
			'description' => __("Upload an image that will be used as a default background.", 'gavroche')
		)
	);

	$form->setting(
		array(
			'type' => 'text',
			'name' => 'cta_txt',
			'label' => __("Call-to-action text", 'gavroche'),
			'description' => __('This is the text displayed above the content in the CTA box. Once clicked, it will open the CTA box.', 'gavroche') . '</a>',
			'options' => array(
				'default' => __('<i class="typcn typcn-heart-outline"></i> Stay informed : subscribe !<span class="dot">.</span> Suivez-nous !', 'gavroche')
			)
		)
	);

	/*$form->setting(
		array(
			'type' => 'boolean',
			'name' => 'enable_cta',
			'options' => array(
		        'default' => true
			),
			'label' => __('Enable call-to-action top bar ?', 'gavroche'),
			'description' => __("If you enable the call-to-action top bar, it'll appear before the content at the top of your page.", 'gavroche')
		)
	);*/

	$form->ordre(
		'home_sections',
		__('Choose elements to display on the homepage and organize them by drag & drop', 'gavroche'),
		array(
			'content' => __('Page content', 'gavroche'),
			'portfolio' => __('Portfolio featured projects', 'gavroche'),
			'skills' => __('Skills', 'gavroche'),
			'references' => __('References', 'gavroche'),
			'posts' => __('Blog posts', 'gavroche'),
		)
	);

	$form->setting(
		array(
			'type' => 'number',
			'name' => 'home_posts',
			'label' => __('Posts on homepage', 'gavroche'),
			'description' => __('How many blog posts should be displayed on the homepage ?', 'gavroche') . '</a>',
			'options' => array(
				'default' => 5
			)
		)
	);

	$form->setting(
		array(
			'type' => 'textarea',
			'name' => 'copyright',
			'label' => __("Copyright content", 'gavroche'),
			'description' => __('Copyright content displayed in the footer. The following HTML tags are allowed : &lt;a&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;img&gt;. %YEAR% will be replaced by the current year.', 'gavroche'),
			'options' => array(
				'default' => sprintf(__('<strong>%s</strong> - Gavroche by <a href="https://www.themesdefrance.fr/" target="_blank">Themes de France</a>', 'gavroche'),date('Y'))
			)
		)
	);

$form->endForm();

$form->endWrapper('tab');

// Portfolio tab
$form->startWrapper('tab', 'portfolio');

$form->startForm();

	$form->setting(
		array(
			'type' => 'text',
			'name' => 'archive_slug',
			'label' => __('Archive slug', 'gavroche'),
			'description' => __('This settings lets you change the projects archive URL slug (default is "portfolio").', 'gavroche') . __('<br><small>(please visit the Permalinks Settings page after changing this setting)</small>', 'gavroche'),
			'options' => array(
				'default' => 'portfolio'
			)
		)
	);

	$form->setting(
		array(
			'type' => 'text',
			'name' => 'project_slug',
			'label' => __('Single project slug', 'gavroche'),
			'description' => __('This settings lets you change a single project URL slug (default is "project").', 'gavroche') . __('<br><small>(please visit the Permalinks Settings page after changing this setting)</small>', 'gavroche'),
			'options' => array(
				'default' => 'project'
			)
		)
	);

	$form->setting(
		array(
			'type' => 'text',
			'name' => 'project_category_slug',
			'label' => __('Project category slug', 'gavroche'),
			'description' => __('This settings lets you change the projects categories URL slug (default is "project-category").', 'gavroche') . __('<br><small>(please visit the Permalinks Settings page after changing this setting)</small>', 'gavroche'),
			'options' => array(
				'default' => 'project-category'
			)
		)
	);

$form->endForm();

$form->endWrapper('tab');

// Advanced tab
$form->startWrapper('tab', 'advanced');

$form->startForm();

	$form->setting(
		array(
			'type' => 'textarea',
			'name' => 'custom_css',
			'label' => __('Additional CSS', 'gavroche'),
			'options' => array(
				'rows' => 15,
			),
			'description' => __('CSS rules added in this field will be added to your site. If you have too many updates, you should download and install the Gavroche child theme from', 'gavroche') . ' <a href="https://www.themesdefrance.fr/" target="_blank">' . __('your Themes de France account', 'gavroche') . '</a>.'
		)
	);

	$form->setting(
		array(
			'type' => 'textarea',
			'name' => 'custom_html_head',
			'label' => __('Additional HTML in &lt;head&gt;', 'gavroche'),
			'options' => array(
				'rows' => 15,
			),
			'description' => __('This extra HTML code will be added in the &lt;head&gt; on each page.', 'gavroche') . '</a>.'
		)
	);

	$form->setting(
		array(
			'type' => 'textarea',
			'name' => 'custom_html_body',
			'label' => __('Additional HTML in &lt;body&gt;', 'gavroche'),
			'options' => array(
				'rows' => 15,
			),
			'description' => __('This extra HTML code will be added just before the &lt;/body&gt; end tag on each page.', 'gavroche') . '</a>.'
		)
	);

$form->endForm();

$form->endWrapper('tab');


// Addons tab
$form->startWrapper('tab', 'addons');

$form->startForm();

	$form->startWrapper('td');

		$form->component('raw', __('Do you know that Gavroche can be extended with addons ? Check the addons available below :', 'gavroche'));

	$form->endWrapper('td');

$form->endForm();

$form->startForm();

	// Action to hook from addons
	do_action('gavroche_addons_tab', $form);

$form->endForm();

$form->endWrapper('tab');

$form->component('submit', 'submit', array('value'=>__('Save changes', 'gavroche')));

$form->render();

?>

<div style="margin-top:20px;">
<?php $status = get_option('gavroche_license_status'); ?>

<?php if($status):

		_e('Any questions on Gavroche ? Go to the', 'gavroche'); ?> <a href="https://www.themesdefrance.fr/support/?utm_source=theme&utm_medium=supportlink&utm_campaign=intro" target="_blank"><?php _e('Themes de France support page.', 'gavroche'); ?></a>

<?php else:

		_e('In order to get support, you need to purchase', 'gavroche'); ?> <a href="https://www.themesdefrance.fr/themes/intro/#acheter?utm_source=theme&utm_medium=supportlink&utm_campaign=intro" target="_blank"><?php _e('the full version.', 'gavroche'); ?></a>

<?php endif;

	 _e('If you like Gavroche, you should', 'gavroche'); ?>, <a href="https://www.facebook.com/ThemesDeFrance" target="_blank"><?php _e('follow us on Facebook', 'gavroche'); ?></a>.

</div>