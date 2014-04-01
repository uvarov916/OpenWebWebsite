<?php

class PeThemeViewLayoutModuleFormTestimonials extends PeThemeViewLayoutModuleContainer {

	public function messages() {
		return
			array(
				  "title" => "",
				  "type" => __("Testimonials",'Pixelentity Theme/Plugin')
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
						"default"=>__("What people are saying.",'Pixelentity Theme/Plugin')
						),
				  "content" =>
				  array(
						"label" => "Content",
						"type" => "Editor",
						"noscript" => true,
						"description" => __("Content",'Pixelentity Theme/Plugin'),
						"default" => __("A selection of hand-picked testimonials. Super-easy to include or remove from your designs.",'Pixelentity Theme/Plugin'),
						),
				  );
	}

	public function name() {
		return __("Testimonials",'Pixelentity Theme/Plugin');
	}

	public function type() {
		return __("Section",'Pixelentity Theme/Plugin');
	}

	public function create() {
		return "FormTestimonial";
	}

	public function force() {
		return "FormTestimonial";
	}
	
	public function allowed() {
		return "testimonial";
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
													  'via' => '',
													  'content' => ''
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
		peTheme()->get_template_part("viewmodule","testimonials");
	}

	public function tooltip() {
		return __("Use this block to add a Testimonials section.",'Pixelentity Theme/Plugin');
	}

}

?>
