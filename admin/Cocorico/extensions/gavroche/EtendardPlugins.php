<?php

if (!function_exists('gavrocheDiaporamaShorthand')) {
	function gavrocheDiaporamaShorthand($cocorico, $name)
	{
		$images = CoCoRequest::request($name);
		if (!$images) $images = $cocorico->getStore()->get($name);
		if (!$images) $images = array();

		$liens = CoCoRequest::request($name . '_lien');
		if (!$liens) $liens = $cocorico->getStore()->get($name . '_lien');

		$titres = CoCoRequest::request($name . '_titre');
		if (!$titres) $titres = $cocorico->getStore()->get($name . '_titre');

		$cocorico->startForm();

		foreach ($images as $index => $img) {
			$cocorico->startWrapper('tr');
			$cocorico->startWrapper('th');
			$cocorico->component('raw', __('Slider', 'gavroche') . ' #' . ($index + 1));
			$cocorico->endWrapper('th');
			$cocorico->endWrapper('tr');

			$cocorico->startWrapper('tr');

			$cocorico->startWrapper('th');
			//THIS MAKES NO SENSE, INVERTARGS
			$cocorico->component('label', $name . '-upload-' . $index, __('Image', 'gavroche'));
			$cocorico->endWrapper('th');

			$cocorico->startWrapper('td');
			$cocorico->component(
				'upload',
				$name,
				array(
					'value' => $img,
					'id' => $name . '-upload-' . $index,
					'name' => $name . '[]',
				)
			)->filter('stripslashes')->filter('save');
			$cocorico->endWrapper('td');

			$cocorico->endWrapper('tr');

			$cocorico->startWrapper('tr');

			$cocorico->startWrapper('th');
			//THIS MAKES NO SENSE, INVERTARGS
			$cocorico->component('label', $name . '-link-' . $index, __('Link', 'gavroche'));
			$cocorico->endWrapper('th');

			$cocorico->startWrapper('td');
			$cocorico->component(
				'text',
				$name . '_lien',
				array(
					'name' => $name . '_lien[]',
					'value' => $liens[$index],
					'id' => $name . '-link-' . $index,
				)
			)->filter('stripslashes')->filter('save');
			$cocorico->endWrapper('td');

			$cocorico->startWrapper('th');
			//THIS MAKES NO SENSE, INVERTARGS
			$cocorico->component('label', $name . '-title-' . $index, __('Title', 'gavroche'));
			$cocorico->endWrapper('th');

			$cocorico->startWrapper('td');
			$cocorico->component(
				'text',
				$name . '_titre',
				array(
					'name' => $name . '_titre[]',
					'value' => $titres[$index],
					'id' => $name . '-title-' . $index,
				)
			)->filter('stripslashes')->filter('save');
			$cocorico->endWrapper('td');

			$cocorico->startWrapper('td');
			$cocorico->component('link', '#', __('Delete', 'gavroche'), array(
				'class' => 'submitdelete gavroche-delete-diaporama',
				'style' => 'color: #A00;'
			));
			$cocorico->endWrapper('td');

			$cocorico->endWrapper('tr');
		}

		$cocorico->endForm();

		$cocorico->component('input', 'upload-add', array(
			'type' => 'button',
			'class' => array('button', 'button-primary', 'gavroche-diaporama-add'),
			'value' => __('Add', 'gavroche')
		));

		wp_register_script('gavroche_cocorico', ETENDARD_COCO_URI . '/extensions/gavroche/gavroche.js', array('jquery'), '1', true);
		wp_enqueue_script('gavroche_cocorico');
	}
}
CocoDictionary::register(CocoDictionary::SHORTHAND, 'diaporama', 'gavrocheDiaporamaShorthand');

if (!function_exists('gavrocheTitreWrapper')) {
	function gavrocheTitreWrapper($content)
	{
		$output = '<h2 style="font-size: 23px;font-weight: 400;padding: 9px 15px 4px 0px;line-height: 29px;">';
		$output .= $content;
		$output .= '</h2>';
		return $output;
	}
}
CocoDictionary::register(CocoDictionary::WRAPPER, 'titre', 'gavrocheTitreWrapper');

