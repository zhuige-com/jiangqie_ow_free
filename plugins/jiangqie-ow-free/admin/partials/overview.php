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

$content = '欢迎使用追格企业官网Free小程序! <br/><br/> 微信客服：jianbing2011 (加开源群、问题咨询、项目定制、购买咨询) <br/><br/> <a href="https://www.zhuige.com/download.html" target="_blank">更多免费产品</a>';
if (stripos($_SERVER["REQUEST_URI"], 'jiangqie-ow-free')) {
    $res = wp_remote_get("https://www.zhuige.com/api/ad/wordpress?id=jq_xcx_ow_free", ['timeout' => 1]);
    if (!is_wp_error($res) && $res['response']['code'] == 200) {
        $data = json_decode($res['body'], TRUE);
        if ($data['code'] == 1) {
            $content = $data['data'];
        }
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
