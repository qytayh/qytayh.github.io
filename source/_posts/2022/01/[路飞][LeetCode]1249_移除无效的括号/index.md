---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/minimum-remove-to-make-valid-parentheses/)

<!-- more -->


## 题目

给你一个由 `'('`、`')'` 和小写字母组成的字符串 `s`。

你需要从字符串中删除最少数目的 `'('` 或者 `')'` （可以删除任意位置的括号)，使得剩下的「括号字符串」有效。

请返回任意一个合法字符串。

有效「括号字符串」应当符合以下 **任意一条** 要求：

-   空字符串或只包含小写字母的字符串
-   可以被写作 `AB`（`A` 连接 `B`）的字符串，其中 `A` 和 `B` 都是有效「括号字符串」
-   可以被写作 `(A)` 的字符串，其中 `A` 是一个有效的「括号字符串」

**示例 1：**

```
输入：s = "lee(t(c)o)de)"
输出："lee(t(c)o)de"
解释："lee(t(co)de)" , "lee(t(c)ode)" 也是一个可行答案。
```

**示例 2：**

```
输入： s = "a)b(c)d"
输出： "ab(c)d"
```

**示例 3：**

```
输入： s = "))(("
输出： ""
解释： 空字符串也是有效的
```

**示例 4：**

```
输入： s = "(a(b(c)d)"
输出： "a(b(c)d)"
```

> 提示：
> - `1 <= s.length <= 10^5`
> - `s[i]` 可能是 `'('`、`')'` 或英文小写字母


## 解题思路

- 继续沿用`栈` 的思想
- 我们定一个`2`个数组用来存放出现的括号的索引
- 出现`(`就往存左括号的数组里`push`
- 出现`)`时，如左括号数组里有，则左括号数组进行`pop`，否则右括号数组进行`push`
- 合并两个数组，里面所有的元素为要排除的括号的索引

## 解题代码

```js
var minRemoveToMakeValid = function(s) {
    let strArr = s.split('')
    let left = []
    let right = []
    for(let i in s){
        if(s[i]=='(') left.push(parseInt(i))
        if(s[i]==')'){
            if(left.length) {
                left.pop()
            }else{
                right.push(parseInt(i))
            }
        }

    }
    let arr = [...left,...right]
    let str = ''
    strArr.forEach((v,i)=>{
        if(!arr.includes(i)){
            str+=v
        }
    })
    return str
};
```

如有任何问题或建议，欢迎留言讨论！