<?php 
	namespace App\Http\Controllers\Admin;

	use JerryLib\Model\CommonModel;
    use JerryLib\System\Common;
    use Request;

    class MyorderController extends CommonController {

        /**
         * 我的订单
         */
        public function getIndex() {
            
            $page = isset($this->input['page']) ? $this->input['page'] : 1;
            // 查询用户列表
            $wheres = $params = $page_str = array();
            if(isset($this->input['order_id'])) {
                $wheres[] = "order_id like '%{$this->input['order_id']}%'";
            }
            $wheres[] = ' g_uid=? ';
            $params[] = $this->uid;
            $where = count($wheres)>0 ? ' where ' . implode(' and ', $wheres) : '';

            $sql = "select order_id,FROM_UNIXTIME(add_time) as add_time,FROM_UNIXTIME(pay_time) as pay_time,FROM_UNIXTIME(send_time) as send_time,pay_status,send_status,g_name,g_address,status from p_order $where order by add_time desc";
            
            $data = $this->common_model->prepare($sql, $params)->fetchPage($page, 20);
            $page_str = Common::page_str($data, $this->naction);
            $return_data = array();
            
            if($data['page_list']) {

                // 取出所有的order_id
                $order_arr = $order_goods = $return_data = array();
                foreach ($data['page_list'] as $key => $value) {
                    $return_data[$value['order_id']] = $value;
                    $order_arr[] = $value['order_id'];
                }
                $order_str = implode(',', $order_arr);
                $sql = "select a.*,b.goods_name from (select order_id,goods_id,goods_num,goods_price from p_order_goods where order_id in ($order_str)) as a left join p_goods as b on a.goods_id=b.id";
                $result = $this->common_model->prepare($sql)->fetchAll();
                $goods_ids = $goods_info = array();
                foreach ($result as $key => $value) {
                    $order_goods[$value['order_id']][] = $value;
                }

                // 构造物品信息  和 总价
                $iteminfo = $sum_amount = array();
                foreach ($order_goods as $order_id => $arr) {
                    $iteminfo[$order_id] = '';
                    $sum_amount[$order_id] = 0;
                    foreach ($arr as $key => $value) {
                        $sum_amount[$order_id] += $value['goods_num']*$value['goods_price'];
                        $iteminfo[$order_id] .= $value['goods_name'].":".$value['goods_num']."公斤-";
                    }
                }

                foreach ($return_data as $order_id => $value) {
                    if(array_key_exists($order_id, $iteminfo)) {
                        $return_data[$order_id]['iteminfo'] = $iteminfo[$order_id];
                    }
                    if(array_key_exists($order_id, $sum_amount)) {
                        $return_data[$order_id]['sum_amount'] = $sum_amount[$order_id];
                    }
                }
            }
            
            return $this->render(['data'=>$return_data, 'page_str'=>$page_str]);
        }

        /**
         * 确定收货
         */
        public function getShouhuo() {
            if(isset($this->input['order_id'])) {
                $order_id = intval($this->input['order_id']);

                $result = $this->common_model->update_arr('p_order', array('send_status'=>2), array('order_id'=>$this->input['order_id']));

                if($result) {
                    $this->redirect('Admin/Myorder/index', '确定收货成功！');
                } else {
                    $this->redirect('', '确定收货失败！');
                }
            }
        }

        /**
         * 取消订单
         */
        public function getQuxiao() {
            if(isset($this->input['order_id'])) {
                $order_id = intval($this->input['order_id']);

                $result = $this->common_model->update_arr('p_order', array('status'=>2), array('order_id'=>$this->input['order_id']));

                if($result) {
                    $this->redirect('Admin/Myorder/index', '订单取消成功！');
                } else {
                    $this->redirect('', '订单取消失败！');
                }
            }
        }

	}
?>