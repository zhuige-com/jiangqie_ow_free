<?php

/*
 * 酱茄企业官网Free
 * Author: 追格
 * Help document: https://www.zhuige.com/docs/gwfree.html
 * github: https://github.com/zhuige-com/jiangqie_ow_free
 * gitee: https://gitee.com/zhuige_com/jiangqie_ow_free
 * License：GPL-2.0
 * Copyright © 2021-2024 www.zhuige.com All rights reserved.
 */

class Jiangqie_Ow_Free_Public
{

	private $jiangqie_ow_free;

	private $version;

	public function __construct($jiangqie_ow_free, $version)
	{
		$this->jiangqie_ow_free = $jiangqie_ow_free;
		$this->version = $version;
	}

	public function plugin_init()
	{
		$token = '';
		if (isset($_GET['token'])) {
			$token = sanitize_text_field(wp_unslash($_GET['token']));
		} else if (isset($_POST['token'])) {
			$token = sanitize_text_field(wp_unslash($_POST['token']));
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
		$user_id = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT user_id FROM `$table_usermeta` WHERE  meta_key='jiangqie_token' AND meta_value='%s'",
				$token
			)
		);

		if ($user_id) {
			wp_set_current_user($user_id);
		}
	}

	public function enqueue_styles()
	{
		wp_enqueue_style($this->jiangqie_ow_free, JIANGQIE_OW_FREE_BASE_URL . 'public/css/jiangqie-ow-free-public.css', array(), $this->version, 'all');
	}

	public function enqueue_scripts()
	{
		wp_enqueue_script($this->jiangqie_ow_free, JIANGQIE_OW_FREE_BASE_URL . 'public/js/jiangqie-ow-free-public.js', array('jquery'), $this->version, false);
	}
}
