---
title: 从零开始进阶全栈之NODE基础api
date: 2021-09-18 21:56:40
tags:
    - 全栈之路
    - node
categories:
    - node
description: 
---

本篇内容：异步I/O概念、promisify用法、流、buffer，http服务

<!-- more -->

# 异步I/O概念

对于这个概念，网上有一个很经典的例子

隔壁王大爷有个水壶，王大爷经常用它来烧开水。
- 王大爷把水壶放到火上烧，然后啥也不干在那等，直到水开了王大爷再去搞别的事情。（同步阻塞）
- 王大爷觉得自己有点憨，不打算等了。把水壶放上去之后大爷就是去看电视，时不时来瞅一眼有没有开（同步非阻塞）
- 王大爷去买了个响水壶，他把响水壶放在火上，然后也是等着水开，水开的时候水壶会发出声响（异步阻塞）
- 王大爷又觉得自己有点憨，他把响水壶放在火上然后去看电视，这时他不用是不是来瞅一眼，因为水开的时候水壶会发出声音通知大爷。（异步非阻塞）

上面四个例子里，阻塞非阻塞说明的是大爷的状态，同步非同步说明的是水壶的调用姿势。水壶能在烧好的时候主动响起，就等同于我们异步的定义，能在结束时通知主线程并且回调。所以异步一般配合非阻塞，才能发挥其作用。

# promisify

```js
const fs = require('fs')
// 同步调用 
const data = fs.readFileSync('./xxx.js'); //代码会阻塞在这里 
console.log(data);// 打出的是 buffer数据 如果要显示实际数据 打印 data.toString()

// 异步调用
// 错误优先的回调
fs.readFile('./xxxx.js',(err,data)=>{
    if(err) throw err
    console.log(data.toString())
})

// promisify
// promise风格接口
const {promisify} = require('util')
const readFile = promisify(fs.readFile)
readFile('./xxx.js').then(data=>console.log(data))

// fs Promises API node v10 
const fsp = require("fs").promises; 
fsp.readFile("./confs.js")
.then(data => console.log(data)) 
.catch(err => console.log(err));

// async/await
(async ()=>{
    const fs = require('fs')
    const {promisify} = require('util')
    const readFile = promisify(fs.readFile)
    const data = await readFile('./xxx.js')
    console.log(data.toString())
})()

```

# buffer对象

Buffer - 用于在 TCP 流、文件系统操作、以及其他上下文中与八位字节流进行交互。 八位字节组成的数组，可以有效的在JS中存储二进制数据

```js
//创建一个长度为10字节以0填充的Buffer
const buf1 = Buffer.alloc(10) // 分配10字节的内存空间
// 读取Buffer数据
console.log(buf1)  // <Buffer 00 00 00 00 00 00 00 00 00 00>

//创建一个Buffer包含ascii.
const buf2 = Buffer.from('a')
console.log(buf2)  //<Buffer 61>

// 创建Buffer 包含utf-8字节
// UFT-8：一种变长的编码方案，使用 1~6 个字节来存储； 
// UFT-32：一种固定长度的编码方案，不管字符编号大小，始终使用 4 个字节来存储； 
// UTF-16：介于 UTF-8 和 UTF-32 之间，使用 2 个或者 4 个字节来存储，长度既固定又可变。
const buf3 = Buffer.from('中文')
console.log(buf3,buf3.toString()) //<Buffer e4 b8 ad e6 96 87> 中文

// 合并  图片的上传 二进制=> 分包  分包接收
const buf4 = Buffer.concat([buf2,buf3])
console.log(buf4,buf4.toString())  // <Buffer 61 e4 b8 ad e6 96 87> 'a中文'

// 写入buffer
buf1.write('hello')
console.log(buf1,buf1.toString()) //<Buffer 68 65 6c 6c 6f 00 00 00 00 00> 'hello\u0000\u0000\u0000\u0000\u0000'

```
> Buffer类似数组，所以很多数组方法它都有
> GBK转码 icon-lite

# http服务

创建一个http服务器

```js
const http = require('http')
const server = http.createServer((request,response) => {
    console.log('request',request)
    response.end('hello node')
}) 
server.listen(3000)
// 使用 node/nodemon 启动
// 访问localhost:3000 
```

显示一个首页
```js
const http = require('http')
const server = http.createServer((request,response) => {
    const {url, method} = request; 
    if (url === '/' && method === 'GET') { 
        fs.readFile('index.html', (err, data) => { 
            if (err) { 
                response.writeHead(500, { 'Content-Type': 'text/plain;charset=utf-8' }); 
                response.end('500，服务器错误'); 
                return;
            }
            response.statusCode = 200; 
            response.setHeader('Content-Type', 'text/html'); 
            response.end(data);
        }); 
    }else if (url === '/users' && method === 'GET') { 
        // 编写一个接口
        response.writeHead(200, { 'Content-Type': 'application/json' }); 
        response.end(JSON.stringify([{name:'tom',age:20}]));
    } 
    else { 
        response.statusCode = 404; 
        response.setHeader('Content-Type', 'text/plain;charset=utf-8'); 
        response.end('404, 页面没有找到'); 
    }
}) 
server.listen(3000)
```

# Stream流

```js
const fs = require('fs')
const rs =  fs.createReadStream('./1.jpg')
const ws = fs.createWriteStream('./2.jpg')
rs.pipe(ws) // 占用内存少
```

```js
const http = require('http')
const fs = require('fs') 
const server = http.createServer((request,response) => {
    const {url, method, headers} = request; 
    if (url === '/' && method === 'GET') { 
        ...
    }
    ...
    // 所有的图片请求
    else if (method === 'GET' && headers.accept.includes('image/*')) { 
        // 不使用fs.readFile() ----> 读文件 全部存入内存 1k  100m
        // 使用createReadStream 流的方式
        fs.createReadStream('.'+url).pipe(response); 
    }
    ...
    else{
        ...
    }
}) 
server.listen(3000)
```




<!-- markdownlint-disable MD041 MD002--> 