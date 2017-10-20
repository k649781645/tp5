<?php
namespace app\controller;

use think\Controller;
use think\Request;
use wx\AccessToken;

class Index extends Controller
{
    public function index()
    {
        $Wx = new AccessToken('txl');
        dump($Wx->getAccessToken());
        return $this->fetch();
    }
}
