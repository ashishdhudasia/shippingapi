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
class Ups_Shipping_Method extends WC_Shipping_Method {

	/**
	 * Shipping class
	 *
	 * @param mixed $instance_id Instance from woo shipping.
	 */
	public function __construct( $instance_id = 0 ) {

		// These title description are display on the configuration page.
		$this->id                 = 'ups-shipping-method';
		$this->instance_id        = absint( $instance_id );
		$this->method_title       = __( 'Ups Shipping', 'ups-woocommerce' );
		$this->method_description = __( 'Ups WooCommerce Shipping', 'ups-woocommerce' );

		$this->supports = array(
			'shipping-zones',
			'instance-settings',
		);

		$this->init();

		$this->enabled = $this->get_option( 'enabled' );
		$this->title   = $this->get_option( 'title' );

		add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
		add_filter( 'woocommerce_shipping_method_add_rate_args', array( $this, 'ups_create_description_as_meta' ), 10, 2 );
		add_action( 'woocommerce_after_shipping_rate', array( $this, 'ups_output_shipping_method_tooltips' ), 10 );

		// Run the initial method.
	}

	/**
	 * * Load the settings API
	 */
	public function init() {

		// Add the form fields.
		$this->init_form_fields();
	}

	/**
	 *  Load the form fields
	 */
	public function init_form_fields() {

		$form_fields = array(
			'enabled'     => array(
				'title'   => __( 'Enable/Disable', 'ups-woocommerce-add-on1' ),
				'type'    => 'checkbox',
				'label'   => __( 'Enable this shipping method', 'ups-woocommerce-add-on1' ),
				'default' => 'yes',
			),
			'title'       => array(
				'title'       => __( 'Method Title', 'ups-woocommerce-add-on1' ),
				'type'        => 'text',
				'description' => __( 'This controls the title which the user sees during checkout.', 'ups-woocommerce-add-on1' ),
				'default'     => __( 'UPS® Global Checkout', 'ups-woocommerce-add-on1' ),
				'desc_tip'    => true,
			),
			'description' => array(
				'title'   => __( 'Description', 'ups-woocommerce-add-on1' ),
				'type'    => 'textarea',
				'default' => __( 'No surprises.This charge includes Tax & Duties & Handling Fee.', 'ups-woocommerce-add-on1' ),
			),
		);

		$this->instance_form_fields = $form_fields;
	}

	/**
	 * * Calculate Shipping rate
	 *
	 * @param array $package Get shipping packages.
	 */
	public function calculate_shipping( $package = array() ) {
		$this->add_rate(
			array(
				'id'    => $this->id . $this->instance_id,
				'label' => $this->title,
				'cost'  => 1,
			)
		);
	}

	/**
	 * Adding tooltip to shipping method
	 *
	 * @param object $method Get shipping method.
	 */
	public function ups_output_shipping_method_tooltips( $method ) {
		$meta_data = $method->get_meta_data();
		if ( array_key_exists( 'description', $meta_data ) ) {
			$description = apply_filters( 'ups_description_output', html_entity_decode( $meta_data['description'] ), $method );
			if ( $description ) {
				$html = '<div class="cus-tooltip"><span class="dashicons dashicons-info"></span><span class="cus-tooltiptext">' . wp_kses( $description, wp_kses_allowed_html( 'post' ) ) . '</span></div>';
				echo apply_filters( 'ups_description_output_html', $html, $description, $method );
			}
		}
	}

	/**
	 * * Calculate Shipping rate
	 *
	 * @param array  $args Get exsting argument value.
	 * @param object $method Get shipping method.
	 */
	public function ups_create_description_as_meta( $args, $method ) {
		$args['meta_data']['description'] = htmlentities( $method->get_option( 'description' ) );
		return $args;
	}
}
