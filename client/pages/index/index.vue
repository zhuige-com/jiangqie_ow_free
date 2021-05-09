<template>
	<view class="content">
		<!-- 首页 -->
		<view :style="{'display':show_index == 0 ?'block':'none'}">
			<tab-home ref="home"></tab-home>
		</view>
		<!-- 发现 -->
		<view :style="{'display':show_index == 1 ?'block':'none'}">
			<tab-discovery ref="discovery"></tab-discovery>
		</view>
		<!-- 数据 -->
		<view :style="{'display':show_index == 2? 'block':'none'}">
			<tab-guestbook ref="guestbook"></tab-guestbook>
		</view>
		<!-- is_lhp判断是否为刘海屏在main.js里，好像uniapp有一个css变量获取刘海屏的安全区域 -->
		<view class="tabBar">
			<view class="tabBar_list">
				<view v-for="(item) in tab_nav_list" :key="item.id" class="tabBar_item" @tap="cut_index(item.id)">
					<image v-if="show_index == item.id" :src="item.icon_p">
					</image>
					<image v-else :src="item.icon"></image>
					<view :class="{'tabBar_name':true,'nav_active':show_index == item.id}">{{item.name}}</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	/*
	 * 酱茄企业官网Free v1.0.0
	 * Author: 酱茄
	 * Help document: https://www.jiangqie.com/owfree/7685.html
	 * github: https://github.com/longwenjunjie/jiangqie_ow_free
	 * gitee: https://gitee.com/longwenjunj/jiangqie_ow_free
	 * License：GPL-2.0
	 * Copyright © 2021 www.jiangqie.com All rights reserved.
	 */
	
	import Constant from '@/utils/constants';
	import Util from '@/utils/util';
	import Api from '@/utils/api';
	import Rest from '@/utils/rest';

	import tabHome from '@/components/tabbar/home.vue'
	import tabDiscovery from '@/components/tabbar/discovery.vue'
	import tabGuestbook from '@/components/tabbar/guestbook.vue'

	export default {
		components: {
			tabHome, //首页		0
			tabDiscovery, //发现	1
			tabGuestbook, //留言	2
		},

		data() {
			return {
				show_index: 0, //控制显示那个组件
				tab_nav_list: [{
					id: 0,
					name: '首页',
					icon: '../../static/tabbar/index.png',
					icon_p: '../../static/tabbar/index_p.png',
				}, {
					id: 1,
					name: '动态',
					icon: '../../static/tabbar/discover.png',
					icon_p: '../../static/tabbar/discover_p.png',
				}, {
					id: 2,
					name: '留言',
					icon: '../../static/tabbar/mine.png',
					icon_p: '../../static/tabbar/mine_p.png',
				}], //菜单列表
				// is_lhp: false
			}
		},

		onLoad() {
			// this.is_lhp = this.$is_bang
			this.$nextTick(() => {
				// 一定要等视图更新完再调用方法   -----------++++++++++++++++重要
				setTimeout(() => {
					this.$refs.home.jqOnShow() //初次加载第一个页面的请求数据
				}, 100)
			})

			// console.log("是否为刘海屏", this.is_lhp)

			uni.$on('feedback', (data) => {
				this.cut_index(2);
			})
		},

		onShareAppMessage() {
			let params = {
				title: getApp().appName
			};
			
			if (getApp().appThumb) {
				params.imageUrl = getApp().appThumb;
			}

			// #ifdef MP-WEIXIN || MP-BAIDU
				params.path = 'pages/index/index';
			// #endif
			
			// #ifdef MP-BAIDU
			params.content = getApp().appDesc;
			// #endif

			return params;
		},

		// #ifdef MP-WEIXIN
		onShareTimeline() {
			return {
				title: getApp().appName
			};
		},
		onAddToFavorites(res) {
			return {
				title: getApp().appName
			};
		},
		// #endif

		methods: {
			// 切换组件
			cut_index(type) {
				this.show_index = type
				if (this.show_index == 0) {
					this.$refs.home.jqOnShow()
				} else if (this.show_index == 1) {
					this.$refs.discovery.jqOnShow()
				} else if (this.show_index == 2) {
					this.$refs.guestbook.jqOnShow()
				}
			},

			onPullDownRefresh() {
				// uni.showToast({
				// 	title: `第${this.show_index+1}个页面的刷新`
				// })

				// setTimeout(function() {
				// 	uni.stopPullDownRefresh()
				// }, 2000)

				// console.log('下拉刷新四个组件公用的下拉刷新方法,根据在哪个页面下拉执行哪个页面的刷新方方法即可')
				// console.log('如果想要自定义刷新的话，插件市场就有一个   非常好用也非常容易入手')
			}
		}
	}
</script>

<style lang="scss">
	.tabBar {
		display: flex;
		align-items: center;
		justify-content: center;
		position: fixed;
		bottom: 0rpx;
		left: 0rpx;
		right: 0rpx;
		background: #FFFFFF;
		width: 100%;
		height: 100rpx;
		padding-bottom: 30rpx;
		border-top: 1rpx solid #E5E5E5;
		z-index: 99;

		.tabBar_list {
			width: 86%;
			display: flex;
			justify-content: space-between;

			image {
				width: 48rpx;
				height: 48rpx;
				margin-bottom: 2rpx
			}

			.tabBar_item {
				width: 68rpx;
				display: flex;
				justify-content: center;
				align-items: center;
				flex-direction: column;
				font-size: 20rpx;
				color: #969BA3;
			}
		}
	}

	.border_box {
		// pointer-events: none; 事件穿透解决z-index层级问题
		width: 100%;
		height: 100rpx;
		display: flex;
		justify-content: center;
		align-items: center;
		position: fixed;
		left: 0px;
		bottom: 50rpx;
		z-index: 100;
		pointer-events: none;

		.tabBar_miden_border {
			width: 100rpx;
			height: 50rpx;
			border-top: 2rpx solid #E5E5E5;
			border-radius: 50rpx 50rpx 0 0;
			/* 左上、右上、右下、左下 */
			background: #fff;
		}
	}

	.nav_active {
		color: #007AFF;
	}
</style>
