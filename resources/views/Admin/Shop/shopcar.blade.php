<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>购物车</title>
        <!-- 引入标签库 -->
        <tagLib name="html" />
        <!-- 加载头部公共文件 -->
        <?php require_once(HEADER_URL); ?>
        <style>
            .userList { margin: 20px 30px 20px 30px; }
            .goods { min-height: 250px; overflow: hidden; }
            .min,.add { width: 20px; }
            .all_price { margin-top: 50px; text-align: center; font-size: 18px; color: #f30; font-weight: bold; }

            .box{float:left; width:165px; height:260px; margin-left:45px; margin-top: 20px; border:1px solid #e0e0e0; text-align:center}
            .box p{line-height:20px; padding:4px 4px 10px 4px; text-align:left}
            .box:hover{border:1px solid #f90}
            .box span {line-height:25px; font-size:14px; color:#f30;font-weight:500}

            .m-sidebar{position: fixed;top: 0;right: 0;background: #000;z-index: 2000;width: 35px;height: 100%;font-size: 12px;color: #fff;}
            .cart{ display:block; color: #fff;text-align:center;line-height: 20px;padding: 200px 0 0 0px;}
            .cart span{display:block;width:20px;margin:0 auto;}
            .cart i{width:35px;height:35px;display:block; background:url("<?php echo asset('/images/car.png') ?>") no-repeat;}

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
        </style>
    </head>
    <body>
        <!-- 主页面开始 -->
        <div id="main_body" class="main_body">
            <div class="main_button" id="main_button">
                
            </div>
            <div class="userList">

                <form id="shopcar" action="" method="post">
                    <div class="goods">
                        <?php 

                            $all_price = 0;
                            foreach ($data as $key => $value) {

                                $all_price += $value['price']*$value['goods_num'];

                                echo '<div class="box">';
                                echo '<img src="'.$value['logo'].'" width="150" height="150">';
                                echo "<h3>{$value['goods_name']}({$type_info[$value['type']]})</h3>";
                                echo '<input class="goods_id" name="goods['.$key.'][goods_id]" type="hidden" value="'.$value['goods_id'].'" />';
                                echo '<div>
                                         <input class="min" name="" type="button" value="-" />
                                         <input class="goods_num" name="goods['.$key.'][goods_num]" onchange="change_price($(this))" type="text" value="'.$value['goods_num'].'" style="width:20px;" />
                                         <input class="add" name="" type="button" value="+" />
                                         (斤)
                                      </div>';
                                echo "价格：<span class='show_price'>¥".$value['price']*$value['goods_num']."</span><br/>";
                                echo '<input class="price" name="goods['.$key.'][price]" type="hidden" value="'.$value['price'].'" />';
                                echo '<a href="#" class="button orange addcar" onclick="delete_goods('.$value['goods_id'].',$(this))">删除</a>';
                                echo '</div>';
                            }
                        ?>
                    </div>

                    <div class="form-item">
                        <div class="all_price">
                            总价格：<span class="show_all_price"><?php echo $all_price; ?></span>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" name="submit" style="font-size: 18px;" value="提交订单" class="login_submit bluebtn" />
                    </div>

                </form>
            </div>
        </div>
    </body>
    <script>
        $(document).ready(function() {

            $(".add").click(function() {
                // $(this).prev() 就是当前元素的前一个元素，即 goods_num
                var num = parseInt($(this).prev().val()) + 1;
                $(this).prev().val(num);
                // 当前显示价格++
                var parent_box = $(this).parents('.box');
                var price = parent_box.find('.price').val();
                var sum_price = (num*price).toFixed(2);
                parent_box.find('.show_price').text("¥"+sum_price)

                // 计算总价格 加上增加价格
                var show_all_price = (parseFloat($(".show_all_price").text()) + parseFloat(price)).toFixed(2);
                $(".show_all_price").text(show_all_price);
            });
              
            $(".min").click(function() {
                // $(this).next() 就是当前元素的下一个元素，即 goods_num
                var num = parseInt($(this).next().val()) - 1;
                // num不能小于1
                if(num<=0) {
                    alert('数量不能小于1');
                    return false;
                }
                $(this).next().val(num);
                // 当前显示价格--
                var parent_box = $(this).parents('.box');
                var price = parent_box.find('.price').val();
                var sum_price = (num*price).toFixed(2);
                parent_box.find('.show_price').text("¥"+sum_price)

                // 计算总价格 减价格
                var show_all_price = (parseFloat($(".show_all_price").text()) - parseFloat(price)).toFixed(2);
                $(".show_all_price").text(show_all_price);
            });

        });

        // 删除购物车商品
        function delete_goods(goods_id, now_params) {

            var parent_box = now_params.parents(".box");
            var show_price = parent_box.find(".show_price").text();
            show_price = (parseFloat(show_price.replace('¥', ''))).toFixed(2);

            $.ajax({
                type: 'POST',
                url: '/Admin/Ajax/deletegoods',
                data: {goods_id:goods_id},
                dataType: 'json',
                async: false, //这里设置为同步，执行完ajax之后再return
                beforeSend:function() {
                },
                success:function(result) {
                    if(result.code == 0) {
                        // remove box div
                        parent_box.remove();
                        // 重新计算总价
                        var show_all_price = (parseFloat($(".show_all_price").text()) - show_price).toFixed(2);
                        $(".show_all_price").text(show_all_price);
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
        }

        var change_all_price = 0;

        // 输入框改变时重新计算价格
        function change_price(now_params) {
            // 当前显示价格++
            change_all_price = 0; // 总价重置为0
            num = now_params.val();
            var parent_box = now_params.parents('.box');
            var price = parent_box.find('.price').val();
            var sum_price = (num*price).toFixed(2);
            parent_box.find('.show_price').text("¥"+sum_price);

            // 计算总价格 循环所有show_price 价格累加
            $(".show_price").each(function () {
                var show_price = parseFloat($(this).text().replace('¥', ''));
                console.log(show_price)
                change_all_price = change_all_price + show_price;
            });
            $(".show_all_price").text(change_all_price.toFixed(2));
        }
    </script>
</html>