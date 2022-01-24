---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/valid-parentheses/)


<!-- more -->

## 题目

给定一个只包括 `'('`，`')'`，`'{'`，`'}'`，`'['`，`']'` 的字符串`s`，判断字符串是否有效。

有效字符串需满足：

- 左括号必须用相同类型的右括号闭合。
- 左括号必须以正确的顺序闭合。

**示例 1：**

```
输入： s = "()"
输出： true
```

**示例 2：**

```
输入： s = "()[]{}"
输出： true
```

**示例 3：**

```
输入： s = "(]"
输出： false
```

**示例 4：**

```
输入： s = "([)]"
输出： false
```

**示例 5：**

```
输入： s = "{[]}"
输出： true
```

> 提示：
> - `1 <= s.length <= 104`
> - `s` 仅由括号 `'()[]{}'` 组成


## 解题思路

- 我们用**栈**的思想，当出现`)`,`]`,`}`时，前一位一定会有与之对应的`(`,`[`,`{`才能满足题意
- 排除几个边界条件
    - 以`)`,`]`,`}`开头
    - 从未出现过`)`,`]`,`}`
    - `s`长度为`1`


## 解题代码

```js
var isValid = function(s) {
    if(s.startsWith(')')||s.startsWith(']')||s.startsWith('}')||s.length<=1) return false
    if(!s.includes(')')&&!s.includes(']')&&!s.includes('}')) return false
    let arr = []
    for(let i in s){
        if(['(','[','{'].includes(s[i])){
            arr.push(s[i])
        }else{
            let a = arr[arr.length-1]+s[i]
            if(!['()','[]','{}'].includes(a)) return false
            arr.splice(arr.length-1,1)
        }
    }
    return arr.length==0
};
```

如有任何问题或建议，欢迎留言讨论！