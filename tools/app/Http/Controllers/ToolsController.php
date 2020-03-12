<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/9/25
 * Time: 19:09
 */

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exceptions\Util;
use App\Exceptions\FirePHPCore\FirePHP;

class ToolsController extends Controller
{
    static $firephp;
    function __construct()
    {
        self::$firephp =  FirePHP::getInstance(true);
    }

    /**
     * Show the profile for the given user.
     *
     * @param int $id
     * @return View
     */
    public function show()
    {
        return view('tools.index', ['user' => '12222']);
    }

    public function parse(Request $request)
    {
        $sql = $request->get("sql");
        $table = "/CREATE TABLE `([\w_]*)`/";
        preg_match($table, $sql, $matches);
        $data['table'] = $matches[1];

        $cloum = "/([\w]+)` (([a-zA-Z]*)\([\d]*\)|(datetime|TEXT)).*(NULL AUTO_INCREMENT COMMENT|COMMENT|NOT NULL AUTO_INCREMENT)? (.*),/i";
        preg_match_all($cloum, $sql, $matches);
        $data['cloum'] = $matches;

        $cloum = "/.*ENGINE=InnoDB .* COMMENT='(.*)'/i";
        preg_match($cloum, $sql, $matches);
        $data['name'] = $matches[1];

        return view('tools.index', ['data' => $data]);
    }


    public function sql(Request $request)
    {
        $file = file_get_contents("/mnt/f/quickstart.sql");
        $file = str_replace('{$CHARSET}', 'utf8mb4', $file);
        $file = str_replace('{$COLLATE_TEXT}', 'utf8mb4_bin', $file);
        $file = str_replace('{$COLLATE}', 'utf8mb4_bin', $file);
        $file = str_replace('{$CHARSET_FULLTEXT}', 'utf8mb4_bin', $file);
        $file = str_replace('{$CHARSET_SORT}', 'utf8mb4_bin', $file);
        $file = str_replace('{$COLLATE_SORT}', 'utf8_unicode_ci', $file);
        $file = str_replace('{$COLLATE_FULLTEXT}', 'utf8_unicode_ci', $file);
        $file = str_replace('{$NAMESPACE}', 'phabricator', $file);
        file_put_contents("/mnt/f/quickstart222.sql", $file);
        die();

//        return view('tools.sql', $data);
    }

    public function apiresult(Request $request)
    {
        if ($_POST['root'] != "" && !is_dir($_POST['root'])) {
            die("指定根目录不存在");
        }

        $code = Util::parseDoc($request->get('doc'));

        $root = !empty($_POST['root']) ? $_POST['root'] : "E:\\www\\server-spring-php-api\\config\\route";

        $code['api'] = explode("/", $code['address']);
        define("ROTE_PATH", $root);
        $file = ROTE_PATH . "./../api.php";
        $api = Util::getapiArr($file);

        $rote = Util::getRoteArr(ROTE_PATH);

        $data["code"] = $code;
        $data["api"] = $api;
        $data["rote"] = $rote;
        $data["root"] = $root;
        $data["islist"] = $request->get('islist');
        $data["act"] = "config";
        $data["width"] = "90%";
//                print_r($data);
//        exit();
        $data["doc"] = view('tools.text', $data);
        return view('tools.doc', $data);
    }

    public function insterCode(Request $request)
    {
        $act = $request->get("act");
        $config = json_decode($request->get("config"), true);
        $code = $request->get("code");

        if ($act == "dao") {

            $root = dirname(dirname($request->get("path"))) . "/models/" . $config[$act];
            if (is_file($root)) {
                self::insertNewCode($root, $code);
                die("代码插入成功！");
            } else {
                die("文件不存在");
            }


        }

        if ($act == "impl") {

            $root = dirname(dirname($request->get("path"))) . "/models/" . $config[$act];
            if (is_file($root)) {
                self::insertImpl($root, $code);
                die("代码插入成功！");
            } else {
                die("文件不存在");
            }


        }

        if ($act == "controller") {
            $root = dirname(dirname($request->get("path"))) . $config[$act];
            if (is_file($root)) {
                self::insertNewCode($root, $code);
                die("代码插入成功！");
            } else {
                die("文件不存在");
            }
        }

        if ($act == "api") {
            $root = dirname($request->get("path")) . "/api.php";
            if (is_file($root)) {
                $line = $config[$act];
                self::insertInLine($root, $code, $line);
                die("代码插入成功！");
            } else {
                die("文件不存在");
            }
        }

    }

