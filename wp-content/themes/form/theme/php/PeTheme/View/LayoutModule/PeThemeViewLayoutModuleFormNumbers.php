<?php

class PeThemeViewLayoutModuleFormNumbers extends PeThemeViewLayoutModule {

	public function messages() {
		return
			array(
				  "title" => "",
				  "type" => __("Numbers",'Pixelentity Theme/Plugin')
				  );
	}

	public function fields() {
		return
			array(
				  'numbers' => 
				  array(
						"label"        =>__("Numbers",'Pixelentity Theme/Plugin'),
						"type"         =>"Items",
						"description"  => __("Add one or more number describing this project.",'Pixelentity Theme/Plugin'),
						"button_label" => __("Add Number",'Pixelentity Theme/Plugin'),
						"sortable"     => true,
						"auto"         => '5',
						"unique"       => false,
						"editable"     => false,
						"legend"       => false,
						"fields"       => 
						array(
							  array(
									"label"   => __("Number",'Pixelentity Theme/Plugin'),
									"name"    => "number",
									"type"    => "text",
									"width"   => 185,
									"default" => "5",
									),
							  array(
									"name"    => "description",
									"type"    => "text",
									"width"   => 300, 
									"default" => "propositions",
									),
							  )
						)
				  );
	}

	public function name() {
		return __("Numbers",'Pixelentity Theme/Plugin');
	}

	public function type() {
		return __("Section",'Pixelentity Theme/Plugin');
	}

	public function templateName() {
		return "numbers";
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
		return __("Add a Numbers section.",'Pixelentity Theme/Plugin');
	}

}

?>
