<?php

/**
 * Plugin Name:		酱茄企业官网Free
 * Plugin URI:		https://www.jiangqie.com/owfree/7685.html
 * Description:		让Wordpress快速变身企业官网小程序。
 * Version:			1.0.0
 * Author:			酱茄
 * Author URI:		https://www.jiangqie.com/
 * License:			GPLv2 or later
 * License URI:		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain:		jiangqie-ow-free
 */

if (!defined('WPINC')) {
	die;
}

define('JIANGQIE_OW_FREE_VERSION', '1.0.0');
define('JIANGQIE_OW_FREE_BASE_DIR', plugin_dir_path(__FILE__));

function activate_jiangqie_ow_free()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-jiangqie-ow-free-activator.php';
	Jiangqie_Ow_Free_Activator::activate();
}

function deactivate_jiangqie_ow_free()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-jiangqie-ow-free-deactivator.php';
	Jiangqie_Ow_Free_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_jiangqie_ow_free');
register_deactivation_hook(__FILE__, 'deactivate_jiangqie_ow_free');

require plugin_dir_path(__FILE__) . 'includes/class-jiangqie-ow-free.php';
require plugin_dir_path(__FILE__) . 'includes/jiangqie-function.php';
require plugin_dir_path(__FILE__) . 'includes/jiangqie-ow-free-feedback.php';

function run_jiangqie_ow_free()
{

	$plugin = new Jiangqie_Ow_Free();
	$plugin->run();
}
run_jiangqie_ow_free();
