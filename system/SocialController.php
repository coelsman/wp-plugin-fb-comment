<?php
require_once 'SocialModel.php';
require_once 'SocialView.php';

if ( !class_exists('SocialController') ) {
	class SocialController {
		public $view;
		public $model;

		public function __construct() {
			$this->model = new SocialModel();
			$this->view = new SocialView();
		}
	}
}