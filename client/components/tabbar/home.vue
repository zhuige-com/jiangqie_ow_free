<template>
	<view class="content">
		<scroll-view class="main_box" scroll-y="true" @scrolltolower="lower">
			<!-- 首页顶部轮播图 -->
			<view v-if="slides.length>0" class="jiangqie-swiper">
				<swiper indicator-dots="true" circular="ture" autoplay="autoplay" interval="2000" duration="duration">
					<swiper-item v-for="(slide, index) in slides" :key="index" @click="clickLink(slide.link)">
						<view>
							<image mode="aspectFill" :src="slide.image"></image>
						</view>
					</swiper-item>
				</swiper>
			</view>
			
			<!-- 自定义图标 -->
			<view v-if="icon_navs.length>0" class="jiangqie-icon-block">
				<view v-for="(item, index) in icon_navs" :key="index" class="jiangqie-custom-icon" @click="clickLink(item.link)">
					<image mode="aspectFill" :src="item.image"></image>
					<text>{{item.title}}</text>
				</view>
			</view>

			<!-- 简单描述 -->
			<view v-if="about" class="jiangqie-block">
				<view class="jiangqie-head">{{about.title}}</view>
				<view class="jiangqie-simple">
					<mp-html :content="about.content" />
				</view>
			</view>

			<!-- 滑动展示 -->
			<view v-if="goods_list && goods_list.list.length>0" class="jiangqie-block jiangqie-scroll-block">
				<view class="jiangqie-head">
					{{goods_list.title}}
					<text>滑动查看</text>
				</view>
				<scroll-view class="jiangqie-scroll-view" scroll-x="true">
					<view v-for="(item, index) in goods_list.list" :key="index" @click="clickPost(item.id)">
						<image mode="aspectFill" :src="item.thumbnail"></image>
						<text>{{item.title}}</text>
					</view>
				</scroll-view>
			</view>

			<view v-if="news_list && news_list.list.length>0" class="jiangqie-block">
				<view class="jiangqie-head">
					{{news_list.title}}
					<text @click="clickNewsMore()">查看更多</text>
				</view>
				<!-- 列表内容块 - 左图 -->
				<view v-for="(item, index) in news_list.list" :key="index" class="jiangqie-list-side" @click="clickPost(item.id)">
					<view class="jiangqie-list-img">
						<image mode="aspectFill" :src="item.thumbnail"></image>
					</view>
					<view class="jiangqie-list-text">
						<view class="jiangqie-list-title">{{item.title}}</view>
						<view class="jiangqie-list-data">
							<text>浏览 {{item.views}}</text>
							<text>{{item.time}}</text>
						</view>
					</view>
				</view>
			</view>

			<!-- 留言表单 -->
			<view v-if="feedback" class="jiangqie-block">
				<view class="jiangqie-head">{{feedback.title}}</view>
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
					<view class="jiangqie-base-block jiangqie-form-btn">
						<view class="jiangqie-button" @click="clickSubmit()">提交</view>
 						<!-- <view class="jiangqie-form-tips">
							<text>提交成功</text>
						</view> -->
					</view>
				</view>
			</view>

			<!-- 合作伙伴 -->
			<view v-if="friends.length>0" class="jiangqie-block jiangqie-cooperate-block">
				<view class="jiangqie-head">
					合作伙伴
					<!-- <text>查看更多</text> -->
				</view>
				<view class="jiangqie-cooperate">
					<scroll-view class="jiangqie-scroll-cooperate" scroll-x="true">
						<view v-for="(item, index) in friends" :key="index">
							<image mode="aspectFill" :src="item.image"></image>
						</view>
					</scroll-view>
				</view>
			</view>

			<!-- 悬浮菜单 -->
			<view class="jiangqie-float-block">
				<view v-if="phone_switch" @click="clickPhone()">电话</view>
				<!-- #ifdef MP-WEIXIN || MP-BAIDU -->
					<button v-if="contact_switch" open-type="contact"><view>客服</view></button>
				<!-- #endif -->
				<view v-if="feedback_switch" @click="clickFeedback()">反馈</view>
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
				
				slides: [],
				icon_navs: [],
				about: undefined,
				goods_list: undefined,
				news_list: undefined,
				feedback: undefined,
				friends: [],
				
				username: '',
				phone: '',
				email: '',
				content: '',
				
				phone_switch: 0,
				phone_number: '',
				contact_switch: 0,
				feedback_switch: 0,
			}
		},
		
		methods: {
			jqOnLoad() {
				Rest.post(Api.JQ_OW_FREE_SETTING_HOME, {}).then(res => {
					getApp().appName = res.data.title;
					getApp().appDesc = res.data.desc;
					if (res.data.thumb) {
						getApp().appThumb = res.data.thumb;
					}
					
					uni.setNavigationBarTitle({
						title: getApp().appName
					})
					
					this.slides = res.data.slides;
					this.icon_navs = res.data.icon_navs;
					this.about = res.data.about;
					this.goods_list = res.data.goods_list;
					this.news_list = res.data.news_list;
					this.feedback = res.data.feedback;
					this.friends = res.data.friends;
					
					this.phone_switch = res.data.phone_switch;
					this.phone_number = res.data.phone_number;
					this.contact_switch = res.data.contact_switch;
					this.feedback_switch = res.data.feedback_switch;
				}, err => {
					console.log(err)
				});
			},
			
			jqOnShow() {
				if (!this.load) {
					this.load = true;
					this.jqOnLoad();
				}
			},
			
			lower() {
				uni.showToast({
					title: 'scroll-view的加载更多'
				})
			},
			
			clickLink(link) {
				Util.openLink(link);
			},
			
			clickPost(post_id) {
				Util.openLink('/pages/detail/detail?post_id=' + post_id);
			},
			
			clickNewsMore() {
				Util.openLink('/pages/list/list');
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
			},
			
			clickPhone() {
				uni.makePhoneCall({
				    phoneNumber: this.phone_number
				});
			},
			
			clickFeedback() {
				uni.$emit('feedback', {})
			}
		}
	}
</script>

<style lang="scss">
	.jiangqie-float-block {
		button {
			display: inline;
			margin: 0;
			padding: 0;
			background-color: rgba(255, 255, 255, 0);
		}	
	}
</style>
