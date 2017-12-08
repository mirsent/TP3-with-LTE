<?php
return array(

    'TITLE'             => '后台管理系统',

    /*认证相关*/
    'USER_AUTH_KEY'     => 'reimbursement', // 用户认证SESSION标记
    'USER_AUTH_GATEWAY' => 'User/login', // 默认认证网关
    'USER_AUTH_ALLOW'   => [
        'Admin/Index/index'
    ], // 允许访问列表

    /*状态*/
    'STATUS_N'          => 0, // 删除状态
    'STATUS_Y'          => 1, // 正常状态
    'STATUS_B'          => 2, // 禁用状态
);
