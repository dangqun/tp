// JavaScript source code
//<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
//<html xmlns="http://www.w3.org/1999/xhtml">
//<head>
//<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
//<meta name="keywords" content="�ٶȵ�ͼ,�ٶȵ�ͼAPI���ٶȵ�ͼ�Զ��幤�ߣ��ٶȵ�ͼ���������ù���" />
//<meta name="description" content="�ٶȵ�ͼAPI�Զ����ͼ�������û��ڿ��ӻ����������ɰٶȵ�ͼ" />
//<title>�ٶȵ�ͼAPI�Զ����ͼ</title>
//<!--���ðٶȵ�ͼAPI-->
//<style type="text/css">
//    html,body{margin:0;padding:0;}
//    .iw_poi_title {color:#CC5522;font-size:14px;font-weight:bold;overflow:hidden;padding-right:13px;white-space:nowrap}
//    .iw_poi_content {font:12px arial,sans-serif;overflow:visible;padding-top:4px;white-space:-moz-pre-wrap;word-wrap:break-word}
//</style>
//<script type="text/javascript" src="http://api.map.baidu.com/api?key=&v=1.1&services=true"></script>
//</head>

//<body>
//  <!--�ٶȵ�ͼ����-->
//  <div style="width:697px;height:550px;border:#ccc solid 1px;" id="dituContent"></div>
//</body>
//<script type="text/javascript">
    //�����ͳ�ʼ����ͼ������
