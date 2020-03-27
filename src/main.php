<?php


if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

if ( ! class_exists( 'Makerspace_Announcement_Main' ) ) {


    class MVV_Hubs_Main{

        const VERSION = '1.0.0';

        /**
         * Static Singleton Holder
         * @var self
         */
        protected static $instance;

        /**
         * Get (and instantiate, if necessary) the instance of the class
         *
         * @return self
         */
        public static function instance() {
            if ( ! self::$instance ) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        function __construct() {
            add_action('admin_enqueue_scripts', array($this, 'load_styles') );

            require_once plugin_dir_path( __FILE__ ) . '/PostTypes/Hub/hub.php';
            $cal = new HubPostType();
            $cal->register();
        }

        public static function activate() {
            
        }

        public static function deactivate( $network_deactivating ) {

        }

        public function load_styles() {
            // wp_enqueue_style('boot_css', plugins_url('assets/style.css',__FILE__ ));
            // wp_enqueue_script('jquery_datatables', plugins_url('assets/js/jquery.dataTables.min.js' ) );
        }
    }
}