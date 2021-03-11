---
title: Vue组件data为何要函数形式
date: 2020-07-08 21:08:43
tags:
    - vue 
    - 前端面试
categories:
    - [vue]
    - [前端面试]
description:
---

Vue组件中data为什么必须是个函数，而Vue的根实例则没有此限制

<!-- more -->

> 函数每次执行都会返回全新的data对象实例

测试代码如下

```html
<body>
    <div id="demo">
        <h1>Vue组件中data为啥要是函数？</h1>
        <comp></comp>
        <comp></comp>
    </div>
    <script src="https://unpkg.com/vue/dist/vue.js"></script>
    <script>
        Vue.component('comp',{
            template:'<div @click="counter++">{{counter}}</div>',
            data:{counter:0}
        })
        const app = new Vue({
            el: "#demo",
        })
    </script>
</body>
```
我们查看源码研究一下数据是如何初始化的,源码位置`src\core\instance\state.js-initData()`
```js
//如果data是函数，则执行之并将其结果作为data选项的值否则则会执行用户设置的data
data = vm._data = typeof data === 'function'
    ? getData(data, vm)
    : data || {}
```

> 如果每一个组件都是使用的对象来设置data,那么将会作为将来组件实例里的data选项，Vue.component组件的时候其实只执行了一次，每一次初始化的时候对于两个comp的data指向的将会是同一个地方，一个组件的不同实例直接的数据就共享了，会产生数据污染。

我们看一下控制台的报错
```js
vue.js:634 [Vue warn]: The "data" option should be a function that returns a per-instance value in component definitions.
```
> 程序甚至无法通过vue检测

我们接下来再看一下为什么根实例中data可以直接用对象,测试代码如下

```html
<body>
    <div id="demo">
        <h1>Vue组件中data为啥要是函数？</h1>
        <comp></comp>
        <comp></comp>
        <p>{{counter}}</p>
    </div>
    <script src="https://unpkg.com/vue/dist/vue.js"></script>
    <script>
        Vue.component('comp',{
            template:'<div @click="counter++">{{counter}}</div>',
            data(){return {counter:1}}
        })
        const app = new Vue({
            el: "#demo",
            data:{counter:1}
        })
    </script>
</body>
```
从逻辑上来讲，在全局范围内根实例是单例的，不会存在多实例的问题，我们再看一下源码中是怎么处理的
`src/core/instance/init.js-initMinx()-Vue-_init`
```js
// merge options 合并选项
if (options && options._isComponent) {//自定义组件
    // optimize internal component instantiation
    // since dynamic options merging is pretty slow, and none of the
    // internal component options needs special treatment.
    initInternalComponent(vm, options)
} else {//根实例
    vm.$options = mergeOptions(
    resolveConstructorOptions(vm.constructor),
        options || {},
        vm
    )
}
```
我们再看一下`src/core/util/options.js`中对data的处理
```js
strats.data = function (
  parentVal: any,
  childVal: any,
  vm?: Component
): ?Function {
  if (!vm) {//只有当根实例创建的时候vm才会存在，普通组件VM不存在，所以进入方法
    if (childVal && typeof childVal !== 'function') {
      process.env.NODE_ENV !== 'production' && warn(
        'The "data" option should be a function ' +
        'that returns a per-instance value in component ' +
        'definitions.',
        vm
      )
      return parentVal
    }
    return mergeDataOrFn(parentVal, childVal)
  }
  return mergeDataOrFn(parentVal, childVal, vm)
}

```

**结论**

Vue组件可能存在多个实例，如果使用对象形式定义data，则会导致它们共用一个data对象，那么状态
变更将会影响所有组件实例，这是不合理的；采用函数形式定义，在initData时会将其作为工厂函数返
回全新data对象，有效规避多实例之间状态污染问题。而在Vue根实例创建过程中则不存在该限制，也
是因为根实例只能有一个，不需要担心这种情况。

<!-- markdownlint-disable MD041 MD002--> 