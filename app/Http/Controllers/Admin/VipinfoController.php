<?php 
	namespace App\Http\Controllers\Admin;

	use JerryLib\Model\CommonModel;
    use JerryLib\System\Common;
    use Request;

    class VipinfoController extends CommonController {

        /**
         * 会员列表
         */
        public function getIndex() {

            $page = isset($this->input['page']) ? $this->input['page'] : 1;
            // 查询用户列表
            $wheres = $params = array();
            if(isset($this->input['vipname'])) {
                $wheres[] = "vipname like '%{$this->input['vipname']}%'";
            }

            $where = count($wheres)>0 ? ' where ' . implode(' and ', $wheres) : '';

            $sql = "select * from p_vipinfo $where";
            
            $data = $this->common_model->prepare($sql, $params)->fetchPage($page, 20);
            
            $page_str = Common::page_str($data, $this->naction);

            return $this->render(['data'=>$data['page_list'], 'page_str'=>$page_str]);
        }

        /**
         * 新增会员
         */
        public function anyAdd() {

            // 插入/修改会员
            $data = array();
            if(isset($this->input['id'])) {
                $id = intval($this->input['id']);

                $sql = "select * from p_vipinfo where id=?";

                $data = $this->common_model->prepare($sql, $id)->fetchRow();                
            }

            if(isset($this->input['submit'])) {
                $insert_arr = [
                    'vipname'  =>  $this->input['vipname'],
                    'viprate'  =>  $this->input['viprate'],
                ];

                if(isset($this->input['id'])) {
                    $result = $this->common_model->update_arr('p_vipinfo', $insert_arr, array('id'=>$this->input['id']));
                } else {
                    $result = $this->common_model->insert_command('p_vipinfo', $insert_arr, true);
                }
                if($result) {
                    $this->redirect('Admin/Vipinfo/index', '会员插入/更新成功！');
                } else {
                    $this->redirect('', '会员插入/更新失败！');
                }
            }

            return $this->render(['data'=>$data]);
        }

        /**
         * 删除会员
         */
        public function getDelete() {
            if(isset($this->input['id'])) {
                $id = intval($this->input['id']);

                $sql = "delete from p_vipinfo where id=?";

                $result = $this->common_model->prepare($sql, $id)->delete_command();

                if($result) {
                    $this->redirect('Admin/Vipinfo/index', '会员删除成功！');
                } else {
                    $this->redirect('', '会员删除失败！');
                }
            }
        }
        
	}
?>