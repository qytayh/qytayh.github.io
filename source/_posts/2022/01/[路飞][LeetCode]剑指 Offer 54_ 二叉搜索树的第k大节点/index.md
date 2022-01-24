---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/er-cha-sou-suo-shu-de-di-kda-jie-dian-lcof/)

<!-- more -->


## 题目

给定一棵二叉搜索树，请找出其中第 `k` 大的节点的值。

**示例 1:**

```
输入: root = [3,1,4,null,2], k = 1
   3
  / \
 1   4
  \
   2
输出: 4
```

**示例 2:**

```
输入: root = [5,3,6,2,4,null,null,1], k = 3
       5
      / \
     3   6
    / \
   2   4
  /
 1
输出: 4
```

**限制：**

-   1 ≤ k ≤ 二叉搜索树元素个数

## 解题思路

做题之前，我们需要对**二叉搜索子树**有一个简单的认知：
- 若它的左子树不空，则左子树上所有结点的值均小于它的根结点的值；
- 若它的右子树不空，则右子树上所有结点的值均大于它的根结点的值；
- 它的左、右子树也分别为二叉排序树

因此我们只需要先进行中序遍历，就可以获得一个升序的数组，然后将倒数第`k`项输出即可



## 解题代码

```js
var kthLargest = function(root, k) {
  let list = nSort(root)
  return list[list.length-k]
};
var arr = []
var nSort = function(root){
  if(!root) return
  nSort(root.left)
  arr.push(root.val)
  nSort(root.right)
  return arr
}
```

当前后左右都没有路时，命运一定是鼓励你向上飞了

如有任何问题或建议，欢迎留言讨论！
