<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.ups.com
 * @since      1.0.0
 *
 * @package    Ups_Woocommerce_Add_On1
 * @subpackage Ups_Woocommerce_Add_On1/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Ups_Woocommerce_Add_On1
 * @subpackage Ups_Woocommerce_Add_On1/includes
 * @author     UPS Wocommerce <info@upswoocommerce.com>
 */
class Ups_Woocommerce_Add_On1 {


	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Ups_Woocommerce_Add_On1_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'UPS_WOOCOMMERCE_ADD_ON1_VERSION' ) ) {
			$this->version = UPS_WOOCOMMERCE_ADD_ON1_VERSION;
		} else {
			$this->version = '0.0.2';
		}
		$this->plugin_name = 'ups-woocommerce-add-on1';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_cron_hooks();

		add_action( 'woocommerce_shipping_init', array( $this, 'ups_include_shipping_method' ) );
		add_filter( 'woocommerce_shipping_methods', array( $this, 'ups_add_shipping_method' ) );
		add_filter( 'manage_edit-product_columns', array( $this, 'admin_products_ups_column' ), 9999 );
		add_action( 'manage_product_posts_custom_column', array( $this, 'admin_products_ups_column_content' ), 10, 2 );
		add_filter( 'transient_shipping-transient-version', '__return_false', 10, 2 );
		add_filter( 'woocommerce_package_rates', array( $this, 'custom_shipping_fee_by_ups' ), 10, 2 );
		add_action( 'woocommerce_checkout_update_order_review', array( $this, 'ups_save_checkout_values' ), 9999 );
		add_action( 'woocommerce_review_order_before_order_total', array( $this, 'ups_shipping_details' ), 20 );
		add_filter( 'woocommerce_cart_shipping_method_full_label', array( $this, 'ups_add_0_to_shipping_label' ), 9999, 2 );
		add_filter( 'woocommerce_order_shipping_to_display', array( $this, 'ups_add_0_to_shipping_label_ordered' ), 9999, 3 );
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Ups_Woocommerce_Add_On1_Loader. Orchestrates the hooks of the plugin.
	 * - Ups_Woocommerce_Add_On1_i18n. Defines internationalization functionality.
	 * - Ups_Woocommerce_Add_On1_Admin. Defines all hooks for the admin area.
	 * - Ups_Woocommerce_Add_On1_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-ups-woocommerce-add-on1-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-ups-woocommerce-add-on1-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'admin/class-ups-woocommerce-add-on1-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'public/class-ups-woocommerce-add-on1-public.php';

		/**
		 * The class responsible for defining all actions that occur in the cron events
		 * of the plugin.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-ups-woocommerce-add-on1-cron.php';

		$this->loader = new Ups_Woocommerce_Add_On1_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Ups_Woocommerce_Add_On1_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Ups_Woocommerce_Add_On1_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Ups_Woocommerce_Add_On1_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'register_ups_addon1_admin_menu_page', 99 );
		$this->loader->add_action( 'connect_ups_dashboard_form', $plugin_admin, 'connect_ups_dashboard_form' );
		$this->loader->add_action( 'wp_ajax_create_connection', $plugin_admin, 'create_connection' );
		$this->loader->add_action( 'wp_ajax_delete_connection', $plugin_admin, 'delete_connection' );
		$this->loader->add_action( 'wp_ajax_ups_add_shipping_method_to_zone', $plugin_admin, 'ups_add_shipping_method_to_zone' );
		$this->loader->add_action( 'woocommerce_new_product', $plugin_admin, 'ups_simple_product_save', 10, 1 );
		$this->loader->add_action( 'woocommerce_update_product', $plugin_admin, 'ups_simple_product_save', 10, 1 );
		$this->loader->add_action( 'transition_post_status', $plugin_admin, 'ups_variable_product_create', 9999, 3 );
		$this->loader->add_action( 'woocommerce_update_product_variation', $plugin_admin, 'ups_variable_product_update', 10, 1 );

		// $this->loader->add_action( 'admin_init', $plugin_admin, 'producthscoderequest' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Ups_Woocommerce_Add_On1_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	/**
	 * Register all of the hooks related to the cron functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_cron_hooks() {

		$plugin_cron = new Ups_Woocommerce_Add_On1_Cron( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_filter( 'cron_schedules', $plugin_cron, 'cronschedule' );
		$this->loader->add_action( 'init', $plugin_cron, 'ups_crons' );
		$this->loader->add_action( 'ups_cron_product_classification', $plugin_cron, 'update_product_classification_status' );
		$this->loader->add_action( 'ups_cron_product_hscoderequest', $plugin_cron, 'send_product_hscoderequest' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Ups_Woocommerce_Add_On1_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Include your shipping file.
	 */
	public function ups_include_shipping_method() {
		require_once 'class-ups-shipping-method.php';
	}

	/**
	 * Get woocommerce checkout posted data and store to session
	 *
	 * @param [array] $posted_data Get checkout field value.
	 * @return void
	 */
	public function ups_save_checkout_values( $posted_data ) {
		parse_str( $posted_data, $output );
		WC()->session->set( 'checkout_data', $output );
	}

	/**
	 * Add Your shipping method class in the shipping list
	 *
	 * @param array $methods Get woocomerce shipping methods.
	 */
	public function ups_add_shipping_method( $methods ) {
		$methods['ups-shipping-method'] = 'Ups_Shipping_Method';
		return $methods;
	}

	/**
	 * Add UPS Global Checkout classification column in product listing woocommerce
	 *
	 * @param   array $columns Get the current columns of product table woocommerce.
	 * @return  array  New columns added by this function.
	 */
	public function admin_products_ups_column( $columns ) {
		$columns['ups-globl-checkout-classification'] = 'UPS® Global Checkout Classification';
		$columns                                      = array_slice( $columns, 0, 8, true ) + array( 'ups-globl-checkout-classification' => 'UPS® Global Checkout Classification' ) + array_slice( $columns, 8, count( $columns ) - 8, true );
		return $columns;
	}

	/**
	 * Add Ups Global checkout classificatiion staus to product listing
	 *
	 * @param string $column      Get the current columns of product table woocommerce.
	 * @param int    $product_id  Get the current product ID from product table woocommerce.
	 */
	public function admin_products_ups_column_content( $column, $product_id ) {
		if ( 'ups-globl-checkout-classification' === $column ) {
			$product = wc_get_product( $product_id );
			if ( $product->get_type() === 'variable' ) {
				$variable_product  = new WC_Product_Variable( $product->get_id() );
				$variations        = $variable_product->get_available_variations();
				$variations_status = array();
				foreach ( $variations as $variation ) {
					$varation_id = $variation['variation_id'];
					if ( get_post_meta( $varation_id, 'classification_status', true ) ) {
						$variation_classification_status = get_post_meta( $varation_id, 'classification_status', true );
						$variations_status[]             = $variation_classification_status;
					} else {
						$variations_status[] = '';
					}
				}
				if ( count( array_unique( $variations_status ) ) === 1 && 'Classified' === array_unique( $variations_status )[0] ) {
					$classification_status = 'Classified';
				} else {
					$classification_status = 'New';
				}
			} elseif ( $product->get_type() === 'simple' ) {
				$is_virtual_downloadable_item = $product->is_downloadable() && $product->is_virtual();
				if ( isset( $is_virtual_downloadable_item ) && ! $is_virtual_downloadable_item ) {
					if ( get_post_meta( $product_id, 'classification_status', true ) ) {
						$classification_status = get_post_meta( $product_id, 'classification_status', true );
					} else {
						$classification_status = 'New';
					}
				} else {
					$classification_status = 'Not Supported';
				}
			} elseif ( $product->get_type() === 'grouped' ) {
				$children_products = $product->get_children();
				$variations_status = array();
				foreach ( $children_products as $children_product ) {
					$product_id = $children_product;
					$product    = wc_get_product( $product_id );
					if ( $product->get_type() === 'variable' ) {
						$variable_product = new WC_Product_Variable( $product->get_id() );
						$variations       = $variable_product->get_available_variations();
						foreach ( $variations as $variation ) {
							$varation_id = $variation['variation_id'];
							if ( get_post_meta( $varation_id, 'classification_status', true ) ) {
								$variation_classification_status = get_post_meta( $varation_id, 'classification_status', true );
								$variations_status[]             = $variation_classification_status;
							} else {
								$variations_status[] = '';
							}
						}
					} elseif ( $product->get_type() === 'simple' ) {
						$is_virtual_downloadable_item = $product->is_downloadable() && $product->is_virtual();
						if ( isset( $is_virtual_downloadable_item ) && ! $is_virtual_downloadable_item ) {
							if ( get_post_meta( $product_id, 'classification_status', true ) ) {
								$simple_classification_status = get_post_meta( $product_id, 'classification_status', true );
								$variations_status[]          = $simple_classification_status;
							} else {
								$variations_status[] = '';
							}
						} else {
							$variations_status[] = 'Not Supported';
						}
					}
				}
				if ( count( array_unique( $variations_status ) ) === 1 && 'Classified' === array_unique( $variations_status )[0] ) {
					$classification_status = 'Classified';
				} else {
					$classification_status = 'New';
				}
			} elseif ( $product->get_type() === 'external' ) {
				$classification_status = 'Not Supported';
			}
			echo esc_html(
				sprintf(
					__( '%s', 'ups-woocommerce-add-on1' ),
					$classification_status
				)
			) . ' <span class="dashicons dashicons-info"></span>';
		}
	}

	/**
	 * Add Ups Global checkout fees by ups product tad and qutoes API.
	 *
	 * @param mixed $rates Get rates from woocommerce on cart and checkout page.
	 * @param mixed $package Get packegs of shipping.
	 */
	public function custom_shipping_fee_by_ups( $rates, $package ) {

		if ( ! is_checkout() ) {
			foreach ( $rates as $rate_id => $rate_val ) {
				if ( 'ups-shipping-method' === $rate_val->get_method_id() ) {
					unset( $rates[ $rate_id ] );
				}
			}
		} else {

			global $wpdb;
			$tablename = ITEMBASE_CONNECTION_TABLE . '';
			$ibcofig   = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %1s', $tablename ) );
			if ( $ibcofig ) {

				$ib_api_key       = $ibcofig[0]->ib_api_key;
				$ib_api_secret    = $ibcofig[0]->ib_api_secret;
				$ib_connection_id = $ibcofig[0]->ib_connection_id;

				if ( is_checkout() ) {

					if ( isset( $ib_api_key ) && isset( $ib_api_secret ) && isset( $ib_connection_id ) ) {

						$classified_status = array();
						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
							$variation_id = $cart_item['variation_id'];
							if ( $variation_id && 0 !== $variation_id ) {
								$product_id = $variation_id;
							} else {
								$product_id = $cart_item['product_id'];
							}
							$classified          = get_post_meta( $product_id, 'classification_status', true );
							$classified_status[] = $classified;
						}

						if ( count( array_unique( $classified_status ) ) === 1 && 'Classified' === array_unique( $classified_status )[0] ) {

							$check = false;
							foreach ( $rates as $rate_key => $rate ) {
								if ( 'ups-shipping-method' === $rate->method_id ) {
									$check = true;
								}
							}
							if ( true === $check ) {

								$product_data   = array();
								$weight_unit    = get_option( 'woocommerce_weight_unit', '' );
								$dimension_unit = get_option( 'woocommerce_dimension_unit', '' );
								$currency       = get_option( 'woocommerce_currency', '' );

								foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
									$product             = $cart_item['data'];
									$product_id          = $cart_item['product_id'];
									$variation_id        = $cart_item['variation_id'];
									$quantity            = $cart_item['quantity'];
									$price               = $product->get_regular_price();
									$weight              = $product->get_weight();
									$width               = $product->get_width();
									$length              = $product->get_length();
									$height              = $product->get_height();
									$sku                 = $product->get_sku();
									$product_description = $product->get_description();

									$product_data[] = array(
										'sku'             => $sku,
										'weight'          => $weight,
										'length'          => $length,
										'width'           => $width,
										'height'          => $height,
										'dimUnit'         => $dimension_unit,
										'weightUnit'      => $weight_unit,
										'htsCode'         => null,
										'originCountry'   => null,
										'quantity'        => $quantity,
										'originalPrice'   => $price,
										'description'     => $product_description,
										'valueCompanyCurrency' => null,
										'companyCurrency' => null,
										'valueShopperCurrency' => null,
										'shopperCurrency' => null,
										'itemStyle'       => null,
										'requestedSku'    => null,
									);
								}

								/* SETTING UP THE ORIGIN ADDRESS DATA [START] */
								$store_address   = get_option( 'woocommerce_store_address', '' );
								$store_address_2 = get_option( 'woocommerce_store_address_2', '' );
								$store_city      = get_option( 'woocommerce_store_city', '' );
								$store_zip       = get_option( 'woocommerce_store_postcode', '' );

								$store_country_raw = get_option( 'woocommerce_default_country', '' );
								$split_country     = explode( ':', $store_country_raw );
								$store_country     = $split_country[0];
								$store_state       = $split_country[1];

								$origin_address_data = array(
									'addressLine1' => $store_address,
									'addressLine2' => $store_address_2,
									'city'         => $store_city,
									'state'        => $store_state,
									'zip'          => $store_zip,
									'country'      => $store_country,
								);
								/* SETTING UP THE ORIGIN ADDRESS DATA [END] */

								/* SETTING UP THE BILLING ADDRESS DATA [START] */
								$checkout_session_data = WC()->session->get( 'checkout_data' );

								$billing_first_name = WC()->cart->get_customer()->get_billing_first_name();
								if ( isset( $billing_first_name ) && ! empty( $billing_first_name ) && null !== $billing_first_name ) {
									$b_first_name = $billing_first_name;
								} elseif ( isset( $checkout_session_data['billing_first_name'] ) && ! empty( $checkout_session_data['billing_first_name'] ) ) {
									$b_first_name = $checkout_session_data['billing_first_name'];
								}

								$billing_last_name = WC()->cart->get_customer()->get_billing_last_name();
								if ( isset( $billing_last_name ) && ! empty( $billing_last_name ) && null !== $billing_last_name ) {
									$b_last_name = $billing_last_name;
								} elseif ( isset( $checkout_session_data['billing_last_name'] ) && ! empty( $checkout_session_data['billing_last_name'] ) ) {
									$b_last_name = $checkout_session_data['billing_last_name'];
								}

								$billing_company = WC()->cart->get_customer()->get_billing_company();
								if ( isset( $billing_company ) && ! empty( $billing_company ) && null !== $billing_company ) {
									$b_company = $billing_company;
								} elseif ( isset( $checkout_session_data['billing_company'] ) && ! empty( $checkout_session_data['billing_company'] ) ) {
									$b_company = $checkout_session_data['billing_company'];
								}

								$billing_email = WC()->cart->get_customer()->get_billing_email();
								if ( isset( $billing_email ) && ! empty( $billing_email ) && null !== $billing_email ) {
									$b_email = $billing_email;
								} elseif ( isset( $checkout_session_data['billing_email'] ) && ! empty( $checkout_session_data['billing_email'] ) ) {
									$b_email = $checkout_session_data['billing_email'];
								}

								$billing_phone = WC()->cart->get_customer()->get_billing_phone();
								if ( isset( $billing_phone ) && ! empty( $billing_phone ) && null !== $billing_phone ) {
									$b_phone = $billing_phone;
								} elseif ( isset( $checkout_session_data['billing_phone'] ) && ! empty( $checkout_session_data['billing_phone'] ) ) {
									$b_phone = $checkout_session_data['billing_phone'];
								}

								$billing_country = WC()->cart->get_customer()->get_billing_country();
								if ( isset( $billing_country ) && ! empty( $billing_country ) && null !== $billing_country ) {
									$b_country = $billing_country;
								} elseif ( isset( $checkout_session_data['billing_country'] ) && ! empty( $checkout_session_data['billing_country'] ) ) {
									$b_country = $checkout_session_data['billing_country'];
								}

								$billing_state = WC()->cart->get_customer()->get_billing_state();
								if ( isset( $billing_state ) && ! empty( $billing_state ) && null !== $billing_state ) {
									$b_state = $billing_state;
								} elseif ( isset( $checkout_session_data['billing_state'] ) && ! empty( $checkout_session_data['billing_state'] ) ) {
									$b_state = $checkout_session_data['billing_state'];
								}

								$billing_postcode = WC()->cart->get_customer()->get_billing_postcode();
								if ( isset( $billing_postcode ) && ! empty( $billing_postcode ) && null !== $billing_postcode ) {
									$b_postcode = $billing_postcode;
								} elseif ( isset( $checkout_session_data['billing_postcode'] ) && ! empty( $checkout_session_data['billing_postcode'] ) ) {
									$b_postcode = $checkout_session_data['billing_postcode'];
								}

								$billing_city = WC()->cart->get_customer()->get_billing_city();
								if ( isset( $billing_city ) && ! empty( $billing_city ) && null !== $billing_city ) {
									$b_city = $billing_city;
								} elseif ( isset( $checkout_session_data['billing_city'] ) && ! empty( $checkout_session_data['billing_city'] ) ) {
									$b_city = $checkout_session_data['billing_city'];
								}

								$billing_address = WC()->cart->get_customer()->get_billing_address();
								if ( isset( $billing_address ) && ! empty( $billing_address ) && null !== $billing_address ) {
									$b_address = $billing_address;
								} elseif ( isset( $checkout_session_data['billing_address'] ) && ! empty( $checkout_session_data['billing_address'] ) ) {
									$b_address = $checkout_session_data['billing_address'];
								}

								$billing_address_2 = WC()->cart->get_customer()->get_billing_address_2();
								if ( isset( $billing_address_2 ) && ! empty( $billing_address_2 ) && null !== $billing_address_2 ) {
									$b_address_2 = $billing_address_2;
								} elseif ( isset( $checkout_session_data['billing_address_2'] ) && ! empty( $checkout_session_data['billing_address_2'] ) ) {
									$b_address_2 = $checkout_session_data['billing_address_2'];
								}

								$billing_fname = ( isset( $b_first_name ) ) ? $b_first_name : '';
								$billing_lname = ( isset( $b_last_name ) ) ? $b_last_name : '';

								$billing_address_data = array(
									'name'         => $billing_fname . ' ' . $billing_lname,
									'company'      => ( isset( $b_company ) ) ? $b_company : '',
									'addressLine1' => ( isset( $b_address ) ) ? $b_address : '',
									'addressLine2' => ( isset( $b_address_2 ) ) ? $b_address_2 : '',
									'city'         => ( isset( $b_city ) ) ? $b_city : '',
									'state'        => ( isset( $b_state ) ) ? $b_state : '',
									'zip'          => ( isset( $b_postcode ) ) ? $b_postcode : '',
									'country'      => ( isset( $b_country ) ) ? $b_country : '',
									'phone'        => ( isset( $b_phone ) ) ? $b_phone : '',
									'email'        => ( isset( $b_email ) ) ? $b_email : '',
								);
								/* SETTING UP THE BILLING ADDRESS DATA [END] */
								if ( isset( $checkout_session_data['ship_to_different_address'] ) && ! empty( $checkout_session_data['ship_to_different_address'] ) && '1' === $checkout_session_data['ship_to_different_address'] ) {

									/* SETTING UP THE SHIPPING ADDRESS DATA [START] */
									$shipping_first_name = WC()->cart->get_customer()->get_shipping_first_name();
									if ( isset( $shipping_first_name ) && ! empty( $shipping_first_name ) && null !== $shipping_first_name ) {
										$sh_first_name = $shipping_first_name;
									} elseif ( isset( $checkout_session_data['shipping_first_name'] ) && ! empty( $checkout_session_data['shipping_first_name'] ) ) {
										$sh_first_name = $checkout_session_data['shipping_first_name'];
									}

									$shipping_last_name = WC()->cart->get_customer()->get_shipping_last_name();
									if ( isset( $shipping_last_name ) && ! empty( $shipping_last_name ) && null !== $shipping_last_name ) {
										$sh_last_name = $shipping_last_name;
									} elseif ( isset( $checkout_session_data['shipping_last_name'] ) && ! empty( $checkout_session_data['shipping_last_name'] ) ) {
										$sh_last_name = $checkout_session_data['shipping_last_name'];
									}

									$shipping_company = WC()->cart->get_customer()->get_shipping_company();
									if ( isset( $shipping_company ) && ! empty( $shipping_company ) && null !== $shipping_company ) {
										$sh_company = $shipping_company;
									} elseif ( isset( $checkout_session_data['shipping_company'] ) && ! empty( $checkout_session_data['shipping_company'] ) ) {
										$sh_company = $checkout_session_data['shipping_company'];
									}

									$shipping_country = WC()->cart->get_customer()->get_shipping_country();
									if ( isset( $shipping_country ) && ! empty( $shipping_country ) && null !== $shipping_country ) {
										$sh_country = $shipping_country;
									} elseif ( isset( $checkout_session_data['shipping_country'] ) && ! empty( $checkout_session_data['shipping_country'] ) ) {
										$sh_country = $checkout_session_data['shipping_country'];
									}

									$shipping_state = WC()->cart->get_customer()->get_shipping_state();
									if ( isset( $shipping_state ) && ! empty( $shipping_state ) && null !== $shipping_state ) {
										$sh_state = $shipping_state;
									} elseif ( isset( $checkout_session_data['shipping_state'] ) && ! empty( $checkout_session_data['shipping_state'] ) ) {
										$sh_state = $checkout_session_data['shipping_state'];
									}

									$shipping_postcode = WC()->cart->get_customer()->get_shipping_postcode();
									if ( isset( $shipping_postcode ) && ! empty( $shipping_postcode ) && null !== $shipping_postcode ) {
										$sh_postcode = $shipping_postcode;
									} elseif ( isset( $checkout_session_data['shipping_postcode'] ) && ! empty( $checkout_session_data['shipping_postcode'] ) ) {
										$sh_postcode = $checkout_session_data['shipping_postcode'];
									}

									$shipping_city = WC()->cart->get_customer()->get_shipping_city();
									if ( isset( $shipping_city ) && ! empty( $shipping_city ) && null !== $shipping_city ) {
										$sh_city = $shipping_city;
									} elseif ( isset( $checkout_session_data['shipping_city'] ) && ! empty( $checkout_session_data['shipping_city'] ) ) {
										$sh_city = $checkout_session_data['shipping_city'];
									}

									$shipping_address = WC()->cart->get_customer()->get_shipping_address();
									if ( isset( $shipping_address ) && ! empty( $shipping_address ) && null !== $shipping_address ) {
										$sh_address = $shipping_address;
									} elseif ( isset( $checkout_session_data['shipping_address'] ) && ! empty( $checkout_session_data['shipping_address'] ) ) {
										$sh_address = $checkout_session_data['shipping_address'];
									}

									$shipping_address_2 = WC()->cart->get_customer()->get_shipping_address_2();
									if ( isset( $shipping_address_2 ) && ! empty( $shipping_address_2 ) && null !== $shipping_address_2 ) {
										$sh_address_2 = $shipping_address_2;
									} elseif ( isset( $checkout_session_data['shipping_address_2'] ) && ! empty( $checkout_session_data['shipping_address_2'] ) ) {
										$sh_address_2 = $checkout_session_data['shipping_address_2'];
									}

									$shipping_fname = ( isset( $sh_first_name ) ) ? $sh_first_name : '';
									$shipping_lname = ( isset( $sh_last_name ) ) ? $sh_last_name : '';

									$shipping_address_data = array(
										'name'         => $shipping_fname . ' ' . $shipping_lname,
										'company'      => ( isset( $sh_company ) ) ? $sh_company : '',
										'addressLine1' => ( isset( $sh_address ) ) ? $sh_address : '',
										'addressLine2' => ( isset( $sh_address_2 ) ) ? $sh_address_2 : '',
										'city'         => ( isset( $sh_city ) ) ? $sh_city : '',
										'state'        => ( isset( $sh_state ) ) ? $sh_state : '',
										'zip'          => ( isset( $sh_postcode ) ) ? $sh_postcode : '',
										'country'      => ( isset( $sh_country ) ) ? $sh_country : '',
										'phone'        => ( isset( $b_phone ) ) ? $b_phone : '',
										'email'        => ( isset( $b_email ) ) ? $b_email : '',
									);
								} else {
									$shipping_address_data = array(
										'name'         => $billing_fname . ' ' . $billing_lname,
										'company'      => ( isset( $b_company ) ) ? $b_company : '',
										'addressLine1' => ( isset( $b_address ) ) ? $b_address : '',
										'addressLine2' => ( isset( $b_address_2 ) ) ? $b_address_2 : '',
										'city'         => ( isset( $b_city ) ) ? $b_city : '',
										'state'        => ( isset( $b_state ) ) ? $b_state : '',
										'zip'          => ( isset( $b_postcode ) ) ? $b_postcode : '',
										'country'      => ( isset( $b_country ) ) ? $b_country : '',
										'phone'        => ( isset( $b_phone ) ) ? $b_phone : '',
										'email'        => ( isset( $b_email ) ) ? $b_email : '',
									);
								}

								/* SETTING UP THE SHIPPING ADDRESS DATA [START] */

								$otherdata = array(
									'weight_unit'    => $weight_unit,
									'dimension_unit' => $dimension_unit,
									'currency'       => $currency,
								);

								/*
								CHECK DATA FOR API.
								echo '<pre>';
								print_r( $billing_address_data );
								print_r( $shipping_address_data );
								print_r( $origin_address_data );
								print_r( $otherdata );
								echo '</pre>';
								exit;
								*/

								if ( ! empty( $billing_fname ) && ! empty( $b_country ) && ! empty( $b_postcode ) ) {
									$itembase             = new Itembase_Api();
									$token                = $itembase->create_auth_jwt_token( $ib_api_key, $ib_api_secret );
									$shippingcharge_data  = $itembase->tadquotes( $ib_connection_id, $token, $product_data, $shipping_address_data, $billing_address_data, $origin_address_data, $otherdata );
									$shippingchargeresult = json_decode( $shippingcharge_data );

									/*
									CHECK RESPONSE
									echo '<pre>';
									print_r( $shippingchargeresult );
									echo '</pre>';
									exit;
									*/

									if ( isset( $shippingchargeresult->result->serviceLevels[0]->shippingCharge ) ) {
										$ups_shipping_cost = $shippingchargeresult->result->serviceLevels[0]->shippingCharge;
									}

									if ( isset( $shippingchargeresult->result->serviceLevels[0]->invalidItems ) ) {
										$invalid_items = $shippingchargeresult->result->serviceLevels[0]->invalidItems;
									}

									if ( isset( $shippingchargeresult->result->serviceLevels[0]->tax ) ) {
										$ups_tax_cost = $shippingchargeresult->result->serviceLevels[0]->tax;
									} else {
										$ups_tax_cost = '';
									}
									if ( isset( $shippingchargeresult->result->serviceLevels[0]->duty ) ) {
										$ups_tax_duty = $shippingchargeresult->result->serviceLevels[0]->duty;
									} else {
										$ups_tax_duty = '';
									}
									if ( isset( $shippingchargeresult->result->serviceLevels[0]->handling ) ) {
										$ups_tax_handling = $shippingchargeresult->result->serviceLevels[0]->handling;
									} else {
										$ups_tax_handling = '';
									}
									$found = false;
									if ( isset( $ups_shipping_cost ) && empty( $invalid_items ) ) {

										$new_shippping_cost = $ups_shipping_cost;
										$new_shippping_cost = (float) $new_shippping_cost;

										if ( isset( $ups_tax_cost ) ) {
											$new_shipping_tax = $ups_tax_cost;
											WC()->session->set( 'ups_shipping_tax', $new_shipping_tax );
										}
										if ( isset( $ups_tax_duty ) ) {
											$new_shipping_duty = $ups_tax_duty;
											WC()->session->set( 'ups_shipping_duty', $new_shipping_duty );
										}
										if ( isset( $ups_tax_handling ) ) {
											$new_shipping_handling = $ups_tax_handling;
											WC()->session->set( 'ups_shipping_handling', $new_shipping_handling );
										}
										foreach ( $rates as $rate_key => $rate ) {
											if ( 'ups-shipping-method' === $rate->method_id ) {
												// Set rate cost.
												$rates[ $rate_key ]->cost = $new_shippping_cost;
											}
										}
									} else {
										$found = true;
										if ( true === $found ) {
											foreach ( $rates as $rate_id => $rate_val ) {
												if ( 'ups-shipping-method' === $rate_val->get_method_id() ) {
													unset( $rates[ $rate_id ] );
												}
											}
										}
									}
								} else {
									foreach ( $rates as $rate_id => $rate_val ) {
										if ( 'ups-shipping-method' === $rate_val->get_method_id() ) {
											unset( $rates[ $rate_id ] );
										}
									}
								}
							}
						} else {
							foreach ( $rates as $rate_id => $rate_val ) {
								if ( 'ups-shipping-method' === $rate_val->get_method_id() ) {
									unset( $rates[ $rate_id ] );
								}
							}
						}
					} else {
						foreach ( $rates as $rate_id => $rate_val ) {
							if ( 'ups-shipping-method' === $rate_val->get_method_id() ) {
								unset( $rates[ $rate_id ] );
							}
						}
					}
				}
			} else {
				foreach ( $rates as $rate_id => $rate_val ) {
					if ( 'ups-shipping-method' === $rate_val->get_method_id() ) {
						unset( $rates[ $rate_id ] );
					}
				}
			}
		}

		return $rates;
	}


	/**
	 * Get all shipping zones woocommerce.
	 */
	public function ups_get_all_shipping_zones() {
		$data_store = WC_Data_Store::load( 'shipping-zone' );
		$raw_zones  = $data_store->get_zones();
		foreach ( $raw_zones as $raw_zone ) {
			$zones[] = new WC_Shipping_Zone( $raw_zone );
		}
		// $zones[] = new WC_Shipping_Zone( 0 ); // ADD ZONE "0" MANUALLY.
		return $zones;
	}

	/**
	 * Get products count based on classification status .
	 */
	public function ups_get_products_count() {
		$product_args                = array(
			'status' => 'publish',
			'limit'  => -1,
		);
		$all_products                = wc_get_products( $product_args );
		$classification_status_count = array();
		$classified_count            = 0;
		$new_count                   = 0;
		$in_progess_count            = 0;
		$not_supoorted_count         = 0;
		foreach ( $all_products as $product ) {
			$product_id = esc_attr( $product->get_id() );
			if ( $product->get_type() === 'variable' ) {
				$variable_product  = new WC_Product_Variable( $product->get_id() );
				$variations        = $variable_product->get_available_variations();
				$variations_status = array();
				foreach ( $variations as $variation ) {
					$varation_id = $variation['variation_id'];
					if ( get_post_meta( $varation_id, 'classification_status', true ) ) {
						$variation_classification_status = get_post_meta( $varation_id, 'classification_status', true );
						$variations_status[]             = $variation_classification_status;
					} else {
						$variations_status[] = '';
					}
				}
				if ( count( array_unique( $variations_status ) ) === 1 && 'Classified' === array_unique( $variations_status )[0] ) {
					$classification_status = 'Classified';
					if ( 'Classified' === $classification_status ) {
						++$classified_count;
						$classification_status_count['Classified'] = $classified_count;
					}
				} else {
					$classification_status = 'New';
					if ( 'New' === $classification_status ) {
						++$new_count;
						$classification_status_count['New'] = $new_count;
					}
				}
			} elseif ( $product->get_type() === 'simple' ) {
				$is_virtual_downloadable_item = $product->is_downloadable() && $product->is_virtual();
				if ( isset( $is_virtual_downloadable_item ) && ! $is_virtual_downloadable_item ) {
					$classification_status = get_post_meta( $product_id, 'classification_status', true );
					if ( 'Classified' === $classification_status ) {
						++$classified_count;
						$classification_status_count['Classified'] = $classified_count;
					}
					if ( 'New' === $classification_status ) {
						++$new_count;
						$classification_status_count['New'] = $new_count;
					}
				} else {
					$classification_status = 'Not Supported';
					if ( 'Not Supported' === $classification_status ) {
						++$not_supoorted_count;
						$classification_status_count['Not Supported'] = $not_supoorted_count;
					}
				}
			} elseif ( $product->get_type() === 'grouped' ) {
				$children_products = $product->get_children();
				$variations_status = array();
				foreach ( $children_products as $children_product ) {
					$product_id = $children_product;
					$product    = wc_get_product( $product_id );
					if ( $product->get_type() === 'variable' ) {
						$variable_product = new WC_Product_Variable( $product->get_id() );
						$variations       = $variable_product->get_available_variations();
						foreach ( $variations as $variation ) {
							$varation_id = $variation['variation_id'];
							if ( get_post_meta( $varation_id, 'classification_status', true ) ) {
								$variation_classification_status = get_post_meta( $varation_id, 'classification_status', true );
								$variations_status[]             = $variation_classification_status;
							} else {
								$variations_status[] = '';
							}
						}
					} elseif ( $product->get_type() === 'simple' ) {
						$is_virtual_downloadable_item = $product->is_downloadable() && $product->is_virtual();
						if ( isset( $is_virtual_downloadable_item ) && ! $is_virtual_downloadable_item ) {
							if ( get_post_meta( $product_id, 'classification_status', true ) ) {
								$simple_classification_status = get_post_meta( $product_id, 'classification_status', true );
								$variations_status[]          = $simple_classification_status;
							} else {
								$variations_status[] = '';
							}
						} else {
							$variations_status[] = 'Not Supported';
						}
					}
				}
				if ( count( array_unique( $variations_status ) ) === 1 && 'Classified' === array_unique( $variations_status )[0] ) {
					$classification_status = 'Classified';
					if ( 'Classified' === $classification_status ) {
						++$classified_count;
						$classification_status_count['Classified'] = $classified_count;
					}
				} else {
					$classification_status = 'New';
					if ( 'New' === $classification_status ) {
						++$new_count;
						$classification_status_count['New'] = $new_count;
					}
				}
			} elseif ( $product->get_type() === 'external' ) {
				$classification_status = 'Not Supported';
				if ( 'Not Supported' === $classification_status ) {
					++$not_supoorted_count;
					$classification_status_count['Not Supported'] = $not_supoorted_count;
				}
			}
		}
		return $classification_status_count;
	}

	/**
	 * Check array objects hase property exists.
	 *
	 * @param array $objects Pass array for checking.
	 * @param mixed $property Pass value for property key.
	 * @param mixed $value Pass value for property value.
	 * @return boolean
	 */
	public function has_property_value( array $objects, $property, $value ): bool {
		foreach ( $objects as $object ) {
			if ( property_exists( $object, $property ) && $object->{$property} === $value ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Note for shipping method.
	 */
	public function ups_shipping_details() {
		if ( ! empty( WC()->session->get( 'chosen_shipping_methods' ) ) ) {
			$chosen_shipping_methods     = WC()->session->get( 'chosen_shipping_methods' )[0];
			$chosen_method_id            = explode( ':', $chosen_shipping_methods );
			$chosen_method_id            = reset( $chosen_method_id );
			$shipping_method_tax         = WC()->session->get( 'ups_shipping_tax' );
			$shipping_method_duty        = WC()->session->get( 'ups_shipping_duty' );
			$shipping_method_handing_fee = WC()->session->get( 'ups_shipping_handling' );

			if ( str_contains( $chosen_method_id, 'ups-shipping-method' ) ) {
				$tax         = ( isset( $shipping_method_tax ) ) ? $shipping_method_tax : 0;
				$duty        = ( isset( $shipping_method_duty ) ) ? $shipping_method_duty : 0;
				$handing_fee = ( isset( $shipping_method_handing_fee ) ) ? $shipping_method_handing_fee : 0;

				/*
				print_r( $tax );
				print_r( $duty );
				print_r( $handing_fee );
				exit;
				*/

				if ( is_plugin_active( 'custom-checkout-layouts-for-woocommerce/woocommerce-one-page-checkout-and-layouts.php' ) || is_plugin_active( 'joy-checkout-more-beautiful-checkout-for-woocommerce/joy-checkout.php' ) ) {
					$html = '<div class="delivery-message"><p class="left-corner"></p><span class="right-corner">';
					/* translators: %s: Tax charge from checkout */
					$html .= sprintf( __( '<strong>Tax - %s</strong><br />', 'ups-woocommerce-add-on1' ), $tax );
					/* translators: %s: Duty charge from checkout */
					$html .= sprintf( __( '<strong>Duties - %s</strong><br />', 'ups-woocommerce-add-on1' ), $duty );
					/* translators: %s: Handling Fee charge from checkout */
					$html .= sprintf( __( '<strong>Handling Fee - %s</strong><br />', 'ups-woocommerce-add-on1' ), $handing_fee );
					echo $html . '</span></div>';
				} else {
					$html = '<tr class="delivery-message"><th></th><td><div class="outside-delivery checkout">';
					/* translators: %s: Tax charge from checkout */
					$html .= sprintf( __( '<strong>Tax - %s</strong><br />', 'ups-woocommerce-add-on1' ), $tax );
					/* translators: %s: Duty charge from checkout */
					$html .= sprintf( __( '<strong>Duties - %s</strong><br />', 'ups-woocommerce-add-on1' ), $duty );
					/* translators: %s: Handling Fee charge from checkout */
					$html .= sprintf( __( '<strong>Handling Fee - %s</strong><br />', 'ups-woocommerce-add-on1' ), $handing_fee );
					echo $html . '</div></td></tr>';
				}
			}
		}
	}


	/**
	 * Get shipping method lable and name.
	 *
	 * @param [string] $label Lable of the method.
	 * @param [string] $method Method Name.
	 * @return string
	 */
	public function ups_add_0_to_shipping_label( $label, $method ) {
		if ( ! ( $method->cost > 0 ) ) {
			$label .= ': ' . wc_price( 0 );
		}
		return $label;
	}

	/**
	 * Get the shipping method and data and return 0 price in order
	 *
	 * @param [array] $shipping Get shipping data.
	 * @param [array] $order Get order data.
	 * @param [array] $tax_display Get tax information.
	 * @return mixed
	 */
	public function ups_add_0_to_shipping_label_ordered( $shipping, $order, $tax_display ) {
		if ( ! ( 0 < abs( (float) $order->get_shipping_total() ) ) && $order->get_shipping_method() ) {
			$shipping .= ': ' . wc_price( 0 );
		}
		return $shipping;
	}
}
