---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起。


[题目地址](https://leetcode-cn.com/problems/linked-list-cycle-ii/)


<!-- more -->

## 题目

给定一个链表，返回链表开始入环的第一个节点。 如果链表无环，则返回`null`。

如果链表中有某个节点，可以通过连续跟踪`next`指针再次到达，则链表中存在环。 为了表示给定链表中的环，评测系统内部使用整数`pos`来表示链表尾连接到链表中的位置（索引从`0`开始）。如果`pos`是`-1`，则在该链表中没有环。注意`pos`不作为参数进行传递，仅仅是为了标识链表的实际情况。

> 不允许修改链表。

**示例 1：**

![image.png](1.png)

```
输入： head = [3,2,0,-4], pos = 1
输出： 返回索引为 1 的链表节点
解释： 链表中有一个环，其尾部连接到第二个节点。
```

**示例 2：**

![image.png](2.png)

```
输入： head = [1,2], pos = 0
输出： 返回索引为 0 的链表节点
解释： 链表中有一个环，其尾部连接到第一个节点。
```

**示例 3：**

![image.png](3.png)

```
输入： head = [1], pos = -1
输出： 返回 null
解释： 链表中没有环。
```

> 提示：
> -   链表中节点的数目范围在范围 `[0, 104]` 内
> -   `-105 <= Node.val <= 105`
> -   `pos` 的值为 `-1` 或者链表中的一个有效索引

## 解题思路

![image.png](4.png)

从上图中，我们不难得出，两指针相遇时
- 快指针走过的节点为 `A+N(B+C)+B`
- 慢指针走过的节点为 `A+B`
- 因为有快指针速度是慢指针的`2`倍
- 所以 `A+N(B+C)+B=2(A+B)`
简化等式得到 `A =(N-1)(B+C)+C`
> `B+C`为一个环，我们可以忽略，因此可以得到`A=C`,只要在快慢指针相遇时从头结点开始有个指针向下走，跟慢指针相遇的节点就是我们要输出的`pos`节点


## 解题代码

```js
var detectCycle = function(head) { 
    if(!head) return null 
    let fast = head 
    let slow = head
    let pos = head 
    while (fast&&fast.next){ 
        slow = slow.next 
        fast = fast.next.next 
        if(slow==fast) {
            while (slow){ 
                if(slow==pos)  return pos 
                slow = slow.next
                pos = pos.next 
            } 
            return null
        }
    }
    return null 
};
```

如有任何问题或建议，欢迎留言讨论！








