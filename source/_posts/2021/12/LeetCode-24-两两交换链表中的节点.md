---
title: LeetCode-24-两两交换链表中的节点
date: 2021-12-15 23:42:01
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


[题目地址](https://leetcode-cn.com/problems/swap-nodes-in-pairs/)

<!-- more -->
## 题目

给你一个链表，两两交换其中相邻的结点，并返回交换后链表的头节点。你必须在不修改节点内部的值的情况下完成本题（即，只能进行节点交换）。

**示例 1：**

![image.png](https://p9-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/b99322cdfdeb42768ecde9689ec74238~tplv-k3u1fbpfcp-watermark.image?)

```
输入： head = [1,2,3,4]
输出： [2,1,4,3]
```
**示例 2：**

```
输入： head = []
输出： []
```

**示例 3：**

```
输入： head = [1]
输出： [1]
```


> 提示：
> - 链表中节点的数目在范围 `[0, 100]` 内
> - `0 <= Node.val <= 100`

## 解题思路

- 先理解题目要求：
    - 将链表分为n个长度为2的小链表
    - 每个小链表进行翻转

- 理解了题目要要求那就好办了，我们可以先定义一个虚拟头结点，从虚拟头结点向后找两个节点并记录第二个节点的后置节点
- 将第一个节点指向后置节点，第二个节点指向第一个节点，并将第一个节点当做下一次交换的虚拟头节点的位置
- 循环上面操作

## 解题代码

```js
var swapPairs = function (head) {
  let vnode = new ListNode(-1, head), pre = vnode;
  while (pre.next && pre.next.next) {
   let cur = pre.next
   let last = pre.next.next
   cur.next = last.next
   last.next= cur
   pre.next = last
   pre = cur
  }
  return vnode.next;
};
```
<!-- markdownlint-disable MD041 MD002--> 