---
title: es6基础
date: 2021-01-08 09:46:24
tags:
    - JavaScript
categories:
    - JavaScript
description:
---

## ECMAScript 6 简介
- JavaScript 三大组成部分
    - ECMAScript 
    - DOM
    - BOM 
- ECMAScript 发展历史 https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Language_Resources
- ECMAScript 包含内容：JS 中的数据类型及相关操作，流程控制，运算符及相关运算……
<!-- more -->

## let 和 const

1. let 和 var 的差异
    ```js
    var:
        1.  var可以重复声明
        2.  作用域：全局作用域和函数作用域
        3.  会进行预解析
    
    let:
        1.  同一作用域下不能重复声明   
        2.  作用域： 全局作用域 和 块级作用域  {}
        3.  不进行预解析
    ```

2. const 常量

    - 声明时必须赋值
    - 常量不能重新赋值
    - 不能重复声明
    - 块级作用域
    - const 不会被预解析

## 块级作用域

```html
<ul>
    <li>列表1</li>
    <li>列表2</li>
    <li>列表3</li>
</ul>
<script>
{
    let lis = document.querySelectorAll('li')


    for(let i=0;i<lis.length;i++){
        lis[i].onclick = function(){
            console.log(i)
        }
    }
    //以上for循环等效于
    {
        let i = 0;
        lis[i].onclick = function(){
            console.log(i)
        }
    }
    {
        let i = 1;
        lis[i].onclick = function(){
            console.log(i)
        }
    }
    {
        let i = 2;
        lis[i].onclick = function(){
            console.log(i)
        }
    }
}
</script>
```

## 解构赋值

- 对象的解构赋值
    ```js
    let obj = {
        a:1,
        b:2,
        d:3
    }
    let {a,b} = obj 
    //相当于
    //let a = obj.a
    //let b = obj.b

    // let {a,b,c} = obj
    // console.log(a,b,c) //1,2,undefined

    ```

- 数组的解构赋值
    ```js
    let arr = ["a","b","c"]
    let [e,f]=arr
    console.log(e,f)//a b

    let a=0;
    let b=1;
    //如何快速交换a,b的值
    [a,b]=[b,a]
    ```

- 字符串的解构赋值
    ```js
    let str = "abc"
    let [e,f] = str
    console.log(e,f)//a b
    //let nub = 123 无法解构
    //let [c,d] = nub
    //console.log(c,d)//报错
    ```

## 展开运算符

- 对象展开
    ```js
    let obj = {
        a:1,
        b:2
    }
    let obj2 = {
        c:3,
        d:4
    }
    let obj3 = {
        ...obj,
        ...obj2
    }
    //剩余参数
    let {a,b,...c} = obj3
    console.log(a,b,c) //1 2 {c: 3, d: 4}

    let obj4 = obj
    obj4.a=10
    console.log(obj) //{a:10,b:2}
    let obj5 = {...obj}
    obj5.a=10
    console.log(obj) //{a:1,b:2}
    ```

- 数组展开
    ```js
    let arr=[1,2,3,4]
    let arr2 = ["a","b","c","d"]
    //将arr插入arr2的'b'之后
    let arr3=["a","b",...arr,"c","d"]
    //剩余参数
    let [a,b,...c] = arr
    console.log(a,b,c) // 1  2 [3,4]
    ```

## Set 对象

构造函数：用来构建某一类型的对象 - 对象的实例化
    ```js
    let arr = [1,2,1,3,4,4,5,6,1,"a"]
    let s = new Set(arr)
    console.log(s.size); //去重后的长度  相当于length
    s.delete("a")  //删除某一项 console.log(s.delete("a") ) true 删除不成功返回false
    //s.add(7)//可以添加
    //s.add(5)//添加不了 自动去重
    console.log(s.has(1))//true
    arr = [...s]
    console.log(arr)//[1, 2, 3, 4, 5, 6]  //去重
    //s.clear();//清空所有值  Set(0) {}    console.log(s.clear()) undefined
    console.log(s)
    ```

## Map 对象

