---
title: TypeScript还不会?看完这篇就行了
date: 2021-08-09 14:29:26
tags:
  - TypeScript
categories:
  - TypeScript
description:
---

# TypeScript究竟是什么呢？

<!-- more -->

- JavaScript that scales

- 静态类型风格的类型系统

- 从es6到es10甚至是esnext的语法支持

- 兼容各种浏览器、各种系统、各种服务器，完全开源

>  [ts官网](https://tslang.cn)

## 为什么要使用TS

- 程序更容易理解

  > 函数或者方法输入输出的类型参数，外部条件等 
  > 动态语言的约束：需要手动调试等过程
  > 有了TS:代码本事就可以回答上述问题

- 效率更高
 
 > 在不同的代码块和定义中进行跳转 
 > 代码自动补全
 > 丰富的接口提示

- 更少的错误

  > 编译期间能够发现大部分错误
  > 杜绝一些常见错误

- 非常好的包容性
 
  > 完全兼容JavaScript
  > 第三方库可以单独编写类型文件

## 一些缺点：

+ 增加了一些学习成本

+ 短时间内增加了一些开发成本

# 安装TypeScript

```cmd
npm install -g typescript
```

# 原始数据类型和any类型

```ts
let isDone:boolen = false
let age:number = 10
let firstName:string = 'Joker'
let message:string = `Hello ${firstName}!`
let u:undefined = undefined
let n:null = null

let num:number = undefined

let notSure:any = 4
notSure = 'Maybe a string'
notSure = true

notSure.myName
notSure.getName()
// 如果有明确类型要避免使用any，any可以任意调用方法和属性很有可能出现错误，就失去了类型检查的作用

```

# 数组和元祖

```ts
let arrOfNumber:number[] = [1,2,3]
arrOfNumber.push(4)


// 元祖
let user:[string,number] = ['Joker',666]
user.push('123')
```

# interface 接口

> - 对对象的形状（shape)进行描述
> - Duck Typing(鸭子类型)

```ts
interface IPerson{
  readonly id:number;//只读属性
  name:string;
  age:number;
  tel?:number;  //可选属性
}
let Joker:IPerson = {
  id:1,
  name:'Joker',
  age:25
}
```

# function 函数

> 在js中function是一等公民

```ts
// z 为可选参
function add(x:number,y:number,z?:number):number{
  if(typeof z === 'number'){
    return x + y + z
  }
  return x + y
}
const sum = （x:number,y:number,z?:number):number => {
  if(typeof z === 'number'){
    return x + y + z
  }
  return x + y
}

let result = add(1,2)

interface ISum {
  (x:number,y:number,z?:number):number
}

let add2:(x:number,y:number,z?:number)=>number = add
let add3:ISum = add

```

## 类型推论 联合类型和类型断言

```ts
let str = 'str'

// union types
let numberOrString:number|string  //连盒类型
numberOrString='abc'
numberOrString=123

function getLength(input:string:number):number{
  const str = input as string // 类型断言
  if(str.length){
    return str.length
  }else{
    const number = input as number
    return number.toString().length
  }
}

// type guard

function getLength2(input:string:number):number{
  if(typeof input ==='string'){
    return input.length
  }else{
    return input.toString().length
  }
}

```

# 类Class

## js中的类

- 类(Class):定义了一切事物的抽象特点

- 对象（Object):类的实例

- 面向对象(OOP)三大特性:封装、继承、多态

```ts
class Animal{
  constructor(name){
    this.name = name
  }
  run(){
    return `${this.name} is running!`
  }
}

const dog = new Animal('japan')

console.log(dog.run())

class Pig extends Animal{
  bark(){
    return `${this.name} is barking!`
  }
}

const tlp = new Pig('tlp')
console.log(tlp.run())
console.log(tlp.bark())

class Cat extends Animal{
  static categories = ['cat']
  constructor(name){
    super(name)
  }
  run(){
    return 'Meow, ' + super.run()
  }
}
const maomao = new Cat('maomao')
console.log(maomao.run())
console.log(Cat.categories)

```


## TS中的类

- Public:修饰的属性是共有的

- Private:修饰的属性或者方法是私有的

- Protected:修饰的属性或方法是受保护的

```ts
class Animal{
  readonly name:string //只读
  constructor(name){
    this.name = name
  }
  private eat(){ // 仅在本事和
    return 'eat'
  }
  protected run(){  // 本身和子类
    return `${this.name} is running!`
  }
}

const dog = new Animal('japan')

console.log(dog.run())  //error

class Pig extends Animal{
  bark(){
    return `${this.name} is barking!`
  }
}

const tlp = new Pig('tlp')
console.log(tlp.eat())  // error

class Cat extends Animal{
  static categories = ['cat']
  constructor(name){
    super(name)
  }
  run(){
    return 'Meow, ' + super.run() // true
  }
}
const maomao = new Cat('maomao')
console.log(maomao.run())
console.log(Cat.categories)

```

