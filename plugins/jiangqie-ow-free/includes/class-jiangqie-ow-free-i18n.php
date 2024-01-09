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
