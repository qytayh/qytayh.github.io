---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/lian-biao-zhong-dao-shu-di-kge-jie-dian-lcof/)

<!-- more -->


## 题目

输入一个链表，输出该链表中倒数第k个节点。为了符合大多数人的习惯，本题从1开始计数，即链表的尾节点是倒数第1个节点。

例如，一个链表有 `6` 个节点，从头节点开始，它们的值依次是 `1、2、3、4、5、6`。这个链表的倒数第 `3` 个节点是值为 `4`的节点。

**示例：**

```
给定一个链表: 1->2->3->4->5, 和 k = 2.

返回链表 4->5.
```


## 解题思路

- 此题与[面试题 02.02. 返回倒数第 k 个节点](https://juejin.cn/post/7043782360219222047) 类似
- 本题我们用双指针
- 定义一个快指针比慢指针快`k`个节点
- 当快指针到达尾结点时，慢指针所在节点为我们剩余链表的头结点

## 解题代码

```js
var getKthFromEnd = function(head, k) {
    let slow = head
    let fast =head
    while(k-1){
        fast = fast.next
        k--
    }
    while(fast.next){
        fast=fast.next
        slow = slow.next
    }
    return slow
};
```

如有任何问题或建议，欢迎留言讨论！