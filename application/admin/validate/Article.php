<?php

namespace app\admin\validate;

use think\Validate;

class Article extends Validate
{
	protected $rule = [
	    'title|标题'  => 'require',
        'c_id|分类'   => 'require|token',
    ];

    public function sceneTitleLength()  //检查标题的长度
    {
        return $this->only(['title'])->append('title', 'max:80');
	}

    public function sceneTitleUnique()  //检查标题的唯一性
    {
        return $this->only(['title'])->append('title', 'unique:article');
	}

}
