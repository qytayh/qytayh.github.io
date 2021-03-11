---
title: 实现一个简易Vuex
date: 2020-07-12 15:06:57
tags:
    - vue
categories:
    - vue
description:
---

在阅读本篇之前，希望你已经对vuex的用法有了一定了解。可以参考一下[Vue统一状态管理——Vuex](https://qytayh.github.io/2020/06/Vue%E7%BB%9F%E4%B8%80%E7%8A%B6%E6%80%81%E7%AE%A1%E7%90%86%E2%80%94%E2%80%94Vuex/)。

<!-- more -->

# Vuex 

Vuex**集中式**存储管理应用的所有组件的状态，并以相应的规则保证状态以**可预测**的方式发生改变

{% asset_img 1.png [第一步] %}

## 整合vuex

```bash
vue add vuex
```

## 核心概念

+ state 状态、数据
+ mutations 更改状态的函数
+ actions 异步操作
+ store 包含以上概念的容器

## 状态 - state

state保存应用状态

```js
export default new Vuex.Store({
    state: { counter:0 },
})
```

## 状态变更 - mutations

mutations用于修改状态

```js
export default new Vuex.Store({
    mutations: {
        add(state) {
            state.counter++
        }
    }
})
```

## 派生状态 - getters

从state派生出新状态，类似计算属性

```js
export default new Vuex.Store({
    getters: {
        doubleCounter(state) { // 计算剩余数量
            return state.counter * 2;
        }
    }
})
```

## 动作 - actions

添加业务逻辑，类似于controller

```js
export default new Vuex.Store({
    actions: {
        add({ commit }) {
            setTimeout(() => { commit('add')}, 1000);
        }
    }
})
```

测试代码：

```html
<p @click="$store.commit('add')">counter: {{$store.state.counter}}</p>
<p @click="$store.dispatch('add')">async counter: {{$store.state.counter}}</p>
<p>double：{{$store.getters.doubleCounter}}</p>
```

# Vuex原理解析

## 目标分析：

+ 实现一个插件：声明store类，挂载$store
+ Store具体实现：
    * 创建响应式的state，保存mutations、actions和getters
    * 实现commit根据用户传入的type，执行对应的mutation
    * 实现dispatch根据用户传入的type执行对应的action，同时传递上下文
    * 实现getters，按照getters定义对state做派生

## 初始化

Store声明、install实现，jvuex.js：

```js
// jvuex
let Vue //保存构造函数的引用，避免import
class Store{
    constructor(options){
        //响应化处理state
        this.state = new Vue({
            data: options.state
        })
    }
}
function install(_Vue){
    Vue = _Vue
    Vue.mixin({
        beforeCreate(){
            if(this.$options.store){
                Vue.prototype.$store = this.$options.store
            }
        }
    })
}
export default {
    Store,
    install
}
```

## 实现 commit

根据用户传入type获取并执行对应的mutation

```js
//修改 Store类
class Store{
    constructor(options){
        this._mutations = options.mutations
        //响应化处理state
        this.state = new Vue({
            data: options.state
        })
    }
    // store.commit('add',1)
    //type:mutation的类型
    //payload：载荷，参数
    commit(type,payload){
        const entry = this._mutations[type]
        if(entry){
            entry(this.state,payload)
        }
        
    }
}
```

## 实现 actions

根据用户传入的type获取并执行对应的mutation

```js
//继续修改Store类
dispatch(type,payload){
    const entry = this._actions[type]
    if (entry) {
        entry(this, payload)
    }
}
```
然后我们运行一下会发现报以下错误
{% asset_img 2.png [报错信息] %}

> 错误原因：因为class的影响，this指向出了问题

参考了一下官方的解决方案，我们修改Store：
```js
constructor(options) {
    ......
    //绑定 commit、dispatch的上下文
    this.commit = this.commit.bind(this)
    this.dispatch = this.dispatch.bind(this)
}
```

## 优化state

目前的代码还没有对state做一个很好的保护，会存在将来用户直接去改state中的值得行为，继续修改Store的代码

```js
constructor(options) {
    ......
    //响应化处理state
    // this.state = new Vue({
    //     data: options.state
    // })
    this._vm = new Vue({
        data:{
            //加两个$，Vue不做代理 对外部是隐藏的
            $$state:options.state
        }
    })
    ......
}
//存取器 store.state
get state(){
    console.log(this._vm)
    return this._vm._data.$$state
}
set state(v){
    console.error('禁止这样修改')
}
```

## 实现 getters

继续修改Store类
```js
class Store {
    constructor(options) {
        ......
        this._wrapperGetters = options.getters
        //定义computed选项
        const computed = {}
        this.getters = {}
        const store=this
        //
        Object.keys(this._wrapperGetters).forEach(key=>{
            //获取用户定义的getter
            const fn = store._wrapperGetters[key]
            //转化为computed可以使用的无参数形式
            computed[key]=function(){
                return fn(store.state)
            }
            //为getters定义只读属性
            Object.defineProperty(store.getters,key,{
                get:()=> store._vm[key]
            })
        })
        ......
    }
}
```


<!-- markdownlint-disable MD041 MD002--> 