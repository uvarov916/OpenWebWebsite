<?php

class PeThemeForm extends PeThemeController {

	public $preview = array();

	public function __construct() {

		// custom post types
		add_action("pe_theme_custom_post_type",array(&$this,"pe_theme_custom_post_type"));

		// wp_head stuff
		add_action("pe_theme_wp_head",array(&$this,"pe_theme_wp_head"));

		// google fonts
		add_filter("pe_theme_font_variants",array(&$this,"pe_theme_font_variants_filter"),10,2);

		// menu
		add_filter("wp_nav_menu_objects",array(&$this,"wp_nav_menu_objects_filter"),10,2);

		// social links
		add_filter("pe_theme_social_icons",array(&$this,"pe_theme_social_icons_filter"));
		add_filter("pe_theme_content_get_social_link",array(&$this,"pe_theme_content_get_social_link_filter"),10,4);

		// comment submit button class
		add_filter("pe_theme_comment_submit_class",array(&$this,"pe_theme_comment_submit_class_filter"));

		// use prio 30 so gets executed after standard theme filter
		add_filter("the_content_more_link",array(&$this,"the_content_more_link_filter"),30);

		// remove junk from project screen
		add_action('pe_theme_metabox_config_project',array(&$this,'pe_theme_form_metabox_config_project'),200);

		// add featured image to testimonial
		add_action('init',array(&$this,'pe_theme_form_testimonial_supports'),200);

		// shortcodes
		add_filter("pe_theme_shortcode_columns_mapping",array(&$this,"pe_theme_shortcode_columns_mapping_filter"));
		add_filter("pe_theme_shortcode_columns_options",array(&$this,"pe_theme_shortcode_columns_options_filter"));
		add_filter("pe_theme_shortcode_columns_container",array(&$this,"pe_theme_shortcode_columns_container_filter"),10,2);

		// portfolio
		add_filter("pe_theme_filter_item",array(&$this,"pe_theme_project_filter_item_filter"),10,4);

		// remove staff meta
		add_action('pe_theme_metabox_config_staff',array(&$this,'pe_theme_metabox_config_staff_action'),11);

		// alter services meta
		add_action('pe_theme_metabox_config_service',array(&$this,'pe_theme_metabox_config_service_action'),11);

		// custom meta for gallery images
		add_filter( 'pe_theme_gallery_image_fields', array( $this, 'pe_theme_gallery_image_fields_filter' ) );

		// custom homepage meta js
		add_action( 'admin_enqueue_scripts', array( $this, 'pe_theme_form_custom_meta_js' ) );

		// font awesome admin picker
		add_action( 'admin_enqueue_scripts', array( $this, 'pe_theme_font_awesome_icons' ) );

		// custom video metabox
		add_action('pe_theme_metabox_config_video',array(&$this,'pe_theme_metabox_config_video'),99);

		// builder
		add_filter('pe_theme_view_layout_open',array(&$this,'pe_theme_view_layout_no_parent'));
		add_filter('pe_theme_view_layout_close',array(&$this,'pe_theme_view_layout_no_parent'));
		add_filter('pe_theme_layoutmodule_open',array(&$this,'pe_theme_view_layout_no_parent'));
		add_filter('pe_theme_layoutmodule_close',array(&$this,'pe_theme_view_layout_no_parent'));

	}

	public function pe_theme_view_layout_no_parent($markup) {
		return "";
	}

	public function pe_theme_form_custom_meta_js() {

		PeThemeAsset::addScript("js/form-homepage-meta.js",array('jquery'),"pe_theme_form_homepage_meta");

		$screen = get_current_screen();

		if ( is_admin() && ( 'page' === $screen->post_type || 'post' === $screen->post_type ) ) {
			wp_enqueue_script("pe_theme_form_homepage_meta");
		}

	}

	public function pe_theme_font_awesome_icons() {

		PeThemeAsset::addStyle("css/font-awesome.css",array(),"pe_theme_font_awesome_css");

		$screen = get_current_screen();

		if ( is_admin() && ( 'page' === $screen->post_type || 'post' === $screen->post_type || 'project' === $screen->post_type ) ) {
			wp_enqueue_style("pe_theme_font_awesome_css");
		}

	}

	public function the_content_more_link_filter($link) {
		return sprintf('<a class="read-more-link" href="%s">%s</a>',get_permalink(),__("Continue Reading..",'Pixelentity Theme/Plugin'));
	}

	public function pe_theme_project_filter_item_filter( $html, $aclass, $slug, $name ) {
		return sprintf( '<li class="filter" data-filter="%s">%s</li>', '' === $slug ? 'all' : "filter-$slug", $name );
	}

	public function pe_theme_wp_head() {
		$this->font->apply();
		$this->color->apply();

		// custom CSS field
		if ($customCSS = $this->options->get("customCSS")) {
			printf('<style type="text/css">%s</style>',stripslashes($customCSS));
		}

		// custom JS field
		if ($customJS = $this->options->get("customJS")) {
			printf('<script type="text/javascript">%s</script>',stripslashes($customJS));
		}

	}

	public function pe_theme_font_variants_filter($variants,$font) {
		if ($font === "Open Sans") {
			$variants="$font:400italic,300,400,700,800";
		}
		else if ($font === "Lato") {
			$variants="$font:300,400,700";
		}
		else if ($font === "Montserrat") {
			$variants="$font:400,700";
		}
		else if ($font === "Volkhov") {
			$variants="$font:400italic,700italic,400,700";
		}

		return $variants;
	}

	public function wp_nav_menu_objects_filter($items,$args) {
		if (is_array($items) && !empty($args->theme_location)) {
			$home = false;

			if (is_page()) {
				if ($this->content->pageTemplate() === "page_home.php") {
					$home = get_page_link(get_the_id());
				}
			}

			foreach ($items as $id => $item) {

				if (!empty($item->post_parent)) {
					if ($item->object === "page") {
						$page = get_page($item->object_id);
						if (!empty($page->post_name)) {
							$parent = get_page_link($item->post_parent);
							$slug = $page->post_name;
							$items[$id]->url = $home ? $parent . "#{$slug}" : $parent . "#{$slug}";
							$item->classes[] = $home ? "smoothscroll" : "";
						}
					}
				} else if ($item->url === $home) {
					if ($item->object === "page") {

						$page = get_page($item->object_id);
						$items[$id]->url = $home ? "#" . $page->post_name : $items[$id]->url . "#" . $page->post_name;
						$item->classes[] = $home ? "smoothscroll" : "";

					}
				}

			}
		}
		return $items;
	}

	public function pe_theme_social_icons_filter($icons = null) {
		return 
			array(
				  // label => icon | tooltip text
				  __("Dribbble",'Pixelentity Theme/Plugin') => "fa fa-dribbble|Dribbble",
				  __("Dropbox",'Pixelentity Theme/Plugin') => "fa fa-dropbox|Dropbox",
				  __("Facebook",'Pixelentity Theme/Plugin') => "fa fa-facebook|Facebook",
				  __("Flickr",'Pixelentity Theme/Plugin') => "fa fa-flickr|Flickr",
				  __("Github",'Pixelentity Theme/Plugin') => "fa fa-github|Github",
				  __("Google+",'Pixelentity Theme/Plugin') => "fa fa-google-plus|Google+",
				  __("Instagram",'Pixelentity Theme/Plugin') => "fa fa-instagram|Instagram",
				  __("Linkedin",'Pixelentity Theme/Plugin') => "fa fa-linkedin|Linkedin",
				  __("Pinterest",'Pixelentity Theme/Plugin') => "fa fa-pinterest|Pinterest",
				  __("Skype",'Pixelentity Theme/Plugin') => "fa fa-skype|Skype",
				  __("Twitter",'Pixelentity Theme/Plugin') => "fa fa-twitter|Twitter",
				  __("Vimeo",'Pixelentity Theme/Plugin') => "fa fa-vimeo-square|Vimeo",
				  __("VK",'Pixelentity Theme/Plugin') => "fa fa-vk|VK",
				  __("YouTube",'Pixelentity Theme/Plugin') => "fa fa-youtube|YouTube",
				  );
	}

