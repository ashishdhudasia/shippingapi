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
<form id="ups-tracking-code-form" method="get" action="#">
	<table class="widefat fixed striped table-view-list">
		<thead>
			<tr>
				<th>Shipping Zone</th>
				<th>Shipping Method</th>
				<th>Tracking Code Field (Shortcode)</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Canada</td>
				<td>Express DDP</td>
				<td>
					<input type="text" placeholder="Add Shortcode" id="tracking-code" name="tracking-code">
				</td>
			</tr>
			<tr>
				<td>Canada</td>
				<td>Express</td>
				<td>
					<input type="text" placeholder="{shipstation_tracking}" id="tracking-code" name="tracking-code">
				</td>
			</tr>
		</tbody>
	</table>
</form>