---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/design-circular-queue/)

<!-- more -->


## 题目

设计你的循环队列实现。 循环队列是一种线性数据结构，其操作表现基于 FIFO（先进先出）原则并且队尾被连接在队首之后以形成一个循环。它也被称为“环形缓冲器”。

循环队列的一个好处是我们可以利用这个队列之前用过的空间。在一个普通队列里，一旦一个队列满了，我们就不能插入下一个元素，即使在队列前面仍有空间。但是使用循环队列，我们能使用这些空间去存储新的值。

你的实现应该支持如下操作：

- `MyCircularQueue(k)`: 构造器，设置队列长度为`k`。
- `Front`: 从队首获取元素。如果队列为空，返回`-1`。
- `Rear`: 获取队尾元素。如果队列为空，返回`-1`。
- `enQueue(value)`: 向循环队列插入一个元素。如果成功插入则返回真。
- `deQueue()`: 从循环队列中删除一个元素。如果成功删除则返回真。
- `isEmpty()`: 检查循环队列是否为空。
- `isFull()`: 检查循环队列是否已满。

**示例：**

```
MyCircularQueue circularQueue = new MyCircularQueue(3); // 设置长度为 3
circularQueue.enQueue(1);  // 返回 true
circularQueue.enQueue(2);  // 返回 true
circularQueue.enQueue(3);  // 返回 true
circularQueue.enQueue(4);  // 返回 false，队列已满
circularQueue.Rear();  // 返回 3
circularQueue.isFull();  // 返回 true
circularQueue.deQueue();  // 返回 true
circularQueue.enQueue(4);  // 返回 true
circularQueue.Rear();  // 返回 4
```

> 提示
> - 所有的值都在`0`至`1000`的范围内；
> - 操作数将在`1`至`1000`的范围内；
> - 请不要使用内置的队列库。


## 解题思路

- 我们定义一个数组，如果数组的长度与要求的队列长度长度相同则`isFull`
- 如果数组的长度为`0`，则满足`isEmpty`
- `enQueue`其实就是往数组中`push`元素
- `deQueue`其实就是移除数组的第一项元素
- `Rear`获取最后一项也就是获取数组的第`length-1`项

## 解题代码

```js
/**
 * @param {number} k
 */
var MyCircularQueue = function(k) {
    this.maxLen = k
    this.arr = []
};

/** 
 * @param {number} value
 * @return {boolean}
 */
MyCircularQueue.prototype.enQueue = function(value) {
    if(this.isFull()) return false
    this.arr.push(value)
    return true
};

/**
 * @return {boolean}
 */
MyCircularQueue.prototype.deQueue = function() {
    if(this.isEmpty()) return false
    let [a,...args] = this.arr
    this.arr = [...args]
    return true
};

/**
 * @return {number}
 */
MyCircularQueue.prototype.Front = function() {
    if(!this.arr.length) return -1
    return this.arr[0]
};

/**
 * @return {number}
 */
MyCircularQueue.prototype.Rear = function() {
    if(!this.arr.length) return -1
    return this.arr[this.arr.length-1]
};

/**
 * @return {boolean}
 */
MyCircularQueue.prototype.isEmpty = function() {
    return this.arr.length ==0
};

/**
 * @return {boolean}
 */
MyCircularQueue.prototype.isFull = function() {
    return this.arr.length ==this.maxLen
};

/**
 * Your MyCircularQueue object will be instantiated and called as such:
 * var obj = new MyCircularQueue(k)
 * var param_1 = obj.enQueue(value)
 * var param_2 = obj.deQueue()
 * var param_3 = obj.Front()
 * var param_4 = obj.Rear()
 * var param_5 = obj.isEmpty()
 * var param_6 = obj.isFull()
 */
```

如有任何问题或建议，欢迎留言讨论！
