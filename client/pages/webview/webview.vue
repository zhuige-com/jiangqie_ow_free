<template>
	<view>
		<web-view v-if="src" :src="src"></web-view>
	</view>
</template>

<script>
	/*
	 * 酱茄企业官网Free
	 * 作者: 追格
	 * 文档: https://www.zhuige.com/docs/gwfree.html
	 * github: https://github.com/zhuige-com/jiangqie_ow_free
	 * gitee: https://gitee.com/zhuige_com/jiangqie_ow_free
	 * License：GPL-2.0
	 * Copyright © 2021-2023 www.zhuige.com All rights reserved.
	 */

	export default {
		data() {
			return {
				src: ''
			};
		},

		onLoad(options) {
			if (!options.src) {
				uni.reLaunch({
					url: '/pages/index/index'
				})
				return;
			}
			
			this.src = decodeURIComponent(options.src);
			
			uni.setNavigationBarTitle({
				title: getApp().globalData.appName
			})
		},

		onShareAppMessage(options) {
			return {
				title: getApp().globalData.appName,
				path: 'pages/webview/webview?src=' + encodeURIComponent(options.webViewUrl)
			};
		}
	}
</script>

<style lang="scss" scoped>

</style>
