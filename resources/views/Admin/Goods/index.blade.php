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
                    <label>请输入菜品名</label>
                    <input name="goods_name" id="goods_name" value="<?php echo isset($_GET['goods_name']) ? $_GET['goods_name'] : '';?>"/>
                    <label>--</label>
                    <label>请选择菜品类型</label>
                    <select name="type" style="height:25px;">
                        <?php
                            echo "<option value='0'>--全部--</option>";
                            foreach ($type_info as $id => $name) {
                                $selected = (isset($_GET['type']) && $_GET['type'] == $id) ? 'selected' : '';
                                echo "<option value='$id' $selected>$name</option>";
                            }
                        ?>
                    </select>
                    <input type="submit" class="bluebtn btn" name="submit" value="提交">
                </form>
            </div>
            <div class="main_button" id="main_button">
                <div class="action_btn floatl"><b class="btn_icon btn_icon_add"></b><a id="add" href="{{ URL('Admin/Goods/add') }}">添加商品</a></div>
                <div class="action_btn floatl"><b class="btn_icon btn_icon_add"></b><a id="addtype" href="{{ URL('Admin/Goods/addtype') }}">添加商品类型</a></div>
                <div class="action_btn floatl"><b class="btn_icon btn_icon_add"></b><a id="type" href="{{ URL('Admin/Goods/type') }}">商品类型管理</a></div>
            </div>
            <div class="userList">
                <table id="usertable" class="bordered">
                    <thead>
                        <tr>
                            <th><input class="checkbox" type="checkbox"/></th>
                            <th><nobr>商品ID</nobr></th>
                            <th><nobr>商品名称</nobr></th>
                            <th><nobr>商品logo</nobr></th>
                            <th><nobr>商品价格</nobr></th>
                            <th><nobr>商品类型</nobr></th>
                            <th><nobr>商品描述</nobr></th>
                            <th><nobr>是否上架</nobr></th>
                            <th><nobr>是否删除</nobr></th>
                            <th><nobr>创建时间</nobr></th>
                            <th><nobr>操作</nobr></th>
                        </tr>
                    </thead>
                    <tbody class="main">
                        <?php
                            foreach ($data as $key => $value) {

                                // 操作字符串
                                $edit = "<a href='".URL('Admin/Goods/add?id='.$value['id'])."'>编辑</a>";
                                $delete = $value['is_delete']==0 ? "<a href='".URL('Admin/Goods/delete?id='.$value['id'])."'>删除</a>" : '';
                                $caozuo = "<td>$edit | $delete</td>";

                                echo "<tr>";
                                echo "<td><input class='checkbox' type='checkbox'/></td>";
                                echo "<td>$value[id]</td>";
                                echo "<td>$value[goods_name]</td>";
                                echo "<td>$value[logo]</td>";
                                echo "<td>$value[price]</td>";
                                echo "<td>".$type_info[$value['type']]."</td>";
                                echo "<td>$value[goods_desc]</td>";
                                echo "<td>".(($value['is_on_sale'] == 1) ? '已上架' : '未上架')."</td>";
                                echo "<td>".(($value['is_delete'] == 1) ? '已删除' : '正常')."</td>";
                                echo "<td>".date('Y-m-d H:i:s', $value['addtime'])."</td>";
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