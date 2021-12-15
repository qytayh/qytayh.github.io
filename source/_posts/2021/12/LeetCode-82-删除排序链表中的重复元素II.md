---
title: LeetCode-82-删除排序链表中的重复元素II
date: 2021-12-15 23:49:40
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

[题目地址](https://leetcode-cn.com/problems/remove-duplicates-from-sorted-list-ii/)

<!-- more -->

## 题目
存在一个按升序排列的链表，给你这个链表的头节点`head`，请你删除链表中所有存在数字重复情况的节点，只保留原始链表中 没有重复出现的数字。

返回同样按升序排列的结果链表。

**示例 1：**

![image.png](https://p3-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/1c70e3d36ddd4093996ef0b9b478b2a3~tplv-k3u1fbpfcp-watermark.image?)

```
输入： head = [1,2,3,3,4,4,5]
输出： [1,2,5]
```

**示例 2：**


![image.png](https://p9-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/71bc22ed0f64433f815977fe9a65ca39~tplv-k3u1fbpfcp-watermark.image?)

```
输入： head = [1,1,1,2,3]
输出： [2,3]
```

> 提示：
> - 链表中节点数目在范围 `[0, 300]` 内
> - `-100 <= Node.val <= 100`
> - 题目数据保证链表已经按升序排列



## 解题思路

- 我们先找到有重复元素的第一个节点
- 从有重复元素的节点向后找到第一个与之不重复的节点
- 将有重复元素节点第一个元素的前置节点指向第一个与之不重复的节点

## 解题代码

```js
var deleteDuplicates = function(head) {
    if(!head) return head
    let vnode = new ListNode(-1,head)
    let pre = vnode
    let cur = vnode.next
    while(cur&&cur.next){
        if(cur.val==cur.next.val){
            let fast = cur.next
            while(fast.next&&cur.val==fast.next.val){
                fast= fast.next
            }
            cur = fast.next
            pre.next = fast.next
        }else{
            pre = cur
            cur = cur.next
        }
    }
    return vnode.next
};
```


<!-- markdownlint-disable MD041 MD002--> 