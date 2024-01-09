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

class Jiangqie_Ow_Free_Setting_Controller extends Jiangqie_Ow_Free_Base_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->module = 'setting';
		$this->routes = [
			'home' => 'get_home',
			'news' => 'get_news',
			'guestbook' => 'get_guestbook',
			'detail' => 'get_detail',

			'feedback' => 'feedback',
		];
	}

	/**
	 * 获取配置 首页
	 */
	public function get_home($request)
	{
		//小程序名称
		$data['title'] = Jiangqie_Ow_Free::option_value('basic_title', '酱茄企业官网Free');

		//关键字
		$data['keywords'] = Jiangqie_Ow_Free::option_value('basic_keywords', '追格,酱茄');

		//描述
		$data['desc'] = Jiangqie_Ow_Free::option_value('basic_desc', '流水不争先,争的是滔滔不绝');

		// 幻灯片
		$slides_org = Jiangqie_Ow_Free::option_value('home_slide');
		$slides = [];
		if (is_array($slides_org)) {
			foreach ($slides_org as $item) {
				if ($item['switch'] && $item['image'] && $item['image']['url']) {
					$slides[] = [
						'image' => $item['image']['url'],
						'link' => $item['link'],
					];
				}
			}
		}
		$data['slides'] = $slides;


		//图标导航
		$icon_nav_org = Jiangqie_Ow_Free::option_value('home_nav');
		$icon_navs = [];
		if (is_array($icon_nav_org)) {
			foreach ($icon_nav_org as $item) {
				if ($item['switch'] && $item['image'] && $item['image']['url']) {
					$icon_navs[] = [
						'image' => $item['image']['url'],
						'link' => $item['link'],
						'title' => $item['title'],
					];
				}
			}
		}
		$data['icon_navs'] = $icon_navs;


		//关于我们
		$home_about = Jiangqie_Ow_Free::option_value('home_about');
		if ($home_about && $home_about['switch']) {
			$data['about'] = [
				'title' => $home_about['title'],
				'content' => apply_filters('the_content', $home_about['content'])
			];
		}


		//产品服务
		$home_goods = Jiangqie_Ow_Free::option_value('home_goods');
		if ($home_goods && $home_goods['switch']) {
			if (empty($home_goods['title'])) {
				$home_goods['title'] = '产品服务';
			}

			$goods_ids = $home_goods['ids'];
			$posts = [];
			if (!empty($goods_ids)) {
				$goods_ids = explode(',', $goods_ids);
				$args = [
					'post__in' => $goods_ids,
					'orderby' => 'post__in',
					'posts_per_page' => -1,
					'ignore_sticky_posts' => 1,
				];

				$query = new WP_Query();
				$result = $query->query($args);
				foreach ($result as $item) {
					$posts[] = [
						'id' => $item->ID,
						'title' => $item->post_title,
						'thumbnail' => $this->get_one_post_thumbnail($item->ID),
					];
				}
			}
			unset($home_goods['ids']);
			$home_goods['list'] = $posts;

			$data['goods_list'] = $home_goods;
		}


		//最新动态
		$home_news = Jiangqie_Ow_Free::option_value('home_news');
		if ($home_news && $home_news['switch']) {
			if (empty($home_news['title'])) {
				$home_news['title'] = '最新动态';
			}

			$count = (int)($home_news['count']);
			$posts = [];
			$args = [
				'posts_per_page' => $count ? $count : 1,
				'ignore_sticky_posts' => 1,
			];

			$query = new WP_Query();
			$result = $query->query($args);
			foreach ($result as $item) {
				$posts[] = [
					'id' => $item->ID,
					'title' => $item->post_title,
					'thumbnail' => $this->get_one_post_thumbnail($item->ID),
					'views' => (int) get_post_meta($item->ID, 'jiangqie_views', true),
					'time' => $this->time_beautify($item->post_date)
				];
			}
			$home_news['list'] = $posts;

			$data['news_list'] = $home_news;
		}


		//留言反馈
		$feedback = Jiangqie_Ow_Free::option_value('feedback');
		if ($feedback && $feedback['switch']) {
			// if (empty($feedback['title'])) {
			// 	$feedback['title'] = '留言反馈';
			// }

			// if ($feedback['background']['url']) {
			// 	$feedback['background'] = $feedback['background']['url'];
			// }
			$data['feedback'] = ['title' => (empty($feedback['title']) ? '留言反馈' : $feedback['title'])];
		}

		// 分享标题
		$data['share_title'] = Jiangqie_Ow_Free::option_value('home_title');

		//分享缩略图
		$home_thumb = Jiangqie_Ow_Free::option_value('home_thumb');
		if ($home_thumb && $home_thumb['url']) {
			$data['share_thumb'] = $home_thumb['url'];
		}


		//合作伙伴
		$friends_org = Jiangqie_Ow_Free::option_value('home_friends');
		$friends = [];
		if (is_array($friends_org)) {
			foreach ($friends_org as $item) {
				if ($item['switch'] && $item['image'] && $item['image']['url']) {
					$friends[] = [
						'image' => $item['image']['url'],
						'link' => $item['link'],
						'title' => $item['title'],
					];
				}
			}
		}
		$data['friends'] = $friends;

		$data['phone_switch'] = Jiangqie_Ow_Free::option_value('other_phone_switch') ? 1 : 0;
		$data['phone_number'] = Jiangqie_Ow_Free::option_value('other_phone_number');
		$data['contact_switch'] = Jiangqie_Ow_Free::option_value('other_contact_switch') ? 1 : 0;
		$data['feedback_switch'] = Jiangqie_Ow_Free::option_value('other_feedback_switch') ? 1 : 0;

		// 备案信息
		$beian_icp = Jiangqie_Ow_Free::option_value('beian_icp');
		if ($beian_icp && $beian_icp['switch']) {
			$data['beian_icp'] = [
				'sn' => $beian_icp['sn'],
				'link' => $beian_icp['link'],
			];
		}

		//弹框广告
		$home_ad_pop = Jiangqie_Ow_Free::option_value('home_ad_pop');
		if ($home_ad_pop && $home_ad_pop['switch'] && $home_ad_pop['image'] && $home_ad_pop['image']['url']) {
			$data['pop_ad'] = [
				'image' => $home_ad_pop['image']['url'],
				'link' => $home_ad_pop['link'],
				'interval' => $home_ad_pop['interval'],
			];
		}

		return $this->make_success($data);
	}

	/**
	 * 首页 - 动态
	 */
	public function get_news($request)
	{
		//顶部分类
		$cat_ids = Jiangqie_Ow_Free::option_value('news_top_cat');
		$args = ['hide_empty' => 0];
		if (!empty($cat_ids)) {
			$args['include'] = implode(',', $cat_ids);
		}

		$result = get_categories($args);

		$categories = [];
		foreach ($cat_ids as $cat_id) {
			foreach ($result as $item) {
				if ($cat_id == $item->term_id) {
					$categories[] = [
						'id' => $item->term_id,
						'name' => $item->name,
					];
					break;
				}
			}
		}

		$data['top_nav'] = $categories;

		return $this->make_success($data);
	}

	/**
	 * 首页 - 意见反馈
	 */
	public function get_guestbook($request)
	{
		return $this->make_success([]);
	}

	/**
	 * 详情
	 */
	public function get_detail($request)
	{
		$data['poster_switch'] = Jiangqie_Ow_Free::option_value('post_poster_switch') ? 1 : 0;

		return $this->make_success($data);
	}

	/**
	 * 留言反馈
	 */
	public function feedback($request)
	{
		// $feedback = Jiangqie_Ow_Free::option_value('feedback');
		// if ($feedback) {
		// 	if (empty($feedback['title'])) {
		// 		$feedback['title'] = '留言反馈';
		// 	}

		// 	if ($feedback['background']['url']) {
		// 		$feedback['background'] = $feedback['background']['url'];
		// 	}
		// } else {
		// 	$feedback = ['title' => '留言反馈'];
		// }

		$feedback = [];
		$feedback_background = Jiangqie_Ow_Free::option_value('feedback_background');
		if ($feedback_background && $feedback_background['url']) {
			$feedback['background'] = $feedback_background['url'];
		} else {
			$feedback['background'] = plugins_url('images/default_thumb.png', dirname(__FILE__));
		}
		$feedback['link'] = Jiangqie_Ow_Free::option_value('feedback_link');

		// 备案信息
		$beian_icp = Jiangqie_Ow_Free::option_value('beian_icp');
		if ($beian_icp && $beian_icp['switch']) {
			$feedback['beian_icp'] = [
				'sn' => $beian_icp['sn'],
				'link' => $beian_icp['link'],
			];
		}

		return $this->make_success($feedback);
	}
}
