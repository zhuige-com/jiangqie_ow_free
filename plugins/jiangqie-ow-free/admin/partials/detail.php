<?php

/*
 * 酱茄企业官网Free
 * Author: 追格
 * Help document: https://www.zhuige.com/docs/gwfree.html
 * github: https://github.com/zhuige-com/jiangqie_ow_free
 * gitee: https://gitee.com/zhuige_com/jiangqie_ow_free
 * License：GPL-2.0
 * Copyright © 2021-2023 www.zhuige.com All rights reserved.
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

    )
));
