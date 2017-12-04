
// 百度地图API功能

function setMapIni(default_point){
    // 初始化设置
    // 实例化 全局变量
    map = new BMap.Map("allmap", {minZoom:10,maxZoom:16});
    // window.map = new BMap.Map("allmap", {minZoom:10,maxZoom:16});
    // 起始点
    var point = new BMap.Point(default_point[0], default_point[1]);
    // 中心点和缩放级别
    map.centerAndZoom(point, 15);
    // 启用滚轮放大缩小,默认禁用
    map.enableScrollWheelZoom(true);
    var searchInfoWindow = null;
    var opts={};

    return map;
}

// 创建坐标
function createCoords(z){

    for (var i = 0; i < z.length; i ++) {
        var point = new BMap.Point(z[i][0], z[i][1]);
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
            '<img src="../img/baidu.jpg" alt="" style="float:right;zoom:1;overflow:hidden;width:100px;height:100px;margin-left:3px;"/>' +
            z[i][2]+'<br/>'+z[i][3]+'<br/>'+z[i][4] +
        '</div>'+
        '<form id="gotobaiduform" action="http://api.map.baidu.com/direction" target="_blank" method="get">'+
            '<span class="input">'+
                '<strong>起点：</strong>'+
                '<input class="outset" type="text" name="origin" value="合肥站" />'+
                '<input class="outset-but" type="button" value="公交" onclick="gotobaidu(1)" />'+
                '<input class="outset-but" type="button" value="驾车" onclick="gotobaidu(2)" />'+
                '<a class="gotob"'+ 'href="url='+'"http://api.map.baidu.com/direction?destination=latlng:'+marker.getPosition().lat+"," +  marker.getPosition().lng+ '|name:'+  z[i][6] + '®ion='+z[i][7]+'&output=html"'+ 'target="_blank"></a>"'+
            '</span>'+
            '<input type="hidden" value="'+z[i][7]+'" name="region" />'+
            '<input type="hidden" value="html" name="output" />'+
            '<input type="hidden" value="driving" name="mode" />'+
            '<input type="hidden" value="latlng:' +  marker.getPosition().lat + "," + marker.getPosition().lng + '|name:' + z[i][6]+ '"' +' name="destination" />'+
        '</form>'

        opts = {
            enableMessage:false,
            title  : z[i][5],      //标题
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