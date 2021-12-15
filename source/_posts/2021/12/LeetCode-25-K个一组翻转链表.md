---
title: LeetCode-25-K个一组翻转链表
date: 2021-12-08 23:38:47
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


[题目地址](https://leetcode-cn.com/problems/reverse-nodes-in-k-group/)

<!-- more -->

## 题目

给你一个链表，每`k`个节点一组进行翻转，请你返回翻转后的链表。

`k`是一个正整数，它的值小于或等于链表的长度。

如果节点总数不是`k`的整数倍，那么请将最后剩余的节点保持原有顺序。

**示例 1：**

![image.png](https://p3-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/977d2e02162c40dcae481e239ff46c3a~tplv-k3u1fbpfcp-watermark.image?)

```
输入： head = [1,2,3,4,5], k = 2
输出： [2,1,4,3,5]
```

**示例 2：**


![image.png](https://p3-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/410927d8dbb641cebefe9cbac317a9d8~tplv-k3u1fbpfcp-watermark.image?)

```
输入：head = [1,2,3,4,5], k = 3
输出：[3,2,1,4,5]
```

**示例 3：**

```
输入：head = [1,2,3,4,5], k = 1
输出：[1,2,3,4,5]
```

**示例 4：**

```
输入：head = [1], k = 1
输出：[1]
```

> 提示：
> - 列表中节点的数量在范围 `sz` 内
> - `1 <= sz <= 5000`
> - `0 <= Node.val <= 1000`
> - `1 <= k <= sz`

## 解题思路

> 在解此题前，期待你已经解出了[`206_反转链表`](https://juejin.cn/post/7038607426685239310)和[`92_ 反转链表II`](https://juejin.cn/post/7039725859254566942)

- 此题在92题的基础上加上了多次翻转
- 第一步，从head开始向后反转`k`个节点
- 反转结束后head节点指向第`k+1`个节点
- 重复上面步骤
- 若节点个数不足`k`个，则不翻转

## 解题代码

```js
var reverseKGroup = function (head, k) {
  if (!head) return head;
  let vnode = new ListNode(-1, head);
  let pre = vnode;
  do {
    pre.next = reverse(pre.next, k);
    for (let i = 0; (i < k) && pre; i++) {
      pre = pre.next;
    }
    if (!pre) break;
  } while (1);
  return vnode.next;
};
var reverse = function (head, n) {
  let pre = head;
  let con = n;
  let cur = head;
  while (--n&&pre) {
    pre = pre.next;
  }
  if (!pre) return head;
  pre = null;
  while (con--) {
    [cur.next, pre, cur] = [pre, cur, cur.next];
  }
  head.next = cur;
  return pre;
};
```

<!-- markdownlint-disable MD041 MD002--> 