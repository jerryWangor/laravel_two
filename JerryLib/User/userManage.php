<?php namespace JerryLib\User;

use Illuminate\Support\Facades\Session;
use JerryLib\Model\CommonModel;
use JerryLib\User\Auth;
use JerryLib\System\Init;
use JerryLib\System\Common;

/**
 * Class userManage
 * @package JerryLib\User
 * 用户管理类
 */
class userManage {

    use Init;

    private static $_loginErrorTime = 0; // 登录错误次数
    protected $model; // 当前数据库模型
    protected $lockDoc;
    protected $sessionDoc;
    protected $logtable = 'log_user';

    /**
     * 构造函数
     */
    private function __construct($db = 'laravel') {
        $this->model = CommonModel::Init($db);
        // $this->model->debug = true;
        return $this;
    }

    /**
     * 克隆函数，防止克隆
     */
    private function __clone() {
        throw new \Exception('对不起,不能克隆!');
    }

    /**
     * 写日志
     * @param $userid 用户ID  
     * @param $eventType 日志类型
     * @param $eventFlag 日志标识
     * @param $eventContent 日志内容
     */
    protected function writeLog($userid, $eventContent, $eventFlag, $eventType) {

        $this->model->insert_command($this->logtable, [
            'sessionID' => session()->getId(),
            'uid' => $userid,
            'ip' => Common::get_real_ip(),
            'date' => date('Y-m-d H:i:s'),
            'type' => $eventType,
            'flag' => $eventFlag,
            'content' => $eventContent
        ]);
    }

    /**
     * 写用户日志
     * @param string $userid
     * @param int $eventType
     * @param $eventContent
     */
    public function writeUserLog($userid = '', $eventContent, $eventFlag, $eventType = 1) {
        $userid or $userid = session('_AUTH_USER_UID');
        $this->writeLog($userid, $eventContent, $eventFlag, $eventType);
    }

    /**
     * 写系统日志
     * @param int $eventType
     * @param $eventContent
     */
    public function writeSystemLog($eventContent, $eventFlag = 1, $eventType = 2) {
        $this->writeLog(999999, $eventContent, $eventFlag, $eventType);
    }

    /**
     * 获取30分钟之内登录出错的次数
     * @param $uid
     */
    public function getErrorTime($uid = '') {
        $datetime = date('Y-m-d H:i:s', time()-30*60);
        $data = $this->model->prepare('select count(*) from log_user where uid=? and type=1 and flag=0 and date>=?', array($uid, $datetime))->fetchOne();
        return $data;
    }

    /**
     * 检查用户登录
     * @param $post
     */
    public function checkLogin($post) {

        //然后检查用户名,密码,验证码格式是否正确
        if(!Common::checkUser($post['account'])) {
            throw new \Exception('username error');
        }
        if(!Common::checkPwd($post['password'])) {
            throw new \Exception('passwd error');
        }
        if(Session::get('checkVerify')==true && isset($post['verify']) && !Common::checkVerify($post['verify'])) {
            throw new \Exception('verify error');
        }
        //然后检查用户帐号或者IP是否被限制
        $this->checkUserlock($post['account'])->checkIplock(Common::get_real_ip()); //检查账号或IP是否被封禁
        //然后检查用户密码和验证码
        $userinfo = Auth::getUserInfo($post['account']);
        
        if(!$userinfo) { //验证用户是否存在
            throw new \Exception('user does not exist');
        }
        if($userinfo['status']==2) {
            throw new \Exception('user is unable');
        }

        if($userinfo['password'] != Common::password($post['account'], $post['password'])) {
            $this->showLoginError('密码错误', $userinfo);
        }
        if(Session::get('checkVerify')==true && isset($post['verify']) && strtolower($post['verify'])!=strtolower(Session::get('verify'))) {
            $this->showLoginError('验证码错误', $userinfo);
        }
        //如果验证通过就记录登录成功日志和读取权限
        $this->writeUserLog($userinfo['uid'], '登录系统成功', 1, 1);
        $isadmin = false;
        if($userinfo['level'] == 1) {
            $isadmin = true;
            Session::put('_AUTH_USER_ISADMIN', true);
        }
        if(Auth::getUserRules($userinfo['uid'], 1, $isadmin)) {
            Session::put([
                '_AUTH_USER_ISLOGIN'    => true,
                '_AUTH_USER_UID'        => $userinfo['uid'],
                '_AUTH_USER_ACCOUNT'    => $userinfo['account'],
                '_AUTH_USER_NICKNAME'   => $userinfo['nickname'],
                '_AUTH_USER_INFO'       => $userinfo
            ]);
            Session::forget('verify'); //如果登录成功就销毁当前验证码
            Session::forget('checkVerify');
            Session::forget($userinfo['uid'].'_loginErrorTime');

            // 更新最后登录时间
            $this->model->prepare('update p_users set lastlogintime=? where uid=?', array(time(), $userinfo['uid']))->update_command();

            return array('code'=>0, 'msg'=>'success', 'url'=>'index');
        } else {
            throw new \Exception('登录异常');
        }
    }

