---
title: vue-router源码实现
date: 2020-07-05 19:38:41
tags:
    - vue
categories:
    - vue
description:
---

从零开始，实现vue-router

<!-- more -->

# 本篇目标

- 实现`VueRouter`类和`install`方法，使之作为一个插件存在
- 实现两个全局组件:`router-view`用于显示匹配组件内容，`router-link`用于跳转
- 监控`url`变化:监听`hashchange`或`popstate`事件
- 响应最新`url`:创建一个响应式的属性`current`，当它改变时获取对应的组件并显示

# 实现一个插件：创建VueRouter类和install方法

在`src`目录下创`jrouter`文件夹用于存放我们手写的路由的相关代码，在`jrouter`下新建`index.js`和`jvue-router.js`

```js
//jvue-router.js

let Vue;//引用构造函数，在JVueRouter里面使用
//1、实现一个插件：挂载$router
class JVueRouter{
    constructor(options){
        //获取用户配置并保存
        this.$options=options
    }
}
//插件：实现install方法，注册$router
JVueRouter.install = function(_Vue){
    //保存构造函数，在JVueRouter里面使用
    Vue=_Vue;
    // 挂载$router
    Vue.mixin({//混入
        beforeCreate(){
            //确保根实例的时候才执行,只有根组件拥有router选项
            if(this.$options.router){
                Vue.prototype.$router = this.$options.router
            }
        }
    })
}
export default JVueRouter;
```
> 为什么要采用混入的方式：主要原因是use代码在前，Router实例创建在后，而install逻辑又需要用到该实例

修改`jrouter`中`index.js`代码
```js
import Vue from 'vue'
import VueRouter from './jvue-router'//引入我们写好的插件
import Home from '../views/Home.vue'

// 1.应用插件
Vue.use(VueRouter)

const routes = [
  ......
]

// 2.创建实例
const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
```
最后我们只需要修改`main.js`中对路由的引用就可以了
```js
...
import router from './jrouter'
...
new Vue({
  router,//挂载router实例
  store,
  render: h => h(App)
}).$mount('#app')
```

# 实现router-link和router-view

修改`jrouter`中`index.js`代码

```js
KVueRouter.install = function (_Vue) {
    ...
    Vue.component('router-link', {
        props: {
            to: {
                type: String,
                required: true
            },
        },
        render(h) {
            // <a href="#/about">abc</a>
            // <router-link to="/about">xxx</router-link>
            // h(tag, data, children)
            return h('a', { attrs: { href: '#' + this.to } }, this.$slots.default)
            // return <a href={'#' + this.to}>{this.$slots.default}</a>
        }
    })
    Vue.component('router-view', {
        render(h){
            return h('div','router-view')
        }
    })
}
```

# 监控url的变化

定义响应式的current，监听hashchange事件
```js
class JVueRouter{
    constructor(options){
        this.$options=options
        //需要创建响应式的current的属性,可以利用vue监听current的变化
        Vue.util.defineReactive(this,'current','/')
        //监控url变化
        window.addEventListener('hashchange', this.onHashChange.bind(this))//避免onHashChange中this变成window
        window.addEventListener('load', this.onHashChange.bind(this))//页面加载 避免onHashChange中this变成window
    }
    onHashChange(){
        this.current = window.location.hash.slice(1)
    }
}
```
动态获取对应的组件

```js
Vue.component('router-view', {
        render(h){
            //获取path对应的component
            let component=null
            this.$router.$options.routes.forEach(route=>{
                if(route.path===this.$router.current){
                    component=route.component
                }
            })
            return h(component)
        }
    })
```

# 提前处理路由表

提前处理路由表可以避免每次都循环
```js
class JVueRouter{
    constructor(options){
        ......
        //创建一个路由映射表
        this.routeMap={}
        options.routes.forEach(route=>{
            this.routeMap[route.path]=route
        })
        ......
    }
}
```
修改`router-view`根据path获取component的方法
```js
Vue.component('router-view', {
    render(h){
        const {routeMap,current}=this.$router
        const component=routeMap[current].component || null
        return h(component)
    }
})
```

