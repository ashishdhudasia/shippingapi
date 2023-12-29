<?php
/**
 * Fired during plugin deactivation
 *
 * @link       https://www.ups.com
 * @since      1.0.0
 *
 * @package    Ups_Woocommerce_Add_On1
 * @subpackage Ups_Woocommerce_Add_On1/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during cron event.
 *
 * @since      1.0.0
 * @package    Ups_Woocommerce_Add_On1
 * @subpackage Ups_Woocommerce_Add_On1/includes
 * @author     UPS Wocommerce <info@upswoocommerce.com>
 */
class Ups_Woocommerce_Add_On1_Cron {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Add interval to cron schedules
	 *
	 * @param [array] $schedules Get schedules.
	 * @return array
	 */
	public static function cronschedule( $schedules ) {
		$schedules['ups_twice_daily'] = array(
			'interval' => 43200,
			'display'  => __( 'Twice Daily', 'ups-woocommerce-add-on1' ),
		);
		return $schedules;
	}

	/**
	 * Schedule ups corns
	 *
	 * @return void
	 */
	public static function ups_crons() {
		if ( ! wp_next_scheduled( 'ups_cron_product_classification' ) ) {
			wp_schedule_event( time(), 'ups_twice_daily', 'ups_cron_product_classification' );
		}

		if ( ! wp_next_scheduled( 'ups_cron_product_hscoderequest' ) ) {
			wp_schedule_event( time(), 'ups_twice_daily', 'ups_cron_product_hscoderequest' );
		}
	}

	/**
	 * Check product classifiaction status
	 *
	 * @return array
	 */
	public function get_products_sku_data() {
		$product_args = array(
			'status' => 'publish',
			'limit'  => -1,
		);
		$all_products = wc_get_products( $product_args );
		$skus         = array();
		foreach ( $all_products as $product ) {
			if ( $product->get_type() === 'variable' ) {
				$variable_product = new WC_Product_Variable( $product->get_id() );
				$variations       = $variable_product->get_available_variations();
				foreach ( $variations as $variation ) {
					$variation_id          = esc_attr( $variation['variation_id'] );
					$classification_status = get_post_meta( $variation_id, 'classification_status', true );
					if ( isset( $classification_status ) && 'Classified' !== $classification_status ) {
						$skus[] = array(
							'product_id'  => $variation['variation_id'],
							'product_sku' => $variation['sku'],
						);
					}
				}
			} elseif ( $product->get_type() === 'simple' ) {
				$is_virtual_downloadable_item = $product->is_downloadable() && $product->is_virtual();
				if ( isset( $is_virtual_downloadable_item ) && ! $is_virtual_downloadable_item ) {
					$product_id            = esc_attr( $product->get_id() );
					$classification_status = get_post_meta( $product_id, 'classification_status', true );
					if ( isset( $classification_status ) && 'Classified' !== $classification_status ) {
						$product_sku = esc_attr( $product->get_sku() );
						$skus[]      = array(
							'product_id'  => $product_id,
							'product_sku' => $product_sku,
						);
					}
				}
			}
		}
		return ( ! empty( $skus ) ) ? $skus : '';
	}

