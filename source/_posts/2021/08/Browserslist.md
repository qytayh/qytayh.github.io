---
title: Browserslist
date: 2021-08-17 11:07:32
tags:
 - webpack
categories:
 - webpack
description:
---

`browserslist`实际上就是声明了⼀段浏览器的集合，我们的⼯具可以根据这段集合描述，针对性的输出兼容性代码。

<!-- more -->

[Browserslist](https://github.com/browserslist/browserslist)就是帮助我们来设置⽬标浏览器的⼯具。`Browserslist` 被⼴泛的应⽤到 `Babel`、`postcsspreset-env`、`autoprefixer` 等开发⼯具上。

# 配置

`Browserslist`的配置可以放在`package.json`中，也可以单独放在配置⽂件`.browserslistrc`中。所有的⼯具都会主动查找`browserslist`的配置⽂件，根据 `browserslist`配置找出对应的⽬标浏览器集合。

Browserslist 的数据都是来⾃Can I Use:https://browserl.ist/

可惜⽹站关闭了，现在需要⼿动检测：

```shell
npx browserslist "last 1 version, >1%"
```

在`package.json`中的配置是增加⼀个`browserslist`数组属性：
```json
{
"browserslist": ["last 2 version", "> 1%", "maintained node versions", "not
ie < 11"]
}
```

或者在项⽬的根⽬录下创建⼀个`.browserslistrc`⽂件：
```
# 注释是这样写的，以#号开头
# 每⾏⼀个浏览器集合描述
last 2 version
> 1%
maintained node versions
not ie < 11
```

# 常⻅集合范围说明

| 范围 | 说明 |
| ---- | ---- |
| last 2 versions | caniuse.com⽹站跟踪的最新两个版本，假如 iOS 12 是最新版本，那么向后兼容两个版本就是 iOS 11 和 iOS 12 |
| > 1% | 全球超过 1%⼈使⽤的浏览器，类似> 5% in US 则指代美国 5%以上⽤户 |
| cover 99.5% | 覆盖 99.5%主流浏览器 |
| chrome > 50   ie 6-8 | 指定某个浏览器版本范围 |
| unreleased versions | 所有浏览器的 beta 版本 |
| not ie < 11 | 排除 ie11 以下版本不兼容 |
| since 2013  last 2 years | 某时间范围发布的所有浏览器版本 |
| maintained node versions | 所有被 node 基⾦会维护的 node 版本 |
| current node | 当前环境的 node 版本 |
| dead | 通过last 2 versions 筛选的浏览器中，全球使⽤率低于0.5% 且官⽅声明不再维护或者事实上已经两年没有再更新的版本 |
| defaults | 默认配置， > 0.5% last 2 versions Firefox ESR not dead |


# 常见浏览器名称

| 名称 | 中文对照 |
| ---- | ---- |
| Android | 安卓 webview 浏览器 |
| Baidu | 百度浏览器 |
| BlackBerry / bb | ⿊莓浏览器 |
| Chrome  | chrome 浏览器 |
| ChromeAndroid / and_chr | chrome 安卓移动浏览器 |
| Edge | 微软 Edge 浏览器 |
| Electron | Electron |
| Explorer / ie | ie 浏览器 |
| ExplorerMobile / ie_mob | ie 移动浏览器 |
| Firefox / ff  | ⽕狐浏览器 |
| FirefoxAndroid / and_ff | ⽕狐安卓浏览器 |
| iOS / ios_saf | iOS Safari 浏览器 |
| Node | nodejs |
| Opera | Opera浏览器 |
| OperaMini / op_mini | operaMini 浏览器 |
| OperaMobile / op_mob | opera 移动浏览器 |
| QQAndroid / and_qq | QQ安卓浏览器 |
| Samsung | 三星浏览器 |
| Safari | 桌⾯版本 Safari |
| UCAndroid / and_uc | UC 安卓浏览器 |



<!-- markdownlint-disable MD041 MD002--> 