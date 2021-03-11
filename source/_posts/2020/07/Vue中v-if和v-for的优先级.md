---
title: Vue中v-if和v-for的优先级
date: 2020-07-07 20:00:07
tags:
    - vue 
    - 前端面试
categories:
    - [vue]
    - [前端面试]
description:
---

v-if和v-for哪个优先级更高？如果两个同时出现，应该怎么优化才能得到更好的性能？

<!-- more -->

当v-if和v-for同级的时候，我们写一个例子

```html
<body>
    <div id="demo">
        <p v-for="child in children" v-if="isFolder">{{child.title}}</p>
    </div>
    <script src="https://unpkg.com/vue/dist/vue.js"></script>
    <script>
        const app=new Vue({
            el:"#demo",
            data(){
                return {
                    children:[
                        {title:'foo'},
                        {title:'bar'}
                    ]
                }
            },
            computed:{
                isFolder(){
                    return this.children&&this.children.length>0
                }
            }
        })
        console.log(app.$options.render)
    </script>
</body>
```
生成的渲染函数
```js
ƒ anonymous(
) {
with(this){return _c('div',{attrs:{"id":"demo"}},_l((children),function(child){return (isFolder)?_c('p',[_v(_s(child.title))]):_e()}),0)}
}
```
> 这样我们可以看出来是循环先执行，isFolder判断后执行

当v-if和v-for不同级的时候，我们先调整下dom区域
```html
<template v-if='isFolder'>
    <p v-for="child in children">{{child.title}}</p>
</template>
```
两者不同级时，渲染函数入下
```js
ƒ anonymous(
) {
with(this){return _c('div',{attrs:{"id":"demo"}},[(isFolder)?_l((children),function(child){return _c('p',[_v(_s(child.title))])}):_e()],2)}
}
```
> 先判断了isFolder再看是否执行-l

**结论**

1. 显然v-for优先于v-if被解析
2. 如果同时出现，每次渲染都会先执行循环再判断条件，无论如何，循环都不可避免，浪费了性能
3. 要避免出现这种情况，可以在外层嵌套template,然后在这一层进行v-if判断，然后在内部进行v-for循环
4. 如果条件出现在循环内部，可通过计算属性提前过滤掉那些不需要显示的项

<!-- markdownlint-disable MD041 MD002--> 