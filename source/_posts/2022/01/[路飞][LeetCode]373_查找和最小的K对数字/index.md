---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/find-k-pairs-with-smallest-sums/)

<!-- more -->


## 题目

给定两个以升序排列的整数数组 `nums1` 和 ****`nums2` ****, 以及一个整数 `k` ****。

定义一对值 `(u,v)`，其中第一个元素来自 `nums1`，第二个元素来自 `nums2` ****。

请找到和最小的 `k` 个数对 `(u1,v1)`, `  (u2,v2) ` ... `(uk,vk)` 。

**示例 1:**

```
输入: nums1 = [1,7,11], nums2 = [2,4,6], k = 3
输出: [1,2],[1,4],[1,6]
解释: 返回序列中的前 3 对数：
     [1,2],[1,4],[1,6],[7,2],[7,4],[11,2],[7,6],[11,4],[11,6]
```

**示例 2:**

```
输入: nums1 = [1,1,2], nums2 = [1,2,3], k = 2
输出: [1,1],[1,1]
解释: 返回序列中的前 2 对数：
     [1,1],[1,1],[1,2],[2,1],[1,2],[2,2],[1,3],[1,3],[2,3]
```

**示例 3:**

```
输入: nums1 = [1,2], nums2 = [3], k = 3 
输出: [1,3],[2,3]
解释: 也可能序列中所有的数对都被返回:[1,3],[2,3]
```

**提示:**

-   `1 <= nums1.length, nums2.length <= 104`
-   `-109 <= nums1[i], nums2[i] <= 109`
-   `nums1`, `nums2` 均为升序排列
-   `1 <= k <= 1000`

## 解题思路

- 暴力解yyds
- 因为我们只要返回`k`对,因此先对两个数组的长度进行截取
- 舍掉超出`k`的部分

## 解题代码

```js
var kSmallestPairs = function(nums1, nums2, k) {
    const arr = []
    if(nums1.length>k) nums1.length=k
    if(nums2.length>k) nums2.length=k
    for(let i=0;i<nums1.length;i++){
        for(let j=0;j<nums2.length;j++){
            arr.push([nums1[i],nums2[j]])
        }
    }
    return arr.sort((a,b)=>a[0]+a[1]-b[0]-b[1]).slice(0,k)
};
```
如有任何问题或建议，欢迎留言讨论！