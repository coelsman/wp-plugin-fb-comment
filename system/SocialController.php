<?php
require_once 'SocialView.php';

if ( !class_exists('SocialController') ) {
	class SocialController {
		public $view;

		public function __construct() {
			$this->view = new SocialView();
		}
	}
}