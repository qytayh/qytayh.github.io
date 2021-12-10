---
title: flutter中区分开发环境与正式环境
date: 2020-08-19 10:12:02
tags:
  - flutter
categories:
  - flutter
description:
---

本文讲述如何在flutter中区分开开发环境以及正式环境中接口地址等相关信息。

<!-- more -->

## 准备工作

首先我们已经有了一个flutter项目，创建一个新文件用来保存所有环境特定配置信息`lib/app_config.dart`

```dart
import 'package:flutter/material.dart';
import 'package:meta/meta.dart';

class ENV extends InheritedWidget {
  static String appName; // 系统名称
  static String envName; // 运行环境
  static String baseUrl; // 基础api url
  static String webViewUrl; // 基础webviewurl
 ENV({
    @required String appName,
    @required String envName,
    @required String baseUrl,
    @required Widget child,
    @required String webViewUrl
  }) : super(child: child){
    ENV.appName = appName;
    ENV.envName = envName;
    ENV.baseUrl = baseUrl;
    ENV.webViewUrl = webViewUrl;
  }

  static ENV of(BuildContext context) {
     return context.dependOnInheritedWidgetOfExactType(aspect: ENV);
  }

  @override
  bool updateShouldNotify(InheritedWidget oldWidget) => false;
}
```

## 区分环境配置

新建`main_dev.dart`,并编写开发环境的配置
```dart
import 'package:flutter/material.dart';
import 'app_config.dart';
import 'main.dart';

void main() {
  var configuredApp = new ENV(
    appName: '项目名dev',
    envName: 'development',
    baseUrl: '开发环境接口地址',
    child: new App(),
    webViewUrl:'开发环境webview地址'
  );
  runApp(configuredApp);
}
```
于此同时，创建`main_pro.dart`,编写对应的正式环境配置
```dart
import 'package:flutter/material.dart';
import 'app_config.dart';
import 'main.dart';

void main() {
  var configuredApp = new ENV(
    appName: '项目名',
    envName: 'product',
    baseUrl: '正式环境接口地址',
    child: new App(),
    webViewUrl:'正式环境webview地址'
  );
  runApp(configuredApp);
}
```

## 使用

修改`dio.dart`中baseurl的获取方式
```dart
import 'package:zzc_app/app_config.dart';
...
String BASE_URL = ENV.baseUrl + url;
...
```
> dio的封装可以看这篇->[在flutter中优雅的封装网络请求](https://qytayh.github.io/2020/08/%E5%9C%A8flutter%E4%B8%AD%E4%BC%98%E9%9B%85%E7%9A%84%E5%B0%81%E8%A3%85%E7%BD%91%E7%BB%9C%E8%AF%B7%E6%B1%82/)

## 编译

- 运行开发版本，采用`flutter run -t lib/main_dev.dart`

- 运行生产版本，采用`flutter run -t lib/main_pro.dart`

- Android上创建一个release版本,采用`flutter build apk -t lib/main_<environment>.dart`

> 我们将为不同的环境生成对应的APK。 要在iOS上构建版本，只需将apk替换为ios。


<!-- markdownlint-disable MD041 MD002--> 