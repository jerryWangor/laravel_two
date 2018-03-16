<?php 
	namespace App\Http\Controllers\Admin;

    use Illuminate\Support\Facades\Session;
	use JerryLib\Model\CommonModel;
	use JerryLib\System\Common;
    use JerryLib\User\Auth;
    use Request;

    class UserController extends CommonController {

        /**
         * 用户列表
         */
        public function getIndex() {

            $page = isset($this->input['page']) ? $this->input['page'] : 1;
            // 查询用户列表
            $wheres = $params = array();
            if(isset($this->input['nickname'])) {
                $wheres[] = "nickname like '%{$this->input['nickname']}%'";
            }

            // 除了管理员其他只能看到自己车间的信息
            if(!$this->is_admin) {
                $wheres[] = "creater=?";
                $params[] = Session::get('_AUTH_USER_NICKNAME');
            }
            $where = count($wheres)>0 ? ' where ' . implode(' and ', $wheres) : '';
            
            $sql = "select a.*,b.name as bname from p_users as a left join p_usergroup as b on a.groupids=b.id $where";
            
            $data = $this->common_model->prepare($sql, $params)->fetchPage($page, 20);

            $page_str = Common::page_str($data, $this->naction);

            return view($this->naction, [ 'data'=>$data['page_list'], 'page_str'=>$page_str]);
        }

        /**
         * 新增用户
         */
        public function anyAdd() {

            // 插入/修改用户
            $data = array();
            if(isset($this->input['uid'])) {

                $id = intval($this->input['uid']);
                $sql = "select * from p_users where uid=?";
                $data = $this->common_model->prepare($sql, $id)->fetchRow();
            }

            if(isset($this->input['submit'])) {

                if(!Common::checkUser($this->input['account'])) {
                    $this->redirect('', '用户名格式错误');
                }
                if(isset($this->input['password']) && !Common::checkPwd($this->input['password'])) {
                    $this->redirect('', '密码格式错误');
                }
                if(!(Common::checkUser($this->input['nickname'], 'CN'))) {
                    $this->redirect('', '昵称格式错误');
                }

                $insert_arr = [
                    'account'  =>  $this->input['account'],
                    'nickname'  =>  $this->input['nickname'],
                    'company'  =>  $this->input['company'],
                    'address'  =>  $this->input['address'],
                    'phone'  =>  $this->input['phone'],
                    'qq'  =>  $this->input['qq'],
                    'status'  =>  $this->input['status'],
                    'viplevel'  =>  $this->input['viplevel'],
                    'groupids'  =>  isset($this->input['groupids']) ? $this->input['groupids'] : 999,
                    'creater'  =>  (isset($this->input['creater']) && $this->input['creater']) ? $this->input['creater'] : Session::get('_AUTH_USER_NICKNAME'),
                    'createtime'  =>  date('Y-m-d H:i:s'),
                ];

                // 新增的时候有密码
                if(isset($this->input['password'])) {
                    $insert_arr['password'] = Common::password($this->input['account'], $this->input['password']);
                }

                // 编辑的时候没有密码
                if(isset($this->input['uid'])) {
                    $result = $this->common_model->update_arr('p_users', $insert_arr, array('uid'=>$this->input['uid']));
                } else {
                    //验证当前用户名是否唯一
                    $check_account = $this->common_model->prepare("select * from p_users where account=?", $this->input['account'])->fetchRow();
                    if(count($check_account)>0) {
                        $this->redirect('', '用户已存在！');
                    }

                    $result = $this->common_model->insert_command('p_users', $insert_arr, true);
                }
                if($result) {
                    $this->redirect('Admin/User/index', '用户插入/更新成功！');
                } else {
                    $this->redirect('', '用户插入/更新失败！');
                }
            }

            // 查询用户组
            $group_data = $this->common_model->prepare("select id,name from p_usergroup where status=1")->fetchAll();
            // 查询VIP级别
            $vip_data = $this->common_model->prepare("select id,vipname from p_vipinfo")->fetchAll();

            return $this->render(['group_data'=>$group_data, 'vip_data'=>$vip_data, 'is_admin'=>$this->is_admin, 'data'=>$data]);
        }

        /**
         * 重置密码
         */
        public function getReset() {

            $sql = "select account from p_users where uid=?";

            $account = $this->common_model->prepare($sql, $this->input['uid'])->fetchOne();

            $reset_pass = $account . date('Y');

            $password = Common::password($account, $reset_pass);

            $sql = "update p_users set password=? where uid=?";

            $result = $this->common_model->prepare($sql, $password, $this->input['uid'])->update_command();

            if($result) {
                $this->redirect('Admin/User/index', '用户'.$account.'重置密码成功，新密码为：'.$account.'2017！');
            } else {
                $this->redirect('Admin/User/index', '用户'.$account.'重置密码失败，如果密码不是'.$account.'2017，请联系管理员！');
            }

        }

        /**
         * 禁用/启用用户
         */
        public function getEnable() {

            $str = $this->input['status']==0 ? '禁用' : '启用';
            $sql = "update p_users set status=? where uid=?";

            $result = $this->common_model->prepare($sql, $this->input['status'], $this->input['uid'])->update_command();

            if($result) {
                $this->redirect('Admin/User/index', '用户'.$str.'成功！');
            } else {
                $this->redirect('Admin/User/index', '用户'.$str.'失败！');
            }

        }

        /**
         * 删除用户
         */
        public function getDelete() {
            if(isset($this->input['uid'])) {
                $uid = intval($this->input['uid']);

                $sql = "delete from p_users where uid=?";

                $result = $this->common_model->prepare($sql, $uid)->delete_command();

                if($result) {
                    $this->redirect('Admin/User/index', '用户删除成功！');
                } else {
                    $this->redirect('', '用户删除失败！');
                }
            }
        }

        /**
         * 修改个人信息
         */
        public function anyChangepwd() {
            if(isset($this->input['account'])) {
                $userinfo = Auth::getUserInfo($this->input['account']);
                // 判断旧密码是否正确
                if($userinfo['password'] != Common::password($this->input['account'], $this->input['old_password'])) {
                    $this->redirect('Admin/User/changepwd', '旧密码错误');
                }
                // 判断新密码
                if(!Common::checkPwd($this->input['new_password'])) {
                    $this->redirect('Admin/User/changepwd', '新密码格式不正确');
                }

                $old_password = Common::password($this->input['account'], $this->input['old_password']);
                $new_password = Common::password($this->input['account'], $this->input['new_password']);

                $sql = "update p_users set password=? where account=? and password=?";

                $update = array(
                    'password'  =>  $new_password,
                    'company'  =>  $this->input['company'],
                    'address'  =>  $this->input['address'],
                    'phone'  =>  $this->input['phone'],
                );

                $result = $this->common_model->update_arr('p_users', $update, array('account'=>$this->input['account'], 'password'=>$old_password));
                if($result) {
                    $this->redirect('Admin/Shop/index', '个人信息修改完成！');
                } else {
                    $this->redirect('Admin/User/changepwd', '个人信息修改失败！');
                }

            } else {
                $userinfo = $this->common_model->prepare("select * from p_users where uid=?", $this->uid)->fetchRow();
                return $this->render(['userinfo'=>$userinfo]);
            }
        }

        /**
         * 审核用户
         */
        public function getShenhe() {
            if(isset($this->input['uid'])) {
                $uid = intval($this->input['uid']);

                $sql = "update p_users set status=1,groupids=999 where uid=?";

                $result = $this->common_model->prepare($sql, $uid)->update_command();

                if($result) {
                    $this->redirect('Admin/User/index', '用户审核成功！');
                } else {
                    $this->redirect('', '用户审核失败！');
                }
            }
        }

	}
?>