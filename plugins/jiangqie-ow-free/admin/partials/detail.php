<?php

/*
 * 酱茄企业官网Free
 * Author: 酱茄
 * Help document: https://www.zhuige.com/docs/gwfree.html
 * github: https://github.com/zhuige-com/jiangqie_ow_free
 * gitee: https://gitee.com/zhuige_com/jiangqie_ow_free
 * License：GPL-2.0
 * Copyright © 2021-2022 www.jiangqie.com All rights reserved.
 */

// 详情
CSF::createSection($prefix, array(
    'id'    => 'detail',
    'title' => '详情设置',
    'icon'  => 'fas fa-file-alt',
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
