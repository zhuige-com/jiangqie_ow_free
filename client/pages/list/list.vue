<template>
	<view class="content">
		
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
		
		<view class="jiangqie-block jiangqie-brand">酱茄 JiangQie.com 提供技术支持</view>	
	
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
	
	import Constant from '@/utils/constants';
	import Util from '@/utils/util';
	import Api from '@/utils/api';
	import Rest from '@/utils/rest';
	
	export default {
		data() {
			return {
				posts: [],
				loadMore: 'more'
			}
		},
		
		onLoad(options) {
			this.loadPost();
		},
		
		onShareAppMessage() {
			let params = {
				title: getApp().appName + ' 最新资讯'
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
			clickPost(post_id) {
				Util.openLink('/pages/detail/detail?post_id=' + post_id);
			},
			
			loadPost() {
				if (this.loadMore == 'loading') {
					return;
				}
				this.loadMore = 'loading';
				
				Rest.post(Api.JQ_OW_FREE_POSTS_LAST, {
					offset: this.posts.length
				}).then(res => {
					this.posts = this.posts.concat(res.data.posts);
					this.loadMore = res.data.more;
				});
			}
		}
	}
</script>

<style>
	.jiangqie-block:first-of-type {
		border: none;
	}
</style>
