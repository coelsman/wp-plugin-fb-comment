<?php
if ( !class_exists('SocialModel') ) {
	class SocialModel {
		public function get_config() {
			$config_values = get_option( 'social_plugin_configs' );
			return json_decode( $config_values );
		}
	}
}