<?php
namespace app\controller;

use think\Controller;
use wx\TxlApi;

class Index extends Controller
{
    public function index()
    {
        $res = new TxlApi();
        $data = json_decode($res->getUserByDepartmentId());
        if($data->errcode === 0)
        {
            $data = $data->userlist;
        }else
        {
            $data = array();
        }
        $data =  json_encode($data);
        $this->assign('data',$data);
        return $this->fetch();
    }

    public function updateUser($data='')
    {
        $res = new TxlApi();
        $data = input('post.');
        if(input('post.flag') =='enable')
        {
            $data['enable'] = ($data['enable']==1) ? 0 : 1;
        }
        $data = $res->updateUser($data);
        return $data;
    }

    public function getDepartmentById($id=13)
    {
        $res = new TxlApi();
        $data = json_decode($res->getDepartmentsById($id));
        if($data->errcode === 0)
        {
            $data = $data->department;
        }else
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
        }else
        {
            $data = array();
        }
        return $data;
    }

}
