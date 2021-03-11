---
title: Vue中路由守卫
date: 2020-06-02 21:48:44
tags:
    - vue
categories:
    - vue
description:
---

Vue中路由守卫的详细用法

<!-- more -->

# 路由守卫

`vue-router` 提供的导航守卫主要是用来通过跳转或取消的方式守卫导航。有多种机会植入路由导航过程中：全局，单个路由独享，或者组件级

## 全局守卫

```js
router.beforeEach((to,from,next) => {
    //...
    //to:Route:即将要进入的目标，路由对象
    //from:Route:当前导航正要离开的路由
    //next:Function:一定要调用该方法来 resolve 这个钩子 
})
```

范例

```js
const routes=[
    {
        path: '/',
        component:  component: () => import('@/views/home.vue'),
        meta: {
            auth: true//限制home要登录
        }
    },
    {
        path: '/login',
        component:  component: () => import('@/views/login.vue'),
    }
]

......

router.beforeEach((to,from,next) => {
    //判断路由是否需要守卫
    //meta数据
    if(to.meta.auth){
        //是否登录
        if(window.isLogin){//登录了就直接跳转
            next()
        }else{//未登录就去登录页 ？后面是为了登陆后重定向回当前的页面
            next('/login?redirect='+to.fullPath)
        }
    }
    else{
        next()
    }
})
```

## 单个路由守卫

范例

```js
const routes=[
    {
        path: '/',
        component:  component: () => import('@/views/home.vue'),
        meta: {
            auth: true//限制home要登录
        },
        beforeEnter(to,from,next){
            //是否登录
            if(window.isLogin){//登录了就直接跳转
                next()
            }else{//未登录就去登录页 ？后面是为了登陆后重定向回当前的页面
                next('/login?redirect='+to.fullPath)
            }
        }
]
```

## 组件内守卫

可以在路由组件内直接定义以下导航守卫

- beforeRouteEnter
- beforeRouteUpdate
- beforeRouteLeave

范例

``` js
//About.vue
mounted(){...},
methods:{...},
beforeRouteEnter(to,from,next){
    if(window.isLogin){//登录了就直接跳转
            next()
    }else{//未登录就去登录页 ？后面是为了登陆后重定向回当前的页面
        next('/login?redirect='+to.fullPath)
    }
}
```

## 动态路由

通过router.addRoutes(routes)方式动态添加路由

```js
// 全局守卫修改为：要求用户必须登录，否则只能去登录页
router.beforeEach((to, from, next) => {
    if (window.isLogin) {
        if (to.path === '/login') {
            next('/')
        } else {
            next()
        }
    } else {
        if (to.path === '/login') {
            next()
        } else {
            next('/login?redirect=' + to.fullPath)
        }
    }
})
```
```js
// Login.vue用户登录成功后动态添加/about
login() {
    window.isLogin = true;
    this.$router.addRoutes([
    {
    path: "/about", //...
    }
    ]);
    const redirect = this.$route.query.redirect || "/";
    this.$router.push(redirect);
}
```





<!-- markdownlint-disable MD041 MD002--> 