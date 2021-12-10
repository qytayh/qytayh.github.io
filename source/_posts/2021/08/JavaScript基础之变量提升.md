---
title: JavaScript基础之变量提升
date: 2021-08-29 08:50:52
tags:
  - JavaScript
categories:
  - JavaScript
description:
---

直觉上我们一般会认为JavaScript代码在执行时是由上到下一行一行执行的。但实际上这并不完全正确

<!-- more -->

# 前言

有一些特殊情况会导致这个假设是错误的。

```js
a = 2
var a
console.log(a)  
```
那么`console.log(a)`会输出什么呢？

我们很多人会认为是`undefined`，因为`var a`的声明在`a=2`的后面，因此就认为变量`a`被重新赋上默认值`undefined`。但是，实际输出的结果却是**2**。

再看一个例子

```js
console.log(a)
var a = 2
```

从上个代码块所变现出来的某种自上而下的行为特点，大家可能又会认为这个代码块也会输出`2`,甚至还会有人认为，由于变量`a`在使用前没有事先声明，所以会抛出异常。

但是实际上，输出的会是`undefined`。

> 所以我们就面临了一个问题，到底是声明在前还是赋值在前？

# 从编译器的角度来以上看问题

引擎会在解释`JavaScript`代码之前首先对其进行编译。

编译阶段中的一部分工作就是**找到所有的声明**，并用合适的作用域将它们关联起来。

所以，正确的思路应该是，包括变量和函数在内的所有**声明**都会在**任何代码被执行前首先被处理**。

在我们看到`var a = 2`的时候，可能会认为这是一个声明，但是`JavaScript`实际上会将其看成两个声明`var a`和`a = 2`。第一个声明是在编译阶段进行的，第二个赋值声明会被留在原地等待执行。

因此，我们上面的第一个代码块其实会被以如下方式进行处理
```js
var a
a = 2
console.log(a)
```
类似的，我们的第二个代码块 实际上是按这个流程来处理的：
```js
var a
console.log(a)
a = 2
```
这个过程就好像变量和函数声明从它们在代码中出现的位置被移动到了最上面，这个过程就叫做**提升**。

> 简单的说就是，先声明，后赋值

# 函数声明

```js
foo();

function foo(){
  console.log(a) // undefined
  var a =2
}
```
`foo`的声明被提升了，因此在第一行的调用中可以正常运行。

另外，值得注意的是，每个作用域都会进行提升操作，就像我们正在讨论的`foo`也会在其内部对`var a`进行提升。因此，这段代码可以被理解为
```js
function foo(){
  var a
  console.log(a)
  a = 2
}
foo()
```
> 注意**函数声明会被提升，但是函数表达式不会**

```js
foo() // 不是ReferenceError，而是TypeError
var foo = function(){
  //...
}
```
这段程序的变量标识符`foo()`被提升并分配给所在作用域，因此`foo()`不会导致`ReferenceError`，但是`foo`没有被赋值（如果它是函数声明而不是函数表达式，那么就会被赋值）。`foo`由于对`undefined`值进行函数调用而导致非法操作，所以抛出`TypeError`。

实际上这段代码会被解析为：
```js
var foo;
foo()
foo = function(){
  //...
}
```
> [ReferenceError解释](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/ReferenceError)        
> [TypeError解释](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/TypeError)

# 函数优先

函数声明和变量声明都会被提升，但是有一点值得注意：**函数会首先被提升，然后才是变量**。

以这段代码来举个例子：
```js
foo()
var foo
function foo(){
  console.log(1)
}
foo = function(){
  console.log(2)
}
```
结果会输出`1`而不是`2`。这段代码会被引擎解析为：
```js
function foo(){
  console.log(1)
}

foo()

foo = function(){
  console.log(2)
}
```
尽管`var foo`出现在`function foo()`的声明之前，但它是重复声明（因此被忽略掉了），因为函数声明会被提到变量声明之前。

于此同时，**后面出现的函数声明可以覆盖前面的**。

```js
foo() // 3
function foo(){
  console.log(1)
}
var foo = function(){
  console.log(2)
}
function foo(){
  console.log(3)
}
```

# 小结

我们习惯的将`var a = 2`看做一个声明，但是实际上`JavaScript`引擎并不这么认为，它将`var a`和`a = 2`当做两个单独的声明，第一个是编译阶段的任务，第二个是执行阶段的任务。

这意味着无论作用域中的声明出现在什么地方，都将在代码本身被执行前首先进行处理。所有的函数和变量声明都会被移到各自作用域的最顶端，这个过程就是**提升**。

声明本身会被提升，但是包括函数表达式在内的赋值操作不会被提升。

函数优先原则。


<!-- markdownlint-disable MD041 MD002--> 