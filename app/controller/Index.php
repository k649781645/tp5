<?php
namespace app\controller;

use think\Controller;
use wx\TxlApi;

class Index extends Controller
{
    public function index()
    {
        $res = new TxlApi();
        $data = $res->getDepartmentsById();
        //echo($data);
        return $this->fetch();
    }

    public function test()
    {
        return 'hello word';
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
        //dump(json_encode($data));
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
