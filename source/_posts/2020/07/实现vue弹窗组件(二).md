---
title: 实现vue弹窗组件(二)
date: 2020-07-01 21:01:50
tags:
    - vue
categories:
    - vue
description:
---

本文讲述如何使用`Vue.extend()`构造弹窗组件，并实现全局调用

[点击这里查看](https://qytayh.github.io/2020/07/%E5%AE%9E%E7%8E%B0vue%E5%BC%B9%E7%AA%97%E7%BB%84%E4%BB%B6(%E4%B8%80)/)，查看如何使用`render()`,构造一个弹窗组件

<!-- more -->

## 准备工作

在`components`文件夹下新建`Tools`文件夹用于存放所有的全局组件，`Tools`文件夹下新增`Notice`文件夹，并在其中新建`Notice.vue`和`Notice.js`

## 修改`Notice.js`

在`Notice.js`中添加如下代码
```js
import Vue from 'vue';
import Notice from './Notice.vue';

// 获取组件构造器
const notice = Vue.extend(Notice);
let VM = ''; 
function AModal() {
  return function(type, props) {
    if (!props.text) return;
    if (!VM) {
      const oDiv = document.createElement('div');
      // 创建notice实例
      VM = new notice({ el: oDiv });
      // 并把实例化的模板插入body
      document.body.appendChild(VM.$el);
    }
    // 设置属性
    VM.type = type;
    VM.text = props.text;
    VM.timeout = !props.timeout&&props.timeout!=0?3000:props.timeout;
    VM.show = true;
    setTimeout(() => {
      VM.show = false;
    }, VM.timeout);
  };
}
let SHOW = AModal();
function warning(props) {
  SHOW('warning', props);
}
function info(props) {
  SHOW('info', props);
} 
function success(props) {
  SHOW('success',props);
}
function error(props) {
  SHOW('error', props);
}
export default {
  warning,
  success,
  info,
  error
};
```

## 编写弹窗组件

在`Notice.vue`中，添加如下代码
```vue
<template>
  <div v-if="show" class="box">
      <div :class="type">
        <strong>{{text}}</strong>
      </div>
  </div>
</template>

<script>
export default {
    props: ["show", "text", "type"],
}
</script>
<style>
.box {
  position: fixed;
  width: 100%;
  top: 16px;
  left: 0;
  text-align: center;
  pointer-events: none;
  border: grey 3px solid;
  box-sizing: border-box;
}
.success {
  background: #4caf50 !important;
}
.info {
  background: #2196f3 !important;
}
.warning {
  background: #ffc107 !important;
}
.error {
  background: #ff1744 !important;
}
</style>
```

## 注册全局组件

在`main.js`中，添加如下代码

```js
import notice from './components/Tools/Notice/Notice'

Vue.prototype.$notice = notice

```

## 使用弹窗组件

在需要使用该组件的vue文件中
```js
this.$notice.info({text:"Joker真帅",timeout:9999})
this.$notice.success({text:"Joker真帅"})
```

就可以尽情使用了


<!-- markdownlint-disable MD041 MD002--> 