<?php
require_once WP_SOCIAL_PLUGINS_DIR . '/system/SocialController.php';

if ( !class_exists('ConfigController') ) {
	class ConfigController extends SocialController {
		public $data = array();

		public function __construct() {
			parent::__construct();
		}

		public function index() {
			
		}
	}
}