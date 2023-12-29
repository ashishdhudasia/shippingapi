<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.ups.com
 * @since      1.0.0
 *
 * @package    Ups_Woocommerce_Add_On1
 * @subpackage Ups_Woocommerce_Add_On1/admin/partials
 */

global $wpdb;
$tablename = ITEMBASE_CONNECTION_TABLE . '';
$ibcofig   = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %1s', $tablename ) );
if ( $ibcofig ) {
	$ib_connection_id = $ibcofig[0]->ib_connection_id;
} else {
	$ib_connection_id = '';
}
?>
<?php
if ( isset( $ib_connection_id ) && ! empty( $ib_connection_id ) && null !== $ib_connection_id ) {
	?>
	<div id="metabox" class="postbox">
		<div class="postbox-header">
			<h2 class="hndle"><?php esc_html_e( '2. Connect to your UPS Dashboard', 'ups-woocommerce-add-on1' ); ?></h2>
			<h2 class="right"><?php esc_html_e( 'Connected Successfully', 'ups-woocommerce-add-on1' ); ?></h2>
			<div class="handle-actions hide-if-no-js">
				<button type="button" class="handlediv" aria-expanded="true">
					<span class="dashicons dashicons-saved"></span>
				</button>
			</div>
		</div>
	</div>				
	<?php
} else {
	?>
	<div id="metabox" class="postbox">
		<div class="postbox-header">
			<h2 class="hndle ui-sortable-handle"><?php esc_html_e( '2. Connect to your UPS Dashboard', 'ups-woocommerce-add-on1' ); ?></h2>
			<div class="handle-actions hide-if-no-js">
				<button type="button" class="handlediv" aria-expanded="true">
					<span class="screen-reader-text"><?php esc_html_e( 'Toggle panel: Connect your UPS Account', 'ups-woocommerce-add-on1' ); ?></span>
					<span class="toggle-indicator" aria-hidden="true"></span>
				</button>
			</div>
		</div>
		<div class="inside">
			<div class="custom-inside">
				<div class="main">
					<form name="post" action="#" method="post" class="initial-form hide-if-no-js">

						<?php $nonce = wp_create_nonce( 'connect_account_form' ); ?>
						<input type="hidden" name="connect_account_form_nonce" id="connect_account_form_nonce" value="<?php echo esc_attr( $nonce ); ?>" />

						<div class="input-text-wrap" id="gls_username-wrap">
							<label for="gls_username"><?php esc_html_e( 'GLS Username:', 'ups-woocommerce-add-on1' ); ?></label>
							<input type="text" name="gls_username" id="gls_username" autocomplete="off" />
						</div>

						<div class="input-text-wrap" id="gls_password-wrap">
							<label for="gls_password"><?php esc_html_e( 'GLS Password:', 'ups-woocommerce-add-on1' ); ?></label>
							<input type="text" name="gls_password" id="gls_password" autocomplete="off" />
						</div>

						<div class="input-text-wrap" id="account_number-wrap">
							<label for="account_number"><?php esc_html_e( 'UPS Account Number:', 'ups-woocommerce-add-on1' ); ?></label>
							<input type="text" name="account_number" id="account_number" autocomplete="off" />
						</div>

						<div class="checkbox-wrap" id="terms_condition-wrap">
							<!-- <label for="terms_condition">
								<input name="terms_condition" type="checkbox" id="terms_condition" value="1">
								<?php esc_html_e( 'I hereby accept the Terms of Service UPS Guaranteed Landed Cost and the UPS® Global Checkout Plugin', 'ups-woocommerce-add-on1' ); ?> <a target="_blank" href="https://www.ups.com/de/en/support/shipping-support/legal-terms-conditions/privacy-notice.page">UPS Privacy Notice</a>
							</label> -->
							<?php
							if ( isset( $terms_conditions ) ) {
								echo $terms_conditions;
							}
							?>
						</div>
						<p><a class="button button-primary" id="connect_account_now"><?php esc_html_e( 'Connect', 'ups-woocommerce-add-on1' ); ?></a></p>

						<p class="error-tag" style="color: #ff0000;font-size: 15px;font-weight: bold;display: none;"><?php esc_html_e( 'Please try again', 'ups-woocommerce-add-on1' ); ?></p>

					</form>
				</div>
				<div class="sub">
					<img src="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'images/demo-image.png' ); ?>" alt="<?php esc_html_e( 'UPS logo', 'ups-woocommerce-add-on1' ); ?>" class="ups-image" width="400">
				</div>
			</div>
		</div>
	</div>
	<?php
}