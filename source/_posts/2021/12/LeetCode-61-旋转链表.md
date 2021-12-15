---
title: LeetCode-61-旋转链表
date: 2021-12-07 23:40:10
tags:
- 算法
- LeetCode
categories:
- 算法
- LeetCode
description:
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起。


[题目地址](https://leetcode-cn.com/problems/rotate-list/)

<!-- more -->

## 题目

给你一个链表的头节点`head`，旋转链表，将链表每个节点向右移动`k`个位置。

**示例 1：**


![image.png](https://p6-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/ac0fa47051d241488dc2d67fa1e8aa0f~tplv-k3u1fbpfcp-watermark.image?)

```
输入： head = [1,2,3,4,5], k = 2
输出： [4,5,1,2,3]
```

**示例 2：**

![image.png](https://p9-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/cbacc2c873a841d2a208020f5ceabb7f~tplv-k3u1fbpfcp-watermark.image?)

```
输入： head = [0,1,2], k = 4
输出： [2,0,1]
```

> 提示：
> -  链表中节点的数目在范围 `[0, 500]` 内
> -  `-100 <= Node.val <= 100`
> -  `0 <= k <= 2 * 109`


## 解题思路

- 将尾结点指向`head`
- 将尾结点的前置节点指向`null`
- 重复`k`次上面的动作


## 解题代码
```js
var rotateRight = function(head, k) {
    if(!head) return head
    let list = head
    while(k--){
        list = doRotate(list)
    }
    return list
};

var doRotate = function(head){
    let cur = head
    while(cur.next&&cur.next.next){
        cur = cur.next
    }
    if(!cur.next) return cur
    cur.next.next = head
    let z = cur.next
    cur.next = null
    return z
}
```

## 遇到了一些问题

使用如上的解法，看着没有毛病，但是在`k`的值特别大时，会超时

![image.png](https://p3-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/866d9284080b44b49a1a37b5fc7df295~tplv-k3u1fbpfcp-watermark.image?)

## 优化方案

- 我们先获取到链表的长度`i`
- 用`k`对`i`取余得到我们要旋转的最小次数`con`
- 进行`con`次旋转


## 最终解题代码
```js
var rotateRight = function(head, k) {
    if(!head) return head
    let i = 1
    let cur = head
    while (cur.next){
        cur = cur.next
        i++
    }
    let con = k%i
    let list = head
    while(con--){
        list = doRotate(list)
    }
    return list
};

var doRotate = function(head){
    let cur = head
    while(cur.next&&cur.next.next){
        cur = cur.next
    }
    if(!cur.next) return cur
    cur.next.next = head
    let z = cur.next
    cur.next = null
    return z
}
```

<!-- markdownlint-disable MD041 MD002--> 