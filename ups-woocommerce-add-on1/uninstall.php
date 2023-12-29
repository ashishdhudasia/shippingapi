<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://www.ups.com
 * @since      1.0.0
 *
 * @package    Ups_Woocommerce_Add_On1
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $wpdb;
$tablename = $wpdb->prefix . 'ibconfig';
$wpdb->query( 'DROP TABLE ' . $tablename );
delete_metadata( 'post', 0, 'classification_status', '', true );
/*
$all_accounts = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %1s', $tablename ) );
$itembase     = new Itembase_Api();

if ( ! empty( $all_accounts ) ) {
	foreach ( $all_accounts as $key => $value ) {
		if ( isset( $value->ib_connection_id ) ) {
			$ib_api_key       = $value->ib_api_key;
			$ib_api_secret    = $value->ib_api_secret;
			$ib_connection_id = $value->ib_connection_id;
			if ( isset( $ib_api_key ) && isset( $ib_api_secret ) && isset( $ib_connection_id ) ) {
				$token      = $itembase->create_auth_jwt_token( $ib_api_key, $ib_api_secret );
				$connection = $itembase->delete_itembase_connection( $connection_id, $token );
			}
		}
	}
}


$wpdb->query( $wpdb->prepare( 'DROP TABLE  %1s', $tablename ) );

if ( ! function_exists( 'delete_all_metadata' ) ) {*/
	/**
	 * Remove all post meta data for Custom Post Type (CPT) at the time of uninstall of plugin that created this CPT.
	 * So that plugin do not leave behind any orphan post meta data related to its posttype.
	 * You may place this code in uninstall.php file in your plugin root directory.
	 *
	 * @param [string] $meta_type since we are deleting data for product.
	 * @param [string] $meta_key Your target meta_key added using update_post_meta().
	 * @return void
	 */

	/*
	function delete_all_metadata( $meta_type, $meta_key ) {

		$meta_type_value = $meta_type;
		$object_id       = 0;
		$meta_key_value  = $meta_key;
		$meta_value      = '';
		$delete_all      = true;
		// This will delete all post meta data having the specified key.
		delete_metadata( $meta_type_value, $object_id, $meta_key_value, $meta_value, $delete_all );
	}
}

delete_all_metadata( 'post', 'classifiaction_status' );
delete_all_metadata( 'post', 'classification_status' ); */
