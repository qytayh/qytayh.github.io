---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/design-circular-deque/)

<!-- more -->


## 题目

设计实现双端队列。

你的实现需要支持以下操作：

- `MyCircularDeque(k)`：构造函数,双端队列的大小为`k`。
- `insertFront()`：将一个元素添加到双端队列头部。 如果操作成功返回`true`。
- `insertLast()`：将一个元素添加到双端队列尾部。如果操作成功返回`true`。
- `deleteFront()`：从双端队列头部删除一个元素。 如果操作成功返回`true`。
- `deleteLast()`：从双端队列尾部删除一个元素。如果操作成功返回`true`。
- `getFront()`：从双端队列头部获得一个元素。如果双端队列为空，返回`-1`。
- `getRear()`：获得双端队列的最后一个元素。 如果双端队列为空，返回`-1`。
- `isEmpty()`：检查双端队列是否为空。
- `isFull()`：检查双端队列是否满了。

**示例：**

```
MyCircularDeque circularDeque = new MycircularDeque(3); // 设置容量大小为3
circularDeque.insertLast(1);			        // 返回 true
circularDeque.insertLast(2);			        // 返回 true
circularDeque.insertFront(3);			        // 返回 true
circularDeque.insertFront(4);			        // 已经满了，返回 false
circularDeque.getRear();  				// 返回 2
circularDeque.isFull();				        // 返回 true
circularDeque.deleteLast();			        // 返回 true
circularDeque.insertFront(4);			        // 返回 true
circularDeque.getFront();				// 返回 4
```


## 解题思路

-   我们定义一个数组，如果数组的长度与要求的队列长度长度相同则`isFull`
-   如果数组的长度为`0`，则满足`isEmpty`
-   `insertLast`其实就是往数组中第一项插入元素
-   `insertLast`其实就是往数组中`push`元素
-   `deleteFront`其实就是移除数组的第一项元素
-   `deleteLast`其实就是移除数组的最后一项元素
-   `getRear`获取最后一项也就是获取数组的第`length-1`项
-   `getFront`获取数组第`0`项

> 提示：
> - 所有值的范围为`[1, 1000]`
> - 操作次数的范围为`[1, 1000]`
> - 请不要使用内置的双端队列库。


## 解题代码

```js
/**
 * @param {number} k
 */
var MyCircularDeque = function(k) {
    this.maxLen = k 
    this.arr = []
};

/** 
 * @param {number} value
 * @return {boolean}
 */
MyCircularDeque.prototype.insertFront = function(value) {
    if(this.isFull()) return false
    this.arr = [value,...this.arr]
    return true
};

/** 
 * @param {number} value
 * @return {boolean}
 */
MyCircularDeque.prototype.insertLast = function(value) {
    if(this.isFull()) return false
    this.arr.push(value)
    return true
};

/**
 * @return {boolean}
 */
MyCircularDeque.prototype.deleteFront = function() {
 if(this.isEmpty()) return false
    let [a,...args] = this.arr
    this.arr = [...args]
    return true
};

/**
 * @return {boolean}
 */
MyCircularDeque.prototype.deleteLast = function() {
    if(this.isEmpty()) return false
    this.arr = this.arr.slice(0,this.arr.length-1)
    return true
};

/**
 * @return {number}
 */
MyCircularDeque.prototype.getFront = function() {
    if(this.isEmpty()) return -1
    return this.arr[0]
};

/**
 * @return {number}
 */
MyCircularDeque.prototype.getRear = function() {
    if(!this.arr.length) return -1
    return this.arr[this.arr.length-1]
};

/**
 * @return {boolean}
 */
MyCircularDeque.prototype.isEmpty = function() {
    return this.arr.length == 0
};

/**
 * @return {boolean}
 */
MyCircularDeque.prototype.isFull = function() {
    return this.arr.length == this.maxLen
};

/**
 * Your MyCircularDeque object will be instantiated and called as such:
 * var obj = new MyCircularDeque(k)
 * var param_1 = obj.insertFront(value)
 * var param_2 = obj.insertLast(value)
 * var param_3 = obj.deleteFront()
 * var param_4 = obj.deleteLast()
 * var param_5 = obj.getFront()
 * var param_6 = obj.getRear()
 * var param_7 = obj.isEmpty()
 * var param_8 = obj.isFull()
 */
```

如有任何问题或建议，欢迎留言讨论！