    public static function insertImpl($file, $code)
    {
        $arr = file($file);
        $index = false;
        foreach ($arr as $key => $list) {
            $p = "/class [ \w]+Cache/i";
            preg_match($p, $list, $out);
            if (!empty($out)) {
                $index = $key;
                break;
            }
        }

        for ($i = 0; $i < 100; $i++) {
            $text = trim($arr[$index - $i]);
            if ($text == "}") {
                var_dump($text);
                $index = $index - $i;
                break;
            }
        }

        if ($index !== false) {
            $arr[$index] = $code . "\r\n}";
            $content = implode("", $arr);
            file_put_contents($file, $content);
        }
    }

    public static function insertInLine($file, $code, $line)
    {
        $arr = file($file);
        for ($i = 0; $i < 10; $i++) {
            if (trim($arr[$line - $i]) == "],") {
                $arr[$line - $i] = "        " . $code . "\r\n" . $arr[$line - $i];
                $content = implode("", $arr);
                file_put_contents($file, $content);
                break;
            }
        }

    }


    public static function insertNewCode($file, $code)
    {
        $arr = file($file);
        $arr = self::removeLast($arr);
        $content = implode("", $arr) . $code . "\r\n}";
        file_put_contents($file, $content);

    }

    public static function removeLast($arr)
    {
        if (is_array($arr)) {
            $num = count($arr);
            if (trim($arr[$num - 1]) == "}") {
                array_pop($arr);
                return $arr;
            } else {
                array_pop($arr);
                return self::removeLast($arr);
            }
        }

    }

