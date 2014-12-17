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



/*
 * Create the extra column on the user table needed for plugin when plugin is activated
 */
function mma_edit_user_table(){
	global $wpdb;
	$table_name = $wpdb->prefix . 'users';
	$sql = 'ALTER TABLE ' . $table_name . ' ADD membership_management_level int';
	$wpdb->query($sql);
}
register_activation_hook(__FILE__, 'mma_edit_user_table');

/*
 * Remove the extra column on the user table needed for plugin when plugin is deactivated
 */
function mma_delete_column_user_table(){
	global $wpdb;
	$table_name = $wpdb->prefix . 'users';
	$sql = 'ALTER TABLE ' . $table_name . ' DROP COLUMN membership_management_level';
	$wpdb->query($sql);
}
register_deactivation_hook(__FILE__, 'mma_delete_column_user_table');

/*
 * Hook for adding admin menus
 */
add_action('admin_menu', 'mt_add_pages');

/*
 * action function for above hook
 */
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

/*
 * membership_management_page() displays the page content for the custom Test Toplevel menu
 */
/*
 * Check if the user can manage plugin options
 */
function membership_management_page(){
	if(!current_user_can('manage_options')){
		wp_die('You do not have sufficient permissions to access this page.');
	}
	require('options-page-wrapper.php');
}

/*
 * get testimonials by shortcode
 */
function membership_management_shortcode( $atts, $content = null ) {
	global $wpdb;
	$current_user = wp_get_current_user();
	$table_name = $wpdb->prefix . 'users';
    $a = shortcode_atts( array(
        'level' => null,
    ), $atts );
	$id = $a['level'];
	$row = $wpdb->get_row( $wpdb->prepare('SELECT membership_management_level FROM ' . $table_name . ' WHERE id = %d', $current_user->ID) );

	if($id >= $row->membership_management_level){
		$htmlString = $content;
	}else{
		$htmlString = 'sorry can\'t view';
	}
	return $htmlString;
}
add_shortcode( 'membership management', 'membership_management_shortcode' );



?>