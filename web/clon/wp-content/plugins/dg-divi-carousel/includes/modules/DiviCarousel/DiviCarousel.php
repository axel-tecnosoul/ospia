<?php
require_once ( DICA_MAIN_DIR . '/functions/extends.php');

class DiviCarousel extends ET_Builder_Module {

	public $slug       = 'dica_divi_carousel';
	public $vb_support = 'on';
	public $child_slug = 'dica_divi_carouselitem';

	protected $module_credits = array(
		'module_uri' => 'https://www.divigear.com/',
		'author'     => 'DiviGear',
		'author_uri' => 'https://www.divigear.com',
	);

	public function init() {
		$this->name = esc_html__( 'Divi Carousel', 'et_builder' );
		$this->icon_path = plugin_dir_path( __FILE__ ). 'icon.svg';
		$this->main_css_element = '%%order_class%%';
	}

	public function get_settings_modal_toggles(){
		return array(
			'general'  => array(
					'toggles' => array(
							'main_content' 					=> esc_html__( 'Main Content', 'et_builder' ),
							'slider_settings'				=> esc_html__('Slider Settings', 'et_builder'),
							'advanced_slider'				=> esc_html__('Advanced Slider Settings', 'et_builder'),
					),
			),
			'advanced'  =>  array(
					'toggles'   =>  array(
							'image_overlay'		=> esc_html__('Overlay', 'et_buitlder'),
							'image_style'		=> esc_html__('Image', 'et_buitlder'),
							'image_border'		=> esc_html__('Image Border', 'et_buitlder'),
							'image_shaodow'		=> esc_html__('Image Box Shadow', 'et_buitlder'),
							'title_style'		=> esc_html__('Title Text', 'et_buitlder'),
							'subtitle_style'	=> esc_html__('Subtitle Text', 'et_buitlder'),
							'body_text_style'	=> esc_html__('Body Text', 'et_buitlder'),
							'next_prev_button'	=> esc_html__('Next & Previous Button', 'et_buitlder'),
							'color_settings'	=> esc_html__('Color Settings', 'et_buitlder'),
							'zindex_settings'	=> esc_html__('Z-index', 'et_buitlder'),
							'custom_spacing'				=> array (
								'title'				=> esc_html__('Custom Spacing', 'et_builder'),
								'tabbed_subtoggles' => true,
								// 'priority' => 50,
								'sub_toggles' => array(
									'container'   => array(
										'name' => 'Container',
									),
									'content'     => array(
										'name' => 'Content',
									)
								),
							),
							'item_border'		=> esc_html__('Item Border', 'et_buitlder'),
					)
			),
		);
	}