	public function pe_theme_content_get_social_link_filter($html,$link,$tooltip,$icon) {
		return sprintf('<li><a href="%s" target="_blank" title="%s"><i class="%s"></i></a></li>',$link,$tooltip,$icon);
	}

	public function pe_theme_comment_submit_class_filter() {
		return "contour-btn red";
	}

	public function init() {
		parent::init();

		if (PE_THEME_PLUGIN_MODE) {
			return;
		}
		
		if ($this->options->get("retina") === "yes") {
			add_filter("pe_theme_resized_img",array(&$this,"pe_theme_resized_retina_filter"),10,5);
		} else if ($this->options->get("lazyImages") === "yes") {
			add_filter("pe_theme_resized_img",array(&$this,"pe_theme_resized_img_filter"),10,4);
		}
	}

	public function pe_theme_custom_post_type() {
		$this->gallery->cpt();
		$this->video->cpt();
		$this->project->cpt();
		//$this->ptable->cpt();
		//$this->staff->cpt();
		//$this->service->cpt();
		//$this->testimonial->cpt();
		//$this->logo->cpt();
		//$this->slide->cpt();
		//$this->view->cpt();

	}

	public function pe_theme_shortcode_columns_mapping_filter($array) {
			return array(
				'1/1' => 'col-sm-12',
				"1/3" => "col-sm-4",
				"1/2" => "col-sm-6",
				"1/4" => "col-sm-3",
				"2/3" => "col-sm-8",
				"1/6" => "col-sm-2",
				"last" => '',
			);
		}

	public function pe_theme_shortcode_columns_options_filter($array) {
		unset($array['2 Column layouts']['5/6 1/6']);
		unset($array['2 Column layouts']['1/6 5/6']);
		unset($array['2 Column layouts']['1/4 3/4']);
		unset($array['2 Column layouts']['3/4 1/4']);
		unset($array['3 Column layouts']['1/4 1/4 2/4']);
		unset($array['3 Column layouts']['2/4 1/4 1/4']);

		$single['Single column layout']['1/1'] = '1/1';

		$array = 
			array_merge(
						$single,
						$array
						);
		//unset($array['4 Column layouts']);
		//unset($array['6 Column layouts']);

		return $array;
	}

	public function pe_theme_shortcode_columns_container_filter( $template, $content ) {

		return sprintf('<div class="row">%s</div>',$content);

	}


