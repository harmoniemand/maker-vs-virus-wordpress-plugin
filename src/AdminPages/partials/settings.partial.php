<?php

if (isset($_POST['mvv_settings'])) {
    update_option('google_geocoding_api_key', $_POST['google_api_key']);
}


if (isset($_POST["mvv_check_coords"])) {


    $hubs = get_posts(array(
        'post_type'         => 'mvv_hub',
        'posts_per_page'    =>  -1,
        'orderby'           => 'title',
        'order'              => 'ASC'
    ));


    $google_api_key = get_option('google_geocoding_api_key');

    foreach ($hubs as $hub) :

        $address = get_post_meta($hub->ID, 'hub_street', true) . " " . get_post_meta($hub->ID, 'hub_zip', true) . " " . get_post_meta($hub->ID, 'hub_city', true) . " " . get_post_meta($hub->ID, 'hub_state', true) . " " . get_post_meta($hub->ID, 'hub_country', true);
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

        update_post_meta($hub->ID, "hub_lat", $lat);
        update_post_meta($hub->ID, "hub_long", $long);

        echo "<div>Update " . get_the_title($hub->ID) . ": " . $lat . " " . $long . "</div>";

    endforeach;
}

?>


<form action="/wp-admin/options-general.php?page=MVV+Settings" method="POST">

    <?php wp_nonce_field(basename(__FILE__), 'mvv_settings'); ?>

    <?php
    $google_api_key = get_option('google_geocoding_api_key');
    ?>

    <div style="margin-top: .5rem; display: flex; justify-content: center; align-items: center;">
        <label class="" style="min-width: 150px;" for="google_api_key">Google Geocode API Key</label>
        <input type="text" style="margin-left: 1rem; width: 100%;" id="google_api_key" name="google_api_key" value="<?php echo $google_api_key ?>" />
    </div>

    <button type="submit">Speichern</button>
</form>


<div>
    <form action="/wp-admin/options-general.php?page=MVV+Settings" method="POST">
        <?php wp_nonce_field(basename(__FILE__), 'mvv_check_coords'); ?>
        <button type="submit">Alle Geodaten updaten</button>
    </form>
</div>