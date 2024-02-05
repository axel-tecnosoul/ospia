<?php
class DICA_Extends {
    /**
     * Adding margin padding fields with 
     * hover and responsive settings
     * @param key the field key
     * @param title field title
     * @param toggle_slug slug for the settings group
     * @param sub_toggle slug for the sub settings group
     * @param priority setting view priority
     * @return array()
     */
    static function add_margin_padding_field($key, $title, $toggle_slug, $sub_toggle = '', $priority = 30 ) {
		$margin_padding = array();
		$margin_padding[$key] = array(
			'label'				=> sprintf(esc_html__('%1$s', 'et_builder'), $title),
			'type'				=> 'custom_margin',
			'toggle_slug'       => $toggle_slug,
			'sub_toggle'		=> $sub_toggle,
			'tab_slug'			=> 'advanced',
			'mobile_options'    => true,
			'hover'				=> 'tabs',
			'priority' 			=> $priority,
		);
		$margin_padding[$key . '_tablet'] = array(
			'type'            	=> 'skip',
			'tab_slug'        	=> 'advanced',
			'toggle_slug'		=> $toggle_slug,
		);
		$margin_padding[$key.'_phone'] = array(
			'type'            	=> 'skip',
			'tab_slug'        	=> 'advanced',
			'toggle_slug'		=> $toggle_slug,
		);
		$margin_padding[$key.'_last_edited'] = array(
			'type'            	=> 'skip',
			'tab_slug'        	=> 'advanced',
			'toggle_slug'		=> $toggle_slug,
		);
		return $margin_padding;
    }
    
