<?php namespace JerryLib\System;
	
	/**
	 * 公共函数
	 * Created by PhpStorm.
	 * User: Jerry
	 * Date: 2016/1/25
	 * Time: 11:43
	 */
	 
	class Common {
		
		/**
		 * 去除字符串中的空格，包括空格、制表符、换页符等等
		 */
		public static function trimSpace($string = '') {
		   return preg_replace("/\s/","",$string);
		}

		/**
		 * 验证用户名
		 * 用户名规则:
		 * 1.英文，由字母a～z(不区分大小写)、数字0～9、减号或下划线组成，只能以数字或字母开头和结尾，用户名长度为4～18个字符
		 * 2.中文，由中文、减号或下划线组成，只能以中文开头和结尾，长度为2～6个汉字
		 * @param string $username 用户名
		 * @param int $minlen 最小长度
		 * @param int $maxlen 最大长度
		 * @param string $charset 字符编码
		 * @return boolean
		 */
		public static function checkUser($username = '', $charset = 'all', $minlen = 4, $maxlen = 18) {
			$username = self::trimSpace($username);
			if(empty($username)) return false;
			switch($charset) {
				case 'EN':
					$match = '/^[0-9a-zA-Z]{1}[\w|-]{'.($minlen-2).','.($maxlen-2).'}[0-9a-zA-Z]{1}$/iu';
					break;
				case 'CN':
					$match = '/^[\x{4e00}-\x{9fa5}]{2,'.($maxlen/3).'}$/iu';
					break;
				default:
					$match = '/^[0-9a-zA-Z]{1}[\w|-]{'.($minlen-2).','.($maxlen-2).'}[0-9a-zA-Z]{1}$/iu';
					break;
			}
			return preg_match($match, $username);
		}

		/**
		 * 验证密码
		 * 密码规则:由字母a～z(区分大小写)、数字0～9、[\\~!@#$%^&*()-=+|{}\[\],.?\/:;\'\"\w]组成，必须包含一个字母或者一个数字，只能以数字或字母开头，密码长度为6-16个字符
		 * @param string $password 密码
		 * @param int $minlen 最小长度
		 * @param int $maxlen 最大长度
		 * @return boolean
		 */
		public static function checkPwd($password = '', $minlen = 6, $maxlen = 16) {
			$password = self::trimSpace($password);
			if(empty($password)) return false;
			$match = '/^[\\~!@#$%^&*()-=+|{}\[\],.?\/:;\'\"\w]{'.$minlen.','.$maxlen.'}$/';
			return preg_match($match, $password);
		}

        /**
         * 验证验证码
         * 验证码规则:由字母a～z(区分大小写)、数字0～9组成的4位字符串
         * @param string $verify 密码
         * @return boolean
         */
        public static function checkVerify($verify = '') {
            $verify = self::trimSpace($verify);
            if(empty($verify)) return false;
            $match = '/^[\w]{4}$/';
            return preg_match($match, $verify);
        }

		/**
		 * 验证Email
		 * @param string $email 邮箱名称
		 * @return boolean
		 */
		public static function checkEmail($email = '') {
			$email = self::trimSpace($email);
			if(empty($email)) return false;
			$match = '/^[\w]+[\w-.]*@[\w-.]+\.[\w]{2,10}$/i';
			return preg_match($match, $email);
		}

		/**
		 * 验证手机号码
		 * @param int $phone
		 * @return boolean
		 */
		public static function checkTelephone($telephone = 0) {
			$telephone = self::trimSpace($telephone);
			if(empty($telephone)) return false;
			$match = '/^1[34578]{1}\d{9}$/';
			return preg_match($match, $telephone);
		}

		/**
		 * 验证邮政编码
		 * @param int $postcode
		 * @return boolean
		 */
		public static function checkPostcode($postcode = 0) {
			$postcode = self::trimSpace($postcode);
			if(empty($postcode)) return false;
			$match = '/^\d{6}$/';
			return preg_match($match, $postcode);
		}

		/**
		 * 验证IP，filter_var可以用来专门验证IP
		 * @param string $ip
		 * @return boolean
		 */
		public static function checkIp($ip = '') {
			$ip = self::trimSpace($ip);
			if(empty($ip)) return false;
			$match = '/^(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])$/';
			return preg_match($match, $ip);
		}

		/**
		 * 验证身份证号码
		 * @param string $IDcard
		 * @return boolean
		 */
		public static function checkIDcard($IDcard = '') {
			$IDcard = self::trimSpace($IDcard);
			if(empty($IDcard)) return false;
			$match = '/^\d{6}((1[89])|(2\d))\d{2}((0\d)|(1[0-2]))((3[01])|([0-2]\d))\d{3}(\d|X)$/i';
			return preg_match($match, $IDcard);
		}

		/**
		 * 验证URL
		 * @param string $url
		 * @return boolean
		 */
		public static function checkURL($url = '') {
			$url = self::trimSpace($url);
			if(empty($url)) return false;
			$match = '/^(http:\/\/)?(https:\/\/)?([\w\d-]+\.)+[\w-]+(\/[\d\w-.\/?%&=]*)?$/';
			return preg_match($match, $url);
		}

		/**
		 * 验证QQ号
		 * @param string $QQcard
		 * @return boolean
		 */
		public static function checkQQcard($QQcard = '') {
			$QQcard = self::trimSpace($QQcard);
			if(empty($QQcard)) return false;
			$match = '/^[1-9][0-9]{1,11}$/';
			return preg_match($match, $QQcard);
		}

		/**
		 * 验证微信号
		 * @param string $weixin
		 * @return boolean
		 */
		public static function checkWeixin($weixin = '') {
			$weixin = self::trimSpace($weixin);
			if(empty($weixin)) return false;
			$match = '/^[a-zA-Z][a-zA-Z0-9_-]{5,19}$/';
			return preg_match($match, $weixin);
		}

		/**
		 * 验证生日日期
		 * @param string $birthday
		 * @return boolean
		 */
		public static function checkBirthday($birthday = '') {
			$birthday = self::trimSpace($birthday);
			if(empty($birthday)) return false;
			$match = '/^[12][0-9]{3}-(([0][0-9])|([1][12]))-(([012][0-9])|([3][01]))$/';
			return preg_match($match, $birthday);
		}

		/**
		 * 验证密码强度，总共10分，1-3分为弱，4-6分为中，6分以上为强
		 * @param string @password
		 * @return int $score
		 */
		public static function checkPwdStrong($str = '') {
			$score = 0;
			if(preg_match("/[0-9]+/", $str)) //有数字
			{
				$score ++;
			}
			if(preg_match("/[0-9]{3,}/", $str)) //有3个以上的数字
			{
				$score ++;
			}
			if(preg_match("/[a-z]+/", $str)) //有字母
			{
				$score ++;
			}
			if(preg_match("/[a-z]{3,}/", $str)) //有三个以上的字母
			{
				$score ++;
			}
			if(preg_match("/[A-Z]+/", $str)) //有大写字母
			{
				$score ++;
			}
			if(preg_match("/[A-Z]{3,}/", $str)) //有三个以上的大写字母
			{
				$score ++;
			}
			if(preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]+/", $str)) //有特殊符号
			{
				$score += 2;
			}
			if(preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]{3,}/", $str)) //有三个以上的特殊符号
			{
				$score ++ ;
			}
			if(strlen($str) >= 10) //长度大于10
			{
				$score ++;
			}
			return $score;
		}

		/**
		 * 访问url，发送短信验证码
		 */
		public static function getCurl($url = '') {
			if(function_exists('file_get_contents')) {
				$file_contents = file_get_contents($url);
			} else {
				$ch = curl_init();
				$timeout = 5;
				curl_setopt ($ch, CURLOPT_URL, $url);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
				$file_contents = curl_exec($ch);
				curl_close($ch);
			}
			return $file_contents;
		}
		
		/**
		 * 获取客户端真实IP地址  
		 */
		public static function get_real_ip() {
			if(isset($_SERVER['HTTP_REMOTEIP'])) {
				return $_SERVER['HTTP_REMOTEIP']; //阿里云slb专用找真实IP变量
			}
			$ip = false;
			!empty($_SERVER['HTTP_CLIENT_IP']) && $ip = $_SERVER['HTTP_CLIENT_IP']; //代理服务器发送的HTTP头
			if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ips = explode(', ', $_SERVER['HTTP_X_FORWARDED_FOR']); //代理IP链
				if($ip) {
					array_unshift($ips, $ip);
					$ip = false;
				}
				for($i = 0; $i < count($ips); $i++) { //向前查找代理IP链。返回第一个ip
					if (!preg_match('/^(10|172\.16|192\.168)\./i', $ips[$i])) { //非内网地址
						$ip = $ips[$i];
						break;
					}
				}
			}
			if($ip && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE)) {
				return $ip;
			} else {
				return $_SERVER['REMOTE_ADDR'];
			}
		}

		/**
		 * 获取操作系统为win2000/xp、win7、server2003/2008的本机IP真实地址  
		 */
		public static function get_local_ip() {
			$preg = '/\A((([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\.){3}(([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\Z/';
			exec('ipconfig', $out, $stats);  
			if(!empty($out)) {
				foreach($out as $row) {
					if(strstr($row, 'IP') && strstr($row, ':') && !strstr($row, 'IPv6')) {
						$tmpIp = explode(':', $row);
						if(preg_match($preg, trim($tmpIp[1]))) {
							return trim($tmpIp[1]);
						}
					}
				}
			}
		}
		
		/**
		 * 基本的防sql注入,addslashes转义单双引号
		 */
		public static function sql_injection($content) {
			if(!get_magic_quotes_gpc()) {
				if(is_array($content)) {
					foreach($content as $key=>$value) {
						$content[$key] = self::sql_injection($value);
					}
				} else {
					$content = addslashes($content);
				}
			}
			return $content;
		}
		
		/**
		 * 释放调用存储过程之后的结果集,适用于mysqli
		 */
		public static function clearStoredResults($mysqli_link) {
			while($mysqli_link->next_result()) {
				if($l_result = $mysqli_link->store_result()) {
					$l_result->free();
				}
			}
		}
		
		/**
		 * 读取一个ini配置文件
		 */
		public static function getConfig($file) {
			file_exists($file) or self::throwException('File ‘' . $file . '’ 不存在！');
			return parse_ini_file($file, true);
		}

		/**
		 * 抛出原生异常
		 */
		public static function throwException($msg) {
			throw new \Exception($msg);
		}
		
		/**
		 * 得到文件的扩展名
		 */
		public static function getFileExtend($fileName) {
			return pathinfo($fileName, PATHINFO_EXTENSION);
		}
		
		/**
		 * 取得一个唯一随机码
		 */
		public static function mt_randId($date = '2016-03-21') {
			return (time() - strtotime($date)) . mt_rand(10000, 99999);
		}
		
		/**
		 * 将utf8转成gbk
		 */
		public static function toGBK($str) {
			return mb_convert_encoding($str, 'GBK', 'UTF-8');
		}

		/**
		 * 将gbk转成utf8
		 */
		public static function toUTF8($str) {
			return mb_convert_encoding($str, 'UTF-8', 'GBK');
		}

		/**
		 * 将数组由gbk转成utf8
		 */
		public static function arrToUTF8($arr) {
			foreach($arr as $key => $val) {
				$arr[$key] = is_array($val) ? self::arrToUTF8($val) : self::toUTF8($val);
			}
			return $arr;
		}

		/**
		 * 将数组由utf8转成gbk
		 */
		public static function arrToGBK($arr) {
			foreach($arr as $key => $val) {
				$arr[$key] = is_array($val) ? self::arrToGBK($val) : self::toGBK($val);
			}
			return $arr;
		}
		
		/**
		 * 返回所有键值，过滤掉空数据
		 */
		public static function arrayFilter($arr) {
			return array_values(array_filter($arr));
		}

		/**
		 * 大数据数组判断值是否在数组中
		 */
		public static function inArray($val, $array) {
			$arr = array_flip($array);
			return isset($arr[$val]);
		}
		
		/**
		 * 获得当前时间的秒数，精确到微妙
		 */
		public static function nowTime() {
			list($usec, $sec) = explode(' ', microtime());
			return ((float)$usec + (float)$sec);
		}
		
		/**
		 * 取得一个用户密码md5值，注意用户名自动大写
		 */
		public static function password($username, $password) {
			return md5(md5($password) . strtoupper($username));
		}
		
		/**
		 * 将对象转成数组
		 */
		public static function objectToArray($array) {
			if(is_object($array)) {
				$array = (array)$array;
			}
			if(is_array($array)) {
				foreach ($array as $key => $value) {
					$array[$key] = self::objectToArray($value);
				}
			}
			return $array;
		}
		
		/**
		 * 创建目录，支持数组多个传入
		 */
		public static function mkdirs($dir) {
			if(is_array($dir)) {
				foreach ($dir as $val) {
					file_exists($val) or mkdir($val, 0777, true);
				}
			} else {
				file_exists($dir) or mkdir($dir, 0777, true);
			}
		}
		
		/**
		 * 删除一个文件夹，含其内容
		 */
		public static function fileDelete($dir) {
			$dir = $dir ? $dir . '/' : './';
			file_exists($dir) or self::throwException('目录' . $dir . '不存在!');
			$mydir = opendir($dir);
			readdir($mydir);
			readdir($mydir);
			while($myname = readdir($mydir)) {
				if(is_dir($dir . $myname)) {
					self::fileDelete($dir . $myname);
				} else {
					unlink($dir . $myname);
				}
			}
			closedir($mydir);
			rmdir($dir);
		}
		
		/**
		 * 将文件复制到另一个目录，支持文件夹复制
		 */
		public static function fileCopy($form, $toDir) {
			self::mkdirs($toDir); //建立目标目录
			if(is_dir($form)) {
				$form .= '/';
				$mydir = opendir($form);
				readdir($mydir);
				readdir($mydir);
				while($myname = readdir($mydir)) {
					if(is_dir($form . $myname)) {
						self::fileCopy($form . $myname, $toDir . '/' . $myname);
					} else {
						copy($form . $myname, $toDir . '/' . $myname);
					}
				}
				closedir($mydir);
			} else {
				$form = str_replace("\\", '/', $form);
				$tmp = explode('/', $form);
				$file = end($tmp);
				copy($form, $toDir . $file);
			}
		}
		
		/**
		 * 判断字符串是不是一个日期
		 */
		public static function isDate($date) {
			$formats = array('Y-m-d', 'Y/m/d', 'Y年m月d日', 'Y-n-j', 'Y/n/j', 'Y年n月j日');
			$date = preg_split('/[\s]+/', $date);
			$date = $date[0];

			$unixTime = strtotime($date);
			if(!$unixTime) { //strtotime转换不对，日期格式显然不对。
				return false;
			}
			//校验日期的有效性，只要满足其中一个格式就OK
			foreach($formats as $format) {
				if (date($format, $unixTime) == $date) {
					return true;
				}
			}
			return false;
		}
		
		/**
		 * 判断字符串是不是一个数字
		 */
		public static function is_num($num) {
			if(strpos($num, ',,') !== false) {
				return false;
			}
			$arr = explode(".", $num);
			if(isset($arr[1]) && (strpos($arr[1], ',') !== false)) { //判断小数部分是不是有逗号，
				return false;
			}
			$num = str_replace(',', '', $num); //去除逗号
			return is_numeric($num);
		}

		/**
		 * 将数字转变成Excel的字母下标 A-ZZ的范围
		 */
		public static function numTochar($num) {
			$char = [];
			for($i = 65; $i < 91; $i++) {
				$char[] = chr($i);
			}
			$returnChar = [];
			$i = 1;
			$arr = array_merge([''], $char);
			foreach($arr as $H) {
				foreach($char as $E) {
					$returnChar[$i++] = $H . $E;
					if($i > $num)
						break 2;
				}
			}
			return $returnChar;
		}
		
		/**
		 * 删除一个数组中指定的键值，
		 */
		public static function arrayDataFilter($sourceData, $filterKey) {
			foreach($filterKey as $key) {
				unset($sourceData[$key]);
			}
			return $sourceData;
		}
		
		/**
		 * 取得url的根地址
		 */
		public static function urlRoot() {
			return 'http://' . $_SERVER['HTTP_HOST'] . '/';
		}

		/**
		 * 取得站点目录地址
		 */
		public static function webRoot() {
			return $_SERVER['DOCUMENT_ROOT'] . '/';
		}

        /*
        * 身份证号验证(兼容15，18位)
        * 返回数组 status = 0;
        */
        public static function isIdCardNo($idcard) {
            $return = array('status'=>0, 'msg'=>'');
            if( empty($idcard) ){
                $return['msg'] = '输入的身份证号码不能够为空';
                return $return;
            }
            $City = array(11=>"北京",12=>"天津",13=>"河北",14=>"山西",15=>"内蒙古",21=>"辽宁",22=>"吉林",23=>"黑龙江",31=>"上海",32=>"江苏",33=>"浙江",34=>"安徽",35=>"福建",36=>"江西",37=>"山东",41=>"河南",42=>"湖北",43=>"湖南",44=>"广东",45=>"广西",46=>"海南",50=>"重庆",51=>"四川",52=>"贵州",53=>"云南",54=>"西藏",61=>"陕西",62=>"甘肃",63=>"青海",64=>"宁夏",65=>"新疆",71=>"台湾",81=>"香港",82=>"澳门",91=>"国外");
            $iSum = 0;
            $idCardLength = strlen($idcard);
            //长度验证
            if(!preg_match('/^\d{17}(\d|x)$/i',$idcard) and!preg_match('/^\d{15}$/i',$idcard)) {
                $return['msg'] = L('PUBLIC_IDCARDNO_LIMIT', array('length1'=>'15', 'length2'=>'17'));
                return $return;
            }
            //地区验证
            if(!array_key_exists(intval(substr($idcard,0,2)),$City)) {
                $return['msg'] = '身份证号码的地区编号错误';
                return $return;
            }
            // 15位身份证验证生日，转换为18位
            if ($idCardLength == 15) {
                $sBirthday = '19'.substr($idcard,6,2).'-'.substr($idcard,8,2).'-'.substr($idcard,10,2);
                $d = new DateTime($sBirthday);
                $dd = $d->format('Y-m-d');
                if($sBirthday != $dd) {
                    $return['msg'] = '身份证号码的生日错误';
                    return $return;
                }
                $idcard = substr($idcard,0,6)."19".substr($idcard,6,9);//15to18
                $Bit18 = getVerifyBit($idcard);//算出第18位校验码
                $idcard = $idcard.$Bit18;
            }
            // 判断是否大于2078年，小于1900年
            $year = substr($idcard,6,4);
            if ($year<1900 || $year>2078 ) {
                $return['msg'] = '身份证号码的出生年份错误';
                return $return;
            }
            //18位身份证处理
            $sBirthday = substr($idcard,6,4).'-'.substr($idcard,10,2).'-'.substr($idcard,12,2);
            $d = new DateTime($sBirthday);
            $dd = $d->format('Y-m-d');
            if($sBirthday != $dd) {
                $return['msg'] = '身份证号码的出生年月日错误';
                return $return;
            }
            //身份证编码规范验证
            $idcard_base = substr($idcard,0,17);
            if(strtoupper(substr($idcard,17,1)) != getVerifyBit($idcard_base)) {
                $return['msg'] = '身份证编码不符合规范验证';
                return $return;
            }
            $return['status'] = 1;
            return $return;
        }
        /**
         * 计算身份证校验码，根据国家标准GB 11643-1999
         */
        public static function getVerifyBit($idcard_base) {
            if (strlen($idcard_base) != 17) {
                return false;
            }
            //加权因子
            $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
            //校验码对应值
            $verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4','3', '2');
            $checksum = 0;
            for ($i = 0; $i < strlen($idcard_base); $i++) {
                $checksum += substr($idcard_base, $i, 1) * $factor[$i];
            }
            $mod = $checksum % 11;
            $verify_number = $verify_number_list[$mod];
            return $verify_number;
        }
        /**
         * 快速测试UTF8编码的文件是不是加了BOM，并可自动移除
         */
        public static function checkBOM($filename, $auto = 1) {
            $contents = file_get_contents($filename);
            $charset[1] = substr($contents, 0, 1);
            $charset[2] = substr($contents, 1, 1);
            $charset[3] = substr($contents, 2, 1);
            if(ord($charset[1])==239 && ord($charset[2])==187 && ord($charset[3])==191) {
                if($auto==1) {
                    $rest = substr($contents, 3);
                    self::rewrite($filename, $rest);
                    return ("<font color=red>BOM found, automatically removed.</font>");
                } else {
                    return ("<font color=red>BOM found.</font>");
                }
            }
            else return ("BOM Not Found.");
        }

        /**
         * 自动移除BOM
         */
        public static function rewrite($filename, $data) {
            $filenum = fopen($filename, 'w');
            flock($filenum, LOCK_EX);
            fwrite($filenum, $data);
            fclose($filenum);
        }

        /**
         * 检查url来路
         * @return bool
         */
        public static function checkFromUrl($tourl = '') {
            if(preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) !== preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST'])) {
                header("Location: $tourl");
                exit();
            }
            return true;
        }

        /**
		 * xss过滤函数
		 *
		 * @param $string
		 * @return string
		 */
		public static function remove_xss($string) {
		    $string = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S', '', $string);

		    $parm1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');

		    $parm2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');

		    $parm = array_merge($parm1, $parm2); 

		    for ($i = 0; $i < sizeof($parm); $i++) {
		        $pattern = '/'; 
		        for ($j = 0; $j < strlen($parm[$i]); $j++) { 
		            if ($j > 0) { 
		                $pattern .= '('; 
		                $pattern .= '(&#[x|X]0([9][a][b]);?)?'; 
		                $pattern .= '|(&#0([9][10][13]);?)?'; 
		                $pattern .= ')?'; 
		            }
		            $pattern .= $parm[$i][$j]; 
		        }
		        $pattern .= '/i';
		        $string = preg_replace($pattern, ' ', $string); 
		    }
		    return $string;
		}

		/**
		 * 安全过滤函数
		 *
		 * @param $string
		 * @return string
		 */
		public static function safe_replace($string) {
		    $string = str_replace('%20','',$string);
		    $string = str_replace('%27','',$string);
		    $string = str_replace('%2527','',$string);
		    $string = str_replace('*','',$string);
		    $string = str_replace('"','&quot;',$string);
		    $string = str_replace("'",'',$string);
		    $string = str_replace('"','',$string);
		    $string = str_replace(';','',$string);
		    $string = str_replace('<','&lt;',$string);
		    $string = str_replace('>','&gt;',$string);
		    $string = str_replace("{",'',$string);
		    $string = str_replace('}','',$string);
		    $string = str_replace('\\','',$string);
		    return $string;
		}

		/**
		 * 过滤ASCII码从0-28的控制字符
		 * @return String
		 */
		public static function trim_unsafe_control_chars($str) {
		    $rule = '/[' . chr ( 1 ) . '-' . chr ( 8 ) . chr ( 11 ) . '-' . chr ( 12 ) . chr ( 14 ) . '-' . chr ( 31 ) . ']*/';
		    return str_replace ( chr ( 0 ), '', preg_replace ( $rule, '', $str ) );
		}

        /**
         * 非常全面的过滤表单数据
         */
        public static function filter_form_data(array $inputs = array()) {
        	$return_data = array();
        	// 循环数组内的每个值进行过滤转移
        	foreach ($inputs as $key => $value) {
        		// 判断$value是不是数组
        		if(is_array($value)) {
        			// 如果是数组暂时不处理
        			$return_data[$key] = $value;
        		} else {
        			// 如果是字符串或者数字
        			if(self::is_num($value)) {
        				$return_data[$key] = doubleval($value);
        			} else {
        				// 去除两边的空格
        				$value = self::trimSpace($value);
        				// addslashes
        				$value = self::sql_injection($value);
        				// stripslashes
        				$value = stripslashes($value);
        				// xss过滤
        				$value = self::remove_xss($value);
        				// 过滤某些特殊符号
        				$value = self::safe_replace($value);
        				// 过滤ASCII码从0-28的控制字符
        				$value = self::trim_unsafe_control_chars($value);
        				$return_data[$key] = $value;
        			}
        		}
        	}
        	return $return_data;
        }

        public static function page_str($page_datas = array(), $page_prefix = null){
	        $page_str = array("<div class='pages_div'>");
	        if($page_datas['page_count']<=10){
	            $start = 1;
	            $end = $page_datas['page_count'];
	        }else{
	            $start = $page_datas['page_index']-4;
	            $end = $page_datas['page_index']+5;
	            if($start<=1){
	                $start = 1;
	                $end = $start+10;
	            }elseif($end>$page_datas['page_count']){
	                $end = $page_datas['page_count'];
	                $start = $page_datas['page_count']-10;
	            }
	        }        
	        $query = $_GET;
	        $_tzurl = URL("$page_prefix?".http_build_query($query));
	        if(isset($query['page'])){
	            unset($query['page']);
	        }
	        for($i=$start;$i<=$end;$i++){
	            $query['page'] = $i;

	            $_url = URL("$page_prefix?".http_build_query($query));
	            if($page_datas['page_index']== $i){
	                $class ='class=" page cur"';
	            }else{
	                $class = 'class="page"';
	            }
	            $page_str[] = "<a href=\"$_url\" $class ><b>$i</b></a>";
	        }
	        $page_str[] = "<span class='page_tips'>共 ".$page_datas['rows_count']." 条记录，分 ".$page_datas['page_count'].' 页</span>'."<span style='margin-left:15px;'>转到<input class='text_input' type='text' style='width:40px; height:8px;' size='5' maxlength='5' title='输入页码后回车' onkeyup=\"this.value=this.value.replace(/\D/g,'')\" onafterpaste = \"this.value = this.value.replace(/\D/g,'')\" onkeydown = \"javascript:if(event.charCode==13||event.keyCode==13){if(!isNaN(this.value)){ location.href='$_tzurl'+'&page='+this.value; }return false;}\"/>页</span>";
	        return implode("",$page_str)."</div>";
	    }

	    /**
		 * 处理上传文件的函数
		 */
		public static function upload_file($F = array(), $ext = array('csv','jpg','jpeg','png')) {

		    $path = SERVER_ROOT.'/uploads'.DIRECTORY_SEPARATOR.date("Y").DIRECTORY_SEPARATOR.date("md").DIRECTORY_SEPARATOR;
		    $path = str_replace(array("\\","/"), DIRECTORY_SEPARATOR, $path);
		    $lastPath = null;
		    if (empty($F) || count($F) <= 0) return array('path'=>null,'error'=>'未知错误，可能是$_FILE没有值.');
		    $_t_file = $F['name'];
		    if( count($ext) <= 0) $ext = array('csv');

		    // 表示表单中的FILE为空或
		    switch ($F['error']) {
		        case 0 :
		            // 表示文件上传成功
		            // 文件名
		            $nameArray = explode(".",$_t_file);
		            $fNameExt = strtolower($nameArray[count($nameArray) - 1]);
		            if (!in_array($fNameExt, $ext) || empty($fNameExt)) {
		                $error = '未知格式的文件。请重新上传';
		                break;
		            }

		            if (!is_dir($path)) mkdir($path, 0777, true);
		            $tempName = $path . date("YmdHis").rand(00000,99999).'.'.$fNameExt;

		            if (move_uploaded_file($F['tmp_name'], $tempName)) {
		                 if ( filesize($tempName) <= 0) {
		                     $error = '上传的文件大小为0请重新上传';
		                     // 删除文件
		                     @unlink($tempName);   
		                 } else { 
		                    // 文件上传成功。
		                    $lastPath = $tempName;
		                    self::img_resize($lastPath);
		                 }
		            } else {
		                $error = '出现未知错误，请重新上传文件上.';
		            }
		            break;
		        case 1:
		            $error = '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值。 请联系网络管理员或自己调整文件的内容。';
		            break;
		        case 4:
		            $error = '没有文件被上传。 ';
		            break;
		        case 7:
		            $error = '文件写入失败。请联系网络管理员调整 “'.$path.'”目录的写入权限。';
		            break;
		        default:
		            $error  = '未知错误，请重新上传文件。';
		            break;
		    }
		    $data['source'] = $lastPath;
		    $data['realname'] = $_t_file;
		    $data['file'] = str_replace($path, '', $lastPath);
		    $data['path']  =  str_replace(SERVER_ROOT, '', $lastPath);
		    $data['error'] = isset($error) ? $error : '';
		    return $data;
		}

		/**
		 * 压缩文件到指定的高宽
		 */
		public static function img_resize($src = null, $width = 150, $height = 150, $is_adapt = false) { 

			$temp = pathinfo($src); 
			$name = $temp["basename"];//文件名 
			$dir = $temp["dirname"];//文件所在的文件夹 
			$extension = $temp["extension"];//文件扩展名 
			$savepath = "{$dir}/{$name}";//缩略图保存路径,新的文件名为*.thumb.jpg 
		  
			//获取图片的基本信息 
			$info = getimagesize($src); 
			$o_width = $info[0];//获取图片宽度 
			$o_height = $info[1];//获取图片高度 
			$per1 = round($o_width/$o_height,2);//计算原图长宽比 
			$per2 = round($width/$height,2);//计算缩略图长宽比 
		  	
		  	if($is_adapt) {
		  		// 原图长宽比大于或者等于缩略图长宽比，则按照宽度优先 
				if($per1>$per2 || $per1==$per2) $per = $width/$o_width; 
				// 原图长宽比小于缩略图长宽比，则按照高度优先 
				if($per1<$per2) $per = $height/$o_height; 
				$temp_w = intval($o_width*$per);//计算原图缩放后的宽度 
				$temp_h = intval($o_height*$per);//计算原图缩放后的高度 
				$temp_img = imagecreatetruecolor($temp_w,$temp_h);//创建画布 
			 	$im = self::img_create($src); 
			 	imagecopyresampled($temp_img,$im,0,0,0,0,$temp_w,$temp_h,$o_width,$o_height); 
			 	if($per1>$per2) {
			 		//宽度优先，在缩放之后高度不足的情况下补上背景 
			 		imagejpeg($temp_img,$savepath, 100); 
			 		imagedestroy($im); 
			 		return self::img_addbg($savepath,$width,$height,"w"); 
			 	} 
			 	if($per1==$per2) { 
			 		//等比缩放 
			 		imagejpeg($temp_img,$savepath, 100); 
			 		imagedestroy($im); 
			 		return $savepath; 
			 	} 
			 	if($per1<$per2) { 
			 		//高度优先，在缩放之后宽度不足的情况下补上背景 
			 		imagejpeg($temp_img,$savepath, 100); 
			 		imagedestroy($im); 
			 		return self::img_addbg($savepath,$width,$height,"h"); 
			 	}
			 } else {
			 	// 固定高度  宽度
			 	$temp_img = imagecreatetruecolor($width,$height);//创建画布 
			 	$im = self::img_create($src); 
			 	imagecopyresampled($temp_img,$im,0,0,0,0,$width,$height,$o_width,$o_height);
			 	imagejpeg($temp_img,$savepath, 100); 
		 		imagedestroy($im); 
		 		return $savepath; 
			 }
			
		}

		/** 
		* 添加背景 
		* @param string $src 图片路径 
		* @param int $width 背景图像宽度 
		* @param int $height 背景图像高度 
		* @param String $first 决定图像最终位置的，w 宽度优先 h 高度优先 wh:等比 
		* @return 返回加上背景的图片 
		* **/
		public static function img_addbg($src = null, $width = null, $height = null, $fisrt = "w") { 

			$bg = imagecreatetruecolor($width, $height); 
			$white = imagecolorallocate($bg,255,255,255); 
			imagefill($bg,0,0,$white); //填充背景 

			//获取目标图片信息 
			$info = getimagesize($src); 
			$o_width = $info[0];//目标图片宽度 
			$o_height = $info[1];//目标图片高度 
			$img = self::img_create($src); 
			if($fisrt == "wh") { 
				//等比缩放 
				return $src; 
			} else { 
				if($fisrt == "w") { 
					$x = 0;
					$y = ($h-$o_height)/2;//垂直居中 
				}
				if($fisrt == "h") { 
					$x = ($w-$o_width)/2;//水平居中 
					$y = 0; 
				} 
				imagecopymerge($bg,$img,$x,$y,0,0,$o_width,$o_height,100); 
				imagejpeg($bg,$src,100); 
				imagedestroy($bg); 
				imagedestroy($img); 
				return $src; 
			}
		}

		/** 
		* 创建图片，返回资源类型 
		* @param string $src 图片路径 
		* @return resource $im 返回资源类型 
		* **/
		public static function img_create($src = null) {
			$info = getimagesize($src);
			switch ($info[2]) {
			case 1: 
				$im = imagecreatefromgif($src); 
				break; 
			case 2: 
				$im = imagecreatefromjpeg($src); 
				break; 
			case 3: 
				$im = imagecreatefrompng($src); 
				break; 
			} 
			return $im; 
		} 

		/**
		 * 主要用于构造merge_target
		 * 用法：传入1,2,3,5,7,8 
		 * 返回：1-3,5,7-8
		 */
		public static function bulidName($value) {
		    $dataarr = explode(',', $value); //把字符串按照,分割成数组
		    $count = count($dataarr); //计算数组中的值的个数
		    $first = $dataarr[0]; //设置第一个数组的值
		    $last = $dataarr[$count-1]; //设置最后一个数组的值
		    $newdata = ''; //这个变量是保存匹配后的字符串
		    if($count>1) { //如果区服数量大于1才进行循环匹配
		        for($i=0; $i<$count-1; $i++) { //从第一个开始循环一直到倒数第二个
		            if($dataarr[$i+1]-$dataarr[$i]>1) { //如果第二个减去第一个大于1，就说明中间已经断开，那么如果中间有断开的就继续执行下面的代码
		                if($first == $dataarr[$i]) { //请注意这里是中间已经断开了，第一个值和当前循环的值相等的话就设置/
		                    $newdata .= $first.',';
		                } else { //如果第一个值和当前循环值不相等就用第一个值-当前循环的值
		                    $newdata .= $first.'-'.$dataarr[$i].',';
		                }
		                if($last == $dataarr[$i+1]) { //如果已经循环到最后一个值了，并且中间断开了，那说明最后一个值是单独的，所以单独连接在后面
		                    $newdata .= $dataarr[$i+1];
		                }
		                $first = $dataarr[$i+1]; //每次都把第一个数给设置成当前值
		            } else { //这里是最有趣的，如果全部都是连续的，那么就用第一个值-连接最后一个值，否则就是中间有断开的
		                if($last == $dataarr[$i+1]) {
		                    $newdata .= $first.'-'.$dataarr[$i+1];
		                }
		            }
		        }
		    } else {
		        $newdata = $value;
		    }
		    return $newdata;
		}

		/**
		 * 主要用于解析bulidName构造的字符串
		 * 用法：传入1,3-5,7
		 * 返回：array(1,3,4,5,7)
		 */
		public static function convertName($serverid = null) {
		    $serverids = array();
		    if($serverid) {
		        if (strpos($serverid, ',')) {
		            $temp_arr = explode(',', $serverid);
		            foreach ($temp_arr as $t) {
		                if (strpos($t, '-')) {
		                    $t_temp = explode('-', $t);
		                    $serverids = array_merge($serverids, range(intval($t_temp[0]), intval($t_temp[1])));
		                } else {
		                    $serverids[] = intval($t);
		                }
		            }
		        } else {
		            if (strpos($serverid, '-')) {
		                $t = explode('-', $serverid);
		                $serverids = array_merge($serverids, range($t[0], $t[1]));
		            } else {
		                $serverids[] = intval($serverid);
		            }
		        }
		    }
		    return $serverids;
		}

		/**
 		 * post 提交数据
 		 */
		public static function init_curl_post($array, $url) {
	        $ch = curl_init();  
	        curl_setopt($ch, CURLOPT_URL,$url);  
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//指定post数据  
	        curl_setopt($ch, CURLOPT_POST, 1);  
	        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($array));  
	        $output = curl_exec($ch);
	        if(!$output){
	            $output = curl_error($ch);
	        } 
	        curl_close($ch);
	        return $output;
	    }

	    /**
		 * 本函数用于输出和判断文件头类型
		 * param file:文件路径
		 * param form:用于对比的文件类型
		 */
		public static function judgeFile($file = null, $form = null) {
		    if(!empty($file)) {
		        $filehead = fopen($file,'r');
		        $bin = fread($filehead, 2);
		        fclose($filehead);
		        $data = unpack('C2chars', $bin);
		        $type_code = intval($data['chars1'].$data['chars2']);
		        switch ($type_code) {
		            case 7790: $fileType = 'exe';break;
		            case 7784: $fileType = 'midi';break;
		            case 8075: $fileType = 'zip';break;
		            case 8297: $fileType = 'rar';break;
		            case 255216: $fileType = 'jpg';break;
		            case 7173: $fileType = 'gif';break;
		            case 6677: $fileType = 'bmp';break;
		            case 13780: $fileType = 'png';break;
		            case 199248: $fileType = 'csv';break;
		            case 115101: $fileType = 'csv';break;
		            default: $fileType = 'unknown';break;
		        }
		        if(!$form) return $fileType;
		    } else {
		        return false;
		    }

		    if(!empty($form)) {
		        if(!is_array($form)){
		            if($fileType==$form){
		                return true;
		            }else{
		                return false;
		            }
		        }else{
		            if(in_array($file, $form)){
		                return true;
		            }else{
		                return FALSE;
		            }
		        }
		    } else {
		        return false;
		    }
		}

		/**
		 * 导出文件公共函数
		 * @param  array  $fileds_array     文件头字段
		 * @param  array  $data             数据
		 * @param  string $file_name        文件名
		 * @param  array  $change_params    可变参数
		 *                                  array('数据下标($data)'=>'需要指定的值')
		 * @param  array  $source_data      需原样输出的值                                 
		 * @return unknown
		 */
		public static function export_file($fileds_array = array(), $data = array(), $file_name = NULL, $change_params = array()) {
		    if ( ! is_array($data) && count($data) <= 0 ) return false;

		    if ( empty($file_name) )  {
		        $file_name = date('Y-m-d H:i:s_').rand(0000,9999).'.csv';
		    } else {
		        if (strpos($file_name, '.csv') === false) $file_name .= '.csv';
		    }
		    // 打一个csv流
		    $fp = fopen('php://output', 'w') or die("Can't open php://output");
		    // 告诉浏览器发送的是一个csv文件  
		    header('Content-Type: application/csv;charset=utf-8');  
		    header('Content-Disposition: attachment; filename="'.$file_name);
		    // 解决CSV或TXT文件的编码
		    fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
		    if( is_array($fileds_array) && count($fileds_array) > 0 ) {
		        fputcsv($fp, $fileds_array);  
		    }
		    foreach($data as $key => $line){
		        $_news = array();
		        // 处理需要从外面传递的值
		        foreach ($change_params as $_k => $_v) {
		            if ( is_array($_v) ) {
		                // 处理有多个值的数组
		                if (strpos($_k, ',') === false) {
		                    $line[$_k] = $_v[$line[$_k]];
		                } else {
		                    list($_app_key, $_app_name) = explode(',', $_k);
		                    $line[$_app_key] = $_v[$line[$_app_key]][$_app_name];
		                }
		            } else {
		                $_last_result = NULL;
		                // start SP_
		                if( preg_match('/^(SP_)/', $_v) ) {
		                    // SP_new_role/server_days|sprintf,%0.2f,new_role/server_days
		                    $_replace_sp = str_replace('SP_', '', $_v);
		                    // end split
		                    list($_var, $funs) = explode('|', $_replace_sp);
		                    // + 增加一个=表示两个参数一个，直接使用
		                    list($max, $min) = (preg_split('/[\\+\\*%\\/\\-]/', $_var));
		                    preg_match('/[\\+\\*%\\/\\-]/', $_var, $_tools);
		                    $_tools = current($_tools);
		                    $_start = $line[$max];
		                    $_end   = $line[$min];
		                    switch($_tools) {
		                        case '+' :
		                            $_last_result = $_start + $_end;
		                            break;
		                        case '-'    :
		                            $_last_result = $_start - $_end;
		                            break;
		                        case '*'    :
		                            $_last_result = $_start * $_end;
		                            break;
		                        case '/'    :
		                            $_last_result = $_start / $_end;
		                            break;
		                        case '%'    :
		                            $_last_result = $_start % $_end;
		                            break;
		                        default;
		                    }
		                    if ( $funs && !empty($funs)) {
		                        // FixTools:2016-07-22
		                        // + 规定,第一个参数为函数名
		                        list($function, $args1, $args2) = explode(',', $funs);
		                        if (function_exists($function) ) {
		                            if ($_var == $args2 && $args2) {
		                                $_last_result = $function($args1, $_last_result);
		                            } else {
		                                // unknown args
		                                $_last_result = $function.' unknown args.source data:('.$_last_result.')';
		                            }
		                        }  else {
		                            $_last_result = $function.' don\'t exists.source data:('.$_last_result.')';
		                        }
		                    }
		                    $line[$_k] = $_last_result;
		                } else {
		                    $line[$_k] = $_v;
		                }
		            }
		        }
		        foreach ($fileds_array as $key => $value) {
		            $_news[] = $line[$key];
		        }
		        if(fputcsv($fp, $_news) === false){  
		            die("Can't write CSV line");
		        }
		    }
		    fclose($fp) or die("Can't close php://output");
		    exit();
		}

		/**
		 * 两段日期之间的日期数组
		 */
		public static function getDateList($sdate = null, $edate = null, $d = 15) {
		    if(!$edate){
		        $edate = date('Y-m-d',strtotime("last day"));//昨天
		    }
		    if(!$d){
		        $d = 15;
		    }
		    if($sdate){
		        $sdates = strtotime($sdate);
		    }
		    if($edate){
		        $edates = strtotime($edate);
		    }
		    if($sdate){//求两时间段内的日期
		        if($sdates > $edates){
		            return '您设置的开始时间大于了结束时间';
		        }
		        $d = ($sdates - $edates)/(24*60*60);//天
		    }else{//无开始日期
		        if($d>0){
		            $d = -1*$d;
		        }
		        $d = $d + 1;                      
		    }
		    for ($i=$d; $i <= 0; $i++) { 
		        $dateList[] = date('Y-m-d',strtotime($i." days",strtotime($edate))); 
		    }
		    return $dateList;
		        
		}

	}
	