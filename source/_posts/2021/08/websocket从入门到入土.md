---
title: websocket从入门到入土
date: 2021-08-18 15:17:03
tags:
  - websocket
categories:
  - websocket
description:
---

# 什么是`websocket`？

`websocket`是一种网络传输协议，可在单个`tcp`连接上进行全双工通信，位于`OSI`模型的应用层。

<!-- more -->

特点：
- `TCP`链接，与`HTTP`协议兼容
- 双向通信，主动推送（服务端向客户端）
- 无同源限制，协议标识符为ws（加密wss）

# 应用场景

- 聊天、消息、点赞
- 直播评论（弹幕）
- 游戏、协调编辑、基于位置的应用


# 开始你的第一个websocket应用

## websocket常用前端库

- ws (实现原生协议，特点：通用、性能高，定制型强)
- socket.io (向下兼容协议，特点：适配性强，性能一般)

## 3分钟编写一个ws应用

1. 新建`server`目录，通过`npm init -y`初始化`server`目录
2. `npm install ws` 安装ws库
3. 新建`index.js`作为入口文件
```js
const WebSocket = require('ws')
const wss = new WebSocket.Server({port:3000})

wss.on('connection',function connection(ws){
  console.log('on client is connected')
})
```
4. 根目录下新建一个`client`目录，并添加`index.html`文件
```js
 var ws =  new WebSocket('ws://127.0.0.1:3000')
```
5. 通过`node index.js`启动服务端
6. 访问客户端的`index.html`，我们可以看到服务端控制台输出有用户连接了

> 客户端中使用ws方法与服务端类似

# 常见API介绍

https://developer.mozilla.org/zh-CN/docs/Web/API/WebSocket

# websocket常见状态
```js
ws.onopen = function(){
  console.log('open'+ws.readyState) // 1
  ws.send('hello from client')
}
ws.onmessage = function(msg){
  console.log('message'+ws.readyState) // 1
  console.log(msg)
}
// 连接主动断开时触发
ws.onclose = function(){
  console.log('close'+ ws.readyState)  //  close: 服务端断开 3  客户端主动断开 3
  console.log('yiguanbi')
}
// 当连接失败触发error事件
ws.onerror = function(){
  console.log('error'+ ws.readyState)  //  erroe:3
}
```

# 实现一个ws广播
```js
// server端

...
wss.clients.forEach((client)=>{
  // 判断非自己的客户端 并且有连接的客户端
  if(ws!==client&&client.readyState===WebSocket.OPEN){
    client.send(msg.toString())
  }
})
...

```

# 统计进入聊天室的人数
```js
// client
// 改写sendMSg方法
sendMsg(){
  this.lists.push(this.name+":"+this.message)
  this.ws.send(JSON.stringify({
    event:'message',
    message:this.message,
    name:this.name // 传递用户名
  }))
  this.message=''
},
// 改写onMsessage
onMessage(event){
  if(this.isshow) return // 未进入聊天室则不接收消息
  var obj = JSON.parse(event.data)
  if(obj.event==='enter'){
    this.lists.push('欢迎'+obj.message+'加入聊天室')
  }else if(obj.event ==='out'){
    this.lists.push(obj.name+'离开了聊天室')
  }else {
    if(obj.name!==this.name){
      this.lists.push(obj.name+":"+obj.message)
    }
  }
  this.num = obj.num
},

// server

// 定义一个全局的变量num用于人数统计
let num = 0

ws.on("message", function (msg) {
  const msgObj = JSON.parse(msg);
  if (msgObj.event === "enter") {
    ws.name = msgObj.message;
    num++;
  }
  // ws.send(msg)
  // 广播消息
  wss.clients.forEach((client) => {
    if (client.readyState === WebSocket.OPEN) {
      // 为了获取在线的聊天人数
      msgObj.num = num;
      client.send(JSON.stringify(msgObj));
    }
  });
});

// 当ws客户端断开
ws.on("close", function () {
  if(ws.name){
    num--;
  }
  let msgObj = {}
  // 广播消息
  wss.clients.forEach((client) => {
    if (client.readyState === WebSocket.OPEN) {
      // 为了获取在线的聊天人数
      msgObj.num = num;
      msgObj.name = ws.name;
      msgObj.event = 'out'
      client.send(JSON.stringify(msgObj));
    }
  });
});

```

# 实现多聊天室

调整`client`代码，在`enter`的时候带上聊天室的`id`,广播的时候只对该聊天室进行广播
```js
// client
enter(){
  if(this.name.trim()==='')  {
    alert('用户名不得为空')
    return
  }
  this.isShow=false
  this.ws.send(JSON.stringify({
    event:'enter',
    message:this.name,
    roomid:this.roomid
  }))
}

// server
 wss.clients.forEach((client) => {
  if (client.readyState === WebSocket.OPEN&& client.roomid ===ws.roomid) {
    msgObj.name = ws.name
    client.send(JSON.stringify(msgObj));
  }
});
```

# websocket鉴权

- 协议本身在握手阶段不提的
- 浏览器侧：url传参、message主动消息，session/cookie
- Nodejs侧：直接使用ws传Header

# 心跳检测&断线重连

```js
// server 发送心跳检测
const timeInterval = 1000
setInterval(()=>{
  wss.clients.forEach((ws)=>{
    if(!ws.isAlive){
      group[ws.roomid]--
      return ws.terminate() //关闭ws链接
    }
    // 主动发送心跳检测请求
    // 当客户端返回了消息后，主动设置flag为在线
    ws.isAlive = false
    ws.send(JSON.stringify({
      event:'heartbeat',
      message:'ping'
    }))
  })
},timeInterval)

// client 响应
onMessage(event) {
  if (this.isShow) return; //用户没进入聊天室 就不接收消息
  console.log("message" + this.ws.readyState); // 1
  var obj = JSON.parse(event.data);
  switch (obj.event) {
    case "noAuth":
      // 鉴权失败
      // 重新获取token
      break;
    case "enter":
      this.lists.push("欢迎" + obj.message + "加入聊天室");
      break;
    case "out":
      this.lists.push(obj.name + "离开了聊天室");
      break;
    case 'heartbeat':// 响应心跳检测
      this.ws.send(JSON.stringify({
        event:'heartbeat',
        message:'pong'
      }))
      break;
    default:
      if (obj.name !== this.name) {
        this.lists.push(obj.name + ":" + obj.message);
      }
  }
  this.num = obj.num;
}
```

```js
// client 断线重连
// 新增定时器方法
checkServer(){
  clearTimeout(this.handle)
  this.handle = setTimeout(() => {
    this.onClose()
    this.initWS()
  }, 1000+500);
}

// 改写onError
 onError() {
  console.log("error" + ws.readyState); //  erroe:3
  // 连接失败后1s 尝试断线重连
  setTimeout(() => {
    this.initWS()
  }, 1000);
},
```


> 相关代码请移步github -----> [websocketBase](https://github.com/qytayh/websocketBase)







<!-- markdownlint-disable MD041 MD002--> 