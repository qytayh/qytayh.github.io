---
theme: condensed-night-purple
---

## 写在前面

耗子君QAQ的这篇 [组件库设计 | 如何开发一个组件库CLI](https://juejin.cn/post/7012564452545396750) 中大致讲了组件库 cli 的开发思路以及使用到的相关工具。

受篇幅的影响可能不是很详细，所以经过 `varlet core team` 商量后，我们决定以专栏的形式来将组件库的实现尽可能的介绍清楚。

如果你是对组件库实现原理十分好奇的人，本专栏对你应该会有所启发。如果你想快速具备开发组件库的能力，并不想对底层实现刨根问底，你可以尝试使用 [Varlet-Cli](https://varlet.gitee.io/varlet-ui/#/zh-CN/cli) 直接开始组件库开发。

<!-- more -->

## 简介

学习一门技术的最好方法，就是在实践中使用它。

本专栏将以 [Varlet-Cli](https://varlet.gitee.io/varlet-ui/#/zh-CN/cli) 展开主要介绍如何从`0`到`1`开发一个组件库的实战过程。

本专栏将按基础篇、进阶篇、实战篇、总结篇进行编排：

- 基础篇：你将学到 cli 开发过程中常用的关于 node 的一些基本概念。

- 进阶篇：你将学会使用 cli 开发中常用的工具，并开始能尝试做一些简单的 cli 。

- 实战篇：这一部分我们将以 [Varlet-Cli](https://varlet.gitee.io/varlet-ui/#/zh-CN/cli) 为例，挑选出核心部分的代码实现进行讲解。

- 总结篇：总结本专栏的重要知识点。

## 关于我

笔者是 `varlet core team` 中的一员，目前在团队中主要负责对 pr 的 review，有较大 change 时负责协调团队里人员进行修改，新 feature 的跟进，以及该专栏的持续输出。

本专栏，讲述我参与开源的过程中以及看完 [varlet](https://github.com/varletjs/varlet) 源码后的一些收获以及感悟。

如果这个专栏可以给你们带来一些灵感或者带来一些帮助，那这个专栏的目的就达到了。

## Varlet组件库相关链接，希望多多鼓励和支持

[Github仓库](https://github.com/varletjs/varlet)

[中文文档](https://varlet.gitee.io/varlet-ui/#/zh-CN/home)

[英文文档](https://varlet.gitee.io/varlet-ui/#/en-US/home)

[耗子君QAQ主页](https://juejin.cn/user/1046390801697319)

## 最后

如果这个系列你能掌握，我们诚邀你加入我们的核心团队。