# 代码结构优化

我们在`jrouter`文件夹下新建`jrouter-link.js`和`jrouter-view.js`,调整`jvue-router.js`中代码
```js
//首先进行引入
import Link from './jrouter-link'
import View from './jrouter-view'

......

 // 
JVueRouter.install = function (_Vue) {
    ......
    Vue.component('router-link', Link)
    Vue.component('router-view', View)
    ......
}
```
然后我们将原先写在`jvue-router.js`中组件部分的代码分别写到对应的js文件中
```js
//jrouter-link.js
export default {
  props: {
    to: {
      type: String,
      required: true
    },
  },
  render(h) {
    // <a href="#/about">abc</a>
    // <router-link to="/about">xxx</router-link>
    // h(tag, data, children)
    return h('a', { attrs: { href: '#' + this.to } }, this.$slots.default)
    // return <a href={'#' + this.to}>{this.$slots.default}</a>
  }
}
// jrouter-view.js
export default {
  render(h) {
    //获取path对应的component
    const {routeMap, current} = this.$router;
    const component = routeMap[current].component || null;
    return h(component)
  }
}
```

> 如果我们不用`Vue.util.defineReactive(this,'current','/')`来实现监听，其实也可以用这种方式
>```js
this.app = new Vue({
    data(){
        return {
            current:'/'
        }
   }
})
//获取current的方式就变为
this.app.current
>```

# 嵌套路由

当用户的路由为类似如下的嵌套路由时，我们应该如何兼容呢

```js
const routes = [
    ......
  {
    path: '/about',
    name: 'about',
    component: () => import('../views/About.vue'),
    children:[
        {
            path:'/about/info',
            component:() => import('../views/AboutInfo.vue'),
        }
        ......
    ]
  }
    ......
]
```
打开`jrouter-view.js`文件，并修改
```js
export default {
  render(h) {
    //标记当前router-view深度
    this.$vnode.data.routerView = true;
    let depth = 0
    let parent = this.$parent
    while(parent){
        const vnodeData = parent.$vnode&&parent.$vnode.data
        if(vnodeData&&vnodeData.routerView){
            //说明当前的parent是一个router-view
            depth++
        }
        parent = parent.$parent
    }
    //获取path对应的component
    let component = null;
    const route = this.$router.matched[depth];
    if(route){
        component = route.component
    }
    
    return h(component)
  }
}
```
修改`jvue-router.js`
```js
class JVueRouter{
    constructor(options){
        this.$options=options
        //需要创建响应式的current的属性,可以利用vue监听current的变化
        // Vue.util.defineReactive(this,'current','/')通过matched数组获取component，不需要current响应式了
        this.current = window.location.hash.slice(1)||'/'
        Vue.util.defineReactive(this,'matched',[])
        //match方法可以递归遍历路由表，获得匹配关系的数组
        this.match()
        //监控url变化
        window.addEventListener('hashchange', this.onHashChange.bind(this))//避免onHashChange中this变成window
        window.addEventListener('load', this.onHashChange.bind(this))//页面加载 避免onHashChange中this变成window
    }
    onHashChange(){
        this.current = window.location.hash.slice(1)
        this.matched = []
        this.match()

    }
    match(routes){
        routes = routes||this.$options.routes
        //递归遍历路由表
        for(const route of routes){
            if(route.path === '/'&&this.current==='/'){
                this.matched.push(route)
                return
            }
            if(route.path!=='/'&&this.current.indexOf(route.path)!=-1){
                this.matched.push(route)
                if(route.children){//如果有嵌套 
                    this.match(route.children)
                }
                return
            }
        }
    }
}
```





<!-- markdownlint-disable MD041 MD002--> 