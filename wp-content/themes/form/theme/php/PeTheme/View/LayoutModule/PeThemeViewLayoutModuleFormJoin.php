<?php

class PeThemeViewLayoutModuleFormJoin extends PeThemeViewLayoutModule {

	public function messages() {
		return
			array(
				  "title" => "",
				  "type" => __("Join",'Pixelentity Theme/Plugin')
				  );
	}

	public function fields() {
		
		$defaultInfo = '<h2>Join us.</h2><p>Want to make your website awesome? Just get in touch we don\'t bite.</p>';

		$joinMbox = array(
			"type"     => "",
			"title"    => __("Join Options",'Pixelentity Theme/Plugin'),
			"priority" => "core",
			"where"    => array(
				"page" => "page_join",
			),
			"content" => array(
				"info" => array(
					"label"       => __("Info",'Pixelentity Theme/Plugin'),
					"type"        => "TextArea",
					"description" => __("Join Info.",'Pixelentity Theme/Plugin'),
					"default"     => $defaultInfo,
				),
			),
		);

		$gmap = PeGlobal::$const->gmap->metabox;

		$joinMbox["content"] = array_merge( $joinMbox["content"], $gmap["content"] );

		$fields = $joinMbox["content"];
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
		return __("Join",'Pixelentity Theme/Plugin');
	}

	public function type() {
		return __("Section",'Pixelentity Theme/Plugin');
	}

	public function templateName() {
		return "join";
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
		return __("Add a Join section showing posts.",'Pixelentity Theme/Plugin');
	}

}

?>
