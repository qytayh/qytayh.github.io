---
title: LeetCode-19-删除链表中的倒数第N个结点
date: 2021-12-15 23:43:27
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


[题目地址](https://leetcode-cn.com/problems/remove-nth-node-from-end-of-list/submissions/)

<!-- more -->

## 题目

给你一个链表，删除链表的倒数第`n`个结点，并且返回链表的头结点。

**示例 1：**


![image.png](https://p3-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/b39515d5d003460aa1c82fedf4e66992~tplv-k3u1fbpfcp-watermark.image?)

```
输入： head = [1,2,3,4,5], n = 2
输出： [1,2,3,5]
```

**示例 2：**

```
输入： head = [1], n = 1
输出： []
```

**示例 3：**

```
输入： head = [1,2], n = 1
输出： [1]
```

> 提示：
> - 链表中结点的数目为 `sz`
> - `1 <= sz <= 30`
> - `0 <= Node.val <= 100`
> - `1 <= n <= sz`

## 解题思路

- 定义两个指针，快指针比慢指针快`n`
- 当快指针到达尾结点时，慢指针刚好到达要删除的结点
- 将慢指针的下个节点指向要删除节点的后置节点便可完成删除

## 解题代码

```js
var removeNthFromEnd = function(head, n) {
    let vnode = new ListNode(-1,head)
    let slow = vnode
    let fast = vnode
    while(n--) fast =fast.next
    if(!fast) return vnode.next
    while(fast.next){
        fast=fast.next
        slow= slow.next
    }
    slow.next = slow.next.next
    return vnode.next
};
```


<!-- markdownlint-disable MD041 MD002--> 