---
title: TS进阶之--装饰器
date: 2021-08-10 14:47:43
tags:
  - TypeScript
categories:
  - TypeScript
description:
---


# 什么是装饰器

`装饰器-Decorators` 在 `TypeScript` 中是一种可以在不修改类代码的基础上通过添加标注的方式来对类型进行扩展的一种方式

<!-- more -->


- 减少代码量
- 提高代码扩展性、可读性和维护性

> 在 `TypeScript` 中，装饰器只能在类中使用

# 装饰器语法

装饰器的使用极其的简单

- 装饰器本质就是一个函数
- 通过特定语法在特定的位置调用装饰器函数即可对数据（类、方法、甚至参数等）进行扩展

**启用装饰器特性**

- `experimentalDecorators: true`

> `tsconfig.json`中进行配置

```ts
function log(target:Function,name:string,descriptor:PropertyDescriptor){
  /**
  *    target:被装饰的方法所属的类
  *    被装饰的方法的名称
  *    descriptor: 描述符
  **/
  // 把原始的方法提取出来
  let fn = descriptor.value
  descriptor.value = function(a:number,b:number){
    let result = fn(a,b)  // 原先方法行为
    console.log('日志：',{
      name,
      a,
      b,
      result
    }) // 扩展行为

    return result
  }
}

class M {
  @log
  static add(a:number,b:number){
    return a+b
  }
}
```

# 装饰器细节

`装饰器` 是一个函数，它可以通过 `@装饰器函数` 这种特殊的语法附加在 `类`、`方法` 、`访问符`、`属性`、`参数` 上，对它们进行包装，然后返回一个包装后的目标对象（`类`、`方法` 、`访问符`、`属性`、`参数` ），**装饰器工作在类的构建阶段，而不是使用阶段**

```ts
function d1(target:Function){
  console.log(typeof target,target)
}
function d11(target:Function){
  console.log(typeof target,target)
}

function d2(target:any,name:string){
  console.log(typeof target,name)
}

function d3(target:any,name:string,descriptor: PropertyDescriptor){
  console.log(typeof target,name,descriptor)
}

function d4(target:any,name:string,descriptor: PropertyDescriptor){
  console.log(typeof target,name,descriptor)
}

function d5(target:any,name:string,index: number){
  // name为当前参数所在的方法的名称
  console.log(typeof target,name,index)
}

@d1 
@d11  // 多个装饰器时 或 @d1 @d11
class MyClass {
  
  @d2
  a: number;
  
  @d2
  static property1: number;
  
  @d3
  get b() { 
    return 1; 
  }
  
  @d3
  static get c() {
    return 2;
  }
  
  @d4
  public method1(@d5 x: number,@d5 y:number) {
    //
  }
  
  @d4
  public static method2() {}
}
```


## 类装饰器

目标

- 应用于类的构造函数

参数

- 第一个参数（也只有一个参数）
  + 类的构造函数作为其唯一的参数


## 属性装饰器

目标

- 应用于类的属性上

参数

- 第一个参数
  + 静态方法：类的构造函数 (装饰`static property1`那么为`MyClass`)
  + 实例方法：类的原型对象 (装饰的`a: number;`那么为`new MyClass()`实例后的对象)
- 第二个参数
  + 属性名称


## 访问器装饰器

目标

- 应用于类的访问器（getter、setter）上

参数

- 第一个参数 (同属性装饰器)
  - 静态方法：类的构造函数
  - 实例方法：类的原型对象
- 第二个参数
  - 属性名称
- 第三个参数
  - 方法描述符对象


## 方法装饰器

目标

- 应用于类的方法上

参数

- 第一个参数
  - 静态方法：类的构造函数
  - 实例方法：类的原型对象
- 第二个参数
  - 方法名称
- 第三个参数
  - 方法描述符对象


## 参数装饰器

目标

- 应用在参数上

参数

- 第一个参数
  - 静态方法：类的构造函数
  - 实例方法：类的原型对象
- 第二个参数
  - 方法名称
- 第三个参数
  - 参数在函数参数列表中的索引


# 装饰器执行顺序

实例装饰器

​		属性 => 访问符 => 参数 => 方法

静态装饰器

​		属性 => 访问符 => 参数 => 方法

类

​		类


# 装饰器工厂

如果我们需要给装饰器执行过程中传入一些参数的时候，就可以使用装饰器工厂来实现

