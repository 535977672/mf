<?php

class core_lib_comm extends Sabstract {

    /**
     * 图片上传
     * @param type $_file 文件
     * @param type $filename 文件名
     * @param type $service 服务
     * @param type $from 来源 
     * @param type $mark 水印
     * @return type 
     */
    public static function getUploadFilePath($_file, $filename = "", $service = "goods", $from = "app", $mark = 0) {
        if ($_file) {
            set_time_limit(1800);
            $_file_type = 0;
            $type_img = array('jpg', 'gif', 'jpeg', 'png', 'bmp');
            $ext = strtolower(strrchr($_file['name'], '.'));
            if (in_array($ext, $type_img)) {
                $_file_type = 1;
                if ($ext == 'gif')
                    $_file_type = 3;
            } else if (in_array($ext, array('php', 'phps', 'php5', 'php4'))) {
                exit();
            }
            $filename = $filename ? $filename : uniqid(SUtil::random(5)) . '.' . $ext;

            $query['type'] = $_file_type;  //为图片时填1,非图片文件填
            $query['server'] = $service ;
            $query['from'] = $from;
            $upload = core_lib_Uploadfilesv::postfile($query, $_file['name'], $_file['tmp_name'], $_file['type']);
            if ($upload['state'] == 1) {
                return $upload['url'];
            } else {
                return $upload;
            }

        } else {
            $aMsgData = array('state' => -2, 'msg' => '图片上传失败');
            return $aMsgData;
        }
    }

    /*
     * solr数据解析
     */
    public static function solr_parse($rs, $facet = '') {
        $items = array();
        if (is_array($rs->response->docs)) {
            $i = 0;
            foreach ($rs->response->docs as $k => $v) {
                foreach ($v as $k1 => $v1) {
                    $items[$i][$k1] = $v1;
                }
                $i++;
            }
            $i = 0;
            if (!empty($rs->highlighting)) {
                foreach ($rs->highlighting as $k => $v) {
                    foreach ($v as $k1 => $v1) {
                        $items[$i]['hl'][$k1] = $v1[0];
                    }
                    $i++;
                }
            }
        }

        $result = array(
            'items' => $items,
            'totalsize' => $rs->response->numFound
        );

        // 统计
        if (!empty($facet)) {
            $result['facet'] = $oRes->facet_counts->facet_fields->$facet;
        }

        return $result;
    }

    /**
     * 上传文件接口
     * 返回上传成功失败的数组
     *
     * @param object $postvar
     *        	数据流
     * @param string $file_name
     *        	文件名
     * @param string $tmp_name
     *        	临时文件名
     * @param string $servers_url
     *        	指定上传的地址,该地址需要遵守一定规则
     * @return array
     */
    public static function upload($parameters) {
        $http = new SHttp ();
        $result = $http->request(UPLOAD_URL, 'POST', $parameters, true);
        if (preg_match_all('(\{.*\})', $result, $matched)) {
            return json_decode($matched[0][0], true);
        } else {
            return array(
                'state' => - 1,
                'msg' => '未知错误'
            );
        }
    }

    /*
     * 生成完整的文件路径
     */
    public static function file2url($file, $width = 0, $height = 0, $cut = 0, $ishostname = 0) {
        if (empty($file)) {
            return $file;
        } else {
            preg_match('/([0-9a-zA-z\/]+)(\.[a-z]+)/', $file, $matches);
            if (!empty($matches)) {
                $ext = $matches[2];
                if ($ishostname == 1) {
                    $url = $matches[1];
                } else {
                    $url = FILE_URL . "/" . $matches[1];
                }
                if (!empty($width) || !empty($height) || !empty($cut)) {
                    $url .= '_' . $width . '_' . $height . '_' . $cut;
                }
                $url .= $ext;
                return $url;
            } else {
                return $file;
            }
        }
    }

    /*
     * 用户授权token
     */
    public static function accessToken($display_name, $uid) {
        // return md5($display_name.$uid.SECURITY_KEY);
        return md5($uid . SECURITY_KEY);
    }
	
