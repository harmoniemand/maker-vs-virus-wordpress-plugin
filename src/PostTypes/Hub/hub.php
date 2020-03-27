<?php


class HubPostType
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
        $this->slug = "mvv_hub";

        $this->labels = array(
            'name'          => __('Hubs'),
            'singular_name' => __('hub'),
            'edit_item'     => __('Hub bearbeiten'),
        );
    }

    public function register_posttype()
    {

        $args = array(
            'labels'      => $this->labels,
            'public'      => true,
            'has_archive' => true,
            'menu_icon'   => plugin_dir_url(__FILE__) . 'logo.png',
            'supports'    => array('title', /*'editor', 'author', 'excerpt'*/),
            'taxonomies'  => array(),
        );

        register_post_type($this->slug, $args);
    }


    public function save_custom_meta_box()
    {

        if (!isset($_POST['metabox_hub_options']))
            return;

        $pid = $_POST["post_ID"];

        if (!current_user_can("edit_post", $pid)) {
            return $pid;
        }

        if (defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) {
            return $pid;
        }

        $fields = array(
            "hub_email",
            "hub_city",
            "hub_state",
            "hub_country",
            "hub_contact_person",
            "hub_twitter",
            "hub_phone",
            "hub_address",
            "hub_offer",
            "hub_capacity",
            "hub_description",
            "hub_for_free",
            "hub_for_net_cost"
        );

        foreach ($fields as $field) {
            update_post_meta($pid, $field, $_POST[$field]);
        }
    }

    public function metabox_options_template()
    {
        require(plugin_dir_path(__FILE__) . 'partials/hub-options.php');
    }

    public function add_metaboxes()
    {

        add_meta_box(
            'metabox_hub_options',
            'Hub Details',
            array($this, 'metabox_options_template'),
            $this->slug,
            'normal',
            'high'
        );
    }

    public function register()
    {
        add_action('init', array($this, 'register_posttype'));

        add_action('add_meta_boxes', array($this, 'add_metaboxes'));
        add_action( 'init', array( $this, 'save_custom_meta_box') );

        // add_filter('manage_workshop_columns', array($this, 'list_columns_head'));
        // add_action('manage_posts_custom_column',  array($this, 'list_columns_content'), 10, 2);


        // subpages
        // add_action( 'admin_menu', array($this, 'add_menu') );


    }
}
