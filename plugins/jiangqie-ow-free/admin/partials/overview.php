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

$content = '酱茄企业官网Free';
$res = wp_remote_get("https://key.jiangqie.com/api/goods/description?id=jq_xcx_ow_free", ['timeout' => 1]);
if (!is_wp_error($res) && $res['response']['code'] == 200) {
    $data = json_decode($res['body'], TRUE);
    if ($data['code'] == 1) {
        $content = $data['data'];
    }
}

// 概要
CSF::createSection($prefix, array(
    'title'  => '概要',
    'icon'   => 'fas fa-rocket',
    'fields' => array(

        array(
            'type'    => 'content',
            'content' => $content,
        ),

    )
));
