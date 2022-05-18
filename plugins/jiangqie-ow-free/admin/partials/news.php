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

// 动态
CSF::createSection($prefix, array(
    'id'    => 'news',
    'title' => '动态设置',
    'icon'  => 'far fa-newspaper',
    'fields' => array(

        array(
            'id'          => 'news_top_cat',
            'type'        => 'select',
            'title'       => '顶部分类',
            'placeholder' => '选择分类',
            'options'     => 'categories',
            'chosen'      => true,
            'multiple'    => true,
            'sortable'    => true,
        ),

    )
));
