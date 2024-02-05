<?php
namespace Dgdc\Func;

/**
 * $api_key need to change according to the plugin
 * $status need to change according to the plugin
 */

function dg_plugin_update($checked_data) {
    global $wp_version;
    $api_url = "https://api.divigear.com/";
    $option = get_option('dg_settings');
    $plugin_slug = basename(dirname(__DIR__));
    $array_key = $plugin_slug .'/'. $plugin_slug .'.php';

    // need to change according to the plugin
    $api_key = isset($option['dgdc_license_key_setting']) ? $option['dgdc_license_key_setting'] : '';
    $status = isset($option['dgdc_license_key_status']) ? $option['dgdc_license_key_status'] : '';

    //Comment out these two lines during testing.
    if (empty($checked_data->checked)) {
        return $checked_data;
    }
    if (!array_key_exists($array_key, $checked_data->checked ) ) {
        return $checked_data;
    }

    $args = array(
        'slug' => $plugin_slug,
        'version' => $checked_data->checked[$plugin_slug .'/'. $plugin_slug .'.php'],
        'apikey' => $api_key,
        'status' => $status,
        'file_name' => $plugin_slug
    );
    $request_string = array(
        'body' => array(
            'action' => 'basic_check',
            'request' => serialize($args),
            'api-key' => md5(get_bloginfo('url'))
        ),
        'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
        );

    // Start checking for an update
    $raw_response = wp_remote_post($api_url, $request_string);

    if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200))
        $response = unserialize($raw_response['body']);

    if (is_object($response) && !empty($response)) // Feed the update data into WP updater
        $checked_data->response[$plugin_slug .'/'. $plugin_slug .'.php'] = $response;

    return $checked_data;
}


function dg_plugin_notice() {
    $plugin_slug = basename(dirname(__DIR__));
    $class = 'notice is-dismissible notice-error';

    if ( is_admin() ) {
        if ( !function_exists('get_plugin_data')) {
                require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        } 
        $plugin_data = get_plugin_data(plugin_dir_path(__DIR__). '/'.$plugin_slug.'.php');
        
        if (!class_exists('DiviExtension')) {
            printf( '<div class="%1$s"><p>Please update your theme or builder to use %2$s.</p></div>', esc_attr( $class ), $plugin_data['Name'] );
        }
    }
}