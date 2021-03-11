---
title: git常用命令
date: 2020-05-29 09:20:12
tags:
    - git
categories:
    - git
description: 记录下工作中经常使用的git命令
---

日常工作中的git高频命令

<!-- more -->
## 日常工作中常用的几条git命令

1. 查看所有本地分支和远程分支

    `git branch -a`

2. 下载一个项目和它的整个代码历史

    `git clone [url]`

3. 列出所有远程分支

    `git branch -r`

4. 切换到指定分支

    `git checkout [branch-name]`

5. 合并指定分支到当前分支

    `git merge [branch]`

6. 新建一个分支，但依然停留在当前分支

    `git branch [branch-name]`

7. 新建一个分支，并切换到该分支

    `git checkout -b [branch]`

8. 显示所有远程仓库

    `git remote -v`

9. 取回远程仓库的变化

    `git pull`

10. 添加当前目录的所有文件到暂存区

    `git add .`

11.  提交暂存区到仓库区

    `git commit -m [message]`

12. 上传本地代码到远程仓库

    `git push`

13. 提交本地分支到远程仓库

    `git push origin 本地分支名`

14. 删除远程分支

    `git push --delete origin 分支名`

15. 更新远程分支列表

    `git remote update origin -p`

<!-- markdownlint-disable MD041 MD002--> 