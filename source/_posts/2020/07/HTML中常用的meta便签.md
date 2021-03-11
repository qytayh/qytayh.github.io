---
title: HTML中常用的meta便签
date: 2020-07-26 21:37:31
tags:
categories:
description:
---

`<meta>`元素可提供有关页面的元信息（meta-information），比如针对搜索引擎和更新频度的描述和关键词。

`<meta>`标签位于文档的头部，不包含任何内容。`<meta>`标签的属性定义了与文档相关联的名称/值对。

<!-- more -->
## 定义

标签提供关于HTML文档的元数据。它不会显示在页面上，但是对于机器是可读的。可用于浏览器（如何显示内容或重新加载页面），搜索引擎（关键词），或其他 web 服务。

## 作用

meta里的数据是供机器解读的，告诉机器该如何解析这个页面，还有一个用途是可以添加服务器发送到浏览器的http头部内容，例如我们为页面中添加如下meta标签：
```html
<meta http-equiv="charset" content="iso-8859-1">
<meta http-equiv="expires" content="31 Dec 2008">
```
浏览器的头部就会包括这些:
```
charset:iso-8859-1
expires:31 Dec 2008
```
只有浏览器可以接受这些附加的头部字段，并能以适当的方式使用它们时，这些字段才有意义。





<!-- markdownlint-disable MD041 MD002--> 