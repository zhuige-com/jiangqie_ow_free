<template>
	<view class="content">

		<view v-if="top_navs && top_navs.length>0" class="jiangqie-scroll-nav">
			<scroll-view scroll-x scroll-with-animation scroll-left="scrollLeft" show-scrollbar="false"
				class="jiangqie-tab-nav">
				<view v-for="(item,index) in top_navs" @click="clickNavCat(item.id)" :key="index"
					:class="{'jiangqie-tab-on':curCat==item.id}">
					<view>{{item.name}}</view>
				</view>
			</scroll-view>
		</view>

		<view v-if="posts.length>0" class="jiangqie-block-margin">
			<view v-for="(post, index) in posts" :key="post.id" class="jiangqie-block" @click="clickPost(post.id)">
				<view class="jiangqie-list">
					<view class="jiangqie-list-title">{{post.title}}</view>
					<view class="jiangqie-list-img">
						<image mode="aspectFill" :src="post.thumbnail"></image>
					</view>
					<view class="jiangqie-list-text">
						<view class="jiangqie-list-data">
							<text>浏览 {{post.views}}</text>
							<text>{{post.time}}</text>
						</view>
					</view>
				</view>
			</view>

			<uni-load-more :status="loadMore"></uni-load-more>
		</view>
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
	 * Copyright © 2021-2024 www.zhuige.com All rights reserved.
	 */

	import Util from '@/utils/util';
	import Api from '@/utils/api';
	import Rest from '@/utils/rest';

	export default {
		components: {
			
		},
		
		data() {
			return {
				top_navs: [],
				curCat: 0,

				posts: [],
				loadMore: 'more'
			}
		},

		onLoad(options) {
			if (options.cat_id) {
				this.curCat = options.cat_id;
			}

			this.loadSetting();
			this.loadPost();
		},

		onShow() {
			// #ifdef MP-BAIDU
			swan.setPageInfo({
				title: '最新资讯_' + getApp().globalData.appName,
				description: getApp().globalData.appDesc,
				keywords: getApp().globalData.appKeyword,
			});
			// #endif
		},

		onShareAppMessage() {
			let params = {
				title: getApp().globalData.appName + ' 最新资讯'
			};

			// #ifdef MP-WEIXIN || MP-BAIDU
			params.path = 'pages/list/list';
			// #endif

			return params;
		},

		// #ifdef MP-WEIXIN
		onShareTimeline() {
			return {
				title: etApp().appName + ' 最新资讯'
			};
		},
		onAddToFavorites(res) {
			return {
				title: etApp().appName + ' 最新资讯'
			};
		},
		// #endif

		onReachBottom() {
			if (this.loadMore == 'more') {
				this.loadPost();
			}
		},

		methods: {
			/**
			 * 点击文章
			 */
			clickPost(post_id) {
				Util.openLink('/pages/detail/detail?post_id=' + post_id);
			},

			/**
			 * 点击分类
			 */
			clickNavCat(cat_id) {
				this.curCat = cat_id;

				this.loadMore = 'more';
				this.loaded = false;
				this.posts = [];

				this.loadPost();
			},

			/**
			 * 加载配置
			 */
			loadSetting() {
				Rest.post(Api.JQ_OW_FREE_SETTING_NEWS, {}).then(res => {
					this.top_navs = [{
						id: 0,
						name: '全部'
					}];
					this.top_navs = this.top_navs.concat(res.data.top_nav);
				}, err => {
					console.log(err)
				});
			},

			/**
			 * 加载文章
			 */
			loadPost() {
				if (this.loadMore == 'loading') {
					return;
				}
				this.loadMore = 'loading';

				Rest.post(Api.JQ_OW_FREE_POSTS_LAST, {
					offset: this.posts.length,
					cat_id: this.curCat,
				}).then(res => {
					this.posts = this.posts.concat(res.data.posts);
					this.loadMore = res.data.more;
				});
			}
		}
	}
</script>

<style lang="scss" scoped>
	.jiangqie-block-margin {
		margin-top: 100rpx;
	}

	.jiangqie-block:first-of-type {
		border: none;
		border-top: 16rpx solid #F3F3F3;
	}
</style>