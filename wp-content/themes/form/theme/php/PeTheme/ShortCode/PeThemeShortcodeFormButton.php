<?php

class PeThemeShortcodeFormButton extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "pbutton";
		$this->group = __("UI",'Pixelentity Theme/Plugin');
		$this->name = __("Button",'Pixelentity Theme/Plugin');
		$this->description = __("Add a button",'Pixelentity Theme/Plugin');
		$this->fields = array(
			"url" => array(
				"label"       => __("Url",'Pixelentity Theme/Plugin'),
				"type"        => "Text",
				"description" => __("Enter the destination url of the button",'Pixelentity Theme/Plugin'),
			),
			"text" => array(
				"label"       => __("Text",'Pixelentity Theme/Plugin'),
				"type"        => "Text",
				"description" => __("Enter the button text here",'Pixelentity Theme/Plugin'),
			),
			"new_window" => array(
				"label"       => __("Open in new window",'Pixelentity Theme/Plugin'),
				"type"        => "Select",
				"description" => __("Should the url be opened in new window or not.",'Pixelentity Theme/Plugin'),
				"options"     => array(
					__("Yes",'Pixelentity Theme/Plugin') => "yes",
					__("No",'Pixelentity Theme/Plugin')  => "no",
				),
				"default"     =>"no",
			),
			"color" => array(
				"label"       => __("Color",'Pixelentity Theme/Plugin'),
				"type"        => "RadioUI",
				"options"     => array(
					__( 'Gray' ,'Pixelentity Theme/Plugin') => 'gray',
					__( 'Accent' ,'Pixelentity Theme/Plugin')  => 'accent',
					__( 'Accent Alt' ,'Pixelentity Theme/Plugin')  => 'accent-alt',
				),
				"description" => __('Select button color scheme.','Pixelentity Theme/Plugin'),
				"default"     => "gray",
			),
			"center" => array(
				"label"       => __("Center button",'Pixelentity Theme/Plugin'),
				"type"        => "RadioUI",
				"options"     => array(
					__( 'Yes' ,'Pixelentity Theme/Plugin') => 'yes',
					__( 'No' ,'Pixelentity Theme/Plugin')  => 'no',
				),
				"description" => __('Whether button should be centered.','Pixelentity Theme/Plugin'),
				"default"     => "no",
			),
		);
	}

	public function output($atts,$content=null,$code="") {
		extract($atts);
		if ( ! isset( $url ) ) $url = "#";

		$target = isset( $new_window ) && 'yes' === $new_window ? '_blank' : '_self';

		$color = isset( $color ) && '' !== $color ? $color : '';

		$center = isset( $center ) ? $center : 'no';

		if ( 'yes' === $center ) :

		$html = <<< EOT
<div class="center"><a href="$url" class="button $color" target="$target">$text</a></div>
EOT;

		else :

		$html = <<< EOT
<a href="$url" class="button $color" target="$target">$text</a>
EOT;

		endif;

        return trim($html);
	}


}
