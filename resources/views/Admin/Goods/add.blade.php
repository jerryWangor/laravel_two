<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>添加商品</title>
        <!-- 引入标签库 -->
        <tagLib name="html" />
        <!-- 加载头部公共文件 -->
        <?php require_once(HEADER_URL); ?>
        <script type="text/javascript" src="<?php echo asset('/js/ajaxfileupload.js') ?>"></script>
        <style>
            .form-item { margin: 20px 0 ;}
            .form-item span {color:#03A9F4; font-size: 12px;}
            .form-item label { display: inline-block; width: 100px; text-align: right;}
            .form-item img { display: inline-block; width: 150px; height: 150px; }
        </style>
    </head>
    <body>
        <!-- 主页面开始 -->
        <div id="user_add" class="user_add">
            <form id="user_form" action="" method="post">
                <div class="one-content">
                    <div class="form-item">
                        <label>商品名字：</label>
                        <input type="text" data-required name="goods_name" id="goods_name" value="<?php echo isset($data['goods_name']) ? $data['goods_name'] : ''; ?>" />
                        <span class="error_tips displayin"><span class="icontips floatl"></span><span class="content"></span></span>
                    </div>
                    <div class="form-item">
                        <label>商品图片：</label>
                        <input name="logo_file" id="logo_file" type="file" onchange="handle_file(this.value)" >
                        <input type="hidden" data-required name="logo" id="logo" value="<?php echo isset($data['logo']) ? $data['logo'] : ''; ?>" />
                        <img id="logo_img" src="<?php echo isset($data['logo']) ? $data['logo'] : ''; ?>"></img>
                        <span class="error_tips displayin"><span class="icontips floatl"></span><span class="content"></span></span>
                    </div>
                    <div class="form-item">
                        <label>商品价格：</label>
                        <input type="text" data-required name="price" id="price" value="<?php echo isset($data['price']) ? $data['price'] : ''; ?>" />
                        <span class="error_tips displayin"><span class="icontips floatl"></span><span class="content"></span></span>
                    </div>
                    <div class="form-item">
                        <label>商品类型：</label>
                        <select name="type">
                            <?php 
                                foreach ($type_info as $key => $value) {
                                    echo "<option value='$value[id]'>$value[name]</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-item">
                        <label>商品描述：</label>
                        <textarea style="width:350px; height:100px;" name="goods_desc" data-required id="goods_desc"><?php echo isset($data['goods_desc']) ? $data['goods_desc'] : ''; ?></textarea>
                        <span class="error_tips displayin"><span class="icontips floatl"></span><span class="content"></span></span>
                    </div>
                    <div class="form-item">
                        <label>是否上架：</label>
                        <input type="radio" id="is_on_sale" name="is_on_sale" value=1 <?php echo (isset($data['is_on_sale']) && $data['is_on_sale']==1) || !isset($data['is_on_sale']) ? 'checked' : ''; ?>>上架
                        <input type="radio" id="is_on_sale" name="is_on_sale" value=0 <?php echo (isset($data['is_on_sale']) && $data['is_on_sale']==0) ? 'checked' : ''; ?>>不上架
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

    <script>
        /**
         * 异步提交文件
         */ 
        function handle_file(value) {
            if(value) {
                $.ajaxFileUpload({
                    url: '/Admin/Ajax/upload',
                    secureuri: false,
                    fileElementId: "logo_file", //file标签的id
                    dataType: "json", //返回数据的类型
                    data: {filetype:"file", _token:"{{ csrf_token() }}"}, //一同上传的数据
                    success: function(data) {
                        // 接收服务端处理的数据
                        if(data.code == 0) {
                            // alert("图片上传成功！");
                            $("#logo_img").attr("src",data.path);
                            $("#logo").val(data.path);
                            // 显示图片
                        } else {
                            alert(data.msg);
                        }
                    },
                    error: function (data, status, e) {
                        alert(e);
                    }
                });
            }
        }
    </script>
</html>