	public function get_advanced_fields_config() {
		$advanced_fields = array();
		$advanced_fields['text'] = false;
		// Image
		$advanced_fields['fonts']  = array(
			// Title
			'title'   => array(
				'label'         => esc_html__( 'Title', 'et_builder' ),
				'toggle_slug'   => 'title_style',
				'tab_slug'		=> 'advanced',
				'hide_text_shadow'  => true,
				'line_height' => array(
					'default' => '1em',
				),
				'font_size' => array(
					'default' => '20px',
				),
				'css'      => array(
					'main' => "%%order_class%% .dica_divi_carouselitem .dica-item-content .item-title",
					'hover' => "%%order_class%% .dica_divi_carouselitem:hover .dica-item-content .item-title",
					'important' => 'all',
				),
			),
			// Subtitle
			'subtitle'   => array(
				'label'         => esc_html__( 'Subtitle', 'et_builder' ),
				'toggle_slug'   => 'subtitle_style',
				'tab_slug'		=> 'advanced',
				'hide_text_shadow'  => true,
				'line_height' => array(
						'default' => '1em',
					),
					'font_size' => array(
						'default' => '16px',
					),
				'css'      => array(
					'main' => "%%order_class%% .dica_divi_carouselitem .dica-item-content .item-subtitle",
					'hover' => "%%order_class%% .dica_divi_carouselitem:hover .dica-item-content .item-subtitle",
					'important' => 'all',
				),
			),
			// Body Text
			'body'   => array(
				'label'         => esc_html__( 'Body', 'et_builder' ),
				'toggle_slug'   => 'body_text_style',
				'tab_slug'		=> 'advanced',
				'hide_text_shadow'  => true,
				'line_height' => array(
						'default' => '1.7em',
					),
					'font_size' => array(
						'default' => '14px',
					),
				'css'      => array(
					'main' => "%%order_class%% .dica_divi_carouselitem .dica-item-content .content, 
								%%order_class%% .dica_divi_carouselitem .dica-item-content .content p",
					'hover' => "%%order_class%% .dica_divi_carouselitem:hover .dica-item-content .content, 
								%%order_class%% .dica_divi_carouselitem:hover .dica-item-content .content p",
					'important' => 'all',
				),
			),

			'nav_icon'   => array(
				// 'label'         => esc_html__( 'Nav', 'et_builder' ),
				'toggle_slug'   => 'next_prev_button',
				'tab_slug'		=> 'advanced',
				'hide_text_shadow'  => true,
				'hide_font'	=> true,
				'hide_font_size'	=> true,
				'hide_letter_spacing'	=> true,
				'hide_text_color'	=> true,
				'hide_text_align'	=> true,
				'line_height' => array(
					'default' => '0.96em',
				),
				'font_size' => array(
					'default' => '53px',
				),
				'css'      => array(
					'main' => "%%order_class%% .dica-container .swiper-button-next,
					%%order_class%% .dica-container .swiper-button-prev",
					'important' => 'all',
				),
			),

		);
		

		$advanced_fields['borders'] = array(
			'default' => false,
			'item'	=> array(
				'css'      => array(
					'main' => array(
						'border_styles' => "#et-boc %%order_class%%.dica_divi_carousel .dica_divi_carouselitem > div:first-of-type,
											%%order_class%%.dica_divi_carousel .dica_divi_carouselitem > div:first-of-type",
						'border_radii'	=> "#et-boc %%order_class%%.dica_divi_carousel .dica_divi_carouselitem > div:first-of-type,
											%%order_class%%.dica_divi_carousel .dica_divi_carouselitem > div:first-of-type",
					),
					'important'	=> true
				),
				'label_prefix'    => esc_html__( 'Border', 'et_builder' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'item_border',
			),
			'image'	=> array(
				'label'         => esc_html__( 'Image Border', 'et_builder' ),
				'css'             => array(
					'main' => array(
						'border_radii' => "{$this->main_css_element}.dica_divi_carousel .dica_divi_carouselitem .dica-image-container img.dica-item-image, 
											#et-boc {$this->main_css_element}.dica_divi_carousel .dica_divi_carouselitem .dica-image-container img.dica-item-image,
											{$this->main_css_element} .dica_divi_carouselitem .dica-image-container a.image",
						'border_styles' => "{$this->main_css_element}.dica_divi_carousel .dica_divi_carouselitem .dica-image-container img.dica-item-image, 
											#et-boc {$this->main_css_element}.dica_divi_carousel .dica_divi_carouselitem .dica-image-container img.dica-item-image",
					)
				),
				'label_prefix'    => esc_html__( 'Image', 'et_builder' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'image_border',
			)
		);
		$advanced_fields['margin_padding'] = array(
			'css'      => array(
				'main' => '%%order_class%%.dica_divi_carousel',
				'important' => 'all',
			),
		);
		$advanced_fields['background'] = array(
			'css' 		=> array(
				'main'	=> '%%order_class%%.dica_divi_carousel .dica_divi_carouselitem .dica-item-content',
				'hover'	=> '%%order_class%%.dica_divi_carousel .dica_divi_carouselitem:hover .dica-item-content'
			)
		);
		$advanced_fields['box_shadow'] = array(
			'default'	=> false,
			'image'		=> array(
				'css'	=> array(
					'main'	=> "{$this->main_css_element} .dica_divi_carouselitem .dica-image-container .image"
				),
				'label_prefix'    => esc_html__( 'Image Box Shadow', 'et_builder' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'image_shaodow',
			)
		);
		$advanced_fields['overflow'] = false;
		$advanced_fields['button'] = false;
		$advanced_fields['link_options'] = false;
		$advanced_fields['animation'] = false;
		$advanced_fields['filters'] = false;

		return $advanced_fields;
	}

	public function get_fields() {
		$_ex = "DICA_Extends";
		$general = array(
			// Sliider Settings
			'item_width_auto'	=> array(
				'label'				=> 	esc_html__('Item width control', 'et_builder'),
				'type'				=>	'yes_no_button',
				'description'		=> esc_html__('Control the fixed with for each carousel item for multiple devices.', 'et_builder'),
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'		=>	'slider_settings',
				'default'			=> 'off'
			),
			// item width
			'item_width'     => array(
                'label'             => esc_html('Item width', 'et_builder'),
                'type'              => 'range',
				'toggle_slug'       => 'slider_settings',
				'description'		=> esc_html__('Specify the width for devices.', 'et_builder'),
				'mobile_options'    => true,
                'range_settings '   => array(
                    'min'       => '50px',
                    'max'       => '550px',
                    'step'      => '1',
                ),
				'default'          => '550px',
				'default_unit'     => 'px',
				'show_if'         => array(
					'item_width_auto' => 'on',
				),
			),
			'item_width_tablet' => array(
				'type'            	=> 'skip',
				// 'tab_slug'        	=> 'advanced',
				'toggle_slug'		=> 'slider_settings',
			),
			'item_width_phone' => array(
				'type'            	=> 'skip',
				// 'tab_slug'        	=> 'advanced',
				'toggle_slug'		=> 'slider_settings',
			),
			'item_width_last_edited' => array(
				'type'            	=> 'skip',
				// 'tab_slug'        	=> 'advanced',
				'toggle_slug'		=> 'slider_settings',
			),

			'show_items_desktop'	=> array(
				'label'				=> 	esc_html__('Show item Desktop', 'et_builder'),
				'type'				=>	'text',
				'default'			=>	'4',
				'toggle_slug'		=> 'slider_settings',
				'show_if_not'         => array(
					'item_width_auto' => 'on',
				),
			),
			'show_items_tablet'	=> array(
				'label'				=> 	esc_html__('Show item Tablet', 'et_builder'),
				'type'				=>	'text',
				'default_on_front'	=>	'3',
				'toggle_slug'		=> 'slider_settings',
				'show_if_not'         => array(
					'item_width_auto' => 'on',
				),
			),
			'show_items_mobile'	=> array(
				'label'				=> 	esc_html__('Show item Mobile', 'et_builder'),
				'type'				=>	'text',
				'default'			=>	'1',
				'toggle_slug'		=> 'slider_settings',
				'show_if_not'         => array(
					'item_width_auto' => 'on',
				),
			),
			'multislide'	=> array(
				'label'				=> 	esc_html__('Multislide', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'		=>	'slider_settings',
				'default'			=> 'off',
				'show_if_not'         => array(
					'item_width_control' 	=> 'on',
					'scroller_effect' 		=> 'on',
				),
			),
			'transition_duration'	=> array(
				'label'				=> 	esc_html__('Transition Duration (ms)', 'et_builder'),
				'type'				=>	'text',
				'default'			=>	'500',
				'toggle_slug'		=>	'slider_settings',
				'show_if_not'        => array(
					'scroller_effect' => 'on',
				)
			),
			'centermode'	=> array(
				'label'				=> 	esc_html__('Center Slide', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'		=>	'slider_settings',
				'default'			=> 'off'
			),
			'loop'	=> array(
				'label'				=> 	esc_html__('Loop', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'		=>	'slider_settings',
				'default'			=> 'off'
			),
			'autoplay'	=> array(
				'label'				=> 	esc_html__('AutoPlay', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'		=>	'slider_settings',
				'default'			=> 'off'
			),
			'hoverpause'	=> array(
				'label'				=> 	esc_html__('Pause on hover', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'		=>	'slider_settings',
				'default'			=> 'off',
				'show_if'         => array(
					'autoplay' => 'on',
				),
			),
			'scroller_effect'	=> array(
				'label'				=> 	esc_html__('Scroller Effect', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'		=>	'slider_settings',
				'default'			=> 'off',
				'show_if'         => array(
					'autoplay' => 'on',
				),
			),
			'transition_duration_scroll'	=> array(
				'label'				=> 	esc_html__('Transition Duration for Scroll Effect', 'et_builder'),
				'type'				=>	'select',
				'options'         => array(
					'1000'       	=> esc_html__( '1 Second', 'et_builder' ),
					'2000' 			=> esc_html__( '2 Seconds', 'et_builder' ),
					'3000'  		=> esc_html__( '3 Seconds', 'et_builder' ),
					'4000'  		=> esc_html__( '4 Seconds', 'et_builder' ),
					'5000'  		=> esc_html__( '5 Seconds', 'et_builder' ),
					'6000'  		=> esc_html__( '6 Seconds', 'et_builder' ),
					'7000'  		=> esc_html__( '7 Seconds', 'et_builder' ),
					'8000'  		=> esc_html__( '8 Seconds', 'et_builder' ),
					'9000'  		=> esc_html__( '9 Seconds', 'et_builder' ),
					'10000'  		=> esc_html__( '10 Seconds', 'et_builder' ),
					'11000'  		=> esc_html__( '11 Seconds', 'et_builder' ),
					'12000'  		=> esc_html__( '12 Seconds', 'et_builder' ),
					'13000'  		=> esc_html__( '13 Seconds', 'et_builder' ),
					'14000'  		=> esc_html__( '14 Seconds', 'et_builder' ),
					'15000'  		=> esc_html__( '15 Seconds', 'et_builder' ),
				),
				'default'		=> '4000',
				'toggle_slug'		=>	'slider_settings',
				'show_if'      => array(
					'scroller_effect' => 'on',
				),
			),
			'autoplay_speed'		=> array(
				'label'				=> 	esc_html__('Auto Play Delay', 'et_builder'),
				'type'				=>	'text',
				'default'			=>	'1000',
				'toggle_slug'		=> 'slider_settings',
				'show_if'         => array(
					'autoplay' => 'on',
				),
				'show_if_not'         => array(
					'scroller_effect' => 'on',
				),
			),
			'arrow_nav'	=> array(
				'label'				=> 	esc_html__('Arrow Navigation', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'		=>	'slider_settings',
				'default'			=> 'off'
			),
			'dot_nav'	=> array(
				'label'				=> 	esc_html__('Dot Navigation', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'		=>	'slider_settings',
				'default'			=> 'off'
			),
			'dot_alignment'	=> array(
				'label'				=> 	esc_html__('Dots Alignment', 'et_builder'),
				'type'				=>	'text_align',
				'options'         	=> et_builder_get_text_orientation_options( array( 'justified' ) ),
				'toggle_slug'		=>	'slider_settings',
				'default'			=> 'center',
				'default_on_front'	=> 'center',
				'show_if'         => array(
					'dot_nav' => 'on',
				),
			),
			'item_spacing'     => array(
                'label'             => esc_html('Item Spacing', 'et_builder'),
                'type'              => 'range',
				'toggle_slug'       => 'slider_settings',
				'mobile_options'    => true,
                'range_settings '   => array(
                    'min'       => '0',
                    'max'       => '100',
                    'step'      => '1',
                ),
				'default'          => '30',
				'default_unit'     => ''
			),
			'item_spacing_tablet' => array(
				'type'            	=> 'skip',
				'toggle_slug'		=> 'slider_settings',
			),
			'item_spacing_phone' => array(
				'type'            	=> 'skip',
				'toggle_slug'		=> 'slider_settings',
			),
			'item_spacing_last_edited' => array(
				'type'            	=> 'skip',
				'toggle_slug'		=> 'slider_settings',
			),
			'equal_height'	=> array(
				'label'				=> 	esc_html__('Equal Height Item', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'		=>	'slider_settings',
				'default'			=> 'off'
			),
			'item_vertical_align'	=> array(
				'label'				=> 	esc_html__('Vertical Align', 'et_builder'),
				'type'				=>	'select',
				'options'         => array(
					'flex-start' 	=> esc_html__( 'Top', 'et_builder' ),
					'center'  		=> esc_html__( 'Center', 'et_builder' ),
					'flex-end'  	=> esc_html__( 'Bottom', 'et_builder' ),
				),
				'toggle_slug'		=>	'slider_settings',
				'show_if'      => array(
					'equal_height' => 'off',
				),
			),
			'lazy_loading'	=> array(
				'label'				=> 	esc_html__('Lazy Loading', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'		=>	'slider_settings',
				'default'			=> 'off'
			),
			'load_before_transition'	=> array(
				'label'				=> 	esc_html__('Start Loading before transition Start', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'		=>	'slider_settings',
				'default'			=> 'off',
				'show_if'      => array(
					'lazy_loading' => 'on',
				),
			),
			// Advanced Settings
			'advanced_effect' => array(
				'default'         => 'default',
				'default_on_front'=> true,
				'label'           => esc_html__( 'Slider Effect', 'et_builder' ),
				'type'            => 'select',
				'options'         => array(
					'default' 		=> esc_html__( 'Default', 'et_builder' ),
					'coverflow'  	=> esc_html__( 'Coverflow', 'et_builder' ),
				),
				'toggle_slug'     => 'advanced_slider',
			),
			'coverflow_rotate'     => array(
                'label'             => esc_html('Rotate', 'et_builder'),
                'type'              => 'range',
                'toggle_slug'       => 'advanced_slider',
                'range_settings '   => array(
                    'min'       => '0',
                    'max'       => '100',
                    'step'      => '1',
                ),
				'default'          => '50',
				'show_if'         => array(
					'advanced_effect' => 'coverflow',
				),
			),
			'coverflow_shadow'	=> array(
				'label'				=> 	esc_html__('Coverflow Shadow', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'		=>	'advanced_slider',
				'default'			=> 'on',
				'show_if'         => array(
					'advanced_effect' => 'coverflow',
				),
			),
			// Image
			'overlay_image' => array(
				'label'           => esc_html__( 'Image Overlay', 'et_builder' ),
				'type'            => 'yes_no_button',
				'options'         => array(
					'off'	=> esc_html('No', 'et_builder'),
					'on'	=> esc_html('Yes', 'et_builder')
				),
				'default_on_front' => 'off',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'image_overlay',
			),
			'overlay_color'	=> array(
				'label'				=> 	esc_html__('Overlay Color', 'et_builder'),
				'type'				=>	'color-alpha',
				'toggle_slug'		=>	'image_overlay',
				'default'			=> 'rgba(255,255,255,0.85)',
				'tab_slug'          => 'advanced',
				'show_if'         => array(
					'overlay_image' => 'on'
				),
			),
			'use_overlay_icon'	=> array(
				'label'				=> 	esc_html__('Use custom overlay icon', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'		=>	'image_overlay',
				'default'			=> 'off',
			),
			'overlay_icon' => array(
				'label'               => esc_html__( 'Select overlay icon', 'et_builder' ),
				'type'                => 'et_font_icon_select',
				'renderer'            => 'select_icon',
				'renderer_with_field' => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'image_overlay',
				'show_if'         => array(
					'use_overlay_icon' => 'on',
				),
			),
			'overlay_icon_color'	=> array(
				'label'				=> 	esc_html__('Overlay Icon Color', 'et_builder'),
				'type'				=>	'color-alpha',
				'toggle_slug'		=>	'image_overlay',
				'default'			=> '#0c71c3',
				'tab_slug'          => 'advanced',
				'show_if'         => array(
					'overlay_image' => 'on',
				)
			),
			
			
			// Color
			'arrow_nav_color'	=> array(
				'label'				=> 	esc_html__('Arrow Color', 'et_builder'),
				'type'				=>	'color-alpha',
				'toggle_slug'		=>	'color_settings',
				'default'			=> '#0c71c3',
				'tab_slug'          => 'advanced',
			),
			'arrow_bg_color'	=> array(
				'label'				=> 	esc_html__('Arrow Background Color', 'et_builder'),
				'type'				=>	'color-alpha',
				'toggle_slug'		=>	'color_settings',
				'default'			=> '#ffffff',
				'tab_slug'          => 'advanced',
			),
			'dots_color'	=> array(
				'label'				=> 	esc_html__('Dots Color', 'et_builder'),
				'type'				=>	'color-alpha',
				'toggle_slug'		=>	'color_settings',
				'default'			=> '#e0e0e0',
				'tab_slug'          => 'advanced',
			),
			'dots_active_color'	=> array(
				'label'				=> 	esc_html__('Dots Active Color', 'et_builder'),
				'type'				=>	'color-alpha',
				'toggle_slug'		=>	'color_settings',
				'default'			=> '#0c71c3',
				'tab_slug'          => 'advanced',
			),
		);
		$image_settings = array(
			'align' => array(
				'label'           => esc_html__( 'Image Alignment', 'et_builder' ),
				'type'            => 'text_align',
				'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'default_on_front' => 'center',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'image_style',
				'description'     => esc_html__( 'Here you can choose the image alignment.', 'et_builder' ),
			),
			'image_force_fullwidth'	=> array(
				'label'				=> 	esc_html__('Force full width', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'		=>	'image_style',
				'default'			=> 'off'
			),
			'image_sizing'     => array(
                'label'             => esc_html('Image Max Width', 'et_builder'),
                'type'              => 'range',
                'toggle_slug'       => 'image_style',
                'tab_slug'          => 'advanced',
                'range_settings '   => array(
                    'min'       => '0',
                    'max'       => '100',
                    'step'      => '1',
                ),
                'default'          => '100%',
                'default_unit'     => '%',
				'allow_empty'      => true,
				'show_if_not'	   => array(
					'image_force_fullwidth'	=> 'on'
				)
			),
		);
		$next_prev_button_settings = array(
			'arrow_position'	=> array(
				'label'				=> 	esc_html__('Position', 'et_builder'),
				'type'				=>	'select',
				'options'           => array(
					'middle-inside' => esc_html__( 'Middle & Inside the container', 'et_builder' ),
					'middle-outside' => esc_html__( 'Middle & Outside the container', 'et_builder' ),
					'top' => esc_html__( 'Top', 'et_builder' ),
					'bottom' => esc_html__( 'Bottom', 'et_builder' ),
				),
				'tab_slug'        	=>  'advanced',
				'toggle_slug'		=>  'next_prev_button',
				'default'			=>  'middle-inside',
				'mobile_options'    => true,
			),
			'arrow_show_hover'	=> array(
				'label'				=> 	esc_html__('Show on hover (Only for middle position)', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'tab_slug'        	=>  'advanced',
				'toggle_slug'		=>	'next_prev_button',
				'default'			=> 'off',
			),
			'arrow_alignment'	=> array(
				'label'				=> 	esc_html__('Alignment for top & bottom position', 'et_builder'),
				'type'				=>	'select',
				'options'           => array(
					'space-between' => esc_html__( 'default', 'et_builder' ),
					'flex-start' 	=> esc_html__( 'Left', 'et_builder' ),
					'center' 		=> esc_html__( 'Center', 'et_builder' ),
					'flex-end' 		=> esc_html__( 'Right', 'et_builder' ),
					'space-between' => esc_html__( 'Justify', 'et_builder' ),
				),
				'tab_slug'        	=>  'advanced',
				'toggle_slug'		=>  'next_prev_button',
				'default'			=>  'space-between',
			),
			
			// Next & Previous Button
			'use_prev_icon'	=> array(
				'label'				=> 	esc_html__('Use previous custom icon', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'		=>	'next_prev_button',
				'default'			=> 'off',
			),
			'prev_icon' => array(
				'label'               => esc_html__( 'Select previous icon', 'et_builder' ),
				'type'                => 'et_font_icon_select',
				'renderer'            => 'select_icon',
				'renderer_with_field' => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'next_prev_button',
				'show_if'         => array(
					'use_prev_icon' => 'on',
				),
			),
			'use_next_icon'	=> array(
				'label'				=> 	esc_html__('Use next custom icon', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'		=>	'next_prev_button',
				'default'			=> 'off',
			),
			'next_icon' => array(
				'label'               => esc_html__( 'Select next icon', 'et_builder' ),
				'type'                => 'et_font_icon_select',
				'renderer'            => 'select_icon',
				'renderer_with_field' => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'next_prev_button',
				'show_if'         => array(
					'use_next_icon' => 'on',
				),
			),
			'arrow_font_size' => array(
				'label'             => esc_html__( 'Font Size', 'et_builder' ),
				'type'              => 'range',
				'mobile_options'    => true,
                'responsive'        => true,
                'default'           => '53px',
                'default_unit'      => 'px',
				'range_settings '   => array(
                    'min'       => '0',
                    'max'       => '100',
                    'step'      => '1',
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'next_prev_button',
			),
		);
		$zindex 			= array(
			'image_container_zindex' => array(
				'label'             => esc_html__( 'Image Container', 'et_builder' ),
				'type'              => 'range',
				'mobile_options'    => true,
                'responsive'        => true,
                'default'           => '10',
				// 'default_unit'      => ' ',
				'unitless'         => true,
				'range_settings '   => array(
                    'min'       => '0',
                    'max'       => '100',
                    'step'      => '1',
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'zindex_settings',
			),
			'content_container_zindex' => array(
				'label'             => esc_html__( 'Content Container', 'et_builder' ),
				'type'              => 'range',
				'mobile_options'    => true,
                'responsive'        => true,
                'default'           => '10',
				// 'default_unit'      => ' ',
				'unitless'         => true,
				'range_settings '   => array(
                    'min'       => '0',
                    'max'       => '100',
                    'step'      => '1',
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'zindex_settings',
			),
		);

		$title_background 	=	array(
			'title_background' => array(
				'label'           => esc_html__( 'Background Color', 'et_builder' ),
				'type'            => 'color-alpha',
				'tab_slug'        => 'advanced',
				'toggle_slug'	  => 'title_style',
				// 'default'		  => 'rgba(51, 51, 51, 0.59)',
				'hover'			  => 'tabs'
			),
		);
		$subtitle_background 	=	array(
			'subtitle_background' => array(
				'label'           => esc_html__( 'Background Color', 'et_builder' ),
				'type'            => 'color-alpha',
				'tab_slug'        => 'advanced',
				'toggle_slug'	  => 'subtitle_style',
				'hover'			  => 'tabs'
			),
		);
		$content_background 	=	array(
			'content_background' => array(
				'label'           => esc_html__( 'Background Color', 'et_builder' ),
				'type'            => 'color-alpha',
				'tab_slug'        => 'advanced',
				'toggle_slug'	  => 'body_text_style',
				// 'default'		  => 'rgba(51, 51, 51, 0.59)',
				'hover'			  => 'tabs'
			),
		);
		
		$item_margin = $_ex::add_margin_padding_field(
			'item_margin',
			'Carousel Item Margin',
			'custom_spacing',
			'container'
		);
		$item_padding = $_ex::add_margin_padding_field(
			'item_padding',
			'Carousel Item Padding',
			'custom_spacing',
			'container'
		);
		$image_container_margin = $_ex::add_margin_padding_field(
			'image_container_margin',
			'Image Container Margin',
			'custom_spacing',
			'container'
		);
		$image_container_padding = $_ex::add_margin_padding_field(
			'image_container_padding',
			'Image Container Padding',
			'custom_spacing',
			'container'
		);
		$image_padding = $_ex::add_margin_padding_field(
			'image_padding',
			'Image Padding',
			'custom_spacing',
			'content'
		);
		$content_container_margin = $_ex::add_margin_padding_field(
			'content_container_margin',
			'Content Container Margin',
			'custom_spacing',
			'container'
		);
		$content_container_padding = $_ex::add_margin_padding_field(
			'content_container_padding',
			'Content Container Padding',
			'custom_spacing',
			'container'
		);
		$title_margin = $_ex::add_margin_padding_field(
			'title_margin',
			'Title Margin',
			'custom_spacing',
			'content'
		);
		$title_padding = $_ex::add_margin_padding_field(
			'title_padding',
			'Title Padding',
			'custom_spacing',
			'content'
		);
		$subtitle_margin = $_ex::add_margin_padding_field(
			'subtitle_margin',
			'Subtitle Margin',
			'custom_spacing',
			'content'
		);
		$subtitle_padding = $_ex::add_margin_padding_field(
			'subtitle_padding',
			'Subtitle Padding',
			'custom_spacing',
			'content'
		);
		$text_margin = $_ex::add_margin_padding_field(
			'text_margin',
			'Text Margin',
			'custom_spacing',
			'content'
		);
		$text_padding = $_ex::add_margin_padding_field(
			'text_padding',
			'Text Padding',
			'custom_spacing',
			'content'
		);
		$button_margin = $_ex::add_margin_padding_field(
			'button_margin',
			'Button Margin',
			'custom_spacing',
			'content'
		);
		$button_padding = $_ex::add_margin_padding_field(
			'button_padding',
			'Button Padding',
			'custom_spacing',
			'content'
		);
		
		$social_container_margin = $_ex::add_margin_padding_field(
			'social_container_margin',
			'Social Media Container Margin',
			'custom_spacing',
			'container'
		);
		$social_container_padding = $_ex::add_margin_padding_field(
			'social_container_padding',
			'Social Media Container Padding',
			'custom_spacing',
			'container'
		);
		$social_item_margin = $_ex::add_margin_padding_field(
			'social_item_margin',
			'Social Media Item Margin',
			'custom_spacing',
			'content'
		);
		$social_item_padding = $_ex::add_margin_padding_field(
			'social_item_padding',
			'Social Media Item Padding',
			'custom_spacing',
			'content'
		);
		$rating_container_margin = $_ex::add_margin_padding_field(
			'rating_container_margin',
			'Rating Container Margin',
			'custom_spacing',
			'container'
		);
		$innercontent_padding = $_ex::add_margin_padding_field(
			'innercontent_padding',
			'Inner Wrapper Padding',
			'custom_spacing',
			'container'
		);
		$carousel_container_margin = $_ex::add_margin_padding_field(
			'carousel_container_margin',
			'Carousel Container Margin',
			'custom_spacing',
			'container'
		);
		$carousel_container_padding = $_ex::add_margin_padding_field(
			'carousel_container_padding',
			'Carousel Container Padding',
			'custom_spacing',
			'container'
		);
		
		return array_merge(
			$general,
			$zindex,
			$title_background,
			$subtitle_background,
			$content_background,
			$image_settings,
			$next_prev_button_settings,
			$carousel_container_margin,
			$carousel_container_padding,
			$innercontent_padding,
			$item_padding,
			$image_container_margin,
			$image_container_padding,
			$image_padding,
			$title_margin,
			$title_padding,
			$subtitle_margin,
			$subtitle_padding,
			$text_margin,
			$text_padding,
			$button_margin,
			$button_padding,
			$content_container_margin,
			$content_container_padding,
			$social_container_margin,
			$social_container_padding,
			$social_item_margin,
			$social_item_padding,
			$rating_container_margin
		);
	}

	public function return_data_value($value) {
		return (!empty($value)) ? $value : '';
	}
	
	public function additional_css_styles($render_slug){
		$image_width				=	$this->props['image_sizing'];
		$image_align				=	$this->props['align'];
		$inner_content_padding		=	array_diff(explode("|", $this->props['innercontent_padding']), ['true', 'false']);
		$order_class 				= 	self::get_module_order_class( $render_slug );
		$_ex 						= "DICA_Extends";
		
		// add transition values to items
		ET_Builder_Element::set_style($render_slug, array(
			'selector' => '%%order_class%% .dica_divi_carouselitem > div, %%order_class%% .dica_divi_carouselitem > div *, %%order_class%% .dica_divi_carouselitem .dica-rating span:before',
			'declaration' => sprintf('transition: all %1$s %2$s %3$s !important;', 
				$this->props['hover_transition_duration'],
				$this->props['hover_transition_speed_curve'],
				$this->props['hover_transition_delay']
			),
		));

		// Items Margin and Padding
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'item_padding', 
			'padding', 
			'%%order_class%% .dica_divi_carouselitem > div',
			'%%order_class%% .dica_divi_carouselitem > div:hover'
		);
		// Image container Margin and Padding
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'image_container_margin', 
			'margin', 
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem .dica-image-container',
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem:hover .dica-image-container'
		);
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'image_container_padding', 
			'padding', 
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem .dica-image-container',
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem:hover .dica-image-container'
		);
		// Image Margin and Padding
		// $this->apply_margin_padding(
		// 	$render_slug, 
		// 	'image_margin', 
		// 	'margin', 
		// 	'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem .dica-image-container img',
		// 	'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem:hover .dica-image-container img'
		// );
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'image_padding', 
			'padding', 
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem .dica-image-container img',
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem:hover .dica-image-container img'
		);
		// Content Container Margin and Padding
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'content_container_margin', 
			'margin', 
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem .dica-item-content',
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem:hover .dica-item-content'
		);
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'content_container_padding', 
			'padding', 
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem .dica-item-content',
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem:hover .dica-item-content'
		);
		// Title Margin and Padding
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'title_margin', 
			'margin', 
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem .dica-item-content > .item-title',
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem:hover .dica-item-content > .item-title'
		);
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'title_padding', 
			'padding', 
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem .dica-item-content > .item-title',
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem:hover .dica-item-content > .item-title'
		);
		// Subtitle Margin and Padding
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'subtitle_margin', 
			'margin', 
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem .dica-item-content > .item-subtitle',
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem:hover .dica-item-content > .item-subtitle'
		);
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'subtitle_padding', 
			'padding', 
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem .dica-item-content > .item-subtitle',
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem:hover .dica-item-content > .item-subtitle'
		);
		// Text Margin and Padding
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'text_margin', 
			'margin', 
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem .dica-item-content .content',
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem:hover .dica-item-content .content'
		);
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'text_padding', 
			'padding', 
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem .dica-item-content .content',
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem:hover .dica-item-content .content'
		);
		// Button Margin and Padding
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'button_margin', 
			'margin', 
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem .dica-item-content > div:not(.content):not(.dica-image-container):not(.social-media-container) a',
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem:hover .dica-item-content > div:not(.content):not(.dica-image-container):not(.social-media-container) a'
		);
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'button_padding', 
			'padding', 
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem .dica-item-content > div:not(.content):not(.dica-image-container):not(.social-media-container) a',
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem:hover .dica-item-content > div:not(.content):not(.dica-image-container):not(.social-media-container) a'
		);
		// social media container spacing
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'social_container_margin', 
			'margin', 
			'%%order_class%% .dica_divi_carouselitem .social-media-container',
			'%%order_class%% .dica_divi_carouselitem:hover .social-media-container'
		);
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'social_container_padding', 
			'padding', 
			"%%order_class%% .dica_divi_carouselitem .social-media-container",
			"%%order_class%% .dica_divi_carouselitem:hover .social-media-container"
		);
		// social media item spacing
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'social_item_margin', 
			'margin', 
			'%%order_class%% .dica_divi_carouselitem .social-media-container ul li',
			'%%order_class%% .dica_divi_carouselitem .social-media-container ul li:hover'
		);
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'social_item_padding', 
			'padding', 
			'%%order_class%% .dica_divi_carouselitem .social-media-container ul li a',
			'%%order_class%% .dica_divi_carouselitem .social-media-container ul li:hover a'
		);
		// rating container spacing
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'rating_container_margin', 
			'margin', 
			'%%order_class%% .dica_divi_carouselitem .dica-rating-container',
			'%%order_class%% .dica_divi_carouselitem:hover .dica-rating-container'
		);
		// Carousel container margin
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'carousel_container_margin', 
			'margin', 
			'%%order_class%%.dica_divi_carousel .dica-container',
			'%%order_class%%.dica_divi_carousel .dica-container:hover'
		);
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'carousel_container_padding', 
			'padding', 
			'%%order_class%%.dica_divi_carousel .dica-container',
			'%%order_class%%.dica_divi_carousel .dica-container:hover'
		);
		// Inner container padding
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'innercontent_padding', 
			'padding', 
			'%%order_class%% .swiper-container',
			'%%order_class%% .swiper-container:hover'
		);
		// title background color
		$_ex::apply_element_color(
			$this,
			$render_slug, 
			'title_background', 
			'background-color', 
			'%%order_class%% .dica-item .dica-item-content > .item-title',
			'%%order_class%% .dica_divi_carouselitem:hover .dica-item .dica-item-content > .item-title', 
			true
		);
		// title background color
		$_ex::apply_element_color(
			$this,
			$render_slug, 
			'subtitle_background', 
			'background-color', 
			'%%order_class%% .dica-item .dica-item-content > .item-subtitle',
			'%%order_class%% .dica_divi_carouselitem:hover .dica-item .dica-item-content > .item-subtitle', 
			true
		);
		// content background color
		$_ex::apply_element_color(
			$this,
			$render_slug, 
			'content_background', 
			'background-color', 
			'%%order_class%% .dica-item .dica-item-content > .content',
			'%%order_class%% .dica_divi_carouselitem:hover .dica-item .dica-item-content > .content', 
			true
		);
		// Apply item width
		if('on' === $this->props['item_width_auto']) {
		$_ex::control_width_and_spacing(
			$this,
			$render_slug, 
			'item_width', 
			'width', 
			'%%order_class%%.dica_divi_carousel .dica_divi_carouselitem');
		}
		// image width control
		$image_width = '' == $image_width ? '100%' : $image_width;
		if('' !== $image_width && 'on' !== $this->props['image_force_fullwidth'] ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .dica_divi_carouselitem .dica-image-container a',
                'declaration' => sprintf(
                    'max-width:%1$s;', $image_width),
            ) );
		}
		if ('on' === $this->props['image_force_fullwidth']) {
			ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .dica_divi_carouselitem .dica-image-container img',
                'declaration' => 'width: 100%;',
            ) );
			ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .dica_divi_carouselitem .dica-image-container a',
                'declaration' => 'width: 100%;',
            ) );
		}
		// image alignment
		if('' !== $image_align) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .dica_divi_carouselitem .dica-image-container',
				'declaration' => sprintf(
					'text-align: %1$s!important;', $image_align),
			) );
		} else {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .dica_divi_carouselitem .dica-image-container',
				'declaration' => 'text-align: center!important;',
			) );
		}
		// if('' !== $image_align) {
		// 	if($image_align == 'left'){
		// 		ET_Builder_Element::set_style( $render_slug, array(
        //             'selector'    => '%%order_class%% .dica_divi_carouselitem .dica-image-container a',
        //             'declaration' => sprintf(
        //                 'margin-left: 0!important;margin-right: auto!important;'),
        //         ) );
		// 	}elseif($image_align == 'center'){
		// 		ET_Builder_Element::set_style( $render_slug, array(
        //             'selector'    => '%%order_class%% .dica_divi_carouselitem .dica-image-container a',
        //             'declaration' => sprintf(
        //                 'margin-left: auto!important;margin-right: auto!important;'),
        //         ) );
		// 	}elseif($image_align == 'right') {
		// 		ET_Builder_Element::set_style( $render_slug, array(
        //             'selector'    => '%%order_class%% .dica_divi_carouselitem .dica-image-container a',
        //             'declaration' => sprintf(
        //                 'margin-left: auto!important;margin-right: 0!important;'),
        //         ) );
		// 	}
		// 	if($image_align == 'left'){
		// 		ET_Builder_Element::set_style( $render_slug, array(
        //             'selector'    => '%%order_class%% .dica_divi_carouselitem .dica-image-container img',
        //             'declaration' => sprintf(
        //                 'margin-left: 0!important;margin-right: auto!important;'),
        //         ) );
		// 	}elseif($image_align == 'center'){
		// 		ET_Builder_Element::set_style( $render_slug, array(
        //             'selector'    => '%%order_class%% .dica_divi_carouselitem .dica-image-container img',
        //             'declaration' => sprintf(
        //                 'margin-left: auto!important;margin-right: auto!important;'),
        //         ) );
		// 	}elseif($image_align == 'right') {
		// 		ET_Builder_Element::set_style( $render_slug, array(
        //             'selector'    => '%%order_class%% .dica_divi_carouselitem .dica-image-container img',
        //             'declaration' => sprintf(
        //                 'margin-left: auto!important;margin-right: 0!important;'),
        //         ) );
		// 	}
		// }
		if('' !== $this->props['arrow_nav_color']) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .swiper-button-next:before,%%order_class%% .swiper-button-prev:before',
                'declaration' => sprintf(
                    'color:%1$s!important;', $this->props['arrow_nav_color']),
            ) );
		}
		if('' !== $this->props['arrow_bg_color']) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%%.dica_divi_carousel .swiper-button-next,%%order_class%%.dica_divi_carousel .swiper-button-prev',
                'declaration' => sprintf(
                    'background-color:%1$s!important;', $this->props['arrow_bg_color']),
            ) );
		}
		if('' !== $this->props['dots_color']) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%%.dica_divi_carousel .swiper-pagination-bullet',
                'declaration' => sprintf(
                    'background-color:%1$s!important;', $this->props['dots_color']),
            ) );
		}
		if('' !== $this->props['dots_active_color']) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%%.dica_divi_carousel .swiper-pagination-bullet.swiper-pagination-bullet-active',
                'declaration' => sprintf(
                    'background-color:%1$s!important;', $this->props['dots_active_color']),
            ) );
		}
		if( 'on' === $this->props['equal_height']) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%%.dica_divi_carousel .dica-container .swiper-wrapper .dica_divi_carouselitem',
                'declaration' => 'height:100%;',
            ) );
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%%.dica_divi_carousel .dica_divi_carouselitem .dica-item-content',
                'declaration' => 'flex-grow: 1;',
            ) );
		}
		if( 'on' !== $this->props['equal_height'] && '' !== $this->props['item_vertical_align']) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%%.dica_divi_carousel .dica-container .swiper-wrapper .dica_divi_carouselitem',
                'declaration' => sprintf('align-self:%1$s;', $this->props['item_vertical_align']),
            ) );
		}
		if($this->props['dot_alignment'] !== '') {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%%.dica_divi_carousel .dica-container .swiper-pagination',
                'declaration' => sprintf('text-align:%1$s;', $this->props['dot_alignment']),
            ) );
		}
		// overlay custom icon style
		if($this->props['use_overlay_icon'] == 'on') {
			$overlay_icon = html_entity_decode(esc_attr(et_pb_process_font_icon($this->props['overlay_icon'])));
			ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%%.dica_divi_carousel .overlay-image .dica-item .dica-image-container a.image:after',
                'declaration' => sprintf('content:"%1$s" !important;', $overlay_icon),
			) );
		}
		if($this->props['overlay_image'] == 'on') {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%%.dica_divi_carousel .overlay-image .dica-item .dica-image-container a:before',
                'declaration' => sprintf('background-color:%1$s !important;', $this->props['overlay_color']),
			) );
			ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%%.dica_divi_carousel .overlay-image .dica-item .dica-image-container a:after',
                'declaration' => sprintf('color:%1$s !important;', $this->props['overlay_icon_color']),
            ) );
		}

		// arrow width and height and font-size
		if(isset($this->props['arrow_font_size']) && '' !== $this->props['arrow_font_size']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%% .dica-container .swiper-button-next, %%order_class%% .dica-container .swiper-button-prev',
				'declaration' => sprintf('font-size:%1$s; width:%1$s; height:%1$s;', 
				$this->props['arrow_font_size']),
			));
		}
		if(isset($this->props['arrow_font_size_tablet']) && '' !== $this->props['arrow_font_size_tablet']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%% .dica-container .swiper-button-next, %%order_class%% .dica-container .swiper-button-prev',
				'declaration' => sprintf('font-size:%1$s; width:%1$s; height:%1$s;', 
				$this->props['arrow_font_size_tablet']),
				'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
			));
		}
		if(isset($this->props['arrow_font_size_phone']) && '' !== $this->props['arrow_font_size_phone']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%% .dica-container .swiper-button-next, %%order_class%% .dica-container .swiper-button-prev',
				'declaration' => sprintf('font-size:%1$s; width:%1$s; height:%1$s;', 
				$this->props['arrow_font_size_phone']),
				'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
			));
		}
		// arrow alignment
		if (isset($this->props['arrow_alignment'])) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%% .dica-container .swiper-buttton-container',
				'declaration' => sprintf('justify-content:%1$s;', 
				$this->props['arrow_alignment']),
			));
		}
		// if (isset($this->props['arrow_alignment']) && $this->props['arrow_position'] === 'top' || $this->props['arrow_position'] === 'bottom' ) {
		// 	ET_Builder_Element::set_style($render_slug, array(
		// 		'selector' => '%%order_class%% .dica-container.tablet_top .swiper-buttton-container,
		// 		%%order_class%% .dica-container.tablet_bottom .swiper-buttton-container',
		// 		'declaration' => sprintf('justify-content:%1$s;', 
		// 		$this->props['arrow_alignment']),
		// 		'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
		// 	));
		// } else {
		// 	ET_Builder_Element::set_style($render_slug, array(
		// 		'selector' => '%%order_class%% .dica-container.tablet_top .swiper-buttton-container,
		// 		%%order_class%% .dica-container.tablet_bottom .swiper-buttton-container',
		// 		'declaration' => 'justify-content: space-between;',
		// 		'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
		// 	));
		// }
		// if (isset($this->props['arrow_alignment']) && $this->props['arrow_position'] === 'top' || $this->props['arrow_position'] === 'bottom' ) {
		// 	ET_Builder_Element::set_style($render_slug, array(
		// 		'selector' => '%%order_class%% .dica-container.mobile_top .swiper-buttton-container,
		// 		%%order_class%% .dica-container.mobile_bottom .swiper-buttton-container',
		// 		'declaration' => sprintf('justify-content:%1$s;', 
		// 		$this->props['arrow_alignment']),
		// 		'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
		// 	));
		// } else {
		// 	ET_Builder_Element::set_style($render_slug, array(
		// 		'selector' => '%%order_class%% .dica-container.mobile_top .swiper-buttton-container,
		// 		%%order_class%% .dica-container.mobile_bottom .swiper-buttton-container',
		// 		'declaration' => 'justify-content: space-between;',
		// 		'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
		// 	));
		// }

		// smooth scroll effect
		if('on' === $this->props['scroller_effect']) {
			ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%%.dica_divi_carousel .swiper-wrapper',
				'declaration' => '-webkit-transition-timing-function:linear!important;
				-o-transition-timing-function:linear!important;
				transition-timing-function: linear !important; 
				transition-duration:2000ms;',
			) );
		}
		// add transition values to items
		// ET_Builder_Element::set_style($render_slug, array(
		// 	'selector' => sprintf('%1$s', implode(',', array_unique($this->hoverTransitionSelector))),
		// 	'declaration' => sprintf('transition: all %1$s %2$s %3$s,
		// 	width 0ms, height 0ms, flex 0ms, flex-shrink 0ms, flex-grow 0ms !important;
		// 	animation-duration: 0ms !important;', 
		// 		$this->props['hover_transition_duration'],
		// 		$this->props['hover_transition_speed_curve'],
		// 		$this->props['hover_transition_delay']
		// 	),
		// ));
		$_ex::process_single_value(array(
			'module'		=> $this,
			'render_slug'	=> $render_slug,
			'slug'			=> 'image_container_zindex',
			'selector'      => '%%order_class%% .dica_divi_carouselitem .dica-image-container',
			'type'			=> 'z-index',
			'unit_type'		=> false,
			'default'       => '10',
		));
		$_ex::process_single_value(array(
			'module'		=> $this,
			'render_slug'	=> $render_slug,
			'slug'			=> 'content_container_zindex',
			'selector'      => '%%order_class%% .dica_divi_carouselitem .dica-item-content',
			'type'			=> 'z-index',
			'unit_type'		=> false,
			'default'       => '10',
		));

	}

	public function get_custom_css_fields_config() {
		return array(
			'title' => array(
				'label'    => esc_html__( 'Title', 'et_builder' ),
				'selector' => '%%order_class%%.dica_divi_carousel .dica-container .swiper-wrapper .dica_divi_carouselitem .item-title',
			),
			'content' => array(
				'label'    => esc_html__( 'Content', 'et_builder' ),
				'selector' => '%%order_class%%.dica_divi_carousel .dica-container .swiper-wrapper .dica_divi_carouselitem .content',
			),
			'image' => array(
				'label'    => esc_html__( 'Image', 'et_builder' ),
				'selector' => '%%order_class%%.dica_divi_carousel .dica-container .swiper-wrapper .dica_divi_carouselitem .dica-image-container img',
			),
			'button' => array(
				'label'    => esc_html__( 'Button', 'et_builder' ),
				'selector' => '%%order_class%%.dica_divi_carousel .dica-container .swiper-wrapper .dica_divi_carouselitem .et_pb_button',
			),
			'social_media' => array(
				'label'    => esc_html__( 'Social Icon', 'et_builder' ),
				'selector' => '%%order_class%%.dica_divi_carousel .dica_divi_carouselitem .social-media-container .social-media li a',
			),
		);
	}

	public function render( $attrs, $content = null, $render_slug ) {

		$classes = '';
		$item_spacing = $this->props['item_spacing'];
		$item_spacing_tablet = isset($this->props['item_spacing_tablet']) && $this->props['item_spacing_tablet'] !== '' ? 
								$this->props['item_spacing_tablet'] : $item_spacing;
		$item_spacing_phone = isset($this->props['item_spacing_phone']) && $this->props['item_spacing_phone'] !== '' ? 
								$this->props['item_spacing_phone'] : $item_spacing;
		$arrow_show_hover_class = $this->props['arrow_show_hover'] == 'on' ? ' arrow-show-hover' : '';
		
		$order_class 	= self::get_module_order_class( $render_slug );
		$order_number	= str_replace('_','',str_replace($this->slug,'', $order_class));

		$this->additional_css_styles($render_slug);
		$coverflow = sprintf('cover-rotate="%1$s" ', 
								$this->return_data_value($this->props['coverflow_rotate'])
							);
		
		
		// filter for main container
		if (array_key_exists('image', $this->advanced_fields) && array_key_exists('css', $this->advanced_fields['image'])) {
			$this->add_classname($this->generate_css_filters(
				$render_slug,
				'child_',
				self::$data_utils->array_get($this->advanced_fields['image']['css'], 'main', '%%order_class%%')
			));
		}
		$data_attr = array(
			'desktop' => $this->return_data_value($this->props['show_items_desktop']),
			'tablet' => $this->return_data_value($this->props['show_items_tablet']),
			'mobile' => $this->return_data_value($this->props['show_items_mobile']),
			'speed' => $this->return_data_value($this->props['transition_duration']),
			'arrow' => $this->return_data_value($this->props['arrow_nav']),
			'dots' => $this->return_data_value($this->props['dot_nav']),
			'autoplay' => $this->return_data_value($this->props['autoplay']),
			'autoSpeed' => $this->return_data_value($this->props['autoplay_speed']),
			'loop' => $this->return_data_value($this->props['loop']),
			'item_spacing' => $this->props['item_spacing'],
			'center_mode' => $this->return_data_value($this->props['centermode']),
			'slider_effec' => $this->return_data_value($this->props['advanced_effect']),
			'cover_rotate' => $this->return_data_value($this->props['coverflow_rotate']),
			'pause_onhover' => $this->return_data_value($this->props['hoverpause']),
			'multislide' => $this->return_data_value($this->props['multislide']),
			'cfshadow' => $this->props['coverflow_shadow'],
			'order' => $order_number,
			'lazyload' => $this->props['lazy_loading'],
			'lazybefore' => $this->props['load_before_transition'],
			'scroller_effect' => $this->props['scroller_effect'],
			'autowidth' => $this->props['item_width_auto'],
			'item_spacing_tablet' => $item_spacing_tablet,
			'item_spacing_phone' => $item_spacing_phone,
			'scroller_speed' => $this->props['transition_duration_scroll']
		);
		
		$pagination		= ($this->props['dot_nav'] == 'on') ? 
			sprintf('<div class="swiper-pagination dica-paination-%1$s"></div>', $order_number) : '' ;

		// add overlay classes
		if ($this->props['overlay_image'] === 'on') {
			$classes = $this->add_class($classes, 'overlay-image');
		}
		// add arrow class
		$classes = $this->add_class($classes, $this->carousel_arrow_classes());
		// arrow show on hover
		if ( $this->props['arrow_show_hover'] === 'on') {
			$classes = $this->add_class($classes, 'arrow-on-hover');
		}

		$output = sprintf( '<div class="dica-container %5$s" data-props=\'%2$s\'>
							 	<div class="swiper-container">
									<div class="swiper-wrapper">%1$s</div>	
								</div>	
								%3$s
								%4$s						
							</div>', 
							et_core_sanitized_previously( $this->content ),
							json_encode($data_attr),
							$this->carousel_arraow_markup($order_number),
							$pagination,
							$classes
						);

		return $output;
	}

	/**
	 * Add module Classes
	 */
	public function add_class($classes, $class = '') {
		return $classes .= ' ' . $class;
	}
	/**
	 * Return the arraow markup depending on settings
	 */
	public function carousel_arraow_markup( $order_number) {
		$arrow_navigation = '';
		$data_prev_icon = 'on' === $this->props['use_prev_icon'] ? 
			sprintf( 'data-icon="%1$s"', esc_attr( et_pb_process_font_icon($this->props['prev_icon']) ) ) : 'data-icon="4"';
		$data_next_icon = 'on' === $this->props['use_next_icon'] ? 
			sprintf( 'data-icon="%1$s"', esc_attr( et_pb_process_font_icon($this->props['next_icon']) ) ) : 'data-icon="5"';
		
		if ($this->props['arrow_nav'] == 'on') {
			$arrow_navigation =  sprintf('<div class="swiper-button-prev dica-prev-btn-%1$s" %2$s></div><div class="swiper-button-next dica-next-btn-%1$s" %3$s></div>', 
			$order_number,
			$data_prev_icon,
			$data_next_icon ) ;

			$arrow_navigation = sprintf('<div class="swiper-buttton-container">%1$s</div>', $arrow_navigation);
		}
		
		return $arrow_navigation;
	}
	/**
	 * Generate arrow position classes
	 */
	public function carousel_arrow_classes () {
		$arrow_position_desktop = empty($this->props['arrow_position']) || $this->props['arrow_position'] == 'on' ? 'middle-inside' : $this->props['arrow_position'];
		$arrow_position_tablet = isset($this->props['arrow_position_tablet']) && '' !== $this->props['arrow_position_tablet'] ? 
			$this->props['arrow_position_tablet'] : $arrow_position_desktop;
		$arrow_position_mobile = isset($this->props['arrow_position_phone']) && '' !== $this->props['arrow_position_phone'] ? 
			$this->props['arrow_position_phone'] : $arrow_position_desktop;

		$arrow_position_desktop = 'desktop_'.$arrow_position_desktop;
		$arrow_position_tablet = 'tablet_'.$arrow_position_tablet;
		$arrow_position_mobile = 'mobile_'.$arrow_position_mobile;
		
		return $arrow_position_desktop . ' ' . $arrow_position_tablet . ' ' . $arrow_position_mobile;
	}
	/**
	 * Opacity for non-active slide in 'center mode'
	 */
	public function non_active_slide_opacity( $render_slug, $itemKey, $selector ) {
		if ( isset($this->props[$itemKey])) {
			$opacity = $this->props[$itemKey]/100;
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => $selector,
				'declaration' => sprintf('opacity:%1$s !important;',$opacity),
			));
		}
	}

}

new DiviCarousel;
