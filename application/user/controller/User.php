<?php
namespace app\user\controller;
use app\user\controller\Base;
use app\user\model\UserModel;
use think\Validate;
use think\Image;
use think\Requset;

class User extends Base
{
	private $data = array(
		'upload_path' => UPLOAD_PATH,
		);

	public function index(){
		return $this->fetch();
	}
	

	public function login(){
		$data = input('post.');
    	$userModel = new UserModel;
    	$user = $userModel->where(['username'=>$data['username'],'status' => 0])->find();
    	
    	if($user){
    		if(md5($data['password']) == $user['password']){
    			return json(['success'=>true,'userData'=>$user,'msg'=>'登陆成功']);
    		}else{
    			return json(['success'=>false,'msg'=>'密码错误']);
    		}
    	}else{
            return json(['success'=>false,'msg'=>'用户名不存在']);
        }
	}

	public function add()
	{
		$user = new UserModel;
		$data = input('post.');
		$userModel = UserModel::where(['username' => $data['username'],'status' => 0])->find();
        if($userModel){
            return json(['success' => false,'msg' => '该用户名已存在！']);
        }
        $UserModel2 = UserModel::where(['nickname' => $data['nickname'],'status' => 0 ])->find();
        if($UserModel2){
        	return json(['success' => false,'msg' => '该昵称已存在！']);
        }
		$data['avatar'] = $this->upload();
		$data['password'] = md5($data['password']);
        $data['province'] = getLocation()['province'];
        $data['city'] = getLocation()['city'];
		$user->data($data);
		if($user->save()){
			return json(['success' => 'true','msg' => '注册成功！']);
		}
		else{
			return json(['success' => 'fasle','msg' => '注册失败！']);
		}
	}

	public function del($id)
	{
		//$id = input('param.id');
		$result = UserModel::where('id',$id)-> update(['status' => 1]);
		if($result){
			return json(['success' => 'true','msg' => '注销成功！']);
		}
		else{
			return json(['success' => 'fasle','msg' => '注销失败！']);
		}
	}

	public function get($id)
	{
		//$id = input('param.id');
		$data = UserModel::where(['id'=>$id,'status' => 0])-> find();
		return json($data);
	}

	public function edit(){
		$userModel = new UserModel;
		$data = input('post.');
		$user = $userModel->where('id',$data['id'])->find();
        if(isset($data['avatar'])  && (!empty($user['avatar'])) && ($data['avatar'] != $user['avatar'])){

          unlink($this->data['upload_path'].'/'.$user['avatar']);

        }
         $result = $userModel->save($data,['id' => $data['id']]);

         if($result){
             return json(['success' => 'true','msg' => '修改成功！']);
         }
         else{
             return json(['success' => 'fasle','msg' => '修改失败！']);
         }
	}

	public function updatePass()
	{
		$data = input('post.');
        $user = UserModel::get($data['id']);
        if(md5($data['oldpass']) == $user['password']){
            $user['password'] = md5($data['newpass']);
            if($user->save()){
               return json(['success' => true,'msg' => '密码修改成功！']);
            }
            else{
                return json(['success' => false,'msg' => '密码修改失败！']);
            }
        }else{
            return json(['success' => false,'msg' => '密码错误！']);
        }
	}


	/**
	 * 图片上传
	 * @return [type] [description]
	 */
	public function upload(){
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