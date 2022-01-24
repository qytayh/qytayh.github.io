---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/zui-xiao-de-kge-shu-lcof/)

<!-- more -->


## 题目

输入整数数组 `arr` ，找出其中最小的 `k` 个数。例如，输入4、5、1、6、2、7、3、8这8个数字，则最小的4个数字是1、2、3、4。

**示例 1：**

```
输入： arr = [3,2,1], k = 2
输出： [1,2] 或者 [2,1]
```

**示例 2：**

```
输入： arr = [0,1,2,1], k = 1
输出： [0]
```

**限制：**

-   `0 <= k <= arr.length <= 10000`
-   `0 <= arr[i] <= 10000`


## 解题思路

- 拿到手一看 这不送分题么
- 看我`sort`快排解君愁

## 解题代码

```js
var getLeastNumbers = function(arr, k) {
    return arr.sort((a, b) => a - b).slice(0, k);
};
```

如有任何问题或建议，欢迎留言讨论！







