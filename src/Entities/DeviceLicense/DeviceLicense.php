<?php


class DeviceLicenseEntity {

    private $slug;
    private $labels;

    protected static $instance;

    public static function instance() {
        if ( ! self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function __construct()
    {
        $this->slug = "ms-device-license";

        $this->labels = array(
            'name'          => __('Führerscheine'),
            'singular_name' => __('Führerschein'),
            'edit_item' 	=> __('Führerschein bearbeiten'),
        );
    }


    public function list_columns_head($defaults) {
        global $post_ID;
        $post = get_post($post_ID);
        if ($post && get_post_type($post) == $this->slug) {
            $defaults['workshop_start'] = 'Beginn';
            $defaults['workshop_end'] = 'Ende';
        }
        return $defaults;
    }

    // SHOW THE FEATURED IMAGE
    public function list_columns_content($column_name, $post_ID) {
        $post = get_post($post_ID);
        if ($post && get_post_type($post) == $this->slug) {
            if ($column_name == 'workshop_start') {
                $workshop_start_date = get_post_meta($post->ID, 'workshop_start_date', true);
                $workshop_start_time = get_post_meta($post->ID, 'workshop_start_time', true);

                echo $workshop_start_date . " " . $workshop_start_time;
            }

            if ($column_name == 'workshop_end') {
                $workshop_end_date = get_post_meta($post->ID, 'workshop_end_date', true);
                $workshop_end_time = get_post_meta($post->ID, 'workshop_end_time', true);

                echo $workshop_end_date. " " . $workshop_end_time;
            }
        }
    }

    public function render_page_device_license_list() {
        require( plugin_dir_path( __FILE__ ) . 'partials/device-license-list.php' );
    }

    public function add_menu() {
        add_menu_page(
            'Führerscheine',
            'Führerscheine',
            'create_users',
            'ms_device_license',
            array( $this, 'render_page_device_license_list')
        );
    }

    public function register () {
        // subpages
        add_action( 'admin_menu', array($this, 'add_menu') );
    }

}
