---
title: 在flutter中优雅的封装网络请求
date: 2020-08-03 20:30:25
tags:
  - flutter
	- 网络请求
categories:
  - flutter
	- 网络请求
description:
---

本文讲述如何封装dio网络请求，并在实际中使用。
<!-- more -->

## Dio http库

dio是一个强大的Dart Http请求库，支持Restful API、FormData、拦截器、请求取消、Cookie管理、文件上传/下载、超时等。

## 引入

引入dio:
```yaml
dependencies:
  dio: ^x.x.x   #请使用pub上的最新版本
```

## 开始封装

在lib文件夹下创建`utils/dio/dio.dart`,用于编写我们封装的代码

```dart
import 'dart:convert';
import 'package:dio/dio.dart';
import 'package:shared_preferences/shared_preferences.dart';
/// 自定义枚举
enum Method { get, post, put, delete }
class Net {
  // 工厂模式
  factory Net() => _getInstance();
  static Net get instance => _getInstance();
  static Net _instance;

  Dio dio;
  Net._internal() {
    // 初始化
    dio = Dio(BaseOptions(
      connectTimeout: 60000, // 连接服务器超时时间，单位是毫秒.
      receiveTimeout: 10000, // 响应流上前后两次接受到数据的间隔，单位为毫秒, 这并不是接收数据的总时限.
    ));
  }
  // 单列模式
  static Net _getInstance() {
    if (_instance == null) {
      _instance = Net._internal();
    }
    return _instance;
  }
  get(String url, Map<String, dynamic> params) {
    return _doRequest(url, params, Method.get);
  }
  post(String url, Map<String, dynamic> params) {
    return _doRequest(url, params, Method.post);
  }
  put(String url, Map<String, dynamic> params) {
    return _doRequest(url, params, Method.put);
  }
  delete(String url, Map<String, dynamic> params) {
    return _doRequest(url, params, Method.delete);
  }
   _doRequest(
    String url,
    Map<String, dynamic> params,
    Method method,
  ) async {
    try {
      var _prefs = await SharedPreferences.getInstance();
      var token = _prefs.getString('token')??'';
      /// 可以添加header 设置token
      dio.options.headers.addAll({'Authorization': 'Bearer ' + token});
      String BASE_URL = '你的接口地址' + url;
      Response response;
      switch (method) {
        case Method.get:
          if (params != null && params.isNotEmpty) {
            response = await dio.get(BASE_URL, queryParameters: params);
          } else {
            response = await dio.get(BASE_URL);
          }
          break;
        case Method.post:
          if (params != null && params.isNotEmpty) {
            response = await dio.post(BASE_URL, queryParameters: params);
          } else {
            response = await dio.post(BASE_URL);
          }
          break;
        case Method.put:
          if (params != null && params.isNotEmpty) {
            response = await dio.put(BASE_URL, queryParameters: params);
          } else {
            response = await dio.put(BASE_URL);
          }
          break;
        case Method.delete:
          if (params != null && params.isNotEmpty) {
            response = await dio.delete(BASE_URL, queryParameters: params);
          } else {
            response = await dio.delete(BASE_URL);
          }
          break;
      }
      return json.decode(response.toString());
    } catch (exception) {
      print('错误：${exception.toString()}');
    }
  }
}
class BaseModel {
  int code;
  dynamic data;
  String error;
  BaseModel({this.code, this.data, this.error});
  BaseModel.fromJson(Map<String, dynamic> json) {
    code = json['code'];
    data = json['data'];
    error = json['error'];
  }
}
```

## 使用

我们以一个登陆的demo来看dio的用法
```dart
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:zzc_app/utils/dio/dio.dart';

class LoginForm extends StatefulWidget {
  LoginForm({Key key}) : super(key: key);
  @override
  _LoginFormState createState() => _LoginFormState();
}
class _LoginFormState extends State<LoginForm> {
  final _userNameController = TextEditingController();
  final _pwdController = TextEditingController();

  _onsubmit() async {//进行登陆操作
    var params={
      'username':_userNameController.text,
      'password':_pwdController.text
    };
    var res = await Net().post('login', params);
    if(res['code']==1){
      //登陆成功的操作
    }else{
      //登陆失败的操作
    }
  }
  @override
  Widget build(BuildContext context) {
    return Scaffold(
        body: Container(
      padding: EdgeInsetsDirectional.fromSTEB(30, 100, 30, 10),
      child: Column(
        children: <Widget>[
          TextField(
            controller: _userNameController,
            decoration: InputDecoration(
              labelText: '用户名',
            ),
          ),
          TextField(
            controller: _pwdController,
            decoration: InputDecoration(
              labelText: '密码',
            ),
          ),
          MaterialButton(onPressed: _onsubmit,//等同于我们常见的click事件
           child: Text('登陆'))
        ],
      ),
    ));
  }
}

```


>  [将uni-request进行axios化封装](https://qytayh.github.io/2020/11/%E5%B0%86uni-request%E8%BF%9B%E8%A1%8Caxios%E5%8C%96%E5%B0%81%E8%A3%85/)
>  [在vue中对axios进行二次封装](https://qytayh.github.io/2020/08/%E5%9C%A8vue%E4%B8%AD%E5%AF%B9axios%E8%BF%9B%E8%A1%8C%E4%BA%8C%E6%AC%A1%E5%B0%81%E8%A3%85/)





<!-- markdownlint-disable MD041 MD002--> 