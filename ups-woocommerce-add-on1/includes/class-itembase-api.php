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
 * This is used to define itembase APIS.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Ups_Woocommerce_Add_On1
 * @subpackage Ups_Woocommerce_Add_On1/includes
 * @author     UPS Wocommerce <info@upswoocommerce.com>
 */
class Itembase_Api {

	/**
	 * Method write_log
	 *
	 * @param $content $content This is load content.
	 * @param $file    $file This is a file path.
	 *
	 * @return void
	 */
	public function write_log( $content, $file = 'logs/api_response.log' ) {
		$write_to_log = UPSWOOCOMMERCE_ADDON1_PLUGIN_DIR . $file;
		file_put_contents( $write_to_log, $content . PHP_EOL, FILE_APPEND | LOCK_EX );
	}

	/**
	 * Method api_log_count
	 *
	 * @param $file  $file This is file path.
	 * @param $count $count This is limit to store logs.
	 *
	 * @return void
	 */
	public function api_log_count( $file = 'logs/api_response.log', $count = 100 ) {
		if ( get_option( 'itembase_api_log_count' ) ) {
			$log_count = get_option( 'itembase_api_log_count' );
			if ( $log_count !== $count ) {
				++$log_count;
				update_option( 'itembase_api_log_count', $log_count );
			} else {
				$write_to_log = UPSWOOCOMMERCE_ADDON1_PLUGIN_DIR . $file;
				file_put_contents( $write_to_log, '' );
				update_option( 'itembase_api_log_count', 1 );
			}
		} else {
			add_option( 'itembase_api_log_count', 1 );
		}
	}

	/**
	 * Method generate UUID 4 secret
	 *
	 * @return string
	 */
	public function generate_api_secret() {
		return sprintf(
			'%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			mt_rand( 0, 0xffff ),
			mt_rand( 0, 0xffff ),
			mt_rand( 0, 0xffff ),
			mt_rand( 0, 0x0fff ) | 0x4000,
			mt_rand( 0, 0x3fff ) | 0x8000,
			mt_rand( 0, 0xffff ),
			mt_rand( 0, 0xffff ),
			mt_rand( 0, 0xffff )
		);
	}


	/**
	 * Create JWT token for update connection data.
	 *
	 * @param string $api_key API Key for create token.
	 * @param string $api_secret API Secret for create token.
	 *
	 * @return string
	 */
	public function create_auth_jwt_token( $api_key, $api_secret ) {

		$payload = array(
			'iss' => $api_key,
			'iat' => strtotime( 'now' ),
			'exp' => strtotime( '+4 minutes' ),
			'aud' => 'itembase',
			'sub' => '',
		);
		$token   = Firebase\JWT\JWT::encode( $payload, $api_secret, 'HS256' );
		return ( ! empty( $token ) ) ? $token : '';
	}

	/**
	 * Method create_new_connection
	 *
	 * @since 1.0.0
	 * @param string $username Account username.
	 * @param string $password Account Password.
	 * @param string $account_number Acccount Number.
	 * @param string $ib_api_key Itembase API key.
	 * @param string $ib_api_secret Iteambase API secret.
	 *
	 * @return mixed
	 */
	public function create_itembase_connection( $username, $password, $account_number, $ib_api_key, $ib_api_secret ) {

		$body        = new \Swagger\Client\Model\ShippingLabelAccessCredentials();
		$config      = Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken( '' );
		$instance_id = ITEMBASE_CONNECT_INSTANCE_ID;
		$test_mode   = false;

		$body->setUserName( $username );
		$body->setPassword( $password );
		$body->setAccountNumber( $account_number );
		$body->setApiKey( $ib_api_key );
		$body->setApiSecret( $ib_api_secret );

		$api_instance = new Swagger\Client\Api\AuthenticationApi(
			new GuzzleHttp\Client(),
			$config
		);

		try {
			$result             = $api_instance->create( $body, $instance_id, $test_mode );
			$auth_connection_id = $result['connection_id'];
			return wp_json_encode(
				array(
					'success' => true,
					'result'  => $auth_connection_id,
					'message' => 'Connection ID generated successfully',
				)
			);
		} catch ( Exception $e ) {
			return wp_json_encode(
				array(
					'error'   => true,
					'result'  => $e->getMessage(),
					'message' => 'Error when request for AuthenticationApi->create',
				)
			);
		}
	}

