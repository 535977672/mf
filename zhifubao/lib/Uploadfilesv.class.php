<?php

class core_lib_Uploadfilesv {

    public static $host = UPLOAD_FILE_HOST;
    public static $port = '80';
    public static $path = '/upload.php';
    public static $method = 'POST';

    //protected static $store = '';

    /**
     * 上传文件接口
     * 返回上传成功失败的数组
     *
     * @param object $postvar 数据流
     * @param string $file_name 文件名
     * @param string $tmp_name 临时文件名
     * @param string $servers_url 指定上传的地址,该地址需要遵守一定规则
     * @return array
     */
    public static function postfile($postvar, $file_name = "", $tmp_name, $content_type = 1, $servers_url = NULL) {
        $postvar['t_echo'] = 1; //强制显示返回json
        $postvar['verify'] = md5($postvar['name'] . UPLOAD_FILE_KEY);
        $host = self::$host;
        $method = self::$method;
        $path = self::$path;
        $port = self::$port;

        //是否自定义参数
        if (!empty($servers_url)) {
            $url = parse_url($servers_url);
            $host = $url['host'] ? $url['host'] : self::$host;
            $path = $url['path'] ? $url['path'] : self::$path;
            $port = $url['port'] ? $url['port'] : self::$port;
        }

        srand((double) microtime() * 1000000);
        $boundary = "---------------------" . substr(md5(rand(0, 32000)), 0, 10);

        // Build the header
        $header = "POST $path HTTP/1.0\r\n";
        $header .= "Host: $host\r\n";
        $header .= "Content-type: multipart/form-data, boundary=$boundary\r\n";
        // attach post vars
        foreach ($postvar AS $index => $value) {
            $data .="--$boundary\r\n";
            $data .= "Content-Disposition: form-data; name=\"" . $index . "\"\r\n";
            $data .= "\r\n" . $value . "\r\n";
            $data .="--$boundary\r\n";
        }
        
        if ($tmp_name) {
            $data .= "--$boundary\r\n";
            $content_file = join("", file($tmp_name));
            $data .="Content-Disposition: form-data; name=\"upload_file\"; filename=\"$file_name\"\r\n";
            $data .= "Content-Type: image/unknown\r\n\r\n";
            $data .= "" . $content_file . "\r\n";
            $data .="--$boundary--\r\n";
        }
        //$data .="$postvar\r\n";
        $header .= "Content-length: " . strlen($data) . "\r\n\r\n";
        // Open the connection
        // 连接5次的机会
        $rec = 0;
        do {
            $fp = @fsockopen($host, $port, $errno, $errstr, 10);
            $rec++;
        } while (!$fp && $rec < 5);

        if (!$fp) {
            return array('state' => 101, 'msg' => '连接服务器失败 ' . $errno . ' ' . $errstr);
        }

        // then just
        fputs($fp, $header . $data);
        while (!feof($fp)) {
            $return .= fgets($fp);
        }
        fclose($fp);
        if (preg_match_all('(\{.*\})', $return, $matched)) {
            return json_decode($matched[0][0], true);
        } else {
            return array('state' => 100, 'msg' => '未知错误');
        }
        //return $header;
        //return $data;
    }

    protected static function set($type, $key, $name, $value) {
        return null;
    }

    protected static function get($type, $key, $name) {
        return null;
    }

    protected static function del($type, $key, $name) {
        return null;
    }

    public static function getfileurl($path, $name) {
        $url = "{$path}$name";
        return $url;
    }

    protected static function getFilename($group, $id) {
        return null;
    }

    public static function setPrefix($prefix) {
        self::$prefix = $prefix;
    }

    public static function setStore($store) {
        self::$store = $store;
    }

}

/**
  $query['path']="task/$time_yy-$time_mm/$tId/";//任务使用此路径,其它图片或文件使用'opic/$time_yymm/'
  $query['size1']="80x80";
  $query['size2']="640x1000";
  $query['type']="1";
  $query['name']="$newfile";//唯一文件名由自己构造,不能使用上传文件的名字，有可能重复,可以使用自增id、时间截或随机等为文件名
  $query['key']="$tId";//任务为tid(纯数字),其它业务图片或文件自定但不能为纯数字
  Uploadfiles::hsf($host, $method, $path, $query,$_FILES['image']['name'],$_FILES['image']['tmp_name'],$_FILES['image']['type']);
  $host默认为空,

  访问 http://p1.zbjimg.com/img/$key/唯一文件名
  如:http://p1.zbjimg.com/img/69140/irhks2bz.jpg
 * */
?>
