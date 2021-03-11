---
title: 在vue项目中动态加载js
date: 2020-06-03 08:54:13
tags:
    - vue
categories:
    - vue
description:
---

通常情况下，如果网页加载的js文件较多并且文件较大的时候，一次性加载完毕的话，会非常的影响网页加载的速度，当然将会严重影响用户体验，最终会影响的站点的人气，所以我们要想办法解决这个问题。

<!-- more -->

很多时候，加载的js代码在当前页面功能中并不需要，所以如果能够根据需要动态的加载js文件，那么将会极大的提高网页的加载速度，下面就通过代码实例介绍一下如何动态加载js。

vue中常用的引入js文件的方式一般有三种

- 在html文件中`<script src="" type="text/javascript"></script>`引入

- 在`main.js`或需要引用的`.vue`文件中
```js
import a from '../a'//要用到export导出之后 才能用import导入.
//或
import '../a'//和直接引入script标签是一样的
```

假设我们有这样一个比较极限的应用场景：

我们在登录页需要支持facebook，google，微信等十多个平台的第三方登录，并且每个第三方登录所需要的js文件特别大，用我们常规的用法去加载的话在用户第一次使用的时候就需要加载特别多的js文件，势必会造成用户体验不好的情况

那么我们应该怎么去优化呢

# vue-plugin-load-script

安装

```
npm install --save vue-plugin-load-script
```

使用

```js
// In main.js
import LoadScript from 'vue-plugin-load-script';

Vue.use(LoadScript);
```

```js
//login.vue
methods:{
    wxLogin(){
        this.$loadScript("https://wx登录需要的js")
        .then(() => {
        // Script is loaded, do something
        })
        .catch(() => {
        // Failed to fetch script
        });
    },
    googleLogin(){
        this.$loadScript("https://谷歌登录需要的js")
        .then(() => {
        // Script is loaded, do something
        })
        .catch(() => {
        // Failed to fetch script
        });
    },
    ......
}
```

这样用户点击什么登录方式就会去加载对应的第三方登录需要的js，从而避免了加载过多不需要的js造成页面性能浪费


<!-- markdownlint-disable MD041 MD002--> 