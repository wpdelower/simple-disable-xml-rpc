<?php
/**
 * Simple Disable XML-RPC
 *
 * @package       SIMPLEDISA
 * @author        Delower Hossain
 * @license       gplv2
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   Simple Disable XML-RPC
 * Plugin URI:    https://www.delowerhossain.com
 * Description:   Simple Disable XML-RPC\" is a user-friendly WordPress plugin that empowers website administrators to easily control and secure their site by enabling or disabling the XML-RPC functionality. With a simple toggle switch, this plugin helps protect your WordPress site from potential XML-RPC-related security threats, enhancing your website\'s overall safety and performance.
 * Version:       1.0.0
 * Author:        Delower Hossain
 * Author URI:    https://www.delowerhossain.com
 * Text Domain:   simple-disable-xml-rpc
 * Domain Path:   /languages
 * License:       GPLv2
 * License URI:   https://www.gnu.org/licenses/gpl-2.0.html
 *
 * You should have received a copy of the GNU General Public License
 * along with Simple Disable XML-RPC. If not, see <https://www.gnu.org/licenses/gpl-2.0.html/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

// Enable or Disable XML-RPC functionality.


//Create the Settings Page

function xmlrpc_disabler_menu() {
    add_options_page(
        'XML-RPC Disabler',
        'XML-RPC Disabler',
        'manage_options',
        'xmlrpc-disabler',
        'xmlrpc_disabler_page'
    );
}
add_action('admin_menu', 'xmlrpc_disabler_menu');

function xmlrpc_disabler_page() {
    ?>
    <div class="wrap">
        <h2>XML-RPC Disabler Settings</h2>
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
    add_settings_section('xmlrpc_disabler_section', 'XML-RPC Settings', 'xmlrpc_disabler_section_callback', 'xmlrpc-disabler');
    add_settings_field('xmlrpc_enabled', 'Enable XML-RPC', 'xmlrpc_enabled_callback', 'xmlrpc-disabler', 'xmlrpc_disabler_section');
}
add_action('admin_init', 'xmlrpc_disabler_init');

function xmlrpc_disabler_section_callback() {
    echo 'Enable or disable XML-RPC functionality for the site.';
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
