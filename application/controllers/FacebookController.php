<?php
require_once WP_FB_CM_DIR . '/system/SocialController.php';

if ( !class_exists('FacebookController') ) {
	class FacebookController extends SocialController {
		public function __construct() {
			parent::__construct();
		}
	}
}