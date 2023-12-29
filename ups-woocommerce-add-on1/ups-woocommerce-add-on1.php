<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.ups.com
 * @since             1.0.0
 * @package           Ups_Woocommerce_Add_On1
 *
 * @wordpress-plugin
 * Plugin Name:       UPS Woocommerce Add-On1 - Tax & Duties Rates
 * Plugin URI:        https://www.ups.com
 * Description:       UPS® Shipping Dashboard for WooCommerce
 * Version:           0.0.2
 * Author:            UPS Wocommerce
 * Author URI:        https://www.ups.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ups-woocommerce-add-on1
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'UPS_WOOCOMMERCE_ADD_ON1_VERSION', '0.0.2' );
define( 'UPSWOOCOMMERCE_ADDON1_PLUGIN_DIR', plugin_dir_path( __DIR__ . '/ups-woocommerce-add-on1/' ) );

/**
 * Define itembase varaibles
 */
define( 'ITEMBASE_CONNECT_INSTANCE_ID', '92569e08-cea1-4987-954e-dce16a67d681' );
global $wpdb;
define( 'ITEMBASE_CONNECTION_TABLE', $wpdb->prefix . 'ibconfig' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ups-woocommerce-add-on1-activator.php
 */
function activate_ups_woocommerce_add_on1() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ups-woocommerce-add-on1-activator.php';
	Ups_Woocommerce_Add_On1_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ups-woocommerce-add-on1-deactivator.php
 */
function deactivate_ups_woocommerce_add_on1() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ups-woocommerce-add-on1-deactivator.php';
	Ups_Woocommerce_Add_On1_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ups_woocommerce_add_on1' );
register_deactivation_hook( __FILE__, 'deactivate_ups_woocommerce_add_on1' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ups-woocommerce-add-on1.php';

/**
 * Object of itembase.
 */
require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-itembase-api.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ups_woocommerce_add_on1() {

	$plugin = new Ups_Woocommerce_Add_On1();
	$plugin->run();
}
run_ups_woocommerce_add_on1();
