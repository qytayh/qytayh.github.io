---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/kth-node-from-end-of-list-lcci/)

<!-- more -->


## 题目

实现一种算法，找出单向链表中倒数第 k 个节点。返回该节点的值。

**注意：** 本题相对原题稍作改动

**示例：**
```
输入： 1->2->3->4->5 和 k = 2
输出： 4
```
**说明：**

给定的 *k* 保证是有效的。

## 解题思路

此题与 [剑指 Offer 22. 链表中倒数第k个节点](https://juejin.cn/post/7043784099915366407/) 类似
- 本题我们用双指针
- 定义一个快指针比慢指针快`k`个节点
- 当快指针到达尾结点时，慢指针所在节点为我们要找的节点

## 解题代码

```js
var kthToLast = function(head, k) {
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
    return slow.val
};
```

如有任何问题或建议，欢迎留言讨论！


