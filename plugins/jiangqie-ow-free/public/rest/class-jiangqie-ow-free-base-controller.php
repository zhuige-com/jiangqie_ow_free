<?php

/*
 * 追格企业官网Free
 * Author: 追格
 * Help document: https://www.zhuige.com/docs/gwfree.html
 * github: https://github.com/zhuige-com/jiangqie_ow_free
 * gitee: https://gitee.com/zhuige_com/jiangqie_ow_free
 * License：GPL-2.0
 * Copyright © 2021-2024 www.zhuige.com All rights reserved.
 */

class Jiangqie_Ow_Free_Base_Controller extends WP_REST_Controller
{
	public $routes = [];

	public function __construct()
	{
		$this->namespace = 'jq-ow-free';
	}

	public function register_routes()
	{
		foreach ($this->routes as $key => $value) {
			register_rest_route($this->namespace, '/' . $this->module . '/' . $key, [
				[
					'methods' => WP_REST_Server::CREATABLE,
					'callback' => [$this, $value]
				]
			]);
		}
	}

	//组合返回值
	public function make_response($code, $msg, $data = null)
	{
		$response = [
			'code' => $code,
			'msg' => $msg,
		];

		if ($data !== null) {
			$response['data'] = $data;
		}

		return $response;
	}

	//组合返回值 成功
	public function make_success($data = null)
	{
		return $this->make_response(0, '操作成功！', $data);
	}

	//组合返回值 失败
	public function make_error($msg = '', $code = 1)
	{
		return $this->make_response($code, $msg);
	}

	/**
	 * 分页参数
	 */
	public function params_paging()
	{
		return [
			'offset' => [
				'default' => 0,
				'description' => '起始位置',
				'type' => 'integer',
			]
		];
	}

	/**
	 * 获取参数的方便方法
	 */
	public function param_value($request, $param_name, $default_value = false)
	{
		if (isset($request[$param_name])) {
			return sanitize_text_field(wp_unslash($request[$param_name]));
		}

		return $default_value;
	}

	/**
	 * 美化时间格式
	 */
	public function time_beautify($time)
	{
		$origin_time = strtotime($time);
		return $this->time_stamp_beautify($origin_time);
	}

	/**
	 * 美化时间格式
	 */
	public function short_time_beautify($time)
	{
		$origin_time = strtotime($time);
		return $this->short_time_stamp_beautify($origin_time);
	}

	/**
	 * 美化时间戳
	 */
	public function time_stamp_beautify($time)
	{
		$dur = time() - $time;
		if ($dur < 60) {
			return '刚刚';
		} else if ($dur < 3600) {
			return floor($dur / 60) . '分钟前';
		} else if ($dur < 86400) {
			return floor($dur / 3600) . '小时前';
		} else if ($dur < 604800) { //7天内
			return floor($dur / 86400) . '天前';
		} else {
			return date("Y-m-d", $time);
		}
	}

	/**
	 * 美化时间戳
	 */
	public function short_time_stamp_beautify($time)
	{
		$dur = time() - $time;
		if ($dur < 60) {
			return '刚刚';
		} else if ($dur < 3600) {
			return floor($dur / 60) . '分钟前';
		} else if ($dur < 86400) {
			return floor($dur / 3600) . '小时前';
		} else if ($dur < 604800) { //7天内
			return floor($dur / 86400) . '天前';
		} else {
			return date("m-d", $time);
		}
	}

	/**
	 * 获取缩略图
	 */
	public function get_post_thumbnails($post_id, $default = true)
	{
		$thumbnails = [];
		if (has_post_thumbnail($post_id)) {
			$thumbnail_id = get_post_thumbnail_id($post_id);
			if ($thumbnail_id) {
				$attachment = wp_get_attachment_image_src($thumbnail_id, 'full');
				if ($attachment) {
					$thumbnails[] = $attachment[0];
				}
			}
		}

		$post = get_post($post_id);
		$post_content = $post->post_content;
		preg_match_all('|<img.*?src=[\'"](.*?)[\'"].*?>|i', do_shortcode($post_content), $matches);
		if ($matches && isset($matches[1])) {
			if (isset($matches[1][0])) {
				$thumbnails[] = $matches[1][0];
			}

			if (isset($matches[1][1])) {
				$thumbnails[] = $matches[1][1];
			}

			if (isset($matches[1][2]) && count($thumbnails) < 3) {
				$thumbnails[] = $matches[1][2];
			}
		}

		if (!empty($thumbnails)) {
			return $thumbnails;
		}

		if ($default) {
			$thumbnails[] = plugins_url('images/default_thumb.png', dirname(__FILE__));
		}

		return $thumbnails;
	}

	/**
	 * 获取一个缩略图
	 */
	public function get_one_post_thumbnail($post_id, $default = true)
	{
		if (has_post_thumbnail($post_id)) {
			$thumbnail_id = get_post_thumbnail_id($post_id);
			if ($thumbnail_id) {
				$attachment = wp_get_attachment_image_src($thumbnail_id, 'full');
				if ($attachment) {
					return $attachment[0];
				}
			}
		}

		$post = get_post($post_id);
		$post_content = $post->post_content;
		preg_match_all('|<img.*?src=[\'"](.*?)[\'"].*?>|i', do_shortcode($post_content), $matches);
		if ($matches && isset($matches[1]) && isset($matches[1][0])) {
			return $matches[1][0];
		}

		if ($default) {
			return plugins_url('images/default_thumb.png', dirname(__FILE__));
		}

		return '';
	}

	public function get_user_avatar($user_id)
	{
		$avatar = get_user_meta($user_id, 'jiangqie_avatar', true);
		if (empty($avatar)) {
			$avatar = plugins_url('images/default_avatar.jpg', dirname(__FILE__));
		}
		return $avatar;
	}

	/**
	 * 检查敏感内容
	 */
	public function msg_sec_check($content)
	{
		if (!isset($_REQUEST['os']) || (isset($_REQUEST['os']) && $_REQUEST['os'] != 'wx')) {
			return true;
		}

		$wx_session = Jiangqie_Ow_Free::get_wx_token();
		$access_token = $wx_session['access_token'];
		if (empty($access_token)) {
			return false;
		}

		$api = 'https://api.weixin.qq.com/wxa/msg_sec_check?access_token=' . $access_token;

		$args = array(
			'method'  => 'POST',
			'body' 	  => json_encode(['content' => $content], JSON_UNESCAPED_UNICODE),
			'headers' => array(
				'Content-Type' => 'application/json'
			),
			'cookies' => array()
		);

		$res = wp_remote_post($api, $args);
		if (is_wp_error($res)) {
			return true;
		}

		if ($res['response']['code'] == 200) {
			$body = json_decode($res['body'], TRUE);
			if ($body['errcode'] == 0) {
				return true;
			}
		}

		return false;
	}
}
