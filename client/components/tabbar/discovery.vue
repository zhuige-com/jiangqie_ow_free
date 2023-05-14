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
		
		<scroll-view class="main_box" scroll-y="true" @scrolltolower="lower">
			
			<template v-if="posts.length>0">
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
				
				<view class="jiangqie-placeholder"></view>
			</template>

		</scroll-view>
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

	import Util from '@/utils/util';
	import Api from '@/utils/api';
	import Rest from '@/utils/rest';

	export default {
		data() {
			this.load = false;
			
			return {
				top_navs: [],
				curCat: 0,

				posts: [],
				loadMore: 'more'
			}
		},
		
		methods: {
			/**
			 * 组件加载
			 */
			jqOnLoad() {
				this.loadSetting();
				this.loadPost();
			},

			/**
			 * 组件显示
			 */
			jqOnShow() {
				if (!this.load) {
					this.load = true;
					this.jqOnLoad();
				}
			},

			/**
			 * 上拉 加载更多
			 */
			lower() {
				if (this.loadMore == 'more') {
					this.loadPost();
				}
			},

			/**
			 * 点击打开文章
			 */
			clickPost(post_id) {
				Util.openLink('/pages/detail/detail?post_id=' + post_id);
			},
			
			/**
			 * 点击版权
			 */
			clickJiangQie() {
				Util.jiangqie();
			},
			
			/**
			 * 点击切换分类
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
			 * 加载最新文章
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
	.main_box {
		width: 100vw;
		height: 100vh;
		margin-top: 100rpx;
		padding-bottom: 160rpx;
		box-sizing: border-box;
	}

	.jiangqie-block:first-of-type {
		border: none;
		border-top: 16rpx solid #F3F3F3;
	}
	
	.jiangqie-placeholder {
		height: 50rpx;
	}
</style>