# 类和接口

- 继承的困境

- 类可以使用implements来实现接口

```ts

interface Radio {
  switchRadio(trigger:boolean):void,
}

interface Battery {
  checkBatteryStatus():void
}

interface RadioWithBattery extends Radio {
  checkBatteryStatus():void
}

class Car implements Radio {
  switchRadio(trigger:boolean){

  }
}

class CellPhone implements Radio,Battery{
  switchRadio(trigger:boolean){
    
  }
  checkBatteryStatus(){

  }
}

class MobilePhone implements RadioWithBattery{
  switchRadio(trigger:boolean){
    
  }
  checkBatteryStatus(){

  }
}
```

# 枚举

```ts
enum Direction {
  Up,
  Down,
  Left=10,
  Right
}
console.log(Direction.Up) // 0
console.log(Direction.Down) // 1
console.log(Direction[0]) // 'Up'
console.log(Direction.Left) // 10
console.log(Direction.Right) // 11
```

```ts
const enum Direction { // 加上const 变成常量枚举可以提升性能  只有常量值可以使用const
  Up = 'Up',
  Down = 'Down',
  Left = 'Left',
  Right = 'Right'
}
const value = 'Up'
if(value === Direction.Up){
  console.log('go up')
}

```


# 泛型

在定义函数接口或类的时候不预先指定类型，在使用的时候再指定

```ts
function echo<T>(arg:T):T{
  return arg
}

const str:string='str'
const result0 = echo(str)
const result1 = echo(123)
const result2 = echo(true)


function swap<T,U>(tuple:[T,U]):[U,T]{
  return [tuple[1],tuple[0]]
}
const result3 = swap(['abc',123])


// 约束泛型
function echoWithArr<T>(arg:T[]):T[]{
  console.log(arg.length)
  return arg
}
const arr1 = echoWithArr([1,2,3])

interface IWithLength{
  length:number
}
function echoWithLength<T extends IWithLength>(arg:T):T{
  console.log(arg.length)
  return arg
}
const str = echoWithLength('str')
const obj = echoWithLength({length:10})
const arr2 = echoWithLength([1,2,3])


class Queue<T>{
  private data = []
  push(item:T){
    return this.data.push(item)
  }
  pop():T{
    return this.data.shift()
  }
}
const queue = new Queue<number>()
queue.push(1)
console.log(queue.pop().toFixed())


interface KeyPair<T,U> {
  key:T,
  value:U
}
let kp1:KeyPair<number,string> = {key:1,value:'str'}
let kp2:KeyPair<string,number> = {key:'str',value:123}

let arr:number[] = [1,2,3]
let arr2:Array<number> = [1,2,3]

```


# 类型别名,字面量和交叉类型

```ts
let sum:(x:number,y:number)=>number 
const result = sum(1,2)

type PlusType = (x:number,y:number)=>number
let sum2:PlusType
const result = sum2(2,3)

type StrOrNumber = string | number
let result3:StrOrNumber = '123'
result3 = 123
result3 = true //error

const str:'name' = 'name'
const str2:'name' = 'name1'  //error
const number:1 = 1

type Direction = 'Up'|'Down'|'Left'|'Right'
let toWards:Direction = 'Down' // 只能四个里面的一个值


interface IName {
  name:string
}
type TPerson = IName & {age:number}
let person:TPerson = {name:'123',age:123}

```

# 声明文件

一般是`.d.ts`结尾，只是实现了类型的定义并未实现真正代码功能


# 内置类型

```ts
const a:Array<number> = [1,2,3]
const date = new Date()
date.getTime()
const reg = /abc/
reg.test('abc')

//build-in object
Math.pow(2,2)

// Dom and Bom
let body = document.body
let allLis = document.querySelectorAll('li')
allLis.keys()

document.addEventListener('click',(e)=>{
  e.preventDefault()
})

// Utility Types
interface IPerson {
  name:string,
  age:number
}
let Joker:IPerson = {name:'Joker',age:25}
type TPartical = Partical<IPerson> //将所有参数变为可选
let Joker2:IPerson = {name:'Joker'}
type TOmit = Omit<IPerson,'name'> // 忽略一个选项
let Joker3:IPerson = {age:25}

```




<!-- markdownlint-disable MD041 MD002--> 