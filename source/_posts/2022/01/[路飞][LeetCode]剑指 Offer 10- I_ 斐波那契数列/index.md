---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/fei-bo-na-qi-shu-lie-lcof/)

<!-- more -->


## 题目

写一个函数，输入 `n` ，求斐波那契（Fibonacci）数列的第 `n` 项（即 `F(N)`）。斐波那契数列的定义如下：

```
F(0) = 0,   F(1) = 1
F(N) = F(N - 1) + F(N - 2), 其中 N > 1.
```

斐波那契数列由 0 和 1 开始，之后的斐波那契数就是由之前的两数相加而得出。

答案需要取模 1e9+7（1000000007），如计算初始结果为：1000000008，请返回 1。

**示例 1：**

```
输入： n = 2
输出： 1
```

**示例 2：**

```
输入： n = 5
输出： 5
```

**提示：**

-   `0 <= n <= 100`

## 解题思路

- 本题的重点在于进行`n-1`次`F(N) = F(N - 1) + F(N - 2)`操作

## 解题代码

**方便理解版**

```js
var fib = function(n) {
  let a = 0
  let b = 1
  let sum = 0
  while (n>=1){
      sum = (a + b)%1000000007
      a =b
      b = sum
      n--
  }
  return  a
};
```

**尾递归版**

```js
var fib = function(n) {
  return fibFun(0,1,n)
};

var fibFun = function(a,b,n){
  if (n==0) return a
  return fibFun(b,(a+b)%1000000007,n-1)
}
```

如有任何问题或建议，欢迎留言讨论！
