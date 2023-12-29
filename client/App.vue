<script>
	/*
	 * 酱茄企业官网Free v1.6.8
	 * 作者: 追格
	 * 文档: https://www.zhuige.com/docs/gwfree.html
	 * github: https://github.com/zhuige-com/jiangqie_ow_free
	 * gitee: https://gitee.com/zhuige_com/jiangqie_ow_free
	 * License：GPL-2.0
	 * Copyright © 2021-2023 www.zhuige.com All rights reserved.
	 */
	
	// 收集你的昵称、头像
	// 使用你的相册（仅写入）权限
	// 读取你的剪切板

	export default {
		globalData: {
			appName: '',
			appDesc: '',
			appKeyword: '',

			shareTitle: undefined,
			shareThumb: undefined,
		},

		onLaunch() {
			const updateManager = wx.getUpdateManager()
			updateManager.onCheckForUpdate(function(res) {
				// 请求完新版本信息的回调
				// console.log(res.hasUpdate)
			})
			updateManager.onUpdateReady(function() {
				wx.showModal({
					title: '更新提示',
					content: '新版本已经准备好，是否重启应用？',
					success: function(res) {
						if (res.confirm) {
							// 新的版本已经下载好，调用 applyUpdate 应用新版本并重启
							updateManager.applyUpdate()
						}
					}
				})
			})
			updateManager.onUpdateFailed(function() {
				// 新版本下载失败
			})
		},

		onShow() {

		},

		onHide() {

		}
	}
</script>

<style>
	/*每个页面公共css */
	@import "style/main.css";
</style>