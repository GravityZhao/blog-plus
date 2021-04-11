<?php

namespace app\common\model;

use think\Model;

class Category extends Model
{
    public function article()
    {
        return $this->hasMany('Article', 'c_id', 'id');
    }
}
