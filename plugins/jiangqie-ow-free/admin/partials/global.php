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

// 基础设置
CSF::createSection($prefix, array(
    'id'    => 'basic',
    'title' => '基础设置',
    'icon'  => 'fas fa-cubes',
    'fields' => array(

        array(
            'id'          => 'basic_title',
            'type'        => 'text',
            'title'       => '标题',
            'placeholder' => '标题'
        ),

        array(
            'id'          => 'basic_keywords',
            'type'        => 'text',
            'title'       => '关键字',
            'subtitle'    => '仅百度小程序使用',
            'placeholder' => '关键字'
        ),

        array(
            'id'          => 'basic_desc',
            'type'        => 'text',
            'title'       => '描述',
            'placeholder' => '描述'
        ),

        array(
            'id'     => 'basic_wechat',
            'type'   => 'fieldset',
            'title'  => '微信小程序',
            'fields' => array(
                array(
                    'id'    => 'appid',
                    'type'  => 'text',
                    'title' => 'App ID',
                ),
                array(
                    'id'    => 'secret',
                    'type'  => 'text',
                    'title' => 'App Secret',
                ),
            ),
        ),

        array(
            'id'     => 'basic_baidu',
            'type'   => 'fieldset',
            'title'  => '百度小程序',
            'fields' => array(
                array(
                    'id'    => 'appid',
                    'type'  => 'text',
                    'title' => 'App Key',
                ),
                array(
                    'id'    => 'secret',
                    'type'  => 'text',
                    'title' => 'App Secret',
                ),
            ),
        ),

        array(
            'id'     => 'basic_qq',
            'type'   => 'fieldset',
            'title'  => 'QQ小程序',
            'fields' => array(
                array(
                    'id'    => 'appid',
                    'type'  => 'text',
                    'title' => 'App ID',
                ),
                array(
                    'id'    => 'secret',
                    'type'  => 'text',
                    'title' => 'App Secret',
                ),
            ),
        ),

        array(
            'id'      => 'home_thumb',
            'type'    => 'media',
            'title'   => '分享缩略图',
            'library' => 'image',
        ),
        
        array(
            'id'    => 'jiangqie_xcx_img2attachment',
            'type'  => 'switcher',
            'title' => '小程序码导入媒体库',
            'subtitle' => '使用七牛/阿里/腾讯OSS的需要开启',
            'default' => ''
        ),
    )
));
