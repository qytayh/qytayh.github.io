---
title: 在vue中使用graphql
date: 2020-05-25 16:31:14
tags:
    - vue
    - graphql
categories:
    - vue
    - graphql
description:
---

记录在vue中使用graphql踩过的坑

<!-- more -->
# 安装依赖
首先我们保证已经有了一个vue项目，输入以下命令

`npm install --save vue-apollo graphql apollo-client apollo-link apollo-link-http apollo-cache-inmemory graphql-tag`

# 引入
创建apollo.js并输入以下代码

```ts
import { ApolloClient } from 'apollo-client'
import { createHttpLink } from 'apollo-link-http'
import { InMemoryCache } from 'apollo-cache-inmemory'
import {ApolloLink} from 'apollo-link'
// 与 API 的 HTTP 连接
const httpLink = createHttpLink({
  // 你需要在这里使用绝对路径
  uri: process.env.VUE_APP_BASEURL + 'graphql',
})
const middlewareLink = new ApolloLink((operation, forward) => {
  let token = '';
  //配置token验证
  let api_token = JSON.parse(sessionStorage.getItem('api_token')!)
  if (api_token) {
      token = api_token
  }
  operation.setContext({
      headers: {
          Authorization: `Bearer ${token}` || null
      }
  })
  return forward(operation)
})
// 缓存实现
const cache = new InMemoryCache()
// 创建 apollo 客户端
export const apolloClient = new ApolloClient({
  link: middlewareLink.concat(httpLink),
  cache,
})
```
然后在main.js中引入
```ts
import * as apollo from './plugins/apollo'
import VueApollo from 'vue-apollo'

Vue.use(VueApollo)
const apolloProvider = new VueApollo({
  defaultClient: apollo.apolloClient,
})
```
使用 apolloProvider 选项将它添加到你的应用程序
```ts
new Vue({
  router,
  vuetify,
  i18n,
  store,
  apolloProvider,
  render: h => h(App)
}).$mount('#app');
```
# 使用
在我们需要使用graphql的页面引入`gql`

`import gql from 'graphql-tag'`

然后创建一个js文件`query.js`用来编写查询语句，并在我们使用graphql的页面引入

`
import * as sql from './query'
`

在`query.js`中添加查询代码如下

```js
import gql from 'graphql-tag'
export var report1 = gql `query($id: ID!){
     contracts(first:10,id:$id){
        data{
            id
            address
            contract_no
            order{
                contract_id
            }
        }
    }
}`
```

然后回到我们需要使用apollo的页面，使用如下方法进行查询

```js
this.$apollo.query({
          query: sql.report1,
          variables: {
            id: 195,
          },
          fetchPolicy:"no-cache",//禁止缓存
      }).then(res => {
          console.log(res)
      }).catch(err => {
          console.log(err)
      })
```
{% asset_img 1.png [如图，我们便得到了查询结果] %}

<!-- markdownlint-disable MD041 MD002--> 