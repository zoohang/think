<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends CommonAction 
{

	/*public function _initialize()
	{
		echo "这是自动运行的方法";
	}*/

    public function index()
    {
    	//p(M('User')->select());die;
    	$this->display('index');
    }

    public function logout()
    {
    	session_unset();
    	session_destroy();
    	$this->redirect('Manage/Login/index');
    }
}