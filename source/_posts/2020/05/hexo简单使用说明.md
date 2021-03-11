---
title: hexo简单使用说明
date: 2020-05-19 15:34:28
tags: hexo
categories: hexo
description: 一些使用hexo常用的命令
---
# 一些使用hexo常用的命令
<!-- more -->


## 命令行

``` bash
hexo n "博客名称"  => hexo new "博客名称"   #这两个都是创建新文章，前者是简写模式
hexo p  => hexo publish
hexo g  => hexo generate  #生成
hexo s  => hexo server  #启动服务预览
hexo clean  //清除缓存 网页正常情况下可以忽略此条命令
hexo d  => hexo deploy  #部署
hexo publish [layout] <title>
``` 

## 引入图片
``` bash
![图片alt](图片地址 ''图片title'')
图片alt就是显示在图片下面的文字，相当于对图片内容的解释。
图片title是图片的标题，当鼠标移到图片上时显示的内容。title可加可不加
例如
![百度](https://www.baidu.com/img/flexible/logo/pc/result@2.png)
或者
{% asset_img slug [title] %}
{% asset_img result@2.png [title] %}

```


![第一种](https://www.baidu.com/img/flexible/logo/pc/result@2.png)

{% asset_img result@2.png [第二种] %}




## 超链接
``` bash
[超链接名](超链接地址 "超链接title")
例如
[简书](http://jianshu.com)
```

[百度](http://www.baidu.com)


## 无序列表

使用符号`-`

- 第一个
- 第二个
。。。。。。

## 字体加粗

```bash
**需要加粗的内容**
```
**需要加粗的内容**

## 引用

```bash
> 内容
>> 内容
>>> 内容
```
> 内容
>> 内容
>>> 内容
