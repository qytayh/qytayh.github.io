---
title: 基于高德地图jsapi的二次封装
date: 2021-08-24 16:54:13
tags:
 - 地图
 - jsapi
categories:
 - 地图
 - jsapi
description:
---

针对vue、uni等项目的一些常用地图api的二次封装

<!-- more -->

# 申请key

第一步我们要做地图肯定要有这地图对应的key，还不知道怎么生成的话可以点这个查看----->[如何生成高德地图的key](http://baidu.physton.com/?q=%E5%A6%82%E4%BD%95%E7%94%9F%E6%88%90%E9%AB%98%E5%BE%B7%E5%9C%B0%E5%9B%BE%E7%9A%84key)

# 使用AMapLoader加载高德地图的js

```shell
cnpm i @amap/amap-jsapi-loader
```
> 是的，你没有看错，就用cnpm！npm安装会有各种报错

# 修改map.js

在`map.js`中，我们修改`key`为自己的`key`，并按自己需要去修改插件数组

```js
import AMapLoader from '@amap/amap-jsapi-loader';

// 配置地图所需要的插件
const mapPlugin = [
  // 'AMap.ToolBar',
  // 'AMap.Scale',
  // 'AMap.AdvancedInfoWindow',
  // 'AMap.Geolocation',
  // 'AMap.Transfer',
  // 'AMap.StationSearch',
];
// 地图key
const key = 'your key';

// 主题id
const styleId = 'your styleId'

// 默认城市号
const defaultCityCode = '城市号'  

export default class Map {
 constructor(opt) {
    this.map = null;
    this.initMap(opt);
  }
  // 销毁地图
  destroy() {
    this.map.destroy();
  }
  // 初始化地图
  initMap({ domId, geolocation }) {
    return new Promise((resolve, reject) => {
      AMapLoader.load({
        key: key, // 申请好的Web端开发者Key，首次调用 load 时必填
        plugins: mapPlugin, // 需要使用的的插件列表，如比例尺'AMap.Scale'等
        AMapUI: {
          // 是否加载 AMapUI，缺省不加载
          plugins: [], // 需要加载的 AMapUI ui插件
        },
      })
        .then(AMap => {
          this.map = new AMap.Map(domId, {
            mapStyle: `amap://styles/${styleId}`,
          });
          if (geolocation) {
            // 初始化定位
            this.initGetLocation();
          }
          if (mapPlugin.length > 0) { // 加载插件
            this.initMapPlugin(mapPlugin);
          }
          resolve();
        })
        .catch(e => {
          console.log(e);
          reject();
        });
    });
  }
  // 获取当前定位
  getLocation() {
    this.geolocation.getCurrentPosition();
  }
  // 初始化定位组件
  initGetLocation() {
    this.map.plugin('AMap.Geolocation', () => {
      this.geolocation = new AMap.Geolocation({
        enableHighAccuracy: false, //是否使用高精度定位，默认:true
        timeout: 1000, //超过10秒后停止定位，默认：无穷大
        maximumAge: 0, //定位结果缓存0毫秒，默认：0
        convert: true, //自动偏移坐标，偏移后的坐标为高德坐标，默认：true
        showButton: false, //显示定位按钮，默认：true
        showMarker: true, //定位成功后在定位到的位置显示点标记，默认：true
        showCircle: true, //定位成功后用圆圈表示定位精度范围，默认：true
        panToLocation: true, //定位成功后将定位到的位置作为地图中心点，默认：true
        zoomToAccuracy: false, //定位成功后调整地图视野范围使定位位置及精度范围视野内可见，默认：false
      });
      this.map.addControl(this.geolocation);
      this.getLocation();// 初始化完成默认调用一次获取定位
      AMap.event.addListener(this.geolocation, 'complete', onComplete => {
        console.log(onComplete, '定位成功');
        this.currentLocation = onComplete; //  存储当前定位
      }); //返回定位信息

      AMap.event.addListener(geolocation, 'error', onError => {
        console.log(onError, '定位失败');
      }); //返回 定位失败
    });
  }
  // 加载插件
  initMapPlugin(l) {
    l.forEach(v => {
      const f = v.split('.')[1];
      this.map.addControl(new AMap[f]());
    });
  }
  // 画线
  pathLine(pointList, pathOption) {
    /**
     * pointList 为线所要经过的点 格式为
     * [
          {
            name: "轨迹名",
            path: [
              [100.340417, 27.376994],
              [108.426354, 37.827452],
              [113.392174, 31.208439],
              [124.905846, 42.232876],
            ],
          },
        ],
     * pathOption 为线条参数
     * 
     * **/
    const that = this;
    let pathLineStyle = {
      strokeStyle: 'red',
      lineWidth: 6,
      dirArrowStyle: true,
    };
    Object.assign(pathLineStyle, pathOption);
    AMapUI.load(['ui/misc/PathSimplifier'], function(PathSimplifier) {
      var pathSimplifierIns = new PathSimplifier({
        zIndex: 100,
        map: that.map, //所属的地图实例
        getPath: function(pathData, pathIndex) {
          //返回轨迹数据中的节点坐标信息，[AMap.LngLat, AMap.LngLat...] 或者 [[lng|number,lat|number],...]
          return pathData.path;
        },
        // getHoverTitle: function(pathData, pathIndex, pointIndex) {
        //   //返回鼠标悬停时显示的信息
        //   if (pointIndex >= 0) {
        //     //鼠标悬停在某个轨迹节点上
        //     return (
        //       pathData.name + '，点:' + pointIndex + '/' + pathData.path.length
        //     );
        //   }
        //   //鼠标悬停在节点之间的连线上
        //   return pathData.name + '，点数量' + pathData.path.length;
        // },
        renderOptions: {
          //轨迹线的样式
          pathLineStyle,
        },
      });
      pathSimplifierIns.setData(pointList);
    });
  }
  // 自定义兴趣点
  drawMarker(marker) {
    // marker可传单个点 可传点数组
    this.map.add(marker);
  }
  // 获取自定义内容标记
  getMarker(position, opt, extData, fn) {
    /**
     * position 为位置信息 必传
     * opt 为用户自定义覆盖物 可传
     * icon: '//vdata.amap.com/icons/b18/1/2.png', // 添加 Icon 图标 URL
     * size: new AMap.Size(40, 50),    // 图标尺寸
     * image: '//webapi.amap.com/theme/v1.3/images/newpc/way_btn2.png',  // Icon的图像
     * imageOffset: new AMap.Pixel(0, -60),  // 图像相对展示区域的偏移量，适于雪碧图等
     * imageSize: new AMap.Size(40, 50)   // 根据所设置的大小拉伸或压缩图片
     * zoom: 13
     * content:'<div class="marker-route marker-marker-bus-from"></div>'
     * 更多配置 https://lbs.amap.com/api/javascript-api/reference/overlay#marker
     * **/
    let option = {
      position, // 基点位置
      offset: new AMap.Pixel(-17, -42), // 相对于基点的
      clickable: true,
      extData: extData,
    };
    if (opt) {
      option = { ...option, ...opt };
    }
    const marker = new AMap.Marker(option);
    marker.on('click', e => {
      // 注册marker的点击事件
      // console.log(e.target.getExtData());
      this.map.setZoomAndCenter(10, e.target.getPosition()); // 点击marker点后以 marker点为中心
      // marker点 点击
      if (this.lastSelectedMarker) {
        // 如果存在上个点击点 将上个点击点的icon恢复默认大小
        const { image } = this.lastSelectedMarker.w.icon.Ce;
        const icon = this.getMarkerIcon({ image });
        this.lastSelectedMarker.setIcon(icon);
      }
      const { image } = e.target.w.icon.Ce;
      const newIcon = this.getMarkerIcon({
        image,
        setOffset: new AMap.Pixel(-18, -50),
        size: new AMap.Size(52, 52), // 图标尺寸
        imageSize: new AMap.Size(48, 48),
      });

      e.target.setIcon(newIcon);
      fn(extData);
      this.lastSelectedMarker = e.target;
    });
    return marker;
  }
  // 生成marker的图片icon
  getMarkerIcon(opt) {
    // opt 必须包含image属性
    let option = {
      size: new AMap.Size(40, 40), // 图标尺寸
      imageSize: new AMap.Size(36, 36),
    };
    return new AMap.Icon({ ...option, ...opt });
  }
  // 初始化 拖拽选址
  initPositionPicker([fnSuc, fnFail], position) {
    // [fnSuc, fnFail], position
    /***
     * 入参说明
     * fn数组 为拖拽事件处理 必传
     * position 为start的中线点 可不传
     * **/
    AMapUI.loadUI(['misc/PositionPicker'], PositionPicker => {
      this.positionPicker = new PositionPicker({
        mode: 'dragMap', //设定为拖拽地图模式，可选'dragMap'、'dragMarker'，默认为'dragMap'
        map: this.map, //依赖地图对象
      });
      //TODO:事件绑定、结果处理等
      this.positionPicker.on('success', positionResult => {
        console.log(positionResult, '拖拽 success');
        // fnSuc(positionResult)
      });
      this.positionPicker.on('fail', positionResult => {
        // 海上或海外无法获得地址信息
        console.log(positionResult, '拖拽err');
        // fnFail()
      });
      this.positionPicker.start(
        position ? position : this.currentLocation.position
      ); // 开启定位  默认以当前点为中心点  有传入 就以传入的为中心点
    });
  }

  // 添加搜索框输入提示
  initAutoComplete() {
    AMap.plugin('AMap.Autocomplete', ()=> {
      const {citycode} = this.currentLocation.addressComponent  // 获取当前定位的城市的城市号
      this.autoComplete = new AMap.Autocomplete({
        city:citycode?citycode:defaultCityCode
      });
    });
  }
