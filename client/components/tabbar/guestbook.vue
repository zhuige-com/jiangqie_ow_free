<template>
	<view class="content">
		<scroll-view class="main_box" scroll-y="true">
			<!-- 留言表单 -->
			<view v-if="background" class="jiangqie-gust-img" @click="clickLink(link)">
				<image class="image" mode="aspectFill" :src="background"></image>
			</view>
			<view class="jiangqie-block">
				<view v-if="title" class="jiangqie-head">{{title}}</view>
				<view class="jiangqie-form">
					<view class="jiangqie-form-line">
						<view>
							<text>姓名:</text>
						</view>
						<view>
							<input type="nickname" @blur="onUsernameBlur" v-model="username" placeholder="请输入姓名" />
						</view>
					</view>
					<view class="jiangqie-form-line">
						<view>
							<text>电话:</text>
						</view>
						<view>
							<input type="text" v-model="phone" placeholder="请输入联系电话" />
						</view>
					</view>
					<view class="jiangqie-form-line">
						<view>
							<text>E-mail:</text>
						</view>
						<view>
							<input type="text" v-model="email" placeholder="请输入Email" />
						</view>
					</view>
					<view class="jiangqie-form-hightline">
						<view>
							<text>留言内容:</text>
						</view>
						<view>
							<textarea auto-height="" v-model="content" placeholder="您的留言对我们很重要"></textarea>
						</view>
					</view>
					<!-- 认证button -->
					<view class="jiangqie-base-block jiangqie-form-btn">
						<view class="jiangqie-button" @click="clickSubmit()">提交</view>
					</view>
				</view>
			</view>
			
			<view @click="clickJiangQie" class="jiangqie-block jiangqie-brand">本小程序基于追格（zhuige.com）搭建</view>
			
			<!-- 备案信息 -->
			<view class="jiangqie-recordinfo" v-if="beian_icp" @click="clickLink(beian_icp.link)">
				<text>
					{{beian_icp.sn}}
				</text>
			</view>
			
		</scroll-view>
	</view>
</template>

<script>
	/*
	 * 追格企业官网Free
	 * 作者: 追格
	 * 文档: https://www.zhuige.com/docs/gwfree.html
	 * github: https://github.com/zhuige-com/jiangqie_ow_free
	 * gitee: https://gitee.com/zhuige_com/jiangqie_ow_free
	 * License：GPL-2.0
	 * Copyright © 2021-2024 www.zhuige.com All rights reserved.
	 */

	import Util from '@/utils/util';
	import Alert from '@/utils/alert';
	import Api from '@/utils/api';
	import Rest from '@/utils/rest';

	export default {
		data() {
			this.load = false;

			return {
				background: undefined,
				link: '',
				title: '',

				username: '',
				phone: '',
				email: '',
				content: '',
				
				beian_icp: undefined,
			}
		},
		methods: {
			/**
			 * 组件加载
			 */
			jqOnLoad() {
				Rest.post(Api.JQ_OW_FREE_SETTING_FEEDBACK, {}).then(res => {
					this.background = res.data.background;
					this.link = res.data.link;
					this.title = res.data.title;
					
					if (res.data.beian_icp) {
						this.beian_icp = res.data.beian_icp;
					}
				});
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
			 * 设置用户名
			 */
			onUsernameBlur(e) {
				this.username = e.detail.value;
			},

			/**
			 * 点击提交反馈
			 */
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
			},

			/**
			 * 点击版权
			 */
			clickJiangQie() {
				Util.jiangqie();
			},
			
			/**
			 * 点击打开链接
			 */
			clickLink(link) {
				Util.openLink(link);
			}
		}
	}
</script>

<style lang="scss" scoped>
	.main_box {
		padding-bottom: 160rpx;
	}

	.jiangqie-block {
		border: none;
	}

	.jiangqie-gust-img,
	.jiangqie-gust-img .image {
		height: 360rpx;
		width: 100%;
	}
	
	textarea {
		line-height: normal;
	}
</style>