---
title: LeetCode-206-反转链表
date: 2021-12-01 23:28:00
tags:
- 算法
- LeetCode
categories:
- 算法
- LeetCode
description:
---


看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!


[题目地址](https://leetcode-cn.com/problems/reverse-linked-list/)

<!-- more -->

## 题目

给你单链表的头节点 `head` ，请你反转链表，并返回反转后的链表。

**示例一:**

![image.png](https://p1-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/8205a093a8854a81b24bc36a571b8b3e~tplv-k3u1fbpfcp-watermark.image?)

```
输入： head = [1,2,3,4,5]
输出： [5,4,3,2,1]
```

**示例二:**


![image.png](https://p1-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/591a722d12574a97924a45f206a5e876~tplv-k3u1fbpfcp-watermark.image?)

```
输入： head = [1,2]
输出： [2,1]
```

**示例三:**

```
输入： head = []
输出： []
```

> 提示
> -  链表中节点的数目范围是 `[0, 5000]`
> -  `-5000 <= Node.val <= 5000`


## 解题思路

![image.png](https://p3-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/d13536358394445c9fa6ebaefa7a6bca~tplv-k3u1fbpfcp-watermark.image?)
- 最后一项的`next`一定是`null`，因为当前的第一项为结果的最后一项，因此有`head.next=null`

![image.png](https://p9-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/71795b5ce939484ba50aa2869992b47f~tplv-k3u1fbpfcp-watermark.image?)
- 我们接下来通过修改next的指向来解题(第二项的`next`原本指向`3`,我们将其指向`2`)

![image.png](https://p1-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/f65d82ec6b4b4920bf62ee89a6ba7e91~tplv-k3u1fbpfcp-watermark.image?)

- 后面的逻辑就跟第二步一样了


## 解题代码

```js
var reverseList = function(head) {
    if(!head||!head.next) return head
    let current = head.next
    head.next = null
    while (current){
        let b = current.next
        current.next = head
        head = current
        current = b
    }
    return head
};
```
<!-- markdownlint-disable MD041 MD002--> 