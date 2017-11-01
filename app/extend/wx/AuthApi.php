<?php

namespace wx;

class AuthApi
{
    private $access_token;
    private $angetId = 1000002;

    /**
     * 通过构造函数获取需要的access_token
     */
    public function __construct() {
        $this->access_token = get_access_token($this->angetId);
    }

    /**
     * 获取授权登录用户的用户信息（UserId）
     * @param [striing] $access_token 调用接口凭证
     * @param [string] $code 用户授权登录后企业微信返回的code
     * @return
     */
    public function getUserId($code)
    {
        $res = http_get("https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token=$this->access_token&code={$code}");
        return $res;
    }

    /**
     * 通过code获取用户信息
     */
    public function getUserInfoByCode($code)
    {

    }

}