---
title: LeetCode-86-分隔链表
date: 2021-12-15 23:58:40
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

[题目地址](https://leetcode-cn.com/problems/partition-list/)

<!-- more -->

## 题目

给你一个链表的头节点`head`和一个特定值`x`，请你对链表进行分隔，使得所有小于`x`的节点都出现在 大于或等于`x`的节点之前。

你应当保留两个分区中每个节点的初始相对位置。

**示例 1：**


![image.png](https://p9-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/f26ebcd7a39b4f0a87d65a410d02b1ba~tplv-k3u1fbpfcp-watermark.image?)

```
输入：head = [1,4,3,2,5,2], x = 3
输出：[1,2,2,4,3,5]
```

**示例 2：**

```
输入：head = [2,1], x = 2
输出：[1,2]
```

> 提示：
> - 链表中节点的数目在范围 `[0, 200]` 内
> - `-100 <= Node.val <= 100`
> - `-200 <= x <= 200`

## 解题思路

- 将链表分成两个链表，分别为小于`x`的小链表和大于等于`x`的大链表
- 将小链表与大链表连接即可完成解题



## 解题代码

```js
var partition = function(head, x) {
    if(!head||!head.next) return head
    let vnodeBig = new ListNode(-1,head)
    let vnodeSmall = new ListNode(-1,head)
    let big = vnodeBig
    let small = vnodeSmall
    while(head){
        if(head.val<x){
            small.next = head
            small = small.next
        }else{
            big.next =head
            big = big.next
        }
        head = head.next
    }
    big.next = null
    small.next = vnodeBig.next
    return vnodeSmall.next
};
```

<!-- markdownlint-disable MD041 MD002--> 