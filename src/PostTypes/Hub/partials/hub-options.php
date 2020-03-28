<?php

global $post;

// Nonce field to validate form request came from current site
wp_nonce_field(basename(__FILE__), 'metabox_hub_options');

?>

<?php $hub_city = get_post_meta($post->ID, 'hub_city', true); ?>
<div style="margin-top: .5rem; display: flex; justify-content: center; align-items: center;">
    <label class="" style="min-width: 150px;" for="hub_city">Stadt</label>
    <input type="text" style="margin-left: 1rem; width: 100%;" id="hub_city" name="hub_city" value="<?php echo $hub_city ?>" />
</div>


<?php $hub_state = get_post_meta($post->ID, 'hub_state', true); ?>
<div style="margin-top: .5rem; display: flex; justify-content: center; align-items: center;">
    <label class="" style="min-width: 150px;" for="hub_state">Bundesland</label>
    <input type="text" style="margin-left: 1rem; width: 100%;" id="hub_state" name="hub_state" list="hub_state_list" value="<?php echo $hub_state ?>" />
</div>
<datalist id="hub_state_list">
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


<?php $hub_country = get_post_meta($post->ID, 'hub_country', true); ?>
<div style="margin-top: .5rem; display: flex; justify-content: center; align-items: center;">
    <label class="" style="min-width: 150px;" for="hub_country">Land</label>
    <input type="text" style="margin-left: 1rem; width: 100%;" id="hub_country" name="hub_country" value="<?php echo $hub_country ?>" />
</div>


<?php $hub_contact_person = get_post_meta($post->ID, 'hub_contact_person', true); ?>
<div style="margin-top: .5rem; display: flex; justify-content: center; align-items: center;">
    <label class="" style="min-width: 150px;" for="hub_contact_person">Kontaktperson</label>
    <input type="text" style="margin-left: 1rem; width: 100%;" id="hub_contact_person" name="hub_contact_person" value="<?php echo $hub_contact_person ?>" />
</div>


<?php $hub_email = get_post_meta($post->ID, 'hub_email', true); ?>
<div style="margin-top: .5rem; display: flex; justify-content: center; align-items: center;">
    <label class="" style="min-width: 150px;" for="hub_email">E-Mail</label>
    <input type="email" style="margin-left: 1rem; width: 100%;" id="hub_email" name="hub_email" value="<?php echo $hub_email ?>" />
</div>


<?php $hub_twitter = get_post_meta($post->ID, 'hub_twitter', true); ?>
<div style="margin-top: .5rem; display: flex; justify-content: center; align-items: center;">
    <label class="" style="min-width: 150px;" for="hub_twitter">Twitter</label>
    <input type="text" style="margin-left: 1rem; width: 100%;" id="hub_twitter" name="hub_twitter" value="<?php echo $hub_twitter ?>" />
</div>


<?php $hub_phone = get_post_meta($post->ID, 'hub_phone', true); ?>
<div style="margin-top: .5rem; display: flex; justify-content: center; align-items: center;">
    <label class="" style="min-width: 150px;" for="hub_phone">Telefon</label>
    <input type="tel" style="margin-left: 1rem; width: 100%;" id="hub_phone" name="hub_phone" value="<?php echo $hub_phone ?>" />
</div>



<?php $hub_address = get_post_meta($post->ID, 'hub_address', true); ?>
<div style="margin-top: .5rem; display: flex; justify-content: center; align-items: center;">
    <label class="" style="min-width: 150px;" for="hub_address">Anschrift</label>
    <textarea style="margin-left: 1rem; width: 100%;" id="hub_address" name="hub_address"><?php echo $hub_address ?></textarea>
</div>


<?php $hub_offer = get_post_meta($post->ID, 'hub_offer', true); ?>
<div style="margin-top: .5rem; display: flex; justify-content: center; align-items: center;">
    <label class="" style="min-width: 150px;" for="hub_offer">Wir bieten</label>
    <textarea style="margin-left: 1rem; width: 100%;" id="hub_offer" name="hub_offer"><?php echo $hub_offer ?></textarea>
</div>


<?php $hub_capacity = get_post_meta($post->ID, 'hub_capacity', true); ?>
<div style="margin-top: .5rem; display: flex; justify-content: center; align-items: center;">
    <label class="" style="min-width: 150px;" for="hub_capacity">Kapazitäten</label>
    <textarea style="margin-left: 1rem; width: 100%;" id="hub_capacity" name="hub_capacity"><?php echo $hub_capacity ?></textarea>
</div>



<?php $hub_description = get_post_meta($post->ID, 'hub_description', true); ?>
<div style="margin-top: .5rem; display: flex; justify-content: center; align-items: center;">
    <label class="" style="min-width: 150px;" for="hub_description">Kurzvorstellung</label>
    <textarea style="margin-left: 1rem; width: 100%;" id="hub_description" name="hub_description"><?php echo $hub_description ?></textarea>
</div>



<?php $hub_for_free = get_post_meta($post->ID, 'hub_for_free', true); ?>
<div style="margin-top: .5rem; display: flex; justify-content: center; align-items: center;">
    <label class="" style="min-width: 150px;" for="hub_for_free">Kostenlos</label>
    <input type="checkbox" style="margin-left: 1rem;" id="hub_for_free" name="hub_for_free" <?php if ($hub_for_free) {
                                                                                                echo 'checked';
                                                                                            } ?>>
    <div style="width: 100%;"></div>
</div>

<?php $hub_for_net_cost = get_post_meta($post->ID, 'hub_for_net_cost', true); ?>
<div style="margin-top: .5rem; display: flex; justify-content: center; align-items: center;">
    <label class="" style="min-width: 150px;" for="hub_for_net_cost">Selbstkosten</label>
    <input type="checkbox" style="margin-left: 1rem;" id="hub_for_net_cost" name="hub_for_net_cost" <?php if ($hub_for_net_cost) {
                                                                                                        echo 'checked';
                                                                                                    } ?>>
    <div style="width: 100%;"></div>
</div>
