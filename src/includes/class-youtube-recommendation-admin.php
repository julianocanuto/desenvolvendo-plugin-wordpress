<?php

if (!class_exists('My_Youtube_Recommendation')) {
    
    class My_Youtube_Recommendation{
        
        private $options;

        private $plugin_basename;
        private $plugin_slug;
        private $json_filename;
        private $plugin_version;
        
        public function __construct($basename, $slug, $json_filename, $version){

            $this->options          = get_option('my_yt_rec');
            
            $this->plugin_basename  = $basename;
            $this->plugin_slug      = $slug;
            $this->json_filename    = $json_filename;
            $this->plugin_version   = $version;

            add_action( 'admin_menu', array($this, 'add_plugin_page') );
            add_action( 'admin_init', array($this, 'page_init') );
            add_action( 'admin_footer_text', array($this, 'page_footer') );
            add_action( 'admin_notices', array($this, 'show_notices') );

            add_filter( 'plugin_action_links_' . $this->plugin_basename, array($this, 'add_settings_link') );
        }

    }
}