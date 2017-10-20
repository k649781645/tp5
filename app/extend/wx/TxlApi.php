<?php
namespace wx;
/**
 * 企业微信通信录处理类
 */
class TxlApi
{
    private $access_token;

    public function __construct() {
        $this->access_token = get_access_token('string');
    }

    /**
    * 根据部门ID来查询下属的所有子部门
    * @param  [Number] $id 部门ID (默认为1表示根部门)
    */
    public function getDepartmentsById($id=1)
    {
        if($id > 0)
        {
            return http_get("https://qyapi.weixin.qq.com/cgi-bin/department/list?access_token=$this->access_token&id=$id");
        }else
        {
            return '{"errcode":-1,"errmsg":"departmentId is invalid"}';
        }
    }
}