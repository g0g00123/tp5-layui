<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\PostModel;

class Post extends Base
{
	public function add(){
		return $this->fetch();
	}

	public function add_action(){
		$data = input('post.');
        $postModel = new PostModel;
		$postModel->data($data);
		if($postModel->save()){
			return json(['success' => true,'msg' => '发表成功！']);
		}
		else{
			return json(['success' => false,'msg' => '发表失败！']);
		}
	}

	public function upload(){
		$file = request()->file('file');
		if($file){
			$info = $file->rule('uniqid')->move(ROOT_PATH.'public'.DS.'uploads');
			$fileName = explode('.',$info->getFilename());
			$data = ['code' => 0,'msg' => '','data' => ['src' => request()->domain().'/uploads/'.$fileName[0].'.'.$info->getExtension()]];
			return json($data);
		}
	}
}