    /**
	 * Generate margin and padding styles with the value
     * @param module the module object itself
     * @param render_slug 
     * @param slug the slug of the settings
     * @param type margin/padding
     * @param class the selector for the styles
     * @param hoverSelector the selector for the hover
     * @param important whether or not the important applied
     * @return null
	 */
	static function apply_margin_padding($module, $render_slug, $slug, $type, $class, $hoverSelector, $important = true) {
		$desktop 				= $module->props[$slug];
		$tablet 				= $module->props[$slug.'_tablet'];
		$phone 					= $module->props[$slug.'_phone'];
        if (class_exists('ET_Builder_Element')) {
            if(isset($desktop) && !empty($desktop)) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $class,
                    'declaration' => et_builder_get_element_style_css($desktop, $type, $important),
                ));
            }
            if (isset($tablet) && !empty($tablet)) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $class,
                    'declaration' => et_builder_get_element_style_css($tablet, $type, $important),
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                ));
            }
            if (isset($phone) && !empty($phone)) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $class,
                    'declaration' => et_builder_get_element_style_css($phone, $type, $important),
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                ));
            }
			if (et_builder_is_hover_enabled( $slug, $module->props ) && isset($module->props[$slug.'__hover']) ) {
				$hover = $module->props[$slug.'__hover'];
				ET_Builder_Element::set_style($render_slug, array(
					'selector' => $hoverSelector,
					'declaration' => et_builder_get_element_style_css($hover, $type, $important),
				));
			}
        }
	}
    /**
	 * Generate styles with the color value
     * @param module the module object itself
     * @param render_slug 
     * @param slug the slug of the settings
     * @param type color/background-color
     * @param class css selector
     * @param hover_class hover selector
     * @param important important text
     * @return null
	 */
	static function apply_element_color( $module, $render_slug, $slug, $type, $class, $hover_class, $important = false) {
		$key = $module->props[$slug];
		$important_text = true === $important ? '!important' : '';
		if ('' !== $key) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => $class,
				'declaration' => sprintf('%2$s: %1$s %3$s;', $key, $type, $important_text),
			));
		}
		if ( et_builder_is_hover_enabled( $slug, $module->props ) && isset($module->props[$slug . '__hover']) ) {
			$slug_hover = $module->props[$slug . '__hover'];
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => $hover_class,
				'declaration' => sprintf('%2$s: %1$s %3$s;', $slug_hover, $type, $important_text),
			));
		}
    }
    
    /**
	 * Generate styles wiht the single 
     * value setting ( like: font-size, spacing )
     * @param module
     * @param render_slug
     * @param slug
     * @param type
     * @param class
     * @param unit
     * @param decrease
     * @param addition
     * @return null
	 */
	static function apply_single_value($module, $render_slug, $slug, $type, $class,$unit = '%', $decrease = false, $addition = true) {
		$desk = $module->props[$slug];
		$tab = empty($module->props[$slug.'_tablet']) ? $desk : $module->props[$slug.'_tablet'];
		$mob = empty($module->props[$slug.'_phone']) ? $desk : $module->props[$slug.'_phone'];

		$desktop 	= $decrease === false ? intval($desk) : 100 - intval($desk) ;
		$tablet 	= $decrease === false ? intval($tab) : 100 - intval($tab);
		$phone 		= $decrease === false ? intval($mob) : 100 - intval($mob);
		$negative = $addition == false ? '-' : '';

		$desktop.= $unit;
		$tablet.= $unit;
		$phone.= $unit;
		if(isset($desktop) && !empty($desktop)) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => $class,
				'declaration' => sprintf('%1$s:%3$s%2$s !important;', $type, $desktop, $negative),
			));
		}
		if (isset($tablet) && !empty($tablet)) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => $class,
				'declaration' => sprintf('%1$s:%3$s%2$s !important;', $type, $tablet,$negative),
				'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
			));
		}
		if (isset($phone) && !empty($phone)) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => $class,
				'declaration' => sprintf('%1$s:%3$s%2$s !important;', $type, $phone,$negative),
				'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
			));
		}
    }
    /**
	 * Generate styles wiht the single 
     * value setting ( like: font-size, spacing )
	 */
    static function control_width_and_spacing($module,$render_slug, $slug, $type, $class, $important = true) {
		$desktop 				= $module->props[$slug];
		$tablet 				= $module->props[$slug.'_tablet'];
		$phone 					= $module->props[$slug.'_phone'];
		$important_text 		= $important === true ? '!important' : '';

		if(isset($desktop) && !empty($desktop)) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => $class,
				'declaration' => sprintf('%1$s:%2$s%3$s;',$type, $desktop, $important_text),
			));
		}
		if (isset($tablet) && !empty($tablet)) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => $class,
				'declaration' => sprintf('%1$s:%2$s%3$s;',$type, $tablet, $important_text),
				'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
			));
		}
		if (isset($phone) && !empty($phone)) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => $class,
				'declaration' => sprintf('%1$s:%2$s%3$s;',$type, $phone, $important_text),
				'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
			));
		}
	}
	/**
	 * Render title
	 */
	static function render_title( $title, $current, $position ) {
		if ( $current === $position ) {
			return $title;
		} else {
			return null;
		}
	}
	/**
	 * Render subtitle
	 */
	static function render_subtitle($subtitle, $current, $position) {
		if ( !empty($subtitle)) {
			if ( $current === $position ) {
				return '<h6 class="item-subtitle">'.$subtitle.'</h6>';
			} else {
				return null;
			}
		} 
	}
	/**
     * Process single value
     */
    static function process_single_value($options = array()) {

        $default = array(
            'module'            => '',
            'render_slug'       => '',
            'slug'              => '',
            'type'              => '',
            'selector'          => '',
            'unit'              => '%',
            'hover'             => '',
            'decrease'          => false,
            'addition'          => true,
            'important'         => true,
			'default'           => '14',
			'unit_type'			=> true
        );
        $options        = wp_parse_args( $options, $default );
        extract($options);
        $unit_value = !empty(str_replace(intval($module->props[$slug]), "", $module->props[$slug])) ? str_replace(intval($module->props[$slug]), "", $module->props[$slug]) : $unit;
        $unit_value_tab = str_replace(intval($module->props[$slug.'_tablet']), "", $module->props[$slug.'_tablet']) !== '' ? 
            str_replace(intval($module->props[$slug.'_tablet']), "", $module->props[$slug.'_tablet']) : $unit_value;
        $unit_value_ph = str_replace(intval($module->props[$slug.'_phone']), "", $module->props[$slug.'_phone']) !== '' ? 
            str_replace(intval($module->props[$slug.'_phone']), "", $module->props[$slug.'_phone']) : $unit_value_tab;

        $desktop_value  =  !empty($module->props[$slug]) ? $module->props[$slug] : $default;
        $tablet_value   =  !empty($module->props[$slug.'_tablet']) ?$module->props[$slug.'_tablet'] : $desktop_value;
        $mobile_value   =  !empty($module->props[$slug.'_phone']) ? $module->props[$slug.'_phone'] : $tablet_value;

		$desktop 	= $decrease === false ? intval($desktop_value) : 100 - intval($desktop_value);
		$tablet 	= $decrease === false ? intval($tablet_value) : 100 - intval($tablet_value);
		$phone 		= $decrease === false ? intval($mobile_value) : 100 - intval($mobile_value);
		$negative   = $addition == false ? '-' : '';

		if ($unit_type === true) {
			$desktop    .= $unit_value;
			$tablet     .= $unit_value_tab;
			$phone      .= $unit_value_ph;
		}
		$important_text = $important === true ? '!important' : ''; 

		if(isset($desktop) && !empty($desktop)) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => $selector,
				'declaration' => sprintf('%1$s:%2$s %4$s;', $type, $desktop, $negative,$important_text),
			));
		}
		if (isset($tablet) && !empty($tablet)) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => $selector,
				'declaration' => sprintf('%1$s:%3$s%2$s %4$s;', $type, $tablet,$negative,$important_text),
				'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
			));
		}
		if (isset($phone) && !empty($phone)) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => $selector,
				'declaration' => sprintf('%1$s:%3$s%2$s %4$s;', $type, $phone,$negative,$important_text),
				'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
			));
        }
        if (et_builder_is_hover_enabled( $slug, $module->props ) && isset($module->props[$slug.'__hover'])) {
            $hover_value = $module->props[$slug.'__hover'];
            if ( !empty($hover_value)) {
                $hover_value 	= $decrease === false ? intval($hover_value) : 100 - intval($hover_value) ;
                $hover_value .= $unit_value;
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $options['hover'],
                    'declaration' => sprintf('%1$s:%2$s %3$s %4$s;', $type, $hover_value, $negative,$important_text),
                ));
            }
            
        }
    }
}