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

function openLink(link) {
	if (!link) {
		return;
	}

	if (link.startsWith('/pages/')) {
		uni.navigateTo({
			url: link,
		});
	} else if (link.startsWith('https://') || link.startsWith('http://')) {
		uni.navigateTo({
			url: '/pages/webview/webview?src=' + link,
		});
	} else {
		// #ifdef MP-WEIXIN
		if (link.startsWith('plugin-private://wx2b03c6e691cd7370')) {
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
			}
			let params = {
				appId: appid,
				fail: res => {
					uni.setClipboardData({
						data: link
					});
				}
			};
			if (page != '') {
				params.path = page;
			}
		
			uni.navigateToMiniProgram(params);
			return;
		}
		// #endif

		// #ifdef H5
			Alert.toast(link);
		// #endif

		// #ifndef H5
		uni.setClipboardData({
			data: link
		});
		// #endif
	}
}

function jiangqie() {
	let os = undefined;
	// #ifdef MP-WEIXIN
	os = 'weixin';
	uni.navigateToMiniProgram({
		appId: 'wxb0b82c1a4e82a353'
	})
	// #endif
	
	// #ifdef MP-BAIDU
	os = 'baidu';
	uni.navigateToMiniProgram({
		appId: 'UBGY8eyZqGooUziDVAz27P0KuMWj0eR1'
	})
	// #endif
	
	// #ifdef MP-QQ
	os = 'qq';
	uni.navigateToMiniProgram({
		appId: '1111804134'
	})
	// #endif
	
	if (!os) {
		openLink('https://www.jiangqie.com');
	}
}

module.exports = {
	navigateBack,
	openLink,
	jiangqie,
};
