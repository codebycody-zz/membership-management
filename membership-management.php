<?php
/*
 * Plugin Name: Membership Management
 * Plugin URI: http://archonweb.com/membership-management/
 * Description: Allows the ability to setup and manage multiple membership tiers.
 * Version: 1.0
 * Author: Cody Greene
 * Author URI: https://github.com/toymakercody
 * License: GPL2
 *
 */
/*
 * Assign global variables
 */


// Hook for adding admin menus
add_action('admin_menu', 'mt_add_pages');

// action function for above hook
function mt_add_pages() {
	global $plugin_url;
	// Add a new top-level menu (ill-advised):
	add_menu_page(
		__('Membership Management','Membership Management'),
		__('Membership Management','Membership Management'),
		'manage_options',
		'manage_options',
		'membership_management_page',
		WP_PLUGIN_URL . '/membership-management/img/contact_card.png'
		
	);

}

// membership_management_page() displays the page content for the custom Test Toplevel menu
function membership_management_page() {
    echo "<h2>" . "Membership Management" . "</h2>";
}

?>