<?php
return array(
	//'配置项'=>'配置值'
	'APP_GROUP_MODE' => 1,
	'APP_GROUP_PATH' => 'Application',
	'APP_GROUP_LIST' => 'Home,Manage',
	'DEFAULT_GROUP'	 => 'Home',

	//数据库链接参数
	'DB_HOST'	=> '127.0.0.1',
	'DB_USER'	=> 'root',
	'DB_PWD'	=> 'root',
	'DB_NAME'	=> 'test',
	'DB_PREFIX'	=> 'think_',

	//点语法默认解析
	'TMPL_VAR_IDENTIFY'	=>'array',

	//默认过滤函数
	'DEFAULT_FILTER'	=> 'htmlspecialchars',

	//模板路径
	'TMPL_FILE_DEPR'	=> '_',

	'__PUBLIC__'	=> __ROOT__.'/Public',

	'URL_MODEL'	=> 2,

	//session写入数据库
	'SESSION_TYPE'	=>'Db',

);
?>