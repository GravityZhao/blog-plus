<?php

namespace app\admin\validate;

use think\Validate;

class User extends Validate
{
	protected $rule = [
	    'username|用户名'  => 'require|min:5',
        'password|密码'    => 'require|min:5',
    ];

    public function sceneLogin()
    {
        return $this->only(['username', 'password']);
	}
}
