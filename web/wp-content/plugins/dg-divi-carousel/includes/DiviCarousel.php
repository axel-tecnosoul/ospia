<?php

class DICA_DiviCarousel extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'dica-divi-carousel';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name = 'divi-carousel';

	/**
	 * The extension's version
	 *
	 * @since 2.0.14
	 *
	 * @var string
	 */
	public $version = '2.0.14';

	/**
	 * DICA_DiviCarousel constructor.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	public function __construct( $name = 'divi-carousel', $args = array() ) {
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );

		parent::__construct( $name, $args );
	}
}

new DICA_DiviCarousel;
