<?php
namespace wx;
/**
 * 企业微信通信录处理类
 */
class TxlApi
{
    private $access_token;

    public function __construct()
    {
        $this->access_token = get_access_token();
    }

    /**
    * 获取部门列表
    * 根据部门ID来查询下属的所有子部门
    * @param  [Number] $id 部门ID (默认为1表示根部门)
    */
    public function getDepartmentsById($id=1)
    {
        if($id > 0)
        {
            return http_get("https://qyapi.weixin.qq.com/cgi-bin/department/list?access_token={$this->access_token}&id=$id");
        }
        else
        {
            return '{"errcode":-1,"errmsg":"departmentId is invalid"}';
        }
    }

    /**
    * 根据部门ID来查询部门下成员详情
    * @param  [Number] $id 部门ID (默认为1表示根部门)
    * @param  [boolean] $fetch_child 默认递归获取子部门下面成员
    */
    public function getUserByDepartmentId($id=1,$fetch_child=true)
    {
        if($id > 0)
        {
            return http_get("https://qyapi.weixin.qq.com/cgi-bin/user/list?access_token={$this->access_token}&department_id=$id&fetch_child=$fetch_child");
        }
        else
        {
            return '{"errcode":-1,"errmsg":"departmentId is invalid"}';
        }
    }

    /**
     * 更新成员信息
     * @param [array] $data 成员信息字段组成的数组（userif为必须其他字段为可选）
     * @return [string]    返回json格式字符串，例如:{"errcode": 0,"errmsg": "updated"}
     */
    public function updateUser($data)
    {
        if($data["userid"])
        {
            if( count($data) >= 2 )
            {
                return http_post("https://qyapi.weixin.qq.com/cgi-bin/user/update?access_token={$this->access_token}",$data);
            }
            else
            {
                return '{"errcode":-2,"errmsg":"params is missing"}';
            }
        }
        else
        {
            return '{"errcode":-2,"errmsg":"params is missing"}';
        }
    }

    /**
     * 删除单个成员
     * @param  [string] $userid 用户userid
     * @return [Json]     {"errcode": 0,"errmsg": "deleted"}
     */
    public function deleteUser($userid)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/delete?access_token={$this->access_token}&userid={$userid}";
        $res = http_get($url);
        return $res;
    }

    /**
     * 通过UserId获取用户详细信息
     */
    public function getUserInfoByUserId($userId)
    {
        $res = http_get("https://qyapi.weixin.qq.com/cgi-bin/user/get?access_token={$this->access_token}&userid={$userId}");
        return $res;
    }
}