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

if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('WP_List_Table')) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

require dirname(__FILE__) . '/jiangqie-ow-free-feedback-list.php';

add_action('admin_menu', 'add_menu_items_ow_feedback');

function add_menu_items_ow_feedback()
{
	add_menu_page(
		'酱茄留言反馈', 					// Page title.
		'酱茄留言反馈',						// Menu title.
		'activate_plugins',					// Capability.
		'jiangqie_ow_feedback',				// Menu slug.
		'jiangqie_render_ow_feedback',		// Callback function.
		'',
		3
	);
}

function jiangqie_render_ow_feedback()
{
	$action  = $_GET['action'];
	if ($action == 'detail') {
		global $wpdb;
		$feedback_id = $_GET['id'];
		{
			$feedback = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}jiangqie_ow_feedback WHERE id=$feedback_id", ARRAY_A);
		?>
			<h1>留言信息</h1>
			<!-- <form method="post" enctype="multipart/form-data"> -->
				<table class="form-table">
					<tr>
						<th><label>ID</label></th>
						<td><?php echo $feedback['id']; ?></td>
					</tr>
					<tr>
						<th><label>姓名</label></th>
						<td><?php echo $feedback['username']; ?></td>
					</tr>
					<tr>
						<th><label>电话</label></th>
						<td><?php echo $feedback['phone']; ?></td>
					</tr>
					<tr>
						<th><label>E-mail</label></th>
						<td><?php echo $feedback['email']; ?></td>
					</tr>
					<tr>
						<th><label for="content">内容</label></th>
						<td><textarea id="content" name="content" rows="5" cols="30" class="regular-text"><?php echo $feedback['content']; ?></textarea></td>
					</tr>
					<tr>
						<th><label>时间</label></th>
						<td><?php echo date('Y-m-d H:i:s', $feedback['createtime']); ?></td>
					</tr>
				</table>
				<!-- <p class="submit">
					<input type="submit" name="submit" id="submit" class="button button-primary" value="更新">
				</p>
			</form> -->
		<?php
		}
	} else {
		if ($action == 'delete') {
			global $wpdb;
			$feedback_id = $_GET['id'];
			$wpdb->query("DELETE FROM {$wpdb->prefix}jiangqie_ow_feedback WHERE id=$feedback_id");
		}
		$owFeedbackList = new JiangQieOwFreeFeedbackList();
		$search = isset($_GET['s']) ? $_GET['s'] : '';
		$owFeedbackList->prepare_items($search);
		?>
		<div class="wrap">
			<h1><?php echo esc_html(get_admin_page_title()); ?></h1>

			<form method="get">
				<input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>" />
				<?php $owFeedbackList->search_box('搜索', 'search_id'); ?>
			</form>

			<form id="movies-filter" method="get">
				<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
				<?php $owFeedbackList->display() ?>
			</form>
		</div>
<?php
	}
}
