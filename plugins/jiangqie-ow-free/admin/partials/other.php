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

// 其他设置
CSF::createSection($prefix, array(
    'id'    => 'other',
    'title' => '其他设置',
    'icon'  => 'fas fa-plus-circle',
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
