---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/shu-de-zi-jie-gou-lcof/)

<!-- more -->


## 题目

输入两棵二叉树A和B，判断B是不是A的子结构。(约定空树不是任意一个树的子结构)

B是A的子结构， 即 A中有出现和B相同的结构和节点值。

例如:

给定的树 A:

```
3
/ \
4 5
/ \
1 2
```
给定的树 B：

```
4
/
1
```
返回 true，因为 B 与 A 的一个子树拥有相同的结构和节点值。

**示例 1：**

```
输入： A = [1,2,3], B = [3,1]
输出： false
```

**示例 2：**

```
输入： A = [3,4,5,1,2], B = [4,1]
输出： true
```

**限制：**

- `0 <= 节点个数 <= 10000`

## 解题思路

- 因为我们约定空树不是任意一个树的子结构，所以如果`A/B`不存在,直接返回`false`
- 假设 `B` 的根节点与 `A` 相同，递归判断是否 `B` 的左右子树都在 `A` 中
- 否则递归判断 `A` 中是否有节点与 `B` 根节点相同，有的话执行上一步，否则输出`false`

## 解题代码

```js
var isSubStructure = function(A, B) {
  if(!A||!B) return false
  if(isPart(A,B)) return true
  return isSubStructure(A.left,B)||isSubStructure(A.right,B)
};

var isPart = function(a,b){
  if(!b) return true
  if(!a||a.val!==b.val) return false
  return isPart(a.left,b.left) && isPart(a.right,b.right)
}
```

如有任何问题或建议，欢迎留言讨论！
