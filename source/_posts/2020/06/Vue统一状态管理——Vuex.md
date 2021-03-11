---
title: Vue统一状态管理——Vuex
date: 2020-06-10 14:21:38
tags:
    - vue
categories:
    - vue
description:
---

Vuex是一个专为Vue.js 应用程序开发的状态管理模式。它采用集中式存储管理应用的所有组件的状
态，并以相应的规则保证状态以可预测的方式发生变化。
<!-- more -->

# 安装

`vue add vuex`

# 起始

## State

将应用全局状态定义在state中

```js
state: {
 isLogin: false
}
```

## Mutation

修改State只能通过Mutation

```js
mutations: {
    login(state) {
        state.isLogin = true
    },
    logout(state) {
        state.isLogin = false
    }
},
```

## 获取和修改状态

使用store.state获取状态

```html
<button @click="login" v-if="!$store.state.isLogin">登录</button>
<button @click="logout" v-else>登出</button>
```

修改状态只能通过store.dispatch(mutation)

```js
this.$store.commit('login')
this.$store.commit('logout')
```

## Action

Action 类似于 mutation，不同在于：
- Action 提交的是 mutation，而不是直接变更状态。
- Action 可以包含任意异步操作。

```js
//参数1是vuex传递的上下文context:{commit,dispatch,state}
login({commit}, username) {
    //模拟登陆api调用，1s后如果登录名是admin则登陆成功
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            if (username === 'admin') {
                commit('login')
                resolve()
            } else {
                reject()
            }
        }, 1000);
    })
}
```

派发动作，触发actions

```js
this.$store.dispatch('login', 'admin').then(() => {
        this.$router.push(this.$route.query.redirect)
}).catch(() => {
    alert('用户名或密码错误')
})
```

# 最佳实践

## 模块化

使用modules定义多个子模块有利于组件复杂状态

```js
import user from './user'

export default new Vuex.Store({
    modules:{
        user,
    }
})
```

移动先前登陆状态相关代码到store文件夹下新建的user.js中

```js
export default {
    namespaced: true,//避免命名冲突
    //...
}
```

访问方式相应变化

```html
<!-- Login.vue -->
<button @click="login" v-if="!$store.state.user.isLogin">登录</button>
```
```js
this.$store.dispatch('user/login', 'admin').then(() => {
    const redirect = this.$route.query.redirect || '/'
    this.$router.push(redirect)
}).catch(() => {
    alert('用户名或密码错误')
})
```
```js
// router/index.js
store.state.user.isLogin
```

## mapState()/mapMutation()/mapAction()

通过这些映射方法可以让大家少敲几个字，而起避免对store的直接访问

state相关修改,`Login.vue`
```html
<button @click="login" v-if="!isLogin">登录</button>
```
```js
import { mapState } from 'vuex'
computed: {
    ...mapState('user', ['isLogin'])
}
```

action相关修改

```js
import { mapActions } from 'vuex'
methods:{
    login(){
        this['user/login']("admin").then(()=>{
            ...
        }).catch(()=>{
            ...
        })
    },
    ...mapActions(['user/login','user/logout'])
}
```
## Getters

可以使用getters从store的state中派生出一些状态

```js
export default {
    namespaced: true,
    state:{
        isLogin:false,
        username:''//用户名
    },
    mutations:{
        login(state,username){
            state.isLogin = true
            state.username = username
        },
        logout(){
            state.isLogin = false
            state.username = ''
        }
    },
    getters:{
        welcome: state => {
            return state.username + ',欢迎回来'
        }
    },
    actions:{
        login({commit},username){
            return new Promise((resolve,reject)=>{
                setTimeout(()=>{
                    if(username==='admin'){
                        commit('login',username)
                        resolve()
                    }else{
                        reject()
                    }
                },1000)
                
            })
        }
    }
}
```
在需要渲染的页面中
```html
<span v-if="isLogin">
    {{welcome}}
    <button>注销</button>
</span>
```
```js
import {mapState,mapGetters} from 'vuex'
export default {
    computed:{
        ...mapState('user',['isLogin'])
        ...mapGetters('user',['welcome'])
    }
}
```

## 严格模式

严格模式下，无论何时发生了状态变更且不是由 mutation 函数引起的，将会抛出错误。这能保证所有的状态变更都能被调试工具跟踪到。开启严格模式`strict: true`

```js
const store = new Vuex.Store({
// ...
    strict: true
})
```

## 插件

Vuex的store接受plugins选项，这个选项暴露出每次mutation的钩子。Vuex插件就是一个函数，它接收 store 作为唯一参数：

```js
const myPlugin = store => {
// 当 store 初始化后调用
}
```
在store文件夹下新建plugins文件夹并新建persist.js

```js
export default store =>{
    //store初始化的时候，将存储在localStoreage的状态还原
    if(localStoreage){
        const user = JSON.parse(localStorage.getItem('user'))
        if(user){
            store.commit('login',user.username)
        }
    }
    //如果用户相关状态发生变化，自动存入localStoreage
    store.subscribe((mutation,state)=>{
        //{type:'user/login'}
        //{type:'user/logout'}
        //{type:'cart/addcart'}
        if(mutation.type==='user/login'){
            const user = JSON.stringify(state.user)
            localStoreage.setItem('user',user)
        }else if(mutation.type==='user/logout'){
            localStoreage.removeItem('user')
        }
    })
}
```
注册插件：

在store的index.js中

```js
//...
import persist from './plugins/persist'

const store = new Vuex.Store({
    // ...
    plugins: [persist]
})
```







<!-- markdownlint-disable MD041 MD002--> 