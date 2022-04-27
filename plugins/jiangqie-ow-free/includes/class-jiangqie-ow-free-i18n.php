<?php

/*
 * 酱茄企业官网Free
 * Author: 酱茄
 * Help document: https://www.jiangqie.com/owfree/7685.html
 * github: https://github.com/longwenjunjie/jiangqie_ow_free
 * gitee: https://gitee.com/longwenjunj/jiangqie_ow_free
 * License：GPL-2.0
 * Copyright © 2021-2022 www.jiangqie.com All rights reserved.
 */

class Jiangqie_Ow_Free_i18n
{
	public function load_plugin_textdomain()
	{
		load_plugin_textdomain(
			'jiangqie-ow-free',
			false,
			dirname(JIANGQIE_OW_FREE_BASE_NAME) . '/languages/'
		);
	}
}
