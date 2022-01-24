---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/delete-middle-node-lcci/)

<!-- more -->


## 题目

若链表中的某个节点，既不是链表头节点，也不是链表尾节点，则称其为该链表的「中间节点」。

假定已知链表的某一个中间节点，请实现一种算法，将该节点从链表中删除。

例如，传入节点 `c`（位于单向链表 `a->b->c->d->e->f` 中），将其删除后，剩余链表为 `a->b->d->e->f`

**示例：**

```
输入： 节点 5 （位于单向链表 4->5->1->9 中）
输出： 不返回任何数据，从链表中删除传入的节点 5，使链表变为 4->1->9
```

## 解题思路

- 我们直接改写这个节点 让他成为他自己的下个节点
- 让次节点的`val`等于下个节点的 `val`
- 让次节点的`next`等于下个节点的 `next`

## 解题代码

```js
var deleteNode = function(node) {
    node.val = node.next.val
    node.next = node.next.next
};
```
