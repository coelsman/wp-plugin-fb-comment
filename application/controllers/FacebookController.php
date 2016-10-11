<?php
require_once WP_SOCIAL_PLUGINS_DIR . '/system/SocialController.php';

if ( !class_exists('FacebookController') ) {
	class FacebookController extends SocialController {
		public $data = array();

		public function __construct() {
			parent::__construct();
			$this->data['splug_title_page'] = 'SOCIAL PLUGINS - FACEBOOK CONFIGURATIONS';
		}

		public function conf() {
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
			$this->view->render('facebook/conf', $this->data);
		}

		public function front_comment($content) {
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
	}
}