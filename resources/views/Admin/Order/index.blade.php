<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>订单管理</title>
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
                    <label>请输入订单号</label>
                    <input name="order_id" id="order_id" value="<?php echo isset($_GET['order_id']) ? $_GET['order_id'] : '';?>"/>
                    <input type="submit" class="bluebtn btn" name="submit" value="提交">
                </form>
            </div>
            <!-- <div class="main_button" id="main_button">
                <div class="action_btn floatl"><b class="btn_icon btn_icon_add"></b><a id="add" href="{{ URL('Admin/Rules/add') }}">添加权限</a></div>
            </div> -->
            <div class="userList">
                <table id="usertable" class="bordered">
                    <thead>
                        <tr>
                            <th><input class="checkbox" type="checkbox"/></th>
                            <th><nobr>订单号</nobr></th>
                            <th><nobr>订单状态</nobr></th>
                            <th><nobr>商品信息</nobr></th>
                            <th><nobr>商品总价</nobr></th>
                            <th><nobr>创建时间</nobr></th>
                            <th><nobr>付款状态</nobr></th>
                            <th><nobr>付款时间</nobr></th>
                            <th><nobr>配送状态</nobr></th>
                            <th><nobr>配送时间</nobr></th>
                            <th><nobr>收货人姓名</nobr></th>
                            <th><nobr>收货人地址</nobr></th>
                            <th><nobr>操作</nobr></th>
                        </tr>
                    </thead>
                    <tbody class="main">
                        <?php
                            foreach ($data as $order_id => $value) {

                                // 操作字符串
                                if($value['send_status']==2 && $value['pay_status'] == 1) {
                                    $edit = '订单已完成';    
                                } elseif($value['status'] == 2) {
                                    $edit = '订单已取消';    
                                } else {
                                    $edit = "<a href='".URL('Admin/Order/edit?order_id='.$order_id)."'>编辑</a>";
                                }
                                
                                $caozuo = "<td>$edit</td>";

                                // 配送状态
                                if($value['send_status'] == 0) {
                                    $send_status = '未出发';
                                } elseif($value['send_status'] == 1) {
                                    $send_status = '送货中';
                                } else {
                                    $send_status = '已签收';
                                }

                                // 商品信息
                                $iteminfo = mb_substr($value['iteminfo'], 0, 20);

                                echo "<tr>";
                                echo "<td><input class='checkbox' type='checkbox'/></td>";
                                echo "<td>$order_id</td>";
                                echo "<td>".(($value['status'] == 1) ? '正常' : '已取消')."</td>";
                                echo "<td title='{$value['iteminfo']}'>$iteminfo</td>";
                                echo "<td>$value[sum_amount]</td>";
                                echo "<td>$value[add_time]</td>";
                                echo "<td>".(($value['pay_status'] == 0) ? '未付款' : '已付款')."</td>";
                                echo "<td>$value[pay_time]</td>";
                                echo "<td>$send_status</td>";
                                echo "<td>$value[send_time]</td>";
                                echo "<td>$value[g_name]</td>";
                                echo "<td>$value[g_address]</td>";
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