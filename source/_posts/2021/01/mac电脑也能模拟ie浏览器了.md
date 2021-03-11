---
title: mac电脑也能模拟ie浏览器了
date: 2021-01-10 11:01:42
tags:
    - 前端
    - ie
categories:
    - 前端
    - ie
description:
---

在我们日常开发中难免会遇到需要兼容ie浏览器的情况，这就让我们mac用户十分头疼。
本文可以解决此类问题
<!-- more -->

1. 打开safair浏览器，在偏好设置 -> 高级 -> 在菜单栏中显示“开发”菜单

2. 开发 -> 用户代理

    - 有需要的ie版本则选择需要的版本

    - 没有的话，点开其他，参照下表贴入需要的对应的代理字符串

    |  系统平台   | 浏览器  | 代理字符串  |
    |  ----  | ----  |----  |
    |  Windows  | IE 5 | Mozilla/4.0 (compatible; MSIE 5.0; Windows NT; WOW64; Trident/4.0; SLCC1) |
    |  Windows  | IE 6 | Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; WOW64; Trident/4.0; SLCC1) |
    |  Windows  | IE 7 | Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; WOW64; Trident/4.0; SLCC1) |
    |  Windows  | IE 8 | Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0) |
    | Windows  | IE 9 |Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0) |
    | Windows  | IE 10 |Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; WOW64; Trident/6.0) |
    | Windows  | IE 11 | Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko |

<!-- markdownlint-disable MD041 MD002--> 