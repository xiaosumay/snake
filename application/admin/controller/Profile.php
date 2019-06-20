<?php


namespace app\admin\controller;


use app\admin\model\UserModel;

class Profile extends Base
{
    protected $middleware = ['Auth'];


    /**
     * @return mixed|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index() {
        //提交修改
        if ($this->request->isAjax()) {
            $param = $this->request->param();
            if (empty($param)) {
                return json(msg(-1, '', 'not found user'));
            }
            if ($param['new_password'] !== $param['re_new_password']) {
                return json(msg(-2, '', '两次输入的密码不相同'));
            }
            $user_model = new UserModel();
            $user_data  = $user_model->getOneUser(session('id'));
            if (is_null($user_data)) {
                return json(msg(-1, '', 'not found user'));
            }
            if ($user_data['password'] !== md5($param['old_password'] . config('salt'))) {
                return json(msg(-3, '', '原始密码错误'));
            }
            if ($user_data['password'] === md5($param['new_password'] . config('salt'))) {
                return json(msg(-4, '', '新密码不能和旧密码相同'));
            }
            $param['password'] = md5($param['new_password'] . config('salt'));
            $flag              = $user_model->updateStatus($param, session('id'));
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        return $this->fetch();
    }
}