---
title: 自己动手封装一个Vue表单组件
date: 2020-06-30 20:40:26
tags:
    - vue
categories:
    - vue
description:
---

仿element-ui封装一个通用的表单组件

<!-- more -->

# 需求分析

- 实现JForm
    - 指定数据，校验规则

- JFormItem
    - 执行校验
    - 显示错误信息

- JInput
    - 维护数据

最终理想效果：[element Form 表单](https://element.eleme.cn/#/zh-CN/component/form)

# JInput

创建components/form/JInput.vue

```vue
<template>
  <div>
    <!-- 自定义组件双向绑定：:value  @input -->
    <!-- v-bind="$attrs"展开$attrs 每一个项都可以单独设置上去 -->
    <input :type="type" :value="value" @input="onInput" v-bind="$attrs">
  </div>
</template>
<script> 
  export default {
    inheritAttrs: false, // 设置为false避免attrs设置到根元素上
    props: {
      value: {
        type: String,
        default: ''
      },
      type: {
        type: String,
        default: 'text'
      }
    },
    methods: {
      onInput(e) {
        // 派发一个input事件即可
        this.$emit('input', e.target.value)
      }
    },
  }
</script>
```

# 使用JInput

创建components/form/index.vue，添加如下代码：

``` vue
<template>
    <div>
        <h3>JForm表单</h3><hr>
        <j-input v-model="model.username"></j-input>
        <j-input type="password" v-model="model.password"></j-input>
    </div>
</template>
<script>
import JInput from "./JInput";
export default {
    components: {
        JInput
    },
    data() {
        return {
            model: { username: "Joker", password: "" },
        };
    }
};
</script>
```

# 实现JFormItem

创建components/form/JFormItem.vue

``` vue
<template>
    <div>
        <label v-if="label">{{label}}</label>
        <solt></solt>
        <p v-if="error">{{error}}</p>
    </div>
</template>
<script>
export default {
    props:{
        label:{//输入项标签
            type:String,
            default:''
        }
    },
    data(){
        return{
            error:''//校验错误信息
        }
    }
}
</script>
```

# 使用JFormItem

在components/form/index.vue中添加基础代码

```vue
<template>
    <div>
        <h3>JForm表单</h3><hr>
        <j-form-item label="用户名">
            <j-input v-model="model.username"></j-input>
        </j-form-item>
        <j-form-item label="密码">
            <j-input type="password" v-model="model.password"></j-input>
        </j-form-item>
    </div>
</template>
<script>
import JInput from "./JInput";
import JFormItem from "./JFormItem";
export default {
    components: {
        JInput,JFormItem
    },
    data() {
        return {
            model: { username: "Joker", password: "" },
        };
    }
};
</script>
```

# 实现JForm

创建components/form/JForm.vue

```vue
<template>
    <form>
        <solt></solt>
    <form>
</template>
<script>
export default {
    provide() {
        return {
            form: this // 将组件实例作为提供者，子代组件可方便获取
        };
    },
    props: {
        model: {
            type: Object,
            required: true
        },
        rules: {
            type: Object
        }
    }
}
</script>
```

# 使用JForm

在components/form/index.vue中添加基础代码

```vue
<template>
  <div> 
    <!-- JForm -->
    <JForm :model="userInfo" :rules="rules" ref="loginForm">
      <!-- 用户名 -->
      <JFormItem label="用户名" prop="username">
        <JInput v-model="userInfo.username" placeholder="请输入用户名"></JInput>
      </JFormItem>
      <!-- 密码 -->
      <JFormItem label="密码" prop="password">
        <JInput type="password" v-model="userInfo.password" placeholder="请输入用户名"></JInput>
      </JFormItem>
      <!-- 提交按钮 -->
      <JFormItem>
        <button @click="login">登录</button>
      </JFormItem>
    </JForm>
  </div>
</template>
<script>
import JInput from "./JInput";
import JFormItem from "./JFormItem";
import JForm from "./JForm";

export default {
    components: {
        JInput,JFormItem,JForm
    },
    data() {
        return {
            rules: {
                username: [{ required: true, message: "请输入用户名" }],
                password: [{ required: true, message: "请输入密码" }]
            },
            model: { username: "Joker", password: "" },
        };
    },
    methods:{
        login(){
            this.$refs['loginForm'].validate(valid => {
                if(valid){
                    alert("请求登录")
                }else{
                    alert("请求失败")
                }
            })
        }
    }
};
</script>
```

# 数据校验

JInput中通知校验，修改components/form/JInput.vue中代码
```
<!-- dom -->
<input :type="type" :value="value" @input="onInput" v-bind="$attrs">

<!-- methods -->
onInput(e) {
    // 派发一个input事件即可
    this.$emit('input', e.target.value)
    // 通知父级执行校验
    this.$parent.$emit('validate')
}
```

JFormItem监听校验通知，获取规则并执行校验，修改components/form/JFormItem.vue

```vue
<template>
    <div>
        <label v-if="label">{{label}}</label>
        <solt></solt>
        <p v-if="error">{{error}}</p>
    </div>
</template>
<script>
export default {
    inject:['form'],//注入
    mounted(){//监听校验事件
        this.$on('validate',()=>{this.validate()})
    },
    methods:{
        validate(){
            //获取对应JFormItem的校验规则
            console.log(this.form.rules[this.prop]);
            //获取对应JFormItem的值
            console.log(this.form.model[this.prop]);
        }
    },
    props:{
        label:{//输入项标签
            type:String,
            default:''
        },
        prop: {
            type: String
        }
    },
    data(){
        return{
            error:''//校验错误信息
        }
    }
}
</script>
```

安装校验库async-validator： `npm i async-validator -S`

在components/form/JFormItem.vue中引入，并添加校验代码

```js
import Schema from "async-validator";
...
validate(){
    //获取对应校验规则
    const rules = this.form.rules[this.prop];
    //获取校验值
    const value = this.form.model[this.prop];
    //获取描述对象
    const desc = {[this.prop]:rules};
    //创建Schema实例
    const schema = new Schema(desc)
    return schema.validate({[this.prop]:value},errors =>{
        if(errors){
            this.error=errors[0].message
        }else{
            //校验通过
            this.error=''
        }
    })
}
```

# 表单全局校验

为JForm提供validate方法，修改components/form/JForm.vue

``` js
validate(cb){
    // 获取所有孩子KFormItem
    // [resultPromise]
    const task = this.$children
    .filter(item => item.prop) // 过滤掉没有prop属性的Item
    .map(item => item.validate())
    //统一处理所有的Promise结果
    Promise.all(tasks)
    .then(()=> cb(true))
    .catch(()=> cb(false))
}
```




<!-- markdownlint-disable MD041 MD002--> 