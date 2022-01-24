---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/basic-calculator-ii/)

<!-- more -->


## 题目

给你一个字符串表达式 `s` ，请你实现一个基本计算器来计算并返回它的值。

整数除法仅保留整数部分。

**示例 1：**

```
输入： s = "3+2*2"
输出： 7
```

**示例 2：**

```
输入： s = " 3/2 "
输出： 1
```

**示例 3：**

```
输入： s = " 3+5 / 2 "
输出： 5
```

> 提示：
> - `1 <= s.length <= 3 * 105`
> - `s` 由整数和算符 `('+', '-', '*', '/')` 组成，中间由一些空格隔开
> - `s` 表示一个 **有效表达式**
> - 表达式中的所有整数都是非负整数，且在范围 `[0, 231 - 1]` 内
> - 题目数据保证答案是一个 **32-bit 整数**


## 解题思路

- 我们将所有的数以及运算符先找出来
- 用`m`标记当前的运算符
- `last`记录上次操作的数(例如`1+2` 我们就记录`2`)
- 对每种运算符进行对应操作

**温馨提示**

- 我在实现中对减法使用了加负数的方式，方便回溯
- 遇到乘法或者除法要对上次的加减法回溯时，我们有 `sum-last+last本次的乘除操作`


## 解题代码

```js
var calculate = function(s) {
    s = s.replace(/\s*/g,"");
    let num = s.split(/[^0-9]/)
    if(num.length==1) return num[0] 
    let ml = s.replace(/[0-9]+/g,"").split('');
    let sum = 0
    let m = '+'
    let last = 0
    for(let i =0;i<=ml.length;i++){
            if(m=='+'){
                sum += parseInt(num[i])
                last = parseInt(num[i])
            }else if(m=='-'){
                sum -= parseInt(num[i])
                last = -parseInt(num[i])
            }else if(m=='*'){
                sum  = sum - last + parseInt(num[i]) * last;
                last =  parseInt(num[i]) * last
            }else{
                sum  = sum - last + parseInt(last/parseInt(num[i]));
                last =  parseInt(last/parseInt(num[i]))
            }
            m = ml[i]
    }
    return sum
};
```

如有任何问题或建议，欢迎留言讨论！
