---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/top-k-frequent-words/)

<!-- more -->


## 题目

给一非空的单词列表，返回前 *k* 个出现次数最多的单词。

返回的答案应该按单词出现频率由高到低排序。如果不同的单词有相同出现频率，按字母顺序排序。

**示例 1：**

```
输入: ["i", "love", "leetcode", "i", "love", "coding"], k = 2
输出: ["i", "love"]
解析: "i" 和 "love" 为出现次数最多的两个单词，均为2次。
注意，按字母顺序 "i" 在 "love" 之前。
```

**示例 2：**

```
输入: ["the", "day", "is", "sunny", "the", "the", "the", "sunny", "is", "is"], k = 4
输出: ["the", "is", "sunny", "day"]
解析: "the", "is", "sunny" 和 "day" 是出现次数最多的四个单词，
出现次数依次为 4, 3, 2 和 1 次。
```

**注意：**

1.  假定 *k* 总为有效值， 1 ≤ *k* ≤ 集合元素数。
1.  输入的单词均由小写字母组成。

## 解题思路

- 我们先分别统计每个单词出现的次数
- 对单词出现的次数进行排序
- 输出前`k`个

## 解题代码

```js
var topKFrequent = function(words, k) {
    let map = {}
    words.forEach(v=>map[v]?map[v]++:map[v]=1)
    const keys = Object.keys(map).sort((a,b)=>map[b]-map[a]||a.localeCompare(b))
    return keys.slice(0,k)
};
```

如有任何问题或建议，欢迎留言讨论！
