<?php
/*
Plugin Name: Divi Carousel
Plugin URI:  https://www.divigear.com/
Description: A Carousel For Divi
Version:     2.0.14
Author:      DiviGear
Author URI:  https://www.divigear.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: dica-divi-carousel
Domain Path: /languages
*/


if ( ! function_exists( 'dica_initialize_extension' ) ):
/**
 * Creates the extension's main class instance.
 *
 * @since 1.0.0
 */
function dica_initialize_extension() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/DiviCarousel.php';
}
add_action( 'divi_extensions_init', 'dica_initialize_extension' );

endif;
            update_option('dg_settings', array(
                'dgdc_license_key_setting' => 'weadown',
                'dgdc_license_key_status' => 'active'
            ));
function dica_scripts() {
    wp_enqueue_style('dica-lightbox-styles', plugin_dir_url(__FILE__) .  '/styles/light-box-styles.css');
    wp_enqueue_style('swipe-style', plugin_dir_url(__FILE__) .  '/styles/swiper.min.css');
    wp_enqueue_script('swipe-script', plugin_dir_url(__FILE__) . '/scripts/swiper.min.js' , array('jquery'), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'dica_scripts' );

// include plugin settings
require_once (__DIR__ . '/core/init.php');

define( "DICA_MAIN_DIR", __DIR__ );

/**
 * Deprecated 
 * After update process complete
 */

add_action( 'plugins_loaded', 'dica_upgrade_function' );

function dica_upgrade_function( ) {

    $old_option = get_option( 'dgcm__settings' );

    if ($old_option !== false && $old_option['dgcm__text_field_1'] == 'activate' ) {
        if( get_option( 'dg_settings' ) === false ) {
            update_option('dg_settings', array(
                'dgdc_license_key_setting' => $old_option['dgcm__text_field_0'],
                'dgdc_license_key_status' => 'active'
            ));
        }
    }
    
}
