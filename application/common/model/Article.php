<?php

namespace app\common\model;

use think\Model;

class Article extends Model
{
    // 关联模型

    public function articleContent()
    {
        return $this->hasOne('ArticleContent', 'a_id', 'id');
    }

    public function user()
    {
        return $this->hasOne('User', 'id', 'u_id');
    }

    public function category()
    {
        return $this->hasOne('Category', 'id', 'c_id');
    }


}
