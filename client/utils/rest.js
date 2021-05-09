/**
 * request封装
 */
function request(url, data = {}, method = "GET") {
	return new Promise(function(resolve, reject) {
		uni.showLoading({
			title: '加载中'
		});

		// data.t = new Date().getTime();
		// data.r = Math.floor(Math.random() * 10000);
		
		uni.request({
			url: url,
			data: data,
			method: method,
			success: function(res) {
				uni.hideLoading();

				if (res.statusCode != 200) {
					reject(res.errMsg);
					return;
				}

				// if (res.data.code == -1) {
				// 	uni.navigateTo({
				// 	    url: '/pages/user/login/login',
				// 	});
				// 	return;
				// }
				
				resolve(res.data);
			},
			fail: function(err) {
				uni.hideLoading();
				reject(err);
			}
		});
	});
}

/**
 * get请求
 */
function get(url, data = {}) {
	return request(url, data, 'GET');
}

/**
 * post请求
 */
function post(url, data = {}) {
	return request(url, data, 'POST');
}

module.exports = {
	get,
	post,
};
