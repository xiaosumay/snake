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

use app\admin\model\NodeModel;

class Node extends Base
{
    protected $middleware = ['Auth'];

    // 节点列表

    /**
     * @return mixed|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        if (request()->isAjax()) {

            $node = new NodeModel();
            $nodes = $node->getNodeList();

            $nodes = getTree(objToArray($nodes), false);
            return json(msg(1, $nodes, 'ok'));
        }

        return $this->fetch();
    }

    // 添加节点

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function nodeAdd()
    {
        $param = input('post.');

        $node = new NodeModel();
        $flag = $node->insertNode($param);
        $this->removeRoleCache();
        return json(msg($flag['code'], $flag['data'], $flag['msg']));
    }

    // 编辑节点

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function nodeEdit()
    {
        $param = input('post.');

        $node = new NodeModel();
        $flag = $node->editNode($param);
        $this->removeRoleCache();
        return json(msg($flag['code'], $flag['data'], $flag['msg']));
    }

    /**
     * 删除节点
     * @return \think\response\Json
     * @throws \Exception
     */
    public function nodeDel()
    {
        $id = input('param.id');

        $role = new NodeModel();
        $flag = $role->delNode($id);
        $this->removeRoleCache();
        return json(msg($flag['code'], $flag['data'], $flag['msg']));
    }
}
