<?php
// +----------------------------------------------------------------------
// | snake
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2022 http://baiyf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: NickBai <1902822973@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;


use think\Controller;
use app\admin\model\RoleModel;

class Base extends Controller
{

    protected function initialize()
    {
        $this->assign([
            'head' => session('head'),
            'username' => session('username'),
            'rolename' => session('role')
        ]);
    }

    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function removeRoleCache()
    {
        $roleModel = new RoleModel();
        $roleList = $roleModel->getRole();

        foreach ($roleList as $value) {
            cache($value['id'], null);
        }
    }
}
