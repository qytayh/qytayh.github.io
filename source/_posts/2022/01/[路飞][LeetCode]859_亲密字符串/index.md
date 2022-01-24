---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/buddy-strings/)

<!-- more -->


## 题目

给你两个字符串`s`和`goal`，只要我们可以通过交换`s`中的两个字母得到与`goal`相等的结果，就返回`true`；否则返回`false`。

交换字母的定义是：取两个下标`i`和`j`（下标从`0`开始）且满足`i!=j`，接着交换`s[i]`和`s[j]`处的字符。

- 例如，在`abcd`中交换下标`0`和下标`2`的元素可以生成`cbad`。

**示例 1：**

```
输入：s = "ab", goal = "ba"
输出：true
解释：你可以交换 s[0] = 'a' 和 s[1] = 'b' 生成 "ba"，此时 s 和 goal 相等。
```

**示例 2：**

```
输入：s = "ab", goal = "ab"
输出：false
解释：你只能交换 s[0] = 'a' 和 s[1] = 'b' 生成 "ba"，此时 s 和 goal 不相等。
```

**示例 3：**

```
输入：s = "aa", goal = "aa"
输出：true
解释：你可以交换 s[0] = 'a' 和 s[1] = 'a' 生成 "aa"，此时 s 和 goal 相等。
```

**示例 4：**

```
输入：s = "aaaaaaabc", goal = "aaaaaaacb"
输出：true
```

> 提示：
> - `1 <= s.length, goal.length <= 2 * 104`
> - `s`和`goal`由小写英文字母组成

## 解题思路

- 如果`s`和`goal`长度不同或`s`的长度只有`1`，都为`false`
- 如果`s===goal`，那么`s`中有重复元素才能满足题意
- 如果`s!=goal`，则`s`和`goal`只能有2个不同的元素，并且需要满足元素交换位置后相同

> 这亲密字符串一点也不亲密👀 哈哈~😆

## 解题代码

```js
var buddyStrings = function(s, goal) {
    if(s.length!=goal.length||s.length==1) return false
    if(s==goal){
        let arr = s.split('')
        arr = Array.from(new Set(arr))
        return s.length!= arr.length
    }
    let flag = false
    let arr = []
    for(let i in s){
        if(s[i]!=goal[i]) arr.push(i) 
    }
    if(arr.length!=2) return false
    let [a,b]= arr
    return s[a]==goal[b]&&s[b]==goal[a]
};
```
如有任何问题或建议，欢迎留言讨论！
