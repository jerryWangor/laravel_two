<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>主页面</title>
        <!-- 引入标签库 -->
        <tagLib name="html" />
        <!-- 加载头部公共文件 -->
        <?php require_once(HEADER_URL); ?>
        <script type="text/javascript">
            dotable();
        </script>
    </head>
    <body>
        <!-- 主页面开始 -->
        <div id="main_body" class="main_body">
            <div class="main_title">
                <form name="search_form" class="search_form" action="" method="get">
                    <label>请输入昵称</label>
                    <input name="nickname" id="nickname" value="<?php echo isset($_GET['nickname']) ? $_GET['nickname'] : '';?>"/>
                    <input type="submit" class="bluebtn btn" name="submit" value="提交">
                </form>
            </div>
            <div class="main_button" id="main_button">
                <div class="action_btn floatl"><b class="btn_icon btn_icon_add"></b><a id="add" href="{{ URL('Admin/User/add') }}">添加用户</a></div>
            </div>
            <div class="userList">
                <table id="usertable" class="bordered">
                    <thead>
                        <tr>
                            <th><input class="checkbox" type="checkbox"/></th>
                            <th><nobr>客户id</nobr></th>
                            <th><nobr>客户账号</nobr></th>
                            <th><nobr>姓名</nobr></th>
                            <th><nobr>公司</nobr></th>
                            <th><nobr>地址</nobr></th>
                            <th><nobr>电话号码</nobr></th>
                            <th><nobr>邮政编码</nobr></th>
                            <th><nobr>QQ</nobr></th>
                            <th><nobr>状态</nobr></th>
                            <th><nobr>会员级别</nobr></th>
                            <!-- <th><nobr>最后登录时间</nobr></th> -->
                            <th><nobr>所属角色组</nobr></th>
                            <th><nobr>注册时间</nobr></th>
                            <th><nobr>操作</nobr></th>
                        </tr>
                    </thead>
                    <tbody class="main">
                        <?php
                            foreach ($data as $key => $value) {

                                // 操作字符串
                                $edit = "<a href='".URL('Admin/User/add?uid='.$value['uid'])."'>编辑</a>";
                                $reset = "<a onclick=\"return confirm('请确认');\" href='".URL('Admin/User/reset?uid='.$value['uid'])."'>重置密码</a>";
                                $enable_stats = $value['status']==0 ? 1 : 0;
                                $enable_str = $value['status']==0 ? '启用' : '禁用';
                                $enable = "<a onclick=\"return confirm('请确认');\" href='".URL('Admin/User/enable?uid='.$value['uid'].'&status='.$enable_stats)."'>$enable_str</a>";
                                // 审核账号
                                $shenhe = $status = '';
                                if($value['status'] == 0) {
                                    $status = '已禁用';
                                } elseif($value['status'] == 1) {
                                    $status = '正常';
                                } else {
                                    $status = '待审核';
                                    $shenhe = "<a onclick=\"return confirm('请确认');\" href='".URL('Admin/User/shenhe?uid='.$value['uid'])."'>审核通过</a>";    
                                }
                                $caozuo = "<td>$edit | $reset | $enable | $shenhe</td>";

                                // 会员级别
                                $viplevel = $value['viplevel'].'级';
                                $lastlogintime = date('Y-m-d H:i:s', $value['lastlogintime']);
                                echo "<tr>";
                                echo "<td><input class='checkbox' type='checkbox'/></td>";
                                echo "<td>$value[uid]</td>";
                                echo "<td>$value[account]</td>";
                                echo "<td>$value[nickname]</td>";
                                echo "<td>$value[company]</td>";
                                echo "<td>$value[address]</td>";
                                echo "<td>$value[phone]</td>";
                                echo "<td>$value[postcode]</td>";
                                echo "<td>$value[qq]</td>";
                                echo "<td>$status</td>";
                                echo "<td>$viplevel</td>";
                                // echo "<td>$lastlogintime</td>";
                                echo "<td>$value[bname]</td>";
                                echo "<td>$value[createtime]</td>";
                                echo $caozuo;
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
                <ul class="pager" id="pager"><?php echo $page_str; ?></ul>
            </div>
        </div>
    </body>
</html>