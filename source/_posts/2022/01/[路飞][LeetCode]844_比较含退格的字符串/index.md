---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/backspace-string-compare/)

<!-- more -->


## 题目

给定`s`和`t`两个字符串，当它们分别被输入到空白的文本编辑器后，请你判断二者是否相等。`#`代表退格字符。

如果相等，返回`true`；否则，返回`false`。

注意：如果对空文本输入退格字符，文本继续为空。

**示例 1：**

```
输入： s = "ab#c", t = "ad#c"
输出： true
解释： S 和 T 都会变成 “ac”。
```

**示例 2：**

```
输入： s = "ab##", t = "c#d#"
输出： true
解释： s 和 t 都会变成 “”。
```

**示例 3：**

```
输入： s = "a##c", t = "#a#c"
输出： true
解释： s 和 t 都会变成 “c”。
```

**示例 4：**

```
输入： s = "a#c", t = "b"
输出： false
解释： s 会变成 “c”，但 t 仍然是 “b”。
```

> 提示：
> - `1 <= s.length, t.length <= 200`
> - `s` 和 `t` 只含有小写字母以及字符 `'#'`


## 解题思路

- 我们先将两个字符串进行退格处理
- 遍历字符串，如果遇到`#`则将新字符串末尾的去掉，否则将遍历项加到新字符串末尾
- 比较处理后的字符串

## 解题代码

```js
var backspaceCompare = function(s, t) {
    s = transform(s)
    t = transform(t)
    return s==t
};

var transform = function(str){
    let newstr = ''
    for(let i in str){
        if(str[i]=='#'){
           newstr = newstr.slice(0,newstr.length-1)
        }else{
            newstr = newstr + str[i]
        }
    }
    return newstr
}
```

如有任何问题或建议，欢迎留言讨论！