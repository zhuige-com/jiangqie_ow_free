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

if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('WP_List_Table')) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

require dirname(__FILE__) . '/jiangqie-ow-free-feedback-list.php';

add_action('admin_menu', 'jiangqie_ow_free_add_menu_items_feedback');

function jiangqie_ow_free_add_menu_items_feedback()
{
	add_menu_page(
		'追格留言反馈', 					// Page title.
		'追格留言反馈',						// Menu title.
		'activate_plugins',					// Capability.
		'jiangqie_ow_free_feedback',				// Menu slug.
		'jiangqie_ow_free_render_feedback',		// Callback function.
		'dashicons-feedback',
		3
	);
}

function jiangqie_ow_free_render_feedback()
{
	$action = (isset($_GET['action'])) ? sanitize_text_field(wp_unslash($_GET['action'])) : '';

	if ($action == 'detail') {
		global $wpdb;

		$feedback_id = (isset($_GET['id'])) ? sanitize_text_field(wp_unslash($_GET['id'])) : '';

		if ($feedback_id) {
			$feedback = $wpdb->get_row(
				$wpdb->prepare(
					"SELECT * FROM {$wpdb->prefix}jiangqie_ow_feedback WHERE id=%d",
					$feedback_id
				),
				ARRAY_A
			);
?>
			<h1>留言信息</h1>
			<table class="form-table">
				<tr>
					<th><label>ID</label></th>
					<td><?php echo esc_html($feedback['id']); ?></td>
				</tr>
				<tr>
					<th><label>姓名</label></th>
					<td><?php echo esc_html($feedback['username']); ?></td>
				</tr>
				<tr>
					<th><label>电话</label></th>
					<td><?php echo esc_html($feedback['phone']); ?></td>
				</tr>
				<tr>
					<th><label>E-mail</label></th>
					<td><?php echo esc_html($feedback['email']); ?></td>
				</tr>
				<tr>
					<th><label for="content">内容</label></th>
					<td><textarea id="content" name="content" rows="5" cols="30" class="regular-text"><?php echo esc_textarea($feedback['content']); ?></textarea></td>
				</tr>
				<tr>
					<th><label>时间</label></th>
					<td><?php echo date('Y-m-d H:i:s', $feedback['createtime']); ?></td>
				</tr>
			</table>
		<?php
		}
	} else {
		if ($action == 'delete') {
			global $wpdb;

			$feedback_id = (isset($_GET['id'])) ? sanitize_text_field(wp_unslash($_GET['id'])) : '';

			if ($feedback_id) {
				$wpdb->delete($wpdb->prefix . 'jiangqie_ow_feedback', ['id' => $feedback_id], ['%d']);
			}
		}
		$owFeedbackList = new JiangQieOwFreeFeedbackList();

		$search = (isset($_GET['s'])) ? sanitize_text_field(wp_unslash($_GET['s'])) : '';

		$owFeedbackList->prepare_items($search);
		?>
		<div class="wrap">
			<h1><?php echo esc_html(get_admin_page_title()); ?></h1>

			<form method="get">
				<input type="hidden" name="page" value="<?php echo esc_html($_REQUEST['page']); ?>" />
				<?php $owFeedbackList->search_box('搜索', 'search_id'); ?>
			</form>

			<form id="movies-filter" method="get">
				<input type="hidden" name="page" value="<?php echo esc_html($_REQUEST['page']); ?>" />
				<?php $owFeedbackList->display() ?>
			</form>
		</div>
<?php
	}
}
