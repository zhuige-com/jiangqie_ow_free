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

// 首页设置
CSF::createSection($prefix, array(
    'id'    => 'home',
    'title' => '首页设置',
    'icon'  => 'fas fa-home',
    'fields' => array(

        array(
            'id'     => 'home_slide',
            'type'   => 'group',
            'title'  => '幻灯片',
            'fields' => array(
                array(
                    'id'       => 'link',
                    'type'     => 'text',
                    'title'    => '链接',
                    'default'  => 'https://www.zhuige.com',
                ),
                array(
                    'id'      => 'image',
                    'type'    => 'media',
                    'title'   => '图片',
                    'library' => 'image',
                ),
                array(
                    'id'    => 'switch',
                    'type'  => 'switcher',
                    'title' => '开启/停用',
                    'default' => '1'
                ),
            ),
        ),

        array(
            'id'     => 'home_nav',
            'type'   => 'group',
            'title'  => '导航项',
            'fields' => array(
                array(
                    'id'          => 'title',
                    'type'        => 'text',
                    'title'       => '标题',
                    'placeholder' => '标题'
                ),
                array(
                    'id'      => 'image',
                    'type'    => 'media',
                    'title'   => '图片',
                    'library' => 'image',
                ),
                array(
                    'id'       => 'link',
                    'type'     => 'text',
                    'title'    => '链接',
                    'default'  => 'https://www.zhuige.com',
                ),
                array(
                    'id'    => 'switch',
                    'type'  => 'switcher',
                    'title' => '开启/停用',
                    'default' => '1'
                ),
            ),
        ),

        array(
            'id'     => 'home_about',
            'type'   => 'fieldset',
            'title'  => '关于我们',
            'fields' => array(
                array(
                    'id'    => 'title',
                    'type'  => 'text',
                    'title' => '标题',
                ),
                array(
                    'id'    => 'content',
                    'type'  => 'wp_editor',
                    'title' => '内容',
                ),
                array(
                    'id'    => 'switch',
                    'type'  => 'switcher',
                    'title' => '开启/停用',
                    'default' => '1'
                ),
            ),
        ),

        array(
            'id'     => 'home_goods',
            'type'   => 'fieldset',
            'title'  => '产品服务',
            'fields' => array(
                array(
                    'id'    => 'title',
                    'type'  => 'text',
                    'title' => '标题',
                ),
                array(
                    'id'    => 'ids',
                    'type'  => 'text',
                    'title' => '文章ID',
                    'subtitle' => '英文逗号分隔',
                ),
                array(
                    'id'    => 'switch',
                    'type'  => 'switcher',
                    'title' => '开启/停用',
                    'default' => '1'
                ),
            ),
        ),

        array(
            'id'     => 'home_news',
            'type'   => 'fieldset',
            'title'  => '最新动态',
            'fields' => array(
                array(
                    'id'    => 'title',
                    'type'  => 'text',
                    'title' => '标题',
                ),

                array(
                    'id'    => 'count',
                    'type'  => 'number',
                    'title' => '显示数量',
                ),
                array(
                    'id'    => 'switch',
                    'type'  => 'switcher',
                    'title' => '开启/停用',
                    'default' => '1'
                ),
            ),
        ),

        array(
            'id'     => 'feedback',
            'type'   => 'fieldset',
            'title'  => '留言反馈',
            'fields' => array(
                array(
                    'id'    => 'title',
                    'type'  => 'text',
                    'title' => '标题',
                ),
                array(
                    'id'    => 'switch',
                    'type'  => 'switcher',
                    'title' => '开启/停用',
                    'default' => '1'
                ),
            ),
        ),

        array(
            'id'     => 'home_friends',
            'type'   => 'group',
            'title'  => '合作伙伴',
            'fields' => array(
                array(
                    'id'          => 'title',
                    'type'        => 'text',
                    'title'       => '标题',
                    'placeholder' => '标题'
                ),
                array(
                    'id'      => 'image',
                    'type'    => 'media',
                    'title'   => '图片',
                    'library' => 'image',
                ),
                array(
                    'id'       => 'link',
                    'type'     => 'text',
                    'title'    => '链接',
                    'default'  => 'https://www.zhuige.com',
                ),
                array(
                    'id'    => 'switch',
                    'type'  => 'switcher',
                    'title' => '开启/停用',
                    'default' => '1'
                ),
            ),
        ),

        array(
            'id'     => 'home_ad_pop',
            'type'   => 'fieldset',
            'title'  => '弹窗广告',
            'fields' => array(
                array(
                    'id'      => 'image',
                    'type'    => 'media',
                    'title'   => '图片',
                    'library' => 'image',
                ),
                array(
                    'id'       => 'link',
                    'type'     => 'text',
                    'title'    => '链接',
                    'default'  => 'https://www.zhuige.com',
                ),
                array(
                    'id'    => 'switch',
                    'type'  => 'switcher',
                    'title' => '开启/停用',
                    'default' => '1'
                ),
                array(
                    'id'    => 'interval',
                    'type'  => 'number',
                    'title' => '间隔时间',
                    'subtitle' => '单位（小时）',
                ),
            ),
        ),
    )
));
