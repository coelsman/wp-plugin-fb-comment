<?php
require_once WP_SOCIAL_PLUGINS_DIR . '/system/SocialController.php';

if ( !class_exists('FacebookController') ) {
	class FacebookController extends SocialController {
		public function __construct() {
			parent::__construct();
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