---
theme: condensed-night-purple
---

「这是我参与2022首次更文挑战的第4天，活动详情查看：[2022首次更文挑战](https://juejin.cn/post/7052884569032392740 "https://juejin.cn/post/7052884569032392740")」

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/k-closest-points-to-origin/)

<!-- more -->


## 题目

我们有一个由平面上的点组成的列表 `points`。需要从中找出 `K` 个距离原点 `(0, 0)` 最近的点。

（这里，平面上两点之间的距离是欧几里德距离。）

你可以按任何顺序返回答案。除了点坐标的顺序之外，答案确保是唯一的。

**示例 1：**

```
输入： points = [[1,3],[-2,2]], K = 1
输出： [[-2,2]]
解释：
(1, 3) 和原点之间的距离为 sqrt(10)，
(-2, 2) 和原点之间的距离为 sqrt(8)，
由于 sqrt(8) < sqrt(10)，(-2, 2) 离原点更近。
我们只需要距离原点最近的 K = 1 个点，所以答案就是 [[-2,2]]。
```

**示例 2：**

```
输入： points = [[3,3],[5,-1],[-2,4]], K = 2
输出： [[3,3],[-2,4]]
（答案 [[-2,4],[3,3]] 也会被接受。）
```

**提示：**

1.  `1 <= K <= points.length <= 10000`
1.  `-10000 < points[i][0] < 10000`
1.  `-10000 < points[i][1] < 10000`

## 解题思路

话不多说，老规矩，先暴力解安排上。

- 算距离为横坐标的平方+ 纵坐标的平方的和开根号
- 因为我们要求的是最近的点，所以开根号的步骤可以省略掉
- 用`map`来存点以及'距离'
- 将`map`转成数组，并按升序排列
- 截取数组的前`k`个就是要找的点


## 解题代码

```js
var kClosest = function(points, k) {
  const map  = new Map()
  for(let i of points){
      map.set(i,Math.pow(i[0],2)+Math.pow(i[1],2))
  }
  const arr = [...map]
  return arr.sort((a,b)=>a[1]-b[1]).slice(0,k).map(v=>v[0])
};
```

## 大根堆

**大顶堆**：每个结点的值都大于或等于其左右子结点的值。

如果是排序，**求升序**用大顶堆，**求降序**用小顶堆。

本题要求的是最接近的也就是最小的`k`个，符合大顶堆。

```js
var kClosest = function(points, k) {
    const map  = new Map()
    for(let i of points){
       map.set(i,Math.pow(i[0],2)+Math.pow(i[1],2))
    }
    if(map.size<=k) return [...map.keys()]
    const maxQueue = new MaxPriorityQueue({ priority: (bid) => bid.value })
    map.forEach((value,key)=>{
        if(maxQueue.size()<k){
            maxQueue.enqueue(key,value)
        }else{
            if(maxQueue.front().priority>value){
                maxQueue.dequeue()
                maxQueue.enqueue(key,value)
            }
        }
    })
    return maxQueue.toArray().map(v=> v.element)
};
```



如有任何问题或建议，欢迎留言讨论！

