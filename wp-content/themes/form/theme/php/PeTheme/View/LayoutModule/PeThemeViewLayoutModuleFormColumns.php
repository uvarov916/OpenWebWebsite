<?php

class PeThemeViewLayoutModuleFormColumns extends PeThemeViewLayoutModuleFormContainer {

	public static $translate = 
		array(
			  "1/1" => "col-sm-12",
			  "1/2" => "col-sm-6",
			  "1/3" => "col-sm-4",
			  "1/4" => "col-sm-3",
			  "1/6" => "col-sm-2",
			  "2/4" => "col-sm-6",
			  "2/3" => "col-sm-8",
			  "3/4" => "col-sm-9",
			  "5/6" => "col-sm-10",
			  "last" => ""
			  );

	public function messages() {
		return
			array(
				  "title" => "",
				  "type" => __("Columns",'Pixelentity Theme/Plugin')
				  );
	}

	public function fields() {
		return
			array(
				  "columns" => 
				  array(
						"label" => __("Layout",'Pixelentity Theme/Plugin'),
						"description" => __("Select the columns layout",'Pixelentity Theme/Plugin'),
						"type" => "Select",
						"groups" => true,
						"options" => apply_filters('pe_theme_shortcode_columns_options',PeGlobal::$config["columns"]),
						),
				  "top" =>
				  array(
						"label" => __("Padding Top",'Pixelentity Theme/Plugin'),
						"description" => __("Amount of section top padding in pixels.",'Pixelentity Theme/Plugin'),
						"type" => "Number",
						"default" => 90
						),
				  "bottom" =>
				  array(
						"label" => __("Padding Bottom",'Pixelentity Theme/Plugin'),
						"description" => __("Amount of section bottom padding in pixels.",'Pixelentity Theme/Plugin'),
						"type" => "Number",
						"default" => 80
						)
				  );
	}

	public function name() {
		return __("Columns",'Pixelentity Theme/Plugin');
	}

	public function create() {
		return "FormText";
	}

	public function force() {
		return "FormText";
	}

	public function allowed() {
		return "column";
	}

	public function group() {
		return "section";
	}


	public function template() {
		
		if (empty($this->conf->items) || !is_array($this->conf->items)) {
			return;
		}

		$translate = PeThemeViewLayoutModuleFormColumns::$translate;

		if (empty($this->data->columns)) {
			$cols = count($this->conf->items);
		} else {
			$layout = explode(" ",strtr($this->data->columns,$translate));
			$cols = count($layout);
		}
		

		$idx = 0;
		$last = count($this->conf->items)-1;

		$open = '<div class="row">';
		$close = '</div>';

		$style = "";
		if ($this->data->top != "") {
			$style .= sprintf('padding-top:%spx; ',absint($this->data->top));
		}
		if ($this->data->bottom != "") {
			$style .= sprintf('padding-bottom:%spx; ',absint($this->data->bottom));
		}
		if ($style) {
			$style = sprintf('style="%s"',$style);
		}

		printf('<section class="center-mobile content container" %s>',$style);
		foreach ($this->conf->items as $item) {
			if (($idx % $cols) === 0) echo $open;
			printf('<div class="%s">',empty($layout[$idx % $cols]) ? '' : $layout[$idx % $cols],$idx,$cols);
			$this->outputModule($item);
			echo "</div>";
			if ($idx === $last || ($idx % $cols) === ($cols-1)) echo $close;
			$idx++;
		}
		print '</section>';

	}

	public function tooltip() {
		return __("Use this block to add columns of content to your layout.",'Pixelentity Theme/Plugin');
	}

}

?>
