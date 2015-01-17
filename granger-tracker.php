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
if ( ! defined( 'WP_CACHE_DIR' ) ) define( 'WP_CACHE_DIR', WP_CONTENT_DIR . '/cache' );
if ( ! defined( 'WP_CACHE_URL' ) ) define( 'WP_CACHE_URL', WP_CONTENT_URL. '/cache' );

define("GT_PLUGIN_NAME" , basename(dirname(__FILE__)) );
define("GT_PLUGIN_DIR" , WP_PLUGIN_DIR . "/" . GT_PLUGIN_NAME);
define("GT_PLUGIN_URL" , WP_PLUGIN_URL . "/" . GT_PLUGIN_NAME);

/*

******** BEGIN PLUGIN FUNCTIONS ********

*/
function gt_scripts() {
    $bundle = array(
        "hcharts.js",
        "hchartheme.js",
        "transparency.js",
        "chic.js",
        "require.js",
        "general.js",
        "UI.js"
    );
    if(is_writable(WP_CACHE_DIR)) {
        $bundle_fn = WP_CACHE_DIR . "/gt_bundle.js";
        $mtime = file_exists($bundle_fn) ? filemtime($bundle_fn) : 0;
        foreach($bundle as $bfile) {
            if(filemtime(GT_PLUGIN_DIR . '/js/' . $bfile) > $mtime) {
                //require_once("php/jsminify.php");
                @unlink($bundle_fn);
                foreach($bundle as $bfile) {
                    //file_put_contents($bundle_fn, "/** $bfile  **/\n".JSMin::minify(file_get_contents(GT_PLUGIN_DIR . '/js/' . $bfile))."\n", FILE_APPEND);
                    file_put_contents($bundle_fn, "/** $bfile  **/\n".file_get_contents(GT_PLUGIN_DIR . '/js/' . $bfile)."\n", FILE_APPEND);
                }
                break;
            }
        }
    }
    wp_enqueue_script(
        'gt_bundle',
        WP_CACHE_URL . '/gt_bundle.js',
        array( 'jquery' )
    );
    wp_enqueue_style( 
        'gt_theme', 
        get_template_directory_uri() . '/css/tracker.css' 
    );
}
function gt_admin_scripts() {
    wp_enqueue_style( 
        'gt_admin', 
        GT_PLUGIN_URL . '/css/admin.css' 
    );
}

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
    echo file_get_contents(__DIR__. "/htm/admin.html");
    exit;
}
/* Add new menu */
add_action('admin_menu', 'tracker_add_pages');
add_action( 'admin_enqueue_scripts', 'gt_admin_scripts' );

$slugs = array(
    "servers",
    "players",
    "clans"
);
$slug = rtrim(ltrim($_SERVER["REQUEST_URI"],"/"),"/");
if(in_array($slug,$slugs)) {
    add_action( 'wp_enqueue_scripts', 'gt_scripts' );
    wp_enqueue_script(
        'gt_loader',
        GT_PLUGIN_URL . "/js/$slug.js",
        array( 'gt_bundle' )
    );
}

?>
