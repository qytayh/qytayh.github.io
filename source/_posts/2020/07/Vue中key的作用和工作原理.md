---
title: Vue中key的作用和工作原理
date: 2020-07-11 14:29:41
tags:
    - vue
    - 前端面试
categories:
    - [vue]
    - [前端面试]
description:
---

一般我们会回答：可以唯一的确定一个dom元素，从而执行diff算法的时候更高效。

但是到底为什么是这样呢，我们来从源码中找一下答案。

<!-- more -->

准备测试代码,在页面加载两秒后执行一个插入操作，在c的前面插入一个f

```html
<body>
    <div id="demo">
        <p v-for="item in items">{{item}}</p>
    </div>
    <script src="https://unpkg.com/vue/dist/vue.js"></script>
    <script>
        const app=new Vue({
            el:"#demo",
            data(){
                return {
                    items:['a','b','c','d','e']
                }
            },
            mounted(){
                setTimeout(()=>{
                    this.items.splice(2,0,'f')
                },2000)
            }
        })
    </script>
</body>
```

如果不使用key，其实并不知道要更新谁，只能做一个操作，就是逐步更新：

首先更新a，其次更新b，第三步的时候覆盖更新，将f更新到原来的c上，c更新到原来的d，d更新到e，然后再创建一个新的e追加在最后。执行了五次更新一次创建追加。

如果使用了key

```
前两次更新与不使用key一样
//首次循环patch a
a b c d e
a b f c d e 

//第2次循环patch b
b c d e
b f c d e

//第3次循环patch e
c d e
f c d e

//第4次循环patch d
c d 
f c d 

//第5次循环patch c
c
f c 

//oldch全部处理结束，newch中剩下f，创建f并插入到c前面

```

这边虽然看上去是执行了五次更新，但是这五次并没有发生任何操作，因为是在更新五个完全相同的节点。因为数据没有发生变化，所以在执行patch是不会做任何事情，也不会发生任何dom操作。

因此准确的来讲，如果不使用key我们执行了三次更新同时一次创建插入操作；而使用了key只做了一次创建插入操作，在数据量比较大的时候运行效率会大大提高。

打开控制台，在vue.js的第6182行加上一个断点，并将oldStartVnode的标签指定在p标签上
```js
//断点所在行
while (oldStartIdx <= oldEndIdx && newStartIdx <= newEndIdx) {......}

//右键编辑断点，加上以下条件 这样以后在update children时只观察p标签的变化
oldStartVnode.tag==='p'
```
然后刷新页面，我们可以看到，每次都会进入以下逻辑

{% asset_img 1.png [sameVnode] %}

我们进到sameVnode()中看一下

{% asset_img 2.png [sameVnode] %}

判断的条件第一条就是判断key的值是否相等，两个undefined会让等式成立，标签相同，都不是注释，data也没有发生变化，也不是input，因此判断条件已经成立了。如果没有设置key的情况下，只要两个标签相同，就会被认为是同一节点，就开始进行patch操作。

我们将key加上，再看一下结果
```html
<p v-for="item in items">{{item}}</p>
```

前两次直接跳过，因为a、b都是相同的节点，到第三次的时候，就会进入到patch e中

{% asset_img 3.png [sameVnode] %}

到第五次循环时，老的已经循环结束了，新的只剩下了f

{% asset_img 4.png [sameVnode] %}

并且在debug的过程中我们也不难看出，设置了key的只会在最后一步更新，而未设置key的会从第三次开始，每次在视图上做出更新。

**结论**

1. key的作用主要是为了更高效的更新虚拟dom，其原理是vue在patch过程中通过key可以精准判断两个节点是否是同一个，从而避免频繁更新不同的元素，使得整个patch过程更加的高效，减少dom操作量，提高性能。

2. 另外，如果不设置key还可能在列表更新时引发一些隐蔽的bug(例如：更新了某一不需要更新的行)

3. vue中在使用相同标签名元素的过渡切换时，也会使用到key属性，其目的也是为了vue可以区分它们，否则vue只会替换其内部属性而不会触发过渡效果 


> 2.2.0+ 的版本里，当在组件中使用v-for时，key现在是必须的，key的取值需要是number或者string，而且需要在同级唯一。

<!-- markdownlint-disable MD041 MD002--> 