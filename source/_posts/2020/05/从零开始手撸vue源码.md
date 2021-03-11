---
title: 从零开始手撸vue源码
date: 2020-05-23 10:52:56
tags:
    - vue
categories:
description: 本文用于记录学习vue源码的过程

---

本文用于记录学习vue源码的过程

<!-- more -->
简介
本文主要为学习B站 [前端铁蛋-手写vue框架](https://www.bilibili.com/video/BV1HE411L7fM) 的学习笔记

# 一、准备工作
首先，利用webpack构建项目

1. 初始化项目

    `npm init -y`

2. 安装webpack

    `npm i webpack webpack-cli webpack-dev-server html-webpack-plugin --save`

3. 配置webpack
    
    根目录创建webpack.config.js文件

    配置代码如下
    ``` js
    const path = require('path')
    const HtmlWebpackPlugin = require('html-webpack-plugin')
    module.exports = {
        entry: './src/index.js',
        output: {
            filename: "bundle.js",
            path: path.resolve(__dirname, 'dist')
        },
        devtool: "source-map", //调试的时候可以快速找到源码
        resolve: {
            //更改模块的查找方式
            modules: [path.resolve(__dirname, 'source'), path.resolve('node_modules')]
        },
        plugins: [
            new HtmlWebpackPlugin({
                template: path.resolve(__dirname, 'public/index.html')
            })
        ]
    }
    ```


4. 新建source文件夹用于后期存放资源

5. 新建public文件夹
    
    创建index.html文件并生成h5代码
    ``` html
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <div id="app"></div>
    </body>
    </html>
    ```
6. 修改packjson.json配置
    ``` json
    "scripts": {
        "start": "webpack-dev-server",
        "build": "webpack"
    },
    ```
7. 命令行输入
    
    `npm start //启动` 

# 二、数据代理

1. 创建构造函数并初始化用户传入的参数(我们先假设用户传入的只有el、data)

    在source文件夹新建vue文件夹并添加index.js文件
    ``` js
    import {initstate} from './Observe'

    function Vue(options) { //vue中传入参数
        //初始化用户传入的选项
        this._init(options)
    }

    //初始化
    Vue.prototype._init = function (options) {
        let vm = this
        vm.$options = options
        //重新初始化状态 data computed watch
        initstate(vm)
    }

    export default Vue
    ```
2. vue文件夹中新建Observe并添加index.js文件

    ``` js
    import Observe from './observe'
    export function initstate(vm) {
        //做不同的初始化工作
        let opts = vm.$options
        if (opts.data) {
            initData(vm)
        }
    }
    export function observe(data){
        //判断data是不是对象 不是就return
        if(typeof data!=='object'||data==null){
            return
        }
        //如果是对象则new一个Observe对象来使这个data 实现数据监听
        return new Observe(data) //观察数据的业务逻辑放在这里
    }
    function initData(vm) {
        //获取用户传入的data
        let data = vm.$options.data
        //判断是不是函数  把数据赋值给vm._data 方便观察
        data=vm._data = typeof data === 'function' ? data.call(vm) : data || {}
        //观察数据
        observe(data)
    }
    ```
3. Observe文件夹下新建observe.js文件

    ``` js
    import { observe } from "."
    class Observe {
        constructor(data) { //data就是vue中我们定义的data vm._data
            //将用户的数据使用defineProperty定义
            this.walk(data)
        }
        walk(data) {
            let keys = Object.keys(data)
            for (let i = 0; i < keys.length; i++) {
                let key = keys[i] //获取所有的key
                let value = data[keys[i]] //所有的value
                defineReactive(data, key, value)
            }
        }
    }
    export function defineReactive(data, key, value) {
        //观察value是不是对象 然后监听  如果是一个对象 递归监听
        observe(value)
        Object.defineProperty(data, key, {
            get() {
                return value
            },
            set(newval) {
                if(newval===value) return
                //有可能设置的时候也是一个对象
                observe(newval)
                value = newval
            }
        })
    }
    export default Observe
    ```
4. 这时我们回到src/index.js 引入vue并初始化vue对象
    ```js
    //默认  source/vue
    import Vue from 'vue'  
    let vm = new Vue({
        el:'#app',
        data(){
            return{
                msg:'hello',
                haha:{
                    a:1
                }
            }
        },
    })
    ```
5. 修改一下data中某个属性的值，看一下效果
    ``` js
    vm._data.msg='Joker 666'
    console.log(vm)
    ```
    {% asset_img 2-1.png [这边我们可以看到msg已经发生了变化] %}

6. 实现数据代理

    我们在使用vue的时候，获取data属性时一般都是通过this.xxx获取，而我们上面只实现了通过this._data.xxx,所以我们要编写一个proxy方法，将传入的数据直接挂载到vm上

    在 source/Observe/index.js 文件中新增proxy方法
    ```js
    function proxy(vm, source, key) {
        Object.defineProperty(vm, key, {
            get() {
                return vm[source][key]
            },
            set(newval) {
                return vm[source][key]=newval
            }
        })
    }
    ```
    修改initData()
    ```js
    function initData(vm) {
        //获取用户传入的data
        let data = vm.$options.data
        //判断是不是函数  把数据赋值给vm._data 方便观察
        data = vm._data = typeof data === 'function' ? data.call(vm) : data || {}
        //其实是vm._data代理了vm的操作
        for (let key in data) {
            proxy(vm, "_data", key)
        }
        //观察数据
        observe(data)
    }
    ```

    实现的原理其实非常简单，实际上就是在我们想要获取this.data时，其实去获取this._data


    至此，我们已经实现了数据监听，但是还有个问题，Object.defineProperty是无法监听数组的变化的(面试需要注意)

# 三、重写数组方法

 我们常用的改变数组的方法有以下几种
    `['push','shift','unshift','pop','reverse','sort','splice']`

    我们企图往数组arr中添加值，结果发现新添加进去的值是没办法被监听到的，因此，我们需要改写push等方法    

    基本思路就是之前我们调用push方法时，是从Aarray.prototype寻找这个方法，我们改成用一个空对象{}继承Array.prototype，然后再给空对象添加push方法
    我们在source/vue/Observe下新增array.js文件
    ```js
    //获取数组原型上的方法
    let oldArrayProtoMethods = Array.prototype
    //复制一份  然后改新的
    export let arrayMethods = Object.create(oldArrayProtoMethods)
    //修改的方法
    let methods = ['push', 'shift', 'unshift', 'pop', 'reverse', 'sort', 'splice']
    methods.forEach(method => {
        arrayMethods[method] = function (...arg) {
            //不光要返回新的数组方法  还要执行监听
            let res = oldArrayProtoMethods[method].apply(this, arg)
            //实现新增属性的监听
            console.log('实现了监听数组属性的变化')
            return res
        }
    })
    ```
    我们在用户数据传入Observe中接收监听的时候需要区分data是数组还是对象，如果是数组，则改变数组的原型链
    修改source/vue/Observe/observe.js中的代码
    ```js
    class Observe {
        constructor(data) { //data就是vue中我们定义的data vm._data
            //将用户的数据使用defineProperty定义
            if (Array.isArray(data)) {
                data.__proto__ = arrayMethods
            } else {
                this.walk(data)
            }
        }
        walk(data) {
            let keys = Object.keys(data)
            for (let i = 0; i < keys.length; i++) {
                let key = keys[i] //获取所有的key
                let value = data[keys[i]] //所有的value
                defineReactive(data, key, value)
            }
        }
    }
    ```
    执行以下代码
    
    `vm.arr.push(4)`

    然后在控制台可以看到我们成功修改了数组
    {% asset_img 3-1.png [这边我们可以看到arr已经发生了变化] %}

# 四、

    


未完待续。。。


<!-- markdownlint-disable MD041 MD002--> 