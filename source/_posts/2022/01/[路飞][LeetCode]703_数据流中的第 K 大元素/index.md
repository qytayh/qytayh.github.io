---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/kth-largest-element-in-a-stream/)

<!-- more -->


## 题目

设计一个找到数据流中第 `k` 大元素的类（class）。注意是排序后的第 `k` 大元素，不是第 `k` 个不同的元素。

请实现 `KthLargest` 类：

-   `KthLargest(int k, int[] nums)` 使用整数 `k` 和整数流 `nums` 初始化对象。
-   `int add(int val)` 将 `val` 插入数据流 `nums` 后，返回当前数据流中第 `k` 大的元素。

**示例：**

```
输入：
["KthLargest", "add", "add", "add", "add", "add"]
[[3, [4, 5, 8, 2]], [3], [5], [10], [9], [4]]
输出：
[null, 4, 5, 5, 8, 8]

解释：
KthLargest kthLargest = new KthLargest(3, [4, 5, 8, 2]);
kthLargest.add(3);   // return 4
kthLargest.add(5);   // return 5
kthLargest.add(10);  // return 5
kthLargest.add(9);   // return 8
kthLargest.add(4);   // return 8
```

**提示：**

-   `1 <= k <= 104`
-   `0 <= nums.length <= 104`
-   `-104 <= nums[i] <= 104`
-   `-104 <= val <= 104`
-   最多调用 `add` 方法 `104` 次
-   题目数据保证，在查找第 `k` 大元素时，数组中至少有 `k` 个元素

## 解题思路

- 我们记录每次要返回的第`k`大元素
- 先将`nums`进行排序，截取`k`个大元素
- 在`add`时先`push`操作
- 然后重新快排，返回第`k`项

## 解题代码

```js
/**
 * @param {number} k
 * @param {number[]} nums
 */
var KthLargest = function(k, nums) {
    this.l = k
    nums.sort((a,b)=>b-a)
    nums.length = k
    this.arr = nums
};

/** 
 * @param {number} val
 * @return {number}
 */
KthLargest.prototype.add = function(val) {
    this.arr.push(val)
    this.arr.sort((a,b)=>b-a)
    this.arr.length = this.l
    return this.arr[this.l-1]
};
```

如有任何问题或建议，欢迎留言讨论！

