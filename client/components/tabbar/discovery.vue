<template>
	<view class="content">
		<scroll-view class="main_box" scroll-y="true" @scrolltolower="lower">

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

		</scroll-view>
	</view>
</template>

<script>
	/*
	 * 酱茄企业官网Free v1.0.5
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
				load: false,

				posts: [],
				loadMore: 'more'
			}
		},
		methods: {
			jqOnLoad() {
				this.loadPost();
			},

			jqOnShow() {
				if (!this.load) {
					this.load = true;
					this.jqOnLoad();
				}
			},

			lower() {
				if (this.loadMore == 'more') {
					this.loadPost();
				}
			},

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

<style lang="scss">
	.main_box {
		width: 100vw;
		height: 100vh;
		padding-bottom: 120rpx;
		box-sizing: border-box;
	}

	.jiangqie-block:first-of-type {
		border: none;
	}
</style>
