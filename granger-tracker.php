<?php
/*
Plugin Name: Granger Tracker
Plugin URI: http://grangerhub.com
Description: Display info from the tracker
Author: GlobalWarming
Author URI:http://grangerhub.com
Version: 0.1
License: GPLv2
*/

/*
This program is free software; you can redistribute it and/or modify 
it under the terms of the GNU General Public License as published by 
the Free Software Foundation; version 2 of the License.

This program is distributed in the hope that it will be useful, 
but WITHOUT ANY WARRANTY; without even the implied warranty of 
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
GNU General Public License for more details. 

You should have received a copy of the GNU General Public License 
along with this program; if not, write to the Free Software 
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA 
*/

/*
GENERAL NOTES

 * PHP short tags ( e.g. <?= ?> ) are not used as per the advice from PHP.net
 * No database implementation
 * IMPORTANT: Menu is visible to anyone who has 'read' capability, so that means subscribers
              See: http://codex.wordpress.org/Roles_and_Capabilities for information on appropriate settings for different users

*/

// Make sure that no info is exposed if file is called directly -- Idea taken from Akismet plugin
if ( !function_exists( 'add_action' ) ) {
	echo "This page cannot be called directly.";
	exit;
}

// Define some useful constants that can be used by functions
if ( ! defined( 'WP_CONTENT_URL' ) ) {	
	if ( ! defined( 'WP_SITEURL' ) ) define( 'WP_SITEURL', get_option("siteurl") );
	define( 'WP_CONTENT_URL', WP_SITEURL . '/wp-content' );
}
if ( ! defined( 'WP_SITEURL' ) ) define( 'WP_SITEURL', get_option("siteurl") );
if ( ! defined( 'WP_CONTENT_DIR' ) ) define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) ) define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) ) define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );

if ( basename(dirname(__FILE__)) == 'plugins' )
	define("GT_PLUGIN_DIR",'');
else define("GT_PLUGIN_DIR" , basename(dirname(__FILE__)) );
define("GT_PLUGIN_PATH", WP_PLUGIN_URL . "/" . GT_PLUGIN_DIR);

/* Add new menu */
add_action('admin_menu', 'tracker_add_pages');
// http://codex.wordpress.org/Function_Reference/add_action

/*

******** BEGIN PLUGIN FUNCTIONS ********

*/
function gt_scripts() {
    wp_enqueue_script(
        'high_charts',
        GT_PLUGIN_PATH . '/js/hcharts.js',
        array( 'jquery' )
    );
    wp_enqueue_script(
        'high_charts_theme',
        GT_PLUGIN_PATH . '/js/hchartheme.js',
        array( 'high_charts' )
    );
    wp_enqueue_script(
        'transparency',
        GT_PLUGIN_PATH . '/js/transparency.js',
        array( 'jquery' )
    );
    wp_enqueue_script(
        'chic',
        GT_PLUGIN_PATH . '/js/chic.js',
        array( 'jquery' )
    );
    wp_enqueue_script(
        'require',
        GT_PLUGIN_PATH . '/js/require.js',
        array( 'jquery' )
    );
    wp_enqueue_script(
        'general',
        GT_PLUGIN_PATH . '/js/general.js',
        array( 'jquery','chic' )
    );
    wp_enqueue_script(
        'ui',
        GT_PLUGIN_PATH . '/js/UI.js',
        array( 'jquery','chic','general' )
    );
}
function gt_admin_scripts() {
    wp_enqueue_style( 
        'admin', 
        GT_PLUGIN_PATH . '/css/admin.css' 
    );
}

add_action( 'wp_enqueue_scripts', 'gt_scripts' );
add_action( 'admin_enqueue_scripts', 'gt_admin_scripts' );

// function for: 
function tracker_add_pages() {

  // anyone can see the menu for the Tracker Plugin
  add_menu_page('Granger Tracker','Granger Tracker', 'read', 'tracker_overview', 'tracker_overview');
  // http://codex.wordpress.org/Function_Reference/add_menu_page

  // this is just a brief introduction
  add_submenu_page('tracker_overview', 'Granger Tracker', 'Overview', 'read', 'tracker_overview', 'tracker_intro');
  // http://codex.wordpress.org/Function_Reference/add_submenu_page

}

function tracker_overview() {
?>
<div class="wrap"><h2>Granger Tracker Overview</h2>
<p>Nothing yet</p>
</div>
<?php
exit;
}

?>
