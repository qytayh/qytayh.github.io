---
title: BFC布局
date: 2020-12-7 14:09:51
tags:
    - css
categories:
    - css
description:
---

这篇文章主要介绍的是关于块格式化上下文（Block Formatting Context），也就是大家俗称的BFC。你可能从未听说过这个术语，但只要你曾经使用过CSS布局，你就可能知道它是什么。理解BFC是什么，它有什么功能，以及如何创建一个BFC是非常有用的，这些能帮助你更好的理解CSS布局。

<!-- more -->

# 什么是BFC

通过一个简单的float布局示例就能很好的理解BFC的行为。在下面的示例中，我们创建了一个盒子（其实在CSS中，每个元素都是一个盒子），这个盒子中包含了一个设置了浮动的图片和一段文本。如果有足够多的文本内容的时候，文本会围绕着图片（把整个图片包裹起来。

```html
<!-- html -->
<div class="outer">
    <div class="float">I am a floated element.</div>
    I am text inside the
        <!-- outer box.If there is enough text 
    then the text will wrap around the floated element.
    The border on the outer will then wrap around the text. -->
</div>
```

```css
/* css */
.outer {
    border: 3px dotted red;
    border-radius: 5px;
    width: 400px;
    padding: 10px;
    margin-bottom: 40px;
}

.float {
    padding: 10px;
    border: 3px solid teal;
    border-radius: 3px;
    background-color:skyblue;
    color: #fff;
    float: left;
    width: 200px;
    margin: 0 20px 0 0;
}
```

{% asset_img 1.png  %}

如果在上面的基础上删除一些文本，就没有足够的文本去围绕图片，同时由于浮动元素脱离文档流，盒子元素的边框高度就会随着文本的减少而降低（常被理解为元素浮动之后使得其父元素坍塌）。

{% asset_img 2.png  %}

之所以会这样，是因为当一个元素浮动时，盒子依然保持原来的宽度，使文本所占的空间缩短了,才给浮动的元素腾出位置，这就是为什么背景和边框都能够看起来包裹住了浮动的元素。

有两种方案可以解决这个布局问题。
- 一种是使用`clearfix`黑魔法，就是在文本和浮动元素的下面加一个元素，比如`div`，并将`clear`属性设置为`both`

```html
<!-- html -->
<div class="outer">
    <div class="float">I am a floated element.</div>
    I am text inside the
    <div class="clear"></div>
        <!-- outer box.If there is enough text 
    then the text will wrap around the floated element.
    The border on the outer will then wrap around the text. -->
</div>
```
```css
.clear{
    clear:both
}
```


- 另一种方法就是使用`overflow`属性，把它设置为非`visible`的值。

```html
<div class="outer">
    <div class="float">I am a floated element.</div>
    I am text inside the
</div>
```
```css
.outer{
    ...
    overflow:auto;/* 补上这个属性 */
}
```
使用`overflow:auto`后盒子就能包裹浮动元素。

{% asset_img 3.png  %}

`overflow`之所以能够有效是因为它的值是非`visible`时会创建一个BFC，而BFC的特性就是包裹浮动元素

> 使用Clearfix黑魔法时，除了在浮动的元素和文本最下面插入一个元素之外，更简单，也是最为经典的方式是使用CSS的伪元素::after或伪类:after。其实也就是大家常说的清除浮动.

# 清除浮动

除了在浮动的元素和文本最下面插入一个元素之外，更简单，也是最为经典的方式是使用CSS的伪元素::after或伪类:after

## 使用伪元素 ::after

```css
.outer::after{
    content: "";
    display: block;
    clear: both;
}
```

## 使用伪类 :after

```css
.outer:after{
    content:"";
    display:block;
    clear:both;
}
```
> 该方法在 ie6、7 中无效，需要对 .outer 设置 zoom:1












<!-- markdownlint-disable MD041 MD002--> 