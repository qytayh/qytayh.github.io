---
title: 仿写new运算符
date: 2021-01-16 10:28:57
tags:
categories:
description:
---

实现new运算符

<!-- more -->

```js
function myNew(constructor,...arg){
    let obj = {};//创建对象
    constructor.call(obj,...arg)//改变this执行
    obj.__proto__==constructor.prototype//构造函数的原型赋给对象的原型
    return obj
}

function Tab(){
    this.name = "张三"
    this.hobby = function(){
        console.log("hobby...")
    }
}

let tab1 = myNew(Tab)
console.log(tab1.name)
tab1.hobby()
```


<!-- markdownlint-disable MD041 MD002--> 