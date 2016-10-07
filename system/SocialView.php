<?php
require_once 'SocialModel.php';

if ( !class_exists('SocialView') ) {
	class SocialView {
		public $model;
		protected $_app_view_dir;

		public function __construct() {
			$this->model = new SocialModel();
			$this->_app_view_dir = WP_FB_CM_DIR . '/application/views/';
		}

		public function render($view, $data = array()) {
			$this->_before_view();
			$this->_main_view($view);
			$this->_after_view();
		}

		public function add_menu() {
			add_menu_page('FB Comment Configurations', 'FB Comment', 'manage_options', 'manage_fb_comment', 'fb_comment_layout');
		}

		public function enqueue_scripts_and_styles() {
			wp_register_style( 'fb-comment', plugins_url( '/publics/css/fb-comment.css', __FILE__ ) );
			wp_enqueue_style( 'fb-comment' );
			wp_enqueue_script( 'jquery' );
			wp_register_script( 'fb-comment', plugins_url( '/publics/js/fb-comment.js', __FILE__ ), array(), false, true );
			wp_enqueue_script( 'fb-comment' );
		}

		public function append_after_post($content) {
			if ( is_single() && !is_home() && !is_feed() ) {
				$config_values  = $this->model->get_config();
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

		protected function _before_view() {
			require_once ( $this->_app_view_dir . '/layouts/before_view.php' );
		}

		protected function _after_view() {
			require_once ( $this->_app_view_dir . '/layouts/after_view.php' );
		}

		protected function _main_view($view) {
			require_once ( $this->_app_view_dir . '/' . $view . '.php' );
		}
	}
}