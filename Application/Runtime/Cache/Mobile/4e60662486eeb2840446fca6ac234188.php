<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
        body, html,#allmap {width: 100%;height: 100%;overflow: hidden;margin:0;font-family:"微软雅黑";}
    </style>
    <link rel="stylesheet" type="text/css" href="/Template/mobile/new/Static/css/public.css"/>
    <link rel="stylesheet" type="text/css" href="/Template/mobile/new/Static/css/index.css"/>
    <link rel="stylesheet" href="/Template/mobile/new/Static/css/stores.css">
    <link rel="stylesheet" href="/Template/mobile/new/Static/css/public.css">
    <script type="text/javascript" src="https://api.map.baidu.com/api?v=3.0&ak=hWvZskNqtgscOPrf4T4AhKhkVVuuRC7v"></script>
</head>
<body style="background: rgba(255,255,255,1)">
<header>
    <div class="tab_nav">
        <div class="header">
            <div class="h-left"><a class="sb-back" title="返回" id="sb_back"></a></div>
            <div class="h-mid">导航</div>
        </div>
    </div>
</header>
<style>
    /*0.28*/
    p{
        padding: 0;
        margin: 0;
    }
    header{
        height: 45px;
        width: 100%;
        position: absolute;
        left: 0;
        top: 0;
        background: purple;
    }
    .allmap{
        height: 100%;
        margin-top: 46px!important;
        position: relative;
        padding-bottom: 196px!important;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .shop_info{
        position: absolute;
        left: 0;
        bottom: 0;
        height: 80px;
        width: 100%;
        overflow: hidden;
        box-shadow: 0px -3px 5px rgb(100,100,100);
        -webkit-box-shadow: 0px -3px 5px rgba(100,100,100,0.3);
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        padding: 0 20px;
        background: #fff;
    }
    .shop_info .shop_info_content{
        height: 50px;
        margin-top: 15px;
        position: relative;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        padding-right:50px;
        padding-left: 60px;
    }
    .shop_info_logo{
        position: absolute;
        left: 0;
        top: 0;
        width: 50px;
        height: 50px;
        /*background: rgb(238,238,238);*/
        border-radius: 10px;
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
    }
    .shop_info_logo img{
        margin: 0;
        padding: 0;
        display: block;
        width: 100%;
        height: 100%;
        border-radius: 10px;
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
    }
    .shop_info_des{
         /*margin-left: 50px;*/
        /* margin-right: 50px; */
        float: left;
        width: 100%;
        height: 50px;
        /* background: #CCCCCC; */
        text-align: left;
        font-size: 14px;
        /*overflow: hidden;*/
        /*padding-right: 150px;*/
        /*box-sizing: border-box;*/
        /*-webkit-box-sizing: border-box;*/
        /*-moz-box-sizing: border-box;*/
        /*overflow: hidden;*/
    }
    .shop_info_des h3{
        padding: 0;
        margin-top: 3px;
        text-overflow: ellipsis;
        -ms-text-overflow: ellipsis;
        -o-text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
    }
    .shop_info_des p{
        font-size: 12px;
        margin-top: 1px;
        color: rgb(100,100,100);
        text-overflow: ellipsis;
        -ms-text-overflow: ellipsis;
        -o-text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;

    }
    .shop_info_daohang{
        position: absolute;
        right: 0;
        top: 0;
        height: 50px;
        width: 50px;
    }
    .shop_info_daohang i{
        background: rgb(53,141,195) url(data:image/png;base64,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) no-repeat;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        display: block;
        margin: 5px auto;
        background-size: 100%;
        -webkit-background-size: 100%;
        background-position: 0 0;
    }
    .shop_info_daohang p{
        color: rgb(90,90,90);
        line-height: normal;
        text-align: center;
        font-size: 12px;
    }
</style>

    <div id="allmap" class="allmap"></div>
<div class="shop_info">
    <div class="shop_info_content">
        <div id="shopLogo" class="shop_info_logo">
            <img alt="">
        </div>
        <div class="shop_info_des">
            <h3 id="shopName"></h3>
            <p>距离<span id="shopDistance"></span>km&nbsp;&nbsp;&nbsp;<span id="shopAddress"></span></p>
        </div>
        <div class="shop_info_daohang" id="shop_info_daohang">
            <i></i>
            <p>导航</p>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript">

    var myLat=<?php echo ($myLat); ?>;
    var myLng=<?php echo ($myLng); ?>;
    var shopLng=<?php echo ($shopLng); ?>;
    var shopLat=<?php echo ($shopLat); ?>;
    var shopName=localStorage.getItem("shopName");
    var shopAddress=localStorage.getItem("shopAddress");
    var shopLogo=localStorage.getItem('shopLogo');
    var shopDistance=localStorage.getItem('shopDistance');
     document.getElementById('shopName').innerHTML=shopName;
    document.getElementById('shopAddress').innerHTML=shopAddress;
      document.getElementById('shopLogo').getElementsByTagName('img')[0].setAttribute('src',shopLogo);
     document.getElementById('shopDistance').innerHTML=shopDistance;
    //  console.log(myLat+'--'+myLng+"--"+shopLat+'--'+shopLng);
    // 百度地图API功能
    var map = new BMap.Map("allmap");
    var  point=new BMap.Point(shopLng,shopLat);
    map.centerAndZoom(point, 15);
    var opts = {
        width : 200,     // 信息窗口宽度
        height: 100,     // 信息窗口高度
        title : "<p style='font-size: 16px;margin-top: 15px'>"+shopName+"</p>" , // 信息窗口标题
        enableMessage:true,//设置允许信息窗发送短息
        message:"亲耐滴，晚上一起吃个饭吧？戳下面的链接看下地址喔~"
    }
    var infoWindow = new BMap.InfoWindow("<p style='font-size: 16px;font-weight: 600;margin-top: 15px'>地址："+"<span style='color:rgb(150,150,150);'>"+shopAddress+"</span></p>",opts);
    var marker = new BMap.Marker(point);
    map.addOverlay(marker);
    marker.openInfoWindow(infoWindow);
    marker.addEventListener("click", function(){
        map.openInfoWindow(infoWindow,point); //开启信息窗口
    });

    /*var map = new BMap.Map("container");
    map.centerAndZoom(new BMap.Point(116.404, 39.915), 14);
    var walking = new BMap.WalkingRoute(map, {
        renderOptions: {
            map: map,
            autoViewport: true
        }
    });
    var start = new BMap.Point(116.310791, 40.003419);
    var end = new BMap.Point(116.326419, 40.003519);
    walking.search(start, end);


    var map = new BMap.Map("container");
    map.centerAndZoom(new BMap.Point(116.404, 39.915), 14);
    var driving = new BMap.DrivingRoute(map, {
        renderOptions: {
            map: map,
            autoViewport: true
        }
    });
    var start = new BMap.Point(116.310791, 40.003419);
    var end = new BMap.Point(116.486419, 39.877282);
    driving.search(start, end);*/
    document.getElementById('shop_info_daohang').onclick=function () {
        try {
            location.href="http://api.map.baidu.com/direction?origin="+myLat+","+myLng+"&destination="+shopLat+","+shopLng+"&mode=driving&region=义乌&output=html&src=苗江伟";
            //location.href="https://map.baidu.com/mobile/webapp/search/search/qt=s&wd="+shopAddress+"/?third_party=uri_api";
        }
        catch (e) {
            alert(e);
        }


    }
    document.getElementById('sb_back').onclick=function () {
        localStorage.setItem("isNavBack",1);
        history.go(-1);
    }
</script>