---
title: flutter中验证码倒计时
date: 2020-08-10 09:52:40
tags:
    - flutter
categories:
    - flutter
description:
---

flutter中更换手机号，验证码倒计时的一种写法。
<!-- more -->

```dart
import 'dart:async';
import 'dart:convert';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:zzc_app/utils/dio/dio.dart';

class PhoneNumber extends StatefulWidget {
  final userinfo;
  PhoneNumber(this.userinfo, {Key key}) : super(key: key);

  @override
  _PhoneNumberState createState() => _PhoneNumberState();
}

class _PhoneNumberState extends State<PhoneNumber> {
  final _codeController = TextEditingController();

  Timer _countdownTimer;
  String _codeCountdownStr = '获取验证码';
  int _countdownNum = 59;

  _getcode() async {
    //获取验证码
    var res = await Net().get('verification-code', {
      'phone_number': widget.userinfo['phone_number'],
      'type': "change_phone"
    });
    reGetCountdown();
  }


  @override
  void initState() {
    super.initState();
  }

  void reGetCountdown() {
    setState(() {
      if (_countdownTimer != null) {
        return;
      }
      // Timer的第一秒倒计时是有一点延迟的，为了立刻显示效果可以添加下一行
      _codeCountdownStr = '${_countdownNum--}(s)';
      _countdownTimer = new Timer.periodic(new Duration(seconds: 1), (timer) {
        setState(() {
          if (_countdownNum > 0) {
            _codeCountdownStr = '${_countdownNum--}(s)';
          } else {
            _codeCountdownStr = '获取验证码';
            _countdownNum = 59;
            _countdownTimer.cancel();
            _countdownTimer = null;
          }
        });
      });
    });
  }

// 不要忘记在这里释放掉Timer
  @override
  void dispose() {
    _countdownTimer?.cancel();
    _countdownTimer = null;
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('绑定手机号')),
      body: Container(
        padding: EdgeInsets.only(left: 10, right: 10, top: 10),
        child: ListView(
          children: <Widget>[
            ListTile(
              leading: Text('当前手机号'),
              title: Text(widget.userinfo['phone_number']),
            ),
            Divider(),
            ListTile(
              title: TextField(
                controller: _codeController,
                decoration: InputDecoration(hintText: '请输入验证码'),
              ),
              trailing: RaisedButton(
                onPressed: _countdownNum >= 59 ? _getcode : null,
                child: Text(_codeCountdownStr),
              ),
            ),
          ],
        ),
      ),
    );
  }
}

```

<!-- markdownlint-disable MD041 MD002--> 