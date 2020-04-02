<?php


class MakerPostType
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
            'post_type'         => 'mvv_maker',
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
                "maker_id" => $post->ID,
                "maker_email" => $this->get_post_meta_save($post->ID, "maker_email", true),
                "maker_street" => $this->get_post_meta_save($post->ID, "maker_street", true),
                "maker_zip" => $this->get_post_meta_save($post->ID, "maker_zip", true),
                "maker_city" => $this->get_post_meta_save($post->ID, "maker_city", true),
                "maker_state" => $this->get_post_meta_save($post->ID, "maker_state", true),
                "maker_country" => $this->get_post_meta_save($post->ID, "maker_country", true),
                "maker_contact_person" => $this->get_post_meta_save($post->ID, "maker_contact_person", true),
                "maker_twitter" => $this->get_post_meta_save($post->ID, "maker_twitter", true),
                "maker_phone" => $this->get_post_meta_save($post->ID, "maker_phone", true),
                "maker_address" => $this->get_post_meta_save($post->ID, "maker_address", true),
                "maker_offer" => nl2br($this->get_post_meta_save($post->ID, "maker_offer", true)),
                "maker_capacity" => nl2br($this->get_post_meta_save($post->ID, "maker_capacity", true)),
                "maker_description" => nl2br($this->get_post_meta_save($post->ID, "maker_description", true)),
                "maker_for_free" => $this->get_post_meta_save($post->ID, "maker_for_free", true),
                "maker_for_net_cost" => $this->get_post_meta_save($post->ID, "maker_for_net_cost", true),
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
            'supports'    => array('title', 'author', 'editor'/*, 'excerpt'*/),
            'taxonomies'  => array(),
            'show_in_rest' => true,
        );

        register_post_type($this->slug, $args);
    }


    public function save_custom_meta_box()
    {

        if (!isset($_POST['metabox_maker_options']))
            return;

        $pid = $_POST["post_ID"];

        if (!current_user_can("edit_post", $pid)) {
            return $pid;
        }

        if (defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) {
            return $pid;
        }

        $fields = array(
            "maker_email",
            "maker_twitter",
            "maker_phone",

            "maker_street",
            "maker_zip",
            "maker_city",
            "maker_state",
            "maker_country",
            
            "maker_capacity",
            "maker_description",
        );

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($pid, $field, $_POST[$field]);
            }
        }


        $google_api_key = get_option('google_geocoding_api_key');
        $address = $_POST['maker_street'] . " " . $_POST["maker_zip"] . " " . $_POST["maker_city"] . " " . $_POST["maker_state"] . " " . $_POST["maker_country"];
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

        update_post_meta($pid, "maker_lat", $lat);
        update_post_meta($pid, "maker_long", $long);
    }

    public function metabox_options_template()
    {
        require(plugin_dir_path(__FILE__) . 'partials/maker-options.php');
    }

    public function add_metaboxes()
    {

        add_meta_box(
            'metabox_maker_options',
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

        // add_action('rest_api_init', array($this, 'add_rest_endpoints'));

        // add_filter('manage_workshop_columns', array($this, 'list_columns_head'));
        // add_action('manage_posts_custom_column',  array($this, 'list_columns_content'), 10, 2);


        // subpages
        // add_action( 'admin_menu', array($this, 'add_menu') );


    }
}