```js
let arr = [
    ["a",1],
    ["b",2],
    ["c",3],
    ["d",4]
]
let m = new Map(arr)
// m.clear()
// console.log(m.delete("a"))
// console.log(m.get("b"))
// console.log(m.set("e",5))
m.set("e",5).set("a",10)
console.log(m)
/*
clear() 清空所有值

delete(key) 删除某一项
    参数：
        key   数据的key值
    返回值：
        true || false 是否删除成功(没有这个值才会出现删除不成功)

get(key)   获取某一项的具体值
    参数：
        key   数据的key值
    返回值：
        key对应的value  

has(key)   是否包含某一项
    参数：
        key   数据的key值
    返回值：
        true || false  是否包含这个值

set(key,val)  设置一个值
    参数：
        key   数据的key值
        val   数据的value值
    返回值：
        map对象本身
*/
```

## 函数新增扩展

1. 箭头函数
    ```js
    let fn = () => {
        console.log()
    }
    fn();
    /*
        箭头函数：
        形参 => 返回值
        let fun = nub => nub*2
        console.log(fun(10))

        (形参,形参) => 返回值
        let fun2 = (nub,nub2) => nub*nub2
        console.log(fun2(10,3))

        ()=> 返回值
        let fun3 = () => "返回值"
        console.log(fun3())

        ()=>{
            执行语句
            // return 返回值
        }

        let fun4 = ()=>{
            console.log("天气不错")
        }

        //箭头函数没有不定参

        function fun5(){
            console.log(arguments) //可以正常输出
        }
        let fun5 = ()=>{
            console.log(arguments) //arguments is not defined
        }
        fun5(1,2,3,4)
    */
    ```

2. rest 参数  剩余参数
    ```js
    let fun = (...arg)=>{
        console.log(arg) //[1,2,3,4]
    }
    fun(1,2,3,4)
    ```

3. 参数默认值设置
    ```js
    let fun = (a=10,b=2)=>{
        console.log(a*b)
    }
    fun()
    ```


> 箭头函数本身没有this,调用箭头函数的this时,指向其声明时所在作用域的this

## 数组新增方法

- Array.from(),Array.isArray()

    ```html
    <ul id="list">
        <li>1</li>
        <li>2</li>
        <li>3</li>
        <li>4</li>
    </ul>
    <script>
    /*
    Array.from()  把一个类数组转换成真正的数组  或者 lis=[...lis]
            类数组：有下标有length
        返回值：
            转换之后的新数组

    Array.isArray()  判断是不是数组
    */
    {
        let lis = document.querySelectorAll("#list li")

        console.log(Array.isArray(lis))  //false

        let arr = []

        //基本用法
        //lis = Array.from(lis) 


        lis = Array.from(lis,function(item,index){
            console.log(item,index,this)
            return index
        },arr)  //arr为this指向 存在时不能使用箭头函数

        console.log(Array.isArray(lis))  //true
        console.log(lis) //[0,1,2,3]
    }
    </script>
    ```

- Array.of() 

    ```js
    console.log(Array.of(1,2,3,4,"a"))//[1, 2, 3, 4, "a"]
    ```

> Array.from(),Array.isArray(),Array.of()  都是Array这个构造函数下的方法

- find()、findIndex()、includes()
    ```js
    //find() 查找数组中满足要求的第一个值
    //findIndex()  查找数组中满足要求的第一个值的索引
    //includes()  判断数组中是否存在某值
    let arr = [1,2,3,4,5]//['a','b','c','d']
    //arr.indexOf('a')
    //let val = arr.find((item,index)=>{
    //   if(item>3){
    //        return true
    //    }
    //})
    val =arr.find(item=>item>=3)
    console.log(val)  //3
    console.log(arr.findIndex(item=>item>=3))  //2
    console.log(arr.includes(2))  //true
    console.log(arr.includes(8))  // false
    console.log(arr.includes(1,2))  // false 从第二位开始检索
    ```

- flat()、flatMap()  数组扁平化方法
    ```js
    let arr = [
        ["小明","18"],
        ["小刚","18"],
        [
            [1,
                [3,4]
            ]
        ]
    ]
    console.log(arr.flat())  //向下提取一层 ["小明", "18", "小刚", "18", Array(2)]
    console.log(arr.flat(3)) //向下提取三层 ["小明", "18", "小刚", "18", 1, 3, 4]
    console.log(arr.flat(Infinity))  //无限层

    let arr2 = [
        ["小明","18"],
        ["小刚","18"],
    ]
    //flatMap  只处理一层
    let newArr = arr2.flatMap((item,index)=>{
        console.log(item,index)
        item = item.filter((item,index)=>{
            return index==0  //只输出姓名
        })
        return item
    })
    console.log(newArr)
    ```

