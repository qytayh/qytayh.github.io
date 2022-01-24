---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/continuous-median-lcci/)

<!-- more -->


## 题目

随机产生数字并传递给一个方法。你能否完成这个方法，在每次产生新值时，寻找当前所有值的中间值（中位数）并保存。

中位数是有序列表中间的数。如果列表长度是偶数，中位数则是中间两个数的平均值。

例如，

[2,3,4] 的中位数是 3

[2,3] 的中位数是 (2 + 3) / 2 = 2.5

设计一个支持以下两种操作的数据结构：

-   void addNum(int num) - 从数据流中添加一个整数到数据结构中。
-   double findMedian() - 返回目前所有元素的中位数。

**示例：**

```
addNum(1)
addNum(2)
findMedian() -> 1.5
addNum(3) 
findMedian() -> 2
```

## 解题思路

- 我们在往数组中添加值的时候需要按序添加
- 输出中位数时对数组长度为奇数或偶数分情况处理


## 解题代码

```js
/**
 * initialize your data structure here.
 */
var MedianFinder = function() {
    this.arr = []
};

/** 
 * @param {number} num
 * @return {void}
 */
MedianFinder.prototype.addNum = function(num) {
    let i = this.arr.findIndex(v=>v>num)
    if(i==-1){
        this.arr.push(num)
    }else if(i==0){
         this.arr.unshift(num)
    }
    else{
        this.arr.splice(i,0,num)
    }
};

/**
 * @return {number}
 */
MedianFinder.prototype.findMedian = function() {
    if(this.arr.length%2){
        return this.arr[(this.arr.length-1)/2]
    }else{
        return (this.arr[(this.arr.length/2)-1]+this.arr[this.arr.length/2])/2
    }
};
```

如有任何问题或建议，欢迎留言讨论！

