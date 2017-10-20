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
        echo($data);
        //return $this->fetch();
    }
}
