---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/design-linked-list/)

<!-- more -->


## 题目

设计链表的实现。您可以选择使用单链表或双链表。单链表中的节点应该具有两个属性：`val` 和 `next`。`val` 是当前节点的值，`next` 是指向下一个节点的指针/引用。如果要使用双向链表，则还需要一个属性 `prev` 以指示链表中的上一个节点。假设链表中的所有节点都是 0-index 的。

在链表类中实现这些功能：

- get(index)：获取链表中第 `index` 个节点的值。如果索引无效，则返回`-1`。
- addAtHead(val)：在链表的第一个元素之前添加一个值为 `val` 的节点。插入后，新节点将成为链表的第一个节点。
- addAtTail(val)：将值为 `val` 的节点追加到链表的最后一个元素。
- addAtIndex(index,val)：在链表中的第 `index` 个节点之前添加值为 `val` 的节点。如果 `index` 等于链表的长度，则该节点将附加到链表的末尾。如果 `index` 大于链表长度，则不会插入节点。如果`index`小于0，则在头部插入节点。
- deleteAtIndex(index)：如果索引 `index` 有效，则删除链表中的第 `index` 个节点。

**示例：**

```
MyLinkedList linkedList = new MyLinkedList();
linkedList.addAtHead(1);
linkedList.addAtTail(3);
linkedList.addAtIndex(1,2);   //链表变为1-> 2-> 3
linkedList.get(1);            //返回2
linkedList.deleteAtIndex(1);  //现在链表是1-> 3
linkedList.get(1);            //返回3
```

**提示：**
-   所有`val`值都在 `[1, 1000]` 之内。
-   操作次数将在 `[1, 1000]` 之内。
-   请不要使用内置的 LinkedList 库。

## 解题思路

- 我们定义一个头节点`head`,以及用来存储链表长度的`length`
- `get`方法中我们先对传入的`index`先进行处理如果在`0-length`之间则处理否则返回`-1`,遍历链表当到第`index`个时返回对应节点的`val`
- 至于`addAtHead`和`addAtTail`我们可以统一放到`addAtIndex`中来处理
- `addAtIndex`函数中我们同样的需要先按题目要求对`index`处理，`index<0`时让其等于`0`
- 然后判断链表有无节点，没有节点的话将传入的作为头结点否则就遍历链表到index的前一位置执行插入操作
- 删除其实也是类似的操作，找到`index`所在节点的前置节点，将其`next`指向`index`后置节点


## 解题代码

```js
var MyLinkedList = function() {
    this.head = null
    this.length = 0
};
var NodeList = function (val,next){
    this.val = val
    this.next = next
}

/**
 * @param {number} index
 * @return {number}
 */
MyLinkedList.prototype.get = function(index) {
    let cur = this.head
    if(index>=0&&index<this.length){
        if(index==0) return this.head.val
        let i = 0;
        while (cur  && i < index) {
            cur = cur.next;
            i++;
        }
        return cur.val;
    }
    return -1
};

/**
 * @param {number} val
 * @return {void}
 */
MyLinkedList.prototype.addAtHead = function(val) {
    this.addAtIndex(0, val);
};

/**
 * @param {number} val
 * @return {void}
 */
MyLinkedList.prototype.addAtTail = function(val) {
    this.addAtIndex(this.length, val);
};

/**
 * @param {number} index
 * @param {number} val
 * @return {void}
 */
MyLinkedList.prototype.addAtIndex = function(index, val) {
    let cur = this.head
    if(index>this.length) return
    if(index<=0||this.size==0){
        this.head = new NodeList(val)
       this.head.next = cur
    }else{
        while (index-- > 1) {
            cur = cur.next
        }
        let addNode = new NodeList(val)
        addNode.next = cur.next
        cur.next = addNode
    }
    this.length++
};

/**
 * @param {number} index
 * @return {void}
 */
MyLinkedList.prototype.deleteAtIndex = function(index) {
    if(!this.head) return
    if(index>=0&&index<this.length){
        let cur = this.head
       if(index==0){
           this.head = cur.next
       }else {
           let pre =null
           let i=0
           while (i<index && cur){
               pre = cur
               cur = cur.next
               i++
           }
           pre.next = cur.next
       }
        this.length--
    }
};
```
如有任何问题或建议，欢迎留言讨论！