	/**
	 * Update product classification status
	 *
	 * @return void
	 */
	public function update_product_classification_status() {
		$to      = 'a.dhudasia@brightness-india.com';
		$subject = 'Classification corn';
		$message = 'Test mail from product classification cron';
		$headers = 'From: The Sender name <a.dhudasia@brightness-india.com>';
		wp_mail( $to, $subject, $message, $headers );

		global $wpdb;
		$tablename = ITEMBASE_CONNECTION_TABLE . '';
		$ibcofig   = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %1s', $tablename ) );
		if ( $ibcofig ) {

			$ib_api_key       = $ibcofig[0]->ib_api_key;
			$ib_api_secret    = $ibcofig[0]->ib_api_secret;
			$ib_connection_id = $ibcofig[0]->ib_connection_id;

			if ( isset( $ib_api_key ) && isset( $ib_api_secret ) && isset( $ib_connection_id ) ) {

				$product_data = $this->get_products_sku_data();

				$product_skus = wp_list_pluck( $product_data, 'product_sku' );
				$skus         = array();
				foreach ( $product_skus as $product_sku ) {
					$skus[] = array(
						'sku' => $product_sku,
					);
				}

				$count = count( $skus );
				if ( $count > 2000 ) {
					$chunks = array_chunk( $skus, 2000 );
					foreach ( $chunks as $chunk ) {
						$itembase             = new Itembase_Api();
						$token                = $itembase->create_auth_jwt_token( $ib_api_key, $ib_api_secret );
						$connection_data      = $itembase->check_product_classification_status( $ib_connection_id, $token, $chunk );
						$classificationresult = json_decode( $connection_data );
						$classificationskus   = $classificationresult->result->skus;
						foreach ( $classificationskus as $classificationsku ) {
							$classifiaction_sku    = $classificationsku->sku;
							$classification_status = $classificationsku->classified;
							foreach ( $product_data as $product ) {
								$product_sku = $product['product_sku'];
								if ( $product_sku === $classifiaction_sku ) {
									$product_id = $product['product_id'];
									if ( true === $classification_status ) {
										$classification_status = 'Classified';
									} else {
										$classification_status = 'New';
									}
									update_post_meta( $product_id, 'classification_status', $classification_status );
								}
							}
						}
					}
				} else {
					$itembase             = new Itembase_Api();
					$token                = $itembase->create_auth_jwt_token( $ib_api_key, $ib_api_secret );
					$connection_data      = $itembase->check_product_classification_status( $ib_connection_id, $token, $skus );
					$classificationresult = json_decode( $connection_data );
					$classificationskus   = $classificationresult->result->skus;
					foreach ( $classificationskus as $classificationsku ) {
						$classifiaction_sku    = $classificationsku->sku;
						$classification_status = $classificationsku->classified;
						foreach ( $product_data as $product ) {
							$product_sku = $product['product_sku'];
							if ( $product_sku === $classifiaction_sku ) {
								$product_id = $product['product_id'];
								if ( true === $classification_status ) {
									$classification_status = 'Classified';
								} else {
									$classification_status = 'New';
								}
								update_post_meta( $product_id, 'classification_status', $classification_status );
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Get products data
	 *
	 * @return array
	 */
	public function get_products_data() {
		$product_args   = array(
			'status' => 'publish',
			'limit'  => -1,
		);
		$all_products   = wc_get_products( $product_args );
		$weight_unit    = get_option( 'woocommerce_weight_unit', '' );
		$dimension_unit = get_option( 'woocommerce_dimension_unit', '' );
		$products       = array();
		foreach ( $all_products as $product ) {
			$product_idd = $product->get_id();
			if ( $product_idd == 2823 || $product_idd == 2824 ) {
				$permalink = esc_attr( $product->get_permalink() );
				if ( $product->get_type() === 'variable' ) {
					$variable_product = new WC_Product_Variable( $product->get_id() );
					$variations       = $variable_product->get_available_variations();
					foreach ( $variations as $variation ) {
						$variation_id          = $variation['variation_id'];
						$variation_sku         = ( isset( $variation['sku'] ) ) ? $variation['sku'] : '';
						$variation_description = ( isset( $variation['variation_description'] ) ) ? $variation['variation_description'] : '';
						$variation_price       = ( isset( $variation['display_regular_price'] ) ) ? $variation['display_regular_price'] : '';
						$variation_weight      = ( isset( $variation['weight'] ) ) ? $variation['weight'] : '';
						$variation_length      = ( isset( $variation['dimensions']['length'] ) ) ? $variation['dimensions']['length'] : '';
						$variation_width       = ( isset( $variation['dimensions']['width'] ) ) ? $variation['dimensions']['width'] : '';
						$variation_height      = ( isset( $variation['dimensions']['height'] ) ) ? $variation['dimensions']['height'] : '';

						$variation_attributes = $product->get_variation_attributes( $variation_id );
						$attribute            = array();
						foreach ( $variation_attributes as $attribute_name => $attribute_value ) {
							$attribute[] = wc_attribute_label( $attribute_name );
						}
						$attribute1 = ( isset( $attribute[0] ) ) ? $attribute[0] : '';
						$attribute2 = ( isset( $attribute[1] ) ) ? $attribute[1] : '';
						$attribute3 = ( isset( $attribute[2] ) ) ? $attribute[2] : '';
						$attribute4 = ( isset( $attribute[3] ) ) ? $attribute[3] : '';
						$attribute5 = ( isset( $attribute[4] ) ) ? $attribute[4] : '';
						$attribute6 = ( isset( $attribute[5] ) ) ? $attribute[5] : '';

						$classification_status = get_post_meta( $variation_id, 'classification_status', true );
						if ( isset( $classification_status ) && 'Classified' !== $classification_status ) {
							$products[] = array(
								'productId'     => $variation_id,
								'description'   => wp_strip_all_tags( $variation_description ),
								'sku'           => $variation_sku,
								'originCountry' => null,
								'attribute1'    => $attribute1,
								'attribute2'    => $attribute2,
								'attribute3'    => $attribute3,
								'attribute4'    => $attribute4,
								'attribute5'    => $attribute5,
								'attribute6'    => $attribute6,
								'hsCodeUS'      => null,
								'currentPrice'  => $variation_price,
								'productUrl'    => $permalink,
								'weight'        => $variation_weight,
								'skn'           => null,
								'length'        => $variation_length,
								'width'         => $variation_width,
								'height'        => $variation_height,
								'shipAlone'     => null,
								'delete'        => null,
								'weightUnit'    => $weight_unit,
								'dimUnit'       => $dimension_unit,
								'batteryType'   => null,
							);
						}
					}
				} elseif ( $product->get_type() === 'simple' ) {
					$is_virtual_downloadable_item = $product->is_downloadable() && $product->is_virtual();
					if ( isset( $is_virtual_downloadable_item ) && ! $is_virtual_downloadable_item ) {
						$product_id          = esc_attr( $product->get_id() );
						$product_description = wp_strip_all_tags( $product->get_description() );
						$product_sku         = esc_attr( $product->get_sku() );
						$product_price       = esc_attr( $product->get_regular_price() );
						$product_weight      = esc_attr( $product->get_weight() );
						$product_length      = esc_attr( $product->get_length() );
						$product_width       = esc_attr( $product->get_width() );
						$product_height      = esc_attr( $product->get_height() );

						$attribute1 = '';
						$attribute2 = '';
						$attribute3 = '';
						$attribute4 = '';
						$attribute5 = '';
						$attribute6 = '';

						$classification_status = get_post_meta( $product_id, 'classification_status', true );
						if ( isset( $classification_status ) && 'Classified' !== $classification_status ) {
							$products[] = array(
								'productId'     => ( isset( $product_id ) ) ? $product_id : '',
								'description'   => ( isset( $product_description ) ) ? $product_description : '',
								'sku'           => ( isset( $product_sku ) ) ? $product_sku : '',
								'originCountry' => null,
								'attribute1'    => $attribute1,
								'attribute2'    => $attribute2,
								'attribute3'    => $attribute3,
								'attribute4'    => $attribute4,
								'attribute5'    => $attribute5,
								'attribute6'    => $attribute6,
								'hsCodeUS'      => null,
								'currentPrice'  => ( isset( $product_price ) ) ? $product_price : '',
								'productUrl'    => $permalink,
								'weight'        => ( isset( $product_weight ) ) ? $product_weight : '',
								'skn'           => null,
								'length'        => ( isset( $product_length ) ) ? $product_length : '',
								'width'         => ( isset( $product_width ) ) ? $product_width : '',
								'height'        => ( isset( $product_height ) ) ? $product_height : '',
								'shipAlone'     => null,
								'delete'        => null,
								'weightUnit'    => $weight_unit,
								'dimUnit'       => $dimension_unit,
								'batteryType'   => null,
							);
						}
					}
				}
			}
		}
		return ( ! empty( $products ) ) ? $products : '';
	}

	/**
	 * Send Product for Hscode request
	 */
	public function send_product_hscoderequest() {
		$to      = 'a.dhudasia@brightness-india.com';
		$subject = 'Hscode request cron';
		$message = 'Test mail from hscode cron';
		$headers = 'From: The Sender name <a.dhudasia@brightness-india.com>';
		wp_mail( $to, $subject, $message, $headers );

		global $wpdb;
		$tablename = ITEMBASE_CONNECTION_TABLE . '';
		$ibcofig   = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %1s', $tablename ) );
		if ( $ibcofig ) {

			$ib_api_key       = $ibcofig[0]->ib_api_key;
			$ib_api_secret    = $ibcofig[0]->ib_api_secret;
			$ib_connection_id = $ibcofig[0]->ib_connection_id;

			if ( isset( $ib_api_key ) && isset( $ib_api_secret ) && isset( $ib_connection_id ) ) {

				$product_data = $this->get_products_data();
				/*
				$itembase           = new Itembase_Api();
				$token              = $itembase->create_auth_jwt_token( $ib_api_key, $ib_api_secret );
				$hscoderequest_data = $itembase->hscoderequest( $ib_connection_id, $token, $product_data );
				$hscoderesult       = json_decode( $hscoderequest_data );
				print_r( $hscoderesult );
				exit;
				*/

			}
		}
	}
}
