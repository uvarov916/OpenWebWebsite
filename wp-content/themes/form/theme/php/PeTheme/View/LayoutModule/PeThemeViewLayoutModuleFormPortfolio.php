<?php

class PeThemeViewLayoutModuleFormPortfolio extends PeThemeViewLayoutModule {

	public function messages() {
		return
			array(
				  "title" => "",
				  "type" => __("Portfolio",'Pixelentity Theme/Plugin')
				  );
	}

	public function fields() {
		$fields = peTheme()->data->customPostTypeMbox('project');
		$fields = $fields["content"];
		$fields = array_merge(
							  array(
									"title" => 	
									array(
										  "label"=>__("Title",'Pixelentity Theme/Plugin'),
										  "type"=>"Text",
										  "description" => __("Section title.",'Pixelentity Theme/Plugin'),
										  "default"=>__("Our Work.",'Pixelentity Theme/Plugin')
										  ),
									"content" =>
									array(
										  "label" => "Content",
										  "type" => "Editor",
										  "noscript" => true,
										  "description" => __("Section description.",'Pixelentity Theme/Plugin'),
										  "default" => __("A selection of work you can edit to show what you can do. We are capable of doing awesome things.",'Pixelentity Theme/Plugin')
										  ),
									"lightbox" =>
									array(
										  "label"=>__("Use Lightbox",'Pixelentity Theme/Plugin'),
										  "type"=>"RadioUI",
										  "description" => __("Enable/Disable lightbox usage on whole portfolio.",'Pixelentity Theme/Plugin'),
										  "options" => PeGlobal::$const->data->yesno,
										  "default"=>"no"
										  )
									),
							  $fields
							  );
		return $fields;
	}

	public function name() {
		return __("Portfolio",'Pixelentity Theme/Plugin');
	}

	public function type() {
		return __("Section",'Pixelentity Theme/Plugin');
	}

	public function templateName() {
		return "portfolio";
	}

	public function group() {
		return "section";
	}


	public function setTemplateData() {
		// we don't store template data here because we want to avoid it if the custom loop is empty
		// so we'll do it in render();
	}

	public function template() {
		$t =& peTheme();
		if ($loop = $t->data->customLoop($this->data)) {
			$t->template->data($this->data,$this->conf->bid);
			$t->get_template_part("viewmodule",$this->templateName());
			$t->content->resetLoop();
		}
	}

	public function tooltip() {
		return __("Add a Portfolio section showing projects.",'Pixelentity Theme/Plugin');
	}

}

?>
