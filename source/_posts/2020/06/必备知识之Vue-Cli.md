---
title: 必备知识之Vue-Cli
date: 2020-06-02 10:15:11
tags:
    - vue
categories:
    - vue
description:
---

更快速构建vue项目

<!-- more -->

# 快速原型开发

你可以使用`vue serve`和`vue build`命令对单个vue文件快速进行原型开发

## 安装`@vue/cli-service-global`扩展

`npm install  -g @vue/cli-service-global`

准备一个内容原型

## vue serve

启动一个服务并运行原型

`vue serve Hello.vue`


# 创建项目

## vue create

创建一个vue项目

`vue create projectname`

## vue ui

图形化项目管理

`vue ui`

# 插件

Vue Cli使用了一套基于插件的架构。插件可以修改webpack的内部配置，也可以向vue-cli-serve注入命令。在项目创建的过程中，绝大部分列出的特性都是通过插件来实现的

## 在现有的项目中安装插件

如果你想在一个已经被创建好的项目中安装一个插件，可以使用 `vue add` 命令

`vue add router`


# 开发

## 处理资源路径

当你在JavaScript、css或vue文件中使用相对路径(必须以`.`开头)引用一个静态资源时，该资源将被webpack处理。(public中文件webpack不会处理)

### 转换规则

如果URL是一个绝对路径(例如`/images/foo.png`),他将会保留不变。

``` html
<img alt="vue logo" src="/assets/logo.png">//当前服务器静态路径下 public会作为服务器静态路径
<img alt="vue logo" src="http://image.xx.com/logo.png">//某图片服务器线上地址
```

如果URL以`.`开头会作为一个相对模块请求被解释并基于文件系统相对路径

``` html
<img alt="vue logo" src="./assets/logo.png">
```

如果URL以`~`开头会作为一个模块请求被解析，这意味着你甚至可以引用Node模块中的资源

``` html
<img alt="vue logo" src="~some-npm-package/foo.png">
```

如果URL以`@`开头会作为一个模块请求被解析，Vue Cli默认会设置一个指向`src`的别名`@`

``` js
import Hello from '@/components/Hello.vue'
```

### 何时使用`public`文件夹

通过webpack的处理并获得如下好处：

- 脚本和样式表会被压缩并且打包在一起，从而避免额外的网络请求

- 文件丢失会直接在编译时报错，而不是到了用户端才会产生404错误

- 最终生成的文件名包含了内容哈希，因此不用担心浏览器缓存他们的老版本

以下的几种情况可以考虑使用public文件夹

- 你需要在构建输出中指定一个固定的文件名字

- 你有上千个图片，需要动态引用他们的路径

- 有些库可能会和webpack不兼容，除了将其用一个独立的`<script>`标签引入没有别的办法

### 使用public文件夹的注意事项

如果你的应用没有部署在域名的根部，那么你需要为你的URL配置`publicPath`前缀

``` js
//vue.config.js
module.export = {
    publicPath: precess.env.NODE_ENV === 'production'?'线上所在目录':'本地所在目录 正常为 / '
}
```

在`public/index.html` 等通过`html-webpack-plugin`用作模板的HTML文件中，你需要用过`<% =BASE_URL %>` 设置链接前缀：

``` html
<link rel="icon" href="<% =BASE_URL %>favicon.ico">
```

在模板中，先向组件传入BASE_URL：
``` js
data(){
    return{
        publicPath: process.env.BASE_URL
    }
}
```
在使用的时候
```js
<img :src="`${publicPath}my-image.png`">
```



<!-- markdownlint-disable MD041 MD002--> 