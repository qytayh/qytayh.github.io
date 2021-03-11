---
title: 实现vue弹窗组件(一)
date: 2020-07-01 20:06:57
tags:
    - vue
categories:
    - vue
description:
---

本文讲述如何使用`render()`，构造一个弹窗组件

[点击这里查看](https://qytayh.github.io/2020/07/%E5%AE%9E%E7%8E%B0vue%E5%BC%B9%E7%AA%97%E7%BB%84%E4%BB%B6(%E4%BA%8C)/),使用`Vue.extend()`构造弹窗组件，并实现全局调用

<!-- more -->

弹窗这类组件的特点是他们**在当前vue实例之外独立存在**，通常挂载于body；他们是通过JS动态创建的，不需要在任何组件中声明。常见的使用姿势：

```js
this.$create(Notice, {
    title: "标题",
    message: "提示信息",
    duration: 2000//延时时间
}).show();
```

## create函数

创建utils/create.js,并添加以下代码

```js
import Vue from 'vue'
function create(Component,props){
    // 组件构造函数如何获取？
    // 1.Vue.extend()
    // 2.render
    const vm = new Vue({
        // h是createElement, 返回VNode，是虚拟dom
        // 需要挂载才能变成真实dom
        render: h => h(Component, {props}),
    }).$mount() // 不指定宿主元素，则会创建真实dom，但是不会追加操作

    //获取真实dom————vm.$el,并挂载到body上
    document.body.appendChild(vm.$el)

    const comp = vm.$children[0]
    // 删除
    comp.remove = function(){
        document.body.removeChild(vm.$el)
        vm.$destroy()
    }

    return comp
}
export default create
```

## 弹窗组件

新建弹窗组件，`Notice.vue`

``` vue
<template>
  <div class="box" v-if="isShow">
    <h3>{{title}}</h3>
    <p class="box-content">{{message}}</p>
  </div>
</template>
<script>
export default {
  props: {
    title: {
      type: String,
      default: ""
    },
    message: {
      type: String,
      default: ""
    },
    duration: {
      type: Number,
      default: 1000
    }
  },
  data() {
    return {
      isShow: false
    };
  },
  methods: {
    show() {
      this.isShow = true;
      setTimeout(this.hide, this.duration);
    },
    hide() {
      this.isShow = false;
      // 清除自己
      this.remove();
    }
  }
};
</script>

<style>
.box {
  position: fixed;
  width: 100%;
  top: 16px;
  left: 0;
  text-align: center;
  pointer-events: none;
  background-color: #fff;
  border: grey 3px solid;
  box-sizing: border-box;
}
.box-content {
  width: 200px;
  margin: 10px auto;
  font-size: 14px;  
  padding: 8px 16px;
  background: #fff;
  border-radius: 3px;
  margin-bottom: 8px;
}
</style>
```

## 使用弹窗组件

在需要使用该组件的vue文件中
```js
import Notice from "@/components/Notice.vue";
import create from './utils/create'

methods: {
    showNotice() {
        create(Notice, {
            title: "标题",
            message: "提示信息",
            duration: 2000//延时时间
        }).show();
    }
};
```



<!-- markdownlint-disable MD041 MD002--> 