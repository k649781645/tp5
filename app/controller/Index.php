<?php
namespace app\controller;

use think\Controller;
use think\Log;
use wx\TxlApi;

class Index extends Controller
{
    //企业微信登录
    public function login()
    {
        $wx = array(
            'appid' => config('wx.CorpId'),//企业微信的CorpID，在企业微信管理端查看
            'agentid' => 1000002,//授权方的网页应用ID，在具体的网页应用中查看
            'redirect_uri' => UrlEncode(url('index/test','','',true)),//重定向地址，需要进行UrlEncode
            'state' => '',//用于保持请求和回调的状态，授权请求后原样带回给企业。该参数可用于防止csrf攻击（跨站请求伪造攻击），建议企业带上该参数，可设置为简单的随机数加session进行校验
            'href' => '',//自定义样式链接，企业可根据实际需求覆盖默认样式
        );
        $this->assign('wx',$wx);
        return $this->fetch();
    }

    public function test()
    {
        $code = input('get.code');
        $wx = new \wx\AuthApi;
        $res = json_decode($wx->getUserId($code));
        $userId = $res->UserId;
        $txl = new \wx\TxlApi;
        $data = $txl->getUserInfoByUserId($userId);
        dump(json_decode($data));
        //return $data;
    }

    //首页
    public function index()
    {
        $res = new \wx\AccessToken();
        $res->getAccessToken();
        return $this->fetch();
    }

    //通信录
    public function txl()
    {
        $res = new TxlApi();
        $data = json_decode($res->getUserByDepartmentId());
        if($data->errcode === 0)
        {
            $data = $data->userlist;
        }
        else
        {
            $data = array();
        }
        $data =  json_encode($data);
        $this->assign('data',$data);
        return $this->fetch();
    }

    //更新用户信息（done）
    public function updateUser($data='')
    {
        $res = new TxlApi();
        $data = input('post.');
        if(input('post.flag') =='enable')
        {
            $data['enable'] = ($data['enable']==1) ? 0 : 1;//取反
        }
        $data = $res->updateUser($data);
        return $data;
    }

    //获取企业应用信息（TODO）
    public function getAgentInfo()
    {
        $access_token = get_access_token();
        $data = http_get("https://qyapi.weixin.qq.com/cgi-bin/agent/list?access_token={$access_token}");
        dump($data);exit;
        return $data;
    }

    public function getDepartmentById($id=1)
    {
        $res = new TxlApi();
        $data = json_decode($res->getDepartmentsById($id));
        if($data->errcode === 0)
        {
            $data = $data->department;
        }
        else
        {
            $data = array();
        }
        return trim(json_encode($data),'[]');
    }

    public function getUserById($id=1,$fetch_child=true)
    {
        $res = new TxlApi();
        $data = json_decode($res->getUserById($id));
        if($data->errcode === 0)
        {
            $data = array(
                'code' => 0,
                'msg'  => '',
                'count'=> 100,
                'data' => $data->userlist
            );
        }
        else
        {
            $data = array();
        }
        return $data;
    }

}
