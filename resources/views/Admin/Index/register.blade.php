<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>账号注册</title>
        <?php require_once(HEADER_URL); ?>
        <style>
            .login_text { padding:10px 12px 10px 26px; }
            
        </style>
	</head>
	<body style="background-color: #e9f1f3;">
        <div class="register">
            <div class="register_center">
                <div class="register_bg"></div>
                <div class="register_form">
                    <div class="register_step">
                        <ul>
                            <li>
						    <span class="ly_tabtxt"><i class="iconnum iconnum1"></i>填写注册信息</span>
                                <span class="ly_tabbg" id="step1" style="width: 100%;"></span>
                            </li>
                            <li>
                                <span class="ly_tabtxt"><i class="iconnum iconnum2"></i>等待审核</span>
                                <span class="ly_tabbg" id="step2"></span>
                            </li>
                            <li>
                                <span class="ly_tabtxt"><i class="iconnum iconnum3"></i>通过审核</span>
                                <span class="ly_tabbg" id="step3"></span>
                            </li>
                            <li>
                                <span class="ly_tabtxt"><i class="iconnum iconnum4"></i>正常登录</span>
                                <span class="ly_tabbg" id="step4"></span>
                            </li>
                        </ul>
                    </div>
                    <div class="register_tips">备注：XXX</div>
                    <div class="register_content displayon">
                        <form  class="submit_form" id="register_form" action="{{ URL('Admin/Index/checkregister') }}" method="post">
                            <table>
                                <tr>
                                    <th><i>*</i>账号：</th>
                                    <td>
                                        <span class="login_input" style="width:258px;"><input type="text" class="login_text" id="account" name="account" value=""></span>
                                    </td>
                                    <td class="error_tips"><span class="icontips floatl"></span><span class="content"></span></td>
                                </tr>
                                <tr>
                                    <th><i>*</i>密码：</th>
                                    <td>
                                        <span class="login_input" style="width:258px;"><input type="password" class="login_text" id="password" name="password" value=""></span>
                                    </td>
                                    <td class="error_tips"><span class="icontips floatl"></span><span class="content"></span></td>
                                </tr>
                                <tr>
                                    <th><i>*</i>确认密码：</th>
                                    <td>
                                        <span class="login_input" style="width:258px;"><input type="password" class="login_text" id="re_password" name="re_password" value=""></span>
                                    </td>
                                    <td class="error_tips"><span class="icontips floatl"></span><span class="content"></span></td>
                                </tr>
                                <tr>
                                    <th><i>*</i>姓名：</th>
                                    <td>
                                        <span class="login_input" style="width:258px;"><input type="text" class="login_text" id="nickname" name="nickname" value=""></span>
                                    </td>
                                    <td class="error_tips"><span class="icontips floatl"></span><span class="content"></span></td>
                                </tr>
                                <tr>
                                    <th><i>*</i>公司名字：</th>
                                    <td>
                                        <span class="login_input" style="width:258px;"><input type="text" class="login_text" id="company" name="company" value=""></span>
                                    </td>
                                    <td class="error_tips"><span class="icontips floatl"></span><span class="content"></span></td>
                                </tr>
                                <tr>
                                    <th><i>*</i>送货地址：</th>
                                    <td>
                                        <span class="login_input" style="width:258px;"><input type="text" class="login_text" id="address" name="address" value=""></span>
                                    </td>
                                    <td class="error_tips"><span class="icontips floatl"></span><span class="content"></span></td>
                                </tr>
                                <tr>
                                    <th><i>*</i>手机号码：</th>
                                    <td>
                                        <span class="login_input" style="width:258px;"><input type="text" class="login_text" id="phone" name="phone" value=""></span>
                                    </td>
                                    <td class="error_tips"><span class="icontips floatl"></span><span class="content"></span></td>
                                </tr>
                                <tr>
                                    <th><i>*</i>验证码：</th>
                                    <td>
                                        <span class="login_input" style="width:171px;"><input style="width:134px;" type="text" class="login_text floatl" id="verify" name="verify" value=""></span>
                                        <img src="{{ URL('Admin/Index/verify') }}" alt="点击刷新验证码" class="point" id="verifyImg" width="80" height="40" onclick="refleshVerify()">
                                    </td>
                                    <td class="error_tips"><span class="icontips floatl"></span><span class="content"></span></td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td><input type="submit" value="同意并注册" class="login_submit bluebtn"/></td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td style="text-align:right; "><a style=" color: #D8D8D8; font-weight:bold;" href="{{ URL('Admin/Index/login') }}">快速登录</a></td>
                                </tr>
                            </table>
                        </form>
                        <div class="register_wait displayoff" id="register_wait">
                            恭喜您！注册成功，敬请等待账号审核结果，稍后我们将发送短信到您的手机上。
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $('#birthday').datetimepicker({
                lang:"ch",           //语言选择中文
                format:"Y-m-d",      //格式化日期
                timepicker:false    //关闭时间选项
            });
            /**
             * 当DOM加载的时候开始执行
             */
            $(document).ready(function() {
                //注册页面当获取焦点的时候
                $(".register_content input").focus(function() {
                    var idname = $(this).attr("id");
                    var content = $(this).parents("tr").find(".content");
                    var icontips = $(this).parents("tr").find(".icontips");
                    icontips.removeClass("icontips1 icontips2 icontips3 icontips4").addClass("icontips1");
                    if(idname=="verify") { //如果是获取验证码
                        icontips.removeClass("icontips1 icontips2 icontips3 icontips4");
                        content.html("");
                        return false;
                    }
                    switch(idname) {
                        case "account":
                            content.html("字母或数字组成，长度4-17!");
                            break;
                        case "password":
                            content.html("字母或数字组成，长度6-16!");
                            break;
                        case "re_password":
                            content.html("字母或数字组成，长度6-16!");
                            break;
                        case "nickname":
                            content.html("2~6个汉字，中文名字!");
                            break;
                        case "company":
                            content.html("2-50个字");
                            break;
                        case "address":
                            content.html("2-50个字");
                            break;
                        case "phone":
                            content.html("您的电话号码!");
                            break;
                    }
                }).blur(function() {
                    var flag = true;
                    var idname = $(this).attr("id");
                    var value = trim($(this).val());
                    var content = $(this).parents("tr").find(".content");
                    var icontips = $(this).parents("tr").find(".icontips");
                    if(idname=="verify") { //如果是获取验证码
                        icontips.removeClass("icontips1 icontips2 icontips3 icontips4");
                        content.html("");
                        return false;
                    }
                    if(!value) {
                        icontips.removeClass("icontips1 icontips2 icontips3 icontips4").addClass("icontips2");
                        content.html("内容不能为空!");
                        return false;
                    }
                    switch(idname) {
                        case "account":
                            if(!check_user(value)) {
                                icontips.removeClass("icontips1 icontips2 icontips3 icontips4").addClass("icontips2");
                                content.html("账号格式不正确!");
                                flag = false;
                            } else {
                                // 检查账号是否已存在    
                                $.post(
                                    'checkuser',
                                    'username='+value,
                                    function(result) {
                                        if(result.code != 0) {
                                            icontips.removeClass("icontips1 icontips2 icontips3 icontips4").addClass("icontips2");
                                            content.html(result.msg);
                                            flag = false;
                                        } else {
                                            flag = true;
                                        }
                                    },
                                    'json'
                                );
                            }
                            break;
                        case "password":
                            if(!check_pwd(value)) {
                                icontips.removeClass("icontips1 icontips2 icontips3 icontips4").addClass("icontips2");
                                content.html("密码格式不正确!");
                                flag = false;
                            }
                            break;
                        case "re_password":
                            if(!check_pwd(value)) {
                                icontips.removeClass("icontips1 icontips2 icontips3 icontips4").addClass("icontips2");
                                content.html("密码格式不正确!");
                                flag = false;
                            } else {
                                // 判断和上面的密码是否一致
                                var password = $("#password").val();
                                if(value != password) {
                                    icontips.removeClass("icontips1 icontips2 icontips3 icontips4").addClass("icontips2");
                                    content.html("两次输入的密码不一致!");
                                    flag = false;
                                }
                            }
                            break;
                        case "nickname":
                            if(!check_nickname(value)) {
                                icontips.removeClass("icontips1 icontips2 icontips3 icontips4").addClass("icontips2");
                                content.html("姓名格式不正确!");
                                flag = false;
                            }
                            break;
                        case "qq":
                            if(!check_qqcard(value)) {
                                icontips.removeClass("icontips1 icontips2 icontips3 icontips4").addClass("icontips2");
                                content.html("QQ号格式不正确!");
                                flag = false;
                            }
                            break;
                        case "phone":
                            if(!check_telephone(value)) {
                                icontips.removeClass("icontips1 icontips2 icontips3 icontips4").addClass("icontips2");
                                content.html("电话号码格式不正确!");
                                flag = false;
                            }
                            break;
                    }
                    if(flag == true) {
                        icontips.removeClass("icontips1 icontips2 icontips3 icontips4").addClass("icontips3");
                        content.html("");
                    }
                });
            });
        </script>
    </body>
</html>
