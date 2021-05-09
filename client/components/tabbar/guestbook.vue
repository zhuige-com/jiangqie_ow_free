<template>
	<view class="content">
		<scroll-view class="main_box" scroll-y="true" @scrolltolower="lower">
			<!-- 留言表单 -->
			<view v-if="background" class="jiangqie-gust-img">
				<image mode="aspectFill" :src="background"></image>
			</view>
			<view class="jiangqie-block">
				<view v-if="title" class="jiangqie-head">{{title}}</view>
				<view class="jiangqie-form">
					<view class="jiangqie-form-line">
						<view>
							<text>姓名:</text>
						</view>
						<view>
							<input type="text" v-model="username" />
						</view>
					</view>
					<view class="jiangqie-form-line">
						<view>
							<text>电话:</text>
						</view>
						<view>
							<input type="text" v-model="phone" />
						</view>
					</view>
					<view class="jiangqie-form-line">
						<view>
							<text>E-mail:</text>
						</view>
						<view>
							<input type="text" v-model="email" />
						</view>
					</view>
					<view class="jiangqie-form-hightline">
						<view>
							<text>请输入留言内容:</text>
						</view>
						<view>
							<textarea auto-height="" v-model="content"></textarea>
						</view>
					</view>
					<!-- 认证button -->
					<view class="jiangqie-base-block jiangqie-form-btn">
						<view class="jiangqie-button" @click="clickSubmit()">提交</view>
 						<!-- <view class="jiangqie-form-tips">
							<text>提交成功</text>
						</view> -->
					</view>
				</view>
			</view>
			<view class="jiangqie-block jiangqie-brand">酱茄 JiangQie.com 提供技术支持</view>
		</scroll-view>
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
	import Alert from '@/utils/alert';
	import Api from '@/utils/api';
	import Rest from '@/utils/rest';
	
	export default {
		data() {
			return {
				load: false,
				
				background: undefined,
				title: '',
				
				username: '',
				phone: '',
				email: '',
				content: '',
			}
		},
		methods: {
			jqOnLoad() {
				console.log('jqOnLoad');
				
				Rest.post(Api.JQ_OW_FREE_SETTING_FEEDBACK, {}).then(res => {
					this.background = res.data.background;
					this.title = res.data.title;
				});
			},
			
			jqOnShow() {
				if (!this.load) {
					this.load = true;
					this.jqOnLoad();
				}
			},
			
			lower() {
				
			},
			
			clickSubmit() {
				Rest.post(Api.JQ_OW_FREE_USER_FEEDBACK, {
					username: this.username,
					phone: this.phone,
					email: this.email,
					content: this.content
				}).then(res => {
					if (res.code == 0) {
						Alert.success('留言成功');
						this.username = '';
						this.phone = '';
						this.email = '';
						this.content = '';
					} else {
						Alert.error(res.msg);
					}
				});
			}
		}
	}
</script>

<style lang="scss">
	.jiangqie-block {
		border: none;
	}
	.jiangqie-gust-img, .jiangqie-gust-img image {
		height: 360rpx;
		width: 100%;
	}
</style>
