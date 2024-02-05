<?php
if( ! class_exists("DG_Setting_Field")) {

    class DG_Setting_Field {
        
        /**
         * Store the settings field values
         */
        protected $setting_slug = "";
        protected $config = array();
        public $type = '';
        protected $args = array();
        protected $option_slug = '';
        protected $template_url = '';
        protected $data = array();
        protected $options = array();
        protected $effected_field = '';
        protected $effected_field_key = '';
                

        /**
         * Construct the object
         */
        public function __construct($args) {
            $this->setup_properties($args); 
        }

        /**
         * setup the properties
         */
        protected function setup_properties($args) {

            $defaults = array(
                'name'              => '',
                'type'              => '',
                'section_slug'      => '',
                'doc_text'          => '',
                'doc_url'           => '',
                'doc_url_text'      => '',
                'effected_field'    => ''
            );

    
            $this->args = $args;
            $this->setting_slug = $this->args['setting_slug'];
            $this->config = wp_parse_args( $args['config'], $defaults );
            $this->type = $args['config']['type'];
            $this->options = DG_Settings::dg_get_options();
            $this->template_url = DG_Settings::template_url($this->type, true);

            $option_name = $this->args["option_name"];
            $name = $option_name.'['.$this->setting_slug.']';
            $this->effected_field = isset($this->options[$this->config['effected_field']]) ? $this->options[$this->config['effected_field']] : '';
            $this->effected_field_key = $this->config['effected_field'];

            if( $this->type == 'license') {
                add_action( 'wp_ajax_update_license', array($this, 'update_license') );
            }

            

            // creating the data field for template
            $this->data = array(
                'id'    => $this->setting_slug,
                'name' => $name,
                'value' => isset($this->options[$this->setting_slug]) ? $this->options[$this->setting_slug] : '',
                'effected_key' => $this->effected_field_key,
                'effected'  => $this->effected_field,
                'doc_text' => $this->config['doc_text'],
                'doc_url'  => $this->config['doc_url'],
                'doc_url_text'  =>  $this->config['doc_url_text']
            );

        }

        /**
         * return the name
         */
        protected function name( $option_name, $settings_slug ) {
            return $option_name . '[' . $setting_slug . ']';
        }

        /**
         * Set the $template URL
         */
        protected function set_template_url(){
            $this->template_url = DGSETTINGS . "/template/{$this->type}-field.php";
        }

        /**
         * Add settings field
         * 
         */
        public function get_setting_field() {
            $section_slug = $this->config['section_slug'];
            add_settings_field(
                $this->setting_slug,
                $this->config['name'],
                array( $this, "dg_setting_field_callback" ),
                $this->args['option_group'],
                $section_slug
            );
        }

        /**
         * Settings field callback
         */
        public function dg_setting_field_callback() {
            ?>
                <div class="field-option">
                    <?php echo DG_Settings::template($this->template_url, $this->data); ?>
                </div>
            <?php
        }

        /**
         * Update option value
         */
        public function update_license (){
            $data = $_POST ["data"];
            $option = $this->options;
            $status_field_key = $data['status_field_key'];
            $status_field_value = $data['status_field_value'];

            $option[$status_field_key] = $status_field_value;
            $option[$data['license_field']] = $data['apikey'];
            DG_Settings::dg_update_options($option);

            echo json_encode($option);
        }
    }
    
}

if ( ! class_exists('Field')) {
    class Field extends DG_Setting_Field {  
    }
}