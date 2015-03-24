<?php
/**
 * RBAC控制器
 */
class RbacAction extends Action{
	
	//用户类表
	public function index(){
		$result = D('UserRelation')->relation('role')->select();
		p($result);
		die;
		$this->display();
	}

	//角色列表
	public function role(){
		$this->role = M('role')->select();
		
		$this->display();
	}

	//节点列表
	public function node(){
		$field = array('id','name','title','pid');
		$node = M('node')->field($field)->order('sort')->select();
		$this->node = node_merge($node);
		$this->display();
	}

	//添加用户
	public function addUser(){
		$this->access = M('role')->select();
		$this->display();
	}

	public function addUserHandle(){
		if(I('password2') != I('password')){
			$this->error('两次输入的密码不一致');
		}
		$data['username'] = I('username');
		$data['password'] = I('password','','md5');
		$data['loginip'] = get_client_ip();
		$data['logintime'] = time();
		if($uid = M('user')->add($data)){
			foreach($_POST['access'] as $v){
				$access[] = array(
					'role_id' => $v,
					'user_id' => $uid
					);
			}
			M('role_user')->addAll($access);
			$this->success('添加成功',U('Manage/Rbac/index'));
		}else{
			$this->error('添加失敗');
		}
	}

	//添加角色
	public function addRole(){
		$this->display();
	}

	public function addRoleHandle(){
		if(M('role')->add($_POST)){
			$this->success('添加成功',U('Manage/Rbac/role'));
		}else{
			$this->error('添加失败');
		}
	}

	//添加节点
	public function addNode(){
		$this->pid = isset($_GET['pid']) ? $_GET['pid'] : 0;
		//tp写法 $this->pid = I('pid',0,'intval');
		$this->level = isset($_GET['level']) ? $_GET['level'] : 1;

		switch ($this->level) {
			case 1:
				$this->type = '应用';
				break;
			
			case 2:
				$this->type = '控制器';
				break;

			case 3:
				$this->type = '动作方法';
				break;
		}
		$this->display();
	}

	public function addNodeHandle(){
		if(M('node')->add($_POST)){
			$this->success('添加成功',U('Manage/Rbac/node'));
		}else{
			$this->error('添加失败');
		}
	}

	public function access(){
		$rid = I('rid');
		$this->rid = I('rid');
		$field = array('id','name','title','pid');
		$node = M('node')->order('sort')->field($field)->select();
		$access = M('access')->where(array('role_id'=>$rid))->getField('node_id',true);
		/*p($node);
		p($access);
		die;*/
		$this->node = node_merge($node,$access);
		//p($this->node);die;
		$this->display();
	}

	public function setAccess(){
		$access = I('access');
		$rid = I('rid');
		M('access')->where(array('role_id'=>$rid))->delete();
		$data = array();
		foreach($access as $value){
			$tmp = explode('_', $value);
			$data[] = array(
				'role_id' => $rid,
				'node_id' => $tmp[0],
				'level' => $tmp[1]
				);
		}
		if(M('access')->addAll($data)){
			$this->success('修改成功',U('Manage/Rbac/role'));
		}else{
			$this->error('修改失败');
		}
	}
}