	public function boot() {
		parent::boot();

		
		PeGlobal::$config["content-width"] = 990;
		PeGlobal::$config["post-formats"] = array("video","gallery");
		PeGlobal::$config["post-formats-project"] = array("video","gallery");

		PeGlobal::$config["image-sizes"]["thumbnail"] = array(120,90,true);
		PeGlobal::$config["image-sizes"]["post-thumbnail"] = array(260,200,false);
		

		// blog layouts
		PeGlobal::$config["blog"] =
			array(
				  __("Default",'Pixelentity Theme/Plugin') => "",
				  __("Search",'Pixelentity Theme/Plugin') => "search",
				  __("Alternate",'Pixelentity Theme/Plugin') => "project"
				  );

		PeGlobal::$config["shortcodes"] = 
			array(
				  //"BS_Badge",
				  //"BS_Label",
				  //"BS_Button",
				  //"FormNumber",
				  "FormButton",
				  //"FormIcon",
				  //"FormService",
				  //"FormNewsletter",
				  "BS_Columns",
				  "BS_Video"
				  );

		PeGlobal::$config["views"] = 
			array(
				  "LayoutModuleFormServices",
				  "LayoutModuleFormService",
				  "LayoutModuleFormPortfolio",
				  "LayoutModuleFormRecentWork",
				  "LayoutModuleFormTestimonials",
				  "LayoutModuleFormTestimonial",
				  "LayoutModuleFormNumbers",
				  "LayoutModuleFormTeam",
				  "LayoutModuleFormStaff",
				  "LayoutModuleFormContact",
				  "LayoutModuleFormBlog",
				  "LayoutModuleFormColumns",
				  "LayoutModuleFormText"
				  );

		PeGlobal::$config["sidebars"] =
			array(
				  "default" => __("Default post/page",'Pixelentity Theme/Plugin'),
				  //"footer" => __("Footer Widgets",'Pixelentity Theme/Plugin')
				  );

		PeGlobal::$config["colors"] = 
			array(
				  "color1" => 
				  array(
						"label" => __("Primary Color",'Pixelentity Theme/Plugin'),
						"selectors" => 
						array(
							".highlighted" => "color",
							"a" => "color",
							"a:visited" => "color",
							"a.button.accent" => "color",
							".form-click input" => "color",
							".post-title a:hover" => "color",
							".widget-archive a:hover" => "color",
							".widget-recent-entries a:hover" => "color",
							".cat-item a:hover" => "color",
							".recentcomments a:hover" => "color",
							".controls button" => "color",
							"* > .pagination span.current, .pagination a" => "color",

							".accent" => "background-color",
							".button.accent:hover" => "background-color",
							".form-click input:hover" => "background-color",
							".controls button:hover" => "background-color",
							".four-o-four" => "background-color",
							".pagination span.current, .pagination a" => "background-color",
							".pagination span.current" => "background-color",
							".pagination span.current:hover" => "background-color",
							".pagination a:hover" => "background-color",
							".sticky-head" => "background-color:0.95",

							"a.button.accent:hover" => "border-color",
							"* > .form-click input:hover" => "border-color",
							"* > .controls button:hover" => "border-color",
							"* > .pagination span.current" => "border-color",
							"* > .pagination span.current:hover" => "border-color",
							"* > .pagination a:hover" => "border-color",

						),
						"default" => "#2db4d8"
						),
				  );
		

		PeGlobal::$config["fonts"] = array(
			"fontBody" => array(
				"label"     => __("General Font",'Pixelentity Theme/Plugin'),
				"selectors" => array(
					"body",
					"h5",
					"h6",
					"nav.mobile #search",
					"nav.desktop #search",
					".form-field span input",
					".form-field span textarea",
					".form-click input",
					".controls button",
				),
				"default" => "Lato",
			),
			"fontSecondary" => array(
				"label"     => __("Secondary Font",'Pixelentity Theme/Plugin'),
				"selectors" => array(
					"h1",
					"h2",
					"h3",
					"h4",
					".milestone .value",
				),
				"default" => "Montserrat",
			),
		);		

		$options = array();

		$galleries = $this->gallery->option();

		$none = array( __("None",'Pixelentity Theme/Plugin') => '-1' );

		$galleries = array_merge( $none, $galleries );

		$options = array_merge( $options, array(
			"import_demo" => $this->defaultOptions["import_demo"],
			"logo" => array(
				"label"       => __("Logo",'Pixelentity Theme/Plugin'),
				"type"        => "Upload",
				"section"     => __("General",'Pixelentity Theme/Plugin'),
				"description" => __("This is the main site logo image. The image should be a .png file.",'Pixelentity Theme/Plugin'),
				"default"     => PE_THEME_URL."/images/logo.png",
			),
			'hero_bg' => array(
				'label'       => __( 'Header Background' ,'Pixelentity Theme/Plugin'),
				'type'        => 'Upload',
				'section'     => __( 'General' ,'Pixelentity Theme/Plugin'),
				'description' => __( 'Background image used in header.' ,'Pixelentity Theme/Plugin'),
				'default'     => PE_THEME_URL . '/images/hero.png',
			),
			"favicon" => array(
				"label"       => __("Favicon",'Pixelentity Theme/Plugin'),
				"type"        => "Upload",
				"section"     => __("General",'Pixelentity Theme/Plugin'),
				"description" => __("This is the favicon for your site. The image can be a .jpg, .ico or .png with dimensions of 16x16px ",'Pixelentity Theme/Plugin'),
				"default"     => PE_THEME_URL."/favicon.png",
			),
			"customCSS" => $this->defaultOptions["customCSS"],
			"customJS"  => $this->defaultOptions["customJS"],
			"colors"    => array(
				"label"       => __("Custom Colors",'Pixelentity Theme/Plugin'),
				"type"        => "Help",
				"section"     => __("Colors",'Pixelentity Theme/Plugin'),
				"description" => __("In this page you can set alternative colors for the main colored elements in this theme. One color options has been provided. To change the color used on these elements simply write a new hex color reference number into the fields below or use the color picker which appears when each field obtains focus. Once you have selected your desired colors make sure to save them by clicking the <b>Save All Changes</b> button at the bottom of the page. Then just refresh your page to see the changes.<br/><br/><b>Please Note:</b> Some of the elements in this theme are made from images (Eg. Icons) and these items may have a color. It is not possible to change these elements via this page, instead such elements will need to be changed manually by opening the images/icons in an image editing program and manually changing their colors to match your theme's custom color scheme. <br/><br/>To return all colors to their default values at any time just hit the <b>Restore Default</b> link beneath each field.",'Pixelentity Theme/Plugin'),
			),
			"googleFonts" => array(
				"label"       => __("Custom Fonts",'Pixelentity Theme/Plugin'),
				"type"        => "Help",
				"section"     => __("Fonts",'Pixelentity Theme/Plugin'),
				"description" => __("In this page you can set the typefaces to be used throughout the theme. For each elements listed below you can choose any front from the Google Web Font library. Once you have chosen a font from the list, you will see a preview of this font immediately beneath the list box. The icons on the right hand side of the font preview, indicate what weights are available for that typeface.<br/><br/><strong>R</strong> -- Regular,<br/><strong>B</strong> -- Bold,<br/><strong>I</strong> -- Italics,<br/><strong>BI</strong> -- Bold Italics<br/><br/>When decideing what font to use, ensure that the chosen font contains the font weight required by the element. For example, main headings are bold, so you need to select a new font for these elements which supports a bold font weight. If you select a font which does not have a bold icon, the font will not be applied. <br/><br/>Browse the online <a href='http://www.google.com/webfonts'>Google Font Library</a><br/><br/><b>Custom fonts</b> (Advanced Users):<br/> Other then those available from Google fonts, custom fonts may also be applied to the elements listed below. To do this an additional field is provided below the google fonts list. Here you may enter the details of a font family, size, line-height etc. for a custom font. This information is entered in the form of the shorthand 'font:' CSS declaration, for example:<br/><br/><b>bold italic small-caps 1em/1.5em arial,sans-serif</b><br/><br/>If a font is specified in this field then the font listed in the Google font drop menu above will not be applied to the element in question. If you wish to use the Google font specified in the drop down list and just specify a new font size or line height, you can do so in this field also, however the name of the Google font <b>MUST</b> also be entered into this field. You may need to visit the Google fonts web page to find the exact CSS name for the font you have chosen.",'Pixelentity Theme/Plugin'),
			),
			"contactEmail" => $this->defaultOptions["contactEmail"],
			"contactEmailFooter" => $this->defaultOptions["contactEmail"],
			"contactSubject" => $this->defaultOptions["contactSubject"],
			"contactPhone" => array(
				"label"       => __("Phone Number",'Pixelentity Theme/Plugin'),
				"type"        => "Text",
				"section"     => __("Footer",'Pixelentity Theme/Plugin'),
				"description" => __("Phone number, leave empty to hide.",'Pixelentity Theme/Plugin'),
				"default"     => "+ 714-555-1212",
			),
			"contactAddress" => array(
				"label"       => __("Address",'Pixelentity Theme/Plugin'),
				"type"        => "Text",
				"section"     => __("Footer",'Pixelentity Theme/Plugin'),
				"description" => __("Address, leave empty to hide (used only for display).",'Pixelentity Theme/Plugin'),
				"default"     => "1000 Coney Island Ave. NY 11230",
			),
			"contactAddressLink" => array(
				"label"       => __("Address Link",'Pixelentity Theme/Plugin'),
				"type"        => "Text",
				"section"     => __("Footer",'Pixelentity Theme/Plugin'),
				"description" => __("Address Link (used for linking address to external map like Google Maps).",'Pixelentity Theme/Plugin'),
				"default"     => "#",
			),
			"footerCopyright" => array(
				"label"       => __("Copyright",'Pixelentity Theme/Plugin'),
				"wpml"        =>  true,
				"type"        => "TextArea",
				"section"     => __("Footer",'Pixelentity Theme/Plugin'),
				"description" => __("This is the footer copyright message.",'Pixelentity Theme/Plugin'),
				"default"     => '&copy; 2014 Form, LLC',
			),
			"footerSocialLinks" => array(
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
				"fields"       => array(
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
					),
				),
				"default" => "",
			),
			'logosGallery' => array(
				'label'       => __('Logos Gallery','Pixelentity Theme/Plugin'),
				'type'        => 'Select',
				'section'     => __( 'Footer' ,'Pixelentity Theme/Plugin'),
				'description' => __('Specify which gallery should be used for logos section.','Pixelentity Theme/Plugin'),
				'options'     => $galleries,
				"default"     => 'None',
			),
			'ctaTitle' => array(
				'label'       => __( 'Call To Action Title' ,'Pixelentity Theme/Plugin'),
				'wpml'        => true,
				'type'        => 'Text',
				'section'     => __( 'Footer' ,'Pixelentity Theme/Plugin'),
				'description' => __( 'Title of your Call To Action section displayed above footer.' ,'Pixelentity Theme/Plugin'),
				'default'     => 'Are you impressed?',
			),
			'ctaSubtitle' => array(
				'label'       => __( 'Call To Action Subtitle' ,'Pixelentity Theme/Plugin'),
				'wpml'        => true,
				'type'        => 'TextArea',
				'section'     => __( 'Footer' ,'Pixelentity Theme/Plugin'),
				'description' => __( 'Subtitle of your Call To Action section displayed above footer.' ,'Pixelentity Theme/Plugin'),
				'default'     => __('If so, why don\'t you get in touch with us so we can talk about your projects.','Pixelentity Theme/Plugin'),
			),
			'ctaButton1Text' => array(
				'label'       => __( 'Call To Action Button 1 Text' ,'Pixelentity Theme/Plugin'),
				'wpml'        => true,
				'type'        => 'Text',
				'section'     => __( 'Footer' ,'Pixelentity Theme/Plugin'),
				'description' => __( 'Text of the first button in the Call To Action section.' ,'Pixelentity Theme/Plugin'),
				'default'     => 'Contact us',
			),
			'ctaButton1Link' => array(
				'label'       => __( 'Call To Action Button 1 Link' ,'Pixelentity Theme/Plugin'),
				'wpml'        => true,
				'type'        => 'Text',
				'section'     => __( 'Footer' ,'Pixelentity Theme/Plugin'),
				'description' => __( 'Link of the first button in the Call To Action section.' ,'Pixelentity Theme/Plugin'),
				'default'     => '#',
			),
			'ctaButtonsSeparator' => array(
				'label'       => __( 'Call To Action Buttons separator' ,'Pixelentity Theme/Plugin'),
				'wpml'        => true,
				'type'        => 'Text',
				'section'     => __( 'Footer' ,'Pixelentity Theme/Plugin'),
				'description' => __( 'Text separating the buttons in your Call To Action section.' ,'Pixelentity Theme/Plugin'),
				'default'     => 'or',
			),
			'ctaButton2Text' => array(
				'label'       => __( 'Call To Action Button 2 Text' ,'Pixelentity Theme/Plugin'),
				'wpml'        => true,
				'type'        => 'Text',
				'section'     => __( 'Footer' ,'Pixelentity Theme/Plugin'),
				'description' => __( 'Text of the second button in the Call To Action section.' ,'Pixelentity Theme/Plugin'),
				'default'     => 'View Blog',
			),
			'ctaButton2Link' => array(
				'label'       => __( 'Call To Action Button 2 Link' ,'Pixelentity Theme/Plugin'),
				'wpml'        => true,
				'type'        => 'Text',
				'section'     => __( 'Footer' ,'Pixelentity Theme/Plugin'),
				'description' => __( 'Link of the second button in the Call To Action section.' ,'Pixelentity Theme/Plugin'),
				'default'     => '#',
			),
		));

