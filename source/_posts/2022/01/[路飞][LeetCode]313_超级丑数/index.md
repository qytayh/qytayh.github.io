---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/super-ugly-number/)

<!-- more -->


## 题目

**超级丑数** 是一个正整数，并满足其所有质因数都出现在质数数组 `primes` 中。

给你一个整数 `n` 和一个整数数组 `primes` ，返回第 `n` 个 **超级丑数** 。

题目数据保证第 `n` 个 **超级丑数** 在 **32-bit** 带符号整数范围内。

**示例 1：**

```
输入： n = 12, primes = [2,7,13,19]
输出： 32 
解释： 给定长度为 4 的质数数组 primes = [2,7,13,19]，前 12 个超级丑数序列为：[1,2,4,7,8,13,14,16,19,26,28,32] 。
```

**示例 2：**

```
输入： n = 1, primes = [2,3,5]
输出： 1
解释： 1 不含质因数，因此它的所有质因数都在质数数组 primes = [2,3,5] 中。
```

**提示：**

-   `1 <= n <= 106`
-   `1 <= primes.length <= 100`
-   `2 <= primes[i] <= 1000`
-   题目数据 **保证** `primes[i]` 是一个质数
-   `primes` 中的所有值都 **互不相同** ，且按 **递增顺序** 排列


## 解题思路

- 本题思路与[丑数II](https://juejin.cn/post/7050861404366209060)核心思想类似
- 我们对`primes`中的所有值都各维护一个指针
- 依次找出对应的最小丑数并进行存储
- 完成`n`次遍历后找出要找的丑数



## 解题代码

```js
var nthSuperUglyNumber = function(n, primes) {
    let points = new Array(primes.length).fill(0)
    let ret =  [1]
    while(ret.length<n){
        let min = primes[0]*ret[points[0]]
        for(let i=0;i<primes.length;i++){
            min = Math.min(min,primes[i]*ret[points[i]])
        }
        for(let i=0;i<primes.length;i++){
            if(min==primes[i]*ret[points[i]]){
                points[i]++
            }
        }
        ret.push(min)
    }
    return ret[ret.length-1]
};
```

如有任何问题或建议，欢迎留言讨论！