    public function postParse(Request $request)
    {

        //$str = "%5B%7B%22text%22%3A%2211%E5%8F%AC%E5%B9%BF%E4%BA%86%E8%A7%A3%EF%BC%8C201%E8%AD%A6%E6%96%B9%E5%A4%A7%E7%BE%A4%E4%BC%97%EF%BC%8C%E6%B3%A8%E6%84%8F%E6%AD%A4%E4%BA%BA%E4%B8%8B%E4%BE%9B%E4%BE%BF%E5%88%A9%E6%9D%A1%E5%8F%AC%E5%B9%BF%E5%A4%A7%E7%BE%A4%E4%BC%97%EF%BC%8C%E6%B3%A8%E6%84%8F%E6%AD%A4%E4%BA%BA%E4%B8%8B%E4%BE%9B%E4%BE%BF%E5%88%A9%E6%9D%A1%E6%9C%8823%E6%97%A5%EF%BC%8C%E3%80%82%22%2C%22textType%22%3A%22simple%22%7D%2C%7B%22mediaType%22%3A%22img%22%2C%22mediaUrl%22%3A%22http%3A%2F%2Fcdn.static.17k.com%2Fdev%2Fuser%2Fattachment%2F22%2F43%2F4322%2Fsns%2F0%2F20181219%2F1545212801118%281%29.jpg%22%7D%2C%7B%22text%22%3A%22%E6%8D%AE%E4%BA%86%E8%A7%A3%EF%BC%8C201%E8%AD%A6%E6%96%B9%E6%B6%88%E6%81%AF%E7%A7%B0%EF%BC%8C%E7%8A%AF%E7%BD%AA%E5%AB%8C%E7%96%91%E4%BA%BA%E8%A6%83%E4%BA%86%E8%A7%A3%EF%BC%8C201%E8%AD%A6%E6%96%B9%E5%BF%97%E9%92%A2%E5%8F%AC%E5%B9%BF%E5%A4%A7%E7%BE%A4%E4%BC%97%EF%BC%8C%E6%B3%A8%E6%84%8F%E6%AD%A4%E4%BA%BA%E4%B8%8B%E4%BE%9B%E4%BE%BF%E5%88%A9%E6%9D%A1%E7%BD%AA%E6%81%B6%E6%B7%B1%E9%87%8D%EF%BC%8C%E7%A4%BE%E4%BC%9A%E5%8D%B1%E4%BA%86%E8%A7%A3%EF%BC%8C201%E8%AD%A6%E6%96%B9%E9%99%A9%E6%80%A7%E6%9E%81%E5%A4%A7%EF%BC%8C%E4%B8%80%E5%88%BB%E4%B9%9F%E4%B8%8D%E8%83%BD%E5%86%8D%E8%AE%A9%E5%85%B6%E9%80%8D%E9%81%A5%E6%B3%95%E5%A4%96%EF%BC%8C%E5%BF%85%E9%A1%BB%E5%B0%BD%E5%BF%AB%E5%B0%86%E5%85%B6%E7%BC%89%E6%8D%95%E5%BD%92%E6%A1%88%EF%BC%8C%E4%BB%A5%E5%91%8A%E6%85%B0%E4%BA%A1%E8%80%85%EF%BC%8C%E5%BD%B0%E6%98%BE%E6%B3%95%E5%BE%8B%E5%A8%81%E4%B8%A5%EF%BC%8C%E5%8C%A1%E6%89%B6%E7%A4%BE%E4%BC%9A%E6%AD%A3%E4%B9%89%E3%80%82%E7%9B%AE%E5%89%8D%EF%BC%8C%E5%85%AC%E5%AE%89%E6%9C%BA%E5%85%B3%E6%AD%A3%E5%85%A8%E5%8A%9B%E8%BF%BD%E6%8D%95%E8%A6%83%E5%BF%97%E9%92%A2%E3%80%82%22%2C%22textType%22%3A%22simple%22%7D%2C%7B%22mediaType%22%3A%22img%22%2C%22mediaUrl%22%3A%22http%3A%2F%2Fcdn.static.17k.com%2Fdev%2Fuser%2Fattachment%2F22%2F43%2F4322%2Fsns%2F0%2F20181219%2F1545212357479%281%29.jpg%22%7D%2C%7B%22text%22%3A%22%E5%90%8C%E6%97%B6%EF%BC%8C%E5%85%AC%E5%AE%89%E6%9C%BA%E5%85%B3%E4%BA%86%E8%A7%A3%EF%BC%8C201%E8%AD%A6%E6%96%B9%E5%8F%B7%E5%8F%AC%E5%B9%BF%E5%A4%A7%E7%BE%A4%E4%BC%97%EF%BC%8C%E6%B3%A8%E6%84%8F%E6%AD%A4%E4%BA%BA%E4%B8%8B%E4%BE%9B%E4%BE%BF%E5%88%A9%E6%9D%A1%E5%8F%AC%E5%B9%BF%E5%A4%A7%E7%BE%A4%E4%BC%97%EF%BC%8C%E6%B3%A8%E6%84%8F%E6%AD%A4%E4%BA%BA%E4%B8%8B%E4%BE%9B%E4%BE%BF%E5%88%A9%E4%BA%86%E8%A7%A3%EF%BC%8C201%E8%AD%A6%E6%96%B9%E6%9D%A1%E5%8F%AC%E5%B9%BF%E5%A4%A7%E7%BE%A4%E4%BC%97%EF%BC%8C%E6%B3%A8%E6%84%8F%E6%AD%A4%E4%BA%BA%E4%B8%8B%E4%BE%9B%E4%BE%BF%E5%88%A9%E6%9D%A1%E4%BB%B6%E7%9A%84%EF%BC%8C%E5%B0%86%E4%BE%9D%E6%B3%95%E4%BB%8E%E4%B8%A5%E8%BF%BD%E7%A9%B6%E6%B3%95%E5%BE%8B%E8%B4%A3%E4%BB%BB%E3%80%82%5Cn++++%22%2C%22textType%22%3A%22simple%22%7D%5D";
        $doc = $request->get('doc');
        $types = $request->get('types');

        if ($types == 1) {
            $arr = explode("\r\n", $doc);
            $p = "/\((.*)\)/i";
            foreach ($arr as $key => $list) {
                $list = trim($list);
                preg_match($p, $list, $out);
                if (!empty($out)) {
                    $str = str_replace(["'", "\"", " "], "", $out[1]);
                    $code = explode(",", $str);
                    $text = isset($code[2]) && $code[2] == "true" ? $key : "测试-" . $key;
                    $need = isset($code[2]) && $code[2] == "true" ? 'int' : "string";
                    $data['code'][] = [$code[0], $text, $need];
                }
            }
        } elseif ($types == 2) {
            $arr = explode("\r\n", $doc);
            $p = "/(\w+)[\s]+(int|string)+[\s]+(是|否)?[\s]?(.*)/i";
            foreach ($arr as $key => $list) {
                $list = trim($list);
                preg_match($p, $list, $code);
                if (!empty($code)) {
//                    dd($code);
                    $text = isset($code[2]) && $code[2] == "int" ? $key : "测试-" . $code[4] . $key;
                    $need = isset($code[2]) && $code[2] == "true" ? 'int' : "string";
                    $data['code'][] = [$code[1], $text, $need];
                }
            }
        } elseif ($types == 3) {
            $arr = explode("\r\n", $doc);

            foreach ($arr as $key => $list) {
                $code = explode(":", $list);
                $data['code'][] = [$code[0], $code[1], "是"];
            }

        } elseif ($types == 4) {
            $arr = explode("&", $doc);

            foreach ($arr as $key => $list) {
                $code = explode("=", $list);
                $data['code'][] = [$code[0], $code[1], "是"];
            }

        } elseif ($types == 5) {
            $arr = explode("\r\n", $doc);

            foreach ($arr as $key => $list) {
                if (trim($list) != "") {
                    $code = explode("	", $list);
                    $data['code'][] = [$code[0], $code[1], "是"];
                }
            }

        } elseif ($types == 6) {
            $arr = @json_decode($doc);
            foreach ($arr as $key => $list) {
                if (trim($list) != "") {
                    $data['code'][] = [$key, $list, "是"];
                }
            }
        } elseif ($types == 7) {
            $data['code'][] = ["",$doc,"是"];

        } elseif ($types == 8) {


            $xml = trim($doc);
            //XDEBUG_SESSION_START=11936
            $url = $request->get('api');
            $header[] = 'Content-type; text/xml';		#必须声明Content-type为xml
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);		#定义post提交
            curl_setopt($ch, CURLOPT_HEADER, true);	#定义是否显示header头信息
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);  # HEADER信息
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false); # false 不显示返回流 true显示返回信息
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml); # post的数据
            echo curl_exec($ch);
            die();
        }else if ($types == 9){

            preg_match("/.*--data \"(.*)\".*--compressed '(.*)'/",$_POST['doc'],$match);

            if(!empty($match)){
                parse_str($match[1],$arr);
            }
            foreach($arr as $key=>$list){
                $data['code'][] = [$key,$list,'是'];
            }
            $data['code'][] = ['accessToken','4322','是'];
        }
        $data['types'] = $types;
        $data['method'] = $request->get('method');
        $data['api'] = $request->get('api') . ($request->get('params') == "" ? "" : "?") . $request->get('params');
        if($types == 9){
            $data['api'] = $match[2];
        }
