<?php
/**
 * Plugin Name: Social Plugins for Wordpress 4.6
 * Plugin URI: 
 * Description: List of child plugins will finish about next 2 months
  - Facebook: Login, Comment, Like, Share, Graph
  - Google: Plus, Map, Drive
 * Version: 0.2
 * Author: Thanh Dao
 * Author URI:
 * License: GPLv2
 */

define('WP_SOCIAL_PLUGINS_DIR', WP_PLUGIN_DIR . "/" . plugin_basename(dirname(__FILE__)));
define('WP_SOCIAL_PLUGINS_URL', plugins_url(plugin_basename(dirname(__FILE__))));

require_once 'system/SocialController.php';
require_once 'application/controllers/ConfigController.php';
require_once 'application/controllers/FacebookController.php';

$socialApplication = null;
$fbController = new FacebookController();
$cfController = new ConfigController();

function social_plugin_loaded() {
	global $socialApplication;
	$socialApplication = new SocialController();
}

function social_append_after_post( $content ) {
	global $fbController;
	$content = $fbController->front_comment( $content );
	return $content;
}

function social_plug_frontend() {
	global $cfController;
	global $fbController;

	$page = isset( $_GET['page'] ) ? $_GET['page'] : 'social_plug_config';

	switch ($page) {
		case 'social_plug_config':
			$cfController->index();
			break;
	}
}

function social_plugin_add_menu() {
	add_menu_page('Social Plugins Configuration', 'Social Plugins', 'manage_options', 'social_plug_config', 'social_plug_frontend');
}

function social_plugin_activate() {
	$social_plugin_configs = array(
		'colorscheme' => 'light',
		'num_posts'   => 10,
		'order_by'    => 'time',
		'width'       => null
	);
	add_option( 'social_plugin_configs', json_encode( $social_plugin_configs ) );
}

add_action( 'plugins_loaded', 'social_plugin_loaded' );
add_action( 'admin_menu', 'social_plugin_add_menu' );
add_filter( 'the_content', 'social_append_after_post' );
register_activation_hook( __FILE__, 'social_plugin_activate' );

if ( isset( $_GET['action'] ) || $_GET['action'] == 'activate' ) {
	add_action( 'admin_init', 'social_plugin_activate' );
}