```

# 使用

在我们需要使用地图的地方
```js
// 引入Map
import Map from "@/common/script/map";

// 初始化
this.map = new Map({domId:"dom的id",geolocation:true});

// 获取定位 (可以放在你点击获取当前定位的按钮上)
this.map.getLocation()

// 输入提示 
this.map.initAutoComplete()  // 注册输入提示
  // 在需要触发的方法里面  this.place为 需要进行模糊匹配的内容
  this.map.autoComplete.search(this.place,(status,res)=>{
      console.log(status,res)
  })



// 画自定义点 content 
drawMarker() {
  const content ='<div>1</div>'
  const marker = this.map.getMarker([116.39, 39.9],{content});
  this.map.drawMarker(marker);
}

// 画自定义点 icon
drawMarker(){
  const icon = this.map.getMarkerIcon({ image: 'you image url' });
  const marker = this.map.getMarker(
      [120.3, 31.3],
      { icon },
      extData,
      callback // 传递给marker点 点击触发的回调方法
    );
  this.map.drawMarker(marker);
  
}

// 画自定义线
drawPath() {
  this.map.pathLine(
    [
      {
        name: "轨迹0",
        path: [
          [100.340417, 27.376994],
          [108.426354, 37.827452],
        ],
      },
    ],
    {
      strokeStyle: "green",
    }
  );
  this.map.pathLine([
    {
      name: "轨迹0",
      path: [
        [108.426354, 37.827452],
        [113.392174, 31.208439],
      ],
    },
  ]);
  this.map.pathLine(
    [
      {
        name: "轨迹0",
        path: [
          [113.392174, 31.208439],
          [124.905846, 42.232876],
        ],
      },
    ],
    {
      strokeStyle: "pink",
    }
  );
}

// 拖拽定位 初始化 第一次初始化会默认开启拖拽
this.map.initPositionPicker([sucCallBack,failCallBack])

// 结束拖拽
this.map.positionPicker.stop();




```


<!-- markdownlint-disable MD041 MD002--> 