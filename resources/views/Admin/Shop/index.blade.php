<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>商店</title>
        <!-- 引入标签库 -->
        <tagLib name="html" />
        <!-- 加载头部公共文件 -->
        <?php require_once(HEADER_URL); ?>
        <style>
            .userList { margin: 20px 30px 20px 30px; }
            .goods { height: 600px; }
            .min,.add { width: 20px; }

            .box{float:left; width:165px; height:280px; margin-left:45px; margin-top: 20px; border:1px solid #e0e0e0; text-align:center}
            .box p{line-height:20px; padding:4px 4px 10px 4px; text-align:left}
            .box:hover{border:1px solid #f90}
            .box span {line-height:25px; font-size:14px; color:#f30;font-weight:500}

            .m-sidebar{position: fixed;top: 0;right: 0;background: #000;z-index: 2000;width: 35px;height: 100%;font-size: 12px;color: #fff;}
            .cart{ display:block; color: #fff;text-align:center;line-height: 20px;padding: 200px 0 0 0px;}
            .cart span{display:block;width:20px;margin:0 auto;}
            .cart i{width:35px;height:35px;display:block; background:url("<?php echo asset('/images/car.png') ?>") no-repeat;}
            #msg{position:fixed; top:300px; right:35px; z-index:10000; width:1px; height:52px; line-height:52px; font-size:20px; text-align:center; color:#fff; background:#360; display:none}
            .u-flyer{display: block;width: 50px;height: 50px;border-radius: 50px;position: fixed;z-index: 9999;}

            .button {
                display: inline-block;
                outline: none;
                cursor: pointer;
                text-align: center;
                text-decoration: none;
                font: 16px/100% 'Microsoft yahei',Arial, Helvetica, sans-serif;
                margin-top: 5px;
                padding: 4px 13px;
                text-shadow: 0 1px 1px rgba(0,0,0,.3);
                -webkit-border-radius: .5em; 
                -moz-border-radius: .5em;
                border-radius: .5em;
                -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.2);
                -moz-box-shadow: 0 1px 2px rgba(0,0,0,.2);
                box-shadow: 0 1px 2px rgba(0,0,0,.2);
            }
            .button:hover {
                text-decoration: none;
            }
            .button:active {
                position: relative;
                top: 1px;
            }
            /* orange */
            .orange {
                color: #fef4e9;
                border: solid 1px #da7c0c;
                background: #f78d1d;
                background: -webkit-gradient(linear, left top, left bottom, from(#faa51a), to(#f47a20));
                background: -moz-linear-gradient(top,  #faa51a,  #f47a20);
                filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#faa51a', endColorstr='#f47a20');
            }
            .orange:hover {
                background: #f47c20;
                background: -webkit-gradient(linear, left top, left bottom, from(#f88e11), to(#f06015));
                background: -moz-linear-gradient(top,  #f88e11,  #f06015);
                filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#f88e11', endColorstr='#f06015');
            }
            .orange:active {
                color: #fcd3a5;
                background: -webkit-gradient(linear, left top, left bottom, from(#f47a20), to(#faa51a));
                background: -moz-linear-gradient(top,  #f47a20,  #faa51a);
                filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#f47a20', endColorstr='#faa51a');
            }

            .type_info:hover {
                border: solid 1px #da7c0c;
            }
        </style>
        <script type="text/javascript" src="<?php echo asset('/js/jquery.fly.min.js') ?>"></script>
        <!--[if lte IE 9]>
        <script type="text/javascript" src="<?php echo asset('/js/requestAnimationFrame.js') ?>"></script>
        <![endif]-->
    </head>
    <body>
        <!-- 主页面开始 -->
        <div id="main_body" class="main_body">
            <div class="main_title">
                <div class="action_btn floatl"><b class="btn_icon btn_icon_add"></b><a style="font-weight:bold" id="add" href="{{ URL('Admin/Shop/shopcar') }}">进入购物车</a></div>
            </div>
            <div class="main_button" id="main_button">
                <div class="action_btn floatl">商品类型：</div>
                <?php 
                    foreach ($type_info as $id => $name) {
                        $url = URL("Admin/Shop/index?type=$id");
                        echo '<div class="action_btn type_info floatl"><a style="font-weight:bold" id="add" href="'.$url.'">'.$name.'</a></div>';
                    }
                ?>
            </div>
            <div class="userList">

                <div class="goods" id="goods">

                    <?php 
                        foreach ($data as $key => $value) {
                            echo '<div class="box">';
                            echo '<img src="'.$value['logo'].'" width="150" height="150">';
                            echo "<h3>{$value['goods_name']}({$type_info[$value['type']]})</h3>";
                            echo '<input class="goods_id" name="goods_id" type="hidden" value="'.$value['id'].'" />';
                            echo "今日菜价：<span>¥{$value['price']}</span><br/>
                                  会员菜价：<span>¥".round($value['price']*$rate,2)."</span>";
                            echo '<input class="vip_price" name="vip_price" type="hidden" value="'.round($value['price']*$rate,2).'" />';
                            echo '<div>
                                     <input class="min" name="" type="button" value="-" />
                                     <input class="goods_num" name="goods_num" type="text" value="1" style="width:20px;" />
                                     <input class="add" name="" type="button" value="+" />
                                     (斤)
                                  </div>';
                            echo '<a href="#" class="button orange addcar" style="color: #FFF">加入购物车</a>';
                            echo '</div>';
                        }
                    ?>
                    <!-- <div class="box">
                        <img src="images/lg.jpg" width="150" height="150">
                        <h3>白菜</h3>
                        <input class="goods_id" id="goods_id" name="" type="hidden" value="" />
                        今日菜价：<span>¥1.25</span><br/>
                        会员菜价：<span>¥1.25</span>
                        <div>
                            <input class="min" name="" type="button" value="-" />
                            <input class="text_box" name="goodnum" type="text" value="1" style="width:20px;" />
                            <input class="add" name="" type="button" value="+" />
                            (斤)
                        </div>
                        <a href="#" class="button orange addcar" style="color: #FFF">加入购物车</a>
                    </div> -->

                </div>

                <div class="m-sidebar">
                    <a class="cart" target="iframe-main" href="/Admin/Shop/shopcar">
                        <i id="end"></i>
                        <span style="color: #FFF">购物车</span>
                    </a>
                </div>
                <div id="msg">已成功加入购物车！</div>

                <ul class="pager" id="pager"><?php echo $page_str; ?></ul>
            </div>
        </div>
    </body>
    <script>
        $(document).ready(function() {

            var offset = $("#end").offset();
            $(".addcar").click(function(event){
                // 飞行之前先ajax把商品加入购物车
                var addcar = $(this);
                var parent_box = $(this).parent('.box');
                var goods_id = parent_box.find('.goods_id').val();
                var goods_num = parent_box.find('.goods_num').val();
                var price = parent_box.find('.vip_price').val();
                $.ajax({
                    type: 'POST',
                    url: '/Admin/Ajax/shopcar',
                    data: {goods_id:goods_id, goods_num:goods_num, price:price},
                    dataType: 'json',
                    async: false, //这里设置为同步，执行完ajax之后再return
                    beforeSend:function() {
                    },
                    success:function(result) {
                        if(result.code == 0) {
                            // 成功之后加入购物车飞行效果
                            var img = addcar.parent().find('img').attr('src');
                            var flyer = $('<img class="u-flyer" src="'+img+'">');
                            flyer.fly({
                                start: {
                                    left: event.pageX,
                                    top: event.pageY
                                },
                                end: {
                                    left: offset.left+10,
                                    top: offset.top+10,
                                    width: 0,
                                    height: 0
                                },
                                onEnd: function(){
                                    $("#msg").show().animate({width: '250px'}, 200).fadeOut(1000);
                                    addcar.css("cursor","default").removeClass('orange').unbind('click');
                                    this.destory();
                                }
                            });
                        } else {
                            alert(result.msg);
                        }
                    },
                    complete:function() {
                    },
                    error:function() {
                        alert('error');
                    }
                });
            });

            $(".add").click(function() {
                // $(this).prev() 就是当前元素的前一个元素，即 text_box
                $(this).prev().val(parseInt($(this).prev().val()) + 1);
            });
              
            $(".min").click(function() {
                // $(this).next() 就是当前元素的下一个元素，即 text_box
                $(this).next().val(parseInt($(this).next().val()) - 1);
            });
        });
    </script>
</html>