---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/implement-queue-using-stacks-lcci/)

<!-- more -->


## 题目

实现一个`MyQueue`类，该类用两个栈来实现一个队列。

**示例：**

```
MyQueue queue = new MyQueue();

queue.push(1);
queue.push(2);
queue.peek();  // 返回 1
queue.pop();   // 返回 1
queue.empty(); // 返回 false
```

> 说明：
> - 你只能使用标准的栈操作 -- 也就是只有`push to top`, `peek/pop from top`,`size`和`is empty`操作是合法的。
> - 你所使用的语言也许不支持栈。你可以使用`list`或者`deque`（双端队列）来模拟一个栈，只要是标准的栈操作即可。
> - 假设所有操作都是有效的 （例如，一个空的队列不会调用`pop`或者`peek`操作）。


## 解题思想

看到这个题，相信看过我的题解的小伙伴们一定会非常的熟悉，这不就是 [**设计循环队列**](https://juejin.cn/post/7040836577735475213) 的简化版嘛！

- 我们用数组来解题
- `push`为常规数组操作
- `empty`判断数组长度是否为`0`
- `peek`直接返回数组的第一个元素
- `pop`删除数组的第一个元素并将删除的元素返回


## 解题代码

```js
/**
 * Initialize your data structure here.
 */
var MyQueue = function() {
    this.arr = []
};

/**
 * Push element x to the back of queue. 
 * @param {number} x
 * @return {void}
 */
MyQueue.prototype.push = function(x) {
    this.arr.push(x)
};

/**
 * Removes the element from in front of queue and returns that element.
 * @return {number}
 */
MyQueue.prototype.pop = function() {
    let [a,...args] = this.arr
    this.arr = [...args]
    return a
};

/**
 * Get the front element.
 * @return {number}
 */
MyQueue.prototype.peek = function() {
    return this.arr[0]
};

/**
 * Returns whether the queue is empty.
 * @return {boolean}
 */
MyQueue.prototype.empty = function() {
    return this.arr.length == 0
};

/**
 * Your MyQueue object will be instantiated and called as such:
 * var obj = new MyQueue()
 * obj.push(x)
 * var param_2 = obj.pop()
 * var param_3 = obj.peek()
 * var param_4 = obj.empty()
 */
```

如有任何问题或建议，欢迎留言讨论！

