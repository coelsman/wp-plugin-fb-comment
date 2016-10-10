<?php
require_once 'SocialModel.php';

if ( !class_exists('SocialView') ) {
	class SocialView {
		public $model;
		protected $_app_view_dir;
		protected $_vendor_url;

		public function __construct() {
			$this->model = new SocialModel();
			$this->_app_view_dir = WP_SOCIAL_PLUGINS_DIR . '/application/views/';
			$this->_vendor_url = WP_SOCIAL_PLUGINS_URL . '/publics';
			$this->enqueue_scripts_and_styles();
		}

		public function render($view, $data = array()) {
			$this->_before_view();
			$this->_main_view($view, $data);
			$this->_after_view();
		}

		public function enqueue_scripts_and_styles() {
			wp_register_style( 'social-plugins', $this->_vendor_url . '/css/social-plugins.css' );
			wp_enqueue_style( 'social-plugins' );
			wp_enqueue_script( 'jquery' );
			wp_register_script( 'social-plugins', $this->_vendor_url . '/js/social-plugins.js', array(), false, true );
			wp_enqueue_script( 'social-plugins' );
		}

		public function append_after_post($content) {
			
		}

		protected function _before_view() {
			require_once ( $this->_app_view_dir . '/layouts/before_view.php' );
		}

		protected function _after_view() {
			require_once ( $this->_app_view_dir . '/layouts/after_view.php' );
		}

		protected function _main_view($view, &$data) {
			extract( $data );
			require_once ( $this->_app_view_dir . '/' . $view . '.php' );
		}
	}
}