---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/binary-tree-zigzag-level-order-traversal/)


<!-- more -->

## 题目

给定一个二叉树，返回其节点值的锯齿形层序遍历。（即先从左往右，再从右往左进行下一层遍历，以此类推，层与层之间交替进行）。

例如：

给定二叉树 `[3,9,20,null,null,15,7]`,

```
    3
   / \
  9  20
    /  \
   15   7
```

返回锯齿形层序遍历如下：

```
[
  [3],
  [20,9],
  [15,7]
]
```

## 解题思路

- 相信看过[剑指 Offer 32 - II. 从上到下打印二叉树 II](https://juejin.cn/post/7048239759767896094)和[107_二叉树的层序遍历 II](https://juejin.cn/post/7048252673753088031)的小伙伴看到这题的时候心理已经有了答案
- 我们采用前序遍历
- 在二叉树的每一层构建一个数组
- 利用前序遍历的特点依次将偶数行节点`push`到这一层的数组中
- 将奇数行节点`unshift`到这一层的数组中
- 最后我们通过`reverse()`将结果反转输出

## 解题代码

```js
var zigzagLevelOrder = function(root) {
    let arr = []
    function pmap(node,i){
        if(!node) return
        if(!arr[i]) arr[i] = []
        if(i%2){
             arr[i].unshift(node.val)
        }else{
             arr[i].push(node.val)
        }
        if(node.left) pmap(node.left,i+1)
        if(node.right) pmap(node.right,i+1)
    }
    pmap(root,0)
    return arr
};
```
当你快乐时，你要想，这快乐不是永恒的；当你痛苦时，你要想，这痛苦也不是永恒的。

如有任何问题或建议，欢迎留言讨论！
