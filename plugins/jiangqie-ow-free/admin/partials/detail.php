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

// 详情
CSF::createSection($prefix, array(
    'id'    => 'detail',
    'title' => '详情设置',
    'icon'  => 'fas fa-plus-circle',
    'fields' => array(

        array(
            'id'    => 'post_poster_switch',
            'type'  => 'switcher',
            'title' => '分享海报是否显示',
            'subtitle' => '停用/启用',
            'default' => '1'
        ),

        // array(
        //     'id'    => 'post_author_switch',
        //     'type'  => 'switcher',
        //     'title' => '作者信息是否显示',
        //     'subtitle' => '停用/启用',
        //     'default' => '1'
        // ),

        // array(
        //     'id'    => 'post_recs_switch',
        //     'type'  => 'switcher',
        //     'title' => '是否启用推荐文章',
        //     'subtitle' => '停用/启用',
        //     'default' => '1'
        // ),

        // array(
        //     'id'          => 'post_copyright',
        //     'type'        => 'text',
        //     'title'       => '文章底部版权',
        // ),
    )
));
