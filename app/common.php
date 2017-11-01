<?php

/**
 * GET 请求
 * @param string $url
 */
function http_get($url){
    $oCurl = curl_init();
    if(stripos($url,"https://")!==FALSE){
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
    }
    curl_setopt($oCurl, CURLOPT_URL, $url);
    curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($oCurl, CURLOPT_VERBOSE, 1);
    //curl_setopt($oCurl, CURLOPT_HEADER, 1);

    $sContent = curl_exec($oCurl);
    // $aStatus = curl_getinfo($oCurl);
    //$sContent = execCURL($oCurl);
    curl_close($oCurl);

    return $sContent;
}
/**
 * POST 请求
 * @param string $url
 * @param array $param
 * @param boolean $post_file 是否文件上传
 * @return string content
 */
function http_post($url,$param,$post_file=false){
    $oCurl = curl_init();

    if(stripos($url,"https://")!==FALSE){
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
    }
    if(PHP_VERSION_ID >= 50500 && class_exists('\CURLFile')){
        $is_curlFile = true;
    }else {
        $is_curlFile = false;
        if (defined('CURLOPT_SAFE_UPLOAD')) {
            curl_setopt($oCurl, CURLOPT_SAFE_UPLOAD, false);
        }
    }

    if($post_file) {
        if($is_curlFile) {
            foreach ($param as $key => $val) {
                if(isset($val["tmp_name"])){
                    $param[$key] = new \CURLFile(realpath($val["tmp_name"]),$val["type"],$val["name"]);
                }else if(substr($val, 0, 1) == '@'){
                    $param[$key] = new \CURLFile(realpath(substr($val,1)));
                }
            }
        }
        $strPOST = $param;
    }else{
        $strPOST = json_encode($param);
    }

    curl_setopt($oCurl, CURLOPT_URL, $url);
    curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($oCurl, CURLOPT_POST,true);
    curl_setopt($oCurl, CURLOPT_POSTFIELDS,$strPOST);
    curl_setopt($oCurl, CURLOPT_VERBOSE, 1);
    //curl_setopt($oCurl, CURLOPT_HEADER, 1);

    $sContent = curl_exec($oCurl);
    // $aStatus  = curl_getinfo($oCurl);

    //$sContent = execCURL($oCurl);
    curl_close($oCurl);

    return $sContent;
}

/**
 * 执行CURL请求，并封装返回对象
 */
function execCURL($ch){
    $response = curl_exec($ch);
    $error    = curl_error($ch);
    $result   = array( 'header' => '',
                     'content' => '',
                     'curl_error' => '',
                     'http_code' => '',
                     'last_url' => '');

    if ($error != ""){
        $result['curl_error'] = $error;
        return $result;
    }

    $header_size = curl_getinfo($ch,CURLINFO_HEADER_SIZE);
    $result['header'] = str_replace(array("\r\n", "\r", "\n"), "<br/>", substr($response, 0, $header_size));
    $result['content'] = substr( $response, $header_size );
    $result['http_code'] = curl_getinfo($ch,CURLINFO_HTTP_CODE);
    $result['last_url'] = curl_getinfo($ch,CURLINFO_EFFECTIVE_URL);
    $result["base_resp"] = array();
    $result["base_resp"]["ret"] = $result['http_code'] == 200 ? 0 : $result['http_code'];
    $result["base_resp"]["err_msg"] = $result['http_code'] == 200 ? "ok" : $result["curl_error"];

    return $result;
}

//给URL地址追加参数
function appendParamter($url,$key,$value){
    return strrpos($url,"?",0) > -1 ? "$url&$key=$value" : "$url?$key=$value";
}

//生成指定长度的随机字符串
function createNonceStr($length = 16) {
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  $str = "";
  for ($i = 0; $i < $length; $i++) {
    $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
  }
  return $str;
}

//读取本地文件
function get_php_file($filename) {
    if(file_exists($filename)){
        return trim(substr(file_get_contents($filename), 15));
    }else{
        return '{"expire_time":0}';
    }
}
//写入本地文件
function set_php_file($filename, $content) {
    $fp = fopen($filename, "w");
    fwrite($fp, "<?php exit();?>" . $content);
    fclose($fp);
}

//根据应用ID获取应用配置
function getConfigByAgentId($agentId){
    $configs = config('wx.apps');;
    foreach ($configs as $key => $value) {
        if($value['AgentId'] == $agentId){
            $config = $value;
            break;
        }
    }
    $config = $config ? $config : array();
    return $config;
}

/**
 * 数组转换为对象（传入非数组原样返回）
 * @param [array] $arr 要转换为对象的数组
 * @return [object/array] 传入数组时返回对象，否则原样返回
 * @author 649781645@qq.com
 */
function array_to_object($arr){
    if(is_array($arr)){
        $object = new StdClass();
        foreach($arr as $key => $value){
            $object->$key = $value;
        }
    }else{
        $object = $arr;
    }
    return $object;
}

/**
 * 获取access_token助手函数
 * @param [string] $agentId 应用ID,获取通信录token留空
 * @return 返回token字符
 * @author 649781645@qq.com
 */
function get_access_token($agentId='')
{
    $wx = new \wx\AccessToken($agentId);
    $access_token = $wx->getAccessToken();
    return $access_token;
}