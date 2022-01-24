---
theme: condensed-night-purple
---

「这是我参与2022首次更文挑战的第2天，活动详情查看：[2022首次更文挑战](https://juejin.cn/post/7052884569032392740 "https://juejin.cn/post/7052884569032392740")」

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/top-k-frequent-elements/)

<!-- more -->


## 题目

给你一个整数数组 `nums` 和一个整数 `k` ，请你返回其中出现频率前 `k` 高的元素。你可以按 **任意顺序** 返回答案。

**示例 1:**

```
输入: nums = [1,1,1,2,2,3], k = 2
输出: [1,2]
```

**示例 2:**

```
输入: nums = [1], k = 1
输出: [1]
```

**提示：**

-   `1 <= nums.length <= 105`
-   `k` 的取值范围是 `[1, 数组中不相同的元素的个数]`
-   题目数据保证答案唯一，换句话说，数组中前 `k` 个高频元素的集合是唯一的

## 解题思路

不管看到啥题目，不要慌，我们先想想暴力解如何解

- 我们用`map`来记录每个元素出现的次数
- 将`map`转成数组
- 进行降序排序
- 截取数组的前`k`个项
- 提取元素

## 解题代码

```js
var topKFrequent = function(nums, k) {
  const map  = new Map()
  for(let k of nums){
    map.set(k,map.has(k)?map.get(k)+1:1)
  }
  const arr = [...map]
  return arr.sort((a,b)=>b[1]-a[1]).slice(0,k).map(v=>v[0])
};
```

## 使用小顶堆

先简单的介绍一下堆，**堆就是利用完全二叉树的结构来维护的一维数组**。

堆可以分为大顶堆和小顶堆。

**大顶堆**：每个结点的值都大于或等于其左右子结点的值。

**小顶堆**：每个结点的值都小于或等于其左右子结点的值。

如果是排序，**求升序**用大顶堆，**求降序**用小顶堆。

一般我们说 `topK` 问题，就可以用大顶堆或小顶堆来实现，

- **最大的 K 个**：小顶堆
- **最小的 K 个**：大顶堆

在这题中，我们要求的是前`k`个高频，符合小顶堆的条件

- 第一步我们还是用`map`来记录每个元素出现的次数
- 如果`map`的长度不够`k`个就直接返回所有的元素
- 否则我们遍历`map`，对小顶堆的长度不够`k`个时向里面添加数组
- 当小顶堆的长度达到`k`个后，我们需要毕竟堆顶的(相对低频)元素的次数是否大于当前遍历到的元素
- 如果小于当前遍历到的元素的次数，则将堆顶的元素推出，将当前元素入堆
- 遍历完成后返回所有的元素

```js
var topKFrequent = function(nums, k) {
  const map  = new Map()
  for(let k of nums){
    map.set(k,map.has(k)?map.get(k)+1:1)
  }
  if(map.size<=k) return [...map.keys()]
  const minQueue = new MinPriorityQueue()
  map.forEach((val,key)=>{
    if(minQueue.size()<k){
      minQueue.enqueue(key,val)
    }else{
      if(minQueue.front().priority<val){
        minQueue.dequeue()
        minQueue.enqueue(key,val)
      }
    }
  })
 return minQueue.toArray().map(v=> v.element)
};
```

如有任何问题或建议，欢迎留言讨论！
