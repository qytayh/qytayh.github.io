---
title: LeetCode-83-删除排序链表中的重复元素
date: 2021-12-15 23:45:43
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

[题目地址](https://leetcode-cn.com/problems/remove-duplicates-from-sorted-list/)

<!-- more -->

## 题目

存在一个按升序排列的链表，给你这个链表的头节点`head`，请你删除所有重复的元素，使每个元素只出现一次。

返回同样按升序排列的结果链表。

**示例 1：**


![image.png](https://p9-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/001afd9c8c514668ac04fe37f9e9a8e4~tplv-k3u1fbpfcp-watermark.image?)

```
输入： head = [1,1,2]
输出： [1,2]
```

**示例 2：**


![image.png](https://p9-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/c68c58a1c33f41c28d54a7df37ebc326~tplv-k3u1fbpfcp-watermark.image?)

```
输入：head = [1,1,2,3,3]
输出：[1,2,3]
```

> 提示：
> - 链表中节点数目在范围`[0, 300]`内
> - `-100 <= Node.val <= 100`
> - 题目数据保证链表已经按升序排列

## 解题思路

- 因为链表是有序的，所以重复的元素一定是相连的
- 我们只需要比较相邻的两个节点的值是否相等
- 如果相等，则左节点指向右节点的后置节点完成删除

## 解题代码

```js
var deleteDuplicates = function(head) {
    if(!head) return head
    let cur = head
    while(cur.next){
        if(cur.val == cur.next.val){
            cur.next = cur.next.next
        }else{
            cur = cur.next
        }
    }
    return head
};
```

<!-- markdownlint-disable MD041 MD002--> 