    /**
     * 检查用户是否被封禁
     * @param $account
     */
    private function checkUserlock($account) {
        $data = $this->model->prepare("select id,lockaccount,lockreason from p_userlock where lockaccount=? and unlocktime>now() limit 1", $account)->fetchRow();
        if(count($data)) {
            throw new \Exception('当前用户(' . $data[0]['lockaccount'] . ')因以下原因被限制登录：' . $data[0]['lockreason'] . ',请及时联系管理员!');
        }
        return $this;
    }

    /**
     * 检查用户IP是否被封禁
     * @param $ip
     */
    private function checkIplock($ip) {
        $data = $this->model->prepare("select id,lockip,lockreason from p_userlock where lockip=? and unlocktime>now() limit 1", $ip)->fetchRow();
        if(count($data)) {
            throw new \Exception('当前IP(' . $data[0]['lockip'] . ')因以下原因被限制登录：' . $data[0]['lockreason'] . ',请及时联系管理员!');
        }
        return $this;
    }

    /**
     * 登录失败的话执行一系列判断
     * @param string $msg
     * @throws \Exception
     */
    private function showLoginError($msg = '', $userinfo) {
        //写入登录失败日志
        $this->writeUserLog($userinfo['uid'], '登录系统失败,' . $msg, 0, 1);
        //读取30分钟之内失败次数
        self::$_loginErrorTime = $this->getErrorTime($userinfo['uid']);
        //判断失败次数执行相应操作
        if(self::$_loginErrorTime>=3 && self::$_loginErrorTime<10) {
            Session::put('checkVerify', true); //开启验证码模式
        } elseif(self::$_loginErrorTime>=5 && self::$_loginErrorTime<10) {
            //限制半个小时之内不能登录
            $msg .= "(不要再尝试登录了，不要封你的账号和IP)";
        } elseif(self::$_loginErrorTime>=10 && self::$_loginErrorTime<20) {
            //封帐号
            $this->lockUser('尝试暴力破解登录', $userinfo['account'], 'system');
        } elseif(self::$_loginErrorTime>=20) {
            //封IP
            $this->lockIp('尝试暴力破解登录', 'system');
        }
        // 记录当前用户登录错误session
        Session::put([$userinfo['uid'].'_loginErrorTime'=>self::$_loginErrorTime]);
        throw new \Exception($msg);
    }

    /**
     * 封号
     * @param string $lockreason
     * @param string $lockaccount
     * @param string $doaccount
     * @param string $unlocktime
     * @return $this
     */
    public function lockUser($lockreason = '', $lockaccount = '', $doaccount = '', $unlocktime = '') {
        $lockaccount or $lockaccount = session('_AUTH_USER_ACCOUNT');
        $doaccount or $doaccount = session('_AUTH_USER_ACCOUNT');
        $unlocktime or $unlocktime = '2050-01-01 00:00:00';
        $this->model->insert_command([
            'lockaccount' => $lockaccount,
            'doaccount' => $doaccount,
            'locktime' => date('Y-m-d H:i:s'),
            'lockreason' => $lockreason,
            'unlocktime' => $unlocktime
        ]);
        return $this;
    }

    /**
     * 封IP
     * @param string $lockreason
     * @param string $lockip
     * @param string $doaccount
     * @param string $unlocktime
     * @return $this
     */
    public function lockIp($lockreason = '', $doaccount = '', $lockip = '', $unlocktime = '') {
        $lockip or $lockip = Common::get_real_ip();
        $doaccount or $doaccount = session('_AUTH_USER_ACCOUNT');
        $unlocktime or $unlocktime = '2050-01-01 00:00:00';
        $this->model->insert_command([
            'lockip' => $lockip,
            'doaccount' => $doaccount,
            'locktime' => date('Y-m-d H:i:s'),
            'lockreason' => $lockreason,
            'unlocktime' => $unlocktime
        ]);
        return $this;
    }

    /**
     * 获取当前系统在线玩家数量
     */
    public function getOnlineNum() {
        $last_time = time()-10*60; // 10分钟之内的算在线
        $onlinenum = 0;
        $data = $this->model->prepare("select * from p_sessions where last_activity>=?", $last_time)->fetchAll();
        foreach ($data as $key => $value) {
            $temp_data = base64_decode($value['payload']);
            if(strpos($temp_data, '_AUTH_USER_ISLOGIN')) {
                $onlinenum++;
            }
        }
        return $onlinenum;
    }

    /**
     * 用户退出执行操作
     * @param $uid
     */
    public function loginout($uid) {
        $this->writeUserLog($uid, '登出系统成功', 1, 2);
    }

}