<?php 
	namespace App\Http\Controllers\Admin;
	use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Session;
    use JerryLib\System\Verify;
    use JerryLib\System\Common;
    use JerryLib\Model\CommonModel;
    use JerryLib\User\Auth;
    use JerryLib\User\userManage;
    use Request;
    use Redirect;

    class IndexController extends Controller {

        // 注册
        public function getRegister(Request $request) {
            return view('Admin.Index.register');
        }

        //后台主页面
		public function getIndex(Request $request) {
            if(!Session::has('_AUTH_USER_ISLOGIN') && !Session::get('_AUTH_USER_ISLOGIN')===true) {
                return Redirect::to('Admin/Index/login');
            }
            // 获取当前在线人数,从session
            $onlineNum = userManage::Init()->getOnlineNum();
            // 获取侧边栏菜单
            $sidedata = Session::get('_AUTH_SIDE');
            // stop($sidedata);
            return view('Admin.Index.index', ['sidedata'=>$sidedata, 'onlineNum'=>$onlineNum]);
		}

        //主区域页面
        public function getMain() {
            if(!Session::has('_AUTH_USER_ISLOGIN') && !Session::get('_AUTH_USER_ISLOGIN')===true) {
                return Redirect::to('Admin/Index/login');
            }
            return view('Admin.Index.main');
        }

        //登录页面
        public function getLogin() {
            if(Session::has('_AUTH_USER_ISLOGIN') && Session::get('_AUTH_USER_ISLOGIN')===true) {
                return Redirect::to('Admin/Index/index');
            }
            $checkVerify = Session::get('checkVerify') ? Session::get('checkVerify') : false;
            return view('Admin.Index.login', ['checkVerify' => $checkVerify]);
        }

        //获取验证码
        public function getVerify() {
            Verify::doimg();
        }

        //登录检查
        public function postChecklogin(Request $request) {
            $inputs = Common::filter_form_data($request::all());
            if($return = userManage::Init()->checkLogin($inputs)) {
                return response()->json($return);
            }
        }

        /**
         * 检查用户是否存在
         */
        public function postCheckuser() {
            $return = array();
            if(!Common::checkUser($_POST['username'])) {
                returnJson('参数错误');
            }

            $userinfo = Auth::getUserInfo($_POST['username']);
            
            if($userinfo) {
                returnJson('用户已存在');
            } else {
                returnJson('可以使用', 0);
            }
        }

        /**
         * 注册验证
         */
        public function postCheckregister() {

            // 过滤表单
            $post = Common::filter_form_data($_POST);
            
            // 验证主要的参数
            if(!Common::checkUser($post['account'])) returnJson('账号错误!');
            if(!Common::checkPwd($post['password'])) returnJson('密码错误!');
            if(!Common::checkUser($post['nickname'], 'CN', 6, 18)) returnJson('姓名错误!');
            if(!Common::checkTelephone($post['phone'])) returnJson('手机号错误!');
            if(!Common::checkVerify($post['verify']) || strtolower($post['verify'])!=strtolower(Session::get('verify'))) returnJson('验证码错误!');

            //检查账号是否注册过
            $userinfo = Auth::getUserInfo($post['account']);
            if($userinfo) returnJson('用户已存在');

            //如果验证通过就写入注册数据
            $registerData = array(
                'account'   =>  $post['account'],
                'password'   =>  Common::password($post['account'], $post['password']),
                'nickname'   =>  $post['nickname'],
                'company'   =>  $post['company'],
                'address'   =>  $post['address'],
                'phone'   =>  $post['phone'],
                'status'   =>  2,
                'groupids'  =>  999,
                'level'   =>  2,
                'creater'   =>  '注册',
                'createtime'    =>  date('Y-m-d H:i:s'),
            );
            
            $common_model = CommonModel::Init();

            $result = $common_model->insert_command('p_users', $registerData, true);

            if($result) {
                returnJson('注册成功，等待审核！', 0, array(), array('url' => '/Admin/Index/login'));
            } else {
                returnJson('注册失败，未知错误！');
            }
        }

        //退出
        public function getLogout(Redirect $Redirect) {
            if(!Session::has('_AUTH_USER_ISLOGIN') && !Session::get('_AUTH_USER_ISLOGIN')===true) {
                return Redirect::to('Admin/Index/login');
            }
            //记录退出日志
            userManage::Init()->loginOut(session('_AUTH_USER_UID'));
            //注销session
            Session::flush();
            return $Redirect::to('Admin/Index/login');
        }
	}
?>