		$options['contactEmailFooter']['section'] = __("Footer",'Pixelentity Theme/Plugin');
		$options['contactEmailFooter']['description'] = __("Email address displayed in footer. When clicked on, it should open default email client on users device.",'Pixelentity Theme/Plugin');

		foreach( PeGlobal::$const->gmap->metabox["content"] as $key => $value ) {

			PeGlobal::$const->gmap->metabox["content"][ $key ]["section"] = __("Footer",'Pixelentity Theme/Plugin');

		}

		unset( PeGlobal::$const->gmap->metabox["content"]["title"] );
		unset( PeGlobal::$const->gmap->metabox["content"]["description"] );
		
		//$options = array_merge($options, PeGlobal::$const->gmap->metabox["content"]);

		$options = array_merge($options,$this->font->options());
		$options = array_merge($options,$this->color->options());

		//$options["retina"] =& $this->defaultOptions["retina"];
		//$options["lazyImages"] =& $this->defaultOptions["lazyImages"];
		$options["minifyJS"] =& $this->defaultOptions["minifyJS"];
		$options["minifyCSS"] =& $this->defaultOptions["minifyCSS"];

		$options["minifyJS"]['default'] = 'yes';

		$options["adminThumbs"] =& $this->defaultOptions["adminThumbs"];
		if (!empty($this->defaultOptions["mediaQuick"])) {
			$options["mediaQuick"] =& $this->defaultOptions["mediaQuick"];
			$options["mediaQuickDefault"] =& $this->defaultOptions["mediaQuickDefault"];
		}

		$options["adminLogo"] =& $this->defaultOptions["adminLogo"];
		$options["adminUrl"] =& $this->defaultOptions["adminUrl"];

		
		
