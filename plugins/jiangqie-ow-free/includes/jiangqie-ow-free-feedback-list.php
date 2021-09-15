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

class JiangQieOwFreeFeedbackList extends WP_List_Table
{
	protected $jq_table_name;

	public function __construct()
	{
		parent::__construct(array(
			'singular' => '酱茄留言反馈',    // Singular name of the listed records.
			'plural'   => '酱茄留言反馈',    // Plural name of the listed records.
			'ajax'     => false,       		// Does this table support ajax?
		));

		global $wpdb;
		$this->jq_table_name = $wpdb->prefix . 'jiangqie_ow_feedback';
	}

	public function ajax_user_can()
	{
		return false;
	}

	public function prepare_items($search = null)
	{
		$columns  = $this->get_columns();
		$hidden   = array();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array($columns, $hidden, $sortable);

		$this->process_bulk_action();

		$per_page = 10;
		$current_page = $this->get_pagenum();
		$total_items  = $this->record_count($search);

		$this->items = $this->get_datas($per_page, $current_page, $search);

		$this->set_pagination_args(array(
			'total_items' => $total_items,
			'per_page'    => $per_page,
			'total_pages' => ceil($total_items / $per_page),
		));
	}

	public function get_columns()
	{
		$columns = array(
			'cb'            => '<input type="checkbox" />',
			'id'	        => '序号',
			'username'		=> '客户',
			'phone'			=> '电话',
			'email'   		=> '邮件',
			'createtime'	=> '时间',
		);

		return $columns;
	}

	protected function get_datas($per_page = 5, $page_number = 1, $search = null)
	{
		global $wpdb;

		$sql = "SELECT * FROM " . $this->jq_table_name;

		if ($search) {
			$sql .= " WHERE (`username` LIKE '%$search%' OR  `phone` LIKE '%$search%' OR  `email` LIKE '%$search%') ";
		}

		if (!empty($_REQUEST['orderby'])) {
			$sql .= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
			$sql .= isset($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
		} else {
			$sql .= ' ORDER BY id ASC';
		}

		$sql .= " LIMIT $per_page";
		$sql .= ' OFFSET ' . ($page_number - 1) * $per_page;


		$result = $wpdb->get_results($sql, 'ARRAY_A');

		return $result;
	}

	protected function get_sortable_columns()
	{
		$sortable_columns = array(
			'id'			=> array('id', false),
			'createtime'	=> array('createtime', false),
		);

		return $sortable_columns;
	}

	protected function column_default($item, $column_name)
	{
		switch ($column_name) {
			case 'id':
			case 'username':
			case 'phone':
			case 'email':
				return $item[$column_name];
			default:
				return print_r($item, true); // Show the whole array for troubleshooting purposes.
		}
	}

	protected function column_cb($item)
	{
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			'ids',
			$item['id']
		);
	}

	protected function column_username($item)
	{
		$page = (isset($_REQUEST['page'])) ? sanitize_text_field(wp_unslash($_REQUEST['page'])) : '';

		// Build edit row action.
		$edit_query_args = array('page' => $page, 'action' => 'detail', 'id'  => $item['id']);
		$actions['detail'] = sprintf(
			'<a href="%1$s">%2$s</a>',
			esc_url(wp_nonce_url(add_query_arg($edit_query_args, 'admin.php'), 'detail_' . $item['id'])),
			'详情'
		);

		// Build delete row action.
		$delete_query_args = array('page' => $page, 'action' => 'delete', 'id'  => $item['id']);
		$actions['delete'] = sprintf(
			'<a href="%1$s">%2$s</a>',
			esc_url(wp_nonce_url(add_query_arg($delete_query_args, 'admin.php'), 'delete_' . $item['id'])),
			'删除'
		);

		// Return the title contents.
		return sprintf(
			'%1$s <span style="color:silver;">(id:%2$s)</span>%3$s',
			$item['username'],
			$item['id'],
			$this->row_actions($actions)
		);
	}

	protected function column_createtime($item)
	{
		return date('Y-m-d H:i:s', $item['createtime']);
	}

	protected function get_bulk_actions()
	{
		$actions = array(
			'bulk_delete' => '删除',
		);

		return $actions;
	}

	protected function process_bulk_action()
	{
		$action = (isset($_GET['action'])) ? sanitize_text_field(wp_unslash($_GET['action'])) : '';

		if ('bulk_delete' == $action) {
			$cat_ids = (isset($_GET['ids'])) ? wp_unslash($_GET['ids']) : '';
			if (is_array($cat_ids ) && !empty($cat_ids)) {
				global $wpdb;
				$table_ow_feedback = $wpdb->prefix . 'jiangqie_ow_feedback';
				$cat_ids = esc_sql(implode(',', $cat_ids));
				$wpdb->query("DELETE FROM $table_ow_feedback WHERE id IN ($cat_ids)");
			}
		}
	}

	protected function usort_reorder($a, $b)
	{
		$orderby = (isset($_REQUEST['orderby'])) ? sanitize_text_field(wp_unslash($_REQUEST['orderby'])) : 'title';
		$order = (isset($_REQUEST['order'])) ? sanitize_text_field(wp_unslash($_REQUEST['order'])) : 'asc';
		$result = strcmp($a[$orderby], $b[$orderby]);

		return ('asc' === $order) ? $result : -$result;
	}

	protected function record_count($search = null)
	{
		global $wpdb;
		$sql = "SELECT COUNT(*) FROM " . $this->jq_table_name;
		if ($search) {
			$sql .= " WHERE (`username` LIKE '%$search%' OR  `phone` LIKE '%$search%' OR  `email` LIKE '%$search%') ";
		}
		return $wpdb->get_var($sql);
	}
}
