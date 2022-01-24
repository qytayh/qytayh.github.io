---
theme: condensed-night-purple
---

看一百遍美女，美女也不一定是你的。但你刷一百遍算法，知识就是你的了~~

谁能九层台，不用累土起!

[题目地址](https://leetcode-cn.com/problems/design-twitter/)

<!-- more -->


## 题目

设计一个简化版的推特(Twitter)，可以让用户实现发送推文，关注/取消关注其他用户，能够看见关注人（包括自己）的最近 `10` 条推文。

实现 `Twitter` 类：

-   `Twitter()` 初始化简易版推特对象
-   `void postTweet(int userId, int tweetId)` 根据给定的 `tweetId` 和 `userId` 创建一条新推文。每次调用此函数都会使用一个不同的 `tweetId` 。
-   `List getNewsFeed(int userId)` 检索当前用户新闻推送中最近 `10` 条推文的 ID 。新闻推送中的每一项都必须是由用户关注的人或者是用户自己发布的推文。推文必须 **按照时间顺序由最近到最远排序** 。
-   `void follow(int followerId, int followeeId)` ID 为 `followerId` 的用户开始关注 ID 为 `followeeId` 的用户。
-   `void unfollow(int followerId, int followeeId)` ID 为 `followerId` 的用户不再关注 ID 为 `followeeId` 的用户。

**示例：**

```
输入
["Twitter", "postTweet", "getNewsFeed", "follow", "postTweet", "getNewsFeed", "unfollow", "getNewsFeed"]
[[], [1, 5], [1], [1, 2], [2, 6], [1], [1, 2], [1]]
输出
[null, null, [5], null, null, [6, 5], null, [5]]

解释
Twitter twitter = new Twitter();
twitter.postTweet(1, 5); // 用户 1 发送了一条新推文 (用户 id = 1, 推文 id = 5)
twitter.getNewsFeed(1);  // 用户 1 的获取推文应当返回一个列表，其中包含一个 id 为 5 的推文
twitter.follow(1, 2);    // 用户 1 关注了用户 2
twitter.postTweet(2, 6); // 用户 2 发送了一个新推文 (推文 id = 6)
twitter.getNewsFeed(1);  // 用户 1 的获取推文应当返回一个列表，其中包含两个推文，id 分别为 -> [6, 5] 。推文 id 6 应当在推文 id 5 之前，因为它是在 5 之后发送的
twitter.unfollow(1, 2);  // 用户 1 取消关注了用户 2
twitter.getNewsFeed(1);  // 用户 1 获取推文应当返回一个列表，其中包含一个 id 为 5 的推文。因为用户 1 已经不再关注用户 2
```

**提示：**

-   `1 <= userId, followerId, followeeId <= 500`
-   `0 <= tweetId <= 104`
-   所有推特的 ID 都互不相同
-   `postTweet`、`getNewsFeed`、`follow` 和 `unfollow` 方法最多调用 `3 * 104` 次

## 解题思路

- 我们用`followers`来记录每个用户关注的列表
- 关注时先判断是否以关注，没关注的话在关注列表进行`push`
- 取关是类似的操作，找到取关索引，进行删除
- 我们用`news`来记录每个用户发的消息
- 在获取信息时，先找到对应的用户关注列表
- 根据关注列表拉到对应的消息
- 对消息进行整合排序，输出最新的10条


## 解题代码

```js
var Twitter = function() {
    this.followers ={}
    this.num = 0
    this.news = {}

};

/** 
 * @param {number} userId 
 * @param {number} tweetId
 * @return {void}
 */
Twitter.prototype.postTweet = function(userId, tweetId) {
    let obj = {tweetId,time:++this.num}
    this.news[userId]?this.news[userId].push(obj):this.news[userId]=[obj]
};

/** 
 * @param {number} userId
 * @return {number[]}
 */
Twitter.prototype.getNewsFeed = function(userId) {
    const followIds = this.followers[userId]||[]
    if(!followIds.includes(userId)) followIds.push(userId)
    let arr = []
    for(let i=0;i<followIds.length;i++){
        if(this.news[followIds[i]]) {
            arr = [...arr,...this.news[followIds[i]]]
        }
    }
    console.log(arr.sort((a,b)=>b.time-a.time).slice(0,10))
    return arr.sort((a,b)=>b.time-a.time).slice(0,10).map(v=> v.tweetId)
};

/** 
 * @param {number} followerId 
 * @param {number} followeeId
 * @return {void}
 */
Twitter.prototype.follow = function(followerId, followeeId) {
    if(this.followers[followerId]){
        if(!this.followers[followerId].includes(followeeId))  {
            this.followers[followerId].push(followeeId)
        }
    }else{
        this.followers[followerId]=[followeeId]
    }
   
};

/** 
 * @param {number} followerId 
 * @param {number} followeeId
 * @return {void}
 */
Twitter.prototype.unfollow = function(followerId, followeeId) {
    if(this.followers[followerId]&&this.followers[followerId].includes(followeeId)){
        this.followers[followerId].splice(this.followers[followerId].indexOf(followeeId),1)
    }
};
```
如有任何问题或建议，欢迎留言讨论！
