<?php
/**
 * Plugin Name: Coelsman Facebook Comment
 * Plugin URI: 
 * Description: 
 * Version: 1.0
 * Author: Thanh Dao
 * Author URI:
 * License: GPLv2
 */

define('WP_FB_CM_DIR', WP_PLUGIN_DIR . "/" . plugin_basename(dirname(__FILE__)));
define('WP_FB_CM_URL', plugins_url(plugin_basename(dirname(__FILE__))));

if ( !class_exists('Fb_Comment') ) {
	class Fb_Comment {
		public function __construct() {
			if ( !function_exists('add_shortcode') ) {
				return;
			}
			add_shortcode( 'hello', array(&$this, 'hello_func') );

			/**
			* Load required CSS and JS files
			*/
			$this->enqueue_scripts_and_styles();
		}

		public function hello_func($atts = array(), $content = null) {
			extract( shortcode_atts( array('name' => 'World'), $atts ) );
			return '<p>Hello ' . $name . '!!!</p>';
		}

		public function enqueue_scripts_and_styles() {
			wp_register_style( 'fb-comment', plugins_url( '/css/fb-comment.css', __FILE__ ) );
			wp_enqueue_style( 'fb-comment' );
			wp_enqueue_script( 'jquery' );
			wp_register_script( 'fb-comment', plugins_url( '/js/fb-comment.js', __FILE__ ), array(), false, true );
			wp_enqueue_script( 'fb-comment' );
		}
	}
}

function mfpd_load() {
	global $mfpd;
	$mfpd = new Fb_Comment();
}

/**
* Add menu to Admin dashboard
*/
function fb_comment_add_menu() {
	add_menu_page('FB Comment Configurations', 'FB Comment', 'manage_options', 'manage_fb_comment', 'fb_comment_layout');
}

function fb_comment_get_config() {
	$config_values = get_option( 'fb_comment_configs' );
	return json_decode( $config_values );
}

/**
* This function will be called when admin active plugin
*
* For detail values of options, please take a look at 
* https://developers.facebook.com/docs/plugins/comments/#configurator
*/
function fb_comment_activate() {
	$fb_comment_configs = array(
		'colorscheme' => 'light',
		'num_posts'   => 10,
		'order_by'    => 'time',
		'width'       => null
	);
	add_option( 'fb_comment_configs', json_encode( $fb_comment_configs ) );
}

function fb_comment_layout() {
	if ( isset($_GET['fb_comment_view']) && $_GET['fb_comment_view'] ) {
		$view = $_GET['fb_comment_view'];
	} else {
		$view = 'config';
	}

	$config_values = fb_comment_get_config();
	$_SESSION['fb_comment_variables'] = $config_values;

	fb_comment_view( $view );
}

function fb_comment_view( $view ) {
	fb_comment_before_view();
	require_once ( WP_FB_CM_DIR . '/views/' . $view . '.php' );
	fb_comment_after_view();
}

function fb_comment_before_view() {
	require_once ( WP_FB_CM_DIR . '/before_view.php' );
}

function fb_comment_after_view() {
	require_once ( WP_FB_CM_DIR . '/after_view.php' );
}

function fb_comment_append_after_post($content) {
	if ( is_single() && !is_home() && !is_feed() ) {
		$config_values  = fb_comment_get_config();
		$content .= '<div class="fb-comments" data-href="' . get_permalink() . '"';

		if ( $config_values->num_posts ) {
			$content .= ' data-numposts="' . $config_values->num_posts . '"';
		}
		if ( $config_values->order_by ) {
			$content .= ' data-order-by="' . $config_values->order_by . '"';
		}
		if ( $config_values->width ) {
			$content .= ' data-width="' . $config_values->width . '"';
		} else {
			$content .= ' data-width="100%"';
		}
		if ( $config_values->colorscheme ) {
			$content .= ' data-colorscheme="' . $config_values->colorscheme . '"';
		}

		return $content . '></div>';
	} else {
		return $content;
	}
}

add_action( 'plugins_loaded', 'mfpd_load' );  // Call function when this plugin is loaded.
add_action( 'admin_menu', 'fb_comment_add_menu' ); // Call function when Admin dashboard page loaded.
add_filter( 'the_content', 'fb_comment_append_after_post' ); // Call function when the post is shown.
register_activation_hook( __FILE__, 'fb_comment_activate' );

if ( isset( $_GET['action'] ) || $_GET['action'] == 'activate' ) {
	add_action( 'admin_init', 'fb_comment_activate' );
}

if ( isset( $_POST['fb_comment_update'] ) ) {
	$config_values = fb_comment_get_config();

	if ( isset( $_POST['num_posts'] ) ) {
		if ( (int) $_POST['num_posts'] <= 0 ) {
			$_POST['num_posts'] = 1;
		}
		$config_values->num_posts = (int) $_POST['num_posts'];
	}
	if ( isset( $_POST['colorscheme'] ) ) {
		$config_values->colorscheme = $_POST['colorscheme'];
	}
	if ( isset( $_POST['order_by'] ) ) {
		$config_values->order_by = $_POST['order_by'];
	}
	if ( isset( $_POST['width'] ) ) {
		$config_values->width = $_POST['width'] ? (int) $_POST['width'] : null;
	}

	update_option( 'fb_comment_configs', json_encode( $config_values ) );
}
?>