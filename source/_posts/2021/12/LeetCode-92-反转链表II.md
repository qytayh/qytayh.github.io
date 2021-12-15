---
title: LeetCode-92-反转链表II
date: 2021-12-04 23:35:15
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

[题目地址](https://leetcode-cn.com/problems/reverse-linked-list-ii/)

<!-- more -->

## 题目

给你单链表的头指针`head`和两个整数`left`和`right`，其中`left<=right`。请你反转从位置`left`到位置`right`的链表节点，返回反转后的链表。

**示例 1：**

![image.png](https://p9-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/0e44a8a40c8e4042920b8869546542b0~tplv-k3u1fbpfcp-watermark.image?)

```
输入：head = [1,2,3,4,5], left = 2, right = 4
输出：[1,4,3,2,5]
```

**示例 2：**

```
输入：head = [5], left = 1, right = 1
输出：[5]
```

> 提示:
> -   链表中节点数目为 `n`
> -   `1 <= n <= 500`
> -   `-500 <= Node.val <= 500`
> -   `1 <= left <= right <= n`


## 解题思路

![2.gif](https://p9-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/81e3e732f53f4f9a8c2a70516d2b450d~tplv-k3u1fbpfcp-watermark.image?)

- 找到开始反转的节点`left`,记录下反转的前驱节点`con`以及反转开始的节点(也是反转部分的尾结点)`tail`
- 开始反转操作
- 反转到`right`，此时反转的链表最后的一个节点(也是反转部分的头结点)为`pre`，后置节点`cur`
- 将我们一开始记录的前驱节点`con`指向`pre`，反转部分的尾结点`tail`指向`cur`便可完成解题



## 解题代码

```js
var reverseBetween = function(head, left, right) {
    if(!head||left == right) return head
    let count = right - left +1
    let vnode = new ListNode(-1,head)
    let pre = vnode
    let cur = pre.next
    while (--left){
        pre = pre.next
    }
    pre.next = reverseList(pre.next,count)
    return vnode.next
}

var reverseList = function(head,n) {
   let pre =null
    let cur = head
    while (n--){
       [cur.next,pre,cur] = [pre,cur,cur.next]
    }
    head.next = cur
    return pre
};
```

<!-- markdownlint-disable MD041 MD002--> 