```ts
function log(callback: Function){
  return function(target:Function,name:string,descriptor:PropertyDescriptor){
    let value = descriptor.value
    descriptor.value = function(x: number, y: number){
      let result = value(x,y)
      callback({
        type,
        a,
        b,
        result
      });
      return result;
    }
  }
}

class M{
  @log(function(result:any){
    console.log('1111',result)
  })
  static add(x: number, y: number){
    return x + y
  }
  @log(function(result:any){
    console.log('222',result)
  })
  static sub(x: number, y: number){
    return x - y
  }
}
let v1 = M.add(1, 2);
console.log(v1);
let v2 = M.sub(1, 2);
console.log(v2);
```


# 元数据

在 `装饰器` 函数中 ，我们可以拿到 `类`、`方法` 、`访问符`、`属性`、`参数` 的基本信息，如它们的名称，描述符 等，但是我们想获取更多信息就需要通过另外的方式来进行：`元数据`

## 什么是元数据？ 

`元数据` ：用来描述数据的数据，在我们的程序中，`对象`、`类` 等都是数据，它们描述了某种数据，另外还有一种数据，它可以用来描述 `对象`、`类`，这些用来描述数据的数据就是 `元数据`

> 比如一首歌曲本身就是一组数据，同时还有一组用来描述歌曲的歌手、格式、时长的数据，那么这组数据就是歌曲数据的元数据

```ts
// 不使用元数据
function L(type?:string){
  return function(target:Function){
    target.prototype.type = type
  }
}
function log(type?: string){
  return function(target:Function,name:string,descriptor:PropertyDescriptor){
    // log方法装饰器是比L类方法装饰器先执行的
    let value = descriptor.value
    descriptor.value = function(x: number, y: number){
      let result = value(x,y)
      let _type = type
      if(!_type){
        _type = typeof target ===='function'?target.prototype.type : target.type
      }
      console.log({
        _type,
        a,
        b,
        result
      });
      return result;
    }
  }
}

@L('log')
class M{
  @log('local')
  static add(x: number, y: number){
    return x + y
  }
  @log()
  static sub(x: number, y: number){
    return x - y
  }
}
let v1 = M.add(1, 2);
console.log(v1);
let v2 = M.sub(1, 2);
console.log(v2);
```
> 会添加额外的属性

## 定义元数据

使用 [reflect-metadata](https://www.npmjs.com/package/reflect-metadata)


首先，需要安装 `reflect-metadata`

```shell
npm install reflect-metadata
```

我们可以 `类`、`方法` 等数据定义元数据

- 元数据会被附加到指定的 `类`、`方法` 等数据之上，但是又不会影响 `类`、`方法` 本身的代码

设置

`Reflect.defineMetadata(metadataKey, metadataValue, target, propertyKey)`

- metadataKey：meta 数据的 key
- metadataValue：meta 数据的 值
- target：meta 数据附加的目标
- propertyKey：对应的 property key

调用方式

- 通过  `Reflect.defineMetadata` 方法调用来添加 元数据

- 通过 `@Reflect.metadata` 装饰器来添加 元数据


```typescript
import "reflect-metadata"

@Reflect.metadata("n", 1)
class A {
    @Reflect.metadata("n", 2)
    public static method1() {
    }
  
  	@Reflect.metadata("n", 4)
  	public method2() {
    }
}

// or
Reflect.defineMetadata('n', 1, A);
Reflect.defineMetadata('n', 2, A, 'method1');

let obj = new A();
Reflect.defineMetadata('n', 3, obj);
Reflect.defineMetadata('n', 4, obj, 'method2');

console.log(Reflect.getMetadata('n', A));
console.log(Reflect.getMetadata('n', A, ));
```
获取

`Reflect.getMetadata(metadataKey, target, propertyKey)`

参数的含义与 `defineMetadata` 对应

## 使用元数据的 log 装饰器

```typescript
import "reflect-metadata"
// function L(type?:string){
//   return function(target:Function){
//     Reflect.defineMetadata("type", type, target);
//   }
// }
function log(type?: string){
  return function(target:Function,name:string,descriptor:PropertyDescriptor){
    // log方法装饰器是比L类方法装饰器先执行的
    let value = descriptor.value
    descriptor.value = function(x: number, y: number){
      let result = value(x,y)
      let _type = type
      if(!_type){
        if(typeof target ===='function'){
          _type = Reflect.getMetadata("type", target);
        }else{
          _type = Reflect.getMetadata('type',target.constructor)
        }
      }
      console.log({
        _type,
        a,
        b,
        result
      });
      return result;
    }
  }
}

// @L('log')
@Reflect.metadata('type','storage')
class M{
  @log('local')
  static add(x: number, y: number){
    return x + y
  }
  @log()
  static sub(x: number, y: number){
    return x - y
  }
}
let v1 = M.add(1, 2);
console.log(v1);
let v2 = M.sub(1, 2);
console.log(v2);
```

<!-- markdownlint-disable MD041 MD002--> 