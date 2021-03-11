---
title: Vue中Watch和Computed的差异
date: 2020-05-30 10:58:33
tags:
    - vue
categories:
    - vue
description:
---

计算属性 vs 监听器

<!-- more -->

# 语境上的差异

``` js
//一个值变化了，我要做些事情，适合一个值影响多个值的情形
watch:{
    firstname(newval,oldval){
        this.fullname = this.firstname + '' + this.lastname
    },
    lastname(newval,oldval){
        this.fullname = this.firstname + '' + this.lastname
    }
}
//一个值由其他值得来，这些值变化了我也要变，适合多个值影响一个值的情形
computed:{
    fullname(){
        return this.firstname + '' + this.lastname
    }
}
```

# 计算属性有缓存性

计算所得的值如果没有变化不会重复执行

# 监听器选项
    
监听器选项提供了更通用的方法，适合执行异步操作或者较大开销操作的情况
    
[点击查看范例](https://cn.vuejs.org/v2/guide/computed.html#%E4%BE%A6%E5%90%AC%E5%99%A8)
    
我们可以在范例中看到，在created的时候将我们要发送的请求做了一次防抖处理的封装，输入停止500毫秒后才会触发，这样就可以很有效的控制请求的频率






<!-- markdownlint-disable MD041 MD002--> 