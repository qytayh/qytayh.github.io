---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/binary-tree-level-order-traversal-ii/)


<!-- more -->

## 题目

给定一个二叉树，返回其节点值自底向上的层序遍历。 （即按从叶子节点所在层到根节点所在的层，逐层从左向右遍历）

例如：

给定二叉树 `[3,9,20,null,null,15,7]`,

```
    3
   / \
  9  20
    /  \
   15   7
```

返回其自底向上的层序遍历为：

```
[
  [15,7],
  [9,20],
  [3]
]
```

## 解题思路

- 本题与 [剑指 Offer 32 - II. 从上到下打印二叉树 II](https://juejin.cn/post/7048239759767896094) 几乎一样
- 我们采用前序遍历
- 在二叉树的每一层构建一个数组
- 利用前序遍历的特点依次将节点`push`到这一层的数组中
- 最后我们通过`reverse()`将结果反转输出


## 解题代码

```js
var levelOrderBottom = function(root) {
    let arr = []
    function pmap(node,i){
        if(!node) return
        if(!arr[i]) arr[i] = []
        arr[i].push(node.val)
        if(node.left) pmap(node.left,i+1)
        if(node.right) pmap(node.right,i+1)
    }
    pmap(root,0)
    return arr.reverse()
};
```

当你快乐时，你要想，这快乐不是永恒的；当你痛苦时，你要想，这痛苦也不是永恒的。

如有任何问题或建议，欢迎留言讨论！