	/**
	 * Method delete_connection
	 *
	 * @since 1.0.0
	 * @param string $connection_id Connected Account ID.
	 * @param string $token JWT token for authentication.
	 *
	 * @return mixed
	 */
	public function delete_itembase_connection( $connection_id, $token ) {

		$instance_id = ITEMBASE_CONNECT_INSTANCE_ID;
		$config      = Swagger\Client\Configuration::getDefaultConfiguration()
		->setAccessToken( $token );

		$api_instance = new Swagger\Client\Api\AuthenticationApi(
			new GuzzleHttp\Client(),
			$config
		);

		try {
			$result = $api_instance->remove( $instance_id, $connection_id );
			return wp_json_encode(
				array(
					'success' => true,
					'result'  => $result,
					'message' => 'Disconnected Successfully',
				)
			);
		} catch ( Exception $e ) {
			return wp_json_encode(
				array(
					'error'   => true,
					'result'  => $e->getMessage(),
					'message' => 'Error when request for AuthenticationApi->remove',
				)
			);
		}
	}

	/**
	 * Method check product clssification status
	 *
	 * @since 1.0.0
	 * @param string $connection_id Connected Account ID.
	 * @param string $token JWT token for authentication.
	 * @param array  $product_skus Product skus array.
	 *
	 * @return mixed
	 */
	public function check_product_classification_status( $connection_id, $token, $product_skus ) {

		$body        = new \Swagger\Client\Model\HsCodesClassificationStatusRequest();
		$test_mode   = false;
		$instance_id = ITEMBASE_CONNECT_INSTANCE_ID;
		$config      = Swagger\Client\Configuration::getDefaultConfiguration()
		->setAccessToken( $token );

		$api_instance = new Swagger\Client\Api\HarmonizedSystemCodesApi(
			new GuzzleHttp\Client(),
			$config
		);

		$body->setSkus(
			$product_skus,
		);

		try {
			$result = $api_instance->isClassified( $body, $instance_id, $connection_id, $test_mode );
			$skus   = json_decode( $result );
			return wp_json_encode(
				array(
					'success' => true,
					'result'  => $skus,
					'message' => 'Get status successfully',
				)
			);
		} catch ( Exception $e ) {
			return wp_json_encode(
				array(
					'error'   => true,
					'result'  => $e->getMessage(),
					'message' => 'Error when request for HarmonizedSystemCodesApi->isClassified',
				)
			);
		}
	}

