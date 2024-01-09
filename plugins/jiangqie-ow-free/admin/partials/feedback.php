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

// 意见反馈
CSF::createSection($prefix, array(
    'id'    => 'other',
    'title' => '意见反馈',
    'icon'  => 'fab fa-rocketchat',
    'fields' => array(

        array(
            'id'      => 'feedback_background',
            'type'    => 'media',
            'title'   => '背景',
            'library' => 'image',
        ),

        array(
            'id'       => 'feedback_link',
            'type'     => 'text',
            'title'    => '链接',
            'default'  => 'https://www.zhuige.com',
        ),
    )
));
