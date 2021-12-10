---
title: 在vue中对axios进行二次封装
date: 2020-08-01 21:17:33
tags:
  - vue
	- 网络请求
categories:
  - vue
	- 网络请求
description:
---

为aixos配置统一请求地址，统一请求头等。
<!-- more -->

## 封装

在`src`下新建`axios/axios.js`
```js
import axios from 'axios';
import router from "../router"
import Tools from '@/components/Tools/index';
import store from '../store'

let token = '';
axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;

//添加请求拦截器
axios.interceptors.request.use(
  config => {
    let api_token = JSON.parse(sessionStorage.getItem('api_token')!)
    if (api_token) {
      token = api_token
    }
    config.headers.common['Authorization'] = 'Bearer ' + token;
    return config;
  },
  error => {
    return Promise.reject(error);
  }
);
//添加响应拦截器
axios.interceptors.response.use(
  response => {
    return response;
  },
  error => {
    return Promise.resolve(error.response);
  }
);
axios.defaults.baseURL = process.env.VUE_APP_BASEURL

axios.defaults.headers.post["Content-Type"] = "application/json";
axios.defaults.headers.post["X-Requested-With"] = "XMLHttpRequest";
axios.defaults.headers.put["Content-Type"] = "application/json";
axios.defaults.headers.put["X-Requested-With"] = "XMLHttpRequest";
axios.defaults.headers.delete["Content-Type"] = "application/json";
axios.defaults.headers.delete["X-Requested-With"] = "XMLHttpRequest";
axios.defaults.timeout = 10000;
function checkStatus(response ) {
  return new Promise((resolve, reject) => {
    if (
      response &&
      (response.status === 200 ||
        response.status === 304 ||
        response.status === 400)
    ) {
        resolve(response.data);
    } else {
      reject({
        status: response.status,
        message: response.data.message,
        error: response.data.errors[Object.keys(response.data.errors)[0]][0]
      });
    }
  });
}
export default {
  post(url, params) {
    return axios({
      method: "post",
      url,
      data: params
    }).then(response => {
      return checkStatus(response);
    });
  },
  get(url, params) {
    return axios({
      method: "get",
      url,
      params
    }).then(response => {
      return checkStatus(response);
    });
  },
  put(url, params) {
    return axios({
      method: "put",
      url,
      data: params
    }).then(response => {
      return checkStatus(response);
    });
  },
  delete(url, params) {
    return axios({
      method: "delete",
      url,
      data: params
    }).then(response => {
      return checkStatus(response);
    });
  }
};
```

## 使用

首先在`main.js`中进行引用
```js
import axios from './axios/axios'

Vue.prototype.$axios = axios;

```
然后在我们要使用的地方
```js
this.$axios.post('接口地址',{}).then(res=>{
    
})
```


>  [将uni-request进行axios化封装](https://qytayh.github.io/2020/11/%E5%B0%86uni-request%E8%BF%9B%E8%A1%8Caxios%E5%8C%96%E5%B0%81%E8%A3%85/)
>  [在flutter中优雅的封装网络请求](https://qytayh.github.io/2020/08/%E5%9C%A8flutter%E4%B8%AD%E4%BC%98%E9%9B%85%E7%9A%84%E5%B0%81%E8%A3%85%E7%BD%91%E7%BB%9C%E8%AF%B7%E6%B1%82/)
<!-- markdownlint-disable MD041 MD002--> 