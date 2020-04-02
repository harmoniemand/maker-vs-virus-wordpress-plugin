<?php

global $post;

// Nonce field to validate form request came from current site
wp_nonce_field(basename(__FILE__), 'metabox_maker_options');

?>

<?php $maker_street = get_post_meta($post->ID, 'maker_street', true); ?>
<div style="margin-top: .5rem; display: flex; justify-content: center; align-items: center;">
    <label class="" style="min-width: 150px;" for="maker_street">Straße</label>
    <input type="text" style="margin-left: 1rem; width: 100%;" id="maker_street" name="maker_street" value="<?php echo $maker_street ?>" placeholder="Straße" />
</div>

<?php $maker_zip = get_post_meta($post->ID, 'maker_zip', true); ?>
<div style="margin-top: .5rem; display: flex; justify-content: center; align-items: center;">
    <label class="" style="min-width: 150px;" for="maker_zip">Postleitzahl</label>
    <input type="text" style="margin-left: 1rem; width: 100%;" id="maker_zip" name="maker_zip" value="<?php echo $maker_zip ?>" placeholder="Postleitzahl" />
</div>

<?php $maker_city = get_post_meta($post->ID, 'maker_city', true); ?>
<div style="margin-top: .5rem; display: flex; justify-content: center; align-items: center;">
    <label class="" style="min-width: 150px;" for="maker_city">Stadt</label>
    <input type="text" style="margin-left: 1rem; width: 100%;" id="maker_city" name="maker_city" value="<?php echo $maker_city ?>" />
</div>


<?php $maker_state = get_post_meta($post->ID, 'maker_state', true); ?>
<div style="margin-top: .5rem; display: flex; justify-content: center; align-items: center;">
    <label class="" style="min-width: 150px;" for="maker_state">Bundesland</label>
    <input type="text" style="margin-left: 1rem; width: 100%;" id="maker_state" name="maker_state" list="maker_state_list" value="<?php echo $maker_state ?>" />
</div>
<datalist id="maker_state_list">
    <option>Baden-Württemberg</option>
    <option>Bayern</option>
    <option>Berlin</option>
    <option>Brandenburg</option>
    <option>Bremen</option>
    <option>Hamburg</option>
    <option>Hessen</option>
    <option>Mecklenburg-Vorpommern</option>
    <option>Niedersachsen</option>
    <option>Nordrhein-Westfalen</option>
    <option>Rheinland-Pfalz</option>
    <option>Saarland</option>
    <option>Sachsen</option>
    <option>Sachsen-Anhalt</option>
    <option>Schleswig-Holstein</option>
    <option>Thüringen </option>
</datalist>


<?php $maker_country = get_post_meta($post->ID, 'maker_country', true); ?>
<div style="margin-top: .5rem; display: flex; justify-content: center; align-items: center;">
    <label class="" style="min-width: 150px;" for="maker_country">Land</label>
    <input type="text" style="margin-left: 1rem; width: 100%;" id="maker_country" name="maker_country" value="<?php echo $maker_country ?>" />
</div>



<?php $maker_email = get_post_meta($post->ID, 'maker_email', true); ?>
<div style="margin-top: .5rem; display: flex; justify-content: center; align-items: center;">
    <label class="" style="min-width: 150px;" for="maker_email">E-Mail</label>
    <input type="email" style="margin-left: 1rem; width: 100%;" id="maker_email" name="maker_email" value="<?php echo $maker_email ?>" />
</div>


<?php $maker_twitter = get_post_meta($post->ID, 'maker_twitter', true); ?>
<div style="margin-top: .5rem; display: flex; justify-content: center; align-items: center;">
    <label class="" style="min-width: 150px;" for="maker_twitter">Twitter</label>
    <input type="text" style="margin-left: 1rem; width: 100%;" id="maker_twitter" name="maker_twitter" value="<?php echo $maker_twitter ?>" />
</div>


<?php $maker_phone = get_post_meta($post->ID, 'maker_phone', true); ?>
<div style="margin-top: .5rem; display: flex; justify-content: center; align-items: center;">
    <label class="" style="min-width: 150px;" for="maker_phone">Telefon</label>
    <input type="tel" style="margin-left: 1rem; width: 100%;" id="maker_phone" name="maker_phone" value="<?php echo $maker_phone ?>" />
</div>



<?php $maker_capacity = get_post_meta($post->ID, 'maker_capacity', true); ?>
<div style="margin-top: .5rem; display: flex; justify-content: center; align-items: center;">
    <label class="" style="min-width: 150px;" for="maker_capacity">Kapazitäten</label>
    <textarea style="margin-left: 1rem; width: 100%;" id="maker_capacity" name="maker_capacity"><?php echo $maker_capacity ?></textarea>
</div>



<?php $maker_description = get_post_meta($post->ID, 'maker_description', true); ?>
<div style="margin-top: .5rem; display: flex; justify-content: center; align-items: center;">
    <label class="" style="min-width: 150px;" for="maker_description">Kurzvorstellung</label>
    <textarea style="margin-left: 1rem; width: 100%;" id="maker_description" name="maker_description"><?php echo $maker_description ?></textarea>
</div>