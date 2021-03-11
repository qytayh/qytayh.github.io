---
title: 将uni-request进行axios化封装
date: 2020-11-05 16:06:51
tags:
	- uni-app
	- 网络请求
categories:
	- uni-app
	- 网络请求
description:
---

本文介绍如何将uni-app提供的网络请求方式uni-request进行封装。

<!-- more -->
# step1

首先我们使用hubuilderX创建一个uni-app项目，并在根目录下创建目录`common`，用于统一存放我们的的工具类。

# step2

在`common`下新建`axios/axios.js`,并贴上如下代码：

``` js

const url_config ="你的接口地址"

function axios(options){
	const {url, method, data}=options
	const api_token =uni.getStorageSync('api_token');
	let headers={
		Authorization:'Bearer ' + api_token,
		TargetLanguage:"zh-CN"
	}
	
	return uni.request({
		url: url_config + url,
		method,
		data,
		dataType: 'json',
		header: headers
	}).then(res => {
		const result=res[1]
		return checkStatus(result)
	}).catch(parmas => {
		console.log(parmas,'parmas')
	})
}
function checkStatus(response){
	return new Promise((resolve, reject)=>{
		if(response.statusCode===200|| 
			response.statusCode === 304 ||
			response.statusCode === 400){
			resolve(response.data);
		}else{
			reject({
				status: response.statusCode,
				message: response.data.message,
				error: response.data.errors[Object.keys(response.data.errors)[0]][0]
			 });
		}
	})
}

export default {
	post(url, params) {
		return axios({url, method:"post", data:params}).then(response => {
			return response
		});
	},
	get(url, params) {
		return axios({url, method:"get", data:params}).then(response => {
			return response
		});
	},
	delete(url, params) {
		return axios({url, method:"delete", data:params}).then(response => {
			return response
		});
	},
	put(url, params) {
		return axios({url, method:"put", data:params}).then(response => {
			return response
		});
	},
}

```

# step3

将我们封装好的axios挂载到全局，编辑`main.js`,
```
import axios from 'common/axios/axios.js'
Vue.prototype.$axios = axios;
```
到这边是不是已经开始熟悉起来了

# step4

接下来我们就可以在需要发送网络请求的地方快乐的使用axios了
```js
this.$axios.get(url,params).then(res=>{}).catch(e=>{console.log(e)})
this.$axios.post(url,params).then(res=>{}).catch(e=>{console.log(e)})
this.$axios.delete(url,params).then(res=>{}).catch(e=>{console.log(e)})
this.$axios.put(url,params).then(res=>{}).catch(e=>{console.log(e)})
```


>  [在flutter中优雅的封装网络请求](https://qytayh.github.io/2020/08/%E5%9C%A8flutter%E4%B8%AD%E4%BC%98%E9%9B%85%E7%9A%84%E5%B0%81%E8%A3%85%E7%BD%91%E7%BB%9C%E8%AF%B7%E6%B1%82/)
>  [在vue中对axios进行二次封装](https://qytayh.github.io/2020/08/%E5%9C%A8vue%E4%B8%AD%E5%AF%B9axios%E8%BF%9B%E8%A1%8C%E4%BA%8C%E6%AC%A1%E5%B0%81%E8%A3%85/)

<!-- markdownlint-disable MD041 MD002--> 