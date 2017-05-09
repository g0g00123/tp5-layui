<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\AdminModel;
use app\admin\model\RoleModel;
use org\Verify;

class Login extends Controller
{
	public function index()
    {
        return $this->fetch('admin/login');
    }

    //验证码
    public function checkVerify()
    {
        $verify = new Verify();
        $verify->imageH = 38;
        $verify->imageW = 100;
        $verify->length = 4;
        $verify->useNoise = false;
        $verify->fontSize = 14;
        return $verify->entry();
    }

    public function login()
    {
    	$data = input('post.');
    	$adminModel = new AdminModel;
    	$admin = $adminModel->where(['username'=>$data['username'],'status' => 0])->find();
        $verify = new Verify();
        if (!$verify->check($data['code'])) {
            return $this->error('验证码错误');;
        }
    	if($admin){
    		if(md5($data['password']) == $admin['password']){
    			session('username',$admin['username']);
    		    session('avatar',$admin['avatar']);
                session('password',$admin['password']);
    		    session('id',$admin['id']);
                session('time',time());
                session('login_ip',get_client_ip());

                if(!is_null($admin['role_id'])){
                	$role = RoleModel::get($admin['role_id']);
                    session('sign',$role['sign']);
                }else{
                	session('sign','');
                }
    			return $this->success('登录成功！','/admin/welcome');
    		}else{
    			return $this->error('密码错误');
    		}
    	}else{
            return $this->error('用户名不存在');
        }
    }
}