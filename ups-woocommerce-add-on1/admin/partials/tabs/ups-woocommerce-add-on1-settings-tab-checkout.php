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

?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
	<form id="ups_checkout_data_form" method="get" action="#">
		<?php $nonce = wp_create_nonce( 'ups_checkout_data_form' ); ?>
		<input type="hidden" name="ups_checkout_data_form_nonce" id="ups_checkout_data_form_nonce" value="<?php echo esc_attr( $nonce ); ?>" />
		<table class="widefat fixed striped table-view-list">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Shipping Zone', 'ups-woocommerce-add-on1' ); ?></th>
					<th><?php esc_html_e( 'Shipping Method', 'ups-woocommerce-add-on1' ); ?></th>
					<th><?php esc_html_e( 'UPS® Global Checkout', 'ups-woocommerce-add-on1' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$zones_data = new Ups_Woocommerce_Add_On1();
				$zones      = $zones_data->ups_get_all_shipping_zones();
				foreach ( $zones as $zone ) {
					$zone_id               = $zone->get_id();
					$zone_name             = $zone->get_zone_name();
					$zone_shipping_methods = $zone->get_shipping_methods();
					// if ( count( $zone_shipping_methods ) ) {
					?>
						<tr>
							<td>
								<?php
								/* translators: %s: Zone name */
								echo esc_html( sprintf( __( '%s', 'ups-woocommerce-add-on1' ), $zone_name ) );
								?>
							</td>
							<td>
								<ul>
									<?php
									foreach ( $zone_shipping_methods as $index => $method ) {
										$method_title       = $method->get_method_title();
										$method_user_title  = $method->get_title();
										$method_rate_id     = $method->get_rate_id();
										$method_instance_id = $method->get_instance_id();
										?>
										<li>
											<?php
											/* translators: %s: Method User Title */
											echo esc_html( sprintf( __( '%s', 'ups-woocommerce-add-on1' ), $method_user_title ) );
											?>
										</li>
										<?php
									}
									?>
								</ul>
							</td>
							<td>
								<?php
								$check_property = new Ups_Woocommerce_Add_On1();
								$checked        = $check_property->has_property_value( $zone_shipping_methods, 'id', 'ups-shipping-method' );
								$selected       = '';
								$inactivated    = '';
								if ( true === $checked ) {
									$selected = 'selected';
								} elseif ( false === $checked ) {
									$inactivated = 'selected';
								}
								?>
								<select name = 'ups-global-checkout-add-method' class = 'ups-global-checkout-add-method'>
									<option 
									value="active" 
									data-id="ups-shipping-method" 
									data-zone="<?php echo esc_attr( $zone_id ); ?>" 
									data-action="add" 
									<?php echo ( isset( $selected ) && ! empty( $selected ) && null !== $selected ) ? esc_attr( $selected ) : ''; ?> 
									>
										<?php esc_html_e( 'Active', 'ups-woocommerce-add-on1' ); ?>
									</option>
									<option 
									value="inactive" 
									data-id="ups-shipping-method" 
									data-zone="<?php echo esc_attr( $zone_id ); ?>" 
									data-action="remove" 
									<?php echo ( isset( $inactivated ) && ! empty( $inactivated ) && null !== $inactivated ) ? esc_attr( $inactivated ) : ''; ?> 
									>
										<?php esc_html_e( 'Inactive', 'ups-woocommerce-add-on1' ); ?>
									</option>
								</select>
								<p class="error-tag" id="error_zone_<?php echo esc_attr( $zone_id ); ?>" style="color: #ff0000;font-size: 15px;font-weight: bold;display: none;"><?php esc_html_e( 'Please try again', 'ups-woocommerce-add-on1' ); ?></p>
							</td>
						</tr>
									<?php
									// }
				}
				?>
			</tbody>
		</table>
	</form>
</div>
