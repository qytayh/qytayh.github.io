---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/shan-chu-lian-biao-de-jie-dian-lcof/)

<!-- more -->


## 题目

给定单向链表的头指针和一个要删除的节点的值，定义一个函数删除该节点。

返回删除后的链表的头节点。

**注意：** 此题对比原题有改动

**示例 1:**

```
输入: head = [4,5,1,9], val = 5
输出: [4,1,9]
解释: 给定你链表中值为 5 的第二个节点，那么在调用了你的函数之后，该链表应变为 4 -> 1 -> 9.
```

**示例 2:**

```
输入: head = [4,5,1,9], val = 1
输出: [4,5,9]
解释: 给定你链表中值为 1 的第三个节点，那么在调用了你的函数之后，该链表应变为 4 -> 5 -> 9.
```

**说明：**

-   题目保证链表中节点的值互不相同
-   若使用 C 或 C++ 语言，你不需要 `free` 或 `delete` 被删除的节点

## 解题思路

- 删除结点的关键在于找到这个节点让它的上个结点直接指向下个结点

## 解题代码

```js
var deleteNode = function(head, val) {
    if(!head) return head
    if(head.val ==val){
        head = head.next
        return head
    }

    let slow = head
    let fast = head.next
    while(fast){
        if(fast.val==val){
            slow.next = fast.next
            return head
        }
        fast=fast.next
        slow=slow.next
    }
    return head
};
```
