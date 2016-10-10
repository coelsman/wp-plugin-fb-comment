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

define('WP_FB_CM_DIR', WP_PLUGIN_DIR . "/" . plugin_basename(dirname(__FILE__)));
define('WP_FB_CM_URL', plugins_url(plugin_basename(dirname(__FILE__))));

require_once 'system/SocialController.php';
require_once 'application/controllers/FacebookController.php';

$socialApplication = null;
$fbController = new FacebookController();

function social_plugin_loaded() {
	global $socialApplication;
	$socialApplication = new SocialController();
}

function social_append_after_post( $content ) {
	global $fbController;
	$content = $fbController->front_comment( $content );
	return $content;
}

function social_plugin_add_menu() {
	global $fbController;
	// $fbController->view->add_menu();
}

add_action( 'plugins_loaded', 'social_plugin_loaded' );
add_action( 'admin_menu', 'social_plugin_add_menu' );
add_filter( 'the_content', 'social_append_after_post' );