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
	<a href="#" class="page-title-action">ADD NEW ACCOUNT</a>
	<form id="ups-account-form" method="get" action="#">
		<?php $nonce = wp_create_nonce( 'account_form_nonce' ); ?>
		<input type="hidden" name="account_form_nonce" id="account_form_nonce" value="<?php echo esc_attr( $nonce ); ?>" />
		<table class="widefat fixed striped table-view-list">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Account Name', 'ups-woocommerce-add-on1' ); ?></th>
					<th><?php esc_html_e( 'Account Type', 'ups-woocommerce-add-on1' ); ?></th>
					<th><?php esc_html_e( 'Connection Date', 'ups-woocommerce-add-on1' ); ?></th>
					<th><?php esc_html_e( 'Status', 'ups-woocommerce-add-on1' ); ?></th>
					<th><?php esc_html_e( 'Actions', 'ups-woocommerce-add-on1' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				global $wpdb;
				$tablename = ITEMBASE_CONNECTION_TABLE . '';
				$ibcofig   = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %1s', $tablename ) );
				foreach ( $ibcofig as $config ) {
						$ib_account_name    = $config->ib_account_name;
						$ib_account_status  = $config->ib_account_status;
						$connection_id      = $config->ib_connection_id;
						$ib_connection_date = $config->ib_updated_date;
					?>
				<tr>
					<td><?php echo esc_attr( $ib_account_name ); ?></td>
					<td>-</td>
					<td><?php echo esc_attr( $ib_connection_date ); ?></td>
					<td><?php echo esc_attr( $ib_account_status ); ?></td>
					<td>
						<a href="javascript:void(0);" class="edit-connection-action" data-id="<?php echo esc_attr( $connection_id ); ?>" ><span class="dashicons dashicons-edit"></span></a>
						<a href="javascript:void(0);" class="delete-connection-action" data-id=<?php echo esc_attr( $connection_id ); ?> ><span class="dashicons dashicons-no"></span></a>
					</td>
				</tr>
					<?php
				}
				?>
				<!-- <tr>
					<td>My WWE Account 1</td>
					<td>UPS WWE</td>
					<td>2023-10-11</td>
					<td>Active</td>
					<td>
						<a href="#" class="edit-action"><span class="dashicons dashicons-edit"></span></a>
						<a href="#" class="delete-action"><span class="dashicons dashicons-no"></span></a>
					</td>
				</tr> -->
			</tbody>
		</table>
		<p class="error-tag" style="color: #ff0000;font-size: 15px;font-weight: bold;display: none;"><?php esc_html_e( 'Please try again', 'ups-woocommerce-add-on1' ); ?></p>
	</form>
</div>
