<?php
/** 
 * Plugin Uninstaller
 * 
 * Run the plugin uninstaller.  Removes all settings created
 * and the custom post type
 * 
 * @since 7.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin's Security Header Generator
 * 
*/

// make sure we're actually supposed to be doing this
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) || ! WP_UNINSTALL_PLUGIN ||
	dirname( WP_UNINSTALL_PLUGIN ) != dirname( plugin_basename( __FILE__ ) ) ) {
	exit;
}

// remove our settings
unregister_setting( 'kp_cspgen_settings_group', 'kp_cspgen_settings_name' );

// delete the option
delete_option( 'kp_cspgen_settings_name' );

// remove the CPT
unregister_post_type( 'kcp_csp' );

// remove the post for the CSP
global $wpdb;
$wpdb -> query( "DELETE FROM {$wpdb->posts} WHERE `post_type` = 'kcp_csp'" );
