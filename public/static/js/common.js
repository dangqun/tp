(function ($) {
    function getNow(s) {
        return s < 10 ? '0' + s: s;
    }
    var myDate = new Date;
    var date_year = myDate.getFullYear(); //获取当前年
    var date_mon = getNow(myDate.getMonth() + 1); //获取当前月
    var date_d = getNow(myDate.getDate()); //获取当前日
    var date_h = getNow(myDate.getHours());//获取当前小时数(0-23)
    var date_m = getNow(myDate.getMinutes());//获取当前分钟数(0-59)
    var date_s = getNow(myDate.getSeconds());//获取当前秒
    var date_week=myDate.getDay();
    var date_weeks = ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"];
    var date_w = date_weeks[date_week];
    var dade_time = date_year + "-" + date_mon + "-" + date_d + " " + date_h + ":" + date_m;
    $.fn.time = {
        date_year:date_year,   //获取当前年
        date_mon:date_mon,   //获取当前月
        date_d:date_d,          //获取当前日
        date_h:date_h,         //获取当前小时数(0-23)
        date_m:date_m,       //获取当前分钟数(0-59)
        date_s:date_s,       //获取当前秒
        date_w:date_w,     //获取当前周
        dade_time:dade_time
    };

    /*
     *上传图片预览
     * var files = $(this)[0].files[0];    //获取文件信息（this为上传图片input的id）
     * var imgId=$("#img");                //图片id
     * inputId                             //传值DataURL(base64)给input的val
     */
    $.fn.upload_img = function (files,imgId,inputId) {
        var file = files;    //获取文件信息
        if (!/image\/\w+/.test(file.type)) {
            layer.open({content: '请确保文件为图像类型',time: 2});
            return false;
        } else {
            var fileSize = file.size;
            var size = fileSize / 1024;
            //这里限制大小(1000为1M)
            if (size > 10000) {
                layer.open({content: '附件不能大于10M',time: 2});
                return false;
            }
        }
        if (file) {
            var reader = new FileReader();  //调用FileReader
            reader.onload = function (evt) {   //读取操作完成时触发。
                imgId.attr('src', evt.target.result)  //将img标签的src绑定为DataURL
                inputId.val(evt.target.result)  //将input的值绑定为DataURL
            }
            reader.readAsDataURL(file); //将文件读取为 DataURL(base64)
        } else {
            alert("上传失败");
        }
    }

    /*
     *获取url参数
     * console.log(getQueryString("type"));
     */
    $.fn.getQueryString = function (name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
        var reg_rewrite = new RegExp("(^|/)" + name + "/([^/]*)(/|$)", "i");
        var r = window.location.search.substr(1).match(reg);
        var q = window.location.pathname.substr(1).match(reg_rewrite);
        if (r != null) {
            return unescape(r[2]);
        } else if (q != null) {
            return unescape(q[2]);
        } else {
            return null;
        }
    }
    /*
     * 判断是否有数据为空；必须是input中。而且加入data-name属性，data-name内容为提示的名称
     */
    $.fn.dataName = function () {
        var b=$("*[data-name]");
        var s=b.length;
        for(var i=0;i<s;i++){
            var v=b.eq(i).val();
            if(v==""|| v==null || v==undefined){
                var attr =v=b.eq(i).attr("data-name");
                layer.open({content: attr+"不能为空",time: 1});
                return false;
            }
        }
    }
})(jQuery);