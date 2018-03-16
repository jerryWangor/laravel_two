<?php 
	namespace App\Http\Controllers\Admin;

	use JerryLib\Model\CommonModel;
    use JerryLib\System\Common;
    use Request;

    class AjaxController extends CommonController {

        /**
         * 异步上传logo图片
         */
        public function anyUpload() {

            if(!isset($_POST['filetype']) || $_POST['filetype'] != 'file' || !isset($_FILES)) {
                returnJson('请上传文件');
            }

            $data = Common::upload_file($_FILES['logo_file']);
            
            if($data['error']) {
                returnJson('图片上传失败');
            } else {
                returnJson('success', 0, array(), array('path'=>str_replace('\\', '/', $data['path'])));
            }
        }

        /**
         * 商品加入购物车
         */
        public function postShopcar() {
            $insert_arr = [
                'uid'  =>  $this->uid,
                'goods_id'  =>  $this->input['goods_id'],
                'goods_num'  =>  $this->input['goods_num'],
                'price'  =>  $this->input['price'],
                'addtime'  =>  time(),
            ];

            // 在加入购物车之前判断购物车是否有该道具
            $sql = "select * from p_shopcar where uid=? and goods_id=?";
            $has_row = $this->common_model->prepare($sql, $this->uid, $this->input['goods_id'])->fetchRow();
            if($has_row) {
                returnJson('购物车已存在该物品！', -1);
            }

            $result = $this->common_model->insert_command('p_shopcar', $insert_arr);

            if($result) {
                returnJson('success', 0);
            } else {
                returnJson('error', -1, $insert_arr);
            }
        }

        /**
         * 移除购物车中的物品
         */
        public function postDeletegoods() {
            if($this->input['goods_id']) {
                $sql = "delete from p_shopcar where uid=? and goods_id=?";
                $result = $this->common_model->prepare($sql, $this->uid, $this->input['goods_id'])->delete_command();
                if($result) {
                    returnJson('success', 0);
                } else {
                    returnJson('购物车没有该道具！');
                }
            } else {
                returnJson('没有物品！');
            }
        }
        
	}
?>