//        print_r($data);
        return view('tools.postparse', $data);
    }

    public function fetchApi(Request $request)
    {
        $url = $_REQUEST['api_url'];
        if (trim($_REQUEST['api_method']) == "post") {
            $data = $_REQUEST;
        } else {
            $data = [];
        }
        $data = self::get_head($url, $data);
        $docarr = file("/mnt/e/www/server-spring-php-api/config/api.php");
        self::$firephp->fb($data['header'],
            'header',FirePHP::LOG);
        foreach ($data['header'] as $list) {
            if (strrpos($list, "request_return") !== false && !empty($list)) {
                $arr = json_decode($list, true);
//                print_r($arr);
//                die();
                if (!empty($arr)) {
                    $arr = $arr[1];
                    $arr['api'] = explode("?", substr($arr['url'], strrpos($arr['url'], ".com") + 4))[0];
                    $arr['api_doc'] = self::get_doc($docarr, $arr['api']);
                    $datas[] = $arr;
                }

            }
        }
        if (!isset($datas)) {
            die("配置异常，请检查接口地址，和get,post方法设置<a href='/tools/post'>返回</a>");
        }
//        print_r($datas);
//        die();
        return view('tools.fetchApi', ['data' => $datas]);
    }

    static function get_doc($arr, $api)
    {
        $doc = "";
        foreach ($arr as $key => $list) {
            $list = trim($list);
            if (strrpos($list, $api) !== false) {
//                echo "$list, $api";
//                die();
                $partent = "/^.*'(.*)',[\s]{0,30000}\/\/(.*)$/i";
                preg_match($partent,$list,$out);
                $doc = $out;
            }
            if (strrpos($list, "{") !== false) {
                $temp = str_replace("'", "", explode("=>", explode(",", $list)[0])[1]);
                $str1 = preg_replace("/{(\w+)}/", "", trim($temp));
                $str2 = preg_replace("/(\d+)/", "", trim($api));

                if ($str1 == $str2) {
                    $partent = "/^.*'(.*)',[\s]{0,30000}\/\/(.*)$/i";
                    preg_match($partent,$list,$out);
                    $doc = $out;
                }
            }
        }
        return $doc;
    }

    static function get_head($sUrl, $data = [], $headers = [])
    {

        if(strrpos($sUrl,"accessToken") === false){
            $sUrl .= strrpos($sUrl,"?") === false?"?accessToken=4322":"&accessToken=4322";
        }
        $arr = parse_url($sUrl);
        $host = $arr['host'];
        self::$firephp->fb(['host'=>$host],
            'sUrl',FirePHP::LOG);
        $ip = $_GET['toip']?$_GET['toip']:$_GET['ip'];
        $arr['host'] = $ip;
        $uarr = explode(".com",$sUrl);
        $sUrl = "http://".$ip.$uarr[1];
        self::$firephp->fb(['change->url'=>$sUrl],
            'sUrl',FirePHP::LOG);
        $oCurl = curl_init();
        $header[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36';
        $header[] = 'X-FirePHP: 0.4.4';
        $header[] = 'X-FirePHP-Encoding: zlib-deflate';
        $header[] = 'X-FirePHP-Version: 0.4.4';
        $header[] = 'X-Wf-Max-Combined-Size: 262144';
        $header[] = "Host: $host";
        $header[] = "Connection: keep-alive";
        $header[] = "Content-Type: application/x-www-form-urlencoded";
        if (!empty($headers)) {
            $header = array_merge($header, $headers);
        }
        $cookie = false;
        foreach( $header  as $key=>&$list){
            if(strrpos($list,"Cookie")!==false){
                $list = str_replace('&',';',urldecode($list));
                $list .= ';APP_DEBUG=utPhoIvY$1EzyqBV';
                $cookie = true;
            }
        }

        if(!$cookie){
            $header[] = 'Cookie: APP_DEBUG=utPhoIvY$1EzyqBV';
        }

        $user_agent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36";

        curl_setopt($oCurl, CURLOPT_URL, $sUrl);

        if(!empty( $header)){
            foreach($header as $key=>$lt){
                if(strrpos($lt,"Cookie")!==false){
                    $header[$key] = urldecode(str_replace(";","&",$lt).";APP_DEBUG=utPhoIvY$1EzyqBV";
                    //$header[$key] = "Cookie: accessToken=id=4322&nickname=%E8%B6%85%E7%AE%A1&avatarUrl=http%3A%2F%2Fcdn.static.17k.com%2Ftest%2Fuser%2Favatar%2F02%2F22%2F43%2F4322.jpg-88x88%3Fv%3D1577696580000&e=1599561412&s=ba2fe46b11800573";
                }
            }
        }
        $header = ["Cookie:APP_DEBUG=utPhoIvY$1EzyqBV"];
        self::$firephp->fb(['url'=>$sUrl,'header'=>$header],
            'sUrl',FirePHP::LOG);
        curl_setopt($oCurl, CURLOPT_HTTPHEADER, $header);
//        curl_setopt($oCurl, CURLOPT_HTTPHEADER, array('X-HTTP-Method-Override:PUT' ));
        if (!empty($data)) {
            self::$firephp->fb($data,
                '_____post',FirePHP::LOG);
            curl_setopt($oCurl, CURLOPT_HTTPGET, 1);
//            curl_setopt($oCurl, CURLOPT_POSTFIELDS, is_array($data) ? http_build_query($data) : $data);
        }

        //请求方法
        if(strrpos($_REQUEST['curl'],"-X PUT")!==false){
            $method = 'PUT';
        }else if(strrpos($_REQUEST['curl'],"-X DELETE")!==false){
            $method = 'DELETE';
        }else{
            $method = 'POST';
        }


        curl_setopt($oCurl, 10203,["$host:80:$ip"]);
        curl_setopt($oCurl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($oCurl, CURLOPT_HEADER, true);
        curl_setopt($oCurl, CURLOPT_NOBODY, false);
        curl_setopt($oCurl, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);

        if($method!='POST'){
            curl_setopt($oCurl, CURLOPT_CUSTOMREQUEST,$method); //设置请求方式
            curl_setopt($oCurl, CURLOPT_POSTFIELDS,http_build_query($data));
        }else{
            curl_setopt($oCurl, CURLOPT_POST, !empty($data) ? true : false);
        }

        $sContent = curl_exec($oCurl);
        $headerSize = curl_getinfo($oCurl, CURLINFO_HEADER_SIZE);
//        die(substr($sContent, 0, $headerSize));
        $body['header'] = explode("|", substr($sContent, 0, $headerSize));
        $body['body'] = substr($sContent, $headerSize);
        $body['ip'] = $sUrl;
        curl_close($oCurl);
        self::$firephp->fb($body,
            'body',FirePHP::LOG);
        return $body;
    }

    static function http_build_url($url_arr){
        $new_url = $url_arr['scheme'] . "://".$url_arr['host'];
        if(!empty($url_arr['port']))
            $new_url = $new_url.":".$url_arr['port'];
        $new_url = $new_url . $url_arr['path'];
        if(!empty($url_arr['query']))
            $new_url = $new_url . "?" . $url_arr['query'];
        if(!empty($url_arr['fragment']))
            $new_url = $new_url . "#" . $url_arr['fragment'];
        return $new_url;
    }

    public function doServer(Request $request)
    {

        $str = trim($_REQUEST['curl']);
        if (substr($str, 0, 4) == "curl") {
            $params = $str;
            $h = "/-H[\s]+'([^']+)'/i";
            $d = '/--data(-binary)?[\s]+"([^"]+)"/i';
            $u = "/'http(s)?:\/\/(.*)'/i";

            preg_match_all($h, $params, $harr);
            preg_match($d, $params, $darr);
            preg_match($u, $params, $uarr);
//            print_r($harr);
//                        print_r($darr);
//            print_r($uarr);
//            die();
            $uid = 0;
            if (!empty($uarr)) {
                if (isset($harr[1][0])) {
                    $harr[1][2] = isset($harr[1][2])? urldecode($harr[1][2]):"";
                    $ckstr = array_filter($harr[1], function ($var) {
                        if (strrpos($var,"accessToken") !== false) {
                            return $var[0];
                        }
                    });
                    if(!isset($ckstr[0])){
                        $ckstr = ["accessToken=id=4322"];
                    }
                    $test = urldecode(array_values($ckstr)[0]);
//                    print_r($ckstr);
//                    die();
                    self::$firephp->fb(urldecode(array_values($ckstr)[0]),
                        'coockie',FirePHP::LOG);
                    preg_match("/accessToken=id=(\d+)&/i", urldecode(array_values($ckstr)[0]), $coockie);
                    if (!empty($coockie)) {
                        $uid = $coockie[1];
                    }
                }
                $data = empty($darr) ? [] : $darr[2];
                if(is_string($data)){
                    $str = $data;
                    parse_str($str,$data);
                }
                self::$firephp->fb($data,
                    'url-data',FirePHP::LOG);
                $sUrl = str_replace("'","",$uarr[0]);
                if (strrpos($uarr[1], "?") !== false) {
                    $sUrl .= "&__flush_cache=1&accessToken=" . $uid;
                } else {
                    $sUrl .= "?__flush_cache=1&accessToken=" . $uid;
                }

                $datas = self::toParse($sUrl, $data, $harr[1]);
            }

        } else {
            if (strrpos($str, "?") !== false) {
                $str .= "&__flush_cache=1";
            } else {
                $str .= "?&__flush_cache=1";
            }
            $datas = self::toParse($str);
        }
        if(!isset($datas)){
            $datas = [];
        }

        return view('tools.fetchApi', $datas);
//        print_r($_REQUEST);
    }

    static function toParse($url, $data = [], $header = [])
    {
        $data = self::get_head($url, $data, $header);
        self::$firephp->fb($data['header'],
            'header',FirePHP::LOG);
        $file = env('API_PATH') == null?'/data/web/api.17k.com/config/api.php':env('API_PATH');
        $docarr = file($file);
        $handler = "";

        foreach ($data['header'] as $key => &$list) {
            $list = trim($list);
            if ($list{0} == "[") {
                $list = self::getAllinfo($list, $data['header'], $key);
            }
        }
//        print_r($data);
//        die();
        foreach ($data['header'] as $key => &$list) {
            if (strrpos($list, "request_return") !== false && !empty($list)) {
                $arr = json_decode($list, true);
//                print_r($arr);
//                die();
                if (!empty($arr)) {
                    $arr = $arr[1];
                    $arr['api'] = explode("?", substr($arr['url'], strrpos($arr['url'], ".com") + 4))[0];
                    $api = self::get_doc($docarr, $arr['api']);
                    if(!empty($api)){
                        $arr['api'] = $api[1];
                        $arr['api_doc'] = $api[2];
                    }else{
                        $arr['api'] = $arr['api_doc'] = "api 代码 不是最新的";
                    }
                    $datas[] = $arr;
                    unset($arr);
                }
            }
            if (strrpos($list, "handler_controller") !== false) {

                $handler = json_decode($list, true)[0]['Label'];
            }
        }
        if(!isset($datas)){
            echo $data['body'];
            die();
        }
        self::$firephp->fb($datas,
            'datas',FirePHP::ERROR);
        if (!isset($datas)) {
            die("配置异常，请检查接口地址，和get,post方法设置<a href='/tools/post'>返回</a>");
        }
//        print_r($datas);
        $runtime = array_column($datas, "run_time");
//        dd($runtime);
        array_multisort($runtime, SORT_DESC, $datas);
//        print_r($datas);
//        die();
        return ['data' => $datas, 'handler' => $handler, 'url' => $url,'ip'=>$data['ip']];
    }

    static function getAllinfo($list, $data, $key)
    {
        if ($list{0}=='[' && substr( $list,-1) ==']') {
            return $list;
        } else {
//            var_dump($key);
//            die();
            if (isset($data[$key + 1])) {
                $str = $data[$key + 1];
                $list .= strrpos($str,"X-Wf")!==false?"":$str;
                return self::getAllinfo($list, $data, $key + 1);
            }else{
                return $list;
            }
        }
    }
}
