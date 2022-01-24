---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/invert-binary-tree/)

<!-- more -->


## 题目

翻转一棵二叉树。

**示例：**

输入：

```
     4
   /   \
  2     7
 / \   / \
1   3 6   9
```

输出：

```
     4
   /   \
  7     2
 / \   / \
9   6 3   1
```


## 解题思路

- 我们使用前序遍历
- 交换左右节点

## 解题代码

```js
var invertTree = function(root) {
    if(!root) return root
    let temp = root.left
    root.left =root.right
    root.right = temp
    invertTree(root.left)
    invertTree(root.right)
    return root
};
```

如有任何问题或建议，欢迎留言讨论！