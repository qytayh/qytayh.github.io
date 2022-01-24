---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/maximum-width-of-binary-tree/)

<!-- more -->


## 题目
给定一个二叉树，编写一个函数来获取这个树的最大宽度。树的宽度是所有层中的最大宽度。这个二叉树与**满二叉树（full binary tree）** 结构相同，但一些节点为空。

每一层的宽度被定义为两个端点（该层最左和最右的非空节点，两端点间的`null`节点也计入长度）之间的长度。

**示例 1:**

```
输入: 

           1
         /   \
        3     2
       / \     \  
      5   3     9 

输出: 4
解释: 最大值出现在树的第 3 层，宽度为 4 (5,3,null,9)。
```

**示例 2:**

```
输入: 

          1
         /  
        3    
       / \       
      5   3     

输出: 2
解释: 最大值出现在树的第 3 层，宽度为 2 (5,3)。
```

**示例 3:**

```
输入: 

          1
         / \
        3   2 
       /        
      5      

输出: 2
解释: 最大值出现在树的第 2 层，宽度为 2 (3,2)。
```

**示例 4:**

```
输入: 

          1
         / \
        3   2
       /     \  
      5       9 
     /         \
    6           7
输出: 8
解释: 最大值出现在树的第 4 层，宽度为 8 (6,null,null,null,null,null,null,7)。
```

**注意:**  答案在32位有符号整数的表示范围内。


## 解题思路

- 本题我们用前序遍历
- 我们给每一层的节点从左向右添加下标(下标从`1`开始)
- 我们不难发现 左叶为头结点下标`i`的`2*i-1` ,右叶为头结点下标`i`的`2*i` 
- 我们用数组记录下每一层的下标组成的数组
- 取数组中每层下标数组中首尾差值最大的为最大宽度

## 解题代码

```js
var widthOfBinaryTree = function(root) {
    let arr = []
    const mod = 10000000007
    function setIndex(node,deep,i){
        if(!node) return
        if(!arr[deep]) arr[deep] = []
        arr[deep].push(i)
        setIndex(node.left,deep+1,(2*i -1)%mod)
        setIndex(node.right,deep+1,(2*i)%mod)
    }
    setIndex(root,0,1)

    let max=1
    for(let i =1;i<arr.length;i++){
        if(arr[i].length>1){
            max = Math.max(max,arr[i].pop()-arr[i][0]+1)
        }
    }
    return max
};
```

如有任何问题或建议，欢迎留言讨论！
