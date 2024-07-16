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
		wp_enqueue_style($this->jiangqie_ow_free, JIANGQIE_OW_FREE_BASE_URL . 'admin/css/jiangqie-ow-free-admin.css', array(), $this->version, 'all');
	}

	public function enqueue_scripts()
	{
		wp_enqueue_script($this->jiangqie_ow_free, JIANGQIE_OW_FREE_BASE_URL . 'admin/js/jiangqie-ow-free-admin.js', array('jquery'), $this->version, false);
	}

	public function create_menu()
	{
		$prefix = 'jiangqie-ow-free';

		CSF::createOptions($prefix, array(
			'framework_title' => '追格企业官网Free <small>by <a href="https://www.zhuige.com" target="_blank" title="追格">www.zhuige.com</a></small>',
			'menu_title' => '追格企业官网Free',
			'menu_slug'  => 'jiangqie-ow-free',
			'menu_position' => 2,
			'show_bar_menu' => false,
            'show_sub_menu' => false,
			'footer_credit' => 'Thank you for creating with <a href="https://www.zhuige.com/" target="_blank">追格</a>',
			'menu_icon' => 'dashicons-layout',
		));

		$base_dir = plugin_dir_path(__FILE__);
		$base_url = plugin_dir_url(__FILE__);
		require_once $base_dir . 'partials/overview.php';
		require_once $base_dir . 'partials/global.php';
		require_once $base_dir . 'partials/home.php';
		require_once $base_dir . 'partials/news.php';
		require_once $base_dir . 'partials/feedback.php';
		require_once $base_dir . 'partials/detail.php';
		require_once $base_dir . 'partials/other.php';

		//
        // 备份
        //
        CSF::createSection($prefix, array(
            'title'       => '备份',
            'icon'        => 'fas fa-shield-alt',
            'fields'      => array(
                array(
                    'type' => 'backup',
                ),
            )
        ));

        //过滤ID - 修复多选情况下 ID丢失造成的bug
		function jiangqie_ow_free_sanitize_ids($ids, $type='') {
			if (!is_array($ids)) {
				return $ids;
			}

			$ids_n = [];
			foreach ($ids as $id) {
				if (($type=='cat' && get_category($id))) {
					$ids_n[] = $id;
				} else if ($type=='post' || $type=='page') {
					$post = get_post($id);
					if ($post && $post->post_status == 'publish') {
						$ids_n[] = $id;
					}
				}
			}
			return $ids_n;
		}

		function jiangqie_ow_free_save_before( &$data, $option ) {
			$data['news_top_cat'] = jiangqie_ow_free_sanitize_ids($data['news_top_cat'], 'cat');
			return $data;
		}
		add_filter( 'csf_jiangqie-ow-free_save', 'jiangqie_ow_free_save_before', 10, 2 );
	}

	public function admin_init()
	{
		$this->handle_external_redirects();
	}

	public function admin_menu()
	{
		add_submenu_page('jiangqie-ow-free', '', '安装文档', 'manage_options', 'jiangqie_ow_free_setup', array(&$this, 'handle_external_redirects'));
		add_submenu_page('jiangqie-ow-free', '', '新版下载', 'manage_options', 'jiangqie_ow_free_upgrade', array(&$this, 'handle_external_redirects'));
	}

	public function handle_external_redirects()
	{
		if (empty($_GET['page'])) {
			return;
		}

		if ('jiangqie_ow_free_setup' === $_GET['page']) {
			wp_redirect('https://www.zhuige.com/docs/gwfree.html');
			die;
		}

		if ('jiangqie_ow_free_upgrade' === $_GET['page']) {
			wp_redirect('https://www.zhuige.com/product/gwfree.html');
			die;
		}
	}
}
