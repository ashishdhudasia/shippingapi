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
$default_tab = null;
$custom_tab  = isset( $_GET['tab'] ) ? $_GET['tab'] : $default_tab;
?>
<h1 class="wp-heading-inline">Settings</h1>
<div class="wrap itembase-custom-wrap">
		<nav class="nav-tab-wrapper">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=ups-setting-page' ) ); ?>" class="nav-tab 
			<?php if ( null === $custom_tab ) : ?>
			nav-tab-active
			<?php endif; ?>">Accounts</a>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=ups-setting-page&tab=data' ) ); ?>" class="nav-tab 
			<?php if ( 'data' === $custom_tab ) : ?>
			nav-tab-active
			<?php endif; ?>">Data</a>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=ups-setting-page&tab=checkout' ) ); ?>" class="nav-tab 
			<?php if ( 'checkout' === $custom_tab ) : ?>
			nav-tab-active
			<?php endif; ?>">Checkout</a>		
		</nav>
		<div class="tab-content itembase-tab-content">
			<?php
			switch ( $custom_tab ) :
				case 'data':
					include_once UPSWOOCOMMERCE_ADDON1_PLUGIN_DIR . 'admin/partials/tabs/ups-woocommerce-add-on1-settings-tab-data.php';
					break;
				case 'checkout':
					include_once UPSWOOCOMMERCE_ADDON1_PLUGIN_DIR . 'admin/partials/tabs/ups-woocommerce-add-on1-settings-tab-checkout.php';
					break;
				default:
					include_once UPSWOOCOMMERCE_ADDON1_PLUGIN_DIR . 'admin/partials/tabs/ups-woocommerce-add-on1-settings-tab-accounts.php';
					break;
			endswitch;
			?>
		</div>
		
</div>
	