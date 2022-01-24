---
theme: condensed-night-purple
---

「这是我参与2022首次更文挑战的第5天，活动详情查看：[2022首次更文挑战](https://juejin.cn/post/7052884569032392740 "https://juejin.cn/post/7052884569032392740")」

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/sort-characters-by-frequency/)

<!-- more -->


## 题目

给定一个字符串，请将字符串里的字符按照出现的频率降序排列。

**示例 1:**

```
输入:
"tree"

输出:
"eert"

解释: 'e'出现两次，'r'和't'都只出现一次。
因此'e'必须出现在'r'和't'之前。此外，"eetr"也是一个有效的答案。
```

**示例 2:**

```
输入:
"cccaaa"

输出:
"cccaaa"

解释: 'c'和'a'都出现三次。此外，"aaaccc"也是有效的答案。
注意"cacaca"是不正确的，因为相同的字母必须放在一起。
```

**示例 3:**

```
输入:
"Aabb"

输出:
"bbAa"

解释: 此外，"bbaA"也是一个有效的答案，但"Aabb"是不正确的。
注意'A'和'a'被认为是两种不同的字符。
```

## 解题思路

- 我们使用`map`来存储所有的字符
- 如果该字符出现过，就将该字符出现的次数`+1`
- 否则，设置该字符出现的次数为`1`
- 将`map`转为`Array`类型进行排序(转换后每一项都是数组，第一个元素为字符第二个为出现的次数)
- 使用进行数组降序排序
- 拼接字符串，输出结果


## 解题代码

```js
var frequencySort = function(s) {
    let map = new Map()
    let res = ''
    for(let z of s){
        map.set(z,(map.get(z)||0)+1)
    }
    const arr = [...map].sort((a, b) => b[1] - a[1])
    for(let [k,v] of arr){
        res += k.repeat(v)
    }
    return res
};
```

## 使用大顶堆

- 我们之前用`map`来存储的操作都与上方一致
- 排序使用大顶堆来完成
- 将`map`中的内容存入大顶堆后将大顶堆转化成数组(此时的数组已经是排好序的了)
- 遍历数组的内容，拿到字符串以及出现的次数
- 拼接字符串，输出结果



```js
var frequencySort = function(s) {
    let map = new Map()
    let res = ''
    for(let z of s){
        map.set(z,(map.get(z)||0)+1)
    }
    const maxQueue = new MaxPriorityQueue()
    map.forEach((val,key)=>{
        maxQueue.enqueue(key,val)
    })
    maxQueue.toArray().forEach(v=> res+= v.element.repeat(v.priority))
    return res
};
```


如有任何问题或建议，欢迎留言讨论！
