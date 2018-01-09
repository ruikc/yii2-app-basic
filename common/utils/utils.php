<?php

namespace app\common\utils;

use yii\httpclient;

/**
 * 与系统业务无关公共类库，这个文件里写与系统业务无关的公共函数
 * Class String
 */
class utils
{
    /**
     * 生成唯一键的方法
     * @name: uniqueKey
     * @param string $prefix
     * @return mixed|string
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/6 上午9:20
     */
    public static function uniqueKey($prefix = '') {
        $prefix = !$prefix ? date('Ymd') : $prefix;
        $key = uniqid($prefix, true);
        $key = str_replace('.', '', $key);
        return $key;
    }


    /**
     * 截取字符串长度
     * @name: getShort
     * @param $str
     * @param int $length
     * @param string $ext
     * @return string
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/5 下午5:06
     */
    public static function getShort($str, $length = 40, $ext = '...') {
        $str = htmlspecialchars($str);
        $str = strip_tags($str);
        $str = htmlspecialchars_decode($str);
        $strlenth = 0;
        $output = '';
        preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/", $str, $match);
        foreach ($match[0] as $v) {
            preg_match("/[\xe0-\xef][\x80-\xbf]{2}/", $v, $matchs);
            if (!empty($matchs[0])) {
                $strlenth += 1;
            } elseif (is_numeric($v)) {
                $strlenth += 1;    // 字符字节长度比例 汉字为1
            } else {
                $strlenth += 1;    // 字符字节长度比例 汉字为1
            }
            if ($strlenth > $length) {
                $output .= $ext;
                break;
            }
            $output .= $v;
        }
        return $output;
    }


    /**
     * 统计字数长度，汉字与字母全是一个字符处理
     * @name: strLen
     * @param $str
     * @return int
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/5 下午5:07
     */
    public static function strLen($str) {
        $str = htmlspecialchars_decode($str);
        $str = strip_tags($str);
        $str = htmlspecialchars_decode($str);
        $strlenth = 0;
        preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/", $str, $match);
        foreach ($match[0] as $v) {
            preg_match("/[\xe0-\xef][\x80-\xbf]{2}/", $v, $matchs);
            if (!empty($matchs[0])) {
                $strlenth += 1;
            } elseif (is_numeric($v)) {
                $strlenth += 1;    // 字符字节长度比例 汉字为1
            } else {
                $strlenth += 1;    // 字符字节长度比例 汉字为1
            }
        }
        return $strlenth;
    }

    /**
     * 得到浏览器类型
     * @name: getBrowser
     * @return string
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/5 下午5:13
     */
    public static function getBrowser() {
        $agent = $_SERVER["HTTP_USER_AGENT"];
        if (strpos($agent, "rv:11.0"))
            $return = "IE11";
        else if (strpos($agent, "MSIE 10.0"))
            $return = "IE10";
        else if (strpos($agent, "MSIE 9.0"))
            $return = "IE9";
        else if (strpos($agent, "MSIE 8.0"))
            $return = "IE8";
        else if (strpos($agent, "MSIE 7.0"))
            $return = "IE7";
        else if (strpos($agent, "MSIE 6.0"))
            $return = "IE6";
        else if (strpos($agent, "Firefox"))
            $return = "Firefox";
        else if (strpos($agent, "Opera"))
            $return = "Opera";
        else if (strpos($agent, "OPR"))
            $return = "Opera";
        else if (strpos($agent, "Chrome"))
            $return = "Chrome";
        else if (strpos($agent, "Safari"))
            $return = "Safari";
        else $return = 'other';
        return $return;
    }

