<?php
/**
 * Created by sublime.
 * User: xdm
 * Date: 2018/12/12
 * Time: 14:00
 */
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Device;
// use think\Request;
// $request = Request::instance();
header("Access-Control-Allow-Origin: *");
class Socket extends Controller
{
    
    public function index()
    {
        // echo __DIR__ . '/../../application/admin/model/Device.php';

        $post = input('post.');
        if(isset($post['device_id'])&&isset($post['client_id'])){
           $res = Device::create(['device_id'=>$post['device_id'],'client_id'=>$post['client_id'],'is_online'=>1]);
            if($res){
                $msg = array('action' => 'setup_result' ,'result'=>'success', ); 
                return json_encode($msg);
            }else{
                $msg = array('action' => 'setup_result' ,'result'=>'error', ); 
                return json_encode($msg);
            } 
        }
        
    }
}