	/**
	 * Method check product clssification status
	 *
	 * @since 1.0.0
	 * @param string $connection_id Connected Account ID.
	 * @param string $token JWT token for authentication.
	 * @param array  $productdata Product data array.
	 * @param array  $shippingdata Product data array.
	 * @param array  $billingdata Product data array.
	 * @param array  $orgindata Product data array.
	 * @param array  $otherdata Product data array.
	 *
	 * @return mixed
	 */
	public function tadquotes( $connection_id, $token, $productdata, $shippingdata, $billingdata, $orgindata, $otherdata ) {
		/*
		DATA CHECK.
		echo '<pre>';
		print_r( $shippingdata );
		print_r( $orgindata );
		print_r( $billingdata );
		echo '</pre>';

		exit;
		*/

		$test_mode   = false;
		$instance_id = ITEMBASE_CONNECT_INSTANCE_ID;
		$config      = Swagger\Client\Configuration::getDefaultConfiguration()
		->setAccessToken( $token );

		$api_instance = new Swagger\Client\Api\TaxAndDutiesApi(
			new GuzzleHttp\Client(),
			$config
		);

		$body = new \Swagger\Client\Model\QuoteRequest();
		$body->setItemDetailsList(
			$productdata,
		);

		$address_info = new Swagger\Client\Model\AddressInfo();
		$consinee     = new \Swagger\Client\Model\ConsigneeAddress();
		$origin       = new Swagger\Client\Model\ConsignorAddress();

		/* SETTING UP THE SHIPPING ADDRESS DATA [START] */
		$sh_name = $shippingdata['name'];
		if ( isset( $sh_name ) && ! empty( $sh_name ) && null !== $sh_name ) {
			$body->setAddressInfo( $address_info->setShippingAddress( $consinee->setname( $sh_name ) ) );
		} else {
			$body->setAddressInfo( $address_info->setShippingAddress( $consinee->setname( null ) ) );
		}

		$sh_company = $shippingdata['company'];
		if ( isset( $sh_company ) && ! empty( $sh_company ) && null !== $sh_company ) {
			$body->setAddressInfo( $address_info->setShippingAddress( $consinee->setCompany( $sh_company ) ) );
		} else {
			$body->setAddressInfo( $address_info->setShippingAddress( $consinee->setCompany( null ) ) );
		}

		$sh_address_line1 = $shippingdata['addressLine1'];
		if ( isset( $sh_address_line1 ) && ! empty( $sh_address_line1 ) && null !== $sh_address_line1 ) {
			$body->setAddressInfo( $address_info->setShippingAddress( $consinee->setAddressLine1( $sh_address_line1 ) ) );
		} else {
			$body->setAddressInfo( $address_info->setShippingAddress( $consinee->setAddressLine1( null ) ) );
		}

		$sh_address_line2 = $shippingdata['addressLine2'];
		if ( isset( $sh_address_line2 ) && ! empty( $sh_address_line2 ) && null !== $sh_address_line2 ) {
			$body->setAddressInfo( $address_info->setShippingAddress( $consinee->setAddressLine2( $sh_address_line2 ) ) );
		} else {
			$body->setAddressInfo( $address_info->setShippingAddress( $consinee->setAddressLine2( null ) ) );
		}

		$sh_city = $shippingdata['city'];
		if ( isset( $sh_city ) && ! empty( $sh_city ) && null !== $sh_city ) {
			$body->setAddressInfo( $address_info->setShippingAddress( $consinee->setCity( $sh_city ) ) );
		} else {
			$body->setAddressInfo( $address_info->setShippingAddress( $consinee->setCity( null ) ) );
		}

		$sh_state = $shippingdata['state'];
		if ( isset( $sh_state ) && ! empty( $sh_state ) && null !== $sh_state ) {
			$body->setAddressInfo( $address_info->setShippingAddress( $consinee->setState( $sh_state ) ) );
		} else {
			$body->setAddressInfo( $address_info->setShippingAddress( $consinee->setState( null ) ) );

		}

		$sh_zip = $shippingdata['zip'];
		if ( isset( $sh_zip ) && ! empty( $sh_zip ) && null !== $sh_zip ) {
			$body->setAddressInfo( $address_info->setShippingAddress( $consinee->setZip( $sh_zip ) ) );
		} else {
			$body->setAddressInfo( $address_info->setShippingAddress( $consinee->setZip( null ) ) );
		}

		$sh_country = $shippingdata['country'];
		if ( isset( $sh_country ) && ! empty( $sh_country ) && null !== $sh_country ) {
			$body->setAddressInfo( $address_info->setShippingAddress( $consinee->setCountry( $sh_country ) ) );
		} else {
			$body->setAddressInfo( $address_info->setShippingAddress( $consinee->setCountry( null ) ) );
		}

		$sh_phone = $shippingdata['phone'];
		if ( isset( $sh_phone ) && ! empty( $sh_phone ) && null !== $sh_phone ) {
			$body->setAddressInfo( $address_info->setShippingAddress( $consinee->setPhone( $sh_phone ) ) );
		} else {
			$body->setAddressInfo( $address_info->setShippingAddress( $consinee->setPhone( null ) ) );
		}

		$sh_email = $shippingdata['email'];
		if ( isset( $sh_email ) && ! empty( $sh_email ) && null !== $sh_email ) {
			$body->setAddressInfo( $address_info->setShippingAddress( $consinee->setEmail( $sh_email ) ) );
		} else {
			$body->setAddressInfo( $address_info->setShippingAddress( $consinee->setEmail( null ) ) );
		}

		$body->setAddressInfo( $address_info->setShippingAddress( $consinee->setAddressLine3( null ) ) );
		$body->setAddressInfo( $address_info->setShippingAddress( $consinee->setVat( null ) ) );
		$body->setAddressInfo( $address_info->setShippingAddress( $consinee->setPudoLocationId( null ) ) );
		$body->setAddressInfo( $address_info->setShippingAddress( $consinee->setCountryIdentificator( null ) ) );
		/* SETTING UP THE SHIPPING ADDRESS DATA [END] */

		/* SETTING UP THE BILLING ADDRESS DATA [START] */
		$bl_name = $billingdata['name'];
		if ( isset( $bl_name ) && ! empty( $bl_name ) && null !== $bl_name ) {
			$body->setAddressInfo( $address_info->setBillingAddress( $consinee->setname( $bl_name ) ) );
		} else {
			$body->setAddressInfo( $address_info->setBillingAddress( $consinee->setname( null ) ) );
		}

		$bl_company = $billingdata['company'];
		if ( isset( $bl_company ) && ! empty( $bl_company ) && null !== $bl_company ) {
			$body->setAddressInfo( $address_info->setBillingAddress( $consinee->setCompany( $bl_company ) ) );
		} else {
			$body->setAddressInfo( $address_info->setBillingAddress( $consinee->setCompany( null ) ) );
		}

		$bl_address_line1 = $billingdata['addressLine1'];
		if ( isset( $bl_address_line1 ) && ! empty( $bl_address_line1 ) && null !== $bl_address_line1 ) {
			$body->setAddressInfo( $address_info->setBillingAddress( $consinee->setAddressLine1( $bl_address_line1 ) ) );
		} else {
			$body->setAddressInfo( $address_info->setBillingAddress( $consinee->setAddressLine1( null ) ) );
		}

		$bl_address_line2 = $billingdata['addressLine2'];
		if ( isset( $bl_address_line2 ) && ! empty( $bl_address_line2 ) && null !== $bl_address_line2 ) {
			$body->setAddressInfo( $address_info->setBillingAddress( $consinee->setAddressLine2( $bl_address_line2 ) ) );
		} else {
			$body->setAddressInfo( $address_info->setBillingAddress( $consinee->setAddressLine2( null ) ) );
		}

		$bl_city = $billingdata['city'];
		if ( isset( $bl_city ) && ! empty( $bl_city ) && null !== $bl_city ) {
			$body->setAddressInfo( $address_info->setBillingAddress( $consinee->setCity( $bl_city ) ) );
		} else {
			$body->setAddressInfo( $address_info->setBillingAddress( $consinee->setCity( null ) ) );
		}

		$bl_state = $billingdata['state'];
		if ( isset( $bl_state ) && ! empty( $bl_state ) && null !== $bl_state ) {
			$body->setAddressInfo( $address_info->setBillingAddress( $consinee->setState( $bl_state ) ) );
		} else {
			$body->setAddressInfo( $address_info->setBillingAddress( $consinee->setState( null ) ) );
		}

		$bl_zip = $billingdata['zip'];
		if ( isset( $bl_zip ) && ! empty( $bl_zip ) && null !== $bl_zip ) {
			$body->setAddressInfo( $address_info->setBillingAddress( $consinee->setZip( $bl_zip ) ) );
		} else {
			$body->setAddressInfo( $address_info->setBillingAddress( $consinee->setZip( null ) ) );
		}

		$bl_country = $billingdata['country'];
		if ( isset( $bl_country ) && ! empty( $bl_country ) && null !== $bl_country ) {
			$body->setAddressInfo( $address_info->setBillingAddress( $consinee->setCountry( $bl_country ) ) );
		} else {
			echo 'else';
			$body->setAddressInfo( $address_info->setBillingAddress( $consinee->setCountry( null ) ) );
			exit;
		}

		$bl_phone = $billingdata['phone'];
		if ( isset( $bl_phone ) && ! empty( $bl_phone ) && null !== $bl_phone ) {
			$body->setAddressInfo( $address_info->setBillingAddress( $consinee->setPhone( $bl_phone ) ) );
		} else {
			$body->setAddressInfo( $address_info->setBillingAddress( $consinee->setPhone( null ) ) );
		}

		$bl_email = $billingdata['email'];
		if ( isset( $bl_email ) && ! empty( $bl_email ) && null !== $bl_email ) {
			$body->setAddressInfo( $address_info->setBillingAddress( $consinee->setEmail( $bl_email ) ) );
		} else {
			$body->setAddressInfo( $address_info->setBillingAddress( $consinee->setEmail( null ) ) );
		}

		$body->setAddressInfo( $address_info->setBillingAddress( $consinee->setAddressLine3( null ) ) );
		$body->setAddressInfo( $address_info->setBillingAddress( $consinee->setVat( null ) ) );
		$body->setAddressInfo( $address_info->setBillingAddress( $consinee->setPudoLocationId( null ) ) );
		$body->setAddressInfo( $address_info->setBillingAddress( $consinee->setCountryIdentificator( null ) ) );
		/* SETTING UP THE BILLING ADDRESS DATA [END] */

		/* SETTING UP THE ORIGIN ADDRESS DATA [START] */
		$or_address_line1 = $orgindata['addressLine1'];
		if ( isset( $or_address_line1 ) && ! empty( $or_address_line1 ) && null !== $or_address_line1 ) {
			$body->setAddressInfo( $address_info->setOriginAddress( $origin->setAddressLine1( $or_address_line1 ) ) );
		} else {
			$body->setAddressInfo( $address_info->setOriginAddress( $origin->setAddressLine1( null ) ) );
		}

		$or_address_line2 = $orgindata['addressLine2'];
		if ( isset( $or_address_line2 ) && ! empty( $or_address_line2 ) && null !== $or_address_line2 ) {
			$body->setAddressInfo( $address_info->setOriginAddress( $origin->setAddressLine2( $or_address_line2 ) ) );
		} else {
			$body->setAddressInfo( $address_info->setOriginAddress( $origin->setAddressLine2( null ) ) );
		}

		$or_city = $orgindata['city'];
		if ( isset( $or_city ) && ! empty( $or_city ) && null !== $or_city ) {
			$body->setAddressInfo( $address_info->setOriginAddress( $origin->setCity( $or_city ) ) );
		} else {
			$body->setAddressInfo( $address_info->setOriginAddress( $origin->setCity( null ) ) );
		}

		$or_state = $orgindata['state'];
		if ( isset( $or_state ) && ! empty( $or_state ) && null !== $or_state ) {
			$body->setAddressInfo( $address_info->setOriginAddress( $origin->setState( $or_state ) ) );
		} else {
			$body->setAddressInfo( $address_info->setOriginAddress( $origin->setState( null ) ) );
		}

		$or_zip = $orgindata['zip'];
		if ( isset( $or_zip ) && ! empty( $or_zip ) && null !== $or_zip ) {
			$body->setAddressInfo( $address_info->setOriginAddress( $origin->setZip( $or_zip ) ) );
		} else {
			$body->setAddressInfo( $address_info->setOriginAddress( $origin->setZip( null ) ) );
		}

		$or_country = $orgindata['country'];
		if ( isset( $or_country ) && ! empty( $or_country ) && null !== $or_country ) {
			$body->setAddressInfo( $address_info->setOriginAddress( $origin->setCountry( $or_country ) ) );
		} else {
			$body->setAddressInfo( $address_info->setOriginAddress( $origin->setCountry( null ) ) );
		}

		$body->setAddressInfo( $address_info->setOriginAddress( $origin->setname( null ) ) );
		$body->setAddressInfo( $address_info->setOriginAddress( $origin->setCompany( null ) ) );
		$body->setAddressInfo( $address_info->setOriginAddress( $origin->setAddressLine3( null ) ) );
		$body->setAddressInfo( $address_info->setOriginAddress( $origin->setPhone( null ) ) );
		$body->setAddressInfo( $address_info->setOriginAddress( $origin->setEmail( null ) ) );
		$body->setAddressInfo( $address_info->setOriginAddress( $origin->setVat( null ) ) );
		$body->setAddressInfo( $address_info->setOriginAddress( $origin->setEori( null ) ) );
		$body->setAddressInfo( $address_info->setOriginAddress( $origin->setNlVat( null ) ) );
		$body->setAddressInfo( $address_info->setOriginAddress( $origin->setEuEori( null ) ) );
		$body->setAddressInfo( $address_info->setOriginAddress( $origin->setIoss( null ) ) );
		/* SETTING UP THE ORIGIN ADDRESS DATA [END] */

		/* SETTING UP THE OTHER REQUEST DATA [START] */
		$weight_unit_store = $otherdata['weight_unit'];
		if ( isset( $weight_unit_store ) && ! empty( $weight_unit_store ) && null !== $weight_unit_store ) {
			$body->setWeightUnit( $weight_unit_store );
		} else {
			$body->setWeightUnit( null );
		}

		$dimension_unit_store = $otherdata['dimension_unit'];
		if ( isset( $dimension_unit_store ) && ! empty( $dimension_unit_store ) && null !== $dimension_unit_store ) {
			$body->setDimUnit( $dimension_unit_store );
		} else {
			$body->setDimUnit( null );
		}

		$currency_store = $otherdata['currency'];
		if ( isset( $currency_store ) && ! empty( $currency_store ) && null !== $currency_store ) {
			$body->setShippingValueCurrency( $currency_store );
		} else {
			$body->setShippingValueCurrency( null );
		}

		$body->setCurrencyCode( null );
		$body->setCustomsDuty( 'DDP' );
		$body->setInsurance( true );
		$body->setServiceLevel( 0 );
		$body->setOrderReference( null );
		$body->setOtherDiscount( 0 );
		$body->setOtherDiscountCurrency( null );
		$body->setTrackingNumber( null );
		$body->setAlwaysQuote( false );
		$body->setVat( null );
		$body->setPromoCode( null );
		$body->setWeight( 0 );
		$body->setLength( 0 );
		$body->setWidth( 0 );
		$body->setHeight( 0 );
		$body->setShippingValue( 0 );
		$body->setTrackByEmail( false );
		/* SETTING UP THE OTHER REQUEST DATA [end] */

		/*
		echo '<pre>';
		print_r( $body );
		echo '</pre>';
		exit;
		*/

		try {
			$result = $api_instance->getQuotes( $body, $instance_id, $connection_id, $test_mode );
			$data   = json_decode( $result );
			return wp_json_encode(
				array(
					'success' => true,
					'result'  => $data,
					'message' => 'Get shipping quote successfully',
				)
			);

		} catch ( Exception $e ) {
			return wp_json_encode(
				array(
					'error'   => true,
					'result'  => $e->getMessage(),
					'message' => 'Error when request for TaxAndDutiesApi',
				)
			);
		}
	}

