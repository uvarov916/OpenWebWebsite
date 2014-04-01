<?php

class PeThemeViewLayoutModuleFormStaff extends PeThemeViewLayoutModuleText {

	public function messages() {
		return
			array(
				  "title" => "",
				  "type" => __("Staff",'Pixelentity Theme/Plugin')
				  );
	}

	public function fields() {
		return
			array(
				  "title" => 	
				  array(
						"label"=>__("Title",'Pixelentity Theme/Plugin'),
						"type"=>"Text",
						"description" => __("Staff Name.",'Pixelentity Theme/Plugin'),
						"default"=>__("Jon Doe",'Pixelentity Theme/Plugin')
						),
				  "content" =>
				  array(
						"label" => "Content",
						"type" => "Editor",
						"noscript" => true,
						"description" => __("Staff description.",'Pixelentity Theme/Plugin'),
						"default" => ""
						),
				  "social" => 
				  array(
						"label"        => __("Social Profile Links",'Pixelentity Theme/Plugin'),
						"type"         => "Items",
						"section"      => __("Footer",'Pixelentity Theme/Plugin'),
						"description"  => __("Add one or more links to social networks.",'Pixelentity Theme/Plugin'),
						"button_label" => __("Add Social Link",'Pixelentity Theme/Plugin'),
						"sortable"     => true,
						"auto"         => __("Layer",'Pixelentity Theme/Plugin'),
						"unique"       => false,
						"editable"     => false,
						"legend"       => false,
						"fields"       => 
						array(
							  array(
									"label"   => __("Social Network",'Pixelentity Theme/Plugin'),
									"name"    => "icon",
									"type"    => "select",
									"options" => apply_filters('pe_theme_social_icons',array()),
									"width"   => 185,
									"default" => "",
									),
							  array(
									"name"    => "url",
									"type"    => "text",
									"width"   => 300, 
									"default" => "#",
									)
							  )
						)
				  );
		
	}

	public function name() {
		return __("Staff",'Pixelentity Theme/Plugin');
	}

	public function group() {
		return "team";
	}

	public function render() {
		// do nothing here since the rendering happens in the parent template
	}

	public function tooltip() {
		return __("Use this block to add a new team member.",'Pixelentity Theme/Plugin');
	}

}

?>
