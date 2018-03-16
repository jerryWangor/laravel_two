<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>添加用户</title>
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
                        <label><i>*</i>角色组：</label>
                        <select name="groupids">
                            <?php 
                            foreach ($group_data as $key => $value) {
                                $selected = (isset($data['groupids']) && $data['groupids'] == $value['id']) ? 'selected' : '';
                                echo "<option value='$value[id]' $selected>$value[name]</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-item">
                        <label><i>*</i>用户名：</label>
                        <input type="text" data-required name="account" id="account" value="<?php echo isset($data['account']) ? $data['account'] : ''; ?>" />
                        <span class="error_tips displayin"><span class="icontips floatl"></span><span class="content"></span></span>
                    </div>
                    <?php if(!isset($data['password'])) { ?>
                    <div class="form-item">
                        <label><i>*</i>密码：</label>
                        <input type="password" data-required name="password" id="password" value="<?php echo isset($data['password']) ? $data['password'] : ''; ?>" />
                        <span class="error_tips displayin"><span class="icontips floatl"></span><span class="content"></span></span>
                    </div>
                    <?php } ?>
                    <div class="form-item">
                        <label><i>*</i>中文名：</label>
                        <input type="text" data-required name="nickname" id="nickname" value="<?php echo isset($data['nickname']) ? $data['nickname'] : ''; ?>" />
                        <span class="error_tips displayin"><span class="icontips floatl"></span><span class="content"></span></span>
                    </div>
                    <div class="form-item">
                        <label><i>*</i>公司：</label>
                        <input type="text" data-required name="company" id="company" value="<?php echo isset($data['company']) ? $data['company'] : ''; ?>" />
                        <span class="error_tips displayin"><span class="icontips floatl"></span><span class="content"></span></span>
                    </div>
                    <div class="form-item">
                        <label><i>*</i>地址：</label>
                        <input type="text" data-required name="address" id="address" value="<?php echo isset($data['address']) ? $data['address'] : ''; ?>" />
                        <span class="error_tips displayin"><span class="icontips floatl"></span><span class="content"></span></span>
                    </div>
                    <div class="form-item">
                        <label><i>*</i>手机号：</label>
                        <input type="text" data-required name="phone" id="phone" value="<?php echo isset($data['phone']) ? $data['phone'] : ''; ?>" />
                        <span class="error_tips displayin"><span class="icontips floatl"></span><span class="content"></span></span>
                    </div>
                    <div class="form-item">
                        <label>QQ：</label>
                        <input type="text" data-required name="qq" id="qq" value="<?php echo isset($data['qq']) ? $data['qq'] : ''; ?>" />
                        <span class="error_tips displayin"><span class="icontips floatl"></span><span class="content"></span></span>
                    </div>
                    <div class="form-item">
                        <label><i>*</i>VIP级别：</label>
                        <select name="viplevel">
                            <?php 
                            foreach ($vip_data as $key => $value) {
                                $selected = (isset($data['viplevel']) && $data['viplevel'] == $value['id']) ? 'selected' : '';
                                echo "<option value='$value[id]' $selected>$value[vipname]</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-item">
                        <label>状态：</label>
                        <input type="radio" id="status" name="status" value=1 <?php echo (isset($data['status']) && $data['status']==1) || !isset($data['status']) ? 'checked' : ''; ?>>启用
                        <input type="radio" id="status" name="status" value=0 <?php echo (isset($data['status']) && $data['status']==0) ? 'checked' : ''; ?>>禁用
                        <input type="radio" id="status" name="status" value=2 <?php echo (isset($data['status']) && $data['status']==2) ? 'checked' : ''; ?>>待审核
                    </div>
                </div>
                <div class="form-item">
                    <label></label>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="creater" value="<?php echo isset($data['creater']) ? $data['creater'] : ''; ?>">
                    <input type="submit" id="submit" name="submit" value="提交" class="btn btnLg green2 mt30">
                    <input type="reset" id="reset" name="reset" value="重置" class="btn btnLg blue2 mt30">
                </div>
            </form>
        </div>
    </body>
</html>