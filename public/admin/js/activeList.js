layui.use(['form','layer','laydate','table','laytpl'],function(){
    var form = layui.form,
        layer = parent.layer === undefined ? layui.layer : top.layer,
        $ = layui.jquery,
        laydate = layui.laydate,
        laytpl = layui.laytpl,
        table = layui.table;

    //活动列表
    var tableIns = table.render({
        elem: '#activeList',
        url: _public_ + '/index/Activitys/apiGetList',
        response: {
            statusCode:200//规定成功的状态码，默认：0
        },
        cellMinWidth : 95,
        page : true,
        height : "full-125",
        limit : 20,
        limits : [10,15,20,25],
        id : "activeListTable",
        cols : [[
            {type: "checkbox", fixed:"left"},
            { field: 'id', title: '编号', align: "center", width: 80},
            { field: 'oid', title: '义工名称', align: "center"},
            { field: 'uid', title: '性别', align: 'center', width: 60},
            { field: 'title', title: '义工平台头像',  align:'center'},
            { field: 'img', title: '职责', align: 'center',width:60},
            { field: 'create_time', title: '身份证号码', align: 'center' },
            { field: 'org', title: '联系方式', align: 'center' ,templet: function(d){
                    return d.id
                }},
            { field: 'org', title: '义工编码', align: 'center' ,templet: function(d){
                    return d.name
                }},
            // { field: 'status', title: '审核', align: 'center', templet: "#checkStatus" },
            {title: '操作', templet:'#activeListBar',align:"center"}
        ]]

    });

    // //是否置顶
    // form.on('switch(activityTop)', function(data){
    //     var index = layer.msg('修改中，请稍候',{icon: 16,time:false,shade:0.8});
    //     setTimeout(function(){
    //         layer.close(index);
    //         if(data.elem.checked){
    //             layer.msg("置顶成功！");
    //         }else{
    //             layer.msg("取消置顶成功！");
    //         }
    //     },500);
    // })
    //
    // //搜索
    // $('.search_btn').on('click', function () {
    //     var type = $(this).data('type');
    //     active[type] ? active[type].call(this) : '';
    //
    // });
    // // 点击获取数据
    // var active = {
    //     reload: function () {
    //         var name = $('.name').val();
    //         var idCard = $('.idCard').val();
    //         var uid = $('.uid').val();
    //         var mobile = $('.mobile').val();
    //         if ($('.name').val() || $('.idCard').val() || $('.uid').val() || $('.mobile').val()) {
    //             var index = layer.msg('搜索中，请稍候...', { icon: 16, time: false, shade: 0 });
    //             setTimeout(function () {
    //                 table.reload('volListTable', {
    //                     page: {
    //                 curr: 1 //重新从第 1 页开始
    //             },
    //                     where: {
    //                         name: name,
    //                         idCard: idCard,
    //                         uid: uid,
    //                         mobile: mobile
    //                     }
    //                 });
    //                 layer.close(index);
    //             }, 800);
    //         } else {
    //             layer.msg("请输入搜索的内容");
    //         }
    //     },
    // };
    //
    //
    //添加活动
    function addNews(edit){
        var index = layui.layer.open({
            title : "添加活动",
            type : 2,
            content : _admin_+'/activitys/actAdd',
            success : function(layero, index){
                var body = layui.layer.getChildFrame('body', index);
                if(edit){
                    body.find(".newsName").val(edit.newsName);
                    body.find(".abstract").val(edit.abstract);
                    body.find(".thumbImg").attr("src",edit.newsImg);
                    body.find("#news_content").val(edit.content);
                    body.find(".newsStatus select").val(edit.newsStatus);
                    body.find(".openness input[name='openness'][title='"+edit.newsLook+"']").prop("checked","checked");
                    body.find(".newsTop input[name='newsTop']").prop("checked",edit.newsTop);
                    form.render();
                }
                setTimeout(function(){
                    layui.layer.tips('点击此处返回活动列表', '.layui-layer-setwin .layui-layer-close', {
                        tips: 3
                    });
                },500)
            }
        });
        layui.layer.full(index);
        //改变窗口大小时，重置弹窗的宽高，防止超出可视区域（如F12调出debug的操作）
        $(window).on("resize",function(){
            layui.layer.full(index);
        })
    }
    $(".addNews_btn").click(function(){
        addNews();
    });
    //
    // //批量删除
    // $(".delAll_btn").click(function(){
    //     var checkStatus = table.checkStatus('volListTable'),
    //         data = checkStatus.data,
    //         id = [];
    //     if(data.length > 0) {
    //         for (var i in data) {
    //             id.push(data[i].id);
    //
    //         }
    //         layer.confirm('确定删除选中的活动？', {icon: 3, title: '提示信息'}, function (index) {
    //             // $.get("删除活动接口",{
    //             //     id : id  //将需要删除的活动id作为参数传入
    //             // },function(data){
    //             tableIns.reload();
    //             layer.close(index);
    //             // })
    //         })
    //     }else{
    //         layer.msg("请选择需要删除的活动");
    //     }
    // })
    //
    //列表操作
    table.on('tool(activeList)', function(obj){
        var layEvent = obj.event,
            data = obj.data;

        if(layEvent === 'edit'){ //编辑
            addNews(data);
        } else if(layEvent === 'del'){ //删除
            layer.confirm('确定删除此活动？',{icon:3, title:'提示信息'},function(index){
                // $.get("删除活动接口",{
                //     id : data.id  //将需要删除的id作为参数传入
                // },function(data){
                    tableIns.reload();
                    layer.close(index);
                // })
            });
        } else if (layEvent === '') {

        }
    });

});