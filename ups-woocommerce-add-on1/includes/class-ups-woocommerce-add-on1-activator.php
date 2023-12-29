<?php
/**
 * Fired during plugin activation
 *
 * @link       https://www.ups.com
 * @since      1.0.0
 *
 * @package    Ups_Woocommerce_Add_On1
 * @subpackage Ups_Woocommerce_Add_On1/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ups_Woocommerce_Add_On1
 * @subpackage Ups_Woocommerce_Add_On1/includes
 * @author     UPS Wocommerce <info@upswoocommerce.com>
 */
class Ups_Woocommerce_Add_On1_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		if ( ! in_array(
			'ups-woocommerce/ups-woocommerce.php',
			apply_filters( 'active_plugins', get_option( 'active_plugins' ) )
		) ) {
			wp_die(
				'<h1>UPS® Shipping Dashboard required</h1><p>UPS® Shipping Dashboard extension must be installed and activated first!</p>',
				'Plugin Activation Error',
				array(
					'response'  => 200,
					'back_link' => true,
				)
			);
		}

		global $wpdb;
		$table_schema = file_get_contents( UPSWOOCOMMERCE_ADDON1_PLUGIN_DIR . '/private/wordpress.sql' );
		if ( str_contains( $table_schema, 'wp_' ) ) {
			$table_schema = str_replace( 'wp_', $wpdb->prefix, $table_schema );
		}
		include_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $table_schema );
	}
}
