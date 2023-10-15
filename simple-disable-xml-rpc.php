<?php
/**
 * Simple Disable XML-RPC
 *
 * @package       SIMPLEDISA
 * @author        Delower Hossain
 * @license       gplv2
 * @version       1.0
 *
 * @wordpress-plugin
 * Plugin Name:   Simple Disable XML-RPC
 * Plugin URI:    https://www.delowerhossain.com
 * Description:   Simple Disable XML-RPC is a user-friendly WordPress plugin that empowers website administrators to easily control and secure their site by enabling or disabling the XML-RPC functionality. With a simple toggle switch, this plugin helps protect your WordPress site from potential XML-RPC-related security threats, enhancing your website's overall safety and performance.
 * Version:       1.0
 * Requires at least: 5.7
 * Requires PHP:  7.2
 * Author:        Delower Hossain
 * Author URI:    https://www.delowerhossain.com
 * Text Domain:   simple-disable-xml-rpc
 * Domain Path:   /languages
 * License:       GPLv2
 * License URI:   https://www.gnu.org/licenses/gpl-2.0.html
 *
 */

// Avoiding Direct File Access

if ( ! defined( 'ABSPATH' ) ) exit;

// Load Plugin Text Domain

function sdxr_dc_load_textdomain() {
    load_plugin_textdomain( 'simple-disable-xml-rpc', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
  }
  add_action( 'plugins_loaded', 'sdxr_dc_load_textdomain' );


// Enable or Disable XML-RPC functionality.

//Create the Settings Page

function xmlrpc_disabler_menu() {
    add_options_page(
        __( 'Simple Disable XML-RPC', 'simple-disable-xml-rpc' ),
        __( 'Simple Disable XML-RPC', 'simple-disable-xml-rpc' ),
        'manage_options',
        'simple-disable-xml-rpc',
        'xmlrpc_disabler_page'
    );
}
add_action('admin_menu', 'xmlrpc_disabler_menu');

function xmlrpc_disabler_page() {
    ?>
    <div class="wrap">
        <h2>Simple Disable XML-RPC Settings</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('xmlrpc_disabler');
            do_settings_sections('xmlrpc-disabler');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

//Add the Checkbox Option

function xmlrpc_disabler_init() {
    register_setting('xmlrpc_disabler', 'xmlrpc_enabled');
    add_settings_section('xmlrpc_disabler_section', __('Simple Disable XML-RPC Settings', 'simple-disable-xml-rpc'), 'xmlrpc_disabler_section_callback', 'xmlrpc-disabler');
    add_settings_field('xmlrpc_enabled', __('Enable XML-RPC', 'simple-disable-xml-rpc'), 'xmlrpc_enabled_callback', 'xmlrpc-disabler', 'xmlrpc_disabler_section');
}
add_action('admin_init', 'xmlrpc_disabler_init');

function xmlrpc_disabler_section_callback() {
    echo __('Enable or disable XML-RPC functionality for the site.', 'simple-disable-xml-rpc');
}

function xmlrpc_enabled_callback() {
    $xmlrpc_enabled = get_option('xmlrpc_enabled');
    echo '<input type="checkbox" name="xmlrpc_enabled" ' . checked(1, $xmlrpc_enabled, false) . ' value="1" />';
}

//Save the Checkbox Value

function xmlrpc_disabler_save_post_data() {
    if (isset($_POST['xmlrpc_enabled'])) {
        update_option('xmlrpc_enabled', 1);
    } else {
        update_option('xmlrpc_enabled', 0);
    }
}
add_action('admin_post_save_xmlrpc_settings', 'xmlrpc_disabler_save_post_data');


// Simple Disable XML-RPC Option Links

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'sdxr_add_action_links' );

function sdxr_add_action_links ( $actions ) {
   $mylinks = array(
      '<a href="' . admin_url( 'options-general.php?page=simple-disable-xml-rpc' ) . '">Settings</a>',
   );
   $actions = array_merge( $actions, $mylinks );
   return $actions;
}