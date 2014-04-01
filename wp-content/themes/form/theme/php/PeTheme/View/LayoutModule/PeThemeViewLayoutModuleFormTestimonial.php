<?php

class PeThemeViewLayoutModuleFormTestimonial extends PeThemeViewLayoutModuleText {

	public function messages() {
		return
			array(
				  "title" => "",
				  "type" => __("Testimonial",'Pixelentity Theme/Plugin')
				  );
	}

	public function fields() {
		return
			array(
				  "title" => 	
				  array(
						"label"=>__("Name",'Pixelentity Theme/Plugin'),
						"type"=>"Text",
						"description" => __("Testimonial.",'Pixelentity Theme/Plugin'),
						"default"=>__("John Doe",'Pixelentity Theme/Plugin')
						),
				  "via" => 	
				  array(
						"label"=>__("Via",'Pixelentity Theme/Plugin'),
						"type"=>"Text",
						"description" => __("Testimonial \"via\".",'Pixelentity Theme/Plugin'),
						"default"=>__("Someplace",'Pixelentity Theme/Plugin')
						),
				  "content" =>
				  array(
						"label" => "Quote",
						"type" => "Editor",
						"noscript" => true,
						"description" => __("Quote",'Pixelentity Theme/Plugin'),
						"default" => __("Lorem Ipsum",'Pixelentity Theme/Plugin')
						)
				  );
		
	}

	public function name() {
		return __("Testimonial",'Pixelentity Theme/Plugin');
	}

	public function group() {
		return "testimonial";
	}

	public function render() {
		// do nothing here since the rendering happens in the parent template
	}

	public function tooltip() {
		return __("Use this block to add a new service.",'Pixelentity Theme/Plugin');
	}

}

?>
