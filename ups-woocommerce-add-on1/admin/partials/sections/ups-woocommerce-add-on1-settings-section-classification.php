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
<form id="ups-classification-form" method="get" action="#">
	<table class="widefat fixed striped table-view-list">
		<thead>
			<tr>
				<th>Classification Status</th>
				<th>Count</th>
				<th>Check-Out Behavior</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$class                       = new Ups_Woocommerce_Add_On1();
			$classification_status_count = $class->ups_get_products_count();
			if ( isset( $classification_status_count['Classified'] ) && ! empty( $classification_status_count['Classified'] ) ) {
				$classified_count = $classification_status_count['Classified'];
			} else {
				$classified_count = 0;

			}
			if ( isset( $classification_status_count['New'] ) && ! empty( $classification_status_count['New'] ) ) {
				$new_count = $classification_status_count['New'];
			} else {
				$new_count = 0;
			}

			if ( isset( $classification_status_count['Not Supported'] ) && ! empty( $classification_status_count['Not Supported'] ) ) {
				$not_supported_count = $classification_status_count['Not Supported'];
			} else {
				$not_supported_count = 0;
			}

			if ( isset( $classification_status_count['In Progress'] ) && ! empty( $classification_status_count['In Progress'] ) ) {
				$inprogress = $classification_status_count['In Progress'];
			} else {
				$inprogress = 0;
			}

			?>
			<tr>
				<td><?php echo esc_html_e( 'New', 'ups-woocommerce-add-on1' ); ?></td>
				<td><?php echo esc_html( sprintf( __( '%s', 'ups-woocommerce-add-on1' ), $new_count ) ); ?> Products</td>
				<td>
					<select>
						<option>Option 1</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><?php echo esc_html_e( 'Classified', 'ups-woocommerce-add-on1' ); ?></td>
				<td><?php echo esc_html( sprintf( __( '%s', 'ups-woocommerce-add-on1' ), $classified_count ) ); ?> Products</td>
				<td>
					<select>
						<option>Option 1</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><?php echo esc_html_e( 'In Progress', 'ups-woocommerce-add-on1' ); ?></td>
				<td><?php echo esc_html( sprintf( __( '%s', 'ups-woocommerce-add-on1' ), $inprogress ) ); ?> Products</td>
				<td>
					<select>
						<option>Option 1</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><?php echo esc_html_e( 'Not Supported', 'ups-woocommerce-add-on1' ); ?></td>
				<td><?php echo esc_html( sprintf( __( '%s', 'ups-woocommerce-add-on1' ), $not_supported_count ) ); ?> Products</td>
				<td>
					<select>
						<option>Option 1</option>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
</form>
