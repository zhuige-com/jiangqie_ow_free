<template>
	<view>
		<web-view :src="src"></web-view>
	</view>
</template>

<script>
	/*
	 * 酱茄企业官网Free
	 * Author: 酱茄
	 * Help document: https://www.jiangqie.com/owfree/7685.html
	 * github: https://github.com/longwenjunjie/jiangqie_ow_free
	 * gitee: https://gitee.com/longwenjunj/jiangqie_ow_free
	 * License：GPL-2.0
	 * Copyright © 2021 www.jiangqie.com All rights reserved.
	 */
	
	export default {
		data() {
			return {
				src: 'https://www.jiangqie.com/'
			};
		},

		onLoad(options) {
			if (options.src) {
				this.src = options.src;
			}
			uni.setNavigationBarTitle({
				title: getApp().appName
			})
		},

		onShareAppMessage() {
			return {
				title: getApp().appName,
				path: 'pages/mix/webview/webview?src=' + this.src
			};
		},

		onShareTimeline() {
			return {
				title: getApp().appName
			};
		},
	}
</script>

<style lang="scss">

</style>
