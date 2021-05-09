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

class Jiangqie_Ow_Free_User_Controller extends Jiangqie_Ow_Free_Base_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->module = 'user';
		$this->routes = [
			'feedback' => 'feedback',
		];
	}

	/**
	 * 留言反馈
	 */
	public function feedback($request)
	{
		$username = $this->param_value($request, 'username', '');
		if (empty($username)) {
			return $this->make_error('姓名不可为空');
		}

		$phone = $this->param_value($request, 'phone', '');
		if (empty($phone)) {
			return $this->make_error('电话不可为空');
		}

		$email = $this->param_value($request, 'email', '');
		// if (empty($email)) {
		// 	return $this->make_error('邮箱不可为空');
		// }

		$content = $this->param_value($request, 'content', '');
		if (empty($content)) {
			return $this->make_error('内容不可为空');
		}

		if (!$this->msg_sec_check($username . $phone . $email . $content)) {
			return $this->make_error('请勿发布敏感信息');
		}

		global $wpdb;
		$table_ow_feedback = $wpdb->prefix . 'jiangqie_ow_feedback';
		$wpdb->insert($table_ow_feedback, [
			'username' => $username, 'phone' => $phone, 'email' => $email, 'content' => $content, 'createtime' => time()
		]);

		return $this->make_success('');
	}
}