	/**
	 * Method check product clssification status
	 *
	 * @since 1.0.0
	 * @param string $connection_id Connected Account ID.
	 * @param string $token JWT token for authentication.
	 * @param array  $productdata Product data array.
	 *
	 * @return mixed
	 */
	public function hscoderequest( $connection_id, $token, $productdata ) {

		$body        = new \Swagger\Client\Model\HsCodesRequest();
		$test_mode   = false;
		$instance_id = ITEMBASE_CONNECT_INSTANCE_ID;
		$config      = Swagger\Client\Configuration::getDefaultConfiguration()
		->setAccessToken( $token );

		$api_instance = new Swagger\Client\Api\HarmonizedSystemCodesApi(
			new GuzzleHttp\Client(),
			$config
		);

		$body->setShipperReference( null );
		$body->setProducts( $productdata );

		/*
		echo '<pre>';
		print_r( $body );
		echo '</pre>';
		exit;
		*/

		try {
			$result = $api_instance->getHsCodes( $body, $instance_id, $connection_id, $test_mode );
			$data   = json_decode( $result );
			return wp_json_encode(
				array(
					'success' => true,
					'result'  => $data,
					'message' => 'Hscode request successfully',
				)
			);
		} catch ( Exception $e ) {
			return wp_json_encode(
				array(
					'error'   => true,
					'result'  => $e->getMessage(),
					'message' => 'Error when request for HarmonizedSystemCodesApi',
				)
			);
		}
	}
}
