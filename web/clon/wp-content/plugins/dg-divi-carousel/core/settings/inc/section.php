<?php
if ( ! class_exists('DG_Section')) {
    class DG_Section {

        /**
         * class properties
         */
        private $args = array();
        private $section_slug = '';
        private $section_name = '';
        
        /**
         * constructor
         */
        public function __construct($args) {
            $this->args = $args;
            $this->section_slug = $args['section_slug'];
            $this->section_name = $args['section_name'];
        }
    
        /**
         * Add sections
         */
        public function get_section() {
            add_settings_section(
                $this->section_slug,
                null,
                array( $this, 'dg_section_callback' ),
                $this->args['option_group']
            );
        }
    
        /**
         * Section callback
         */
        public function dg_section_callback() {
            // echo '<div class="dg-section-title"><h3>'.$this->section_name.'</h3></div>';
        }
    }
}