- fill()  数据填充
    ```js
    let arr = [0,1,2,3,4]
    arr.fill("a")
    console.log(arr)  //["a", "a", "a", "a", "a"]

    arr.fill("a",4)
    console.log(arr)  //[0,1,2,3,"a"]

    arr.fill("a",1,2)
    console.log(arr)  //[0, "a", 2, 3, 4]

    arr.fill("a",1,20)
    console.log(arr)  //[0, "a", "a", "a", "a"] 不会改变原数组长度
    ```

## 字符串新增方法

- includes()  与数组中includes使用方法相同
- startsWith endsWith()  判断字符串是否以某个字符串开头 或结尾
    ```js
    let str = 'Joker is very smart!'
    console.log(str.startsWith('Joker')) //true
    console.log(str.startsWith('Joker',4)) //false  从第四位开始查找
    console.log(str.endsWith('smart!'))  //true
    console.log(str.endsWith('smart!',4))  //false    只看前四位
    ```
- repeat()   将字符串进行重复
    ```js
    let str = 'aaa'
    console.log(str.repeat(3))  // aaaaaaaaa
    ```

## 模板字符串

```html
<p>
    今年<strong>小明</strong>就要<strong>18</strong>岁了，终于要上<strong>大学</strong>了。
</p>
<script>
    let p = document.querySelector("p")
    let name = "小明"
    let age = 18
    let school = "大学"
    //p.innerHTML = '今年<strong>'+name+'</strong>就要<strong>'+age+'</strong>岁了，终于要上<strong>'+school+'</strong>了。'
    //等同于
    p.innerHTML = `今年<strong>${name}</strong>就要<strong>${age}</strong>岁了，终于要上<strong>${school}</strong>了。`
</script>
```
> 模板字符串可以换行
 
${}  差值表达式

```js
let a = ()=>{
    let b = 10
    return b
}
let d = 2
let c = `a的值为${a()},d${ d>8?'大于':'小于等于'}8`
```

## 对象新增方法

- 简洁表示法
    ```js
    let a = 1
    let b = 2
    //let obj = {
    //    a:a,
    //    b:b,
    //    c:function(){
    //          console.log(a)
    //     }
    //}
    // 可以写成
    let obj = {
        a,
        b,
        c(){
            console.log(a)
        }
    }
    ```

- 属性名表达式
    ```js
    let name = "小明"
    let obj = {
        [name]:111
    }
    obj[name]=111
    ```

- 对象合并
    ```js
    let obj = {
        a:1,
        b:2
    }
    let obj2 = {
        c:3,
        d:4
    }
    //let obj3 = {...obj,...obj2}
    //Object.assign(obj2,obj)  //将后面的对象合并到前面的对象中
    obj2=Object.assign({},obj2,obj)  //将后面的对象合并到前面的空目标对象中
    ```

- 比较
    ```js
    console.log(Object.is(1,'1')) //fasle
    /*
        规则：
            1.两个值都是undefined
            2.两个值都是null
            3.两个值都是true 或两个值都是false
            4.两个值都是由相同个数的字符串按照相同的顺序组成的字符串
            5.两个值都指向同一个对象
            6.两个值都是数字并且：
                    都是正零  +0
                    都是负零  -0
                    都是NAN
            以上几种时候比较结果为true 
    */
    ```
    > 1-5条等同于 `===`，
    > `-0===+0    true` ; `Object.is(-0,+0)  false`
    > `NaN===NaN  false`; `Object.is(NaN,NaN)  true`

## babel

- Babel 是一个 JavaScript 编译器

    ```html
    <script src='babel.min.js'></script>
    <script type="text/babel">
    let a = 1
    let b = 2
    let obj = {
        a,
        b,
        c(){
            console.log(1)
        }
    }
    let obj2 = {
        d:4,
        ...obj,
        e:5
    }
    </script>

    ```




<!-- markdownlint-disable MD041 MD002--> 