<?php
if ( !class_exists('SocialView') ) {
	class SocialView {
		protected $_app_view_dir;

		public function __construct() {
			$this->_app_view_dir = WP_FB_CM_DIR . '/application/views/';
		}

		public function render($view, $data = array()) {
			$this->_before_view();
			$this->_main_view($view);
			$this->_after_view();
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