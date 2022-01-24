---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/legal-binary-search-tree-lcci/)

<!-- more -->


## 题目

实现一个函数，检查一棵二叉树是否为二叉搜索树。

**示例 1:**

```
输入: 
    2
   / \
  1   3
输出: true
```

**示例 2:**

```
输入: 
    5
   / \
  1   4
     / \
    3   6
输出: false
解释: 输入为: [5,1,4,null,null,3,6]。
根节点的值为 5 ，但是其右子节点值为 4 。
```

## 解题思路

首先我们先回顾一下**二叉搜索树**
-   若它的左子树不空，则左子树上所有结点的值均小于它的根结点的值；
-   若它的右子树不空，则右子树上所有结点的值均大于它的根结点的值；
-   它的左、右子树也分别为二叉排序树

因此我们可以采用中序遍历，

- 中序遍历可以获得 `左->根->右`

## 解题代码
```js
var isValidBST = function(root) {
    let prev = Number.MIN_SAFE_INTEGER
    const mmap = (node)=>{
        if(!node) return true
        let l = mmap(node.left)
        if(prev>=node.val) return false
        prev = node.val
        let r = mmap(node.right)
        return l&&r
    }
    return mmap(root)
};
```

如有任何问题或建议，欢迎留言讨论！