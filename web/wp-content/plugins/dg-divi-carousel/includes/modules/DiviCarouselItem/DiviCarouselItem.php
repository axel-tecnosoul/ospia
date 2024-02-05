<?php
require_once ( DICA_MAIN_DIR . '/functions/extends.php');

class DiviCarouselItem extends ET_Builder_Module {

	public $slug       = 'dica_divi_carouselitem';
	public $vb_support = 'on';
	public $type       = 'child';
	// Module item's attribute that will be used for module item label on modal
	public $child_title_var          = 'title';
	public $child_title_fallback_var = 'admin_label';


	protected $module_credits = array(
		'module_uri' => 'https://www.divigear.com/',
		'author'     => 'DiviGear',
		'author_uri' => 'https://www.divigear.com',
	);

	public function init() {
		$this->name = esc_html__( 'Carousel Item', 'et_builder' );	
		$this->main_css_element = '%%order_class%%';
	}
	public function get_settings_modal_toggles(){
		return array(
			'general'  => array(
					'toggles' => array(
							'main_content' 					=> esc_html__( 'Main Content', 'et_builder' ),
							'link' 							=> esc_html__( 'Title & Image Link', 'et_builder' ),
							'button_settings' 				=> esc_html__( 'Button Settings', 'et_builder' ),
							'image_settings'				=> esc_html__( 'Image Settings', 'et_builder'),
							'meta'							=> esc_html__( 'Meta', 'et_builder' ),
					),
			),
			'advanced'  =>  array(
					'toggles'   =>  array(
							'image_styles'				=> esc_html__('Image Styles', 'et_builder'),
							'image_filter'				=> esc_html__('Image Filter', 'et_builder'),
							'icon_settings'				=> esc_html__('Icon settings', 'et_builder'),
							'custom_spacing'			=> esc_html__('Image Spacing', 'et_buitlder'),
							'title_style'          		=> esc_html__('Title Style', 'et_builder'),
							'subtitle_style'          	=> esc_html__('Subtitle Style', 'et_builder'),
							'content_style'          	=> esc_html__('Content Style', 'et_builder'),
							'button'          			=> esc_html__('Button', 'et_builder'),
							'social_media_style'		=> esc_html__('Social Media Style', 'et_buitlder'),
							'rating_style'				=> esc_html__('Rating Style', 'et_buitlder'),
							'dg_custom_spacing'			=> esc_html__('Spacing', 'et_buitlder'),
					)
			),
			// Advance tab's slug is "custom_css"
			'custom_css' => array(
				'toggles' => array(
					'limitation' => esc_html__( 'Limitation', 'et_builder' ), // totally made up
				),
			),
		);
	}

