//获取系统时间
var newDate = '';
getLangDate();
//值小于10时，在前面补0
function dateFilter(date){
    if(date < 10){return "0"+date;}
    return date;
}
function getLangDate(){
    var dateObj = new Date(); //表示当前系统时间的Date对象
    var year = dateObj.getFullYear(); //当前系统时间的完整年份值
    var month = dateObj.getMonth()+1; //当前系统时间的月份值
    var date = dateObj.getDate(); //当前系统时间的月份中的日
    var day = dateObj.getDay(); //当前系统时间中的星期值
    var weeks = ["星期日","星期一","星期二","星期三","星期四","星期五","星期六"];
    var week = weeks[day]; //根据星期值，从数组中获取对应的星期字符串
    var hour = dateObj.getHours(); //当前系统时间的小时值
    var minute = dateObj.getMinutes(); //当前系统时间的分钟值
    var second = dateObj.getSeconds(); //当前系统时间的秒钟值
    var timeValue = "" +((hour >= 12) ? (hour >= 18) ? "晚上" : "下午" : "上午" ); //当前时间属于上午、晚上还是下午
    newDate = dateFilter(year)+"年"+dateFilter(month)+"月"+dateFilter(date)+"日 "+" "+dateFilter(hour)+":"+dateFilter(minute)+":"+dateFilter(second);
    document.getElementById("nowTime").innerHTML = "亲爱的admin，"+timeValue+"好！ 欢迎使用layuiCMS 2.0模版。当前时间为： "+newDate+"　"+week;
    setTimeout("getLangDate()",1000);
}

layui.use(['form','element','layer','jquery'],function(){
    var form = layui.form,
        layer = parent.layer === undefined ? layui.layer : top.layer,
        element = layui.element;
        $ = layui.jquery;
    //上次登录时间【此处应该从接口获取，实际使用中请自行更换】
    $(".loginTime").html(newDate.split("日")[0]+"日</br>"+newDate.split("日")[1]);
    //icon动画
    $(".panel a").hover(function(){
        $(this).find(".layui-anim").addClass("layui-anim-scaleSpring");
    },function(){
        $(this).find(".layui-anim").removeClass("layui-anim-scaleSpring");
    })
    $(".panel a").click(function(){
        parent.addTab($(this));
    })
    //义工数据汇总

        $.ajax({
            url: _public_+"/json/total.json",
            type : "get",
            dataType : "json",
            success: function (data) {
                console.log(data);
                fillTotal(data);
            }
        })

    //填充数据方法
    function fillTotal(data){
        //判断字段数据是否存在
        function nullData(data){
            if(data == '' || data == "undefined"){
                return "未定义";
            }else{
                return data;
            }
        }
 




        $(".dayamount").text(nullData(data.day[0].amount));      
        $(".daypnum").text(nullData(data.day[0].pnum));    
        $(".daytime").text(nullData(data.day[0].time));
        $(".weekamount").text(nullData(data.week[0].amount));   
        $(".weekpnum").text(nullData(data.week[0].pnum));  
        $(".weektime").text(nullData(data.week[0].time));  
        $(".monthamount").text(nullData(data.month[0].amount));
        $(".monthpnum").text(nullData(data.month[0].pnum));
        $(".monthtime").text(nullData(data.month[0].time));  
        $(".y2018amount").text(nullData(data.y2018[0].amount));
        $(".y2018pnum").text(nullData(data.y2018[0].pnum));
        $(".y2018time").text(nullData(data.y2018[0].time));  
        $(".y2017amount").text(nullData(data.y2017[0].amount));
        $(".y2017pnum").text(nullData(data.y2017[0].pnum));
        $(".y2017time").text(nullData(data.y2017[0].time));  
    }

    //最新活动列表
    $.get(_public_ + '/index.php/admin/vol/getActList', function (data) {
        data = JSON.parse(data);
        console.log(data);
   
        var hotActHtml = '';
        for(var i=0;i<6;i++){
            hotActHtml += '<tr>'
                +'<td align="left"><a href="javascript:;"> '+data.data[i].title+'</a></td>'
                +'<td>'+data.data[i].start_time.substring(0,10)+'</td>'
                +'</tr>';
        }
        $(".hot_act").html(hotActHtml);
        $(".userAll span").text(data.length);
    })

    //用户数量
    $.get(_public_ + '/index.php/admin/user/apiUserList', function (data) {
        data = JSON.parse(data);
        console.log(data);
        $(".userAll span").text(data.count);
    })

    //点赞数量
    $.get(_public_ + '/index.php/admin/user/apiUserList', function (data) {
        data = JSON.parse(data);
        console.log(data);
        $(".userAll span").text(data.count);
    })

    //外部图标
    $.get(iconUrl,function(data){
        $(".outIcons span").text(data.split(".icon-").length-1);
    })
})


