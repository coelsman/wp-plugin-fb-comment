<?php
require_once WP_FB_CM_DIR . '/system/SocialController.php';

if ( !class_exists('ConfigController') ) {
	class ConfigController extends SocialController {
		public $data = array();

		public function __construct() {
			parent::__construct();
		}

		public function index() {
			if ( isset( $_POST['social_plug_update'] ) ) {
				$config_values = $this->model->get_config();

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

				update_option( 'social_plugin_configs', json_encode( $config_values ) );
			}

			$this->data['config_values'] = $this->model->get_config();
			$this->view->render('config/index', $this->data);
		}
	}
}