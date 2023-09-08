<?php

/**
 * Plugin Name:		酱茄企业官网Free
 * Plugin URI:		https://www.zhuige.com/docs/gwfree.html
 * Description:		让Wordpress快速变身企业官网小程序。
 * Version:			1.6.1
 * Author:			追格
 * Author URI:		https://www.zhuige.com/
 * License:			GPLv2 or later
 * License URI:		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain:		jiangqie-ow-free
 */

if (!defined('WPINC')) {
	die;
}

define('JIANGQIE_OW_FREE_VERSION', '1.6.1');
define('JIANGQIE_OW_FREE_BASE_DIR', plugin_dir_path(__FILE__));
define('JIANGQIE_OW_FREE_BASE_NAME', plugin_basename(__FILE__));
define('JIANGQIE_OW_FREE_BASE_URL', plugin_dir_url(__FILE__));

function activate_jiangqie_ow_free()
{
	require_once JIANGQIE_OW_FREE_BASE_DIR . 'includes/class-jiangqie-ow-free-activator.php';
	Jiangqie_Ow_Free_Activator::activate();
}

function deactivate_jiangqie_ow_free()
{
	require_once JIANGQIE_OW_FREE_BASE_DIR . 'includes/class-jiangqie-ow-free-deactivator.php';
	Jiangqie_Ow_Free_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_jiangqie_ow_free');
register_deactivation_hook(__FILE__, 'deactivate_jiangqie_ow_free');

function jiangqie_ow_free_action_links($actions)
{
	$actions[] = '<a href="admin.php?page=jiangqie-ow-free">设置</a>';
	$actions[] = '<a href="https://www.zhuige.com/docs/gwfree.html" target="_blank">技术支持</a>';
	return $actions;
}
add_filter('plugin_action_links_' . JIANGQIE_OW_FREE_BASE_NAME, 'jiangqie_ow_free_action_links');

require JIANGQIE_OW_FREE_BASE_DIR . 'includes/class-jiangqie-ow-free.php';
require JIANGQIE_OW_FREE_BASE_DIR . 'includes/zhuige-market.php';
require JIANGQIE_OW_FREE_BASE_DIR . 'includes/jiangqie-function.php';
require JIANGQIE_OW_FREE_BASE_DIR . 'includes/jiangqie-ow-free-dashboard.php';
require JIANGQIE_OW_FREE_BASE_DIR . 'includes/jiangqie-ow-free-feedback.php';

function run_jiangqie_ow_free()
{
	$plugin = new Jiangqie_Ow_Free();
	$plugin->run();
}
run_jiangqie_ow_free();
