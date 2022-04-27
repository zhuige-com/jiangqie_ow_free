<template>
	<view class="content">

		<view v-if="post" class="jiangqie-block">
			<view class="jiangqie-detail-title">{{post.title}}</view>
			<view class="jiangqie-detail-data">
				<text>浏览 {{post.views}}</text>
				<text>{{post.time}}</text>
			</view>
			<view class="jiangqie-detail-view">
				<mp-html :content="post.content" />
			</view>
		</view>

		<view v-if="post && post.poster_switch==1" class="jiangqie-block jiangqie-detail-opt">
			<view @click="clickPoster()">
				<text>分享海报</text>
				<image mode="aspectFill" src="../../static/share.png"></image>
			</view>
		</view>

		<view class="jiangqie-block jiangqie-brand">追格 Zhuige.com 提供技术支持</view>

		<!-- #ifdef MP-BAIDU -->
		<view v-if="isShowPainter" isRenderImage style="position: fixed; top: 0;" @longpress="longTapPainter" @click="clickPainter()">
			<l-painter isRenderImage :board="base" @success="onPainterSuccess" />
		</view>
		<!-- #endif -->
		
		<!-- #ifdef MP-WEIXIN || MP-QQ || H5 -->
		<l-painter v-if="isShowPainter" isRenderImage custom-style="position: fixed; left: 200%;" :board="base"
			@success="onPainterSuccess" />
		<!-- #endif -->
		
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
	 * Copyright © 2021-2022 www.jiangqie.com All rights reserved.
	 */
	
	import Util from '@/utils/util';
	import Api from '@/utils/api';
	import Rest from '@/utils/rest';
	import lPainter from '@/uni_modules/lime-painter/components/lime-painter/'

	export default {
		data() {
			return {
				post_id: undefined,
				post: undefined,

				acode: undefined,

				isShowPainter: false,
				painterImage: '',
				base: undefined,
			}
		},

		components: {
			lPainter,
		},

		onLoad(options) {
			if (options.scene) {
				this.post_id = decodeURIComponent(options.scene);
			} else if (options.post_id) {
				this.post_id = options.post_id;
			}

			// #ifdef MP-WEIXIN
			this.loadWxacode();
			// #endif

			// #ifdef MP-QQ
			this.loadQqacode();
			// #endif
			
			// #ifdef MP-BAIDU || H5
			this.loadBdacode();
			// #endif

			this.loadPost();
		},
		
		onShow() {
			// #ifdef MP-BAIDU
			if (this.post) {
				swan.setPageInfo({
					title: this.post.title,
					description: this.post.excerpt,
					keywords: this.post.keywords,
				});
			}
			// #endif
		},

		onShareAppMessage() {
			let params = {
				title: this.post.title,
				imageUrl: this.post.thumbnail,
				content: this.post.excerpt
			};
			
			// #ifdef MP-WEIXIN || MP-BAIDU
			params.path = 'pages/detail/detail?post_id=' + this.post_id;
			// #endif
			
			// #ifdef MP-BAIDU
			params.content = this.post.excerpt;
			// #endif
			
			return params;
		},

		// #ifdef MP-WEIXIN
		onShareTimeline() {
			return {
				title: this.post.title,
				imageUrl: this.post.thumbnail,
				query: 'post_id=' + this.post_id
			};
		},
		
		onAddToFavorites(res) {
			return {
				title: this.post.title,
				imageUrl: this.post.thumbnail,
				query: 'post_id=' + this.post_id
			};
		},
		// #endif

		methods: {
			/**
			 * 加载文章详情
			 */
			loadPost() {
				Rest.post(Api.JQ_OW_FREE_POST_DETAIL, {
					post_id: this.post_id
				}).then(res => {
					this.post = res.data;
					uni.setNavigationBarTitle({
						title: this.post.title
					})
					
					// #ifdef MP-BAIDU
					swan.setPageInfo({
						title: this.post.title,
						description: this.post.excerpt,
						keywords: this.post.keywords,
					});
					// #endif
				});
			},

			/**
			 * 加载微信小程序码
			 */
			loadWxacode() {
				Rest.post(Api.JQ_OW_FREE_POST_WX_ACODE, {
					post_id: this.post_id
				}).then(res => {
					this.acode = res.data;
				}, err => {
					console.log(err);
				});
			},

			/**
			 * 加载QQ小程序码
			 */
			loadQqacode() {
				Rest.post(Api.JQ_OW_FREE_POST_QQ_ACODE, {
					post_id: this.post_id
				}).then(res => {
					this.acode = res.data;
				}, err => {
					console.log(err);
				});
			},

			/**
			 * 加载百度小程序码
			 */
			loadBdacode() {
				Rest.post(Api.JQ_OW_FREE_POST_BD_ACODE, {
					post_id: this.post_id
				}).then(res => {
					this.acode = res.data;
				}, err => {
					console.log(err);
				});
			},

			//海报分享-百度
			// #ifdef MP-BAIDU
			clickPainter() {
				this.isShowPainter = false;
			},
			
			/**
			 * 长按海报
			 */
			longTapPainter() {
				uni.showActionSheet({
					itemList: ['保存到相册'],
					success: (res) => {
						if (res.tapIndex == 0) {
							uni.showLoading({
								title: '导出……'
							})
							let save2album = setInterval(() => {
								if (!this.painterImage || this.painterImage.length == 0) {
									return;
								}
								clearInterval(save2album)
								uni.hideLoading();
			
								uni.saveImageToPhotosAlbum({
									filePath: this.painterImage,
									success() {
										uni.showToast({
											title:'已保存'
										})
									}
								})
							}, 500);
						}
					},
					fail: (res) => {
						console.log(res.errMsg);
					}
				});
			},
			// #endif

			/**
			 * 海报分享
			 */
			clickPoster() {
				// #ifndef MP-BAIDU
				if (this.painterImage) {
					uni.previewImage({
						urls: [this.painterImage]
					});
					console.log('海报分享');
					return;
				}
				// #endif

				this.isShowPainter = true;
				this.base = {
					width: '750rpx',
					height: '1334rpx',
					backgroundColor: '#007AFF',
					views: [{
							type: 'view',
							css: {
								left: '30rpx',
								top: '234rpx',
								width: '690rpx',
								height: '1000rpx',
								background: '#FFFFFF',
							}
						},
						{
							type: 'text',
							text: this.post.title,
							css: {
								left: '30rpx',
								top: '120rpx',
								width: '690rpx',
								color: '#FFFFFF',
								fontSize: '38rpx',
								textAlign: 'center',
								maxLines: 1,
							}
						},
						{
							type: 'image',
							src: this.post.thumbnail,
							mode: 'center',
							css: {
								left: '30rpx',
								top: '200rpx',
								width: '690rpx',
								height: '520rpx'
							}
						},
						{
							type: 'text',
							text: this.post.excerpt,
							css: {
								left: '70rpx',
								top: '740rpx',
								width: '610rpx',
								color: '#000000',
								fontSize: '28rpx',
								maxLines: 3,
							}
						},
						{
							type: 'image',
							src: this.acode,
							mode: 'aspectFill',
							css: {
								left: '275rpx',
								top: '920rpx',
								width: '200rpx',
								height: '200rpx'
							}
						},
						{
							type: 'text',
							text: getApp().globalData.appName,
							css: {
								left: '30rpx',
								top: '1170rpx',
								width: '690rpx',
								color: '#888888',
								fontSize: '28rpx',
								textAlign: 'center',
							}
						},
					]
				}
			},
			
			/**
			 * 打开海报
			 */
			onPainterSuccess(e) {
				this.painterImage = e;
				
				// #ifndef MP-BAIDU
				uni.previewImage({
					urls: [e]
				});
				// #endif
			},
		}
	}
</script>

<style lang="scss" scoped>
	.jiangqie-block:first-of-type {
		border: none;
	}
</style>
