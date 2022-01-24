---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/validate-stack-sequences/)

<!-- more -->


## 题目

给定`pushed`和`popped`两个序列，每个序列中的值都不重复，只有当它们可能是在最初空栈上进行的推入`push`和弹出`pop`操作序列的结果时，返回`true`；否则，返回`false`。

**示例 1：**

```
输入：pushed = [1,2,3,4,5], popped = [4,5,3,2,1]
输出：true
解释：我们可以按以下顺序执行：
push(1), push(2), push(3), push(4), pop() -> 4,
push(5), pop() -> 5, pop() -> 3, pop() -> 2, pop() -> 1
```

**示例 2：**

```
输入： pushed = [1,2,3,4,5], popped = [4,3,5,1,2]
输出： false
解释： 1 不能在 2 之前弹出。
```

> 提示：
> - `1 <= pushed.length <= 1000`
> - `0 <= pushed[i] <= 1000`
> - `pushed`的所有元素 互不相同
> - `popped.length == pushed.length`
> - `popped`是`pushed`的一个排列

## 解题思路

- 首先我们需要理解**栈**的特点：**先进后出，后进先出**
- 遍历`pushed`数组，将遍历的项插入到新数组中
- 定义一个指针用于记录与`popped`比较到了什么位置
- 如果遍历过程中有遍历的项与`popped`的上述指针所在项相同，移除新数组尾项
- 将新数组从后往前与`popped`从指针所在位置往后进行比较
- 直到两个数组出现不同的项再去重复上面两步
- 如果新数组正好长度为`0`则说明满足题意

## 解题代码

```js
var validateStackSequences = function(pushed, popped) {
    let arr = []
    let popindex = 0
    for(let i =0;i<pushed.length;i++){
        arr.push(pushed[i])
        while(popindex<popped.length&&arr[arr.length-1]==popped[popindex]){
            arr.pop()
            popindex++
        }
    }
    return arr.length==0
};
```
如有任何问题或建议，欢迎留言讨论！