if (!function_exists('gavrocheUlWrapper')) {
	function gavrocheUlWrapper($content)
	{
		$output = '<ul class="slip-target">';
		$output .= $content;
		$output .= '</ul>';
		return $output;
	}
}
CocoDictionary::register(CocoDictionary::WRAPPER, 'ul', 'gavrocheUlWrapper');

if (!function_exists('gavrocheLiWrapper')) {
	function gavrocheLiWrapper($content)
	{
		$output = '<li>';
		$output .= $content;
		$output .= '</li>';
		return $output;
	}
}
CocoDictionary::register(CocoDictionary::WRAPPER, 'li', 'gavrocheLiWrapper');

if (!function_exists('gavrocheOrdreShorthand')) {
	function gavrocheOrdreShorthand($cocorico, $name, $label, $checkboxes)
	{
		$stored = CoCoRequest::request($name);
		if (!$stored) $stored = $cocorico->getStore()->get($name);

		if (!$stored) {
			//first run
			$stored = array();
			foreach ($checkboxes as $index => $value) {
				$stored[$index] = false;
			}
		}

		$reorderedCheckboxes = array();
		foreach ($stored as $index => $value) {
			$reorderedCheckboxes[$index] = $checkboxes[$index];
		}

		$reorderedCheckboxes = array_filter(array_merge($reorderedCheckboxes, $checkboxes));

		$cocorico->startWrapper('tr');
		$cocorico->startWrapper('th');
		$cocorico->component('raw', $label);
		$cocorico->endWrapper('th');

		$cocorico->startWrapper('td');
		$cocorico->startWrapper('ul');

		foreach ($reorderedCheckboxes as $value => $label) {
			$cocorico->startWrapper('li');
			$cocorico->component('boolean', $name . '[' . $value . ']', array('default' => $stored[$value]))->filter('saveOrdre', $name);
			$cocorico->component('label', $name . '[' . $value . ']', $label);
			$cocorico->endWrapper('li');
		}


		$cocorico->endWrapper('ul');
		$cocorico->endWrapper('td');
		$cocorico->endWrapper('tr');

		//wp_register_script('gavroche_slip', COCORICO_URI.'/extensions/gavroche/slip.js', array(), '1', true);
		wp_register_script('gavroche_slip', ETENDARD_COCO_URI . '/extensions/gavroche/slip.js', array(), '1', true);
		wp_enqueue_script('gavroche_slip');

		wp_register_script('gavroche_ordre', ETENDARD_COCO_URI . '/extensions/gavroche/ordre.js', array('jquery'), '1', true);
		wp_enqueue_script('gavroche_ordre');
	}
}
CocoDictionary::register(CocoDictionary::SHORTHAND, 'ordre', 'gavrocheOrdreShorthand');

if (!function_exists('gavrocheSaveOrdreFilter')) {
	function gavrocheSaveOrdreFilter($value, $name, $component)
	{
		$stored = CoCoRequest::request($name);
		$component->getStore()->set($name, $stored);
	}
}
CocoDictionary::register(CocoDictionary::FILTER, 'saveOrdre', 'gavrocheSaveOrdreFilter');

if (!function_exists('gavrocheTextList')) {
	function gavrocheTextList($component)
	{
		if ($component->getValue()) $value = $component->getValue();
		else if (isset($options['default'])) $value = $options['default'];
		else $value = array();

		$output = '<ul>';

		foreach ($value as $field) {
			if (trim($field) === '') continue;

			$output .= '<li><input type="text" class="gavroche-text-list" name="' . $component->getName() . '[]" value="' . $field . '" /><a href="#" class="gavroche-text-list-delete">' . __('delete', 'gavroche') . '</a></li>';
		}
		$output .= '<li><input type="text" class="gavroche-text-list" name="' . $component->getName() . '[]" /></li>';
		$output .= '</ul>';

		wp_register_script('gavroche_text_list', ETENDARD_COCO_URI . '/extensions/gavroche/textlist.js', array('jquery'), '1', true);
		wp_enqueue_script('gavroche_text_list');

		return $output;
	}
}
CocoDictionary::register(CocoDictionary::COMPONENT, 'text-list', 'gavrocheTextList');