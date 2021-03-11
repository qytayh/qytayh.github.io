---
title: JS从入门到放弃——数据类型
date: 2020-08-06 21:15:58
tags:
    - JavaScript
categories:
    - JavaScript
description:
---

值类型(基本类型)：字符串（String）、数字(Number)、布尔(Boolean)、对空（Null）、未定义（Undefined）、Symbol。

引用数据类型：对象(Object)、数组(Array)、函数(Function)。

> 注：Symbol 是 ES6 引入了一种新的原始数据类型，表示独一无二的值。

<!-- more -->

## **JavaScript拥有动态类型**

JavaScript 拥有动态类型。这意味着相同的变量可用作不同的类型：
```js
var x;              //x为undefined
var x = 5;          //x为数字
var x = "Joker";    //x为字符串
```

## **字符串**

字符串是存储字符（比如 "Joker 真帅"）的变量。
字符串可以是引号中的任意文本。您可以使用单引号或双引号：
```js
var name = "Joker";
var name = 'Joker';
```
也可以在字符串中使用引号，只要不匹配包围字符串的引号即可：
```js
var area = "Joker's Blog";
var name = "He is called 'Joker'";
var name = 'He is called "Joker"';
```

## **数字**

JavaScript 只有一种数字类型。数字可以带小数点，也可以不带：
```js
var x1=34.00;      //使用小数点来写
var x2=34;         //不使用小数点来写
```
极大或极小的数字可以通过科学（指数）计数法来书写
```js
var y=123e5;      // 12300000
var z=123e-5;     // 0.00123
```

## **布尔**

布尔（逻辑）只能有两个值：true 或 false。
```js
var x=true;
var y=false;
```

## **数组**

下面的代码创建名为 cars 的数组：
```js
var cars=new Array();
cars[0]="Saab";
cars[1]="Volvo";
cars[2]="BMW";
```
或者 (condensed array):
```js
var cars=new Array("Saab","Volvo","BMW");
```
或者 (literal array):
```js
var cars=["Saab","Volvo","BMW"];
```
数组下标是基于零的，所以第一个项目是 [0]，第二个是 [1]，以此类推。

## **对象**

对象由花括号分隔。在括号内部，对象的属性以名称和值对的形式 (name : value) 来定义。属性由逗号分隔：
```js
var person={firstname:"John", lastname:"Doe", id:5566};
```
上面例子中的对象 (person) 有三个属性：firstname、lastname 以及 id。

对象属性有两种寻址方式：
```js
name=person.lastname;
name=person["lastname"];
```

## **Undefined 和 Null**

undefined 的字面意思就是：未定义的值 。这个值的语义是，希望**表示一个变量最原始的状态，而非人为操作的结果**。

null 的字面意思是：空值。这个值的语义是，希望**表示一个对象被人为的重置为空对象，而非一个变量最原始的状态**。 在内存里的表示就是，栈中的变量没有指向堆中的内存对象


<!-- markdownlint-disable MD041 MD002--> 