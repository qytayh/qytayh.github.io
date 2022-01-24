---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/longest-well-performing-interval/)

<!-- more -->


## 题目

给你一份工作时间表 `hours`，上面记录着某一位员工每天的工作小时数。

我们认为当员工一天中的工作小时数大于 `8` 小时的时候，那么这一天就是「**劳累的一天**」。

所谓「表现良好的时间段」，意味在这段时间内，「劳累的天数」是严格 **大于**「不劳累的天数」。

请你返回「表现良好时间段」的最大长度。

**示例 1：**

```
输入： hours = [9,9,6,0,6,6,9]
输出： 3
解释： 最长的表现良好时间段是 [9,9,6]。
```

**示例 2：**

```
输入： hours = [6,6,6]
输出： 0
```

> 提示：
> - `1 <= hours.length <= 104`
> - `0 <= hours[i] <= 16`

## 解题思路

- 我们使用 **前缀和** 来解题(可能有小伙伴要问了，这个前缀和是啥，顾名思义，钱💰坠落到河里就是前缀和 *认真脸*)
- 回归正题，这个前缀和就是数组前 `n`项的和
- 我们先将输入的数组调整一下，大于`8`的转换成`1`否则为`-1`
- 计算转换后的数组的前缀和数组
- 前缀和数组中两项的差为，转换后数组对应位置两项极其之间数据的和
- 表现良好的时间段为和大于`1`的时间段
- 题目要的正是两项极其之间数据的和大于`1`的最大距离

## 解题代码

```js
var longestWPI = function(hours) {
    hours = hours.map(v=>{
        return v>8?1:-1
    })
    if(!hours.includes(1)) return 0
    let pre_sums = [0]
    for(let i=0;i<hours.length;i++){
        const a = hours[i]
        const b = pre_sums[i]==undefined?0:pre_sums[i]
        pre_sums[i+1] = a+b
    }
    let len =0
    for(let i =0;i<pre_sums.length-1;i++){
        for(let j=i+1;j<pre_sums.length;j++){
            if(pre_sums[j]-pre_sums[i]>0){
                len = Math.max(len,j-i)
            }
        }
    }
    return len
};
```

如有任何问题或建议，欢迎留言讨论！