	public function get_fields() {
		$_ex 	= "DICA_Extends";
		$general = array(
			'title' => array(
				'label'           	=> esc_html__( 'Title', 'et_builder' ),
				'type'            	=> 'text',
				'option_category' 	=> 'basic_option',
				'description'     	=> esc_html__( 'Title entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     	=> 'main_content',
			),
			'sub_title' => array(
				'label'           	=> esc_html__( 'Subtitle', 'et_builder' ),
				'type'            	=> 'text',
				'option_category' 	=> 'basic_option',
				'description'     	=> esc_html__( 'Subtitle entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     	=> 'main_content',
			),
			'content' => array(
				'label'           => esc_html__( 'Content', 'et_builder' ),
				'type'            => 'tiny_mce',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Content entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     => 'main_content',
			),
			// link
			'url' => array(
				'label'           => esc_html__( 'Url', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'If you would like to make your blurb a link, input your destination URL here.', 'et_builder' ),
				'toggle_slug'     => 'link',
			),
			'url_new_window' => array(
				'label'           => esc_html__( 'Url Opens', 'et_builder' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => esc_html__( 'In The Same Window', 'et_builder' ),
					'on'  => esc_html__( 'In The New Tab', 'et_builder' ),
				),
				'toggle_slug'     => 'link',
				'description'     => esc_html__( 'Here you can choose whether or not your link opens in a new window', 'et_builder' ),
				'default_on_front'=> 'off',
			),
			'admin_label' => array(
				'label'           => esc_html__( 'Admin Label', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'admin_label',
				'default_on_front'=> 'Carousel Item',
			),
			// button srettings
			'button_text' => array(
				'label'           => esc_html__( 'Button Text', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your desired button text, or leave blank for no button.', 'et_builder' ),
				'toggle_slug'     => 'button_settings',
			),
			'button_url' => array(
				'label'           => esc_html__( 'Button URL', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input URL for your button.', 'et_builder' ),
				'toggle_slug'     => 'button_settings',
			),
			'button_url_new_window' => array(
				'default'         => 'off',
				'default_on_front'=> true,
				'label'           => esc_html__( 'Url Opens', 'et_builder' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => esc_html__( 'In The Same Window', 'et_builder' ),
					'on'  => esc_html__( 'In The New Tab', 'et_builder' ),
				),
				'toggle_slug'     => 'button_settings',
				'description'     => esc_html__( 'Choose whether your link opens in a new window or not', 'et_builder' ),
			),
			
			// image settings
			'use_icon' => array(
				'label'           => esc_html__( 'Use Icon', 'et_builder' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'     => 'image_settings',
				'affects'         => array(
					'image',
					'image_alt',
					'font_icon',
					'icon_color',
					'use_circle',
					'use_icon_font_size',
					'icon_alignment'
				),
				'description' => esc_html__( 'Here you can choose whether icon set below should be used.', 'et_builder' ),
				'default_on_front'=> 'off',
			),
			'font_icon' => array(
				'label'               => esc_html__( 'Icon', 'et_builder' ),
				'type'                => 'select_icon',
				'option_category'     => 'basic_option',
				'class'               => array( 'et-pb-font-icon' ),
				'toggle_slug'         => 'image_settings',
				'description'         => esc_html__( 'Choose an icon to display with your blurb.', 'et_builder' ),
				'depends_show_if'     => 'on',
			),
			'icon_color' => array(
				'default'           => "#2ea3f2",
				'default_on_front'	=> true,
				'label'             => esc_html__( 'Icon Color', 'et_builder' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'et_builder' ),
				'depends_show_if'   => 'on',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'icon_settings',
			),
			'use_circle' => array(
				'label'           => esc_html__( 'Circle Icon', 'et_builder' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'affects'           => array(
					'use_circle_border',
					'circle_color',
				),
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'icon_settings',
				'description'      => esc_html__( 'Here you can choose whether icon set above should display within a circle.', 'et_builder' ),
				'depends_show_if'  => 'on',
				'default_on_front'=> 'off',
			),
			'circle_color' => array(
				'default'         => "#2ea3f2",
				'label'           => esc_html__( 'Circle Color', 'et_builder' ),
				'type'            => 'color-alpha',
				'description'     => esc_html__( 'Here you can define a custom color for the icon circle.', 'et_builder' ),
				'depends_show_if' => 'on',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'icon_settings',
			),
			'use_circle_border' => array(
				'label'           => esc_html__( 'Show Circle Border', 'et_builder' ),
				'type'            => 'yes_no_button',
				'option_category' => 'layout',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'affects'           => array(
					'circle_border_color',
				),
				'description' => esc_html__( 'Here you can choose whether if the icon circle border should display.', 'et_builder' ),
				'depends_show_if'   => 'on',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'icon_settings',
				'default_on_front'  => 'off',
			),
			'circle_border_color' => array(
				'default'         => "#2ea3f2",
				'label'           => esc_html__( 'Circle Border Color', 'et_builder' ),
				'type'            => 'color-alpha',
				'description'     => esc_html__( 'Here you can define a custom color for the icon circle border.', 'et_builder' ),
				'depends_show_if' => 'on',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'icon_settings',
			),
			'use_icon_font_size' => array(
				'label'           => esc_html__( 'Use Icon Font Size', 'et_builder' ),
				'type'            => 'yes_no_button',
				'option_category' => 'font_option',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'affects'     => array(
					'icon_font_size',
				),
				'depends_show_if' => 'on',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'icon_settings',
				'default_on_front'=> 'off',
			),
			'icon_font_size' => array(
				'label'           => esc_html__( 'Icon Font Size', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'font_option',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'icon_settings',
				'default'         => '96px',
				'default_unit'    => 'px',
				'default_on_front'=> '',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '120',
					'step' => '1',
				),
				'mobile_options'  => true,
				'depends_show_if' => 'on',
				'responsive'      => true,
			),
			'icon_alignment' => array(
				'label'           => esc_html__( 'Icon alignment', 'et_builder' ),
				'type'            => 'text_align',
				'options'         => et_builder_get_text_orientation_options(array( 'justified' )),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'icon_settings',
				'depends_show_if' => 'on',
				'default'		  => 'center'	
			),
			'image' => array(
				'label'              => esc_html__( 'Image', 'et_builder' ),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
				'depends_show_if'    => 'off',
				'description'        => esc_html__( 'Upload an image to display at the top of your blurb.', 'et_builder' ),
				'toggle_slug'        => 'image_settings',
			),
			'image_alt'				=> array(
				'label'				=> esc_html__('Image alt text', 'et_builder'),
				'type'				=> 'text',
				'option_category'    => 'basic_option',
				'toggle_slug'        => 'image_settings',
				'depends_show_if'    => 'off',
			),
			// 'image_position'		=> array(
			// 	'label'			=> esc_html('Image Position', 'et_builder'),
			// 	'type'			=> 'hidden',
			// 	'toggle_slug'	=> 'image_settings'
			// ),
			'image_lightbox'		=> array(
				'label'					=> esc_html__('Open in lightbox', 'et_builder'),
				'type'					=> 'yes_no_button',
				'options'         => array(
					'off'	=> esc_html('No', 'et_builder'),
					'on'	=> esc_html('Yes', 'et_builder')
				),
				'option_category'    	=> 'basic_option',
				'toggle_slug'        	=> 'image_settings',
				'depends_show_if'    	=> 'off',
				'show_if'         => array(
					'use_icon' => 'off'
				),
			),
			// 'image_padding'		=> array(
			// 	'label'				=> esc_html__('Image Padding', 'et_builder'),
			// 	'type'				=> 'custom_margin',
			// 	// 'option_category'    => 'basic_option',
			// 	'toggle_slug'        => 'margin_padding',
			// 	'tab_slug'		=> 'advanced',
			// 	// 'default'		=>	'0|0|0|0'
			// ),
			// 'content_padding'		=> array(
			// 	'label'				=> esc_html__('Content Padding', 'et_builder'),
			// 	'type'				=> 'custom_margin',
			// 	// 'option_category'    => 'basic_option',
			// 	'toggle_slug'        => 'margin_padding',
			// 	'tab_slug'		=> 'advanced',
			// 	// 'default'		=>	'0|0|0|0'
			// )
			'module_id' => array(
				'label'           	=> esc_html__( 'CSS ID', 'et_builder' ),
				'type'            	=> 'text',
				'toggle_slug'     	=> 'classes',
				'tab_slug'        	=> 'custom_css',
				'description'      => esc_html__( 'Assign a unique CSS ID to the element which can be used to assign custom CSS styles from within your child theme or from within Divi\'s custom CSS inputs.', 'et_builder' ),
			),
			'module_class' => array(
				'label'           	=> esc_html__( 'CSS CLASS', 'et_builder' ),
				'type'            	=> 'text',
				'toggle_slug'     	=> 'classes',
				'tab_slug'        	=> 'custom_css',
				'description'      => esc_html__( 'Assign any number of CSS Classes to the element, separated by spaces, which can be used to assign custom CSS styles from within your child theme or from within Divi\'s custom CSS inputs.', 'et_builder' ),
			),
		);
		$image_style_settings = array(
			'image_position'	=> array(
				'label'				=> 	esc_html__('Image position', 'et_builder'),
				'type'				=>	'select',
				'options'           => array(
					'image_top' 		=> esc_html__( 'Top', 'et_builder' ),
					'image_bottom' 		=> esc_html__( 'Bottom', 'et_builder' ),
					'image_left' 		=> esc_html__( 'Left', 'et_builder' ),
					'image_right' 		=> esc_html__( 'Right', 'et_builder' ),
					'image_under_title' => esc_html__( 'Inside Content', 'et_builder' ),
				),
				'tab_slug'        	=>  'advanced',
				'toggle_slug'		=>  'image_styles',
				'default'			=>  'image_top',
			),
			'image_size' => array(
				'label'           => esc_html__( 'Image Width by %', 'et_builder' ),
				'type'            => 'range',
				'mobile_options'    => true,
                'responsive'        => true,
                'default'           => '50',
                // 'default_on_front'  => '50%',
                'default_unit'      => '%',
				'range_settings '   => array(
                    'min'       => '0',
                    'max'       => '100',
                    'step'      => '1',
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'image_styles',
				'show_if_not'         => array(
					'image_position' => array('image_top', 'image_bottom', 'image_under_title'),
				),
			),
			'tablet_on_top' => array(
				'label'           => esc_html__( 'Tablet on top', 'et_builder' ),
				'type'            => 'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'image_styles',
				'default'=> 'off',
				'show_if_not'         => array(
					'image_position' => array('image_top', 'image_bottom', 'image_under_title'),
				),
			),
			'mobile_on_top' => array(
				'label'           => esc_html__( 'Mobile on top', 'et_builder' ),
				'type'            => 'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'image_styles',
				'default'=> 'off',
				'show_if_not'         => array(
					'image_position' => array('image_top', 'image_bottom', 'image_under_title'),
					'tablet_on_top'  => 'on'
				),
			),
		);
		$title = array(
			'title_position'	=> array(
				'label'				=> 	esc_html__('Title Position', 'et_builder'),
				'type'				=>	'select',
				'options'           => array(
					'default' 		=> esc_html__( 'Default', 'et_builder' ),
					'bottom' 		=> esc_html__( 'Bottom', 'et_builder' ),
				),
				'tab_slug'        	=>  'advanced',
				'toggle_slug'		=>  'title_style',
				'default'			=>  'default',
			),
		);
		$subtitle = array(
			'subtitle_position'	=> array(
				'label'				=> 	esc_html__('Subtitle Position', 'et_builder'),
				'type'				=>	'select',
				'options'           => array(
					'default' 		=> esc_html__( 'Default', 'et_builder' ),
					'bottom' 		=> esc_html__( 'Bottom', 'et_builder' ),
				),
				'tab_slug'        	=>  'advanced',
				'toggle_slug'		=>  'subtitle_style',
				'default'			=>  'default',
			),
		);
		$meta 	= array(
			'use_social_media' => array(
				'label'           => esc_html__( 'Use Social Media', 'et_builder' ),
				'type'            => 'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'       => 'meta',
				'default'  => 'off',
				'show_if_not'         => array(
					'use_rating' => 'on',
				),
			),
			'use_rating' => array(
				'label'           => esc_html__( 'Use Rating', 'et_builder' ),
				'type'            => 'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'       => 'meta',
				'default'  => 'off',
				'show_if_not'         => array(
					'use_social_media' => 'on',
				),
			),
			'facebook_url'		=> array(
				'label'				=> esc_html__('Facebook Url', 'et_builder'),
				'type'				=> 'text',
				'toggle_slug'		=> 'meta',
				'show_if'         => array(
					'use_social_media' => 'on',
				),
			),
			'twitter_url'		=> array(
				'label'				=> esc_html__('Twitter Url', 'et_builder'),
				'type'				=> 'text',
				'toggle_slug'		=> 'meta',
				'show_if'         => array(
					'use_social_media' => 'on',
				),
			),
			'linkedin_url'		=> array(
				'label'				=> esc_html__('Linkedin Url', 'et_builder'),
				'type'				=> 'text',
				'toggle_slug'		=> 'meta',
				'show_if'         => array(
					'use_social_media' => 'on',
				),
			),
			'instagram_url'		=> array(
				'label'				=> esc_html__('Instagram Url', 'et_builder'),
				'type'				=> 'text',
				'toggle_slug'		=> 'meta',
				'show_if'         => array(
					'use_social_media' => 'on',
				),
			),
			'email_address'		=> array(
				'label'				=> esc_html__('Email Address', 'et_builder'),
				'type'				=> 'text',
				'toggle_slug'		=> 'meta',
				'show_if'         => array(
					'use_social_media' => 'on',
				),
			),
			'rating_number'	=> array(
				'label'				=> 	esc_html__('Rating', 'et_builder'),
				'type'				=>	'select',
				'options'           => array(
					'1' 		=> esc_html__( 'One', 'et_builder' ),
					'2' 		=> esc_html__( 'Two', 'et_builder' ),
					'3' 		=> esc_html__( 'Three', 'et_builder' ),
					'4' 		=> esc_html__( 'Four', 'et_builder' ),
					'5' 		=> esc_html__( 'Five', 'et_builder' ),
				),
				'toggle_slug'		=>  'meta',
				'default'			=>  '5',
				'show_if'			=> array (
					'use_rating' => 'on'
				)
			)
		);
		$social_media_style = array(
			'social_media_alignment' => array(
				'label'				=> 	esc_html__('Alignment', 'et_builder'),
				'type'				=> 'text_align',
				// 'options'         	=>  et_builder_get_text_orientation_options( array( 'justified' ) ),
				'options'         	=>  et_builder_get_text_orientation_options(  ),
				'toggle_slug'		=> 'social_media_style',
				'tab_slug'        	=> 'advanced',
				'default'			=> 'left',
				'default_on_front'	=> 'left'
			),
			'social_media_position' => array(
				'label'				=> 	esc_html__('Position', 'et_builder'),
				'type'				=> 'select',
				'options'           => array(
					'sm-top' 				=> esc_html__( 'Top', 'et_builder' ),
					'sm-under-title' 		=> esc_html__( 'Middle', 'et_builder' ),
					'sm-bottom' 			=> esc_html__( 'Bottom', 'et_builder' ),
				),
				'toggle_slug'		=> 'social_media_style',
				'tab_slug'        	=> 'advanced',
				'default'			=> 'sm-bottom',
				'default_on_front'	=> 'sm-bottom'
			),
			'social_icon_size' => array(
				'label'           => esc_html__( 'Icon size', 'et_builder' ),
				'type'            => 'range',
				'mobile_options'    => true,
                'responsive'        => true,
                'default'           => '14px',
                'default_unit'      => 'px',
				'range_settings '   => array(
                    'min'       => '0',
                    'max'       => '100',
                    'step'      => '1',
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'social_media_style',
			),
			'social_color_setting'		=> array(
				'label'        			=> esc_html__( 'Color & Background color settings', 'et_builder' ),
				'toggle_slug'			=> 'social_media_style',
				'tab_slug'        		=> 'advanced',
				'type'              	=> 'composite',
				'composite_type'    	=> 'default',
				'composite_structure'	=> array(
					'color' => array(
						'label'    => esc_html( 'Color', 'et_builder' ),
						'controls' => array(
							'facebook_color' => array(
								'label' => esc_html__( 'Facebook Color', 'et_builder' ),
								'type'  => 'color-alpha',
								'hover'	=> 'tabs',
							),
							'twitter_color' => array(
								'label' => esc_html__( 'Twitter Color', 'et_builder' ),
								'type'  => 'color-alpha',
								'hover'	=> 'tabs',
							),
							'linkedin_color' => array(
								'label' => esc_html__( 'Linkedin Color', 'et_builder' ),
								'type'  => 'color-alpha',
								'hover'	=> 'tabs',
							),
							'instagram_color' => array(
								'label' => esc_html__( 'Instagram Color', 'et_builder' ),
								'type'  => 'color-alpha',
								'hover'	=> 'tabs',
							),
							'email_color' => array(
								'label' => esc_html__( 'Email Color', 'et_builder' ),
								'type'  => 'color-alpha',
								'hover'	=> 'tabs',
							)
						),
					),
					'background' => array(
						'label'    => esc_html( 'Background', 'et_builder' ),
						'controls' => array(
							'facebook_bgcolor' => array(
								'label' => esc_html__( 'Facebook Background Color', 'et_builder' ),
								'type'  => 'color-alpha',
								'hover'	=> 'tabs',
							),
							'twitter_bgcolor' => array(
								'label' => esc_html__( 'Twitter Background Color', 'et_builder' ),
								'type'  => 'color-alpha',
								'hover'	=> 'tabs',
							),
							'linkedin_bgcolor' => array(
								'label' => esc_html__( 'Linkedin Background Color', 'et_builder' ),
								'type'  => 'color-alpha',
								'hover'	=> 'tabs',
							),
							'instagram_bgcolor' => array(
								'label' => esc_html__( 'Instagram Background Color', 'et_builder' ),
								'type'  => 'color-alpha',
								'hover'	=> 'tabs',
							),
							'email_bgcolor' => array(
								'label' => esc_html__( 'Email Background Color', 'et_builder' ),
								'type'  => 'color-alpha',
								'hover'	=> 'tabs',
							)
						),
					),
				)
			)
		);
		$rating_style	=	array(
			'rating_alignment' => array(
				'label'				=> 	esc_html__('Alignment', 'et_builder'),
				'type'				=> 'text_align',
				'options'         	=>  et_builder_get_text_orientation_options( array( 'justified' ) ),
				// 'options'         	=>  et_builder_get_text_orientation_options(  ),
				'toggle_slug'		=> 'rating_style',
				'tab_slug'        	=> 'advanced',
				'default'			=> 'left',
				'default_on_front'	=> 'left'
			),
			'rating_position' => array(
				'label'				=> 	esc_html__('Position', 'et_builder'),
				'type'				=> 'select',
				'options'           => array(
					'rating-top' 				=> esc_html__( 'Top', 'et_builder' ),
					'rating-under-title' 		=> esc_html__( 'Middle', 'et_builder' ),
					'rating-bottom' 			=> esc_html__( 'Bottom', 'et_builder' ),
				),
				'toggle_slug'		=> 'rating_style',
				'tab_slug'        	=> 'advanced',
				'default'			=> 'rating-bottom',
				'default_on_front'	=> 'rating-bottom'
			),
			'rating_icon_size' => array(
				'label'           => esc_html__( 'Rating icon size', 'et_builder' ),
				'type'            => 'range',
				'mobile_options'    => true,
                'responsive'        => true,
                'default'           => '14px',
                'default_unit'      => 'px',
				'range_settings '   => array(
                    'min'       => '0',
                    'max'       => '100',
                    'step'      => '1',
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'rating_style',
			),
			'rating_color' => array(
				'label' 			=> esc_html__( 'Rating Color', 'et_builder' ),
				'type'  			=> 'color-alpha',
				'hover'				=> 'tabs',
				'toggle_slug'		=> 'rating_style',
				'tab_slug'        	=> 'advanced',
			),
			'blank_color' => array(
				'label' 			=> esc_html__( 'Blank Color', 'et_builder' ),
				'type'  			=> 'color-alpha',
				'hover'				=> 'tabs',
				'toggle_slug'		=> 'rating_style',
				'tab_slug'        	=> 'advanced',
			),
		);
		$image_padding = $_ex::add_margin_padding_field(
			'image_padding',
			'Image Padding',
			'dg_custom_spacing',
			null
		);
		$content_padding = $_ex::add_margin_padding_field(
			'content_padding',
			'Content Padding',
			'dg_custom_spacing',
			null
		);
		$button_margin = $_ex::add_margin_padding_field(
			'button_margin',
			'Button Margin',
			'dg_custom_spacing',
			null
		);
		$button_padding = $_ex::add_margin_padding_field(
			'button_padding',
			'Button Padding',
			'dg_custom_spacing',
			null
		);
		$item_margin = $_ex::add_margin_padding_field(
			'custom_margin',
			'Margin',
			'dg_custom_spacing',
			null
		);
		$item_padding = $_ex::add_margin_padding_field(
			'custom_padding',
			'Padding',
			'dg_custom_spacing',
			null
		);
		return array_merge(
			$general,
			$title,
			$subtitle,
			$meta,
			$image_style_settings,
			$social_media_style,
			$rating_style,
			$image_padding,
			$content_padding,
			$button_margin,
			$button_padding,
			$item_margin,
			$item_padding
		);
	}
	public function get_custom_css_fields_config() {
		return array(
			'inner_wrapper' => array(
				'label'    => esc_html__( 'Inner Wrapper', 'et_builder' ),
				'selector' => '%%order_class%% > div:first-of-type',
			),
			'image' => array(
				'label'    => esc_html__( 'Image', 'et_builder' ),
				'selector' => '%%order_class%% > div:first-of-type .dica-image-container img',
			),
		);
	}
	public function get_advanced_fields_config() {
		$advanced_fields = array();
		// $advanced_fields['background'] = false;
		$advanced_fields['fonts']  = array(
			// Title
			'header'   => array(
				'label'         => esc_html__( 'Title', 'et_builder' ),
				'toggle_slug'   => 'title_style',
				'tab_slug'		=> 'advanced',
				'hide_text_shadow'  => true,
				'header_level' => array(
					'default' => 'h4',
				),
				'line_height' => array(
					'default' => '1em',
				),
				'font_size' => array(
					'default' => '20px',
				),
				'css'      => array(
					'main' => ".dica_divi_carousel {$this->main_css_element}.dica_divi_carouselitem .dica-item-content h4.item-title,
					.dica_divi_carousel {$this->main_css_element}.dica_divi_carouselitem .dica-item-content h1.item-title,
					.dica_divi_carousel {$this->main_css_element}.dica_divi_carouselitem .dica-item-content h2.item-title,
					.dica_divi_carousel {$this->main_css_element}.dica_divi_carouselitem .dica-item-content h3.item-title,
					.dica_divi_carousel {$this->main_css_element}.dica_divi_carouselitem .dica-item-content h5.item-title,
					.dica_divi_carousel {$this->main_css_element}.dica_divi_carouselitem .dica-item-content h6.item-title",
					'important' => 'all',
				),
				
			),
			// Title
			'subtitle'   => array(
				'label'         => esc_html__( 'Subtitle', 'et_builder' ),
				'toggle_slug'   => 'subtitle_style',
				'tab_slug'		=> 'advanced',
				'hide_text_shadow'  => true,
				'line_height' => array(
					'default' => '1em',
				),
				'font_size' => array(
					'default' => '20px',
				),
				'css'      => array(
					'main' => ".dica_divi_carousel {$this->main_css_element}.dica_divi_carouselitem .dica-item-content .item-subtitle",
					'important' => 'all',
				),
			),
			// Body Text
			'body'   => array(
				'label'         => esc_html__( 'Body', 'et_builder' ),
				'toggle_slug'   => 'content_style',
				'tab_slug'		=> 'advanced',
				'hide_text_shadow'  => true,
				'line_height' => array(
						'default' => '1.7em',
					),
					'font_size' => array(
						'default' => '14px',
					),
				'css'      => array(
					'main' => ".dica_divi_carousel %%order_class%%.dica_divi_carouselitem .dica-item-content .content,
								.dica_divi_carousel %%order_class%%.dica_divi_carouselitem .dica-item-content .content p",
					'important' => 'all',
				),
			),
		);
		$advanced_fields['background'] = array(
			'css' 							=> array(
				'main'			=> ".dica_divi_carousel {$this->main_css_element} > div:first-of-type",
				// 'main'			=> "%%order_class%%",
				'important'		=> 'all'
			),
			'has_background_color_toggle'   => false, // default. Warning: to be deprecated
			'use_background_color'          => true, // default
			'use_background_color_gradient' => true, // default
			'use_background_image'          => true, // default
			'use_background_video'          => false, // default
		);
		$advanced_fields['text'] = false;
		$advanced_fields['borders'] = false;
		$advanced_fields['button'] = array(
			'button'	=> array(
				'label'		=>	esc_html__('Button custom' , 'et_builder'),
				'css'   => array(
					'main'   		=> "%%order_class%% .dica-item-content > div:not(.content):not(.dica-image-container):not(.social-media-container) a",
					'alignment'   	=> "%%order_class%% .et_pb_button_wrapper, #et-boc %%order_class%% .dica-item-content > div:not(.content):not(.dica-image-container):not(.social-media-container)",
					'important'		=> 'all'
				),
				'box_shadow'    => array(
					'css' => array(
						'main' => "%%order_class%% .et_pb_button_wrapper .et_pb_button, #et-boc {$this->main_css_element} .dica-item-content > div:not(.content):not(.dica-image-container):not(.social-media-container) a",
						'important'	=> 'all'
					),
				),
				'margin_padding' => false,
				'use_alignment' => true,
			)
		);
		$advanced_fields['box_shadow'] = array(
			'default' => array(
				'css' => array(
					'main' => "%%order_class%% > div:first-of-type, #et-boc %%order_class%% > div:first-of-type",
				),
			),
		);
		// $advanced_fields['margin_padding'] = array(
		// 	'css' => array(
		// 		'main' => ".dica_divi_carousel {$this->main_css_element}.dica_divi_carouselitem  > div",
		// 		'hover' => ".dica_divi_carousel {$this->main_css_element}.dica_divi_carouselitem  > div",
		// 		'important'	=> 'all'
		// 	)
		// );
		$advanced_fields['margin_padding'] = false;
		$advanced_fields['overflow'] = array(
			'css' => array(
				'main'	=> ".dica_divi_carousel .dica-container {$this->main_css_element}.dica_divi_carouselitem > div:first-of-type, #et-boc .dica_divi_carousel .dica-container {$this->main_css_element}.dica_divi_carouselitem > div:first-of-type",
			)
		);
		// $advanced_fields['filters'] = false;
		$advanced_fields['transform'] = array(
			'css' => array(
				'main'	=> "{$this->main_css_element}.dica_divi_carouselitem .et_pb_module_inner",
			)
		);
		$advanced_fields['max_width'] = false;
		$advanced_fields['animation'] = false;
		$advanced_fields['filters'] = array(
			'child_filters_target' => array(
				'tab_slug' 		=> 'advanced',
				'toggle_slug' 	=> 'image_filter',
				'css'         	=> array(
					'main' => '%%order_class%%.dica_divi_carouselitem .dica-image-container img',
				),
			),
			'css'      => array(
				'main' => '%%order_class%%.dica_divi_carouselitem',
			),
		);
		$advanced_fields['image'] = array(
			'css' => array(
				'main' => array(
					'%%order_class%%.dica_divi_carouselitem .dica-image-container img',
				)
			),
		);

		return $advanced_fields;
	}

	public function additional_css_styles($render_slug){
		$button_margin		=	array_diff(explode("|", $this->props['button_margin']), ['true', 'false']);
		$image_padding		=	array_diff(explode("|", $this->props['image_padding']), ['true', 'false']);
		$content_padding	=	array_diff(explode("|", $this->props['content_padding']), ['true', 'false']);
		$icon_alignment     =	$this->props['icon_alignment'];
		$_ex 				= "DICA_Extends";
		$alignment 			= array (
			'left'		=> 'flex-start',
			'center'	=> 'center',
			'right'		=> 'flex-end',
			'justified'	=> 'space-between'
		);
		// $button_align		=	$this->props['button_align'];
		// $order_class 		= self::get_module_order_class( $render_slug );

		// if the image is SVG
		if (isset($this->props['image']) && '' !== $this->props['image']) {
			$image_url = $this->props['image'];
			$image_type = wp_check_filetype($image_url);
			if($image_type['ext'] == 'svg') {
				ET_Builder_Element::set_style($render_slug, array(
					'selector' => '%%order_class%%.dica_divi_carouselitem .dica-image-container a.image',
					'declaration' => 'width:100%;',
				));
				ET_Builder_Element::set_style($render_slug, array(
					'selector' => '%%order_class%%.dica_divi_carouselitem .dica-image-container img',
					'declaration' => 'width:100%;',
				));
			}
		}

		// social media alignment
		if ( !empty($this->props['social_media_alignment']) ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%%.dica_divi_carouselitem .social-media',
				'declaration' => sprintf('justify-content:%1$s !important;',
				$alignment[$this->props['social_media_alignment']]),
			));
			if ( $this->props['social_media_alignment'] === 'justified' ) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector' => '%%order_class%%.dica_divi_carouselitem .social-media li',
					'declaration' => 'flex:1;'
				));
			}
		}
		// rating alignment
		if ( !empty($this->props['rating_alignment']) ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%%.dica_divi_carouselitem .dica-rating',
				'declaration' => sprintf('text-align:%1$s !important;',
				$this->props['rating_alignment']),
			));
		}
		//social media icon color
		$_ex::apply_element_color(
			$this,
			$render_slug, 
			'facebook_color', 
			'color', 
			'%%order_class%% .dica-item .social-media li.dg_facebook a',
			'%%order_class%% .dica-item .social-media li.dg_facebook:hover a', 
			true
		);
		$_ex::apply_element_color(
			$this,
			$render_slug, 
			'twitter_color', 
			'color', 
			'%%order_class%% .dica-item .social-media li.dg_twitter a',
			'%%order_class%% .dica-item .social-media li.dg_twitter:hover a', 
			true
		);
		$_ex::apply_element_color(
			$this,
			$render_slug, 
			'linkedin_color', 
			'color', 
			'%%order_class%% .dica-item .social-media li.dg_linkedin a',
			'%%order_class%% .dica-item .social-media li.dg_linkedin:hover a', 
			true
		);
		$_ex::apply_element_color(
			$this,
			$render_slug, 
			'instagram_color', 
			'color', 
			'%%order_class%% .dica-item .social-media li.dg_instagram a',
			'%%order_class%% .dica-item .social-media li.dg_instagram:hover a', 
			true
		);
		$_ex::apply_element_color(
			$this,
			$render_slug, 
			'email_color', 
			'color', 
			'%%order_class%% .dica-item .social-media li.dg_email a',
			'%%order_class%% .dica-item .social-media li.dg_email:hover a', 
			true
		);
		// social media icon background-color
		$_ex::apply_element_color(
			$this,
			$render_slug, 
			'facebook_bgcolor', 
			'background-color', 
			'%%order_class%% .dica-item .social-media li.dg_facebook a',
			'%%order_class%% .dica-item .social-media li.dg_facebook:hover a', 
			true
		);
		$_ex::apply_element_color(
			$this,
			$render_slug, 
			'twitter_bgcolor', 
			'background-color', 
			'%%order_class%% .dica-item .social-media li.dg_twitter a',
			'%%order_class%% .dica-item .social-media li.dg_twitter:hover a', 
			true
		);
		$_ex::apply_element_color(
			$this,
			$render_slug, 
			'linkedin_bgcolor', 
			'background-color', 
			'%%order_class%% .dica-item .social-media li.dg_linkedin a',
			'%%order_class%% .dica-item .social-media li.dg_linkedin:hover a', 
			true
		);
		$_ex::apply_element_color(
			$this,
			$render_slug, 
			'instagram_bgcolor', 
			'background-color', 
			'%%order_class%% .dica-item .social-media li.dg_instagram a',
			'%%order_class%% .dica-item .social-media li.dg_instagram:hover a', 
			true
		);
		$_ex::apply_element_color(
			$this,
			$render_slug, 
			'email_bgcolor', 
			'background-color', 
			'%%order_class%% .dica-item .social-media li.dg_email a',
			'%%order_class%% .dica-item .social-media li.dg_email:hover a', 
			true
		);
		// social icon size
		$_ex::apply_single_value(
			$this,
			$render_slug,
			'social_icon_size',
			'font-size',
			".dica_divi_carousel {$this->main_css_element} .social-media-container .social-media li a:before",
			'px'
		);
		// rating icon size
		$_ex::apply_single_value(
			$this,
			$render_slug,
			'rating_icon_size',
			'font-size',
			'%%order_class%% .dica-rating span:before',
			'px'
		);
		// rating color styles
		if ( !empty($this->props['rating_color']) ) {
			$_ex::apply_element_color(
				$this,
				$render_slug, 
				'rating_color', 
				'color', 
				'%%order_class%% .dica-rating span.rate:before',
				'%%order_class%%:hover .dica-rating span.rate:before', 
				true
			);
		}
		if ( !empty($this->props['blank_color']) ) {
			$_ex::apply_element_color(
				$this,
				$render_slug, 
				'blank_color', 
				'color', 
				'%%order_class%% .dica-rating span.blank:before',
				'%%order_class%%:hover .dica-rating span.blank:before', 
				true
			);
		}
		
		// item margin and padding
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'custom_margin', 
			'margin', 
			".dica_divi_carousel {$this->main_css_element}.dica_divi_carouselitem > .et_pb_module_inner",
			".dica_divi_carousel {$this->main_css_element}.dica_divi_carouselitem > .et_pb_module_inner:hover"
		);
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'custom_padding', 
			'padding', 
			".dica_divi_carousel {$this->main_css_element}.dica_divi_carouselitem > .et_pb_module_inner",
			".dica_divi_carousel {$this->main_css_element}.dica_divi_carouselitem > .et_pb_module_inner:hover"
		);
		// button margin padding
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'button_margin', 
			'margin', 
			'%%order_class%%.dica_divi_carouselitem .dica-item .dica-item-content > div:not(.content):not(.dica-image-container):not(.social-media-container) a',
			'%%order_class%%.dica_divi_carouselitem .dica-item .dica-item-content > div:not(.content):not(.dica-image-container):not(.social-media-container) a:hover'
		);
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'button_padding', 
			'padding', 
			"body #page-container {$this->main_css_element}.dica_divi_carouselitem .dica-item .dica-item-content > div:not(.content):not(.dica-image-container):not(.social-media-container) a",
			"body #page-container {$this->main_css_element}.dica_divi_carouselitem .dica-item .dica-item-content > div:not(.content):not(.dica-image-container):not(.social-media-container) a:hover"
		);
		// image size for left and right position
		if( $this->props['image_position'] === 'image_left' || $this->props['image_position'] === 'image_right') {
			$_ex::apply_single_value(
				$this,
				$render_slug,
				'image_size',
				'width',
				'%%order_class%%.dica_divi_carouselitem .dica-image-container'
			);
			$_ex::apply_single_value(
				$this,
				$render_slug,
				'image_size',
				'width',
				'%%order_class%%.dica_divi_carouselitem .dica-item-content',
				'%',
				true
			);
		}
		// image tablet on top
		if ( $this->props['tablet_on_top'] == 'on' ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => ".dica_divi_carousel {$this->main_css_element}.dica_divi_carouselitem .dica-image-container, 
					.dica_divi_carousel {$this->main_css_element}.dica_divi_carouselitem .dica-item-content",
				'declaration' => 'width:100% !important;',
				'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => ".dica_divi_carousel {$this->main_css_element}.dica_divi_carouselitem .dica-item",
				'declaration' => 'flex-direction: column;',
				'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
			));
		}
		// image mobile on top
		if ( $this->props['mobile_on_top'] == 'on' ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => ".dica_divi_carousel {$this->main_css_element}.dica_divi_carouselitem .dica-image-container, 
					.dica_divi_carousel {$this->main_css_element}.dica_divi_carouselitem .dica-item-content",
				'declaration' => 'width:100% !important;',
				'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => ".dica_divi_carousel {$this->main_css_element}.dica_divi_carouselitem .dica-item",
				'declaration' => 'flex-direction: column;',
				'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
			));
		}
		// image spacing
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'image_padding',
			'padding', 
			".dica_divi_carousel {$this->main_css_element}.dica_divi_carouselitem .et_pb_module_inner .dica-image-container",
			".dica_divi_carousel {$this->main_css_element}.dica_divi_carouselitem:hover .et_pb_module_inner .dica-image-container"
		);
		// content padding
		$_ex::apply_margin_padding(
			$this,
			$render_slug,
			'content_padding', 
			'padding', 
			".dica_divi_carousel {$this->main_css_element}.dica_divi_carouselitem .et_pb_module_inner .dica-item-content",
			".dica_divi_carousel {$this->main_css_element}.dica_divi_carouselitem:hover .et_pb_module_inner .dica-item-content"
		);
		// icon alignment
		if('' !== $icon_alignment && $this->props['use_icon'] === 'on') {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '.dica_divi_carousel %%order_class%%.dica_divi_carouselitem .dica-image-container',
                'declaration' => sprintf(
                    'text-align:%1$s !important;', $icon_alignment),
            ) );
		} else if ($this->props['use_icon'] === 'on') {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '.dica_divi_carousel %%order_class%%.dica_divi_carouselitem .dica-image-container',
                'declaration' => sprintf(
                    'text-align:center !important;', null),
            ) );
		}
		
	}

	public function render( $attrs, $content = null, $render_slug ) {
		$_ex 				= "DICA_Extends";
		$classes			= '';
		$title 				=	$this->props['title']; 
		$content			=	$this->props['content'];
		$image 				=	$this->props['image'];
		$image_url 			=	$this->props['image'];
		$social_media       = 	'';
		$rating				=	'';
		$image_lightbox		=	$this->props['image_lightbox'];
		$url 				=	$this->props['url'];
		$url_new_window   	=	$this->props['url_new_window'];

		$button_text           = $this->props['button_text'];
		$button_url            = $this->props['button_url'];
		$button_url_new_window = $this->props['button_url_new_window'];
		$font_icon             = $this->props['font_icon'];
		$use_icon              = $this->props['use_icon'];
		$use_circle            = $this->props['use_circle'];
		$use_circle_border     = $this->props['use_circle_border'];
		$icon_color            = $this->props['icon_color'];
		$circle_color          = $this->props['circle_color'];
		$circle_border_color   = $this->props['circle_border_color'];
		$use_icon_font_size    = $this->props['use_icon_font_size'];
		$icon_font_size        = $this->props['icon_font_size'];
		$icon_font_size_tablet = $this->props['icon_font_size_tablet'];
		$icon_font_size_phone  = $this->props['icon_font_size_phone'];
		$icon_font_size_last_edited  = $this->props['icon_font_size_last_edited'];
		// Design related props are added via $this->advanced_options['button']['button']
		$button_custom         = $this->props['custom_button'];
		$button_rel            = $this->props['button_rel'];
		$button_use_icon       = $this->props['button_use_icon'];
		$custom_icon       	   = $this->props['button_icon'];

		
		if ( 'off' !== $use_icon_font_size ) {
			$font_size_responsive_active = et_pb_get_responsive_status( $icon_font_size_last_edited );

			$font_size_values = array(
				'desktop' => $icon_font_size,
				'tablet'  => $font_size_responsive_active ? $icon_font_size_tablet : '',
				'phone'   => $font_size_responsive_active ? $icon_font_size_phone : '',
			);

			et_pb_generate_responsive_css( $font_size_values, '%%order_class%% .et-pb-icon', 'font-size', $render_slug );
		}

		$this->additional_css_styles($render_slug);
		// Render button
		$button = $this->render_button( array(
			'button_text'      => $button_text,
			'button_url'       => $button_url,
			'url_new_window'   => $button_url_new_window,
			'button_custom'    => $button_custom,
			'button_rel'       => $button_rel,
			'custom_icon'      => $custom_icon,
		) );
		// get the parent module
		$parent_module = self::get_parent_modules('page')['dica_divi_carousel'];
		if ($parent_module->props['lazy_loading'] == 'on') {
			$src_attr = 'data-src';
			$lazy_class = ' swiper-lazy';
			$lazy_preloader = '<div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>';
			$loading = ' loading';
		} else {
			$src_attr = 'src';
			$lazy_class = '';
			$lazy_preloader = '';
			$loading = '';
		}

		// create image markup
		if ( 'off' === $use_icon ) {
			$image = ( '' !== trim( $image ) ) ? sprintf(
				'<img %3$s="%1$s" alt="%2$s" class="dica-item-image%4$s" />%5$s',
				esc_attr( $image ),
				esc_attr( $this->props['image_alt'] ),
				$src_attr,
				$lazy_class,
				$lazy_preloader
			) : '';					
		} else {
			$icon_style = sprintf( 'color: %1$s;', esc_attr( $icon_color ) );

			if ( 'on' === $use_circle ) {
				$icon_style .= sprintf( ' background-color: %1$s;', esc_attr( $circle_color ) );

				if ( 'on' === $use_circle_border ) {
					$icon_style .= sprintf( ' border-color: %1$s;', esc_attr( $circle_border_color ) );
				}
			}

			$image = ( '' !== $font_icon ) ? sprintf(
				'<span class="et-pb-icon %2$s%3$s" style="%4$s">%1$s</span>',
				esc_attr( et_pb_process_font_icon( $font_icon ) ),
				( 'on' === $use_circle ? ' et-pb-icon-circle' : '' ),
				( 'on' === $use_circle && 'on' === $use_circle_border ? ' et-pb-icon-circle-border' : '' ),
				$icon_style
			) : '';
		}
		// create title markup
		if( '' !== $title && '' !== $url) {
			$title = sprintf( '<%4$s class="item-title"><a href="%1$s"%3$s>%2$s</a></%4$s>',
				esc_url( $url ),
				esc_html( $title ),
				( 'on' === $url_new_window ? ' target="_blank"' : '' ),
				et_pb_process_header_level( $this->props['header_level'], 'h4' )
			);
		} else if ('' !== $title && '' === $url) {
			$title = sprintf( '<%2$s class="item-title">%1$s</%2$s>',
				esc_html( $title ),
				et_pb_process_header_level( $this->props['header_level'], 'h4' )
			);
		}
		// create image markup with lightbox
		if( '' !== $image && '' !== $url && 'off' == $use_icon && 'on' !== $image_lightbox ) {
			$image = sprintf( '<a class="image" href="%1$s"%3$s>%2$s</a>',
				esc_url( $url ),
				$image,
				( 'on' === $url_new_window ? ' target="_blank"' : '' )
			);
		} else if ( '' !== $image && 'off' == $use_icon && 'on' !== $image_lightbox ) {
			$image = sprintf( '<a class="image">%1$s</a>',
				$image
			);
		} else if ( '' !== $image && 'off' == $use_icon && 'on' == $image_lightbox ) {
			// if the lightbox on
			$image = sprintf( '<a data-lightbox class="image" href="%2$s">%1$s</a>',
				$image,
				$image_url
			);

		} else if ( '' !== $image && '' !== $url && 'on' == $use_icon ) {
			$image = sprintf( '<a href="%1$s"%3$s>%2$s</a>',
				esc_url( $url ),
				$image,
				( 'on' === $url_new_window ? ' target="_blank"' : '' )
			);
		}
		// social media content
		if( 'on' === $this->props['use_social_media'] ) {
			$facebook = '' !== $this->props['facebook_url'] ? 
				sprintf('<li class="dg_facebook"><a href="%1$s"><span>Facebook</span></a></li>', $this->props['facebook_url']) : '';
			$twitter = '' !== $this->props['twitter_url'] ? 
				sprintf('<li class="dg_twitter"><a href="%1$s"><span>Twitter</span></a></li>', $this->props['twitter_url']) : '';
			$linkedin = '' !== $this->props['linkedin_url'] ? 
				sprintf('<li class="dg_linkedin"><a href="%1$s"><span>Linkedin</span></a></li>', $this->props['linkedin_url']) : '';
			$instagram = '' !== $this->props['instagram_url'] ? 
				sprintf('<li class="dg_instagram"><a href="%1$s"><span>Instagram</span></a></li>', $this->props['instagram_url']) : '';
			$email = '' !== $this->props['email_address'] ? 
				sprintf('<li class="dg_email"><a href="mailto:%1$s"><span>Email</span></a></li>', $this->props['email_address']) : '';
			$social_media = sprintf('<div class="social-media-container">
				<ul class="social-media">
					%1$s %2$s %3$s %4$s %5$s
				</ul>
			</div>', $facebook, $twitter, $linkedin, $instagram, $email);
		}
		// rating content
		if ('on' === $this->props['use_rating']) {
			$rating	= sprintf('<div class="dica-rating-container">
				<div class="dica-rating">
					%1$s
				</div>
			</div>', $this->rating() );
		}

		// image container
		$image_container = '' !== $image && 'image_under_title' !== $this->props['image_position'] ? 
			sprintf('<div class="dica-image-container">%1$s</div>', $image) : '';
		// image position under title
		$image_under_title = '' !== $image && 'image_under_title' === $this->props['image_position'] ?
			sprintf('<div class="dica-image-container">%1$s</div>', $image) : '';

		// if the content is empty
		if ( '' === $this->props['title'] && 
			'' === $this->props['content'] && 
			'' === et_core_sanitized_previously( $button ) &&
			'' === $social_media &&
			'' === $rating ) {
			$classes = $this->add_class($classes, 'empty-content');
		}
		// adding image position class
		$classes = $this->add_class($classes, $this->props['image_position']);
		// social media position class
		if ( $this->props['use_social_media'] === 'on' ) {
			$classes = $this->add_class($classes, $this->props['social_media_position']);
		}
		// rating position class
		if ( $this->props['use_rating'] === 'on' ) {
			$classes = $this->add_class($classes, $this->props['rating_position']);
		}

		$content_text = '' !== $this->props['content'] ? 
			sprintf('<div class="content">%1$s</div>', $this->props['content']) : 
			null;

		// filter for images
		if (array_key_exists('image', $this->advanced_fields) && array_key_exists('css', $this->advanced_fields['image'])) {
			$this->add_classname($this->generate_css_filters(
				$render_slug,
				'child_',
				self::$data_utils->array_get($this->advanced_fields['image']['css'], 'main', '%%order_class%%')
			));
		}
		// content with markup
		$content_container = 
			!empty($title) || !empty($this->props['sub_title']) || 
			!empty($this->props['content']) || 
			!empty(et_core_sanitized_previously( $button )) ||
			!empty($social_media) ||
			!empty($rating) ?
			sprintf('<div class="dica-item-content">%1$s %8$s %4$s %2$s %5$s %6$s %7$s %9$s %3$s</div>', 
				$_ex::render_title($title, 'default', $this->props['title_position']), 
				$content_text, 
				et_core_sanitized_previously( $button ),
				$image_under_title,
				$social_media,
				$rating,
				$_ex::render_title($title, 'bottom', $this->props['title_position']),
				$_ex::render_subtitle($this->props['sub_title'], 'default', $this->props['subtitle_position']),
				$_ex::render_subtitle($this->props['sub_title'], 'bottom', $this->props['subtitle_position']) )
			: null;

		$link_url = '' !== $this->props['link_option_url'] ? 
			sprintf('data-link="%1$s"', $this->props['link_option_url']) : 
			null;
		$link_target = 'on' !== $this->props['link_option_url_new_window'] ? null : 
			'data-target="_blank"';
			
		$output =  sprintf( '<div class="dica-item%3$s%4$s%5$s" %6$s %7$s>
									%2$s
									%1$s
							</div>', 
							$content_container,
							$image_container,
							$classes,
							$lazy_class,
							$loading,
							$link_url,
							$link_target
						);

		return $output;
	}
	/**
	 * Rating
	 */
	public function rating() {
		$rating = '';
		for ($i = 1; $i <= 5; $i++) {
			if ( $i <= $this->props['rating_number']) {
				$rating .= '<span class="rate"></span>';
			} else {
				$rating .= '<span class="blank"></span>';
			}
		}
		return $rating;
	}
	/**
	 * Add module Classes
	 */
	private function add_class($classes, $class = '') {
		return $classes .= ' ' . $class;
	}
	/**
	 * Render title
	 */
	function render_title( $title, $current, $position ) {
		if ( $current === $position ) {
			return $title;
		} else {
			return null;
		}
	}
	/**
	 * Render subtitle
	 */
	function render_subtitle($subtitle, $current, $position) {
		if ( !empty($subtitle)) {
			if ( $current === $position ) {
				return "<h6>{$subtitle}</h6>";
			} else {
				return null;
			}
		} 
	}
}

new DiviCarouselItem;
