---
title: webpack基础
date: 2021-08-12 10:41:25
tags:
 - webpack
categories:
 - webpack
description:
 - 本文基于webpack4.x
---


# webpack简介

<!-- more -->


`Webpack` 是⼀个现代 `JavaScript` 应⽤程序的静态模块打包器（`module bundler`），当 `webpack` 处理应⽤程序时，它会递归地构建⼀个依赖关系图(d`ependency graph`)，其中包含应⽤程序需要的每个模块，然后将所有这些模块打包成⼀个或多个 `bundle`。

`Webpack`是⼀个打包模块化`JavaScript`的⼯具，它会从⼊⼝模块出发，识别出源码中的模块化导⼊语句，递归地找出⼊⼝⽂件的所有依赖，将⼊⼝和其所有的依赖打包到⼀个单独的⽂件中是⼯程化、⾃动化思想在前端开发中的体现。


# webpack安装

环境准备
  nodejs:：`https://nodejs.org/en/`
  版本参考官⽹发布的最新版本，可以提升webpack的打包速度

安装⽅式

  局部安装（推荐）

  ```shell
  npm init -y # 初始化npm配置⽂件
  npm install --save-dev webpack # 安装核⼼库
  npm install --save-dev webpack-cli # 安装命令⾏⼯具
  # 安装4.x稳定版本
  npm i -D webpack@4.44.0
  # 安装指定版本
  npm i -D webpack@<version>
  ```

  全局安装（不推荐）
  ```shell
  # 安装webpack V4+版本时，需要额外安装webpack-cli
  npm install webpack webpack-cli -g
  # 检查版本
  webpack -v
  # 卸载
  npm uninstall webpack webpack-cli -g
  ```
> 全局安装webpack，这会将你项⽬中的webpack锁定到指定版本，造成不同的项⽬中因为webpack依赖不同版本⽽导致冲突，构建失败


# 启动webpack

> 启动wekpack执行构建，默认`mode=production`(默认开启代码压缩)

1. webpack默认配置

  - webpack默认⽀持JS模块和JSON模块
  - ⽀持CommonJS Es moudule AMD等模块类型
  - webpack4⽀持零配置使⽤,但是很弱，稍微复杂些的场景都需要额外扩展

2. 准备执⾏构建

  - 新建`src`⽂件夹
  - 新建`src/index.js`、`src/index.json`、`src/other.js`


```js
// index.js
const json = require("./index.json");//commonJS
import { add } from "./other.js";//es module
console.log(json, add(2, 3));
// index.json
{
"name": "JOSN"
}
//other.js
export function add(n1, n2) {
  return n1 + n2;
}
```

3. 执⾏构建

```shell
# npx⽅式
npx webpack
# npm script
npm run dev
# 修改package.json
"scripts": {
  "dev": "webpack"
},
```
> 原理就是通过shell脚本在`node_modules/.bin`⽬录下创建⼀个软链接。

4. 我们会发现⽬录下多出⼀个`dist`⽬录，⾥⾯有个`main.js`，这个⽂件是⼀个可执⾏的`JavaScript`⽂件，⾥⾯包含`webpackBootstrap`启动函数。

5. 默认配置

```js
const path = require('path')
// 默认配置
module.exports = {
  entry:'./src/index.js',
  output:{
    path:path.resolve(__dirname,'./dist'), // 输出的文件存放的目录
    filename:'main.js' // 输出的文件名称
  },
  mode:'development',// 模式
}
```
> `webpack`配置名默认为`webpack.config.js`,也可以用其他命名，其他命名需要修改`package.json`
> "scripts": {
  "dev": "webpack --config ./youFileName.js"
}

6. 多入口对应多出口

```js
module.exports = {
  // entry支持：字符串 对象 数组
  // 字符串数组对应单页面应用
  // 对象可以单页面应用也可以多页面应用
  entry:{
    index:'./src/index.js',
    a:'./src/a.js'
  },
  // entry:['./src/index.js','./src/a.js'],
  output:{
    path:path.resolve(__dirname,'./dist'), // 输出的文件存放的目录
    filename:'[name].js'// 输出的文件名称 使用占位符 index打包成index.js a打包成a.js
  },
  mode:'development',// 构建模式  none development production
}
```

# webpack配置核⼼概念

- chunk：指代码块，⼀个`chunk`可能由多个模块组合⽽成，也⽤于代码合并与分割。
- bundle：资源经过`Webpack`流程解析编译后最终结输出的成果⽂件。(输出到dist的文件)
- entry：顾名思义，就是⼊⼝起点，⽤来告诉webpack⽤哪个⽂件作为构建依赖图的起点。`webpack`会根据`entry`递归的去寻找依赖，每个依赖都将被它处理，最后输出到打包成果中。
- output：`output`配置描述了`webpack`打包的输出配置，包含输出⽂件的命名、位置等信息。
- loader：默认情况下，`webpack`仅⽀持`.js` `.json` ⽂件，通过`loader`，可以让它解析其他类型的⽂件，充当翻译官的⻆⾊。理论上只要有相应的`loader`，就可以处理任何类型的⽂件。
- plugin：`loader`主要的职责是让`webpack`认识更多的⽂件类型，⽽`plugin`的职责则是让其可以控制构建流程，从⽽执⾏⼀些特殊的任务。插件的功能⾮常强⼤，可以完成各种各样的任务。
  + `webpack`的功能补充
- mode：4.0开始，`webpack`⽀持零配置，旨在为开发⼈员减少上⼿难度，同时加⼊了`mode`的概念，⽤于指定打包的⽬标环境，以便在打包的过程中启⽤`webpack`针对不同的环境下内置的优化。


```js
const path = require("path");
const htmlwebpackplugin = require("html-webpack-plugin");
// 默认配置
module.exports = {
  entry: "./src/index.js",
  output: {
    path: path.resolve(__dirname, "./dist"), // 输出的文件存放的目录
    filename: "main.js", // 输出的文件名称
  },
  mode: "development",
  module: {
    rules: [
      {
        // webpack处理css内容
        test: /\.css$/,
        // 多个loader情况下 执行顺序自后往前
        use: ["style-loader", "css-loader"],
      },
    ],
  },
  plugins: [
    new htmlwebpackplugin({
      template: "./src/index.html",
      filename: "index.html",
    })
  ],
};

```

> webpack 默认只支持.js .json类型的模板。loader需要通过npm 进行安装`npm install style-loader -D`,`npm install css-loader -D`


<!-- markdownlint-disable MD041 MD002--> 