const Config = require("@/utils/config");

function makeURL(module, action) {
	return `https://${Config.JQ_DOMAIN}/wp-json/jq-ow-free/${module}/${action}`;
}

module.exports = {
	
	// ---------- 资讯 ----------
	
	/**
	 * 获取最新文章列表
	 */
	JQ_OW_FREE_POSTS_LAST: makeURL('posts', 'last'),
	
	/**
	 * 获取文章详情
	 */
	JQ_OW_FREE_POST_DETAIL: makeURL('posts', 'detail'),
	
	/**
	 * 获取微信二维码
	 */
	JQ_OW_FREE_POST_WX_ACODE: makeURL('posts', 'wxacode'),
	
	/**
	 * 获取QQ二维码
	 */
	JQ_OW_FREE_POST_QQ_ACODE: makeURL('posts', 'qqacode'),
	
	/**
	 * 获取百度二维码
	 */
	JQ_OW_FREE_POST_BD_ACODE: makeURL('posts', 'bdacode'),
	
	// ---------- 配置 ----------
	
	/**
	 * 获取首页配置
	 */
	JQ_OW_FREE_SETTING_HOME: makeURL('setting', 'home'),
	
	/**
	 * 获取详情配置
	 */
	JQ_OW_FREE_SETTING_DETAIL: makeURL('setting', 'detail'),
	
	/**
	 * 留言反馈
	 */
	JQ_OW_FREE_SETTING_FEEDBACK: makeURL('setting', 'feedback'),
	
	/**
	 * 新闻动态
	 */
	JQ_OW_FREE_SETTING_NEWS: makeURL('setting', 'news'),
	
	// ---------- 用户 ----------
	
	/**
	 * 留言反馈
	 */
	JQ_OW_FREE_USER_FEEDBACK: makeURL('user', 'feedback'),
	
};
