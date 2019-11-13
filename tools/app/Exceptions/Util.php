<?php
namespace App\Exceptions;

class Util
{
    public static function getapiArr($file)
    {
        $arr = file($file);
        $parten1 = "/'([\w]+)' => \[/i";
        $data = [];
        $i = 0;
        foreach ($arr as $key => &$item) {
            $item = trim($item);
            preg_match($parten1, $item, $out1);
            if (!empty($out1)) {
                $data[$i]['name'] = $out1[1];
                $data[$i]['num'] = $key + 1;
                $data[$i]['all'] = $out1[0];
                $data[$i]['replace'] = $out1[0] . "\r\n" . "__replace__" . "\r\n],";
                $i++;
            }
            if ($item == "],") {
                $index = $i - 1;
                $data[$index]['end'] = $key;
            }
        }
        return $data;
    }

    public static function getRoteArr($dir)
    {
        $arr = scandir($dir);
        $data = [];
        foreach ($arr as &$it) {
            $data[$it] = [];
            if (!in_array($it, ['.', '..'])) {
                $file = ROTE_PATH . '/' . $it;
                $filearr = file($file);

                foreach ($filearr as $item) {
                    $item = trim($item);
                    $parten4 = "/.*'(\w+)@.*/i";
                    preg_match($parten4, $item, $out);

                    if (!empty($out) &&isset($data[$it])&& !in_array($out[1], $data[$it])) {
                        $data[$it][] = $out[1];
                    }
                }

            }
        }
        return $data;
    }

    public static function parseDoc($data)
    {
        $arr = explode("\r\n", $data);
        $arr = array_filter($arr, function ($var) {
            return trim($var) != "";
        });
//    print_r($arr);

        $code['title'] = $arr[0];
        $i = 0;
        $temp = "";
        $deal = 0;
        foreach ($arr as $key => &$item) {
            if (strrpos($item, '请求地址') !== false) {
                $code['address'] = trim(str_replace('请求地址', "", $item));
                $code['address'] = explode("?", $code['address'])[0];
                $arrdata = explode("/", $code['address']);
                $num = count($arrdata);
                if($_POST['ctname']){
                    $code['method'] = $_POST['ctname'];
                }else{
                    $code['method'] = str_replace("-", "", $arrdata[$num - 2] . ucwords($arrdata[$num - 1]));
                }

            }
            $find = '请求方法';
            $name = 'params';
            if (strrpos($item, $find) !== false) {
                $code[$name] = strtoupper(trim(str_replace($find, "", $item)));
            }
            if ($key > 11) {
                $p = "/^([a-zA-Z]+)[\s]+(Integer|string|int|JSON)+[\s]+(是|否)+[\s]+.+$/i";
//            $item = trim($item);
                preg_match($p, $item, $match);
//                die($item);
                if (!empty($match)) {
                    $p2 = "/^.*[\s]+(是|否)[\s]+(.*)$/i";
                    preg_match($p2,$match[0], $match5);

                    $match[5] = empty($match5)?"":"//".$match5[2];
                    if ($match[3] == '是') {
                        $match[4] = self::getMaskName($match[1]);
                        $code['code']['need'][$match[1]] = $match;
                    } else {
                        $match[4] = self::getMaskName($match[1]);
                        $code['code']['noneed'][$match[1]] = $match;
                    }
                } else {
                    $part2 = "/^([a-zA-Z]+).*$/i";
                    preg_match($part2, $item, $match5);
                    if (!empty($match5)) {
                        $deal += 1;
                        if ($deal == 2) {
                            preg_match($p, $temp, $match2);
                            if (!empty($match2)) {
                                if ($match2[3] == '是') {
                                    $code['code']['need'][$match2[1]] = $match2;
                                } else {
                                    $code['code']['noneed'][$match2[1]] = $match2;
                                }
                                $temp = $item;
                                $deal = 0;
                            }

                        } else {
                            $part2 = "/^(int|string).*$/i";
                            preg_match($part2, $item, $match6);
                            if (!empty($match6)) {
                                $temp .= " " . $item;
                            } else {
                                $temp .= $item;
                            }
                        }

                    } else {
                        $part2 = "/^(int|string).*$/i";
                        preg_match($part2, $item, $match6);
                        if (!empty($match6)) {
                            $temp .= " " . $item;
                        } else {
                            $temp .= $item;
                        }

                    }

                }
            }

        }

        //链接中的参数
        if(!empty($code['address'])){
            $p = "/\{([a-zA-Z_-]+)\}/i";
            preg_match($p,$code['address'],$out);
            if(!empty($out) && !isset($code['code']['need'][$out[1]])){
                $code['code']['need'][] = [$out[1],$out[1],'string','是',$out[1],self::getMaskName($out[1])];

            }
            $arr = explode("/",$code['address']);
            $code['api_address'] = "/".$arr[2].'/'.strtolower($code['method']);
        }

//        print_r($code);
//        die();

        return $code;
    }

    public static function getMaskName($str){

        $str2 = strtolower(substr($str,0,round(2,3)).substr($str,strlen($str)-3));

        return $str ;
    }

    public static function randCode($length = 5, $type = 0)
    {
        $arr = array(1 => "0123456789", 2 => "abcdefghijklmnopqrstuvwxyz", 3 => "ABCDEFGHIJKLMNOPQRSTUVWXYZ", 4 => "~@#$%^&*(){}[]|",5=>"0123456789abcdefghijklmnopqrstuvwxyz");
        if ($type == 0) {
            array_pop($arr);
            $string = implode("", $arr);
        } elseif ($type == "-1") {
            $string = implode("", $arr);
        } else {
            $string = $arr[$type];
        }
        $count = strlen($string) - 1;
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $string[rand(0, $count)];
        }
        return $code;
    }

}