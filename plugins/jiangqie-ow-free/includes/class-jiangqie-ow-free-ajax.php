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

defined('ABSPATH') or die("Direct access to the script does not allowed");

class Jiangqie_Ow_Free_AJAX
{
    protected static $instance = null;

    private function __construct()
    {
        // Backend AJAX calls
        // if (current_user_can('manage_options')) {
        //     add_action('wp_ajax_admin_backend_call', array($this, 'ajax_backend_call'));
        // }

        // Frontend AJAX calls
        // add_action('wp_ajax_admin_frontend_call', array($this, 'ajax_frontend_call'));
        // add_action('wp_ajax_nopriv_frontend_call', array($this, 'ajax_frontend_call'));

        add_action('wp_ajax_jqowfree_admin_zhuige_market', array($this, 'jqowfree_admin_zhuige_market'));
    }

    public static function get_instance()
    {
        // If the single instance hasn't been set, set it now.
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function ajax_backend_call()
    {
        // Security check
        check_ajax_referer('referer_id', 'nonce');

        $response = 'OK';
        // Send response in JSON format
        // wp_send_json( $response );
        // wp_send_json_error();
        wp_send_json_success($response);

        die();
    }

    public function ajax_frontend_call()
    {
        // Security check
        check_ajax_referer('referer_id', 'nonce');

        $response = 'OK';
        // Send response in JSON format
        // wp_send_json( $response );
        // wp_send_json_error();
        wp_send_json_success($response);

        die();
    }

    public function jqowfree_admin_zhuige_market()
    {
        $action = isset($_POST["zgaction"]) ? sanitize_text_field(wp_unslash($_POST["zgaction"])) : '';

        if ($action == 'get_list') { // 查询产品
            $cat = isset($_POST["cat"]) ? (int)($_POST["cat"]) : 0;
            $params = [];
            if ($cat) {
                $params['cat'] = $cat;
            }

            $free = isset($_POST["free"]) ? sanitize_text_field($_POST["free"]) : '';
            if ($free !== '') {
                $params['free'] = $free;
            }

            $init = isset($_POST["init"]) ? (int)($_POST["init"]) : 0;
            if ($init == 1) {
                $params['init'] = $init;
            }

            $response = wp_remote_post("https://www.zhuige.com/api/market/list", array(
                'method'      => 'POST',
                'body'        => $params
            ));

            if (is_wp_error($response) || $response['response']['code'] != 200) {
                wp_send_json_error();
            }

            $data = json_decode($response['body'], TRUE);
            $datadata = $data['data'];

            if ($data['code'] == 1) {
                wp_send_json_success($datadata);
            } else {
                wp_send_json_error();
            }
        }

        die;
    }
}

Jiangqie_Ow_Free_AJAX::get_instance();
