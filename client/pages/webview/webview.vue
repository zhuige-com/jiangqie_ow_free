<template>
	<view>
		<web-view :src="src"></web-view>
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
	 * Copyright © 2021-2022 www.zhuige.com All rights reserved.
	 */
	
	export default {
		data() {
			return {
				src: 'https://www.zhuige.com/'
			};
		},

		onLoad(options) {
			if (options.src) {
				this.src = decodeURIComponent(options.src);
			}
			uni.setNavigationBarTitle({
				title: getApp().globalData.appName
			})
		},

		onShareAppMessage() {
			return {
				title: getApp().globalData.appName,
				path: 'pages/mix/webview/webview?src=' + encodeURIComponent(this.src)
			};
		},

		onShareTimeline() {
			return {
				title: getApp().globalData.appName
			};
		},
	}
</script>

<style lang="scss" scoped>

</style>
