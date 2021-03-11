---
title: Vue组件化
date: 2020-06-11 09:15:04
tags:
    - vue
categories:
    - vue
description:
---

Vue组件系统提供了一种抽象，让我们可以使用独立可复用的组件来构建大型应用，任意类型的应用程序界面都可以抽象为一个组件树。组件化可以提高开发效率，方便重复使用，简化调试步骤，提升项目可维护性，便于多人协同开发。

<!-- more -->

# 组件通信

## props

父给子传值
```js
//child
props:{ msg: String}

//parent
<HelloWorld msg="hello world">
```

## 自定义事件

子给父传值

```js
// child
this.$emit('add', good)
// parent
<Cart @add="cartAdd($event)"></Cart>
```

## 事件总线

任意两个组件之间传值常用事件总线或vuex的方式

```js
//Bus:事件触发、监听和回调管理
class Bus{
    constructor(){
        this.callbacks={}
    }
    $on(name,fn){
        this.callbacks[name]=this.callbacks[name]||[]
        this.callbacks[name].push(fn)
    }
    $emit(name,args){
        if(this.callbacks[name]){
            this.callbacks[name].forEach(cb => cb(args))
        }
    }
}

//main.js
Vue.prototype.$bus = new Bus()

//child1
this.$bus.$on('foo',msg => {})

//child2
this.$bus.$emit('foo',msg)
```

实践中通常用Vue代替Bus,因为Vue已经实现了相应的接口

## vuex

创建唯一的全局数据管理者store，通过他管理数据并通知组件状态变更

详细见[Vue统一状态管理——Vuex](https://qytayh.github.io/2020/06/Vue%E7%BB%9F%E4%B8%80%E7%8A%B6%E6%80%81%E7%AE%A1%E7%90%86%E2%80%94%E2%80%94Vuex/)

## $parent/$root

兄弟组件之间通信可以通过共同的祖辈搭桥，$parent或$root,与Bus总线类似

```js
//brother1
this.$parent.$on('foo',msg => {})

//brother2
this.$parent.$emit('foo',msg)
```

## $children

父组件可以通过$children访问子组件，实现父子通信
```js
//parent
this.$children[0].xx = 'xxx'
```
  注意：$children不能保证子元素顺序 (异步组件)

## $attr/$listener

包含了父作用域中不作为prop被识别(且获取)的特性绑定(class和style除外)。当一个组件没有声明任何prop时，这里会包含所有父作用域的绑定(class和style除外)，并且可以通过 vbind="$attrs"传入内部组件——在创建高级别的组件时非常有用。

```js
//child:并未在props内声明foo
<p>{{$attrs.foo}}</p>

//parent
<Helloworld foo = 'foo'>
```

## refs

获取子节点引用

```js
//parent
<Helloworld ref='hw'>

mounted(){
    this.$refs.hw.xx = ''
}
```

## provide/inject

能够实现祖先和后代之间传值(依赖注入)

```js
//ancestor 
provide(){//与data、mounted平级
    return {
        foo:'foooooo'
    }
}

//descendant
<p>{{foo}}</p>

inject:['foo']
```
也可以使用别名
```js
//子组件中
<p>{{bar}}</p>

inject:{bar:{from:'foo'}}
```
  provide和inject主要在开发高阶插件/组件库时使用。并不推荐用于普通应用程序代码中。


# 插槽

插槽语法是Vue实现的内容分发API，用于复合组件开发。该技术在通用组件库开发中有大量应用。

## 匿名插槽

```html
<!-- comp1 -->
<div>
    <solt></solt>
</div>

<!-- parent -->
<Comp1>
    <template>content...</template>
</Comp1>
```

## 具名插槽

将内容分发到子组件指定位置

```html
<!-- comp2 -->
<div>
    <solt></solt>
    <solt name="content"></solt>
</div>

<!-- parent -->
<Comp2>
    <!-- 默认插槽使用default做参数 -->
    <template v-solt:default>具名插槽</template>
    <!-- 具名插槽使用插槽名做参数 -->
    <template v-solt:content>内容。。</template>
<Comp2>
```

## 作用域插槽

分发内容要用到子组件中的数据

```html
<!-- comp3 -->
<div>
    <solt :foo="foo"></solt>
</div>

<!-- parent -->
<Comp3>
    <!-- 把v-slot的值指定为作用域上下文对象 -->
    <template v-solt:default="soltProps">
        来自子组件数据：{{soltProps.foo}}
    </template>
</Comp3>
```

范例

```html
<!-- parent -->
<!-- 插槽 -->
<Layout>
<!-- 作用域插槽 -->
<!-- 对象解构 -->
    <template v-slot:footer="{fc}">{{fc}}</template>
</Layout>

<!-- children -->
<div class="footer">
    <slot name="footer" :fc="footerContent"></slot>
</div>
```
```js
//parent
import Layout from '@/components/slots/Layout.vue'
export default {
    components: {
      Layout
    },
}


// children 
data() {
    return {
        remark: [
          '好好学习，天天向上',
          '学习永远不晚',
          '学习知识要善于思考,思考,再思考',
          '学习的敌人是自己的满足,要认真学习一点东西,必须从不自满开始',
          '构成我们学习最大障碍的是已知的东西,而不是未知的东西',
          '在今天和明天之间,有一段很长的时间;趁你还有精神的时候,学习迅速办事',
          '三人行必有我师焉；择其善者而从之，其不善者而改之'
        ]
    }
},
computed: {
    footerContent() {
        return this.remark[new Date().getDay() - 1] 
    }
},
```

<!-- markdownlint-disable MD041 MD002--> 