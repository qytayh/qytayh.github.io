---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/number-of-recent-calls/)

<!-- more -->


## 题目

写一个`RecentCounter`类来计算特定时间范围内最近的请求。

请你实现`RecentCounter`类：

- `RecentCounter()`初始化计数器，请求数为`0`。

- `int ping(int t)`在时间`t`添加一个新请求，其中`t`表示以毫秒为单位的某个时间，并返回过去`3000`毫秒内发生的所有请求数（包括新请求）。确切地说，返回在`[t-3000, t]`内发生的请求数。

保证每次对`ping`的调用都使用比之前更大的`t`值。

**示例：**

```
输入：
["RecentCounter", "ping", "ping", "ping", "ping"]
[[], [1], [100], [3001], [3002]]
输出：
[null, 1, 2, 3, 3]

解释：
RecentCounter recentCounter = new RecentCounter();
recentCounter.ping(1);     // requests = [1]，范围是 [-2999,1]，返回 1
recentCounter.ping(100);   // requests = [1, 100]，范围是 [-2900,100]，返回 2
recentCounter.ping(3001);  // requests = [1, 100, 3001]，范围是 [1,3001]，返回 3
recentCounter.ping(3002);  // requests = [1, 100, 3001, 3002]，范围是 [2,3002]，返回 3
```

> 提示：
> - `1 <= t <= 109`
> - 保证每次对 `ping` 调用所使用的 `t` 值都 **严格递增**
> - 至多调用 `ping` 方法 `104` 次


## 解题思路

- 我们用数组来存储每次`ping`的值
- 从从题目中我们不难得出是一个升序的数组
- 计算数组中在`[t-3000, t]`之间元素的个数


## 解题代码

```js
var RecentCounter = function() {
    this.arr = []
};

/** 
 * @param {number} t
 * @return {number}
 */
RecentCounter.prototype.ping = function(t) {
    this.arr.push(t)
    let i = 0
    let [low,high] = [t-3000,t]
    this.arr.forEach(v=>{
        if(v>=low&&v<=high){
            i++
        }
    })
    return i
};
```

如有任何问题或建议，欢迎留言讨论！
