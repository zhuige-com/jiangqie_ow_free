<?php

/*
 * 酱茄企业官网Free v1.0.0
 * Author: 酱茄
 * Help document: https://www.jiangqie.com/owfree/7685.html
 * github: https://github.com/longwenjunjie/jiangqie_ow_free
 * gitee: https://gitee.com/longwenjunj/jiangqie_ow_free
 * License：GPL-2.0
 * Copyright © 2021 www.jiangqie.com All rights reserved.
 */

class Jiangqie_Ow_Free_Public {

	private $jiangqie_ow_free;

	private $version;

	public function __construct( $jiangqie_ow_free, $version ) {

		$this->jiangqie_ow_free = $jiangqie_ow_free;
		$this->version = $version;

	}

	public function plugin_init()
	{
		$token = '';
		if (isset($_GET['token'])) {
			$token = $_GET['token'];
		} else if (isset($_POST['token'])) {
			$token = $_POST['token'];
		} else {
			$json = json_decode(file_get_contents('php://input'), TRUE);
			if ($json && isset($json['token'])) {
				$token = $json['token'];
			}
		}

		if (empty($token) || $token == 'false') {
			return;
		}

		global $wpdb;
		$table_usermeta = $wpdb->prefix . 'usermeta';
		$user_id = $wpdb->get_var($wpdb->prepare("SELECT user_id FROM `$table_usermeta` WHERE  meta_key='jiangqie_token' AND meta_value='%s'", $token));

		if ($user_id) {
			wp_set_current_user($user_id);
		}
	}

	public function enqueue_styles() {
		wp_enqueue_style( $this->jiangqie_ow_free, plugin_dir_url( __FILE__ ) . 'css/jiangqie-ow-free-public.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( $this->jiangqie_ow_free, plugin_dir_url( __FILE__ ) . 'js/jiangqie-ow-free-public.js', array( 'jquery' ), $this->version, false );
	}

}
