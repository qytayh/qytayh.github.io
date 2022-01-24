---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/binary-tree-postorder-traversal/)

<!-- more -->


## 题目

给定一个二叉树，返回它的 *后序* 遍历。

**示例:**

```
输入: [1,null,2,3]  
   1
    \
     2
    /
   3 

输出: [3,2,1]
```

## 解题思路

- 我们首先要知道*后序遍历*的规则，输出顺序*左 -> 右 -> 根*
- 按顺序进行遍历插入数组


## 解题代码

```js
var postorderTraversal = function(root) {
    let res = []
    let after_order = (root)=>{
        if(root==null) return
        after_order(root.left)
        after_order(root.right)
        res.push(root.val)
    }
    after_order(root)
    return res
};
```

如有任何问题或建议，欢迎留言讨论！
