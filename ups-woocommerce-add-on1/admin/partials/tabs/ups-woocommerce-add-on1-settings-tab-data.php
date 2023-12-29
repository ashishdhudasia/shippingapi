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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get the active tab from the $_GET param.
$default_section = null;
$custom_section  = isset( $_GET['section'] ) ? $_GET['section'] : $default_section;
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<ul class="subsubsub">
	<li>
		<a href="?page=ups-setting-page&tab=data&section=classification" class=" 
		<?php
		if ( null === $custom_section ) :
			?>
			current<?php endif; ?>">Classification</a> |  
	</li>
	<li>
		<a href="?page=ups-setting-page&tab=data&section=tracking-codes" class="
		<?php if ( 'tracking-codes' === $custom_section ) : ?>
			current
		<?php endif; ?>">Tracking Codes</a> 
	</li>
</ul>
<div class="wrap itembase-custom-wrap">
	<div class="tab-content itembase-tab-content">
		<?php
		switch ( $custom_section ) :
			case 'tracking-codes':
				include_once UPSWOOCOMMERCE_ADDON1_PLUGIN_DIR . 'admin/partials/sections/ups-woocommerce-add-on1-settings-section-tracking-codes.php';
				break;
			default:
				include_once UPSWOOCOMMERCE_ADDON1_PLUGIN_DIR . 'admin/partials/sections/ups-woocommerce-add-on1-settings-section-classification.php';
				break;
		endswitch;
		?>
	</div>	
</div>
