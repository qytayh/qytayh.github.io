---
title: 从零开始进阶全栈之koa源码
date: 2021-09-20 22:23:37
tags:
    - 全栈之路
    - node
categories:
    - 全栈之路
    - node
description:
---

深入了解koa原理
<!-- more -->

# koa原理

⼀个基于nodejs的⼊⻔级http服务，类似下⾯代码：
```js
const http = require('http')
const server = http.createServer((req, res) => {
    // 业务逻辑
    res.writeHead(200)
    res.end('hello world!')
})
server.listen(3000,()=>{
    console.log('server listen at 3000')
})
```
koa的⽬标是⽤更简单化、流程化、模块化的⽅式实现回调部分

```js
// 创建 koa.js
const http = require('http')
class Koa {
    listen(...args){
        const server = http.createServer((req,res)=>{
            this.callback(req,res)
        })
        server.listen(...args)
    }
    use(callback){
        this.callback = callback
    }
}

module.exports =  Koa

// 使用 在inde.js中
const Koa = require('./koa')
const app = new Koa()

app.use((req,res)=>{
    res.writeHead(200)
    res.end('hello world!')
})
app.listen(300,()=>{
    console.log('server start at 3000')
})
```
> ⽬前为⽌，Koa只是个⻢甲，要真正实现⽬标还需要引⼊上下⽂（context）和中间件机制

# context

koa为了能够简化API，引⼊上下⽂context概念，将原始请求对象req和响应对象res封装并挂载到context上，并且在context上设置getter和setter，从⽽简化操作。

```js 
// demo
app.use(ctx=>{
    ctx.body = 'hehe'
})
```
封装 context、request、response

```js
// request.js
module.exports = {
    get url(){
        return this.req.url
    },
    get method(){
        return this.req.method.toLowerCase()
    },
}

// response.js
module.exports = {
    get body() {
        return this._body
    },
    set body(val) {
        this._body = val
    }
}

// context.js
module.exports = {
    get url(){
        return this.req.url
    },
    get method(){
        return this.req.method.toLowerCase()
    },
    get body() {
        return this._body
    },
    set body(val) {
        this._body = val
    }
}
```
在koa.js中引入
```js
const http = require('http')
const context = require('./context')
const request = require('./request')
const response = require('./response')

class Koa {
    listen(...args){
        const server = http.createServer((req,res)=>{
            // this.callback(req,res)
            // 创建上下文
            const ctx = this.createContext(req,res)
            this.callback(ctx)
            // 相应
            res.end(ctx.body)
        })
        server.listen(...args)
    }
    ...
    createContext(req,res){
        const ctx = Object.create(context)
        ctx.request = Object.create(request)
        ctx.response = Object.create(response)
        ctx.req = ctx.request.req = req
        ctx.res = ctx.response.res = res
        return ctx
    }
}
```

# 中间件

Koa中间件机制：Koa中间件机制就是函数式 组合概念Compose的概念，将⼀组需要顺序执⾏的函数复合为⼀个函数，外层函数的参数实际是内层函数的返回值。洋葱圈模型可以形象表示这种机制，是源码中的精髓和难点。

异步中间件：我们要⽀持async + await的中间件，要等异步结束后，再执⾏下⼀个中间件。

```js
function compose(middlewares){
    return function(){
        return dispatch(0)
        function dispatch(i){
            let fn = middlewares[i]
            if(!fn){
                return Promise.resolve()
            }
            return Promise.resolve(
                fn(function next(){
                    // promise完成后，再执⾏下⼀个
                    return dispatch(i+1)
                })
            )
        }
    }
}
```

# router

routes()的返回值是⼀个中间件，由于需要⽤到method，所以需要挂载method到ctx之上，修改request.js

> 实现方式请移步[github---->write_koa](https://github.com/qytayh/write_koa)





<!-- markdownlint-disable MD041 MD002--> 