
/*百度地图API功能*/

// 初始化设置
function setMapIni(default_point){

    // 实例化 全局变量
    map = new BMap.Map("allmap", {minZoom:1,maxZoom:16});
    // window.map = new BMap.Map("allmap", {minZoom:10,maxZoom:16});
    // 起始点
    var point = new BMap.Point(default_point[0], default_point[1]);
    // 中心点和缩放级别
    map.centerAndZoom(point, 12);
    // 启用滚轮放大缩小,默认禁用
    map.enableScrollWheelZoom();
    var searchInfoWindow = null;
    var opts={};

    return map;
}

// 创建坐标
function createCoords(z){

    for (var i = 0; i < z.length; i ++) {
        var point = new BMap.Point(z[i].ucs_x, z[i].ucs_y);
        /*定义小图标*/
        var myIcon = new BMap.Icon("http://api.map.baidu.com/img/markers.png", new BMap.Size(23, 25), {
            offset: new BMap.Size(10, 25),
            imageOffset: new BMap.Size(0, 0 - i * 25)
        });

        // 创建标注
        var marker = new BMap.Marker(point, {icon: myIcon});
        // 弹窗内容
        var content =
        '<div class="map_div" style="margin:0;line-height:20px;padding:2px;" to="http://api.map.baidu.com/">' +
            '<img src="../img/baidu.jpg" alt="" style="float:right;zoom:1;overflow:hidden;width:100px;height:100px;margin-left:3px;"/>' +'地址:'+
            z[i].addr+'<br/>'+ "简介：" +z[i].remark +'<br/>'+ "电话:" +z[i].tel +
        '</div>'+
        '<form id="gotobaiduform" action="http://api.map.baidu.com/direction" target="_blank" method="get">'+
            '<span class="input">'+
                '<strong>起点：</strong>'+
                '<input class="outset" type="text" name="origin" id="origin"  placeholder="请输入你所在的位置" />'+
                '<div id="searchResultPanel" style="border:1px solid #C0C0C0;width:150px;height:auto; display:none;"></div>'+
                '<input class="outset-but" type="button" value="公交" onclick="gotobaidu(1)" />'+
                '<input class="outset-but" type="button" value="驾车" onclick="gotobaidu(2)" />'+
                '<a class="gotob"'+ 'href="url='+'http://api.map.baidu.com/direction?destination=latlng:'+marker.getPosition().lat+',' +  marker.getPosition().lng+ '|name:'+  z[i].name + '®ion='+z[i].name+'&output=html"'+ 'target="_blank"></a>'+
            '</span>'+
            '<input type="hidden" value="'+ '合肥' +'" name="region" />'+
            '<input type="hidden" value="html" name="output" />'+
            '<input type="hidden" value="driving" name="mode" />'+
            '<input type="hidden" value="latlng:' +  marker.getPosition().lat + "," + marker.getPosition().lng + '|name:' + z[i].name + '"' +' name="destination" />'+
        '</form>'

        opts = {
            enableMessage:false,
            title  : z[i].name,      //标题
            width  : 290,             //宽度
            height : 105,              //高度
            panel  : "panel",         //检索结果面板
            enableAutoPan : true,     //自动平移
            searchTypes   :[
            ]
        };

        map.addOverlay(marker); //在地图中添加marker
        addClickHandler(content,opts,marker);
    }

    // 输入提示
    // 百度地图API功能(但是这里页面会报错，不会修改错误，但是不影响页面的整体功能)
    function G(id) {
        return document.getElementById(id);
    }

    var ac = new BMap.Autocomplete(    //建立一个自动完成的对象
        {"input" : "origin"
        ,"location" : map
    });

    ac.addEventListener("onhighlight", function(e) {  //鼠标放在下拉列表上的事件
        var str = "";
        var _value = e.fromitem.value;
        var value = "";
        if (e.fromitem.index > -1) {
            value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        }
        str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;
        value = "";
        if (e.toitem.index > -1) {
            _value = e.toitem.value;
            value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        }
        str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
        G("searchResultPanel").innerHTML = str;
    });

    var myValue;
    ac.addEventListener("onconfirm", function(e) {    //鼠标点击下拉列表后的事件
        var _value = e.item.value;
        myValue = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        G("searchResultPanel").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;
    });
}

// 导航
function gotobaidu(type){
    if($.trim($("input[name=origin]").val())==""){
        alert("请输入起点！");
        return;
    }else{
        if(type==1){
            $("input[name=mode]").val("transit");
            $("#gotobaiduform")[0].submit();
        }else if(type==2){
            $("input[name=mode]").val("driving");
            $("#gotobaiduform")[0].submit();
        }
    }
}

// 增加监听事件
function addClickHandler(content,opts,marker){
    marker.addEventListener("click",function(e){
         searchInfoWindow = new BMapLib.SearchInfoWindow(map, content,opts)
         searchInfoWindow.open(marker);
    })
}


