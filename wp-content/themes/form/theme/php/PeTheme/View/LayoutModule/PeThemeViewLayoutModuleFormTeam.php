<?php

class PeThemeViewLayoutModuleFormTeam extends PeThemeViewLayoutModuleContainer {

	public function messages() {
		return
			array(
				  "title" => "",
				  "type" => __("Team",'Pixelentity Theme/Plugin')
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
						"default"=>__("Our Team.",'Pixelentity Theme/Plugin')
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
						"label"=>__("Image",'Pixelentity Theme/Plugin'),
						"type"=>"Upload",
						"description" => __("Section image.",'Pixelentity Theme/Plugin'),
						"default"=>"",
						)
				  );
	}

	public function name() {
		return __("Team",'Pixelentity Theme/Plugin');
	}

	public function type() {
		return __("Section",'Pixelentity Theme/Plugin');
	}

	public function create() {
		return "FormStaff";
	}

	public function force() {
		return "FormStaff";
	}
	
	public function allowed() {
		return "team";
	}

	public function group() {
		return "section";
	}

	public function setTemplateData() {
		// override setTemplateData so to also pass the item array to the template file
		// this way the markup for the child blocks can also be generated in the container/parent template
		// We're not interested in builder related settings so we rebuild the array
		// to only include the data we going to use.
		
		$items = array();
		if (!empty($this->conf->items)) {
			foreach($this->conf->items as $item) {
				$item = (object) shortcode_atts(
												array(
													  'title' => '',
													  'content' => '',
													  'social' => array()
													  ),
												$item["data"]
												);
				
				$item->content = strip_tags($item->content,'<b><a><i><img>');
				$items[] = $item;
			}
		}

		// we also render (parent) shortcodes here to keep template file clean;
		$this->data->content = empty($this->data->content) ? "" : do_shortcode(apply_filters("the_content",$this->data->content));

		peTheme()->template->data($this->data,$items,$this->conf->bid);
	}

	public function template() {
		peTheme()->get_template_part("viewmodule","staff");
	}

	public function tooltip() {
		return __("Use this block to add a Team section.",'Pixelentity Theme/Plugin');
	}

}

?>
