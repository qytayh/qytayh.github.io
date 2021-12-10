---
title: webpack进行前端开发工程环境搭建
date: 2021-08-16 11:36:37
tags:
 - webpack
categories:
 - webpack
description:
---

在阅读这篇文章之前，请确认你已经了解了webpack的基本常识
> [还不了解？点击查看《webpack基础》](https://qytayh.github.io/2021/08/webpack%E5%9F%BA%E7%A1%80/)

<!-- more -->
# 安装依赖

多人协作时，可以在项目根目录下新建一个`.npmrc`文件用来指定npm源

```shell
# 统一团队的npm源
registry=https://registry.npm.taobao.org
# 使用npm install的时候就会默认淘宝源
```

# 项目搭建

## 样式 静态资源 (图片第三方字体) es6+ (vue react ts)

### 样式：借助css-loader处理css语法，借助style-loader使用css

```js
module: {
    rules: [
      {
        // webpack处理css内容
        test: /\.css$/,
        // 多个loader情况下 执行顺序自后往前
        use: ["style-loader", "css-loader"],
      },
      {
        test:/\.less$/,
        // 先将less语法转成css语法
        use: ["style-loader", "css-loader","less-loader"]
      },
      {
        test:/\.scss$/,
        use: ["style-loader", "css-loader","sass-loader"]
      },
    ],
  },
```
> [postcss官网](https://www.postcss.com.cn/)

```js
根目录下新增`postcss.config.js`
module.exports = {
  plugins:[
    require("autoprefixer"),// 浏览器兼容
    require("cssnano") // css 压缩
  ]
}
```

> `package.json`中`"browserslist":["last 2 versions","> 1%"]`用于配置`autoprefixer`自动兼容版本（兼容所有浏览器最近的两个大版本，全球市场占有率大于1%的浏览器）
> 更多点击 --> [Browserslist](https://qytayh.github.io/2021/08/Browserslist/)

安装`mini-css-extract-plugin`用来做样式提取，将css样式抽离成css文件
```shell
npm install mini-css-extract-plugin -D
```
修改`webpack.config.js`中的配置
```js
const minicssExtractPlugin = require('mini-css-extract-plugin')//先进行引用

module.exports = {
  ...
   module: {
    rules: [
      ...
      {
        test:/\.less$/,
        // 将style-loader替换成minicssExtractPlugin自带的loader
        use: [minicssExtractPlugin.loader, "css-loader", "postcss-loader","less-loader"]
      },
      ...
    ],
  },
  plugins: [
    ...
    new minicssExtractPlugin({ // 将样式抽离成独立的css文件
      filename:"[name].css",
    }),
    ...
  ],
  ...
}

```

### 图片/字体⽂件处理：

- file-loader 
- url-loader

`url-loader`和`file-loader`都可以⽤来处理本地的资源⽂件，如图⽚、字体、⾳视频等。功能也是类似的，不过`url-loader`可以指定在⽂件⼤⼩⼩于指定的限制时，返回`DataURL`，不会输出真实的⽂件，可以减少昂贵的⽹络请求。

```shell
#安装
npm install url-loader file-loader -D
```

```js
// 使用
import pic from 'you pic url'

const img = new Image()
img.src = pic

const root = document.getElementById('app')
root.append(img)

// webpack配置
{
  test:/\.(png|jp?g|gif|webp)$/,
  // use:"file-loader"
  use:{
    loader:'file-loader',
    options:{
      name:"images/[name].[ext]", // ext 为后缀占位符 使用原后缀输出
      outputPath:'images',// 输出目录
      publicPath:'../images' // 引用的目录自动带上publicPath路径
    }
  }

  // use:"url-loader"  url-loader兼容file-loader的配置
  use:{
    loader:'url-loader',
    options:{
      name:"images/[name].[ext]", // ext 为后缀占位符 使用原后缀输出
      outputPath:'images',// 输出目录
      publicPath:'../images', // 引用的目录自动带上publicPath路径
      limit: 1024*10   // 单位是字节 1024为一个kb  大于limit值为png格式 小于limit值 转base64
    }
  }
}

```
> [file-loader更多相关](https://github.com/webpack-contrib/file-loader)
> 如果需要使⽤图⽚压缩功能，可以使⽤`image-webpack-loader`。

### 字体

```
//css
@font-face {
  font-family: "webfont";
  font-display: swap;
  src: url("webfont.woff2") format("woff2");
}

body {
  background: blue;
  font-family: "webfont"!important;
}

//webpack.config.js
{
  test: /\.(eot|ttf|woff|woff2|svg)$/,
  use: "file-loader"
}
```

### hash

- `hash`策略

  > 在输出的文件名后添加`[hash]`，可以用`[hash:8]`控制文件名中hash长度  
  > 以项目为单位，项目内容改变，则会生产新的hash，内容不变hash不变

- 使用`chunkhash`

  > 以`chunk`为单位，当一个文件内容改变，则整个chunk组的模块hash都会改变  
  > `[name]-[chunkhash:8].[ext]`

- `contenthash`

  > 以自身内容为单位








<!-- markdownlint-disable MD041 MD002--> 