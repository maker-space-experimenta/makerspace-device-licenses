<?php


if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

if ( ! class_exists( 'Makerspace_Calendar' ) ) {


    class Makerspace_Device_License_Main{

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

            require_once plugin_dir_path( __FILE__ ) . '/Entities/DeviceLicense/DeviceLicense.php';
            $cal = new DeviceLicenseEntity();
            $cal->register();

        }

        public static function activate() {
            global $wpdb;

            $sql = "
                CREATE TABLE IF NOT EXISTS makerspace_device_license_device_user (
                  makerspace_dldu_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                  makerspace_dldu_user_id INT NOT NULL,
                  makerspace_dldu_device_id INT NOT NULL,
                  makerspace_dldu_received_date DATETIME NOT NULL
                )
            ";

            $wpdb->get_results( $sql );
        }

        public static function deactivate( $network_deactivating ) {

        }

        public function load_styles() {
            wp_enqueue_style('ms-device-license-css', plugins_url('assets/style.css',__FILE__ ));
            wp_enqueue_script('jquery_datatables', plugins_url('assets/js/jquery.dataTables.min.js' ) );
        }
    }
}