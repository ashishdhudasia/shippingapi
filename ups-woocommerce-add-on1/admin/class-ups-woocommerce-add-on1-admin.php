<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.ups.com
 * @since      1.0.0
 *
 * @package    Ups_Woocommerce_Add_On1
 * @subpackage Ups_Woocommerce_Add_On1/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ups_Woocommerce_Add_On1
 * @subpackage Ups_Woocommerce_Add_On1/admin
 * @author     UPS Wocommerce <info@upswoocommerce.com>
 */
class Ups_Woocommerce_Add_On1_Admin {

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
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ups_Woocommerce_Add_On1_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ups_Woocommerce_Add_On1_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ups-woocommerce-add-on1-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ups_Woocommerce_Add_On1_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ups_Woocommerce_Add_On1_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ups-woocommerce-add-on1-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'upsAjaxaddon1', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}

	/**
	 * Register addmin submenu menu on plugin activation
	 *
	 * @return void
	 */
	public function register_ups_addon1_admin_menu_page() {
		add_submenu_page(
			'ups-starting-here-page',
			__( 'Settings', 'ups-woocommerce-add-on1' ),
			__( 'Settings', 'ups-woocommerce-add-on1' ),
			'manage_options',
			'ups-setting-page',
			array( $this, 'ups_settings_page' ),
			1
		);
	}

	/**
	 * Include file with varables
	 *
	 * @param string $file_path get file path.
	 * @param array  $variables variables arry.
	 * @param mixed  $print output print.
	 *
	 * @return mixed
	 */
	public function include_with_variables( $file_path, $variables = array(), $print = true ) {
		extract( $variables );
		ob_start();
		include $file_path;
		$output = ob_get_clean();
		if ( ! $print ) {
			return $output;
		}
		echo $output;
	}

	/**
	 * Method add_html_form
	 *
	 * @return void
	 */
	public function connect_ups_dashboard_form() {

		$termsfile = file_get_contents( UPSWOOCOMMERCE_ADDON1_PLUGIN_DIR . 'terms-and-conditions.txt' );

		// Place each line of $termsfile into array.
		$terms_condtions_data = explode( "\n", $termsfile );

		$tchtml = '';

		foreach ( $terms_condtions_data as $index => $checkbox ) {
			$tchtml .= '<label>'
				. '<input type="checkbox" name="tc-checkbox-' . esc_attr( $index )
				. '" id="tc-checkbox-' . esc_attr( $index )
				. '" value="' . esc_attr( $index ) . '"/>' . $checkbox . '</label><br/>';
		}

		$this->include_with_variables(
			UPSWOOCOMMERCE_ADDON1_PLUGIN_DIR . 'admin/partials/ups-woocommerce-add-on1-starting-here-page.php',
			array(
				'terms_conditions' => $tchtml,
			)
		);
	}

	/**
	 * Method ups_settings_page
	 *
	 * @return void
	 */
	public function ups_settings_page() {
		include_once UPSWOOCOMMERCE_ADDON1_PLUGIN_DIR . 'admin/partials/ups-woocommerce-add-on1-admin-settings-page.php';
	}

	/**
	 * Ajax connect account method
	 *
	 * @return void
	 */
	public function create_connection() {

		if ( isset( $_POST['connect_account_form_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['connect_account_form_nonce'] ) ) ) {
			die( 'Security check failed' );
		}

		$gls_username   = ( ! empty( $_POST['gls_username'] ) ) ? sanitize_text_field( wp_unslash( $_POST['gls_username'] ) ) : '';
		$gls_password   = ( ! empty( $_POST['gls_password'] ) ) ? sanitize_text_field( wp_unslash( $_POST['gls_password'] ) ) : '';
		$account_number = ( ! empty( $_POST['account_number'] ) ) ? sanitize_text_field( wp_unslash( $_POST['account_number'] ) ) : '';

		$itembase   = new Itembase_Api();
		$api_key    = $itembase->generate_api_secret();
		$api_secret = $itembase->generate_api_secret();

		global $wpdb;
		$tablename = ITEMBASE_CONNECTION_TABLE . '';
		$ibcofig   = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM  %1s', $tablename ) );
		if ( $ibcofig ) {
			$wpdb->query( $wpdb->prepare( 'TRUNCATE TABLE %1s', $tablename ) );
		}

		$wpdb->insert(
			$tablename,
			array(
				'ib_api_key'      => $api_key,
				'ib_api_secret'   => $api_secret,
				'ib_account_name' => $account_number,
				'ib_created_date' => date( 'Y-m-d H:i:s' ),
			)
		);

		$ibcofig         = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %1s', $tablename ) );
		$ib_api_key      = $ibcofig[0]->ib_api_key;
		$ib_api_secret   = $ibcofig[0]->ib_api_secret;
		$connection      = $itembase->create_itembase_connection( $gls_username, $gls_password, $account_number, $ib_api_key, $ib_api_secret );
		$connection_data = json_decode( $connection );
		$status          = $connection_data->success;

		if ( isset( $status ) && ! empty( $status ) ) {
			$connection_id = $connection_data->result;
			if ( isset( $connection_id ) && ! empty( $connection_id ) ) {
				global $wpdb;
				$tablename = ITEMBASE_CONNECTION_TABLE . '';
				$wpdb->update(
					$tablename,
					array(
						'ib_connection_id'  => $connection_id,
						'ib_account_status' => 'Active',
						'ib_updated_date'   => date( 'Y-m-d H:i:s' ),
					),
					array(
						'ib_id' => 1,
					)
				);
				$ibcofig          = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %1s', $tablename ) );
				$ib_connection_id = $ibcofig[0]->ib_connection_id;
				if ( $ib_connection_id ) {
					echo wp_json_encode(
						array(
							'success' => true,
							'result'  => $ib_connection_id,
						)
					);

					global $wpdb;
					$tablename = ITEMBASE_CONNECTION_TABLE . '';
					$ibcofig   = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %1s', $tablename ) );
					if ( $ibcofig ) {

						$ib_api_key       = $ibcofig[0]->ib_api_key;
						$ib_api_secret    = $ibcofig[0]->ib_api_secret;
						$ib_connection_id = $ibcofig[0]->ib_connection_id;

						if ( isset( $ib_api_key ) && isset( $ib_api_secret ) && isset( $ib_connection_id ) ) {

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

							$product_data = $skus;
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
				} else {
					echo wp_json_encode(
						array(
							'success' => false,
							'message' => 'Connection ID not saved',
						)
					);
				}
			} else {
				echo wp_json_encode(
					array(
						'success' => false,
						'message' => 'Connection ID not found',
					)
				);
			}
		} else {
			$error = $connection_data->result;
			echo wp_json_encode(
				array(
					'success' => false,
					'message' => $error,
				)
			);
		}

		wp_die();
	}



	/**
	 * Ajax disconnect account method
	 *
	 * @return void
	 */
	public function delete_connection() {

		if ( isset( $_POST['account_form_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['account_form_nonce'] ) ) ) {
			die( 'Security check failed' );
		}

		$connection_id = ( ! empty( $_POST['delete_id'] ) ) ? sanitize_text_field( wp_unslash( $_POST['delete_id'] ) ) : '';
		global $wpdb;
		$tablename     = ITEMBASE_CONNECTION_TABLE . '';
		$ibcofig       = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %1s', $tablename ) );
		$ib_api_key    = $ibcofig[0]->ib_api_key;
		$ib_api_secret = $ibcofig[0]->ib_api_secret;

		$itembase        = new Itembase_Api();
		$token           = $itembase->create_auth_jwt_token( $ib_api_key, $ib_api_secret );
		$connection      = $itembase->delete_itembase_connection( $connection_id, $token );
		$connection_data = json_decode( $connection );
		$status          = $connection_data->success;

		$ibcofig = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %1s', $tablename ) );
		if ( $ibcofig ) {
			$wpdb->delete( $tablename, array( 'ib_connection_id' => $connection_id ) );
		}

		if ( isset( $status ) && ! empty( $status ) ) {
			echo wp_json_encode(
				array(
					'success' => true,
					'result'  => $connection_data->result,
				)
			);
			global $wpdb;
			$tablename = ITEMBASE_CONNECTION_TABLE . '';
			$wpdb->query( $wpdb->prepare( 'TRUNCATE TABLE %1s', $tablename ) );

		} else {
			$error = $connection_data->result;
			echo wp_json_encode(
				array(
					'success' => false,
					'message' => $error,
				)
			);
		}

		wp_die();
	}

	/**
	 * Add UPS global checkout method to shipping zone.
	 *
	 * @return void
	 */
	public function ups_add_shipping_method_to_zone() {

		if ( isset( $_POST['ups_checkout_data_form_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['ups_checkout_data_form_nonce'] ) ) ) {
			die( 'Security check failed' );
		}

		$method_id     = ( ! empty( $_POST['method_id'] ) ) ? sanitize_text_field( wp_unslash( $_POST['method_id'] ) ) : '';
		$zone_id       = ( ! empty( $_POST['zone_id'] ) ) ? sanitize_text_field( wp_unslash( $_POST['zone_id'] ) ) : '';
		$method_action = ( ! empty( $_POST['method_action'] ) ) ? sanitize_text_field( wp_unslash( $_POST['method_action'] ) ) : '';

		$zone = new WC_Shipping_Zone( $zone_id );
		if ( isset( $method_action ) && null !== $method_action && 'add' === $method_action ) {
			$instance_id = $zone->add_shipping_method( $method_id );
		} else {
			foreach ( $zone->get_shipping_methods() as $index => $method ) {
				$method_title = $method->get_method_title();
				if ( 'Ups Shipping' === $method_title ) {
					$method_instance_id = $method->get_instance_id();
				}
			}
			$instance_id = $zone->delete_shipping_method( $method_instance_id );
		}

		if ( $instance_id ) {
			$result = array(
				'instance_id' => $instance_id,
			);
			echo wp_json_encode(
				array(
					'success' => true,
					'result'  => $result,
				)
			);
		} else {
			$result = array(
				'zone_id' => $zone_id,
			);
			echo wp_json_encode(
				array(
					'success' => false,
					'result'  => $result,
					'message' => 'shipping method not added',
				)
			);
		}
		wp_die();
	}

	/**
	 * Update simple product and send for classification
	 *
	 * @param [string] $product_id Product Id.
	 * @return void
	 */
	public function ups_simple_product_save( $product_id ) {
		$product = wc_get_product( $product_id );
		if ( $product ) {
			$weight_unit    = get_option( 'woocommerce_weight_unit', '' );
			$dimension_unit = get_option( 'woocommerce_dimension_unit', '' );
			$products       = array();
			$post_status    = get_post_status( $product_id );
			if ( 'publish' === $post_status ) {
				$permalink = esc_attr( $product->get_permalink() );
			} else {
				$permalink = '';
			}
			if ( $product->get_type() === 'simple' ) {
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
			if ( ! empty( $products ) ) {

				global $wpdb;
				$tablename = ITEMBASE_CONNECTION_TABLE . '';
				$ibcofig   = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %1s', $tablename ) );
				if ( $ibcofig ) {

					$ib_api_key       = $ibcofig[0]->ib_api_key;
					$ib_api_secret    = $ibcofig[0]->ib_api_secret;
					$ib_connection_id = $ibcofig[0]->ib_connection_id;

					if ( isset( $ib_api_key ) && isset( $ib_api_secret ) && isset( $ib_connection_id ) ) {

						$product_data = $products;

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
	}

	/**
	 * Update variable product and send for classification
	 *
	 * @param [string] $product_id Product Id Here is variation ID.
	 * @return void
	 */
	public function ups_variable_product_update( $product_id ) {
		$variation = wc_get_product( $product_id );

		$variation_id          = $product_id;
		$sku                   = $variation->get_sku();
		$variation_sku         = ( isset( $sku ) ) ? $sku : '';
		$description           = $variation->get_description();
		$variation_description = ( isset( $description ) ) ? $description : '';
		$price                 = $variation->get_regular_price();
		$variation_price       = ( isset( $price ) ) ? $price : '';
		$weight                = $variation->get_weight();
		$variation_weight      = ( isset( $weight ) ) ? $weight : '';
		$length                = $variation->get_length();
		$variation_length      = ( isset( $length ) ) ? $length : '';
		$width                 = $variation->get_width();
		$variation_width       = ( isset( $width ) ) ? $width : '';
		$height                = $variation->get_height();
		$variation_height      = ( isset( $height ) ) ? $height : '';

		$post_status = get_post_status( $variation->get_parent_id() );
		$product     = wc_get_product( $variation->get_parent_id() );
		if ( 'publish' === $post_status ) {
			$permalink = esc_attr( $product->get_permalink() );
		} else {
			$permalink = '';
		}

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

		$weight_unit    = get_option( 'woocommerce_weight_unit', '' );
		$dimension_unit = get_option( 'woocommerce_dimension_unit', '' );

		$products   = array();
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

		if ( ! empty( $products ) ) {

			global $wpdb;
			$tablename = ITEMBASE_CONNECTION_TABLE . '';
			$ibcofig   = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %1s', $tablename ) );
			if ( $ibcofig ) {

				$ib_api_key       = $ibcofig[0]->ib_api_key;
				$ib_api_secret    = $ibcofig[0]->ib_api_secret;
				$ib_connection_id = $ibcofig[0]->ib_connection_id;

				if ( isset( $ib_api_key ) && isset( $ib_api_secret ) && isset( $ib_connection_id ) ) {

					$product_data = $products;

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

	/**
	 * Create variable product and send for classification
	 *
	 * @param [string] $new_status post new status.
	 * @param [string] $old_status post old status.
	 * @param [array]  $post Post object.
	 * @return void
	 */
	public function ups_variable_product_create( $new_status, $old_status, $post ) {
		if ( 'product' === $post->post_type && 'publish' === $new_status && 'publish' !== $old_status ) {
			$product_id     = $post->ID;
			$product        = wc_get_product( $product_id );
			$weight_unit    = get_option( 'woocommerce_weight_unit', '' );
			$dimension_unit = get_option( 'woocommerce_dimension_unit', '' );
			$products       = array();
			$post_status    = get_post_status( $product_id );
			if ( 'publish' === $post_status ) {
				$permalink = esc_attr( $product->get_permalink() );
			} else {
				$permalink = '';
			}
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
			if ( ! empty( $products ) ) {

				global $wpdb;
				$tablename = ITEMBASE_CONNECTION_TABLE . '';
				$ibcofig   = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %1s', $tablename ) );
				if ( $ibcofig ) {

					$ib_api_key       = $ibcofig[0]->ib_api_key;
					$ib_api_secret    = $ibcofig[0]->ib_api_secret;
					$ib_connection_id = $ibcofig[0]->ib_connection_id;

					if ( isset( $ib_api_key ) && isset( $ib_api_secret ) && isset( $ib_connection_id ) ) {

						$product_data = $products;

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
	}
}