    /**
     * 得到系统类型
     * @name: getOs
     * @return string
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/5 下午5:13
     */
    public static function getOs() {
        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            $OS = $_SERVER['HTTP_USER_AGENT'];
            if (preg_match('/NT 5.0/i', $OS)) {
                $OS = 'Windows 2000';
            } elseif (preg_match('/NT 5.1/i', $OS) || preg_match('/NT 5.2/i', $OS)) {
                $OS = 'Windows XP';
            } elseif (preg_match('/NT 6.0/i', $OS)) {
                $OS = 'Windows Vista';
            } elseif (preg_match('/NT 6.1/i', $OS)) {
                $OS = 'Windows 7';
            } elseif (preg_match('/NT 6.2/i', $OS)) {
                $OS = 'Windows 8';
            } elseif (preg_match('/NT 6.3/i', $OS)) {
                $OS = 'Windows 8.1';
            } elseif (preg_match('/NT 10.0/i', $OS)) {
                $OS = 'Windows 10';
            } elseif (preg_match('/mac/i', $OS)) {
                $OS = 'MAC';
            } elseif (preg_match('/linux/i', $OS)) {
                $OS = 'Linux';
            } elseif (preg_match('/unix/i', $OS)) {
                $OS = 'Unix';
            } elseif (preg_match('/bsd/i', $OS)) {
                $OS = 'BSD';
            } else {
                $OS = 'Other';
            }

        } else {
            $OS = "获取操作系统信息失败！";
        }
        return $OS;
    }

    /**
     * 加密函数
     * @name: encodeSecret
     * @param $txt
     * @param null $key
     * @return string
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/5 下午5:18
     */
    public static function encodeSecret($txt, $key = 'rstuvwxyzABCDEFGHIJ') {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-=_";
        $nh = rand(0, 64);
        $ch = $chars [$nh];
        $mdKey = md5($key . $ch);
        $mdKey = substr($mdKey, $nh % 8, $nh % 8 + 7);
        $txt = base64_encode($txt);
        $tmp = '';
        $k = 0;
        for ($i = 0; $i < strlen($txt); $i++) {
            $k = $k == strlen($mdKey) ? 0 : $k;
            $j = ($nh + strpos($chars, $txt [$i]) + ord($mdKey [$k++])) % 64;
            $tmp .= $chars [$j];
        }
        return $ch . $tmp;
    }

    /**
     * 解密函数
     * @name: decodeSecret
     * @param $txt
     * @param null $key
     * @return bool|string
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/5 下午5:18
     */
    public static function decodeSecret($txt, $key = 'rstuvwxyzABCDEFGHIJ') {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-=_";
        $ch = $txt [0];
        $nh = strpos($chars, $ch);
        $mdKey = md5($key . $ch);
        $mdKey = substr($mdKey, $nh % 8, $nh % 8 + 7);
        $txt = substr($txt, 1);
        $tmp = '';
        $k = 0;
        for ($i = 0; $i < strlen($txt); $i++) {
            $k = $k == strlen($mdKey) ? 0 : $k;
            $j = strpos($chars, $txt [$i]) - $nh - ord($mdKey [$k++]);
            while ($j < 0)
                $j += 64;
            $tmp .= $chars [$j];
        }
        return base64_decode($tmp);
    }

    /**
     * 产生随机数
     * @name: random
     * @param int $length
     * @param int $numeric
     * @return string
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/5 下午5:21
     */
    public static function random($length = 6 , $numeric = 0) {
        PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
        if($numeric) {
            $hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
        } else {
            $hash = '';
            $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz';
            $max = strlen($chars) - 1;
            for($i = 0; $i < $length; $i++) {
                $hash .= $chars[mt_rand(0, $max)];
            }
        }
        return $hash;
    }

    /**
     * 全角转半角的操作
     * @name: quanToBan
     * @param $str
     * @return null|string|string[]
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/5 下午5:23
     */
    public static function quanToBan($str){
        $str = iconv('utf-8', 'gbk', $str);
        $str = preg_replace('/\xa3([\xa1-\xfe])/e', 'chr(ord(\1)-0x80)', $str);
        return $str;
    }

    /**
     * 格式化成小时的操作
     * @name: hourFormat
     * @param $num
     * @param int $round
     * @return float
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/5 下午5:31
     */
    public static function hourFormat($num,$round=0){
        if($round>0){
            $hour =round($num/3600, $round);//小时后面保留几位数
        }else{
            $hour = floor($num/3600);//精确到小时
        }
        return $hour;
    }

    /**
     * 日期转换为文字形式
     * @name: dateToWord
     * @author: xiawei <xiawei@soocedu.com>
     * @time: 2017/3/7 9:46
     */
    public static function dateToWord($dt=''){
        $len = strlen($dt);
        if($len != 8){
            return '';
        }
        $num = array(0=>'零',1=>'一',2=>'二',3=>'三',4=>'四',5=>'五',6=>'六',7=>'七',8=>'八',9=>'九');
        $date[0] = substr($dt, 0, 4);
        $date[1] = substr($dt, 4, 2);
        $date[2] = substr($dt, 6, 2);
        foreach($date as $key => $val){
            $date[$key] = str_split($val);
        }
        $show = array();
        //年
        $show[0] = $num[$date[0][0]].$num[$date[0][1]].$num[$date[0][2]].$num[$date[0][3]];
        //月
        if($date[1][0] == 0){
            $show[1] = $num[$date[1][1]];
        }else if($date[1][1] == 0){
            $show[1] = '十';
        }else{
            $show[1] = '十'.$num[$date[1][1]];
        }
        //日
        if($date[2][0] == 0){
            $show[2] = $num[$date[2][1]];
        }else if($date[2][0] == 1){
            $show[2] = '十';
        }else{
            $show[2] = $num[$date[2][0]].'十';
        }
        if($date[2][0]!=0 && $date[2][1] != 0){
            $show[2] .= $num[$date[2][1]];
        }
        return $show;
    }

    /**
     * 得到当前域名
     * @name: getHost
     * @return string
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/7 下午2:30
     */
    public static function getHost(){
        $script_name = explode('/',$_SERVER['SCRIPT_NAME']);
        unset($script_name[count($script_name)-1]);
        $server_port = '';
        if( $_SERVER['SERVER_PORT'] != '80' ){
            $server_port = ':'.$_SERVER['SERVER_PORT'];
        }
        return 'http://'.$_SERVER['HTTP_HOST'].$server_port.implode('/',$script_name).'/';
    }



    /**
     * 检查是否为email地址
     * @name: isEmail
     * @param $email
     * @return bool
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/5 下午5:08
     */
    public static function isEmail($email) {
        return preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/i", $email) !== 0;
    }

    /**
     * 检查是否为手机号码
     * @name: isTelephone
     * @param $str
     * @return bool
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/5 下午5:08
     */
    public static function isTelephone($str) {
        return preg_match("/1[34587]{1}\d{9}$/i", $str) !== 0;
    }

    /**
     * 是否为身份证号
     * @name: isIdentitycard
     * @param $str
     * @return bool
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/5 下午5:10
     */
    public static function isIdentitycard($str) {
        return strlen($str) == 15 || strlen($str) == 18;
    }

    /**
     * 是否为手机访问
     * @name: isMobile
     * @return bool
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/5 下午5:11
     */
    public static function isMobile() {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array(
                'android', 'iphone', 'ipad', 'windows phone'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        return false;
    }


    /**
     * 对curl远程请求返回内容数组处理
     * @name: xmlToArray
     * @param $xml
     * @return mixed
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/5 下午5:20
     */
    public static function xmlToArray($xml) {
        $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
        if (preg_match_all($reg, $xml, $matches)) {
            $count = count($matches[0]);
            for ($i = 0; $i < $count; $i++) {
                $subxml = $matches[2][$i];
                $key = $matches[1][$i];
                if (preg_match($reg, $subxml)) {
                    $arr[$key] = xml_to_array($subxml);
                } else {
                    $arr[$key] = $subxml;
                }
            }
        }
        return $arr;
    }

    /**
     * 远程获取或提交数据
     * @name: curlData
     * @param $url
     * @param array $data
     * @param string $method
     * @param array $headers
     * @return httpclient\Request
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/6 上午10:42
     */
    public static function curlData($url,$data=[],$method='get',$headers=[]){
        $client = new httpclient\Client();
        $request = $client->createRequest()
            ->setMethod($method)
            ->setUrl($url)
            ->addHeaders($headers);
        if (is_array($data)) {
            $request->setData($data);
        } else {
            $request->setContent($data);
        }
        return $request->send();
    }


    /**
     * 递归创建目录
     * @name: mkDirs
     * @param $dir
     * @return bool
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/5 下午5:15
     */
    public static function mkDirs($dir) {
        if(!is_dir($dir)) {
            if(!static::mkDirs(dirname($dir))){
                return false;
            }
            if(!mkdir($dir,0777)){
                return false;
            }
        }
        return true;
    }

    /**
     * 递归删除某目录
     * @name: rmDirs
     * @param $dirname
     * @return bool
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/5 下午5:16
     */
    public static function rmDirs($dirname) {
        if (!file_exists($dirname)) {
            return false;
        }
        if (is_file($dirname) || is_link($dirname)) {
            return unlink($dirname);
        }
        $dir = dir($dirname);
        if($dir){
            while (false !== $entry = $dir->read()) {
                if ($entry == '.' || $entry == '..') {
                    continue;
                }
                static::rmDirs($dirname . DIRECTORY_SEPARATOR . $entry);
            }
        }
        $dir->close();
        return @rmdir($dirname);
    }


    /**
     * 得到文件扩展名
     * @name: getFileExt
     * @param $filename
     * @return string
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/5 下午5:23
     */
    public static function getFileExt($filename){
        $filear = explode('.',$filename);
        $num = count($filear);
        return  $num == 1 ? 'jpg' : strtolower($filear[$num-1]);
    }

    /**
     * 获取视频文件名
     * @name: getVideoName
     * @param $filename
     * @param $num
     * @return mixed
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/5 下午5:29
     */
    public static function getVideoName($filename,$num){
        $file = str_replace('_0.',"_$num.",$filename);
        return $file;
    }

    /**
     * 返回视频清晰度
     * @name: getVideoDefinition
     * @param $num
     * @return mixed
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/5 下午5:30
     */
    public static function getVideoDefinition($num=0){
        $view = ['标清','高清','超清'];
        return $view[$num];
    }


    /**
     * 设置七牛key的操作
     * @name: getKey
     * @param string $fjid
     * @return string
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/5 下午5:25
     */
    public static function getKey($key=''){
        if(empty($key)){
            return date('Ymd',time()).'_'.uniqid('qn');
        }else{
            return date('Ymd',time()).'_'.$key;
        }
    }

    /**
     * 判断七牛上传扩展名
     * @name: getVideoExt
     * @param $persistentOps
     * @return string
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/5 下午5:26
     */
    public static function getVideoExt($persistentOps){
        return strpos($persistentOps,'m3u8') === false ? 'mp4' : 'm3u8';
    }

    /**
     * 设置七牛上传转码的参数
     * @name: getPersistentOps
     * @param $persistentOps
     * @param $bucket
     * @param string $key
     * @return string
     * @author: rickeryu <lhyfe1987@163.com>
     * @time: 2017/12/5 下午5:28
     */
    public static function getPersistentOps($persistentOps,$bucket,$key=''){
        $perar = explode(';',$persistentOps);
        $restr = array();
        $getkey = static::getKey($key);
        foreach($perar as $key => $val){
            $ext = static::getVideoExt($val);
            $qnkey = $getkey.'_'.$key.'.'.$ext;
            $restr[] = $val.'|saveas/'.base64_encode($bucket.':'.$qnkey);
        }
        return implode(';',$restr);
    }



}