		PeGlobal::$config["options"] = apply_filters("pe_theme_options",$options);

	}

	public function hero( $is_project = false ) {
		$hero = array(
			'type'     => '',
			'title'    => __( 'Header' ,'Pixelentity Theme/Plugin'),
			'priority' => 'core',
			'where'    => array(
				'post' => 'all',
			),
			'content' => array(
				'background' => array(
					'label'       => __( 'Background Image' ,'Pixelentity Theme/Plugin'),
					'type'        => 'Upload',
					'description' => __( 'Background image used in header.' ,'Pixelentity Theme/Plugin'),
					'default'     => '',
				),
			),
		);

		if ( $is_project ) {

			$hero['content']['portfolio'] = array(
				'label' => __( 'Portfolio link' ,'Pixelentity Theme/Plugin'),
				'type'  => 'Text',
				'description' => __( 'Link pointing to your porfolio page, for \'back to portfolio\' button' ,'Pixelentity Theme/Plugin'),
				'default' => '#',
			);

		}

		if ( ! $is_project ) {

			$hero['content']['alternate'] = array(
				'label' => __( 'Alternate splash' ,'Pixelentity Theme/Plugin'),
				'type'  => 'RadioUI',
				'description' => __( 'If set to yes, splash section will support custom title, subtitle and button.' ,'Pixelentity Theme/Plugin'),
				'options' => array(
					__( 'Yes' ,'Pixelentity Theme/Plugin') => 'yes',
					__( 'No' ,'Pixelentity Theme/Plugin')  => 'no',
				),
				'default' => 'no',
			);

			$hero['content']['title'] = array(
				'label' => __( 'Splash Title' ,'Pixelentity Theme/Plugin'),
				'type'  => 'Text',
				'description' => __( 'Text used as a splash title.' ,'Pixelentity Theme/Plugin'),
				'default' => '',
			);

			$hero['content']['subtitle'] = array(
				'label' => __( 'Splash Subtitle' ,'Pixelentity Theme/Plugin'),
				'type'  => 'Text',
				'description' => __( 'Text used as a splash subtitle.' ,'Pixelentity Theme/Plugin'),
				'default' => '',
			);

			$hero['content']['button_url'] = array(
				"label"       => __("Button Url",'Pixelentity Theme/Plugin'),
				"type"        => "Text",
				"description" => __("Enter the destination url of the button.",'Pixelentity Theme/Plugin'),
			);

			$hero['content']['button_text'] = array(
				"label"       => __("Button Text",'Pixelentity Theme/Plugin'),
				"type"        => "Text",
				"description" => __("Enter the button text here.",'Pixelentity Theme/Plugin'),
			);

			$hero['content']['button_new_window'] = array(
				"label"       => __("Open in new window",'Pixelentity Theme/Plugin'),
				"type"        => "RadioUI",
				"description" => __("Should the url be opened in new window?",'Pixelentity Theme/Plugin'),
				"options"     => array(
					__("Yes",'Pixelentity Theme/Plugin') => "yes",
					__("No",'Pixelentity Theme/Plugin')  => "no",
				),
				"default"     =>"no",
			);

		}

		return $hero;
	}


	public function pe_theme_metabox_config_video() {
		unset( PeGlobal::$config["metaboxes-video"]['video']['content']['fullscreen'] );
		unset( PeGlobal::$config["metaboxes-video"]['video']['content']['width'] );
	}

	public function pe_theme_metabox_config_post() {
		parent::pe_theme_metabox_config_post();

		unset( PeGlobal::$config["metaboxes-post"]['gallery']['content']['type'] );

		PeGlobal::$config["metaboxes-post"]['hero'] = $this->hero();

	}

	public function pe_theme_metabox_config_page() {
		parent::pe_theme_metabox_config_page();

		$builder = isset(PeGlobal::$config["metaboxes-page"]["builder"]) ? PeGlobal::$config["metaboxes-page"]["builder"] : false;
		$builder = $builder ? array("builder"=> $builder) : array();

		if (PE_THEME_MODE && $builder) {
			// top level builder element can only member of the "section" group
			$builder["builder"]["content"]["builder"]["allowed"] = "section";
		}

		$footerSections = array(
			"title"    => __("Footer Sections",'Pixelentity Theme/Plugin'),
			"priority" => "core",
			"where"    => array(
				"post" => "all",
			),
			"content" => array(
				"logos" => array(
					"label"       => __("Display Logos",'Pixelentity Theme/Plugin'),
					"type"        => "RadioUI",
					"description" => __('When set to "yes", logos section will be displayed above footer.','Pixelentity Theme/Plugin'),
					"options"     => array(__("Yes",'Pixelentity Theme/Plugin')=>"yes",__("No",'Pixelentity Theme/Plugin')=>""),
					"default"     => "yes",
				),
				"cta" => array(
					"label"       => __("Display Call To Action",'Pixelentity Theme/Plugin'),
					"type"        => "RadioUI",
					"description" => __('When set to "yes", call to action section will be displayed above footer.','Pixelentity Theme/Plugin'),
					"options"     => array(__("Yes",'Pixelentity Theme/Plugin')=>"yes",__("No",'Pixelentity Theme/Plugin')=>""),
					"default"     => "yes",
				),
			),
		);

		$defaultInfo = '<h2>Contact us.</h2><p>Want to make your website awesome? Just get in touch we don\'t bite.</p>';

		PeGlobal::$config["metaboxes-page"] = array_merge(
			$builder,
			array(
				'hero'           => $this->hero(),
				'footerSections' => $footerSections,
			)
		);		
	}

	public function pe_theme_metabox_config_project() {
		parent::pe_theme_metabox_config_project();

		$galleryMbox = array(
			"title"    => __("Slider",'Pixelentity Theme/Plugin'),
			"type"     => "GalleryPost",
			"priority" => "core",
			"where"    => array(
				"post" => "gallery"
			),
			"content" => array(
				"id" => PeGlobal::$const->gallery->id,
			),
		);

		PeGlobal::$config["metaboxes-project"] =  array(
			"gallery" => $galleryMbox,
			"video"   => PeGlobal::$const->video->metaboxPost,
		);

	}

	public function pe_theme_form_testimonial_supports() {

		//add_post_type_support( 'service', 'thumbnail' );
		//add_post_type_support( 'testimonial', 'thumbnail' );

	}

	public function pe_theme_form_metabox_config_project() {

		$galleries = $this->gallery->option();

		$galleries[__("Don't use gallery",'Pixelentity Theme/Plugin')] = 0;
		$galleries[__("Global",'Pixelentity Theme/Plugin')] = 00;

		PeGlobal::$config['metaboxes-project']['hero'] = $this->hero( true );

		PeGlobal::$config["metaboxes-project"]["config"] = array(
			"title"    => __("Settings",'Pixelentity Theme/Plugin'),
			"type"     => "GalleryPost",
			"priority" => "core",
			"where"    => array(
				"post" => "gallery, video, standard"
			),
			"content" => array(
				"lightbox" => array(
					"label"       => __("Open in lightbox",'Pixelentity Theme/Plugin'),
					"type"        => "RadioUI",
					"description" => __('Should this project be opened in lightbox when displayed in project page.','Pixelentity Theme/Plugin'),
					"options"     => array(
						__("Yes",'Pixelentity Theme/Plugin') => "yes",
						__("No",'Pixelentity Theme/Plugin')  => "no"
					),
					"default" => "yes",
				),
				'numbers' => array(
					"label"        =>__("Numbers",'Pixelentity Theme/Plugin'),
					"type"         =>"Items",
					"description"  => __("Add one or more number describing this project.",'Pixelentity Theme/Plugin'),
					"button_label" => __("Add Number",'Pixelentity Theme/Plugin'),
					"sortable"     => true,
					"auto"         => '5',
					"unique"       => false,
					"editable"     => false,
					"legend"       => false,
					"fields"       => array(
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
					),
					"default" => "",
				),
				"intro" => array(
					"label"       => __("Intro Text",'Pixelentity Theme/Plugin'),
					"type"        => "TextArea",
					"description" => __('Displayed above content in big font.','Pixelentity Theme/Plugin'),
					"default"     => '<h2>What we did.</h2>
<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium dolores et quas molestias..</p>',
				),
				'features' => array(
					"label"        =>__("Features",'Pixelentity Theme/Plugin'),
					"type"         =>"Items",
					"description"  => __("Add one or more features for this project.",'Pixelentity Theme/Plugin'),
					"button_label" => __("Add Feature",'Pixelentity Theme/Plugin'),
					"sortable"     => true,
					"auto"         => '5',
					"unique"       => false,
					"editable"     => false,
					"legend"       => false,
					"fields"       => array(
						array(
							"label"   => __("Icon",'Pixelentity Theme/Plugin'),
							"name"    => "icon",
							"type"    => "icon",
							"default" => "",
						),
						array(
							"label"   => __("Title",'Pixelentity Theme/Plugin'),
							"name"    => "title",
							"type"    => "text",
							"width"   => 185,
							"default" => "Title",
						),
						array(
							"name"    => "description",
							"type"    => "text",
							"width"   => 300, 
							"default" => "Description",
						),
					),
					"default" => "",
				),
				"featuresImg" => array(
					"label"       => __("Features Image",'Pixelentity Theme/Plugin'),
					"type"        => "Upload",
					"description" => __("Image displayd besides features.",'Pixelentity Theme/Plugin'),
					"default"     => ""
				),
			),
		);

		PeGlobal::$config['metaboxes-project']['footerSections'] = array(
			"title"    => __("Footer Sections",'Pixelentity Theme/Plugin'),
			"priority" => "core",
			"where"    => array(
				"post" => "all",
			),
			"content" => array(
				"logos" => array(
					"label"       => __("Display Logos",'Pixelentity Theme/Plugin'),
					"type"        => "RadioUI",
					"description" => __('When set to "yes", logos section will be displayed above footer.','Pixelentity Theme/Plugin'),
					"options"     => array(__("Yes",'Pixelentity Theme/Plugin')=>"yes",__("No",'Pixelentity Theme/Plugin')=>""),
					"default"     => "yes",
				),
				"cta" => array(
					"label"       => __("Display Call To Action",'Pixelentity Theme/Plugin'),
					"type"        => "RadioUI",
					"description" => __('When set to "yes", call to action section will be displayed above footer.','Pixelentity Theme/Plugin'),
					"options"     => array(__("Yes",'Pixelentity Theme/Plugin')=>"yes",__("No",'Pixelentity Theme/Plugin')=>""),
					"default"     => "yes",
				),
			),
		);

		unset( PeGlobal::$config["metaboxes-project"]['portfolio'] );
		unset( PeGlobal::$config["metaboxes-project"]['info'] );

	}

	public function pe_theme_metabox_config_staff_action() {

		

	}

	public function pe_theme_metabox_config_service_action() {

		

	}

	public function pe_theme_gallery_image_fields_filter( $fields ) {

		unset( $fields['video'] );
		unset( $fields['link'] );

		return $fields;

	}

	protected function init_asset() {
		return new PeThemeFormAsset($this);
	}

	protected function init_template() {
		return new PeThemeFormTemplate($this);
	}

}

