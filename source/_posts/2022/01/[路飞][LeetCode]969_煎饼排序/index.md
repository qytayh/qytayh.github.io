---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/pancake-sorting/)

<!-- more -->


## 题目

给你一个整数数组`arr`，请使用 煎饼翻转 完成对数组的排序。

一次煎饼翻转的执行过程如下：

- 选择一个整数`k`，`1 <= k <= arr.length`
- 反转子数组`arr[0...k-1]`（下标从`0`开始）

例如，`arr = [3,2,1,4]`，选择`k = 3`进行一次煎饼翻转，反转子数组`[3,2,1]`，得到`arr = [1,2,3,4]`。

以数组形式返回能使`arr`有序的煎饼翻转操作所对应的`k`值序列。任何将数组排序且翻转次数在`10 * arr.length`范围内的有效答案都将被判断为正确。

**示例 1：**

```
输入：[3,2,4,1]
输出：[4,2,4,3]
解释：
我们执行 4 次煎饼翻转，k 值分别为 4，2，4，和 3。
初始状态 arr = [3, 2, 4, 1]
第一次翻转后（k = 4）：arr = [1, 4, 2, 3]
第二次翻转后（k = 2）：arr = [4, 1, 2, 3]
第三次翻转后（k = 4）：arr = [3, 2, 1, 4]
第四次翻转后（k = 3）：arr = [1, 2, 3, 4]，此时已完成排序。 
```

**示例 2：**

```
输入： [1,2,3]
输出： []
解释： 输入已经排序，因此不需要翻转任何内容。
请注意，其他可能的答案，如 [3，3] ，也将被判断为正确。
```

> 提示：
> - `1 <= arr.length <= 100`
> - `1 <= arr[i] <= arr.length`
> - `arr` 中的所有整数互不相同（即，`arr` 是从 `1` 到 `arr.length` 整数的一个排列）



## 解题思路

- 先找到最大数的索引`i`，进行翻转，将最大的数放置到数组首部，并记下第一次翻转的`k = i + 1`
- 进行整体数组的翻转，将最大的数放置到数组的尾部，并记下此时的`k`等于数组长度`len`
- 因为最大的数已经完成了翻转，我们下次翻转时不需要考虑尾部
- 将排除后的部分重复上面操作便可完成题解

## 解题代码
```js
var pancakeSort = function(arr) {
    let len = arr.length
    if(!len||len ==1) return arr
    let list = []
    let max = findMaxIndex(arr,len)
    
    while(len){
            if(max<len){
                list.push(max+1)
                for(let i=0,j=max;i<=max;i++){
                    if(i<j){
                    [ arr[i],arr[j]] =[arr[j],arr[i]]
                    }
                    j--
                }
                for(let i=0,j=len-1;i<len;i++){
                    if(i<j){
                    [ arr[i],arr[j]] =[arr[j],arr[i]]
                    }
                    j--
                }
                list.push(len)
            }
            len--
            max = findMaxIndex(arr,len)
    }
    return list
};

var findMaxIndex = function(arr,len){
    let max = 0
    for(let i=0;i<len;i++){
        if(arr[i]>arr[max]){
            max = i
        }
    }
    return max
}
```

如有任何问题或建议，欢迎留言讨论！
