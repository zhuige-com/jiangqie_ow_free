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

class Jiangqie_Ow_Free_Admin
{
	private $jiangqie_ow_free;

	private $version;

	public function __construct($jiangqie_ow_free, $version)
	{
		$this->jiangqie_ow_free = $jiangqie_ow_free;
		$this->version = $version;
	}

	public function enqueue_styles()
	{
		wp_enqueue_style($this->jiangqie_ow_free, plugin_dir_url(__FILE__) . 'css/jiangqie-ow-free-admin.css', array(), $this->version, 'all');
	}

	public function enqueue_scripts()
	{
		wp_enqueue_script($this->jiangqie_ow_free, plugin_dir_url(__FILE__) . 'js/jiangqie-ow-free-admin.js', array('jquery'), $this->version, false);
	}

	public function create_menu()
	{
		$prefix = 'jiangqie-ow-free';

		CSF::createOptions($prefix, array(
			'framework_title' => '酱茄企业官网Free <small>by <a href="https://www.jiangqie.com" target="_blank" title="酱茄企业官网Free">www.jiangqie.com</a></small>',
			'menu_title' => '酱茄企业官网Free',
			'menu_slug'  => 'jiangqie-ow-free',
			'menu_position' => 2,
			'footer_credit' => 'Thank you for creating with <a href="https://www.jiangqie.com/" target="_blank">酱茄</a>',
		));

		$base_dir = plugin_dir_path(__FILE__);
		$base_url = plugin_dir_url(__FILE__);
		require_once $base_dir . 'partials/overview.php';
		require_once $base_dir . 'partials/global.php';
		require_once $base_dir . 'partials/home.php';
		require_once $base_dir . 'partials/other.php';
		require_once $base_dir . 'partials/detail.php';
	}

	public function admin_init()
	{
        $this->handle_external_redirects();
    }

    public function admin_menu()
	{
        add_submenu_page('jiangqie-ow-free', '', '安装文档', 'manage_options', 'jiangqie_ow_free_setup', array( &$this, 'handle_external_redirects' ) );
        add_submenu_page('jiangqie-ow-free', '', '新版下载', 'manage_options', 'jiangqie_ow_free_upgrade', array( &$this, 'handle_external_redirects' ) );
    }

    public function handle_external_redirects()
    {
      if (empty($_GET['page'])) {
        return;
      }

      if ('jiangqie_ow_free_setup' === $_GET['page']) {
        wp_redirect('https://www.jiangqie.com/owfree/7713.html');
        die;
      }

      if ('jiangqie_ow_free_upgrade' === $_GET['page']) {
        wp_redirect('https://www.jiangqie.com/owfree/7685.html');
        die;
      }
    }
}
