<?php

class PeThemeViewLayoutModuleFormRecentWork extends PeThemeViewLayoutModule {

	public function messages() {
		return
			array(
				  "title" => "",
				  "type" => __("Recent Work",'Pixelentity Theme/Plugin')
				  );
	}

	public function fields() {
		return
			array(
				  "title" => 	
				  array(
						"label"=>__("Title",'Pixelentity Theme/Plugin'),
						"type"=>"Text",
						"description" => __("Section title.",'Pixelentity Theme/Plugin'),
						"default"=>__("Our recent work.",'Pixelentity Theme/Plugin')
						),
				  "content" =>
				  array(
						"label" => "Content",
						"type" => "Editor",
						"noscript" => true,
						"description" => __("Content",'Pixelentity Theme/Plugin'),
						"default" => ""
						),
				  "image" => 	
				  array(
						"label"=>__("Background",'Pixelentity Theme/Plugin'),
						"type"=>"Upload",
						"description" => __("Section background image.",'Pixelentity Theme/Plugin'),
						"default"=>"",
						),
				  "id" =>
				  array(
						"label" => __("Gallery",'Pixelentity Theme/Plugin'),
						"description" => __("Select the gallery.",'Pixelentity Theme/Plugin'),
						"type" => "Select",
						"options" => peTheme()->gallery->option(),
						"editable" => admin_url('post.php?post=%0&action=edit')
						),
				  "label" =>
				  array(
						"label"=>__("Button Label",'Pixelentity Theme/Plugin'),
						"type"=>"Text",
						"description" => __("Button label, leave empty to hide.",'Pixelentity Theme/Plugin'),
						"default"=>__("View work",'Pixelentity Theme/Plugin')
						),
				  "url" =>
				  array(
						"label"=>__("Button URL",'Pixelentity Theme/Plugin'),
						"type"=>"Text",
						"description" => __("Button link.",'Pixelentity Theme/Plugin'),
						"default"=>'#'
						),
				  );
	}

	public function name() {
		return __("Recent Work",'Pixelentity Theme/Plugin');
	}

	public function type() {
		return __("Section",'Pixelentity Theme/Plugin');
	}

	public function templateName() {
		return "recentwork";
	}

	public function group() {
		return "section";
	}

	public function setTemplateData() {
		$t =& peTheme();
		$loop = $t->gallery->getSliderLoop($this->data->id);
		peTheme()->template->data($this->data,$loop,$this->conf->bid);
	}

	public function template() {
		peTheme()->get_template_part("viewmodule",$this->templateName());
	}

	public function tooltip() {
		return __("Add a recent work gallery.",'Pixelentity Theme/Plugin');
	}

}

?>
