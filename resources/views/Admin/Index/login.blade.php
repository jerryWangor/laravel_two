<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>后台登录</title>
        <?php require_once(HEADER_URL); ?>
        <style type="text/css">
            html { width: 100%; height:100%; overflow:hidden; }
            body {
                width: 100%;
                height:100%;
                font-family: 'Open Sans', sans-serif;
                background: #092756;
                background: -moz-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%),-moz-linear-gradient(top,  rgba(57,173,219,.25) 0%, rgba(42,60,87,.4) 100%), -moz-linear-gradient(-45deg,  #670d10 0%, #092756 100%);
                background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), -webkit-linear-gradient(top,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), -webkit-linear-gradient(-45deg,  #670d10 0%,#092756 100%);
                background: -o-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), -o-linear-gradient(top,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), -o-linear-gradient(-45deg,  #670d10 0%,#092756 100%);
                background: -ms-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), -ms-linear-gradient(top,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), -ms-linear-gradient(-45deg,  #670d10 0%,#092756 100%);
                background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), linear-gradient(to bottom,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), linear-gradient(135deg,  #670d10 0%,#092756 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3E1D6D', endColorstr='#092756',GradientType=1 );
            }
        </style>
	</head>
	<body>
        <!--main-->
        <div class="login">
            <div class="login_center">
                <h2 class="login_head">Login</h2>
                <div class="login_error" style="display: none;">
                    <span id="error_tip">123</span>
                </div>
                <div class="login_form">
                    <form class="submit_form" id="login_form" method="post" action="{{ URL('Admin/Index/checklogin') }}">
                        <ul class="login_list">
                            <li>
                                <span class="login_input" style="width: 258px;">
                                    <input type="text" tabindex="1" class="login_text" id="account" name="account" value="" placeholder="请输入用户名" />
                                </span>
                            </li>
                            <li>
                                <span class="login_input" style="width: 258px;">
                                    <input type="password" tabindex="1" class="login_text" id="password" name="password" value="" placeholder="请输入密码" />
                                </span>
                            </li>
                            <li id="show_verify" style="display: <?php if($checkVerify) { echo 'block';} else {echo 'none';} ?>">
                                <span class="login_input" style="width: 170px;">
                                    <input type="text" tabindex="2" style="width:132px;" class="login_text" id="verify" name="verify" value="" placeholder="请输入验证码" />
                                </span>
                                <img src="{{ URL('Admin/Index/verify') }}" alt="点击刷新验证码" class="point" id="verifyImg" width="80" height="40" onclick="refleshVerify()">
                            </li>
                            <li>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" value="登录" class="login_submit bluebtn" />
                            </li>
                            <li style="text-align:right;">
                                <a style=" color: #C0B8B8; font-weight:bold;" href="{{ URL('Admin/Index/register') }}">快速注册</a>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>

    </body>
</html>
