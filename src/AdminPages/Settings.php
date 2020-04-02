<?php


class SettingsAdminPage
{

    private $slug;
    private $labels;

    protected static $instance;

    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function __construct()
    {
        $this->slug = "mvv_maker";

        $this->labels = array(
            'name'          => __('Makers'),
            'singular_name' => __('Maker'),
            'edit_item'     => __('Maker bearbeiten'),
        );
    }

    public function admin_menu_settings() {
        require 'partials/settings.partial.php';
    }

    public function add_admin_menu()
    {
        add_submenu_page(
            'options-general.php',
            __('MVV Settings', 'mvv-settings'),
            __('MVV Settings', 'mvv-settings'),
            'manage_options',
            __('MVV Settings', 'mvv-settings'),
            array( $this, 'admin_menu_settings')
        );
    }


    public function register()
    {

        add_action('admin_menu', array($this, 'add_admin_menu'));
    }
}
