<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>更新订单状态</title>
        <!-- 引入标签库 -->
        <tagLib name="html" />
        <!-- 加载头部公共文件 -->
        <?php require_once(HEADER_URL); ?>
        <style>
            .form-item { margin: 20px 0 ;}
            .form-item span {color:#03A9F4; font-size: 12px;}
            .form-item label { display: inline-block; width: 100px; text-align: right;}
            .form-item .longinput { overflow-x:visible; overflow-y:visible; height: 22px; }
        </style>
    </head>
    <body>
        <?php $send_arr = array(0=>'未发货',1=>'送货中',2=>'已签收'); ?>
        <!-- 主页面开始 -->
        <div id="user_add" class="user_add">
            <form id="user_form" action="" method="get">
                <div class="one-content">
                    <div class="form-item">
                        <label>当前订单号：</label>
                        {{ $data['order_id'] }}
                    </div>
                    <div class="form-item">
                        <label>当前收货人：</label>
                        {{ $data['nickname'] }}
                    </div>
                    <div class="form-item">
                        <label>收货人地址：</label>
                        {{ $data['address'] }}
                    </div>
                    <div class="form-item">
                        <label>收货人电话：</label>
                        {{ $data['phone'] }}
                    </div>
                    <div class="form-item">
                        <label>菜品信息：</label>
                        {{ $iteminfo }}
                    </div>
                    <?php if($data['send_status']<2) { ?>
                    <div class="form-item">
                        <label>送货状态：</label>
                        <select name="send_status">
                            <?php 
                                foreach ($send_arr as $key => $value) {
                                    if($key<=$data['send_status']) {
                                        continue;
                                    } else {
                                        echo "<option value='$key'>$value</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <?php } ?>
                    <?php if($data['pay_status']<1) { ?>
                    <div class="form-item">
                        <label>付款状态：</label>
                        <select name="pay_status">
                            <option value='0'>未付款</option>;
                            <option value='1'>已付款</option>;
                        </select>
                    </div>
                    <?php } ?>
                </div>
                <div class="form-item">
                    <label></label>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="order_id" value="{{ $data['order_id'] }}">
                    <input type="submit" id="submit" name="submit" value="提交" class="btn btnLg green2 mt30">
                    <input type="reset" id="reset" name="reset" value="重置" class="btn btnLg blue2 mt30">
                </div>
            </form>
        </div>
    </body>
</html>