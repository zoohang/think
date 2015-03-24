<?php

class LoginAction extends Action{
	public function index(){
		$_SESSION['username'] = 'admin';
		$this->display();
	}

	public function doLogin(){
		if(!IS_POST){
			$this->error('页面不存在');			
		}
		if(md5(I('post.code')) <> $_SESSION['verify']){
			$this->error('验证码输入错误 ');
		}
		$pwd = I('password');
		$username = I('username');
		$user = M('user')->where(array('username'=>$username))->find();
		if(!$user || $user['password'] <> md5($pwd)){
			$this->error('用户不存在或者是密码错误');
		}

		$data = array(
			'uid'		=> $user['uid'],
			'logintime' => time(),
			'loginip'	=> get_client_ip(),	//$_SERVER["REMOTE_ADDR"]
			);
		
		M('user')->save($data);

		session('uid', $data['uid']);
		session('username', $username);
		session('loginip', $data['loginip']);
		session('logintime', date('y-m-d h:i:s',$data['logintime']));
		//$this->redirect('New/category', array('cate_id' => 2), 5, '页面跳转中...');
		$this->redirect('Manage/Index/index');
	}

	Public function verify(){
    	import('ORG.Util.Image');
    	Image::buildImageVerify(1);
	}

	public function code(){
		import('ORG.Util.Image2');
		Image::verify(3,50,20);
		p($_SESSION['verify']);
	}

}
?>