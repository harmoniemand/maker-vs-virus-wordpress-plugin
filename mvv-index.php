<?php

/**
 *
 * @package           mvv_hubs
 *
 * @wordpress-plugin
 * Plugin Name:       Maker Vs Virus Hubs
 * Version:           1.0.0
 * Author:            Jonathan Günz
 * Author URI:        https://hmnd.de
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mvv_hubs
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}


define( 'MS_DM_FILE', __FILE__ );
define( 'MS_DM_DIR', __DIR__ );


// the main plugin class
require_once dirname( __FILE__ ) . '/src/main.php';

MVV_Hubs_Main::instance();

register_activation_hook( __FILE__, array('MVV_Hubs_Main', 'activate' ) );
register_deactivation_hook( __FILE__, array('MVV_Hubs_Main', 'deactivate' ) );

