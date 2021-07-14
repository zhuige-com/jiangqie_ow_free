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

class Jiangqie_Ow_Free
{

	//分页 每页数量
	const POSTS_PER_PAGE = 10;

	protected $loader;

	protected $jiangqie_ow_free;

	protected $version;

	public $admin;
	public $public;
	public $main;

	/**
	 * 获取配置
	 */
	public static function option_value($key, $default = '')
	{
		static $options = false;
		if (!$options) {
			$options = get_option('jiangqie-ow-free');
		}
		
		if (isset($options[$key]) && !empty($options[$key])) {
			return $options[$key];
		}

		return $default;
	}

	/**
	 * 图片配置项url
	 */
	public static function option_image_url($image, $default = '')
	{
		if ($image && isset($image['url']) && $image['url']) {
			return $image['url'];
		} else {
			if ($default) {
				return plugins_url('public/images/' . $default, dirname(__FILE__));
			} else {
				return $default;
			}
		}
	}

	/**
	 * 分类属性
	 */
	public static function cat_property($cat_id, $key, $default = '')
	{
		$options = get_term_meta($cat_id, 'jiangqie-ow-free-category', true);
		if (isset($options[$key]) && !empty($options[$key])) {
			return $options[$key];
		}

		return $default;
	}

	/**
	 * 微信 token
	 */
	public static function get_wx_token()
	{
		$path_token = JIANGQIE_OW_FREE_BASE_DIR . 'wx_access_token.data';
		if (file_exists($path_token)) {
			$str_token = file_get_contents($path_token);
			$access_token = json_decode($str_token, TRUE);
			if ($access_token['expires_in'] > time()) {
				return $access_token;
			}
		}

		$wechat = Jiangqie_Ow_Free::option_value('basic_wechat');
		$app_id = '';
		$app_secret = '';
		if ($wechat) {
			$app_id = $wechat['appid'];
			$app_secret = $wechat['secret'];
		}

		if (empty($app_id) || empty($app_secret)) {
			return false;
		}

		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$app_id&secret=$app_secret";
		$body = wp_remote_get($url);
		if (!is_array($body) || is_wp_error($body) || $body['response']['code'] != '200') {
			return false;
		}
		$access_token = json_decode($body['body'], TRUE);

		$access_token['expires_in'] = $access_token['expires_in'] + time() - 200;
		file_put_contents($path_token, json_encode($access_token));

		return $access_token;
	}

	/**
	 * QQ token
	 */
	public static function get_qq_token()
	{
		$path_token = JIANGQIE_OW_FREE_BASE_DIR . 'qq_access_token.data';
		if (file_exists($path_token)) {
			$str_token = file_get_contents($path_token);
			$access_token = json_decode($str_token, TRUE);
			if ($access_token['expires_in'] > time()) {
				return $access_token;
			}
		}

		$qq = Jiangqie_Ow_Free::option_value('basic_qq');
		$app_id = '';
		$app_secret = '';
		if ($qq) {
			$app_id = $qq['appid'];
			$app_secret = $qq['secret'];
		}

		if (empty($app_id) || empty($app_secret)) {
			return false;
		}

		$url = "https://api.q.qq.com/api/getToken?grant_type=client_credential&appid=$app_id&secret=$app_secret";
		$body = wp_remote_get($url);
		if (!is_array($body) || is_wp_error($body) || $body['response']['code'] != '200') {
			return false;
		}
		$access_token = json_decode($body['body'], TRUE);

		$access_token['expires_in'] = $access_token['expires_in'] + time() - 200;
		file_put_contents($path_token, json_encode($access_token));

		return $access_token;
	}

	/**
	 * 百度 token
	 */
	public static function get_bd_token()
	{
		$path_token = JIANGQIE_OW_FREE_BASE_DIR . 'bd_access_token.data';
		if (file_exists($path_token)) {
			$str_token = file_get_contents($path_token);
			$access_token = json_decode($str_token, TRUE);
			if ($access_token['expires_in'] > time()) {
				return $access_token;
			}
		}

		$baidu = Jiangqie_Ow_Free::option_value('basic_baidu');
		$app_id = '';
		$app_secret = '';
		if ($baidu) {
			$app_id = $baidu['appid'];
			$app_secret = $baidu['secret'];
		}

		if (empty($app_id) || empty($app_secret)) {
			return false;
		}

		$url = "https://openapi.baidu.com/oauth/2.0/token?grant_type=client_credentials&client_id=$app_id&client_secret=$app_secret&scope=smartapp_snsapi_base
		";
		$body = wp_remote_get($url);
		if (!is_array($body) || is_wp_error($body) || $body['response']['code'] != '200') {
			return false;
		}
		$access_token = json_decode($body['body'], TRUE);

		$access_token['expires_in'] = $access_token['expires_in'] + time() - 200;
		file_put_contents($path_token, json_encode($access_token));

		return $access_token;
	}

	public function __construct()
	{
		if (defined('JIANGQIE_OW_FREE_VERSION')) {
			$this->version = JIANGQIE_OW_FREE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->jiangqie_ow_free = 'jiangqie-ow-free';

		$this->main = $this;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	private function load_dependencies()
	{
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-jiangqie-ow-free-loader.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-jiangqie-ow-free-i18n.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-jiangqie-ow-free-admin.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-jiangqie-ow-free-public.php';

		/**
		 * rest api
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/rest/class-jiangqie-ow-free-base-controller.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/rest/class-jiangqie-ow-free-setting-controller.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/rest/class-jiangqie-ow-free-post-controller.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/rest/class-jiangqie-ow-free-user-controller.php';

		/**
		 * 后台管理
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/codestar-framework/codestar-framework.php';

		$this->loader = new Jiangqie_Ow_Free_Loader();
	}

	private function set_locale()
	{
		$plugin_i18n = new Jiangqie_Ow_Free_i18n();
		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}

	private function define_admin_hooks()
	{
		if (!is_admin()) {
			return;
		}

		$this->admin = new Jiangqie_Ow_Free_Admin($this->get_jiangqie_ow_free(), $this->get_version());

		$this->loader->add_action('admin_enqueue_scripts', $this->admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $this->admin, 'enqueue_scripts');

		$this->loader->add_action('init', $this->admin, 'create_menu', 0);
		$this->loader->add_action('admin_init', $this->admin, 'admin_init');
		$this->loader->add_action('admin_menu', $this->admin, 'admin_menu', 20);
	}

	private function define_public_hooks()
	{
		$this->public = new Jiangqie_Ow_Free_Public($this->get_jiangqie_ow_free(), $this->get_version());

		$this->loader->add_action('init', $this->public, 'plugin_init');

		$this->loader->add_action('wp_enqueue_scripts', $this->public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $this->public, 'enqueue_scripts');

		$controller = [
			new Jiangqie_Ow_Free_Setting_Controller(),
			new Jiangqie_Ow_Free_Post_Controller(),
			new Jiangqie_Ow_Free_User_Controller(),
		];
		foreach ($controller as $control) {
			$this->loader->add_action('rest_api_init', $control, 'register_routes');
		}
	}

	public function run()
	{
		$this->loader->run();
	}

	public function get_jiangqie_ow_free()
	{
		return $this->jiangqie_ow_free;
	}

	public function get_loader()
	{
		return $this->loader;
	}

	public function get_version()
	{
		return $this->version;
	}
}
