---
title: nodejs文件操作
date: 2021-03-16 16:33:58
tags:
  - node
categories:
  - node
description:
---

使用nodejs进行文件以及目录的创建，删除，修改，复制。

<!-- more -->

```js
const fs = require('fs') //文件操作
// 增删改查;
// 1.文件操作   2.目录操作

// 文件操作
fs.writeFile('1.txt',"我是写入的文字",function(err){
    if(err){
        return console.log(err)
    }
    console.log("success")
})

// a:追加写入;w:写入;r:读取
fs.writeFile('1.txt',"我是zhuijia的文字",{flag:"a"},function(err){
    if(err){
        return console.log(err)
    }
    console.log("success")
})

// 读取
fs.readFile('1.txt',"utf8",(err,data)=>{
    if(err){
        return console.log(err)
    }
    console.log(data)
})
fs.readFile('1.txt',(err,data)=>{
    if(err){
        return console.log(err)
    }
    console.log(data,toString())
})

// 所有的文件操作  没有加Sync都是异步  否则是同步
let data = fs.readFileSync('1.txt')
console.log(data.toString())

// 修改文件名
fs.rename("1.txt","2.txt",function(err){
    if(err){
        return console.log(err)
    }
    console.log("success")
})

// 删除
fs.unlink('2.txt',err=>{
    if(err){
        return console.log(err)
    }
    console.log("success")
})

// 复制
fs.copyFile('1.js',"2.js",err=>{
    if(err){
        return console.log(err)
    }
    console.log("success")
})


// 复制
function myCopy(src,dest){
    fs.writeFileSync(dest,fs.readFileSync(src))
}

// 目录操作

// 创建目录
fs.mkdir('test',err=>{
    if(err){
        return console.log(err)
    }
    console.log("success")
})

// 修改目录名称
fs.rename('test',"test1",err=>{
    if(err){
        return console.log(err)
    }
    console.log("success")
})

// 读取目录
fs.readdir('test1',(err,data)=>{
    if(err){
        return console.log(err)
    }
    console.log(data)
})

// 删除目录(空文件夹/目录)
fs.rmdir('test1',err=>{
    if(err){
        return console.log(err)
    }
    console.log("success")
})

// 判断文件/目录是否存在  true/false
fs.exists("test",exists=>{
    console.log(exists)
})

// 获取文件活目录的详细信息
fs.stat('1.js',(err,stat)=>{
    if(err){
        return console.log(err)
    }
    // console.log(stat)
    // let res =stat.isFile()//判断是否是文件
    let res =stat.isDirectory()//判断是否是文件夹
    console.log(res)
})

// 删除非空文件夹
// 先把目录里文件删除->删除空目录
removeDir('test1')
function removeDir(path){
    let data=fs.readdirSync(path)
    data.forEach(v=>{
        //是文件直接删除    目录继续查找
        let url = `${path}/${v}`
        let stat=fs.statSync(url)
        if(stat.isFile()){
            // 文件 删除
            fs.unlinkSync(url)
        }else{
            //目录 继续查找
            removeDir(url)
        }
    })
    fs.rmdirSync(path)
}
```


<!-- markdownlint-disable MD041 MD002--> 