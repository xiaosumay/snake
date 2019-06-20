<?php


namespace app\http\middleware;


use app\admin\model\RoleModel;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\response;

class Auth
{
    /**
     * @param $request
     * @param \Closure $next
     * @return array|mixed|response
     */
    public function handle($request, \Closure $next)
    {
        if (empty(session('username')) || empty(session('id'))) {
            $loginUrl = url('login/index');
            return redirect($loginUrl);
        }

        // 检查缓存
        $this->cacheCheck();

        // 检测权限
        $control = lcfirst(request()->controller());
        $action = lcfirst(request()->action());

        if (empty(authCheck($control . '/' . $action))) {
            abort(403, "您没有权限");
        }

        return $next($request);
    }

    /**
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     */
    private function cacheCheck()
    {
        $action = cache(session('role_id'));

        if (is_null($action) || empty($action)) {
            // 获取该管理员的角色信息
            $roleModel = new RoleModel();
            $info = $roleModel->getRoleInfo(session('role_id'));
            cache(session('role_id'), $info['action']);
        }
    }
}