    /*
     * 发送手机验证码
     */
    public static function sendPhoneValidation($phone, $type) {
        $time = time();
        $expire_time = time() - 1200; // 20分钟内有效
        $condition = array(
            'phone' => $phone,
            'type' => $type,
            'state' => 0,
            'create_time > ' . $expire_time
        );
        $mdl = SModel::init('core_model_mb_phonevalidation');
        $rs = $mdl->get($condition);
        $data = array(
            'create_time' => $time,
            'create_ymd' => date('Y-m-d', $time)
        );
        if (empty($rs)) {
            $code = SUtil::random(6, 1);
            $data['code'] = $code;
            $data['state'] = 0;
            $data['type'] = $type;
            $data['phone'] = $phone;
            $data['ip'] = SUtil::getIP(true);
        } else { // 使用原来的CODE
            $code = $rs['code'];
        }
        if (($time - ((int) $rs['create_time'])) > 60) { // 离上次发送时间大于一分钟才重新发送与更新
            $mdl->set($data);
            $dbrs = $mdl->save();
            if ($dbrs === false) {
                return false;
            } else {
                // 发送手机信息
                if ($type == 1) {
                    $msg = '您的注册验证码为' . $code . '，二十分钟内有效';
                    // $msg = '欢迎您注册融云，您的手机验证码是：（'.$code.')，请在五分钟内完成验证。';
                } else {
                    $msg = '您的修改密码验证码为' . $code . '，二十分钟内有效';
                    // $msg = '欢迎您注册融云，您的手机验证码是：（'.$code.')，请在五分钟内完成验证。';
                }
                $sms_rs = SSms::send($phone, $msg);
                $sms_rs = 1;
                if ($sms_rs == true) {
                    return $code;
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    /*
     * 验证手机验证码是否过期
     */
    public static function verifyPhoneValidation($code, $phone, $type, $upstate = true) {
        $time = time();
        $expire_time = time() - 1200; // 20分钟内有效
        $condition = array(
            'phone' => $phone,
            'type' => $type,
            'code' => $code,
            'state' => 0,
            'create_time > ' . $expire_time
        );
        $mdl = SModel::init('core_model_mb_phonevalidation');
        $rs = $mdl->get($condition);
        if (empty($rs)) { // 验证码记录不存在
            return false;
        } else {
            if ($upstate == true) {
                $mdl->set('state', 1);
                $mdl->save();
            }
            return true;
        }
    }
    
    /*
     * global.php 中需要使用
     */
    public static function createUrlRule() {
    	return array(
    	);
    }
    
    /*
     * 是否微信客户端
     */
    public static function isWeixin() {
    	if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
    		return true;
    	}
    	return false;
    }
    
    /**
     * 判断是否有权限
     * @param string $path URL路径
     * @param string $uid 用户ID
     * @return number 是否有权限 1表示有 0表示无
     */
    public static function isAuth($path, $uid) {
    	
    	// 获取角色id
    	$model = new SModel();
    	$user = $model->db->selectOne('cp_user', "user_id = $uid", 'user_id, role_id');
    	$roleid = $user['role_id'];
    	if( $roleid == 1 ) { // 超级管理员拥有所有权限
    		return 1;
    	}
    	
    	// 从缓存中获取用户所有的权限数据（url）{v=>[0=>array(), 1=>array()]}
    	$memcache = new Cache_Memcache();
    	$memcache->init(array('host'=>'127.0.0.1', 'host'=>11211));
    	$userAuthUrls = $memcache->get($uid)->v;
    	$roleAuthUrls = $memcache->get($roleid)->v;
    	//var_dump($userAuthUrls);
    	if( empty( $userAuthUrls ) ) $userAuthUrls = array();
    	if( empty( $roleAuthUrls ) ) $roleAuthUrls = array();
    	$paths = array_merge($userAuthUrls, $roleAuthUrls);
    	if( empty( $paths ) ) { // 缓存中没有权限数据（url），重新获取权限数据（url）
    		
    		// 重新获取用户权限（url）
    		$userAuthUrls = self::updateUserAuthCache($uid);
    		
    		// 重新获取角色权限（url）;
    		$roleAuthUrls = self::updateRoleAuthCache($roleid);
    		
    		//所有的权限（url）
    		$paths = array_merge($userAuthUrls, $roleAuthUrls);
    		
    	}
    	
    	// 判断$path是否在权限数据（url）中
    	if(in_array($path, $paths)) {
    		return 1;
    	} else {
    		$path = explode('/', $path)[1];
    		if(in_array('/'.$path, $paths)) {
    			return 1;
    		} else {
	    		return 0;
    		}
    	}
    }
    
    /**
     * 更新用户权限缓存
     * @param int $uid 用户ID
     */
    public static function updateUserAuthCache($uid) {
    	
    	// memcache缓存对象
    	$memcache = new Cache_Memcache();
    	$memcache->init(array('host'=>'127.0.0.1', 'host'=>11211));
    	//$userAuthUrls = $memcache->get($uid)->v;
    	
    	$model = new SModel();
    	// 重新获取用户权限（url）
    	$leftjoin = array(
    			'cp_auth b' => 'b.auth_id = a.auth_id'
    	);
    	$fl = 'a.*, b.name, b.route, b.controller, b.method';
    	$userAuth = $model->db->select('cp_user_auth a', "a.user_id = $uid", $fl, '', '', $leftjoin)->items;
    	$userAuthUrls = array();
    	foreach ($userAuth as $ua) {
    		$userAuthUrls[] = $ua['route'];
    	}
    	
    	// 更新用户权限到缓存
    	$memcache->set($uid, $userAuthUrls);
    	
    	return $userAuthUrls;
    }
    
    /**
     * 更新角色权限缓存
     * @param int $roleid 角色ID
     */
    public static function updateRoleAuthCache($roleid) {
    	
    	// memcache缓存对象
    	$memcache = new Cache_Memcache();
    	$memcache->init(array('host'=>'127.0.0.1', 'host'=>11211));
    	
    	$model = new SModel();
    	// 重新获取角色权限（url）;
    	$leftjoin = array(
    			'cp_auth b' => 'b.auth_id = a.auth_id'
    	);
    	$fl = 'a.*, b.name, b.route, b.controller, b.method';
    	$roleAuth = $model->db->select('cp_role_auth a', "a.role_id = $roleid", $fl, '', '', $leftjoin)->items;
    	$roleAuthUrls = array();
    	foreach ($roleAuth as $ra) {
    		$roleAuthUrls[] = $ra['route'];
    	}
    	
    	// 更新角色权限到缓存
    	$memcache->set($roleid, $roleAuthUrls);
    	
    	return $roleAuthUrls;
    }

    /**
     * 数字转人民币大写
     * @param unknown $num 数字
     * @param string $mode 转换模式
     * @param string $sim 
     * @return string 人民币大写
     */
    public static function numToRMB($num, $mode=true, $sim=true){
	    if(!is_numeric($num)) return '含有非数字非小数点字符！';
	    $char = $sim ? array('零','一','二','三','四','五','六','七','八','九')
	    : array('零','壹','贰','叁','肆','伍','陆','柒','捌','玖');
	    $unit = $sim ? array('','十','百','千','','万','亿','兆')
	    : array('','拾','佰','仟','','萬','億','兆');
	    $retval = $mode ? '元':'点';
	    //小数部分
	    if(strpos($num, '.')){
	        list($num,$dec) = explode('.', $num);
	        $dec = strval(round($dec,2));
	        if($mode){
	            $retval .= "{$char[$dec['0']]}角{$char[$dec['1']]}分";
	        }else{
	            for($i = 0,$c = strlen($dec);$i < $c;$i++) {
	                $retval .= $char[$dec[$i]];
	            }
	        }
	    }
	    //整数部分
	    $str = $mode ? strrev(intval($num)) : strrev($num);
	    for($i = 0,$c = strlen($str);$i < $c;$i++) {
	        $out[$i] = $char[$str[$i]];
	        if($mode){
	            $out[$i] .= $str[$i] != '0'? $unit[$i%4] : '';
	                if($i>1 and $str[$i]+$str[$i-1] == 0){
	                $out[$i] = '';
	            }
	                if($i%4 == 0){
	                $out[$i] .= $unit[4+floor($i/4)];
	            }
	        }
	    }
	    $retval = join('',array_reverse($out)) . $retval;
	    return $retval;
	}
    
}
