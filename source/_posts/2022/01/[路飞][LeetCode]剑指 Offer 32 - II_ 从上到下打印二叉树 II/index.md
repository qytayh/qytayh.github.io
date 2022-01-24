---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/cong-shang-dao-xia-da-yin-er-cha-shu-ii-lcof/)

<!-- more -->


## 题目

从上到下按层打印二叉树，同一层的节点按从左到右的顺序打印，每一层打印到一行。

例如:

给定二叉树: `[3,9,20,null,null,15,7]`,

```
    3
   / \
  9  20
    /  \
   15   7
```

返回其层次遍历结果：

```
[
  [3],
  [9,20],
  [15,7]
]
```

**提示：**

1.  `节点总数 <= 1000`


## 解题思路

- 这题其实与 [662_二叉树最大宽度](https://juejin.cn/post/7047510915922526245) 用类似的思路，可以对比观看
- 我们采用前序遍历
- 在二叉树的每一层构建一个数组
- 利用前序遍历的特点依次将节点`push`到这一层的数组中


## 解题代码

```js
var levelOrder = function(root) {
    let arr = []
    function pmap(node,i){
        if(!node) return
        if(!arr[i]) arr[i] = []
        arr[i].push(node.val)
        if(node.left) pmap(node.left,i+1)
        if(node.right) pmap(node.right,i+1)
    }
    pmap(root,0)
    return arr
};
```

当你快乐时，你要想，这快乐不是永恒的；当你痛苦时，你要想，这痛苦也不是永恒的。

如有任何问题或建议，欢迎留言讨论！

