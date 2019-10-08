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

class ToolsController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int $id
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
        if($_POST['root']!="" && !is_dir($_POST['root'])){
            die("指定根目录不存在");
        }

        $code = Util::parseDoc($request->get('doc'));

        $root = !empty($_POST['root']) ? $_POST['root'] : "E:\\www\\server-spring-php-api\\config\\route";

        $code['api'] = explode("/", $code['address']);
        define("ROTE_PATH", $root);
        $file = ROTE_PATH . "./../api.php";
        $api = Util::getapiArr($file);
//        print_r($code);
//        exit();
        $rote = Util::getRoteArr(ROTE_PATH);

        $data["code"] = $code;

        $data["api"] = $api;
        $data["rote"] = $rote;
        $data["root"] = $root;
        $data["act"] = "config";
        $data["width"] = "90%";
        $data["doc"] = view('tools.text', $data);
        return view('tools.doc', $data);
    }

    public function insterCode(Request $request)
    {
        $act = $request->get("act");
        $config = json_decode($request->get("config"), true);
        $code = $request->get("code");

        if ($act == "dao" || $act == "impl") {

            $root = dirname(dirname($request->get("path"))) . "/models/" . $config[$act];
            if (is_file($root)) {
                self::insertNewCode($root, $code);
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
            $root = dirname($request->get("path")) ."/api.php";
            if (is_file($root)) {
                $line = $config[$act];
                self::insertInLine($root, $code,$line);
                die("代码插入成功！");
            } else {
                die("文件不存在");
            }
        }

    }

    public static function insertInLine($file, $code,$line){
        $arr = file($file);
        for($i=0;$i<10;$i++){
            if(trim( $arr[$line-$i]) == "],"){
                $arr[$line-$i] = "        ".$code ."\r\n". $arr[$line-$i];
                $content = implode("", $arr)  ;
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
        if(is_array($arr)){
            $num = count($arr);
            if(trim($arr[$num-1]) == "}"){
                array_pop($arr);
                return $arr;
            }else{
                array_pop($arr);
                return self::removeLast($arr);
            }
        }

    }

}