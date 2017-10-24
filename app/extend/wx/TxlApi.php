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

    /**
    * 根据部门ID来部门下成员详情
    * @param  [Number] $id 部门ID (默认为1表示根部门)
    * @param  [boolean] $fetch_child 默认递归获取子部门下面成员
    */
    public function getUserById($id=1,$fetch_child=true)
    {
        if($id > 0)
        {
            return http_get("https://qyapi.weixin.qq.com/cgi-bin/user/list?access_token=$this->access_token&department_id=$id&fetch_child=$fetch_child");
        }else
        {
            return '{"errcode":-1,"errmsg":"departmentId is invalid"}';
        }
    }
}