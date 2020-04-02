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


    public function  get_post_meta_save($id, $meta, $single)
    {
        $value = get_post_meta($id, $meta, $single);

        if ($value) {
            return $value;
        }

        return "";
    }


    public function rest_endpoint_hubs($data)
    {
        $posts = get_posts(array(
            'post_type'         => 'mvv_hub',
            'posts_per_page'    =>  -1,
            'orderby'           => 'title',
            'order'              => 'ASC'
        ));

        if (empty($posts)) {
            return null;
        }

        $data = array();

        foreach ($posts as $post) {
            array_push($data, array(
                "hub_id" => $post->ID,
                "hub_email" => $this->get_post_meta_save($post->ID, "hub_email", true),
                "hub_street" => $this->get_post_meta_save($post->ID, "hub_street", true),
                "hub_zip" => $this->get_post_meta_save($post->ID, "hub_zip", true),
                "hub_city" => $this->get_post_meta_save($post->ID, "hub_city", true),
                "hub_state" => $this->get_post_meta_save($post->ID, "hub_state", true),
                "hub_country" => $this->get_post_meta_save($post->ID, "hub_country", true),
                "hub_contact_person" => $this->get_post_meta_save($post->ID, "hub_contact_person", true),
                "hub_twitter" => $this->get_post_meta_save($post->ID, "hub_twitter", true),
                "hub_phone" => $this->get_post_meta_save($post->ID, "hub_phone", true),
                "hub_address" => $this->get_post_meta_save($post->ID, "hub_address", true),
                "hub_offer" => nl2br($this->get_post_meta_save($post->ID, "hub_offer", true)),
                "hub_capacity" => nl2br($this->get_post_meta_save($post->ID, "hub_capacity", true)),
                "hub_description" => nl2br($this->get_post_meta_save($post->ID, "hub_description", true)),
                "hub_for_free" => $this->get_post_meta_save($post->ID, "hub_for_free", true),
                "hub_for_net_cost" => $this->get_post_meta_save($post->ID, "hub_for_net_cost", true),
            ));
        }

        return array(
            "draw" => 1,
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        );
    }

    public function add_rest_endpoints()
    {

        register_rest_route('api/v1', '/hubs', array(
            'methods' => 'GET',
            'callback' => array($this, 'rest_endpoint_hubs'),
        ));
    }

    public function register_posttype()
    {

        $args = array(
            'labels'      => $this->labels,
            'public'      => true,
            'has_archive' => true,
            'menu_icon'   => plugin_dir_url(__FILE__) . 'logo.png',
            'supports'    => array('title', 'author', 'thumbnail', 'editor'/*, 'excerpt'*/),
            'taxonomies'  => array(),
            'show_in_rest' => true,
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
            "hub_street",
            "hub_zip",
            "hub_city",
            "hub_state",
            "hub_country",
            "hub_contact_person",
            "hub_twitter",
            "hub_phone",
            "hub_offer",
            "hub_capacity",
            "hub_description",
            "hub_for_free",
            "hub_for_net_cost"
        );

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($pid, $field, $_POST[$field]);
            }
        }


        $google_api_key = get_option('google_geocoding_api_key');
        $address = $_POST['hub_street'] . " " . $_POST["hub_zip"] . " " . $_POST["hub_city"] . " " . $_POST["hub_state"] . " " . $_POST["hub_country"];
        $url = "https://maps.googleapis.com/maps/api/geocode/json?sensor=false&key=" . $google_api_key . "&address=" . urlencode($address);

        $header = array("Accept: application/json");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');


        $response = curl_exec($ch);

        $result = json_decode($response);

        $lat = $result->results[0]->geometry->location->lat;
        $long = $result->results[0]->geometry->location->lng;

        update_post_meta($pid, "hub_lat", $lat);
        update_post_meta($pid, "hub_long", $long);
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
        add_action('init', array($this, 'save_custom_meta_box'));

        add_action('rest_api_init', array($this, 'add_rest_endpoints'));

        // add_filter('manage_workshop_columns', array($this, 'list_columns_head'));
        // add_action('manage_posts_custom_column',  array($this, 'list_columns_content'), 10, 2);


        // subpages
        // add_action( 'admin_menu', array($this, 'add_menu') );


    }
}
