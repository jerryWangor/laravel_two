<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>修改密码</title>
        <!-- 引入标签库 -->
        <tagLib name="html" />
        <!-- 加载头部公共文件 -->
        <?php require_once(HEADER_URL); ?>
        <style>
            .form-item { margin: 20px 0 ;}
            .form-item span {color:#03A9F4; font-size: 12px;}
            .form-item label { display: inline-block; width: 100px; text-align: right;}
        </style>
    </head>
    <body>
        <!-- 主页面开始 -->
        <div id="user_add" class="user_add">
            <form id="user_form" action="" method="post">
                <div class="one-content">
                    <div class="form-item">
                        <label>用户名：</label>
                        <input type="text" data-required readonly name="account" id="account" value="<?php echo $userinfo['account']; ?>" />
                    </div>
                    <div class="form-item">
                        <label>旧密码：</label>
                        <input type="password" data-required name="old_password" id="old_password" value="" />
                        <span class="error_tips displayin"><span class="icontips floatl"></span><span class="content"></span></span>
                    </div>
                    <div class="form-item">
                        <label>新密码：</label>
                        <input type="password" data-required name="new_password" id="new_password" value="" />
                        <span class="error_tips displayin"><span class="icontips floatl"></span><span class="content"></span></span>
                    </div>
                    <div class="form-item">
                        <label>公司名称：</label>
                        <input type="text" data-required name="company" id="company" value="<?php echo $userinfo['company']; ?>" />
                        <span class="error_tips displayin"><span class="icontips floatl"></span><span class="content"></span></span>
                    </div>
                    <div class="form-item">
                        <label>送货地址：</label>
                        <input type="text" data-required name="address" id="address" value="<?php echo $userinfo['address']; ?>" />
                        <span class="error_tips displayin"><span class="icontips floatl"></span><span class="content"></span></span>
                    </div>
                    <div class="form-item">
                        <label>手机号码：</label>
                        <input type="text" data-required name="phone" id="phone" value="<?php echo $userinfo['phone']; ?>" />
                        <span class="error_tips displayin"><span class="icontips floatl"></span><span class="content"></span></span>
                    </div>
                </div>
                <div class="form-item">
                    <label></label>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" id="submit" name="submit" value="提交" class="btn btnLg green2 mt30">
                    <input type="reset" id="reset" name="reset" value="重置" class="btn btnLg blue2 mt30">
                </div>
            </form>
        </div>
    </body>
</html>