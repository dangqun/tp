(function(){
  Date.prototype.Format = function (fmt) { //author: meizz 
    var cNumber=["日","一","二","三","四","五","六"];
    var o = {
      "M+": this.getMonth() + 1, //月份 
      "d+": this.getDate(), //日 
      "h+": this.getHours(), //小时 
      "m+": this.getMinutes(), //分 
      "s+": this.getSeconds(), //秒
      'w+': cNumber[this.getUTCDay()], //星期
      "q+": Math.floor((this.getMonth() + 3) / 3), //季度 
      "S": this.getMilliseconds() //毫秒 
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
  }

  function getGet(hash){
    var r={};
    var arr=hash.split("?");
    if(arr.length>1){
      arr=arr[1].split("&");
    }else{
      arr=[];
    }
    
    for(var i=0;i<arr.length;i++){
      var s=arr[i].split("=");
      
      if(s.length>0 && s[0]!="" && s[1]!=""){
        if(s.length==1){
          s[1]="";
        }
        
        r[s[0]] = s[1];
      }
    }
    
    return r;
  }
  window.getGet=getGet;

})();

//接口ajax请求
function Fnajax(u,param,callback){
  var requestUrl=u;
  
  $.ajax({
    url:requestUrl,
    type:"POST",
    async:true,
    data:param,
    dataType:"json",
    success:function(data){
      if(data.code==401){
        location.href="?ctl=volunteer&act=login"
      }
      callback(data);
    }
  });
}



function loadJS( url, callback ){
  var script = document.createElement('script'),
  fn = callback || function(){};
  script.type = 'text/javascript';
  //IE
  if(script.readyState){
    script.onreadystatechange = function(){
      if( script.readyState == 'loaded' || script.readyState == 'complete' ){
        script.onreadystatechange = null;
        fn();
      }
    };
  }else{
    //其他浏览器
    script.onload = function(){
      fn();
    };
  }
  script.src = url;
  document.getElementsByTagName('head')[0].appendChild(script);
}


(function YdbOnline(){
  $().ready(function(){
    loadJS("https://static.ydbimg.com/API/YdbOnline.js",function(){
      var YDB = new YDBOBJ();
      YDB.SetHeadBar("1")
    })
  })
})();

 




 