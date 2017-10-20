<?php
namespace wx;

class AccessToken
{
    private $corpId;
    private $secret;
    private $agentId;
    private $appConfigs;

    /**
     * AccessToken构造器
     * @param [Number] $agentId 两种情况：1是传入字符串“txl”表示获取通讯录应用的Secret；2是传入应用的agentId
     */
    public function __construct($agentId) {
        $this->appConfigs = arrayToObject(config('wx'));
        $this->corpId = $this->appConfigs->CorpId;
        $this->secret = "";
        $this->agentId = $agentId;

        //由于通讯录是特殊的应用，需要单独处理
        if($agentId == "txl"){
            $this->secret = $this->appConfigs->TxlSecret;
        }else{
            $config = getConfigByAgentId($agentId);

            if($config){
                $this->secret = $config->Secret;
            }
        }
    }


    /**
     * @param [text] $corpid 企业ID
     * @param [text] $secret 应用的凭证密钥
     * return {"errcode":0,"errmsg":"ok","access_token":"dL4nQPluiy46X6usj8tvAXRQpSN9BiOQskhjDHMWeDI0qkU0CzZQY5px264HqrhWvxwVTw0U3RG1BtgW5kRHCt4XCWbYlaIa6n1lp0veTfpVWBb9qfGx4kFYkQ3S0hVISDXralXrtkqq8OvK9mVPIb3vUzJmoUgK5OPmm4Am4hM1zld44bdYu9dbiZmiHTjLvRSQbgHbDlvEdqV_8ecWEg","expires_in":7200}
     */
    public function getAccessToken($corpid='',$secret='')
    {
        $data = cache('wx_access_token');
        if( $data['expire_time'] < time() )
        {
            echo '1';
            $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->corpId&corpsecret=$this->secret";
            $access_token = json_decode(http_get($url)["content"]);
            if($access_token)
            {
                $data['access_token'] = $access_token;
                $data['expire_time'] = time() + 7000;
                cache('wx_access_token', $data, time()+7000);
            }
        }else
        {
            echo '2';
            $data  = cache('wx_access_token');
            $access_token = $data['access_token'];
        }
        return $access_token;
    }
}
