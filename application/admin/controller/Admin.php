<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use think\Image;
use app\admin\model\AdminModel;
use app\admin\model\RoleModel;

class Admin extends Base
{
	private $data = array(
		'upload_path' => UPLOAD_PATH,
	);


    public function welcome(){
        return $this->fetch();
    }

    


    public function loginout(){
        $admin = AdminModel::get(session('id'));
        $admin['last_login_time'] = date('Y-m-d H:i:s', session('time'));
        $admin['login_ip'] = session('login_ip');
        $admin->save();
        session(null);
        return $this->success('已成功登出', '/admin');
    }

    public function update_password($id){
        $this->assign('id',$id);
        return $this->fetch();
    }

    public function update_pass_action(){
        $data = input('post.');
        $admin = AdminModel::get($data['id']);
        if(md5($data['oldpass']) == $admin['password']){
            $admin['password'] = md5($data['newpass1']);
            if($admin->save()){
                session('password',$admin['password']);
               return json(['success' => true,'msg' => '密码修改成功！']);
            }
            else{
                return json(['success' => false,'msg' => '密码修改失败！']);
            }
        }else{
            return json(['success' => false,'msg' => '密码错误！']);
        }
    }

    public function add_action(){
    	$data = input('post.');
        $admin = AdminModel::where(['username' => $data['username'],'status' => 0])->find();
        if($admin){
            return json(['success' => false,'msg' => '改用户名已存在！']);
        }
        $adminModel = new AdminModel;
		$data['password'] = md5($data['password']);
        $role = RoleModel::where('status','0')->find();
        $data['role_id'] = $role['id'];
		$adminModel->data($data);
		if($adminModel->save()){
			return json(['success' => true,'msg' => '添加成功！']);
		}
		else{
			return json(['success' => false,'msg' => '添加失败！']);
		}
    }

    public function get_list(){
    	$list = AdminModel::where('status', 0)
			    ->order('create_time', 'desc')
			    ->paginate(10);
		$this->assign('list',$list);
		return $this->fetch('list');
    }


    public function del_all(){
    	$data = input('param.ids');
        $arr = explode(',',$data);
        foreach ($arr as $key => $value) {
            if($value == session('id')){
                return json(['success' => false,'msg' => '包含登陆账号,不能删除']);
            }
        }
        $adminModel = new AdminModel;
    	$result = $adminModel->where('id','in',$arr)->update(['status' => 1]);
    	if($result){
    		return json(['success' => true,'msg' => '删除成功']);
    	}else{
    		return json(['success' => false,'msg' => '删除失败']);
    	}
    }

    public function del(){
        $id = input('param.id');
        if($id == session('id')){
            return json(['success' => false,'msg' => '该账号正在登陆,不能删除']);
        }
    	$adminModel = new AdminModel;
    	$result = $adminModel->where('id',$id)->update(['status' => 1]);
    	if($result){
    		return json(['success' => true,'msg' => '删除成功']);
    	}else{
    		return json(['success' => false,'msg' => '删除失败']);
    	}
    }

    public function edit_action(){
    	$adminModel = new AdminModel;
    	$data = input('post.');
        $admin1 = $adminModel->where('id',$data['id'])->find();
        if($data['avatar'] != $admin1['avatar']){
            unlink($this->data['upload_path'].'/'.$admin1['avatar']);
        }
    	$result = $adminModel->save($data,['id' => $data['id']]);
    	if($result){
            if(session('username') == $admin1['username']){
                $admin = $adminModel->where('id',$data['id'])->find();
                session('username',$admin['username']);
                session('avatar',$admin['avatar']);
            }
    		return json(['success' => true,'msg' => '编辑成功']);
    	}else{
    		return json(['success' => false,'msg' => '编辑失败']);
    	}
    	
    }

    public function edit($id){
    	$adminModel = new AdminModel;
    	$admin = $adminModel->where('id',$id)->find();
    	$this->assign('admin',$admin);
    	return $this->fetch();
    }

    public function add(){
    	 return $this->fetch();
    }

    public function upload(){
    	$filename = $this->uploadFile();
    	return json(['fileName' => $filename]);
    }
    

    /**
	 * 图片上传
	 * @return [type] [description]
	 */
	public function uploadFile(){
		$file = request()->file('avatar');
		if($file){
			$info = $file->rule('uniqid')->move(ROOT_PATH.'public'.DS.'uploads');
			$image = Image::open($file);
			$image_type = request()->param('type') ?　request()->param('type') : 1;
			switch ($image_type) {
				case 1: //缩略图
					$image->thumb(150,150,Image::THUMB_CENTER);
					break;
				case 2://图片裁剪
					$image->crop(300,300);
					break;
				case 3://垂直翻转
					$image->flip();
					break;
				case 4://水平翻转
					$image->flip(Image::FILP_Y);
					break;
				case 5://图片水印
					$image->water(ROOT_PATH.'public/static/images/logo.png',Image::WATER_NORTHWEST,50);
					break;
				case 6://图片旋转
					$image->rotate();
					break;
				case 7://文字水印
					$image->text('ThinkPHP', VENDOR_PATH . 'topthink/think-captcha/assets/ttfs/1.ttf', 20, '#ffffff');
	                    break;
			}
			$this->sourceFile = $info->getFilename();
			$fileName = explode('.',$info->getFilename());
			$saveName = $fileName[0].'_thumb.'.$file->getExtension();
			$image->save($this->data['upload_path'].'/'.$saveName);
			$this->imageThumbName = $saveName;
			return $this->imageThumbName;
		}

	}
}
