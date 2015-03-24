<?php

function node_merge($node,$access = null,$pid=0){
	$arr = array();

	foreach($node as $v){
		if(is_array($access)){
			if(in_array($v['id'], $access)){
				$v['access'] = 1;
			}
		}
		if($v['pid'] == $pid){
			$v['child'] = node_merge($node,$access,$v['id']);
			$arr[] = $v;
		}
	}
	return $arr;
}
?>