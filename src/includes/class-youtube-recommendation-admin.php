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

        

        public function add_plugin_page(){

            add_options_page( 
                __('Settings', 'my-youtube-recommendation'), 
                __('My Youtube Recommendation', 'my-youtube-recommendation'), 
                'manage_options', 
                $this->plugin_slug, 
                array($this, 'create_admin_page') 
            );
        }

        
        public function create_admin_page(){
            ?>
            <div class='wrap'>
                <h1><?php echo __('My Youtube Recommendation' , 'my-youtube-recommendation'); ?></h1>
                <form method="post" action="options.php">
                    <?php
                        settings_fields( 'my_yt_rec_options' );
                        do_settings_sections( 'my-yt-rec-admin' );
                        submit_button();
                    ?>
                </form>
            </div>
            <?php
        }
        
        public function page_init(){

            register_setting(
                'my_yt_rec_options',
                'my_yt_rec',
                array($this, 'sanitize')
            );

            add_settings_section( 
                'setting_section_id_1', 
                __('General Settings', 'my-youtube-recommendation'),
                null,
                'my-yt-rec-admin'                
            );

            add_setting_field(
                'channel_id',                                       //id
                __('Channel Id', 'my-youtube-recommendation'),      //title
                array($this, 'channel_id_callback'),                //callback
                'my-yt-rec-admin',                                  //page
                'setting_section_id_1'                              //section
            );

            add_setting_field(
                'cache_expiration',                                     //id
                __('Cache expiration', 'my-youtube-recommendation'),    //title
                array($this, 'cache_expiration_callback'),              //callback
                'my-yt-rec-admin',                                      //page
                'setting_section_id_1'                                  //section
            );

            add_setting_field(
                'setting_section_id_2',                             //id
                __('Post Settings', 'my-youtube-recommendation'),   //title
                null,                                               //callback
                'my-yt-rec-admin'                                   //page
            );

            add_setting_field(
                'show_position',                                    //id
                __('Show in posts', 'my-youtube-recommendation'),   //title
                array($this, 'show_position_callback'),             //callback
                'my-yt-rec-admin',                                  //page
                'setting_section_id_2'                              //section
            );

            add_setting_field(
                'layout',
                __('Layout', 'my-youtube-recommendation'),
                array($this, 'show_layout_callback'),
                'my-yt-rec-admin',
                'setting_section_id_2'
            );

            add_setting_field(
                'limit',
                __('Videos in list', 'my-youtube-recommendation'),
                array($this, 'limit_callback'),
                'my-yt-rec-admin',
                'setting_section_id_2'
            );

            add_setting_field(
                'setting_section_id_3',
                __('Customized style', 'my-youtube-recommendation'),
                null,
                'my-yt-rec-admin'
            );
            
            add_setting_field(
                'custom_css',
                __('Your CSS', 'my-youtube-recommendation'),
                array($this, 'custom_css_callback'),
                'my-yt-rec-admin',
                'setting_section_id_3'
            );

        }

    }
}