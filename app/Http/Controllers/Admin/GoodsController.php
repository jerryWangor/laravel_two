<?php 
	namespace App\Http\Controllers\Admin;

	use JerryLib\Model\CommonModel;
    use JerryLib\System\Common;
    use Request;

    class GoodsController extends CommonController {

        /**
         * 商品列表
         */
        public function getIndex() {

            $page = isset($this->input['page']) ? $this->input['page'] : 1;
            // 查询用户列表
            $type_info = $wheres = $params = array();
            if(isset($this->input['goods_name'])) {
                $wheres[] = "goods_name like '%{$this->input['goods_name']}%'";
            }
            if(isset($this->input['type']) && $this->input['type']>0) {
                $wheres[] = "type=?";
                $params[] = $this->input['type'];
            }
            $wheres[] = " is_delete=0 ";
            $where = count($wheres)>0 ? ' where ' . implode(' and ', $wheres) : '';

            $sql = "select * from p_goods $where";
            
            $data = $this->common_model->prepare($sql, $params)->fetchPage($page, 20);
            
            $page_str = Common::page_str($data, $this->naction);

            $temp_data = $this->common_model->prepare("select * from p_goods_type")->fetchAll();
            foreach ($temp_data as $key => $value) {
                $type_info[$value['id']] = $value['name'];
            }

            return $this->render(['data'=>$data['page_list'], 'type_info'=>$type_info, 'page_str'=>$page_str]);
        }

        /**
         * 新增商品
         */
        public function anyAdd() {

            // 判断商品类型是否为空
            $is_null = $this->common_model->prepare("select * from p_goods_type limit 1")->fetchRow();

            if(!$is_null) {
                $this->redirect('Admin/Goods/index', '必须先添加商品类型！');
            }

            // 插入/修改商品
            $data = array();
            if(isset($this->input['id'])) {
                $id = intval($this->input['id']);

                $sql = "select * from p_goods where id=?";

                $data = $this->common_model->prepare($sql, $id)->fetchRow();                
            }

            if(isset($this->input['submit'])) {
                $insert_arr = [
                    'goods_name'  =>  $this->input['goods_name'],
                    'logo'  =>  str_replace('\\', '\\\\', $this->input['logo']),
                    'price'  =>  $this->input['price'],
                    'type'  =>  $this->input['type'],
                    'goods_desc'  =>  $this->input['goods_desc'],
                    'is_on_sale'  =>  $this->input['is_on_sale'],
                    'addtime'  =>  time(),
                ];

                if(isset($this->input['id'])) {
                    $result = $this->common_model->update_arr('p_goods', $insert_arr, array('id'=>$this->input['id']));
                } else {
                    $result = $this->common_model->insert_command('p_goods', $insert_arr, true);
                }
                if($result) {
                    $this->redirect('Admin/Goods/index', '商品插入/更新成功！');
                } else {
                    $this->redirect('', '商品插入/更新失败！');
                }
            }

            $type_info = $this->common_model->prepare("select * from p_goods_type")->fetchAll();

            return $this->render(['data'=>$data, 'type_info'=>$type_info]);
        }

        /**
         * 删除商品
         */
        public function getDelete() {
            if(isset($this->input['id'])) {
                $id = intval($this->input['id']);

                $sql = "update p_goods set is_delete=1 where id=?";

                $result = $this->common_model->prepare($sql, $id)->update_command();

                if($result) {
                    $this->redirect('Admin/Goods/index', '商品删除成功！');
                } else {
                    $this->redirect('', '商品删除失败！');
                }
            }
        }

        /**
         * 展示商品类型
         */
        public function getType() {
            $page = isset($this->input['page']) ? $this->input['page'] : 1;
            // 查询用户列表
            $wheres = $params = array();
            if(isset($this->input['name'])) {
                $wheres[] = "name like '%{$this->input['name']}%'";
            }
            $where = count($wheres)>0 ? ' where ' . implode(' and ', $wheres) : '';

            $sql = "select * from p_goods_type $where";
            
            $data = $this->common_model->prepare($sql, $params)->fetchPage($page, 20);
            
            $page_str = Common::page_str($data, $this->naction);

            return $this->render(['data'=>$data['page_list'], 'page_str'=>$page_str]);
        }

        /**
         * 添加商品类型
         */
        public function anyAddtype() {
            // 插入/修改商品类型
            $data = array();
            if(isset($this->input['id'])) {
                $id = intval($this->input['id']);

                $sql = "select * from p_goods_type where id=?";

                $data = $this->common_model->prepare($sql, $id)->fetchRow();                
            }

            if(isset($this->input['submit'])) {
                $insert_arr = [
                    'name'  =>  $this->input['name'],
                ];

                if(isset($this->input['id'])) {
                    $result = $this->common_model->update_arr('p_goods_type', $insert_arr, array('id'=>$this->input['id']));
                } else {
                    $result = $this->common_model->insert_command('p_goods_type', $insert_arr, true);
                }
                if($result) {
                    $this->redirect('Admin/Goods/index', '商品插入/更新成功！');
                } else {
                    $this->redirect('', '商品插入/更新失败！');
                }
            }

            return $this->render(['data'=>$data]);
        }
        
	}
?>