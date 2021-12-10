---
title: TS装饰器之防抖节流
date: 2021-08-31 20:54:11
tags:
  - TypeScript
categories:
  - TypeScript
description:
---

首先，我们先来了解一下什么是防抖和节流。

<!-- more -->

# 防抖（debounce）

**函数防抖，这里的抖动就是执行的意思，而一般的抖动都是持续的，多次的。假设函数持续多次执行，我们希望让它冷静下来再执行。也就是当持续触发事件的时候，函数是完全不执行的，等最后一次触发结束的一段时间之后，再去执行**

特点：

- 持续触发不执行
- 最后一次触发过了一段时间之后再执行

我们写 js 的时候通常会这么来写

```js
function debounce(fn, delay) {
  let timer = null
  return function () {
    if (timer) {
      clearTimeout(timer);
    }
    timer = setTimeout(fn, delay);
  };
}

function test(){
  console.log('test')
}

// 调用的时候 以滚动为例
window.onscroll = debounce(test, 1000);
```



# 节流（throttle）

**所谓节流，就是指连续触发事件但是在 n 秒中只执行一次函数。节流会稀释函数的执行频率。**

说的通俗一点就是设计一种类似控制阀门一样定期开放的函数，也就是让函数执行一次后，在某个时间段内暂时失效，过了这段时间后再重新激活（类似于技能冷却时间）。

特点:

- 如果短时间内大量触发同一事件，那么在函数执行一次之后，该函数在指定的时间期限内不再工作，直至过了这段时间才重新生效.

js中我们的常见写法
```js
function throttle(fun, wait) {
    let timeout = null;
    return function() {
      if (!timeout) {
        timeout = setTimeout(function(){
          timeout = null;
          fun()
        }, wait)
      }
    }
}
function test(){
  console.log('test')
}

// 调用的时候 我们还是以滚动为例
window.onscroll = throttle(test, 500);
```

# 进阶（TS装饰器）

> 在你阅读这节之前，希望你已经了解了[TS基础](https://qytayh.github.io/2021/08/TypeScript%E8%BF%98%E4%B8%8D%E4%BC%9A-%E7%9C%8B%E5%AE%8C%E8%BF%99%E7%AF%87%E5%B0%B1%E8%A1%8C%E4%BA%86/)以及[装饰器的基本用法](https://qytayh.github.io/2021/08/TS%E8%BF%9B%E9%98%B6%E4%B9%8B-%E8%A3%85%E9%A5%B0%E5%99%A8/)。

```TS
// 工具函数
const delayDefault = 500;

// 防抖
export const debounce = (delay = delayDefault) => {
  return function(target, key, descriptor) {
    const oldValue = descriptor.value;
    let timer: any = null;
    descriptor.value = function() {
      clearTimeout(timer);
      timer = setTimeout(() => {
        oldValue.apply(this, arguments);
      }, delay);
    };
    return descriptor;
  };
};

// 节流 时间戳写法
export const throttle = (delay = delayDefault) => {
  return function(target, key, descriptor) {
    let lastTime, timer;
    const oldFunction = descriptor.value;
    descriptor.value = function() {
      let nowTime = +new Date();
      if (lastTime && nowTime - lastTime < delay) {
        if (timer) {
          clearTimeout(timer);
        }
        timer = setTimeout(() => {
          oldFunction.apply(this, arguments);
          lastTime = nowTime;
        }, delay);
      } else {
        oldFunction.apply(this, arguments);
        lastTime = nowTime;
      }
    };
    return descriptor;
  };
};

// 节流  定时器写法
export const throttle = (delay = delayDefault) => {
  return function(target, key, descriptor) {
    let timer: any = null;
    const oldFunction = descriptor.value;
    descriptor.value = function() {
      if (!timer) {
        timer = setTimeout(() => {
          timer = null;
          oldFunction.apply(this, arguments);
        }, delay);
      }
    };
    return descriptor;
  };
};

```

以上两种节流都可正常使用，没有好坏之分，看个人喜好。

```TS
// 使用
class Test{

  @debounce()
  funA(){
    console.log('A')
  }

  @throttle()
  funB(){
    console.log('B')
  }

}
```



<!-- markdownlint-disable MD041 MD002-->
