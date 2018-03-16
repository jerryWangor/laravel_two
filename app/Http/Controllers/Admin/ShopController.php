<?php 
	namespace App\Http\Controllers\Admin;

    use Illuminate\Support\Facades\Session;
	use JerryLib\Model\CommonModel;
    use JerryLib\System\Common;
    use Request;

    class ShopController extends CommonController {

        /**
         * 会员列表
         */
        public function getIndex() {

            $page = isset($this->input['page']) ? $this->input['page'] : 1;
            
            $type_info = $wheres = $params = array();
            if(isset($this->input['type'])) {
                $wheres[] = "type=?";
                $params[] = $this->input['type'];
            }
            $wheres[] = " is_on_sale=1 ";
            $wheres[] = " is_delete=0 ";
            $where = count($wheres)>0 ? ' where ' . implode(' and ', $wheres) : '';

            $sql = "select id,goods_name,logo,price,type,zk_price,goods_desc from p_goods $where";
            
            $data = $this->common_model->prepare($sql, $params)->fetchPage($page, 20);
            
            $page_str = Common::page_str($data, $this->naction);

            // 查看当前用户会员级别
            $userinfo = Session::get('_AUTH_USER_INFO');

            $sql = "select viprate from p_vipinfo where id=?";

            $rate = $this->common_model->prepare($sql, $userinfo['viplevel'])->fetchOne();

            $temp_data = $this->common_model->prepare("select * from p_goods_type")->fetchAll();
            foreach ($temp_data as $key => $value) {
                $type_info[$value['id']] = $value['name'];
            }

            return $this->render(['data'=>$data['page_list'], 'page_str'=>$page_str, 'rate'=>$rate, 'type_info'=>$type_info]);
        }

        /**
         * 购物车结算
         */
        public function anyShopcar() {

            // 提交订单
            if(isset($this->input['submit'])) {

                if(!isset($this->input['goods'])) {
                    $this->redirect('Admin/Shop/index', '请先添加商品！');
                }
                // 首先开启事务
                $this->common_model->begin_tra();
                try {
                    $userinfo = Session::get('_AUTH_USER_INFO');
                    $order_id = Common::mt_randId();
                    $insert_arr = array();
                    $sum_amount = 0;

                    // 插入订单商品表
                    $order_goods_sql = "insert into p_order_goods(order_id,goods_id,goods_num,goods_price) values ";
                    foreach ($this->input['goods'] as $key => $value) {
                        $sum_amount = $sum_amount + $value['goods_num'] * $value['price'];
                        $insert_arr[] = "($order_id,{$value['goods_id']},{$value['goods_num']},{$value['price']})";
                    }
                    $insert_str = implode(',', $insert_arr);
                    $order_goods_sql .= $insert_str;
                    $result = $this->common_model->prepare($order_goods_sql)->execute();
                    if($result === false) {
                        throw new \Exception('error');
                    }

                    // 插入订单表
                    $order_arr = [
                        'order_id'  =>  $order_id, // 唯一订单号
                        'add_time'  =>  time(),
                        'confirm_time'  =>  time(),
                        'sum_amount'  =>  $sum_amount,
                        'g_uid'  =>  $this->uid,
                        'g_name'  =>  $userinfo['nickname'],
                        'g_address'  =>  $userinfo['address'],
                    ];
                    
                    $result = $this->common_model->insert_command('p_order', $order_arr);

                    if($result) {
                        // 清空购物车
                        $sql = "delete from p_shopcar where uid=?";
                        $this->common_model->prepare($sql,$this->uid)->delete_command();
                        // 提交事务
                        $this->common_model->commit();  
                        $this->redirect('Admin/Shop/index', '购物车结算成功！');
                    } else {
                        throw new \Exception();
                    }
                    
                } catch(\Exception $e) {
                    $this->common_model->rollback();
                    $this->redirect('Admin/Shop/shopcar', '购物车结算失败！');
                }
                
            } else {
                // 如果没有下订单就显示购物车
                $sql = "select a.goods_id,a.goods_num,b.goods_name,b.logo,a.price,b.type from (select uid,goods_id,goods_num,price from p_shopcar where uid=?) as a left join p_goods as b on a.goods_id=b.id where b.is_on_sale=1 and b.is_delete=0";
                $data = $this->common_model->prepare($sql, $this->uid)->fetchAll();

                $type_info = array();
                $temp_data = $this->common_model->prepare("select * from p_goods_type")->fetchAll();
                foreach ($temp_data as $key => $value) {
                    $type_info[$value['id']] = $value['name'];
                }

                return $this->render(['data'=>$data, 'type_info'=>$type_info]);
            }

        }
        
	}
?>