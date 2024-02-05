<?php
// Exit if accessed direCSFy.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Control core classes for avoid errors
if ( class_exists( 'CSF' ) ) {

	//
	// Set a unique slug-like ID
	$prefix = 'cool_timeline_settings';

	//
	// Create options
	CSF::createOptions(
		$prefix,
		array(
			'framework_title'    => 'Timeline Settings',
			'menu_title'         => 'Timeline Settings',
			'menu_slug'          => 'cool_timeline_settings',
			'menu_type'          => 'submenu',
			'menu_parent'        => 'cool-plugins-timeline-addon',
			'menu_capability'    => 'manage_options', // The capability needed to view the page
			'menu_icon'          => CTL_PLUGIN_URL . 'assets/images/cool-timeline-icon.svg',
			'menu_position'      => 6,
			'nav'                => 'inline',
			'show_reset_section' => false,
			'show_reset_all'     => false,
			'show_bar_menu'      => false,

			'footer_text'        => 'CoolTimeline.com',
		)
	);

	//
	// Create a section
	CSF::createSection(
		$prefix,
		array(
			'title'  => 'General Settings',
			'fields' => array(



				// Create a Fieldset
				array(
					'id'     => 'timeline_header',
					'type'   => 'fieldset',
					'title'  => 'Content Before Timeline',
					'fields' => array(
						array(
							'id'    => 'title_text',
							'type'  => 'text',
							'title' => __( 'Timeline Title', 'cool-timeline1' ),
						),
					),
				), // End Fieldset


			// Create a Fieldset
				array(
					'id'     => 'story_content_settings',
					'type'   => 'fieldset',
					'title'  => 'Story Content',
					'fields' => array(
						array(
							'id'      => 'content_length',
							'type'    => 'text',
							'title'   => __( 'Content Length', 'cool-timeline1' ),
							'default' => '50',
							'desc'    => __( 'Please enter no of words', 'cool-timeline1' ),
						),
						array(
							'id'      => 'display_readmore',
							'type'    => 'radio',
							'title'   => __( 'Display read more?', 'cool-timeline1' ),
							'options' => array(
								'yes' => __( 'Yes', 'cool-timeline1' ),
								'no'  => __( 'No', 'cool-timeline1' ),
							),
							'desc'    => __( 'It will also disable link from story title.', 'cool-timeline1' ),
							'inline'  => true,
							'default' => 'yes',
						),
						array(
							'id'         => 'story_link_target',
							'type'       => 'radio',
							'title'      => __( 'Open read more link in?', 'cool-timeline1' ),
							'options'    => array(
								'_self'  => __( 'Same Tab', 'cool-timeline1' ),
								'_blank' => __( 'New Tab', 'cool-timeline1' ),
							),
							'inline'     => true,
							'default'    => '_self',
							'dependency' => array( 'display_readmore', '==', 'yes' ),
						),

					),
				), // End Fieldset


				array(
					'id'     => 'story_date_settings',
					'type'   => 'fieldset',
					'title'  => 'Story Date',
					'fields' => array(

						array(
							'id'         => 'year_label_visibility',
							'type'       => 'switcher',
							'title'      => __( 'Year Label', 'cool-timeline1' ),
							'text_on'    => __( 'Show', 'cool-timeline1' ),
							'text_off'   => __( 'Hide', 'cool-timeline1' ),
							'text_width' => 100,
							'default'    => true,
							'desc'       => __( 'Only for Vertical and One sided layout', 'cool-timeline1' ),
						),

					),
				), // End Fieldset


				array(
					'id'      => 'first_story_position',
					'type'    => 'button_set',
					'title'   => 'Vertical Timeline Stories Starts From',
					'desc'    => 'Not for Compact and Horizontal layout',
					'options' => array(
						'left'  => 'Left',
						'right' => 'Right',
					),
					'default' => 'right',
				),

			),
		)
	);


	// Create a section
	CSF::createSection(
		$prefix,
		array(
			'title'  => 'Style Settings',
			'fields' => array(

				array(
					'id'      => 'content_bg_color',
					'type'    => 'color',
					'title'   => 'Story Background Color',
					'default' => '#ffffff',
				),

				array(
					'id'      => 'circle_border_color',
					'type'    => 'color',
					'title'   => 'Circle Color',
					'default' => '#38aab7',
				),

				array(
					'id'      => 'line_color',
					'type'    => 'color',
					'title'   => 'Line Color',
					'default' => '#025149',
				),

				array(
					'id'      => 'first_post',
					'type'    => 'color',
					'title'   => 'First Color',
					'default' => '#29b246',
				),

				array(
					'id'      => 'second_post',
					'type'    => 'color',
					'title'   => 'Second Color',
					'default' => '#ce792f',
				),

				array(
					'id'       => 'custom_styles',
					'type'     => 'code_editor',
					'title'    => 'Custom Styles',
					'settings' => array(
						'theme' => 'mbo',
						'mode'  => 'css',
					),

				),

			),
		)
	);

	// Create a section
	CSF::createSection(
		$prefix,
		array(
			'title'  => 'Typography Setings',
			'fields' => array(

				array(
					'id'         => 'ctl_date_typo',
					'type'       => 'typography',
					'title'      => 'Story Date',
					'default'    => array(
						'font-family' => 'Maven Pro',
						'font-size'   => '21',
						'line-height' => '',
						'unit'        => 'px',
						'type'        => 'google',
						'font-weight' => '700',
					),
					'text_align' => false,
					'color'      => false,
				),

				array(
					'id'      => 'post_title_typo',
					'type'    => 'typography',
					'title'   => 'Story Title',
					'default' => array(
						'font-family' => 'Maven Pro',
						'font-size'   => '20',
						'line-height' => '',
						'unit'        => 'px',
						'type'        => 'google',
						'font-weight' => '700',
					),
					'color'   => false,
				),

				// A textarea field


				array(
					'id'      => 'post_content_typo',
					'type'    => 'typography',
					'title'   => 'Post Content',
					'default' => array(
						'font-family' => 'Maven Pro',
						'font-size'   => '16',
						'line-height' => '',
						'unit'        => 'px',
						'type'        => 'google',
					),
					'color'   => false,
				),


			),


		)
	);

	// Create a section
	CSF::createSection(
		$prefix,
		array(
			'title'  => 'Advance Settings',
			'fields' => array(

				array(
					'id'      => 'advanced-features',
					'type'    => 'content',
					'content' => '<div class="advance_options" style="text-align:center"><a target="_blank" href="' . CTL_BUY_PRO . '?utm_source=ctl_plugin&utm_medium=inside&utm_campaign=get_pro&utm_content=settings">
          <img src="' . CTL_PLUGIN_URL . 'assets/images/pro-features-list.png" ></a></div>',

				),

			),
		)
	);

}
