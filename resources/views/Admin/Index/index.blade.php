<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" id="mainhtml">
	<head>
		<title>在线下单系统</title>
        <?php require_once(HEADER_URL); ?>
        <script type="text/javascript">
            $(document).ready(function() {
                showTime(); //显示区域时间
                setMainArea(); //初始化body宽和高
            });
        </script>
	</head>
    <body id="mainbody">
        <!-- 头部 -->
        <div id="top" class="top">
            <div id="top_logo" class="top_logo floatl"></div>
            <div id="top_modulelist" class="top_modulelist floatl">
                <ul>

                </ul>
            </div>
            <div id="top_tips" class="top_tips floatr">
                <ul>
                    <li style="border-left:0px;">欢迎您！{{ Session::get('_AUTH_USER_NICKNAME') }}</li>
                    <li><a href="/Admin/User/changepwd" title="修改密码" target="iframe-main">修改个人信息</a></li>
                    <li><a href="/exit" title="注销本次登陆">安全退出</a></li>
                </ul>
                <div id="top_sysinfo" class="top_sysinfo">
                    <span id="now_time"></span>
                    <span id="now_online" onclick="refleshOnlineNum()" title="点击刷新" style="cursor: pointer;">在线人数:{{ $onlineNum }}</span>
                </div>
            </div>
        </div>
        <!-- 侧边菜单栏 -->
        <div id="side" class="side floatl">
            <div id="side_user" class="side_user" style="display: none;"></div>
            <div id="side_tips" class="side_tips"></div>
            <div class="sideMenu" id="sideMenu">
                <ul>
                    <li id="admin" class="displayon">
                        <ul>
                            @foreach( $sidedata as $module)
                                <li><div class="title on">{{ $module['name'] }}</div></li>
                                <li class="menulist">
                                    <ul>
                                        @foreach( $module['controller'] as $controller)
                                            <li><a href="{{ URL($controller['url']) }}" target="iframe-main">{{ $controller['name'] }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </li>

                </ul>
            </div>
        </div>

        <!-- 侧边条 -->
        <div id="drag" class="floatl drag">
            <img class="point" id="dragshow" class="dragshow" onclick="hiddenside()"></img>
        </div>
        <!-- 功能主区域 -->
        <div id="main" class="main floatl">
            
            <iframe id="iframe-main" name="iframe-main" class="iframe-main" frameborder=0 noresize="noresize" marginwidth=0 marginheight=0 src="{{ URL('Admin/Shop/index') }}">

            </iframe>
        </div>
        <!-- 底部 -->
        <div id="foot" class="foot">
            版权所有
        </div>
    </body>
</html>