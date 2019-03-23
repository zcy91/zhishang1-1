<?php
/* 数据库配置 */
return array(

    // 默认连接数据库
    'DB_TYPE' => 'mysql', //数据库类型
    'DB_HOST' => 'localhost', //数据库主机
    'DB_NAME' => '1+1', //数据库名称
    'DB_USER' => 'root', //数据库用户名
    'DB_PWD' => 'root', //数据库密码
    'DB_PORT' => '3306', //数据库端口
    'DB_PREFIX' => 'ty_', //数据库前缀
	'DB_CHARSET'=> 'utf8', // 字符集
	'DB_DEBUG'  => '', // 数据库调试模式 开启后可以记录SQL日志
   
    //第二个数据库连接
    'DB_NEW' => array(
        'DB_TYPE' => 'mysql', // 数据库类型
        'DB_HOST' => '127.0.0.1', // 服务器地址
        'DB_NAME' => 'rt', // 数据库名
        'DB_USER' => 'root', // 用户名
        'DB_PWD' => 'admin888', // 密码
        'DB_PORT' => '3306', // 端口
        'DB_PREFIX' => 'dream_', // 数据库表前缀
    ),
);
?>