---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/design-front-middle-back-queue/)

<!-- more -->


## 题目

请你设计一个队列，支持在前，中，后三个位置的`push`和`pop`操作。

请你完成`FrontMiddleBack`类：

- `FrontMiddleBack()`初始化队列。
- `void pushFront(int val)`将`val`添加到队列的 最前面 。
- `void pushMiddle(int val)`将`val`添加到队列的 正中间 。
- `void pushBack(int val)`将`val`添加到队里的 最后面 。
- `int popFront()`将最前面的元素从队列中删除并返回值，如果删除之前队列为空，那么返回`-1`。
- `int popMiddle()`将正中间的元素从队列中删除并返回值，如果删除之前队列为空，那么返回`-1`。
- `int popBack()`将最后面的元素从队列中删除并返回值，如果删除之前队列为空，那么返回`-1`。

请注意当有 **两个** 中间位置的时候，选择靠前面的位置进行操作。比方说：

- 将`6`添加到`[1, 2, 3, 4, 5]`的中间位置，结果数组为`[1, 2, 6, 3, 4, 5]`。
- 从`[1, 2, 3, 4, 5, 6]`的中间位置弹出元素，返回`3`，数组变为`[1, 2, 4, 5, 6]`。

**示例 1：**
```
输入：
["FrontMiddleBackQueue", "pushFront", "pushBack", "pushMiddle", "pushMiddle", 
"popFront", "popMiddle", "popMiddle", "popBack", "popFront"]
[[], [1], [2], [3], [4], [], [], [], [], []]
输出：
[null, null, null, null, null, 1, 3, 4, 2, -1]

解释：
FrontMiddleBackQueue q = new FrontMiddleBackQueue();
q.pushFront(1);   // [1]
q.pushBack(2);    // [1, 2]
q.pushMiddle(3);  // [1, 3, 2]
q.pushMiddle(4);  // [1, 4, 3, 2]
q.popFront();     // 返回 1 -> [4, 3, 2]
q.popMiddle();    // 返回 3 -> [4, 2]
q.popMiddle();    // 返回 4 -> [2]
q.popBack();      // 返回 2 -> []
q.popFront();     // 返回 -1 -> [] （队列为空）
```

> 提示：
> `1 <= val <= 109`
> 最多调用`1000`次`pushFront`，`pushMiddle`，`pushBack`，`popFront`，`popMiddle`和`popBack`。


## 解题思路

期待你在解此题之前已经完成了 [641_设计循环双端队列](https://juejin.cn/post/7040841285153849357) 和 [622_设计循环队列](https://juejin.cn/post/7040836577735475213)

- `splice`方法的妙用：

    - `arr.splice(index,0,val)`在`index`处插入`val`
    - `arr.splice(index,1)` 删除`index`


## 解题代码


```js
var FrontMiddleBackQueue = function() {
    this.arr = []
};

/** 
 * @param {number} val
 * @return {void}
 */
FrontMiddleBackQueue.prototype.pushFront = function(val) {
    this.arr.splice(0,0,val)
};

/** 
 * @param {number} val
 * @return {void}
 */
FrontMiddleBackQueue.prototype.pushMiddle = function(val) {
    let mid = this.arr.length % 2 ==0? this.arr.length/2: (this.arr.length-1)/2
   this.arr.splice(mid,0,val)
};

/** 
 * @param {number} val
 * @return {void}
 */
FrontMiddleBackQueue.prototype.pushBack = function(val) {
    this.arr.push(val)
};

/**
 * @return {number}
 */
FrontMiddleBackQueue.prototype.popFront = function() {
    if(!this.arr.length) return -1
    let a = this.arr[0]
    this.arr.splice(0,1)
    return a
};

/**
 * @return {number}
 */
FrontMiddleBackQueue.prototype.popMiddle = function() {
    if(!this.arr.length) return -1
    let mid = this.arr.length % 2 ==0? this.arr.length/2 -1: (this.arr.length-1)/2
    let a = this.arr[mid]
    this.arr.splice(mid,1)
    return a
};

/**
 * @return {number}
 */
FrontMiddleBackQueue.prototype.popBack = function() {
    if(!this.arr.length) return -1
    let a = this.arr[this.arr.length-1]
    this.arr.splice(this.arr.length-1,1)
    return a
};

/**
 * Your FrontMiddleBackQueue object will be instantiated and called as such:
 * var obj = new FrontMiddleBackQueue()
 * obj.pushFront(val)
 * obj.pushMiddle(val)
 * obj.pushBack(val)
 * var param_4 = obj.popFront()
 * var param_5 = obj.popMiddle()
 * var param_6 = obj.popBack()
 */
```

如有任何问题或建议，欢迎留言讨论！
