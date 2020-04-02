<?php

if (isset($_POST['mvv_settings'])) {
    update_option('google_geocoding_api_key', $_POST['google_api_key']);
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