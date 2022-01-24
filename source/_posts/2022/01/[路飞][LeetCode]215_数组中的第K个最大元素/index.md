---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/kth-largest-element-in-an-array/)

<!-- more -->


## 题目
给定整数数组 `nums` 和整数 `k`，请返回数组中第 `k` 个最大的元素。

请注意，你需要找的是数组排序后的第 `k` 个最大的元素，而不是第 `k` 个不同的元素。

**示例 1:**

```
输入: [3,2,1,5,6,4] 和 k = 2
输出: 5
```

**示例 2:**

```
输入: [3,2,3,1,2,4,5,5,6] 和 k = 4
输出: 4
```

**提示：**

-   `1 <= k <= nums.length <= 104`
-   `-104 <= nums[i] <= 104`

## 解题思路

- `sort`解君愁
- 按降序排列
- 第`k`大元素的索引为`k-1`


## 解题代码

```js
var findKthLargest = function(nums, k) {
    return nums.sort((a,b)=>b-a)[k-1]
};
```

如有任何问题或建议，欢迎留言讨论！