layui.use(['form', 'element', 'layer', 'jquery'], function () {
    var map = null;
    var lng_lat = null;
    var res = null;
    var dotArr = new Array();
    var dotArray = new Array();
    var dx = null;
    var v=$('#dots').val();
    dotArr.push(JSON.stringify(v));
 

        //$("#search").click(function () {
        //    var search_address = $("#search_address").val();
        //    if (search_address == null) {
        //        alert("�������ַ");
        //    } else {
        //        search(search_address);
        //    }
        //});
        $("#confirm").click(function () {
            if (res == null) {
                alert("��ѡ��һ���ص㣡");
                return;
            }
            if (lng_lat == null) {
                alert("��ȡ��γ�ȴ���");
                return;
            }

            layer.confirm("ȷ��ѡ��[" + res + "]��Ϊǩ���ص���",{icon:3, title:'��ʾ��Ϣ'},function(index){
                layer.close(index);
                if (lng_lat != null) {
                    $("#lng").val(lng_lat.lng);
                    $("#lat").val(lng_lat.lat);
                }
                if (res != null) {
                    $("#address").val(res);
                    $('.dotUl').append('<li class="dotLi"><span style="float:left;height:45px;line-height:45px;" attr-lat="' + lng_lat.lat + '" attr-lat="' + lng_lat.lng + '">' + res + '</span><select style="float:left;height:31px;margin:7px 0;line-height:45px;" class="fanwei"><option value="0">200��</option><option value="1">300��</option><option value="2">500��</option><option value="3">800��</option><option value="4">1000��</option><option value="5">1500��</option></select><select style="float:left;height:31px;margin:7px 0;line-height:45px;" class="qiandao"><option value="0">��ǩ��ǩ��</option><option value="1">����ǩ��</option><option value="2">����ǩ��</option></select><img src="/gy/admin/Tpl/default/Common/images/btn_minus.png" style="height:25px;margin:10px;float:left;" class="deleteDot"></li>');
                    dx = { 'address': res, 'lat': lng_lat.lat, 'lng': lng_lat.lng, 'selectLong': 0, 'selectChoose': 0 }
                    dotArr.push(JSON.stringify(dx));
                    $('#dots').val(dotArr);
                    $(".fanwei").change(function () {
                        var y = $(this).parent('.dotLi').index();
                        dotArr[y] = JSON.parse(dotArr[y])
                        dotArr[y].selectLong = $(this).children('option:selected').val()
                        dotArr[y] = JSON.stringify(dotArr[y])
                        $('.dots').val(dotArr);
                    })
                    $(".qiandao").change(function () {
                        var z = $(this).parent('.dotLi').index();
                        dotArr[z] = JSON.parse(dotArr[z])
                        dotArr[z].selectChoose = $(this).children('option:selected').val()
                        dotArr[z] = JSON.stringify(dotArr[z])
                        $('.dots').val(dotArr);
                    })
                }
            });
        });
        var lnglat = $("#lnglat").val();
        var obj = eval('(' + lnglat + ')');

        var lng = $("#lng").val();
        var lat = $("#lat").val();
    var address = $("#address").val();

    var map = new BMap.Map("allmap");
    map.centerAndZoom(new BMap.Point(120.656054, 27.998312), 11);
    var local = new BMap.LocalSearch(map, {
        renderOptions: { map: map }
    });



    $("#search").click(function () {
        var search_address = $("#search_address").val();
        if (search_address == null) {
            alert("�������ַ");
        } else {
            search(search_address);
        }
    });

    //    if (obj != null) {
    //        for (var i = 0; i < obj.length; i++) {
    //            var point = new BMap.Point(obj[i].lng, obj[i].lat);
    //            console.log(point)
    //            var marker = new BMap.Marker(point);
    //            marker.setAnimation(BMAP_ANIMATION_BOUNCE);
    //            // map.addOverlay(marker);
    //            $('.dotUl').append('<li class="dotLi" attr-lat="' + obj[i].lat + '" attr-lng="' + obj[i].lng + '"><span style="float:left;height:45px;line-height:45px;">' + obj[i].address + '��</span><select style="float:left;height:31px;margin:7px 0;line-height:45px;" class="fanwei"><option value="0">200��</option><option value="1">300��</option><option value="2">500��</option><option value="3">800��</option><option value="4">1000��</option><option value="5">1500��</option></select><select style="float:left;height:31px;margin:7px 0;line-height:45px;" class="qiandao"><option value="0">��ǩ��ǩ��</option><option value="1">����ǩ��</option><option value="2">����ǩ��</option></select><img src="/gy_php/admin/Tpl/default/Common/images/btn_minus.png" style="height:25px;margin:10px;float:left;" class="deleteDot"></li>');
    //            dx = { 'address': obj[i].address, 'lat': obj[i].lat, 'lng': obj[i].lng, 'selectLong': 0, 'selectChoose': 0 }
    //            dotArr.push(JSON.stringify(dx));
    //            $('.dots').val(dotArr);
    //        }
    //    }
    //    map.enableScrollWheelZoom(true);
    //    $(document).on('click', '.deleteDot', function () {
    //        if (confirm('ȷ��Ҫɾ���õ��ַ��')) {
    //            var x = $(this).parent('.dotLi').index();
    //            JSON.stringify(dotArr.splice(x, 1));
    //            $(this).parent().remove();
    //            $('.dots').val(dotArr);
    //        }
    //    })
    //    $(".fanwei").change(function () {
    //        var y = $(this).parent('.dotLi').index();
    //        dotArr[y] = JSON.parse(dotArr[y])
    //        dotArr[y].selectLong = $(this).children('option:selected').val()
    //        dotArr[y] = JSON.stringify(dotArr[y])
    //        $('.dots').val(dotArr);
    //    })
    //    $(".qiandao").change(function () {
    //        var z = $(this).parent('.dotLi').index();
    //        dotArr[z] = JSON.parse(dotArr[z])
    //        dotArr[z].selectChoose = $(this).children('option:selected').val()
    //        dotArr[z] = JSON.stringify(dotArr[z])
    //        $('.dots').val(dotArr);
    //    })
   
    function search(address) {
        var options = {
            renderOptions: { map: map }
        };
        var local = new BMap.LocalSearch(map, options);
        local.search(address);
        local.setMarkersSetCallback(function (pois) {
            for (var i = 0; i < pois.length; i++) {
                pois[i].marker.address = pois[i].address;
                pois[i].marker.addEventListener("click", function (evt) {
                    lng_lat = evt.target.point;
                    res = evt.target.address;
                });
            }
        });

    }


});
//</script>
//</html>  
