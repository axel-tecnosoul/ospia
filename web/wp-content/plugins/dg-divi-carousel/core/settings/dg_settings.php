<?php

if(! class_exists("DG_Settings")) {
    class DG_Settings {

        /**
         * Config properties
         */
        protected $panels = array();
        protected $sections = array();
        protected $settings = array();
        /**
         * Settings properties
         */
        private $menu_name = "DiviGear";
        private $page_title = "DiviGear";
        private $page_slug = "divigear_options";
        private $option_group = "dg_option_group";
        private static $option_name = "dg_settings";
        private $args = array();
        protected $dir = '';
        private $api_url = "https://api.divigear.com/";

        
        private static $instance = null;

        public static function getInstance() {
         
            // Check if instance is already exists      
            if(self::$instance == null) {
                self::$instance = new DG_Settings();
            }
             
            return self::$instance;
             
        }

        /**
         * protected constructor 
         * Cann't be instentiated
         */
        protected function __construct() {
            $this->init();
        }
        
        /**
         * initiate the settings page
         */
        public function init() {
            add_action( 'admin_menu', array( $this, 'dg_add_admin_menu' ) );
            add_action( 'admin_init', array( $this, 'dg_settings_init' ) );
            add_action( 'admin_enqueue_scripts', array($this, 'load_admin_scripts') );
            add_filter( 'plugin_action_links', array( $this, 'dg_plugin_action_links' ), 10, 5 );
            $this->args = $this->get_args();
            $this->dir = dirname( __FILE__ );
        }

        /**
         * Plugin action links to plugin page
         */
        public function dg_plugin_action_links($actions, $plugin_file) {
            static $plugin;
            if (!isset($plugin))
                $plugin = basename(dirname(dirname(dirname(__FILE__)))) . '/' . basename(dirname(dirname(dirname(__FILE__)))) . '.php';
            
            if ($plugin == $plugin_file) {
                $settings = array('settings' => '<a href="admin.php?page='.$this->page_slug.'">' . __('Settings', 'General') . '</a>');
            
                $actions = array_merge($settings, $actions);
            }
            
            return $actions;
        }

        /**
         * get options
         * 
         * @return Options
         */
        static function dg_get_options() {
            return get_option(self::$option_name);
        }

        /**
         * Update options
         * 
         */
        static function dg_update_options($option) {
            update_option(self::$option_name, $option);
        }

        /**
         * load all styles and scripts
         */
        public function load_admin_scripts(){
            wp_enqueue_style( 'dg_admin_styles', plugin_dir_url(__FILE__) . '/assets/css/admin-styles.css', false, '1.0.0' );
            wp_enqueue_script( 'dg_admin_scripts', plugin_dir_url(__FILE__) . '/assets/js/admin-scripts.js', array('jquery'), '1.0.0', true );
            wp_enqueue_script( 'dg_activation_scripts', plugin_dir_url(__FILE__) . '/assets/js/activation.js', array('jquery'), '1.0.0', true );
            wp_localize_script( 'dg_activation_scripts', 'dg_act_options',
                array( 
                    'ajaxurl' => admin_url( 'admin-ajax.php' ),
                    'api_url' => $this->api_url,
                )
            );
        }

        /**
         * Add admin menu to the wp dashboard
         */
        public function dg_add_admin_menu() {
            add_menu_page(
                $this->menu_name,
                $this->page_title,
                'manage_options',
                $this->page_slug,
                array( $this, 'dg_options_page' )
            );
        }
        
        /**
         * Output Settings field HTML
         */
        public function dg_options_page() {
            ?>
                <div class="main-content">
                    <div class="content-header">
                        <h2><?php echo $this->page_title; ?></h2>
                        <?php $this->setup_panels();?>
                    </div>
                    <div class="content">
                        <div class="sidebar">
                            <?php $this->setup_nav();?>
                        </div>
                        <div class="form-container">
                            <form action='options.php' method='post' id="dgpc-activation-key">
                            <?php
                            settings_fields( $this->option_group );
                            $this->dg_settings_sections( $this->option_group );
                            submit_button();
                            ?>
                            </form>
                        </div>
                    </div>
                    
                </div>
            <?php
        }

        /**
         * Sections markup
         */
        private function dg_settings_sections( $page ) {
            global $wp_settings_sections, $wp_settings_fields;
        
            if ( ! isset( $wp_settings_sections[$page] ) )
                return;
        
            foreach ( (array) $wp_settings_sections[$page] as $section ) {

                if ( ! isset( $wp_settings_fields ) || !isset( $wp_settings_fields[$page] ) || !isset( $wp_settings_fields[$page][$section['id']] ) )
                    continue;
                    
                echo '<div class="section-wrapper" data-navid="'.$section['id'].'" >';
                if ( $section['title'] )
                    echo "<h2>{$section['title']}</h2>\n";
        
                if ( $section['callback'] )
                    call_user_func( $section['callback'], $section );
        
                echo '<div class="field-wrapper">';
                $this->dg_settings_fields( $page, $section['id'] );
                echo '</div>';
                echo '</div>';
            }
        }

        /**
         * Settings markup
         */
        private function dg_settings_fields($page, $section) {
            global $wp_settings_fields;

            $template_url = DGSETTINGS . "/template/view.php";


            if ( ! isset( $wp_settings_fields[$page][$section] ) )
                return;
            
            foreach ( (array) $wp_settings_fields[$page][$section] as $field ) {
                $class = '';
                $dg_class = "";

                if ( ! empty( $field['args']['class'] ) ) {
                    $class = ' class="' . esc_attr( $field['args']['class'] ) . '"';
                }

                $field_object = $field['callback'][0];
                if($field_object->type == "docs") {
                    $dg_class .= " doc-field";
                }
                $args = array(
                    'class' => $class,
                    'field' => $field,
                    'dg_class'  => $dg_class
                );
                echo self::template($template_url, $args);
            }
        }

        /**
         *  Add settings fields
         */
        public function dg_settings_init() {
            register_setting( $this->option_group, self::$option_name );

            // register sections
            $this->dg_add_sections();
            // register settings
            $this->dg_add_settings_fields();
        }
        
        /**
         * @return $arg for field
         */
        private function get_args() {
            return array (
                'option_name'   => self::$option_name,
                'option_group'  => $this->option_group
            );
        }

        /**
         * Add settings field
         */
        private function dg_add_settings_fields() {
            $settings = $this->get_settings();
            $args = array();
            $args = array_merge($args, $this->args);
            foreach ( $settings as $setting_slug => $config ) {
                $args['setting_slug'] = $setting_slug;
                $args['config'] = $config;
                $field = new Field($args);
                $field->get_setting_field();
            }
        }

        /**
         * Add sections
         */
        private function dg_add_sections() {
            $sections = $this->get_sections();
            $args = $this->args;
            foreach ( $sections as $section_slug => $section_config ) {
                $args['section_slug'] = $section_slug;
                $args['section_name'] = $section_config['name'];
                $dg_section = new DG_Section($args);
                $dg_section->get_section();
            }
            
        }

        /**
         * setup the navigation
         * 
         * @return HTML
         */
        private function setup_nav() {
            $sections = $this->get_sections();
            $output = '';
            $output .= '<ul class="dg-settings-nav">';
            foreach ( $sections as $section_slug => $section_config ) {
                $output .= '<li data-panel="'.$section_config['panel'].'"><a href="#" data-navId="'.$section_slug.'" ><span>&#129138; </span> '.$section_config['name'].'</a></li>';
            }
            $output .= '</ul>';

            echo $output;
        }

        /**
         * setup the navigation
         * 
         * @return HTML
         */
        private function setup_panels() {
            $panels = $this->get_panels();
            $output ='<ul class="dg-panel">';
            foreach ( $panels as $panel => $panel_name) {
                $output .= '<li class="panel"><a href="#" data-id="'.$panel.'"><span>&#8681; </span>'.$panel_name.'</a></li>';
            }
            $output .= '</ul>';
            echo $output;
        }

        /**
         * Get sections for settings
         * 
         * @return $sections
         */
        protected function get_panels() {
            return $this->panels;
        }

        /**
         * Get sections for settings
         * 
         * @return $sections
         */
        protected function get_sections() {
            return $this->sections;
        }

        /**
         *  Get all settings Field
         * 
         * @return $settings
         */
        protected function get_settings() {
            return $this->settings;
        }

        /**
         * Settings callback
         */
        public function dg_settings_section_callback($typt) {
            echo $type;
        }

        /**
         * Set the template
         */
        static function template( $file, $args ) {
            // Make associative array in variable
            if( is_array($args)) {
                extract($args);
            }
            // buffer the output
            ob_start();
            include $file;
            return ob_get_clean();
        }

        /**
         * Set the $template URL
         */
        static function template_url($type, $field = false){
            if( $field == false ) {
                $template_url = DGSETTINGS . "/template/{$type}.php";
            } else {
                $template_url = DGSETTINGS . "/template/{$type}-field.php";
            } 
            return $template_url;
        }

    }

}

if ( ! class_exists("DG_Config")) {
    class DG_Config extends DG_Settings {
        /**
         * protected constructor 
         * Cann't be instentiated
         */
        protected function __construct() {}

        /**
         * merge panels config to the main object
         */
        public static function set_panels($panels = array()) {
            $instance = self::getInstance();
            $instance->panels = array_merge($instance->panels, $panels);
        }

        /**
         * merge sections config to the main object
         */
        public static function set_sections($sections = array()) {
            $instance = self::getInstance();
            $instance->sections = array_merge($instance->sections,$sections);
        }

        /**
         * merge settings config to the main object
         */
        public static function set_settings($settings = array()) {
            $instance = self::getInstance();
            $instance->settings = array_merge($instance->settings, $settings);
        }

    }
}
