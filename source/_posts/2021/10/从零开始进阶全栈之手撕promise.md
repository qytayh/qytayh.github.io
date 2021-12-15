---
title: 从零开始进阶全栈之手撕promise
date: 2021-10-13 12:29:31
tags:
    - 全栈之路
    - promise
categories:
    - 全栈之路
    - promise
description:
---

从0开始用ts实现promise

<!-- more -->

# 准备工作

- `npm init -y` 初始化npm
- `npm i @rollup/plugin-node-resolve rollup rollup-plugin-typescript2 typescript -D` 安装必要依赖
-  创建`rollup.config.js`，并进行配置
- `npx tsc --init` 初始化ts开发

# 知识储备

## 高阶函数

1. 如果你的函数的参数是一个函数,那么你的函数可以称为高阶函数
```js
function fn(callback){...}
```

2. 如果一个函数里面返回了一个函数，那么也是高阶函数
```js
function fn(){
    return function(){
        ...
    }
}
```

3. 柯里化函数
```js
let utils = {}
function isType(type){
    return function(val){
        return Object.prototype.toString.call(val) ==`[object ${type}]`
    }
}
['String','Number','Boolean'].forEach(type=>{
    utils[`is`+type] = isType(type)
})
console.log(utils.isString('hello'))
console.log(utils.isNumber(111))
```
> 柯里化的功能可以让函数功能更具体


# Promise

## 为什么？
- promise可以解决多个异步并行执行，最终得到所有的结果
- 异步嵌套问题

## 怎么用
```js
// 1.每个promise都有三个状态   pending 等待态   resolve 标识变成成功态fulfilled    reject 标识变成失败态 REJECTED
// 2.每个promise需要有一个then方法，传入两个参数，一个是成功的回调  另一个是失败的回调
// 3.new promise 会立即执行
// 4.当promise抛出异常后 也会走失败态
// 5.状态不可逆 一旦成功就不能失败 一旦失败就不能成功
let promise = new Promise((resovle,reject)=>{
    resovle('ok') // success
    // reject('not ok') // fail
})
promise.then((data)=>{
    console.log('success', data) // resolve进这里
},(err)=>{
    console.log('fail', err)  // reject 几这里
})


// 无论成功还是失败 都可以返回结果(1.出错了了走错误  2.返回一个普通值(不是promise的值)，就会作为下一次then的成功结果 3.是promise的情况(会采用返回的promise的状态)用promise解析后的结果传递给下一个then)

// 普通值  调用 then方法会返回一个全新的promise(不能返回this)

let promise2 = new Promise((resovle,reject)=>{
    resovle('ok') // success
}).then(data => {
    return new Promise((resovle,reject)=>{
        // reject(100) // fail
        setTimeOut(()=>{
            resolve(100)
        },1000)
    })
}, err=>{
    console.log(err)
    return 101
})
promise2.then(data => {
    console.log(data,'==')
},err=>{
    console.log(err,'---')
})
```
> [promise规范](https://promisesaplus.com/)





<!-- markdownlint-disable MD041 MD002--> 