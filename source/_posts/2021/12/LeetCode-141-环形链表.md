---
title: LeetCode-141-环形链表
date: 2021-12-02 23:30:23
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


[题目地址](https://leetcode-cn.com/problems/linked-list-cycle/)

<!-- more -->

## 题目

给你一个链表的头节点`head`，判断链表中是否有环。

如果链表中有某个节点，可以通过连续跟踪 next 指针再次到达，则链表中存在环。为了表示给定链表中的环，评测系统内部使用整数`pos`来表示链表尾连接到链表中的位置（索引从`0`开始）。如果`pos`是 -1，则在该链表中没有环。注意`pos`不作为参数进行传递，仅仅是为了标识链表的实际情况。

如果链表中存在环，则返回`true`。 否则，返回`false`。

**示例 1：**

![image.png](https://p3-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/c59a8bc5551b4bac8f9ad1fd88ee9cce~tplv-k3u1fbpfcp-watermark.image?)

```
输入： head = [3,2,0,-4], pos = 1
输出： true
解释： 链表中有一个环，其尾部连接到第二个节点。
```

**示例 2：**

![image.png](https://p9-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/eae6cbfc4ed14d138c63f740d0e72508~tplv-k3u1fbpfcp-watermark.image?)

```
输入： head = [1,2], pos = 0
输出： true
解释： 链表中有一个环，其尾部连接到第一个节点。
```

**示例 3：**


![image.png](https://p9-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/c78ba43a94674a44b2cc6072568822a5~tplv-k3u1fbpfcp-watermark.image?)

```
输入： head = [1], pos = -1
输出： false
解释： 链表中没有环。
```

> 提示
> -   链表中节点的数目范围是 `[0, 104]`
> -   `-105 <= Node.val <= 105`
> -   `pos` 为 `-1` 或者链表中的一个**有效索引** 。


## 解题思路


![1.gif](https://p9-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/ad1b8658f5424ff3804e813fc98f6ccf~tplv-k3u1fbpfcp-watermark.image?)

定义两个指针：慢指针每次走一个节点，快指针每次走两个节点，最终相遇。

## 解题代码

```js
var hasCycle = function(head) {
    if(!head||!head.next) return false
    let slow = head
    let fast = head
    while(fast&&fast.next){
        slow=slow.next
        fast = fast.next.next
        if(fast==slow) return true
    }
    return false
};
```


<!-- markdownlint-disable MD041 MD002--> 