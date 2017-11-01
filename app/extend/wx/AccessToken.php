<?php
namespace wx;

/**
 * 企业微信获取acess_token类，注意：每个应用有独立的secret，所以每个应用的access_token应该分开来获取
 * @param [string] $corpId 企业ID
 * @param [string] $corpsecret 应用的凭证密钥 （分通信录和独立应用）
 * @param [int] $agentId 应用ID
 * @param [array] $appConfigs  应用配置
 */
class AccessToken
{
    private $corpId = 'ww76be1f123c5c4a8a';
    private $secret = '5FjqFSjduVIBx0kYPLoKDuiiD3q__hKGTYqLKr8p7-c';//通信录凭证密钥
    private $agentId;//应用ID
    private $appConfigs = [
        'AppDesc'        => 'Test',
        'AgentId'        => 1000002,
        'Secret'         => 'pDx4OehhZJivTvwqjc1iH_l14lFaHzTpwVdzarH7KKA',//应用凭证密钥
        'Token'          => '',
        'EncodingAESKey' => ''//应用回调模式的加密串，在应用的回调模式里面设置
    ];

    /**
     * AccessToken构造器
     * @param [Number] $agentId 两种情况：1是传入字符串“txl”表示获取通讯录应用的Secret；2是传入应用的agentId
     * @return
     */
    public function __construct($agentId='')
    {
        if( $agentId !== '')
        {
            $this->agentId = $this->appConfigs['AgentId'];
            $this->secret  = $this->appConfigs['Secret'];//应用凭证密钥Secret
        }
    }


    /**
     * 用于获取access_token
     * @return [string]
     */
    public function getAccessToken()
    {
        $token = cache('wx_access_token_'.$this->agentId);//从缓存中读取access_token信息
        if ( $token['expire_time'] > time() )
        {
            //未过期直接从缓存中拿access_token
            $access_token = $token['access_token'];
        }else
        {
            //缓存过期重新获取
            $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->corpId&corpsecret=$this->secret";
            $token = json_decode(http_get($url));
            if ( $token->errcode === 0 )
            {
                //成功请求到token
                $data = array(
                    'access_token' => $token ->access_token,
                    'expire_time'  => time() + 7000,
                );
                $access_token = $token ->access_token;
                cache('wx_access_token_'.$this->agentId, $data, time()+7000);
            }else
            {
                exit('Request access token failed!');
            }
        }
        return $access_token;
    }
}