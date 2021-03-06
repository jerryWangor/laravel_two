/**
 * Created by wangjin on 2016/3/2.
 * 本页面主要是存放一些公共的函数
 */

    /**
     * 时间转换函数
     * @type {{CurTime: Function, DateToUnix: Function, UnixToDate: Function}}
     */
    var myTime = {
        /**
         * 当前时间戳
         * @return <int>        unix时间戳(秒)
         */
        CurTime: function(){
            return Date.parse(new Date())/1000;
        },
        /**
         * 日期 转换为 Unix时间戳
         * @param <string> 2014-01-01 20:20:20  日期格式
         * @return <int>        unix时间戳(秒)
         */
        DateToUnix: function(string) {
            var f = string.split(' ', 2);
            var d = (f[0] ? f[0] : '').split('-', 3);
            var t = (f[1] ? f[1] : '').split(':', 3);
            return (new Date(
                    parseInt(d[0], 10) || null,
                    (parseInt(d[1], 10) || 1) - 1,
                    parseInt(d[2], 10) || null,
                    parseInt(t[0], 10) || null,
                    parseInt(t[1], 10) || null,
                    parseInt(t[2], 10) || null
                )).getTime() / 1000;
        },
        /**
         * 时间戳转换日期
         * @param <int> unixTime    待时间戳(秒)
         * @param <bool> isFull    返回完整时间(Y-m-d 或者 Y-m-d H:i:s)
         * @param <int>  timeZone   时区
         */
        UnixToDate: function(unixTime, isFull, timeZone) {
            if (typeof (timeZone) == 'number')
            {
                unixTime = parseInt(unixTime) + parseInt(timeZone) * 60 * 60;
            }
            var time = new Date(unixTime * 1000);
            var ymdhis = "";
            ymdhis += time.getUTCFullYear() + "-";
            ymdhis += (time.getUTCMonth()+1) + "-";
            ymdhis += time.getUTCDate();
            if (isFull === true)
            {
                ymdhis += " " + parseInt(time.getUTCHours()) + ":";
                ymdhis += time.getUTCMinutes() + ":";
                ymdhis += time.getUTCSeconds();
            }
            return ymdhis;
        }
    };

    /**
     * 显示当前日期时间，每秒钟循环一次
     */
    function showTime() {
        var now = new Date();
        var nowTime = now.toLocaleString().split(/\s/g);
        var date = nowTime[0].replace(/\//g, '-');//截取日期
        var time = nowTime[1]; //截取时间
        var week = now.getDay(); //星期
        var hour = now.getHours(); //小时
        //判断星期几
        var weeks = ["日","一","二","三","四","五","六"];
        var getWeek = "星期" + weeks[week];
        var sc;
        //判断是AM or PM
        if(hour >= 0 && hour < 5) {
            sc = '凌晨';
        } else if(hour > 5 && hour <= 7) {
            sc = '早上';
        } else if(hour > 7 && hour <= 11) {
            sc = '上午';
        } else if(hour > 11 && hour <= 13) {
            sc = '中午';
        } else if(hour> 13 && hour <= 18) {
            sc = '下午';
        } else if(hour > 18 && hour <= 23) {
            sc = '晚上';
        }
        document.getElementById('now_time').innerHTML = "当前时间:" + date + "&nbsp;" + getWeek + "&nbsp;" + time;
        setTimeout('showTime()', 1000);
    }

    /**
     * 点击drag的时候隐藏side div
     */
    function hiddenside() {
        if($("#side").css("display") == "block") {
            $("#side").css("display", "none");
            $("#main").width($("#main").width() + $("#side").width());
        } else {
            $("#side").css("display", "block");
            $("#main").width($("#main").width() - $("#side").width());
        }
    }

    /**
     * 第一次打开后台主页的时候判断用户的浏览器宽和高，设置side和drag、main的高度
     * 如果浏览器缩小到一定程度，就限制最小的宽和高
     * 如果浏览器分辨率太大，就限制最大的宽和高
     */
    function setMainArea() {

        //设置body宽度
        var bodyW = $(window).width() < 1000 ? 1000 : $(window).width();
        var bodyH = $(window).height() < 540 ? 540 : $(window).height();
        var mainH = bodyH - $("#top").height() - $("#foot").height() - 1;
        $("body").width(bodyW);
        $("#main").width(bodyW - $("#side").width() - $("#drag").width());
        $("#side").height(mainH);
        $("#drag").height(mainH);
        $("#main").height(mainH);

    }

    /**
     * 刷新当前在线人数
     */
    function refleshOnlineNum() {
        $.post(
            '/getOnlineNum',
            {v : 1},
            function(result) {
                if(result.ret == 0) {
                    $("#now_online").html("在线人数:"+result.num);
                }
            },
            'json'
        );
    }

    /**
     * 刷新验证码
     */
    function refleshVerify() {
        //重载验证码
        var timenow = new Date().getTime();
        $("#verifyImg").attr("src", "verify/" + timenow);
    }

    /**
     * 比较排序
     */
    function createCompact(styType) {
        return function (object1, object2) {
            var value1 = object1[1];
            var value2 = object2[1];
            if (styType == "number") {
                //处理数字排序
                return value2 - value1;
            } else {
                if (value1 < value2) {
                    return -1;
                } else if (value1 > value2) {
                    return 1;
                } else {
                    return 0;
                }
            }
        }
    }

    /**
     * 短时间内显示提示信息函数
     * @param tips: 提示信息
     * @param time: 提示时间，秒为单位
     * @param document: 提示框对象
     */
    function showtips(tips, color, time, document) {
        if(time == 0) {
            document.empty().css("display", "none");
            return true;
        }
        document.css({"display": "block", "color": color, "border": "solid 2px "+color});
        document.append(tips);
        setTimeout(function() {showtips('', color, 0, document);}, time*1000);
    }

    /**
     * 在表单之前对每个表单元素进行验证
     */
    function checkForm(formId) {
        formId.find("input").each(function() { //循环判断表单元素
            var input_name = $(this).attr("name");
            if(input_name != null) { //如果input有name属性的话
                var input_value = $(this).val(); //这里的value就是每一个input的value值~
                switch(input_name) {
                    case "account":
                        if(!check_user(input_value)) {
                            alert("请输入正确的用户名!");
                            formFlag = false;
                            return false;
                        }
                        break;
                    case "password":
                        if(!check_pwd(input_value)) {
                            alert("请输入正确的密码!");
                            formFlag = false;
                            return false;
                        }
                    case "re_password":
                        if(!check_pwd(input_value)) {
                            alert("请输入正确的密码!");
                            formFlag = false;
                            return false;
                        } else {
                            // 判断和上面的密码是否一致
                            var password = $("#password").val();
                            if(input_value != password) {
                                alert("两次输入的密码不一致!");
                                formFlag = false;
                                return false;
                            }
                        }
                        break;
                    case "nickname":
                        if(!check_nickname(input_value)) {
                            alert("请输入正确的姓名!");
                            formFlag = false;
                            return false;
                        }
                        break;
                    case "company":
                        if(!input_value) {
                            alert("公司不能为空!");
                            formFlag = false;
                            return false;
                        }
                        break;
                    case "address":
                        if(!input_value) {
                            alert("地址不能为空!");
                            formFlag = false;
                            return false;
                        }
                        break;
                    case "qq":
                        if(!check_qqcard(input_value)) {
                            alert("请输入正确的QQ!");
                            formFlag = false;
                            return false;
                        }
                        break;
                    case "phone":
                        if(!check_telephone(input_value)) {
                            alert("请输入正确的手机号!");
                            formFlag = false;
                            return false;
                        }
                        break;
                }
                formFlag = true;
            }
        });
        return formFlag; //如果表单没通过验证就返回false
    }

    /**
     * 表单提交
     */
    function FormSubmit(formId, formType, keepTime) {
        
        var is_reload = true; // 出现错误是否刷新页面
        var is_url = true; // 是否跳转
        var is_showmsg = true; // 正确返回是否提示信息

        switch(formType) {
            case 'login':
                is_showmsg = false;                
                break;
            case 'register':
                is_reload = false;
                break;
        }

        $.ajax({
            type: 'POST',
            url: formId.attr("action"),
            data: formId.serialize(),
            dataType: 'json',
            async: false, //这里设置为同步，执行完ajax之后再return
            beforeSend:function() {
            },
            success:function(result) {
                if(result.code == 0) {
                    // 这里关系到是否跳转页面
                    if(is_showmsg) {
                        alert(result.msg);
                    }
                    if(is_url == true) {
                        window.location.href = result.url;
                    }
                } else {
                    alert(result.msg);
                    if(is_reload) {
                        window.location.reload();  
                    }
                }
            },
            complete:function() {
            },
            error:function() {
                alert('error');
            }
        });
        return ajaxFlag;
    }

    /**
     * ajax获取分页数据
     */
    function getPageData(page) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: 'ajaxlist',
            data: {'pageNum':page},
            dataType:'json',
            beforeSend:function() {
                $("<div id=\"ajaxLoadingTips\"></div>").css({ "position": "absolute", "left": "50%", "top": "50%", "margin-left": "-50px", "margin-top": "-12px", "width": "100px", "height": "25px", "background-color": "#dce9f9", "opacity": "0.8", "display": "block", "padding-top": "7px", "padding-left": "20px", "z-index": "90009" }).prependTo("body").append("<div class='loading'>loading...</div>");
            },
            success:function(result) {
                $("#usertable tbody").empty();
                $("#ajaxLoadingTips").remove();
                //if(result.total == 0) return;
                //total = result.total; //总记录数
                //pageSize = result.pageSize; //每页显示条数
                //curPage = page; //当前页
                //totalPage = result.totalPage; //总页数
                var tr = "";
                var list = result.list;
                $.each(list, function(index, array){ //遍历json数据列
                    tr += "<tr><td class='checkbox'><input class='checkbox' type='checkbox'/></td>";
                    $("#usertable thead tr th").each(function() {
                        if($(this).attr("id") != null) {
                            tr += "<td type='win_"+$(this).attr("id")+"'>"+array[$(this).attr("id")]+"</td>";
                        }
                    });
                    tr += "</tr>";
                });
                $("#usertable tbody").append(tr);
                //添加分页按钮
                //$("#pager").empty().append("<li class='floatl pager_left'><nobr><a href='javascript:history.go(0)'>刷新</a></nobr></li><li class='floatl pager_center'><nobr id='pager_center'></nobr></li><li class='floatl pager_right'><nobr>查找</nobr></li>");
                $("#pager").empty().append("<li class='floatl pager_left'><nobr><a href='javascript:history.go(0)'>刷新</a></nobr></li><li class='floatl pager_center'><nobr id='pager_center'>" + result.showpager + "</nobr></li><li class='floatl pager_right'><nobr>查找</nobr></li>");
                checkboxObj = {}; //把checkbox对象置为空
            },
            complete:function() { //生成分页条

            },
            error:function() {
                $("#ajaxLoadingTips").remove();
                alert("数据加载失败");
            }
        });
    }

    /**
     * 操作table,排序,hover变色和点击
     */
    function dotable() {

        $(document).ready(function() {

            var tableObject = $('.bordered'); //获取id为tableSort的table对象
            var tbHead = tableObject.children('thead'); //获取table对象下的thead
            var tbHeadTh = tbHead.find('tr th'); //获取thead下的tr下的th
            var tbBody = tableObject.children('tbody'); //获取table对象下的tbody
            var tbBodyTr = tbBody.find('tr'); //获取tbody下的tr,这里因为是加载完过后才生成的表格，所以不能提前赋值
            var sortIndex = -1; //默认没有排序

            tbHeadTh.each(function () {
                var thisIndex = tbHeadTh.index($(this)); //获取th所在的列号
                //给表态th增加鼠标位于上方时发生的事件
                $(this).mouseover(function () {
                    $(".bordered tbody tr").each(function () {//编列tbody下的tr
                        var tds = $(this).find("td"); //获取列号为参数index的td对象集合
                        $(tds[thisIndex]).addClass("tr_hover"); //给列号为参数index的td对象添加样式
                    });
                }).mouseout(function () {//给表头th增加鼠标离开时的事件
                    $(".bordered tbody tr").each(function () {
                        var tds = $(this).find("td");
                        $(tds[thisIndex]).removeClass("tr_hover"); //鼠标离开时移除td对象上的样式
                    });
                });

                //tbBodyTr = $(".bordered tbody tr");
                $(this).click(function () {//给当前表头th增加点击事件
                    if(thisIndex == 0) {
                        return;
                    }
                    var dataType = $(this).attr("type"); //点击时获取当前th的type属性值
                    var trsValue = new Array();            //先声明一维
                    for (var i = 0; i < $(".bordered tbody tr").length; i++) {
                        trsValue[i] = new Array();         //在声明二维
                        var tds = $($(".bordered tbody tr")[i]).find('td');
                        trsValue[i][1] = $(tds[$(this).index()]).html();
                        trsValue[i][2] = $($(".bordered tbody tr")[i]).html();
                        $($(".bordered tbody tr")[i]).html(""); //删除当前循环的数据，存放到trsValue[i]中
                    }
                    var len = trsValue.length;
                    if ($(this).index() == sortIndex) {
                        //如果已经排序了则直接倒序
                        trsValue.reverse();
                    } else {
                        trsValue.sort(createCompact(dataType)); //对trsValue数组中的元素进行排序
                    }
                    for (var i = 0; i < len; i++) {
                        $("tbody tr:eq(" + i + ")").html(trsValue[i][2]);
                    }

                    sortIndex = $(this).index();
                });
            });

            $(".bordered tbody tr").removeClass(); //先移除tbody下tr的所有css类
            //table中tbody中tr鼠标位于上面时添加颜色,离开时移除颜色
            $(document).on("mouseover", ".bordered tbody tr", function () {
                $(this).addClass("tr_hover");
            }).on("mouseout", ".bordered tbody tr", function () {
                $(this).removeClass("tr_hover");
            });

            /**
             * 每当用户点击tr中的checkbox的时候就加入到checkboxObj对象中，执行其他操作的时候会用到
             */
            $(document).on("click", ".bordered tbody tr", function() {
                var tds = $(this).find('td');
                var tr_index = $(".bordered tbody tr").index($(this));
                var inputCB = $(tds[0]).find("input");
                if(inputCB.attr("checked") == "checked") {
                    $(this).removeClass("tr_on");
                    inputCB.removeAttr("checked");
                    delete checkboxObj[tr_index];
                } else {
                    $(this).addClass("tr_on");
                    inputCB.attr("checked", "checked");
                    checkboxObj[tr_index] = new Object();
                    for(var i=1; i<tds.length; i++) {
                        checkboxObj[tr_index][$(tds[i]).attr("type")] = $(tds[i]).html();
                    }
                }
            });

            /**
             * 对checkbox进行点击事件
             */
            $(document).on("click", ".bordered tbody tr td:(.checkbox)", function() {
                var tds = $(this).siblings();
                var parent_tr = $(this).parent("tr");
                var tr_index = $(".bordered tbody tr").index(parent_tr);
                var inputCB = $(this).find("input");
                if($(this).find("input").attr('checked')) {
                    parent_tr.removeClass("tr_on");
                    checkboxObj[tr_index] = new Object();
                    for(var i=1; i<tds.length; i++) {
                        checkboxObj[tr_index][$(tds[i]).attr("type")] = $(tds[i]).html();
                    }
                    $(this).find("input").attr('checked', false);
                } else {
                    parent_tr.addClass("tr_on");
                    delete checkboxObj[tr_index];
                    $(this).find("input").attr('checked', true);
                }
            });
        });
    }

    /**
     * 显示弹出框
     */
    function show_dialog() {
        $("#dialog_div").dialog({
            title: aText,
            bgiframe: true,
            resizable: true,
            width: 800,
            height: 560,
            modal: true,
            close: function() {
                document.location.reload();
                $( this ).dialog( "close" );
            },
            buttons: {
                "确定": function() {
                    var IframeForm = $("#user_form");
                    //检查表单元素是否合法
                    var checkResult = checkForm(IframeForm);
                    if(checkResult == true) {
                        ajaxFlag = false;
                        if(FormSubmit(IframeForm, 'iframe', 1)) {
                            $( this ).dialog( "close" );
                        }
                    } else {
                        return checkResult;
                    }
                },
                "取消": function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    }

    /**
     * 检查table选择的行数
     * @returns {boolean}
     */
    function click_trnum() {
        var count = 0;
        for(var key in checkboxObj) {
            count++;
            tr_key = key;
        }
        if(count>1) {
            alert("只能选择一条数据进行修改!");
            return false;
        } else if(count==0) {
            alert("请选择一条数据进行修改!");
            return false;
        }
        return true;
    }

    
