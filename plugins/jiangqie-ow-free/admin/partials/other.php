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

// 其他设置
CSF::createSection($prefix, array(
    'id'    => 'other',
    'title' => '其他设置',
    'icon'  => 'fas fa-mouse',
    'fields' => array(
        array(
            'id'          => 'other_phone_number',
            'type'        => 'text',
            'title'       => '右侧电话',
            'placeholder' => '右侧电话'
        ),

        array(
            'id'    => 'other_phone_switch',
            'type'  => 'switcher',
            'title' => '开启/停用',
            'label' => '右侧电话',
            'default' => '1'
        ),

        array(
            'id'    => 'other_contact_switch',
            'type'  => 'switcher',
            'title' => '开启/停用',
            'label' => '右侧客服',
            'default' => '1'
        ),

        array(
            'id'    => 'other_feedback_switch',
            'type'  => 'switcher',
            'title' => '开启/停用',
            'label' => '右侧反馈',
            'default' => '1'
        ),
    )
));