function pe_theme_font_awesome_icons() {

	$font_awesome_icons = array(
		"none" => '',
		"adjust" => "fa fa-adjust",
		"adn" => "fa fa-adn",
		"align-center" => "fa fa-align-center",
		"align-justify" => "fa fa-align-justify",
		"align-left" => "fa fa-align-left",
		"align-right" => "fa fa-align-right",
		"ambulance" => "fa fa-ambulance",
		"anchor" => "fa fa-anchor",
		"android" => "fa fa-android",
		"angle-double-down" => "fa fa-angle-double-down",
		"angle-double-left" => "fa fa-angle-double-left",
		"angle-double-right" => "fa fa-angle-double-right",
		"angle-double-up" => "fa fa-angle-double-up",
		"angle-down" => "fa fa-angle-down",
		"angle-left" => "fa fa-angle-left",
		"angle-right" => "fa fa-angle-right",
		"angle-up" => "fa fa-angle-up",
		"apple" => "fa fa-apple",
		"archive" => "fa fa-archive",
		"arrow-circle-down" => "fa fa-arrow-circle-down",
		"arrow-circle-left" => "fa fa-arrow-circle-left",
		"arrow-circle-o-down" => "fa fa-arrow-circle-o-down",
		"arrow-circle-o-left" => "fa fa-arrow-circle-o-left",
		"arrow-circle-o-left" => "fa fa-arrow-circle-o-left",
		"arrow-circle-o-right" => "fa fa-arrow-circle-o-right",
		"arrow-circle-o-right" => "fa fa-arrow-circle-o-right",
		"arrow-circle-o-up" => "fa fa-arrow-circle-o-up",
		"arrow-circle-right" => "fa fa-arrow-circle-right",
		"arrow-circle-up" => "fa fa-arrow-circle-up",
		"arrow-down" => "fa fa-arrow-down",
		"arrow-left" => "fa fa-arrow-left",
		"arrow-right" => "fa fa-arrow-right",
		"arrow-up" => "fa fa-arrow-up",
		"arrows" => "fa fa-arrows",
		"arrows" => "fa fa-arrows",
		"arrows-alt" => "fa fa-arrows-alt",
		"arrows-alt" => "fa fa-arrows-alt",
		"arrows-h" => "fa fa-arrows-h",
		"arrows-h" => "fa fa-arrows-h",
		"arrows-v" => "fa fa-arrows-v",
		"arrows-v" => "fa fa-arrows-v",
		"asterisk" => "fa fa-asterisk",
		"backward" => "fa fa-backward",
		"ban" => "fa fa-ban",
		"bar-chart-o" => "fa fa-bar-chart-o",
		"barcode" => "fa fa-barcode",
		"bars" => "fa fa-bars",
		"beer" => "fa fa-beer",
		"bell" => "fa fa-bell",
		"bell-o" => "fa fa-bell-o",
		"bitbucket" => "fa fa-bitbucket",
		"bitbucket-square" => "fa fa-bitbucket-square",
		"bitcoin" => "fa fa-bitcoin",
		"bitcoin" => "fa fa-bitcoin",
		"bold" => "fa fa-bold",
		"bolt" => "fa fa-bolt",
		"book" => "fa fa-book",
		"bookmark" => "fa fa-bookmark",
		"bookmark-o" => "fa fa-bookmark-o",
		"briefcase" => "fa fa-briefcase",
		"btc" => "fa fa-btc",
		"btc" => "fa fa-btc",
		"bug" => "fa fa-bug",
		"building-o" => "fa fa-building-o",
		"bullhorn" => "fa fa-bullhorn",
		"bullseye" => "fa fa-bullseye",
		"calendar" => "fa fa-calendar",
		"calendar-o" => "fa fa-calendar-o",
		"camera" => "fa fa-camera",
		"camera-retro" => "fa fa-camera-retro",
		"caret-down" => "fa fa-caret-down",
		"caret-left" => "fa fa-caret-left",
		"caret-right" => "fa fa-caret-right",
		"caret-square-o-down" => "fa fa-caret-square-o-down",
		"caret-square-o-down" => "fa fa-caret-square-o-down",
		"caret-square-o-left" => "fa fa-caret-square-o-left",
		"caret-square-o-left" => "fa fa-caret-square-o-left",
		"caret-square-o-left" => "fa fa-caret-square-o-left",
		"caret-square-o-right" => "fa fa-caret-square-o-right",
		"caret-square-o-right" => "fa fa-caret-square-o-right",
		"caret-square-o-up" => "fa fa-caret-square-o-up",
		"caret-square-o-up" => "fa fa-caret-square-o-up",
		"caret-up" => "fa fa-caret-up",
		"certificate" => "fa fa-certificate",
		"chain" => "fa fa-chain",
		"chain-broken" => "fa fa-chain-broken",
		"check" => "fa fa-check",
		"check-circle" => "fa fa-check-circle",
		"check-circle-o" => "fa fa-check-circle-o",
		"check-square" => "fa fa-check-square",
		"check-square" => "fa fa-check-square",
		"check-square-o" => "fa fa-check-square-o",
		"check-square-o" => "fa fa-check-square-o",
		"chevron-circle-down" => "fa fa-chevron-circle-down",
		"chevron-circle-left" => "fa fa-chevron-circle-left",
		"chevron-circle-right" => "fa fa-chevron-circle-right",
		"chevron-circle-up" => "fa fa-chevron-circle-up",
		"chevron-down" => "fa fa-chevron-down",
		"chevron-left" => "fa fa-chevron-left",
		"chevron-right" => "fa fa-chevron-right",
		"chevron-up" => "fa fa-chevron-up",
		"circle" => "fa fa-circle",
		"circle" => "fa fa-circle",
		"circle-o" => "fa fa-circle-o",
		"circle-o" => "fa fa-circle-o",
		"clipboard" => "fa fa-clipboard",
		"clock-o" => "fa fa-clock-o",
		"cloud" => "fa fa-cloud",
		"cloud-download" => "fa fa-cloud-download",
		"cloud-upload" => "fa fa-cloud-upload",
		"cny" => "fa fa-cny",
		"code" => "fa fa-code",
		"code-fork" => "fa fa-code-fork",
		"coffee" => "fa fa-coffee",
		"cog" => "fa fa-cog",
		"cogs" => "fa fa-cogs",
		"columns" => "fa fa-columns",
		"comment" => "fa fa-comment",
		"comment-o" => "fa fa-comment-o",
		"comments" => "fa fa-comments",
		"comments-o" => "fa fa-comments-o",
		"compass" => "fa fa-compass",
		"compress" => "fa fa-compress",
		"copy" => "fa fa-copy",
		"credit-card" => "fa fa-credit-card",
		"crop" => "fa fa-crop",
		"crosshairs" => "fa fa-crosshairs",
		"css3" => "fa fa-css3",
		"cut" => "fa fa-cut",
		"cutlery" => "fa fa-cutlery",
		"dashboard" => "fa fa-dashboard",
		"dedent" => "fa fa-dedent",
		"desktop" => "fa fa-desktop",
		"dollar" => "fa fa-dollar",
		"dot-circle-o" => "fa fa-dot-circle-o",
		"dot-circle-o" => "fa fa-dot-circle-o",
		"dot-circle-o" => "fa fa-dot-circle-o",
		"download" => "fa fa-download",
		"dribbble" => "fa fa-dribbble",
		"dropbox" => "fa fa-dropbox",
		"edit" => "fa fa-edit",
		"eject" => "fa fa-eject",
		"ellipsis-h" => "fa fa-ellipsis-h",
		"ellipsis-v" => "fa fa-ellipsis-v",
		"envelope" => "fa fa-envelope",
		"envelope-o" => "fa fa-envelope-o",
		"eraser" => "fa fa-eraser",
		"eraser" => "fa fa-eraser",
		"eur" => "fa fa-eur",
		"euro" => "fa fa-euro",
		"exchange" => "fa fa-exchange",
		"exclamation" => "fa fa-exclamation",
		"exclamation-circle" => "fa fa-exclamation-circle",
		"exclamation-triangle" => "fa fa-exclamation-triangle",
		"expand" => "fa fa-expand",
		"external-link" => "fa fa-external-link",
		"external-link-square" => "fa fa-external-link-square",
		"eye" => "fa fa-eye",
		"eye-slash" => "fa fa-eye-slash",
		"facebook" => "fa fa-facebook",
		"facebook-square" => "fa fa-facebook-square",
		"fast-backward" => "fa fa-fast-backward",
		"fast-forward" => "fa fa-fast-forward",
		"female" => "fa fa-female",
		"fighter-jet" => "fa fa-fighter-jet",
		"file" => "fa fa-file",
		"file-o" => "fa fa-file-o",
		"file-text" => "fa fa-file-text",
		"file-text-o" => "fa fa-file-text-o",
		"files-o" => "fa fa-files-o",
		"film" => "fa fa-film",
		"filter" => "fa fa-filter",
		"fire" => "fa fa-fire",
		"fire-extinguisher" => "fa fa-fire-extinguisher",
		"flag" => "fa fa-flag",
		"flag-checkered" => "fa fa-flag-checkered",
		"flag-o" => "fa fa-flag-o",
		"flash" => "fa fa-flash",
		"flask" => "fa fa-flask",
		"flickr" => "fa fa-flickr",
		"floppy-o" => "fa fa-floppy-o",
		"folder" => "fa fa-folder",
		"folder-o" => "fa fa-folder-o",
		"folder-open" => "fa fa-folder-open",
		"folder-open-o" => "fa fa-folder-open-o",
		"font" => "fa fa-font",
		"forward" => "fa fa-forward",
		"foursquare" => "fa fa-foursquare",
		"frown-o" => "fa fa-frown-o",
		"gamepad" => "fa fa-gamepad",
		"gavel" => "fa fa-gavel",
		"gbp" => "fa fa-gbp",
		"gear" => "fa fa-gear",
		"gears" => "fa fa-gears",
		"gift" => "fa fa-gift",
		"github" => "fa fa-github",
		"github-alt" => "fa fa-github-alt",
		"github-square" => "fa fa-github-square",
		"gittip" => "fa fa-gittip",
		"glass" => "fa fa-glass",
		"globe" => "fa fa-globe",
		"google-plus" => "fa fa-google-plus",
		"google-plus-square" => "fa fa-google-plus-square",
		"group" => "fa fa-group",
		"h-square" => "fa fa-h-square",
		"hand-o-down" => "fa fa-hand-o-down",
		"hand-o-left" => "fa fa-hand-o-left",
		"hand-o-right" => "fa fa-hand-o-right",
		"hand-o-up" => "fa fa-hand-o-up",
		"hdd-o" => "fa fa-hdd-o",
		"headphones" => "fa fa-headphones",
		"heart" => "fa fa-heart",
		"heart-o" => "fa fa-heart-o",
		"home" => "fa fa-home",
		"hospital-o" => "fa fa-hospital-o",
		"html5" => "fa fa-html5",
		"inbox" => "fa fa-inbox",
		"indent" => "fa fa-indent",
		"info" => "fa fa-info",
		"info-circle" => "fa fa-info-circle",
		"inr" => "fa fa-inr",
		"instagram" => "fa fa-instagram",
		"italic" => "fa fa-italic",
		"jpy" => "fa fa-jpy",
		"key" => "fa fa-key",
		"keyboard-o" => "fa fa-keyboard-o",
		"krw" => "fa fa-krw",
		"laptop" => "fa fa-laptop",
		"leaf" => "fa fa-leaf",
		"legal" => "fa fa-legal",
		"lemon-o" => "fa fa-lemon-o",
		"level-down" => "fa fa-level-down",
		"level-up" => "fa fa-level-up",
		"lightbulb-o" => "fa fa-lightbulb-o",
		"link" => "fa fa-link",
		"linkedin" => "fa fa-linkedin",
		"linkedin-square" => "fa fa-linkedin-square",
		"linux" => "fa fa-linux",
		"list" => "fa fa-list",
		"list-alt" => "fa fa-list-alt",
		"list-ol" => "fa fa-list-ol",
		"list-ul" => "fa fa-list-ul",
		"location-arrow" => "fa fa-location-arrow",
		"lock" => "fa fa-lock",
		"long-arrow-down" => "fa fa-long-arrow-down",
		"long-arrow-left" => "fa fa-long-arrow-left",
		"long-arrow-right" => "fa fa-long-arrow-right",
		"long-arrow-up" => "fa fa-long-arrow-up",
		"magic" => "fa fa-magic",
		"magnet" => "fa fa-magnet",
		"mail-forward" => "fa fa-mail-forward",
		"mail-reply" => "fa fa-mail-reply",
		"mail-reply-all" => "fa fa-mail-reply-all",
		"male" => "fa fa-male",
		"map-marker" => "fa fa-map-marker",
		"maxcdn" => "fa fa-maxcdn",
		"medkit" => "fa fa-medkit",
		"meh-o" => "fa fa-meh-o",
		"microphone" => "fa fa-microphone",
		"microphone-slash" => "fa fa-microphone-slash",
		"minus" => "fa fa-minus",
		"minus-circle" => "fa fa-minus-circle",
		"minus-square" => "fa fa-minus-square",
		"minus-square" => "fa fa-minus-square",
		"minus-square-o" => "fa fa-minus-square-o",
		"minus-square-o" => "fa fa-minus-square-o",
		"mobile" => "fa fa-mobile",
		"mobile-phone" => "fa fa-mobile-phone",
		"money" => "fa fa-money",
		"money" => "fa fa-money",
		"moon-o" => "fa fa-moon-o",
		"music" => "fa fa-music",
		"outdent" => "fa fa-outdent",
		"pagelines" => "fa fa-pagelines",
		"pagelines" => "fa fa-pagelines",
		"paperclip" => "fa fa-paperclip",
		"paste" => "fa fa-paste",
		"pause" => "fa fa-pause",
		"pencil" => "fa fa-pencil",
		"pencil-square" => "fa fa-pencil-square",
		"pencil-square-o" => "fa fa-pencil-square-o",
		"phone" => "fa fa-phone",
		"phone-square" => "fa fa-phone-square",
		"picture-o" => "fa fa-picture-o",
		"pinterest" => "fa fa-pinterest",
		"pinterest-square" => "fa fa-pinterest-square",
		"plane" => "fa fa-plane",
		"play" => "fa fa-play",
		"play-circle" => "fa fa-play-circle",
		"play-circle-o" => "fa fa-play-circle-o",
		"plus" => "fa fa-plus",
		"plus-circle" => "fa fa-plus-circle",
		"plus-square" => "fa fa-plus-square",
		"plus-square" => "fa fa-plus-square",
		"plus-square" => "fa fa-plus-square",
		"plus-square-o" => "fa fa-plus-square-o",
		"plus-square-o" => "fa fa-plus-square-o",
		"plus-square-o" => "fa fa-plus-square-o",
		"power-off" => "fa fa-power-off",
		"print" => "fa fa-print",
		"puzzle-piece" => "fa fa-puzzle-piece",
		"qrcode" => "fa fa-qrcode",
		"question" => "fa fa-question",
		"question-circle" => "fa fa-question-circle",
		"quote-left" => "fa fa-quote-left",
		"quote-right" => "fa fa-quote-right",
		"random" => "fa fa-random",
		"refresh" => "fa fa-refresh",
		"renren" => "fa fa-renren",
		"repeat" => "fa fa-repeat",
		"reply" => "fa fa-reply",
		"reply-all" => "fa fa-reply-all",
		"retweet" => "fa fa-retweet",
		"rmb" => "fa fa-rmb",
		"road" => "fa fa-road",
		"rocket" => "fa fa-rocket",
		"rotate-left" => "fa fa-rotate-left",
		"rotate-right" => "fa fa-rotate-right",
		"rouble" => "fa fa-rouble",
		"rouble" => "fa fa-rouble",
		"rss" => "fa fa-rss",
		"rss-square" => "fa fa-rss-square",
		"rub" => "fa fa-rub",
		"rub" => "fa fa-rub",
		"ruble" => "fa fa-ruble",
		"ruble" => "fa fa-ruble",
		"rupee" => "fa fa-rupee",
		"save" => "fa fa-save",
		"scissors" => "fa fa-scissors",
		"search" => "fa fa-search",
		"search-minus" => "fa fa-search-minus",
		"search-plus" => "fa fa-search-plus",
		"share" => "fa fa-share",
		"share-square" => "fa fa-share-square",
		"share-square-o" => "fa fa-share-square-o",
		"shield" => "fa fa-shield",
		"shopping-cart" => "fa fa-shopping-cart",
		"sign-in" => "fa fa-sign-in",
		"sign-out" => "fa fa-sign-out",
		"signal" => "fa fa-signal",
		"sitemap" => "fa fa-sitemap",
		"skype" => "fa fa-skype",
		"smile-o" => "fa fa-smile-o",
		"sort" => "fa fa-sort",
		"sort-alpha-asc" => "fa fa-sort-alpha-asc",
		"sort-alpha-desc" => "fa fa-sort-alpha-desc",
		"sort-amount-asc" => "fa fa-sort-amount-asc",
		"sort-amount-desc" => "fa fa-sort-amount-desc",
		"sort-asc" => "fa fa-sort-asc",
		"sort-desc" => "fa fa-sort-desc",
		"sort-down" => "fa fa-sort-down",
		"sort-numeric-asc" => "fa fa-sort-numeric-asc",
		"sort-numeric-desc" => "fa fa-sort-numeric-desc",
		"sort-up" => "fa fa-sort-up",
		"spinner" => "fa fa-spinner",
		"square" => "fa fa-square",
		"square" => "fa fa-square",
		"square-o" => "fa fa-square-o",
		"square-o" => "fa fa-square-o",
		"stack-exchange" => "fa fa-stack-exchange",
		"stack-exchange" => "fa fa-stack-exchange",
		"stack-overflow" => "fa fa-stack-overflow",
		"star" => "fa fa-star",
		"star-half" => "fa fa-star-half",
		"star-half-empty" => "fa fa-star-half-empty",
		"star-half-full" => "fa fa-star-half-full",
		"star-half-o" => "fa fa-star-half-o",
		"star-o" => "fa fa-star-o",
		"step-backward" => "fa fa-step-backward",
		"step-forward" => "fa fa-step-forward",
		"stethoscope" => "fa fa-stethoscope",
		"stop" => "fa fa-stop",
		"strikethrough" => "fa fa-strikethrough",
		"subscript" => "fa fa-subscript",
		"suitcase" => "fa fa-suitcase",
		"sun-o" => "fa fa-sun-o",
		"superscript" => "fa fa-superscript",
		"table" => "fa fa-table",
		"tablet" => "fa fa-tablet",
		"tachometer" => "fa fa-tachometer",
		"tag" => "fa fa-tag",
		"tags" => "fa fa-tags",
		"tasks" => "fa fa-tasks",
		"terminal" => "fa fa-terminal",
		"text-height" => "fa fa-text-height",
		"text-width" => "fa fa-text-width",
		"th" => "fa fa-th",
		"th-large" => "fa fa-th-large",
		"th-list" => "fa fa-th-list",
		"thumb-tack" => "fa fa-thumb-tack",
		"thumbs-down" => "fa fa-thumbs-down",
		"thumbs-o-down" => "fa fa-thumbs-o-down",
		"thumbs-o-up" => "fa fa-thumbs-o-up",
		"thumbs-up" => "fa fa-thumbs-up",
		"ticket" => "fa fa-ticket",
		"times" => "fa fa-times",
		"times-circle" => "fa fa-times-circle",
		"times-circle-o" => "fa fa-times-circle-o",
		"tint" => "fa fa-tint",
		"toggle-down" => "fa fa-toggle-down",
		"toggle-down" => "fa fa-toggle-down",
		"toggle-left" => "fa fa-toggle-left",
		"toggle-left" => "fa fa-toggle-left",
		"toggle-left" => "fa fa-toggle-left",
		"toggle-right" => "fa fa-toggle-right",
		"toggle-right" => "fa fa-toggle-right",
		"toggle-up" => "fa fa-toggle-up",
		"toggle-up" => "fa fa-toggle-up",
		"trash-o" => "fa fa-trash-o",
		"trello" => "fa fa-trello",
		"trophy" => "fa fa-trophy",
		"truck" => "fa fa-truck",
		"try" => "fa fa-try",
		"try" => "fa fa-try",
		"tumblr" => "fa fa-tumblr",
		"tumblr-square" => "fa fa-tumblr-square",
		"turkish-lira" => "fa fa-turkish-lira",
		"turkish-lira" => "fa fa-turkish-lira",
		"twitter" => "fa fa-twitter",
		"twitter-square" => "fa fa-twitter-square",
		"umbrella" => "fa fa-umbrella",
		"underline" => "fa fa-underline",
		"undo" => "fa fa-undo",
		"unlink" => "fa fa-unlink",
		"unlock" => "fa fa-unlock",
		"unlock-alt" => "fa fa-unlock-alt",
		"unsorted" => "fa fa-unsorted",
		"upload" => "fa fa-upload",
		"usd" => "fa fa-usd",
		"user" => "fa fa-user",
		"user-md" => "fa fa-user-md",
		"users" => "fa fa-users",
		"video-camera" => "fa fa-video-camera",
		"vimeo-square" => "fa fa-vimeo-square",
		"vimeo-square" => "fa fa-vimeo-square",
		"vk" => "fa fa-vk",
		"volume-down" => "fa fa-volume-down",
		"volume-off" => "fa fa-volume-off",
		"volume-up" => "fa fa-volume-up",
		"warning" => "fa fa-warning",
		"weibo" => "fa fa-weibo",
		"wheelchair" => "fa fa-wheelchair",
		"wheelchair" => "fa fa-wheelchair",
		"wheelchair" => "fa fa-wheelchair",
		"windows" => "fa fa-windows",
		"won" => "fa fa-won",
		"wrench" => "fa fa-wrench",
		"xing" => "fa fa-xing",
		"xing-square" => "fa fa-xing-square",
		"yen" => "fa fa-yen",
		"youtube" => "fa fa-youtube",
		"youtube-play" => "fa fa-youtube-play",
		"youtube-play" => "fa fa-youtube-play",
		"youtube-square" => "fa fa-youtube-square",
	);

	return $font_awesome_icons;

}