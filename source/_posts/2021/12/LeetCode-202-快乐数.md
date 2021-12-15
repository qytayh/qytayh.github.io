---
title: 'LeetCode_202-快乐数'
date: 2021-12-06 09:35:04
tags:
    - 算法
    - LeetCode
categories:
    - 算法
    - LeetCode
description:
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~


[题目地址](https://leetcode-cn.com/problems/happy-number/)

<!-- more -->

## 题目
编写一个算法来判断一个数 n 是不是快乐数。

快乐数」定义为：

对于一个正整数，每一次将该数替换为它每个位置上的数字的平方和。
然后重复这个过程直到这个数变为 1，也可能是 无限循环 但始终变不到 1。
如果 可以变为  1，那么这个数就是快乐数。
如果 n 是快乐数就返回 true ；不是，则返回 false 。

## 示例

```
示例一
输入： n = 19
输出： true
解释： 12 + 92 = 82
82 + 22 = 68
62 + 82 = 100
12 + 02 + 02 = 1
```

 ```
示例二
输入： n = 2
输出： false
```

> 提示： `1 <= n <= 231 - 1`

## 解题思路

从题目中我们可以得出：

- 给定范围内的数一定是或者不是快乐数
- 快乐数最终会等于1
- 不快乐则会无限循环(爱滴魔力转圈圈~~~)

所以我们的解法思路大概为：`通过循环看看这个数是会变为1还是进入死循环，变为1则快乐，死循环则不快乐`

## 解题代码

```js
var isHappy = function(n) {
    let nArr = [] // 建立一个用于存放数字的平方和的数组
    while(!nArr.includes(n)){ // 如果数组中出现过了算出的平方和 则说明进入循环 跳出
        const sum = getSum(n)
        nArr.push(n)
        n = sum
    }
   return n ==1
};
var getSum = function (n){
    let sum = 0
    while(n){
        sum += (n%10)*(n%10)
        n = Math.floor(n/10)
    }
    return sum
}
```

## 通过换下链表的方式解题

```js
var isHappy = function(n) {
    if(!n) return false
    let slow = n
    let fast = next(n)
    while(slow!=fast){
        slow = next(slow)
        fast = next(next(fast))
    }
    return fast==1
};
var next = function (n){
    let sum = 0
    while(n){
        sum += (n%10)*(n%10)
        n = Math.floor(n/10)
    }
    return sum
}
```

如有任何问题或建议，欢迎留言讨论！

<!-- markdownlint-disable MD041 MD002--> 
