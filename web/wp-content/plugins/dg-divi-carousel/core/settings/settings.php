<?php 

if (!defined("DGSETTINGS")) {
    define( "DGSETTINGS", __DIR__ );
}
if (!defined("DGSETTINGSURL")){
    define( "DGSETTINGSURL", plugin_dir_url(__FILE__) );
}
require_once ( __DIR__ . '/dg_settings.php');
require_once (__DIR__ . '/inc/setting_field.php');
require_once (__DIR__ . '/inc/section.php');
