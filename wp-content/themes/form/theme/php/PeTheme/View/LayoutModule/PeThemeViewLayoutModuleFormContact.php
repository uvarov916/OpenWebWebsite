<?php

class PeThemeViewLayoutModuleFormContact extends PeThemeViewLayoutModule {

	public function messages() {
		return
			array(
				  "title" => "",
				  "type" => __("Contact",'Pixelentity Theme/Plugin')
				  );
	}

	public function fields() {
		
		$defaultInfo = '<h2>Contact us.</h2><p>Want to make your website awesome? Just get in touch we don\'t bite.</p>';

		$contactMbox = array(
			"type"     => "",
			"title"    => __("Contact Options",'Pixelentity Theme/Plugin'),
			"priority" => "core",
			"where"    => array(
				"page" => "page_contact",
			),
			"content" => array(
				"info" => array(
					"label"       => __("Info",'Pixelentity Theme/Plugin'),
					"type"        => "TextArea",
					"description" => __("Contact Info.",'Pixelentity Theme/Plugin'),
					"default"     => $defaultInfo,
				),
				"msgOK" => array(
					"label"       => __("Mail Sent Message",'Pixelentity Theme/Plugin'),
					"type"        => "TextArea",
					"description" => __("Message shown when form message has been sent without errors",'Pixelentity Theme/Plugin'),
					"default"     => '<strong>Yay!</strong> Message sent.',
				),
				"msgKO" => array(
					"label"       => __("Form Error Message",'Pixelentity Theme/Plugin'),
					"type"        => "TextArea",
					"description" => __("Message shown when form message encountered errors",'Pixelentity Theme/Plugin'),
					"default"     => '<strong>Error!</strong> Please validate your fields.',
				),
			),
		);

		$gmap = PeGlobal::$const->gmap->metabox;

		$contactMbox["content"] = array_merge( $contactMbox["content"], $gmap["content"] );

		$fields = $contactMbox["content"];
		/*
		$fields["lightbox"] =
			array(
				  "label"=>__("Use Lightbox",'Pixelentity Theme/Plugin'),
				  "type"=>"RadioUI",
				  "description" => __("Enable/Disable lightbox usage on whole portfolio.",'Pixelentity Theme/Plugin'),
				  "options" => PeGlobal::$const->data->yesno,
				  "default"=>"no"
				  );
		*/
		return $fields;
	}

	public function name() {
		return __("Contact",'Pixelentity Theme/Plugin');
	}

	public function type() {
		return __("Section",'Pixelentity Theme/Plugin');
	}

	public function templateName() {
		return "contact";
	}

	public function group() {
		return "section";
	}


	public function setTemplateData() {
		$t =& peTheme();
		peTheme()->template->data($this->data,$this->conf->bid);
	}

	public function template() {
		peTheme()->get_template_part("viewmodule",$this->templateName());
	}

	public function tooltip() {
		return __("Add a Contact section showing posts.",'Pixelentity Theme/Plugin');
	}

}

?>
