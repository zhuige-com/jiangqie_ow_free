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

class Jiangqie_Ow_Free_Activator
{
    public static function activate()
    {
        global $wpdb;

        $charset_collate = '';
        if (!empty($wpdb->charset)) {
            $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
        }

        if (!empty($wpdb->collate)) {
            $charset_collate .= " COLLATE {$wpdb->collate}";
        }

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        //官网 反馈
        $table_ow_feedback = $wpdb->prefix . 'jiangqie_ow_feedback';
        $sql = "CREATE TABLE IF NOT EXISTS `$table_ow_feedback` (
            `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
            `username` varchar(100) NOT NULL COMMENT '用户名',
            `phone` varchar(100) NOT NULL COMMENT '电话',
            `email` varchar(100) NOT NULL COMMENT 'E-mail',
            `content` text NOT NULL COMMENT '内容',
            `createtime` int(11) NOT NULL COMMENT '创建事件',
          PRIMARY KEY (`id`)
        ) $charset_collate;";
        dbDelta($sql);
    }
}
