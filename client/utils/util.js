import Alert from '@/utils/alert';

function navigateBack() {
	uni.navigateBack({
		delta: 1,
		fail: function(res) {
			uni.switchTab({
				url: '/pages/index/index'
			});
		}
	});
}

/**
 *  把html转义成HTML实体字符
 * @param str
 * @returns {string}
 * @constructor
 */
function htmlEncode(str) {
	var s = "";
	if (str.length === 0) {
		return "";
	}
	s = str.replace(/&/g, "&amp;");
	s = s.replace(/</g, "&lt;");
	s = s.replace(/>/g, "&gt;");
	s = s.replace(/ /g, "&nbsp;");
	s = s.replace(/\'/g, "&#39;"); //IE下不支持实体名称
	s = s.replace(/\"/g, "&quot;");
	return s;
}

/**
 *  转义字符还原成html字符
 * @param str
 * @returns {string}
 * @constructor
 */
function htmlRestore(str) {
	var s = "";
	if (str.length === 0) {
		return "";
	}
	s = str.replace(/&amp;/g, "&");
	s = s.replace(/&lt;/g, "<");
	s = s.replace(/&gt;/g, ">");
	s = s.replace(/&nbsp;/g, " ");
	s = s.replace(/&#39;/g, "\'");
	s = s.replace(/&quot;/g, "\"");
	return s;
}

function openLink(link) {
	if (!link) {
		return;
	}
	
	if (link == 'wx82e6ae1175f264fa') {
		var plugin = requirePlugin("wxacommentplugin");
		plugin.openComment({
			success: (res) => {
				// console.log('plugin.openComment success', res)
				let lastTime = wx.getStorageSync('zhuige_comment_plugin_last_time');
				if (!lastTime) {
					lastTime = 0;
				}
				
				let now = new Date().getTime();
				let legal = ((now - lastTime) > 30 * 86400000);
				if (legal) {
					wx.setStorageSync('zhuige_comment_plugin_last_time', now)
				}
				
				uni.showToast({
					icon: 'none',
					title: (legal ? '感谢评价' : '您近期已评价过')
				});
			},
			fail: (res) => {
				// console.log('plugin.openComment fail', res)
				if (res.errCode != -3) {
					uni.showToast({
						icon: 'none',
						title: '评价功能暂不可用'
					});
				}
			}
		})
		return;
	}

	if (link.startsWith('/pages/')) {
		link = htmlRestore(link);
		uni.navigateTo({
			url: link,
		});
	} else if (link.startsWith('https://') || link.startsWith('http://')) {
		link = htmlRestore(link);
		uni.navigateTo({
			url: '/pages/webview/webview?src=' + encodeURIComponent(link),
		});
	} else {
		// #ifdef MP-WEIXIN
		if (link.startsWith('plugin-private://wx2b03c6e691cd7370')) {
			link = htmlRestore(link);
			uni.navigateTo({
				url: link
			})
			return;
		} else if (link.startsWith('appid:')) {
			let appid = '';
			let page = '';
			let index = link.indexOf(';page:');
			if (index < 0) {
				appid = link.substring('appid:'.length);
			} else {
				appid = link.substring('appid:'.length, index);
				page = link.substring(index + ';page:'.length);
				page = htmlRestore(page);
			}
			let params = {
				appId: appid,
				fail: res => {
					if (res.errMsg && res.errMsg.indexOf('cancel') < 0) {
						Alert.toast(res.errMsg)
					}
				}
			};
			if (page != '') {
				params.path = page;
			}

			uni.navigateToMiniProgram(params);
			return;
		} else if (link.startsWith('finder:')) {
			let finder = '';
			let feedId = '';
			let index = link.indexOf(';feedId:');
			if (index < 0) {
				finder = link.substring('finder:'.length);
			} else {
				finder = link.substring('finder:'.length, index);
				feedId = link.substring(index + ';feedId:'.length);
			}
			let params = {
				finderUserName: finder,
				fail: res => {
					if (res.errMsg && res.errMsg.indexOf('cancel') < 0) {
						Alert.toast(res.errMsg)
					}
				}
			};

			if (feedId != '') {
				params.feedId = feedId;
				wx.openChannelsActivity(params);
			} else {
				wx.openChannelsUserProfile(params);
			}

			return;
		}
		// #endif

		// #ifdef H5
		Alert.toast(link);
		// #endif

		// #ifndef H5
		uni.setClipboardData({
			data: link,
			fail: res => {
				if (res.errMsg && res.errMsg.indexOf('cancel') < 0) {
					Alert.toast(res.errMsg)
				}
			}
		});
		// #endif
	}
}

function jiangqie() {
	let os = undefined;
	// #ifdef MP-WEIXIN
	os = 'weixin';
	uni.navigateToMiniProgram({
		appId: 'wx589dff586a7c9b4f'
	})
	// #endif

	// #ifdef MP-BAIDU
	os = 'baidu';
	uni.navigateToMiniProgram({
		appId: 'UBGY8eyZqGooUziDVAz27P0KuMWj0eR1'
	})
	// #endif

	if (!os) {
		openLink('https://www.zhuige.com');
	}
}

/**
 * 是否弹窗
 */
function getPopAd(pop_ad, key) {
	if (!pop_ad) {
		return false;
	}

	let lastTime = wx.getStorageSync(key);
	if (!lastTime) {
		lastTime = 0;
	}

	let now = new Date().getTime();
	if ((now - lastTime) > pop_ad.interval * 3600000) {
		return pop_ad;
	}

	return false;
}

export default {
	navigateBack,
	openLink,
	jiangqie,
	getPopAd
};